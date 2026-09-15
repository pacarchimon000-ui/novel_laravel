<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WriterStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user, public string $status, public ?string $reason = null)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = $this->status === 'approved'
            ? 'Pengajuan Anda sebagai penulis telah disetujui.'
            : 'Pengajuan Anda sebagai penulis ditolak.';

        return [
            'type' => 'writer_status',
            'user_id' => $this->user->id,
            'status' => $this->status,
            'reason' => $this->reason,
            'message' => $message,
        ];
    }
}
