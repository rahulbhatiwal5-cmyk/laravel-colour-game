<?php

namespace App\Services;

use App\Models\Bet;
use App\Models\GameRound;
use App\Models\Transaction;

class GameRoundService
{
    // ── Color Mapping ──
    private array $colorMap = [ 
        0 => 'violet',
        1 => 'green',
        2 => 'red',
        3 => 'green',
        4 => 'red',
        5 => 'violet',
        6 => 'red',
        7 => 'green',
        8 => 'red',
        9 => 'green',
    ];

    // ── Size Mapping ──
    private array $sizeMap = [
        0 => 'small', 1 => 'small', 2 => 'small',
        3 => 'small', 4 => 'small', 5 => 'big',
        6 => 'big',   7 => 'big',   8 => 'big',
        9 => 'big',
    ];

    // ── Naya Round Create karo ──
    public function createNewRound(): GameRound
    {
        return GameRound::create([
            'status'     => 'open',
            'started_at' => now(),
            'ends_at'    => now()->addSeconds(60),
        ]);
    }

    // ── Result Number Calculate karo ──
    public function calculateResult(GameRound $round): int
    {
        // Priority 1 — Manual result set hai admin ne
        if ($round->is_manual && !is_null($round->manual_number)) {
            return $round->manual_number;
        }

        // Priority 2 — Users count check karo
        $bets = $round->bets;
        $userCount = $bets->pluck('user_id')->unique()->count();

        // 2 se kam users — random number
        if ($userCount < 2) {
            return rand(0, 9);
        }

        // 2+ users — minimum payout wala number nikalo
        return $this->getMinPayoutNumber($bets);
    }

    // ── Minimum Payout Number ──
    private function getMinPayoutNumber($bets): int
    {
        $payouts = [];

        for ($num = 0; $num <= 9; $num++) {
            $color = $this->colorMap[$num];
            $size  = $this->sizeMap[$num];
            $total = 0;

            foreach ($bets as $bet) {
                $won = match($bet->bet_type) {
                    'number' => $bet->bet_value == $num,
                    'color'  => $bet->bet_value === $color,
                    'size'   => $bet->bet_value === $size,
                    default  => false,
                };

                if ($won) {
                    $multiplier = match($bet->bet_type) {
                        'number' => 10,
                        'color'  => 3,
                        'size'   => 2,
                        default  => 0,
                    };
                    $total += $bet->amount * $multiplier;
                }
            }

            $payouts[$num] = $total;
        }

        // Sabse kam payout wala number return karo
        return array_keys($payouts, min($payouts))[0];
    }

    // ── Round Close + Payout Process ──
    public function processRound(GameRound $round): void
    {
        $resultNumber = $this->calculateResult($round);
        $resultColor  = $this->colorMap[$resultNumber];
        $resultSize   = $this->sizeMap[$resultNumber];

        // Round update karo
        $round->update([
            'result_number' => $resultNumber,
            'result_color'  => $resultColor,
            'result_size'   => $resultSize,
            'status'        => 'closed',
        ]);

        // Sab bets process karo
        foreach ($round->bets as $bet) {
            $won = match($bet->bet_type) {
                'number' => $bet->bet_value == $resultNumber,
                'color'  => $bet->bet_value === $resultColor,
                'size'   => $bet->bet_value === $resultSize,
                default  => false,
            };

            if ($won) {
                $multiplier = match($bet->bet_type) {
                    'number' => 10,
                    'color'  => 3,
                    'size'   => 2,
                    default  => 0,
                };

                $winAmount = $bet->amount * $multiplier;

                $bet->update([
                    'status'         => 'won',
                    'winning_amount' => $winAmount,
                ]);

                // Wallet mein winning add karo
                $bet->user->wallet->increment('balance', $winAmount);

                // Transaction record
                Transaction::create([
                    'user_id'     => $bet->user_id,
                    'type'        => 'winning',
                    'amount'      => $winAmount,
                    'status'      => 'approved',
                    'description' => 'Won Round #' . $round->id . ' — ' . $resultNumber,
                ]);
            } else {
                $bet->update(['status' => 'lost']);
            }
        }
    }
}