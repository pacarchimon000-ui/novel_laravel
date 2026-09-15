<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WriterController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $novels = Novel::where('user_id', $user->id)
            ->withCount(['chapters', 'likes', 'bookmarks'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'novels' => Novel::where('user_id', $user->id)->count(),
            'chapters' => Chapter::whereHas('novel', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'views' => Novel::where('user_id', $user->id)->sum('views'),
        ];

        return view('writer.dashboard', compact('novels', 'stats'));
    }

    public function novelsIndex()
    {
        $novels = Novel::where('user_id', auth()->id())
            ->withCount(['chapters', 'likes', 'bookmarks'])
            ->latest()
            ->paginate(10);

        return view('writer.novels.index', compact('novels'));
    }

    public function novelsCreate()
    {
        $genres = ['Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Slice of Life', 'Thriller'];

        return view('writer.novels.create', compact('genres'));
    }

    public function novelsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string',
            'genre' => 'required|string',
            'status' => 'required|in:ongoing,completed',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'synopsis' => $validated['synopsis'],
            'genre' => $validated['genre'],
            'status' => $validated['status'],
            'cover' => $coverPath,
        ]);

        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil dibuat!');
    }

    public function novelsEdit(Novel $novel)
    {
        abort_unless($novel->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $genres = ['Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Slice of Life', 'Thriller'];

        return view('writer.novels.edit', compact('novel', 'genres'));
    }

    public function novelsUpdate(Request $request, Novel $novel)
    {
        abort_unless($novel->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string',
            'genre' => 'required|string',
            'status' => 'required|in:ongoing,completed',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $novel->update($validated);

        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil diperbarui!');
    }

    public function novelsDestroy(Novel $novel)
    {
        abort_unless($novel->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $novel->delete();

        return redirect()->route('writer.novels.index')->with('success', 'Novel berhasil dihapus!');
    }

    public function chaptersCreate(Novel $novel)
    {
        abort_unless($novel->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $nextNumber = ($novel->chapters()->max('chapter_number') ?? 0) + 1;

        return view('writer.chapters.create', compact('novel', 'nextNumber'));
    }

    public function chaptersStore(Request $request, Novel $novel)
    {
        abort_unless($novel->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'chapter_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('chapters')->where(fn ($query) => $query->where('novel_id', $novel->id)),
            ],
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'boolean',
            'coin_price' => 'required_if:is_premium,1|integer|min:1',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['coin_price'] = $validated['is_premium'] ? $validated['coin_price'] : 0;

        $chapter = $novel->chapters()->create($validated);

        return redirect()->route('writer.novels.index')->with('success', 'Chapter berhasil ditambahkan!');
    }

    public function chaptersEdit(Novel $novel, Chapter $chapter)
    {
        abort_unless(($novel->user_id === auth()->id() || auth()->user()->isAdmin()) && $chapter->novel_id === $novel->id, 403);

        return view('writer.chapters.edit', compact('novel', 'chapter'));
    }

    public function chaptersUpdate(Request $request, Novel $novel, Chapter $chapter)
    {
        abort_unless(($novel->user_id === auth()->id() || auth()->user()->isAdmin()) && $chapter->novel_id === $novel->id, 403);

        $validated = $request->validate([
            'chapter_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('chapters')->ignore($chapter->id)->where(fn ($query) => $query->where('novel_id', $novel->id)),
            ],
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'boolean',
            'coin_price' => 'required_if:is_premium,1|integer|min:1',
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['coin_price'] = $validated['is_premium'] ? $validated['coin_price'] : 0;

        $chapter->update($validated);

        return redirect()->route('writer.novels.index')->with('success', 'Chapter berhasil diperbarui!');
    }

    public function chaptersDestroy(Novel $novel, Chapter $chapter)
    {
        abort_unless(($novel->user_id === auth()->id() || auth()->user()->isAdmin()) && $chapter->novel_id === $novel->id, 403);

        $chapter->delete();

        return redirect()->route('writer.novels.index')->with('success', 'Chapter berhasil dihapus!');
    }
}
