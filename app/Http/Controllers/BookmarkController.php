<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Novel $novel)
    {
        $user = auth()->user();
        $bookmark = Bookmark::where('user_id', $user->id)->where('novel_id', $novel->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $status = false;
        } else {
            Bookmark::create(['user_id' => $user->id, 'novel_id' => $novel->id]);
            $status = true;
        }

        return back()->with('bookmark_status', $status);
    }

    public function index()
    {
        $bookmarks = auth()->user()->bookmarks()->with(['novel.user'])->withCount('novel')->latest()->paginate(12);
        return view('user.bookmarks', compact('bookmarks'));
    }
}
