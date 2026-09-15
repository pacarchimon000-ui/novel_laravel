<?php

namespace App\Notifications;

use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewChapterNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Novel $novel,
        public Chapter $chapter
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'novel_id'       => $this->novel->id,
            'novel_title'    => $this->novel->title,
            'novel_slug'     => $this->novel->slug,
            'chapter_id'     => $this->chapter->id,
            'chapter_number' => $this->chapter->chapter_number,
            'chapter_title'  => $this->chapter->title,
            'message'        => "Chapter {$this->chapter->chapter_number} dari \"{$this->novel->title}\" sudah tersedia!",
        ];
    }
}
