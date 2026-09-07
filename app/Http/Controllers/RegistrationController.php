<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Get name from email (before @)
        $nameFromEmail = explode('@', $request->email)[0];

        // 1. Create the User (Parent)
        $user = \App\Models\User::create([
            'name' => $nameFromEmail,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'parent',
        ]);

        // 2. Trigger Email Verification
        event(new \Illuminate\Auth\Events\Registered($user));

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan cek email Anda untuk melakukan verifikasi sebelum login.');
    }
}
