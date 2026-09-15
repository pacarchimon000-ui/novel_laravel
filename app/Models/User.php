<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'writer_status',
        'bio',
        'avatar',
        'coins',
        'reading_points',
        'reading_level',
        'writer_application_email',
        'writer_application_motivation',
        'writer_application_experience',
        'writer_application_genre',
        'writer_rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'coins'             => 'integer',
            'reading_points'    => 'integer',
            'reading_level'     => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWriter(): bool
    {
        return $this->role === 'writer';
    }

    public function novels()
    {
        return $this->hasMany(Novel::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function chapterUnlocks()
    {
        return $this->hasMany(ChapterUnlock::class);
    }

    public function coinTransactions()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    public function readingRewards()
    {
        return $this->hasMany(ReadingReward::class);
    }
}
