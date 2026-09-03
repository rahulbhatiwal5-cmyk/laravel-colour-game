<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Setting;
use App\Models\Coupon;
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
        $paymentSettings = Setting::whereIn('key', ['payment_upi_id', 'payment_qr_path'])
                      ->pluck('value', 'key');
        $paymentQrPath = $paymentSettings->get('payment_qr_path');
        $paymentQrUrl = $paymentQrPath
            ? '/storage/' . ltrim($paymentQrPath, '/')
            : asset('images/qr-code.png');

        return view('wallet.index', compact('wallet', 'transactions', 'paymentSettings', 'paymentQrUrl'));
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
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $coupon = null;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($request->coupon_code))])
                            ->where('active', true)
                            ->where(function ($query) {
                                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
                            })
                            ->first();

            if (!$coupon || $request->amount < $coupon->min_deposit ||
                ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses)) {
                return back()->withInput()->with('error', 'Invalid, expired, or unavailable coupon.');
            }
        }

        $couponPercentage = $coupon ? (float) $coupon->bonus_percentage : null;
        $bonusAmount = $coupon ? round((float) $request->amount * $couponPercentage / 100, 2) : 0;

        // Pending deposit transaction banao
        Transaction::create([
            'user_id'     => auth()->id(),
            'type'        => 'deposit',
            'amount'      => $request->amount,
            'status'      => 'pending',
            'utr_number'  => $request->utr_number,
            'description' => $coupon
                ? 'Deposit request via QR - Coupon ' . $coupon->code
                : 'Deposit request via QR',
            'coupon_id' => $coupon?->id,
            'coupon_code' => $coupon?->code,
            'coupon_percentage' => $couponPercentage,
            'bonus_amount' => $bonusAmount,
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