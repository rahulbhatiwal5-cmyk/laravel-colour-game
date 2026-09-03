<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'user_id',
    'type',
    'amount',
    'status',
    'upi_id',
    'utr_number',
    'description',
    'coupon_id',
    'coupon_code',
    'coupon_percentage',
    'bonus_amount',
];

protected function casts(): array
{
    return [
        'coupon_percentage' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
    ];
}

public function user() {
    return $this->belongsTo(User::class);
}


}
