<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // ── Wallet Page ──
    public function index()
    {
        $wallet       = auth()->user()->wallet;
        $transactions = auth()->user()->transactions()
                              ->latest()
                              ->paginate(10);

        return view('wallet.index', compact('wallet', 'transactions'));
    }

    // ── Balance Check (AJAX) ──
    public function balance()
    {
        return response()->json([
            'success' => true,
            'balance' => number_format(auth()->user()->wallet->balance, 2),
        ]);
    }

    // ── Deposit Request ──
    public function depositRequest(Request $request)
    {
        $request->validate([
            'amount'     => 'required|numeric|min:100',
            'utr_number' => 'required|string|min:6|max:30',
        ]);

        // Pending deposit transaction banao
        Transaction::create([
            'user_id'     => auth()->id(),
            'type'        => 'deposit',
            'amount'      => $request->amount,
            'status'      => 'pending',
            'utr_number'  => $request->utr_number,
            'description' => 'Deposit request via QR',
        ]);

        return back()->with('success', 'Deposit request submited! ✅');
    }

    // ── Withdraw Request ──
    public function withdrawRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $wallet = auth()->user()->wallet;

        // Balance check
        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        // Balance hold karo
        $wallet->decrement('balance', $request->amount);

        // Pending withdraw transaction banao
        Transaction::create([
            'user_id'     => auth()->id(),
            'type'        => 'withdraw',
            'amount'      => $request->amount,
            'status'      => 'pending',
            'upi_id' => $request->upi_id,
            'utr_number'  => $request->utr_number,
            'description' => 'Withdrawal request',
        ]);

        return back()->with('success', 'Withdrawal request submited! ✅');
    }
}