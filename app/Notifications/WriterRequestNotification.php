<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WriterRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'writer_request',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'message' => 'Pengajuan menjadi penulis baru dari ' . $this->user->name,
        ];
    }
}
