<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'bonus_percentage',
        'min_deposit',
        'max_uses',
        'used_count',
        'expires_at',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'bonus_percentage' => 'decimal:2',
            'min_deposit' => 'decimal:2',
            'expires_at' => 'datetime',
            'active' => 'boolean',
        ];
    }
}