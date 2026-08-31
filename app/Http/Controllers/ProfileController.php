<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    /** Display the authenticated user's account details. */
    public function show()
    {
        $user = auth()->user()->load('wallet');

        return view('profile.show', compact('user'));
    }
}
