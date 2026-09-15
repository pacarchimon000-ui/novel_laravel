<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingReward extends Model
{
    protected $fillable = [
        'user_id',
        'chapter_id',
        'points',
        'coins',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'coins' => 'integer',
        ];
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}