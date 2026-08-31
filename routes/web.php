<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ProfileController;


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
     Route::get('/queries', [AdminController::class, 'queries'])->name('queries');
    Route::get('/dashboard',                    [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                        [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle',         [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::get('/deposits',                     [AdminController::class, 'deposits'])->name('deposits');
    Route::post('/deposits/{transaction}/approve', [AdminController::class, 'approveDeposit'])->name('deposits.approve');
    Route::post('/deposits/{transaction}/reject',  [AdminController::class, 'rejectDeposit'])->name('deposits.reject');
    Route::get('/withdrawals',                     [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::post('/withdrawals/{transaction}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::post('/withdrawals/{transaction}/reject',  [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
    Route::post('/result',                      [AdminController::class, 'setManualResult'])->name('result');
    Route::get('/round',                        [AdminController::class, 'currentRound'])->name('round');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile',           [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/wallet',            [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/balance',    [WalletController::class, 'balance'])->name('wallet.balance');
    Route::post('/wallet/deposit',   [WalletController::class, 'depositRequest'])->name('wallet.deposit');
    Route::post('/wallet/withdraw',  [WalletController::class, 'withdrawRequest'])->name('wallet.withdraw');
});

Route::middleware('auth')->group(function () {
    Route::get('/game',             [GameController::class, 'index'])->name('game.index');
    Route::post('/game/bet',        [GameController::class, 'placeBet'])->name('game.bet');
    Route::get('/game/status',      [GameController::class, 'status'])->name('game.status');
    Route::get('/game/history',     [GameController::class, 'history'])->name('game.history');
    Route::get('/game/my-history',  [GameController::class, 'myHistory'])->name('game.myHistory');

Route::get('/game/check-result', [GameController::class, 'checkResult'])->name('game.checkResult');
});

    Route::get('/',[AuthController::class, 'showRegister']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/post', [AuthController::class, 'register'])->name('register_post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);


Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Help routes
Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::post('/help/query', [HelpController::class, 'submitQuery'])->name('help.query');

// Query replied status update
Route::post('/admin/queries/{query}/replied', function(\App\Models\Query $query) {
    $query->update(['status' => 'replied']);
    return response()->json(['success' => true]);
})->middleware(['auth', 'admin'])->name('admin.queries.replied');
