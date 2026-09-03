<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\GameRound;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ── Dashboard ──
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_rounds'   => GameRound::count(),
            'pending_deposits'  => Transaction::where('type', 'deposit')
                                              ->where('status', 'pending')
                                              ->count(),
            'pending_withdraws' => Transaction::where('type', 'withdraw')
                                              ->where('status', 'pending')
                                              ->count(),
            'today_bets'     => Bet::whereDate('created_at', today())->count(),
            'today_revenue'  => Bet::whereDate('created_at', today())->sum('amount'),
        ];

        $recentRounds = GameRound::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRounds'));
    }

    // ── Users List ──
    public function users()
    {
        $users = User::where('role', 'user')
                     ->with('wallet')
                     ->latest()
                     ->paginate(20);

        return view('admin.users', compact('users'));
    }

    // ── User Block/Unblock ──
    public function toggleUser(User $user)
    {
        // Role change na ho admin ka
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin ko block nahi kar sakte!');
        }

        // Active field ke badle role use karenge
        $user->update([
            'role' => $user->role === 'user' ? 'banned' : 'user'
        ]);

        $msg = $user->fresh()->role === 'banned' ? 'User blocked!' : 'User unblocked!';
        return back()->with('success', $msg);
    }

    // ── Pending Deposits ──
    public function deposits()
    {
        $deposits = Transaction::where('type', 'deposit')
                               ->where('status', 'pending')
                               ->with('user')
                               ->latest()
                               ->paginate(20);

        return view('admin.deposits', compact('deposits'));
    }

    // ── Deposit Approve ──
    public function approveDeposit(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Ye request already process ho chuki hai!');
        }

        // Balance add karo
        $transaction->user->wallet->increment('balance', $transaction->amount);

        // Status update karo
        $transaction->update(['status' => 'approved']);

        return back()->with('success', 'Deposit approved! ✅');
    }

    // ── Deposit Reject ──
    public function rejectDeposit(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Ye request already process ho chuki hai!');
        }

        $transaction->update(['status' => 'rejected']);

        return back()->with('success', 'Deposit rejected!');
    }

    // ── Pending Withdrawals ──
    public function withdrawals()
    {
        $withdrawals = Transaction::where('type', 'withdraw')
                                  ->where('status', 'pending')
                                  ->with('user')
                                  ->latest()
                                  ->paginate(20);

        return view('admin.withdrawals', compact('withdrawals'));
    }

    // ── Withdrawal Approve ──
    public function approveWithdrawal(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Ye request already process ho chuki hai!');
        }

        $transaction->update(['status' => 'approved']);

        return back()->with('success', 'Withdrawal approved! ✅');
    }

    // ── Withdrawal Reject ──
    public function rejectWithdrawal(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Ye request already process ho chuki hai!');
        }

        // Balance wapas karo user ko
        $transaction->user->wallet->increment('balance', $transaction->amount);

        $transaction->update(['status' => 'rejected']);

        return back()->with('success', 'Withdrawal rejected! Balance wapas kar diya. ✅');
    }

    // ── Manual Result Set karo ──
    public function setManualResult(Request $request)
    {
        $request->validate([
            'manual_number' => 'required|integer|between:0,9',
        ]);

        $round = GameRound::where('status', 'open')->latest()->first();

        if (!$round) {
            return back()->with('error', 'Koi active round nahi hai!');
        }

        $round->update([
            'is_manual'     => true,
            'manual_number' => $request->manual_number,
        ]);

        return back()->with('success', 'Manual result set ho gaya! Next round mein apply hoga. ✅');
    }

    // ── Current Round Info ──
    // public function currentRound()
    // {
    //     $round = GameRound::where('status', 'open')->latest()->first();

    //     return response()->json([
    //         'success'        => true,
    //         'round_id'       => $round?->id,
    //         'seconds'        => $round?->seconds_remaining,
    //         'is_manual'      => $round?->is_manual,
    //         'manual_number'  => $round?->manual_number,
    //         'total_bets'     => $round?->bets->count(),
    //         'total_amount'   => $round?->bets->sum('amount'),
    //     ]);
    // }

    public function currentRound()
{
    $round = GameRound::where('status', 'open')->latest()->first();

    if (!$round) {
        return response()->json(['success' => false]);
    }

    $bets = $round->bets;

    // Size stats
    $bigBets    = $bets->where('bet_type', 'size')->where('bet_value', 'big');
    $smallBets  = $bets->where('bet_type', 'size')->where('bet_value', 'small');

    // Color stats
    $greenBets  = $bets->where('bet_type', 'color')->where('bet_value', 'green');
    $redBets    = $bets->where('bet_type', 'color')->where('bet_value', 'red');
    $violetBets = $bets->where('bet_type', 'color')->where('bet_value', 'violet');

    // Number stats
    $numberBets = [];
    for ($i = 0; $i <= 9; $i++) {
        $nb = $bets->where('bet_type', 'number')->where('bet_value', (string)$i);
        $numberBets[$i] = [
            'count'  => $nb->count(),
            'amount' => $nb->sum('amount'),
        ];
    }

    return response()->json([
        'success'      => true,
        'round_id'     => $round->id,
        'seconds'      => (int) $round->seconds_remaining,
        'is_manual'    => $round->is_manual,
        'manual_number'=> $round->manual_number,
        'total_bets'   => $bets->count(),
        'total_amount' => $bets->sum('amount'),
        'stats' => [
            'big'    => ['count' => $bigBets->count(),    'amount' => $bigBets->sum('amount')],
            'small'  => ['count' => $smallBets->count(),  'amount' => $smallBets->sum('amount')],
            'green'  => ['count' => $greenBets->count(),  'amount' => $greenBets->sum('amount')],
            'red'    => ['count' => $redBets->count(),    'amount' => $redBets->sum('amount')],
            'violet' => ['count' => $violetBets->count(), 'amount' => $violetBets->sum('amount')],
            'numbers'=> $numberBets,
        ],
    ]);
}

    // Queries list
    public function queries()
    {
        $queries = \App\Models\Query::latest()->paginate(20);
        return view('admin.queries', compact('queries'));
    }

    public function settings()
    {
        $settings = Setting::query()->pluck('value', 'key');

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['nullable', 'string', 'max:100'],
            'payment_upi_id' => ['required', 'string', 'max:120'],
            'min_deposit' => ['required', 'numeric', 'min:1'],
            'min_withdrawal' => ['required', 'numeric', 'min:1'],
            'round_duration' => ['required', 'integer', 'min:10', 'max:3600'],
            'support_phone' => ['nullable', 'string', 'max:30'],
            'support_email' => ['nullable', 'email', 'max:120'],
            'payment_qr' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($validated['payment_qr']);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        if ($request->hasFile('payment_qr')) {
            $oldPath = Setting::where('key', 'payment_qr_path')->value('value');
            $newPath = $request->file('payment_qr')->store('payment/qr-codes', 'public');

            Setting::updateOrCreate(
                ['key' => 'payment_qr_path'],
                ['value' => $newPath]
            );

            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }

}