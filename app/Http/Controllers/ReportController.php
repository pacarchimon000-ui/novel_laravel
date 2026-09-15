<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        if (Report::where('user_id', auth()->id())
            ->where('comment_id', $comment->id)
            ->where('status', 'pending')
            ->exists()) {
            return back()->with('error', 'Komentar ini sudah kamu laporkan dan sedang ditinjau.');
        }

        Report::create([
            'user_id'    => auth()->id(),
            'comment_id' => $comment->id,
            'reason'     => $validated['reason'],
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim dan akan segera ditinjau oleh Admin.');
    }
}
