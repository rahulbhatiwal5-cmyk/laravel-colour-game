<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Register Form Show ──
    public function showRegister()
    {
        return view('game.register');
    }

    // ── Register Logic ──
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|numeric|digits:10|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // Wallet auto create
        $user->wallet()->create(['balance' => 0]);

        Auth::login($user);

        return redirect()->route('game.index');
    }

    // ── Login Form Show ──
    public function showLogin()
    {
        return view('game.login');
    }

    // ── Login Logic ──
    public function login(Request $request)
    {
        // dd(77);
        $request->validate([
            'phone'    => 'required|numeric',
            'password' => 'required',
        ]);

       

        if (Auth::attempt([
                'phone'    => $request->phone,
                'password' => $request->password,
            ], $request->remember)) {
            $request->session()->regenerate();

            // Role check — admin ya user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('game.index');
        }

        return back()->withErrors([
            'phone' => 'Phone number or password wrong!',
        ])->withInput();
    }

    // ── Logout ──
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}