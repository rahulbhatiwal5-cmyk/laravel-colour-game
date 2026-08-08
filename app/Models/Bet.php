<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = [
    'user_id',
    'game_round_id',
    'bet_type',
    'bet_value',
    'amount',
    'winning_amount',
    'status'
];

public function user() {
    return $this->belongsTo(User::class);
}

public function gameRound() {
    return $this->belongsTo(GameRound::class);
}


}
