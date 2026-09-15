<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        auth()->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if (isset($notification->data['novel_slug']) && isset($notification->data['chapter_id'])) {
            return redirect()->route('chapters.show', [
                'novel'   => $notification->data['novel_slug'],
                'chapter' => $notification->data['chapter_id'],
            ]);
        }

        return back();
    }
}
