<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;


class HelpController extends Controller
{
     // Help page show
    public function index()
    {
        return view('help.index');
    }

    // Query submit
    public function submitQuery(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|min:10|max:1000',
        ]);

        Query::create([
            'user_id' => auth()->id() ?? null,
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your query has been submitted! We will reply to your email within 24 hours.');
    }
}
