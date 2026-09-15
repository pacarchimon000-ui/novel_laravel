<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Chapter $chapter)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id'    => auth()->id(),
            'chapter_id' => $chapter->id,
            'content'    => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
