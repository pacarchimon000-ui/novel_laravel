<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestNovels = Novel::with('user')
            ->withCount(['chapters', 'likes', 'bookmarks'])
            ->latest()
            ->take(8)
            ->get();

        $popularNovels = Novel::with('user')
            ->withCount(['chapters', 'likes', 'bookmarks'])
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();

        $genres = Novel::distinct()->pluck('genre')->sort()->values();

        $recentHistories = collect();
        if (auth()->check()) {
            $recentHistories = ReadingHistory::with(['novel', 'chapter'])
                ->where('user_id', auth()->id())
                ->latest('updated_at')
                ->take(4)
                ->get();
        }

        return view('home', compact('latestNovels', 'popularNovels', 'genres', 'recentHistories'));
    }
}
