<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Novel;
use App\Models\Report;
use App\Models\User;
use App\Notifications\NewChapterNotification;
use App\Notifications\WriterStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'novels'   => Novel::count(),
            'chapters' => Chapter::count(),
            'users'    => User::count(),
            'comments' => Comment::count(),
            'pending_writers' => User::where('writer_status', 'pending')->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        $latestNovels = Novel::with('user')->withCount('chapters')->latest()->take(5)->get();
        $latestUsers  = User::latest()->take(5)->get();
        $pendingWriters = User::where('writer_status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNovels', 'latestUsers', 'pendingWriters'));
    }

    // --- NOVELS ---
    public function novelsIndex()
    {
        $novels = Novel::with('user')->withCount(['chapters', 'likes', 'bookmarks'])->latest()->paginate(15);
        return view('admin.novels.index', compact('novels'));
    }

    public function novelsShow(Novel $novel)
    {
        $novel->load(['user', 'chapters']);
        $novel->loadCount(['chapters', 'likes', 'bookmarks']);

        return view('admin.novels.show', compact('novel'));
    }

    public function novelsCreate()
    {
        $genres = ['Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Slice of Life', 'Thriller'];
        return view('admin.novels.create', compact('genres'));
    }

    public function novelsStore(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'synopsis' => 'required|string',
            'genre'    => 'required|string',
            'status'   => 'required|in:ongoing,completed',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Novel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Novel::create([
            'user_id'  => auth()->id(),
            'title'    => $validated['title'],
            'slug'     => $slug,
            'synopsis' => $validated['synopsis'],
            'genre'    => $validated['genre'],
            'status'   => $validated['status'],
            'cover'    => $coverPath,
        ]);

        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil ditambahkan!');
    }

    public function novelsEdit(Novel $novel)
    {
        $genres = ['Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Slice of Life', 'Thriller'];
        return view('admin.novels.edit', compact('novel', 'genres'));
    }

    public function novelsUpdate(Request $request, Novel $novel)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'synopsis' => 'required|string',
            'genre'    => 'required|string',
            'status'   => 'required|in:ongoing,completed',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $novel->update($validated);

        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil diupdate!');
    }

    public function novelsDestroy(Novel $novel)
    {
        $novel->delete();
        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil dihapus!');
    }

    // --- CHAPTERS ---
    public function chaptersCreate(Novel $novel)
    {
        $nextNumber = ($novel->chapters()->max('chapter_number') ?? 0) + 1;
        return view('admin.chapters.create', compact('novel', 'nextNumber'));
    }

    public function chaptersStore(Request $request, Novel $novel)
    {
        $validated = $request->validate([
            'chapter_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('chapters')->where(fn ($query) => $query->where('novel_id', $novel->id)),
            ],
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'boolean',
            'coin_price' => 'required_if:is_premium,1|integer|min:1',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['coin_price'] = $validated['is_premium'] ? $validated['coin_price'] : 0;

        $chapter = $novel->chapters()->create($validated);

        // Notify users who bookmarked this novel
        $bookmarkedUsers = User::whereHas('bookmarks', function ($query) use ($novel) {
            $query->where('novel_id', $novel->id);
        })->get();

        foreach ($bookmarkedUsers as $bookmarkedUser) {
            $bookmarkedUser->notify(new NewChapterNotification($novel, $chapter));
        }

        return redirect()->route('admin.novels.show', $novel)->with('success', 'Chapter berhasil ditambahkan dan notifikasi dikirim ke pembaca!');
    }

    public function chaptersEdit(Novel $novel, Chapter $chapter)
    {
        abort_unless($chapter->novel_id === $novel->id, 404);

        return view('admin.chapters.edit', compact('novel', 'chapter'));
    }

    public function chaptersUpdate(Request $request, Novel $novel, Chapter $chapter)
    {
        abort_unless($chapter->novel_id === $novel->id, 404);

        $validated = $request->validate([
            'chapter_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('chapters')->ignore($chapter->id)->where(fn ($query) => $query->where('novel_id', $novel->id)),
            ],
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'boolean',
            'coin_price' => 'required_if:is_premium,1|integer|min:1',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['coin_price'] = $validated['is_premium'] ? $validated['coin_price'] : 0;

        $chapter->update($validated);

        return redirect()->route('admin.novels.index')->with('success', 'Chapter berhasil diupdate!');
    }

    public function chaptersDestroy(Novel $novel, Chapter $chapter)
    {
        abort_unless($chapter->novel_id === $novel->id, 404);

        $chapter->delete();
        return redirect()->route('admin.novels.show', $novel)->with('success', 'Chapter berhasil dihapus!');
    }

    // --- USERS ---
    public function usersIndex(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim();
                $query->where(function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->string('role')))
            ->when($request->filled('writer_status'), fn ($query) => $query->where('writer_status', $request->string('writer_status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function writerRequestsIndex()
    {
        $users = User::where('writer_status', 'pending')->latest()->paginate(20);
        return view('admin.users.pending', compact('users'));
    }

    public function usersToggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri!');
        }
        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);
        return back()->with('success', 'Role user berhasil diubah!');
    }

    public function approveWriter(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menyetujui diri sendiri!');
        }

        $user->update([
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);

        $user->notify(new WriterStatusNotification($user, 'approved'));

        return back()->with('success', 'Pengajuan penulis disetujui!');
    }

    public function rejectWriter(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menolak diri sendiri!');
        }

        request()->validate([
            'writer_rejection_reason' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $user->update([
            'role' => 'user',
            'writer_status' => 'rejected',
            'writer_rejection_reason' => request('writer_rejection_reason'),
        ]);

        $user->notify(new WriterStatusNotification($user, 'rejected', request('writer_rejection_reason')));

        return back()->with('success', 'Pengajuan penulis ditolak!');
    }

    public function usersDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    // --- REPORTS MANAGEMENT ---
    public function reportsIndex(Request $request)
    {
        $reports = Report::with(['user', 'comment.user', 'comment.chapter.novel'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function reportsResolve(Report $report)
    {
        // Delete offending comment
        if ($report->comment) {
            $report->comment->delete();
        }

        $report->update(['status' => 'resolved']);

        return back()->with('success', 'Laporan disetujui & komentar bermasalah berhasil dihapus!');
    }

    public function reportsDismiss(Report $report)
    {
        $report->update(['status' => 'dismissed']);

        return back()->with('success', 'Laporan ditolak / diabaikan.');
    }
}
