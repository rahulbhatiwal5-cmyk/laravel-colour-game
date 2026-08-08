<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}