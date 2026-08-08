<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\GameRound;
use App\Models\Transaction;
use App\Services\GameRoundService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected GameRoundService $service;

    public function __construct(GameRoundService $service)
    {
        $this->service = $service;
    }

    // ── Game Page Load ──
    public function index()
    {
        $round = GameRound::where('status', 'open')
                          ->latest()
                          ->first();

        // Koi round nahi hai toh naya banao
        if (!$round) {
            $round = $this->service->createNewRound();
        }

        $recentRounds = GameRound::where('status', 'closed')
                                  ->latest()
                                   ->paginate(10);

        return view('game.index', compact('round', 'recentRounds'));
    }

    // ── Bet Place karo (AJAX) ──
    public function placeBet(Request $request)
    {
        $request->validate([
            'bet_type'  => 'required|in:color,number,size',
            'bet_value' => 'required|string',
            'amount'    => 'required|numeric|min:10',
        ]);

        $round = GameRound::where('status', 'open')->latest()->first();

        // Round nahi mila
        if (!$round) {
            return response()->json([
                'success' => false,
                'message' => 'No active round!'
            ], 422);
        }

        // Last 10 sec mein betting band
        if ($round->is_betting_locked) {
            return response()->json([
                'success' => false,
                'message' => 'Betting closed waite for next round.'
            ], 422);
        }

        $wallet = auth()->user()->wallet;

        // Balance check
        if ($wallet->balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance!'
            ], 422);
        }

        // Balance deduct karo
        $wallet->decrement('balance', $request->amount);

        // Transaction record
        Transaction::create([
            'user_id'     => auth()->id(),
            'type'        => 'bet',
            'amount'      => $request->amount,
            'status'      => 'approved',
            'description' => 'Bet on ' . $request->bet_type . ': ' . $request->bet_value,
        ]);

        // Bet save karo
        Bet::create([
            'user_id'       => auth()->id(),
            'game_round_id' => $round->id,
            'bet_type'      => $request->bet_type,
            'bet_value'     => $request->bet_value,
            'amount'        => $request->amount,
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Bet placed! Best of luck 🎯',
            'new_balance' => number_format($wallet->fresh()->balance, 2),
        ]);
    }

    // ── Round Status (AJAX Polling) ──
    public function status()
    {
        $round = GameRound::where('status', 'open') 
                          ->latest()
                          ->first();

        if (!$round) {
            return response()->json([
                'success' => false,
                'message' => 'No active round'
            ]);
        }

        return response()->json([
            'success'           => true,
            'round_id'          => $round->id,
            'seconds_remaining' => $round->seconds_remaining,
            'is_locked'         => $round->is_betting_locked,
            'ends_at'           => $round->ends_at,
        ]);
    }

    // ── Game History (AJAX) ──
    public function history()
    {
        $rounds = GameRound::where('status', 'closed')
                           ->latest()
                           ->take(10)
                           ->get(['id', 'result_number', 'result_color', 'result_size', 'created_at']);

        return response()->json([
            'success' => true,
            'rounds'  => $rounds,
        ]);
    }

    // ── My Bet History (AJAX) ──
    public function myHistory()
    {
        $bets = Bet::where('user_id', auth()->id())
                   ->with('gameRound')
                   ->latest()
                   ->take(10)
                   ->get(['id', 'game_round_id', 'bet_type', 'bet_value', 'amount', 'winning_amount', 'status']);

        return response()->json([
            'success' => true,
            'bets'    => $bets,
        ]);
    }

   public function checkResult()
{
    $lastRound = GameRound::where('status', 'closed')
                          ->latest()
                          ->first();

    if (!$lastRound) {
        return response()->json(['success' => false]);
    }

    $bet = Bet::where('user_id', auth()->id())
              ->where('game_round_id', $lastRound->id)
              ->first();

    if (!$bet) {
        return response()->json(['success' => false]);
    }

    return response()->json([
        'success'        => true,
        'status'         => $bet->status,
        'amount'         => $bet->amount,
        'winning_amount' => $bet->winning_amount,
        'result_number'  => $lastRound->result_number,
        'new_balance'    => number_format(auth()->user()->wallet->fresh()->balance, 2),
    ]);
}

}