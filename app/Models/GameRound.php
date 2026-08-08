<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRound extends Model
{
    protected $fillable = [
    'result_number',
    'result_color',
    'result_size',
    'status',
    'is_manual',
    'manual_number',
    'started_at',
    'ends_at'
];

protected $casts = [
    'started_at' => 'datetime',
    'ends_at'    => 'datetime',
    'is_manual'  => 'boolean',
];

public function bets() {
    return $this->hasMany(Bet::class);
}

// Timer seconds remaining
public function getSecondsRemainingAttribute()
{
    if (!$this->ends_at) return 0;
    $remaining = now()->diffInSeconds($this->ends_at, false);
    return max(0, (int) $remaining); // ← (int) cast karo
}

// Betting band karo last 10 sec mein
public function getIsBettingLockedAttribute() {
    return $this->seconds_remaining <= 10;
}

}
