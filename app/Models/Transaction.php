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
    'description'
];

public function user() {
    return $this->belongsTo(User::class);
}


}
