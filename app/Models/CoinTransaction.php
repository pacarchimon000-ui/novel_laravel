<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'order_id',
        'snap_token',
        'package_code',
        'coins',
        'amount',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'coins' => 'integer',
            'amount' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}