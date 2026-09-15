<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Novel::where('approval_status', 'approved')
            ->with('user')
            ->withCount(['chapters', 'likes', 'bookmarks']);

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim();
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('synopsis', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', "%{$search}%"));
            });
        }

        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'popular' => $query->orderBy('views', 'desc'),
            'likes'   => $query->orderBy('likes_count', 'desc'),
            default   => $query->latest(),
        };

        $novels = $query->paginate(12)->withQueryString();
        $genres = Novel::distinct()->pluck('genre')->sort()->values();

        return view('novels.index', compact('novels', 'genres'));
    }

    public function show(Novel $novel)
    {
        abort_unless($novel->approval_status === 'approved', 404);

        $novel->increment('views');
        $novel->load(['user', 'chapters', 'likes', 'bookmarks']);
        $novel->loadCount(['chapters', 'likes', 'bookmarks']);

        $isBookmarked = $novel->isBookmarkedBy(auth()->user());
        $isLiked      = $novel->isLikedBy(auth()->user());

        return view('novels.show', compact('novel', 'isBookmarked', 'isLiked'));
    }
}
