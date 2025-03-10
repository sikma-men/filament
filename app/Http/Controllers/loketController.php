<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoketController extends Controller
{
    // Method untuk menampilkan form login
    public function showLoginForm()
    {
        return view('loket.loginLoket'); // Pastikan file view-nya ada di resources/views/loket/loginLoket.blade.php
    }

    // Method untuk memproses login
    public function loginloket(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Coba autentikasi menggunakan guard 'loket'
        if (Auth::guard('loket')->attempt($credentials)) {
            return redirect()->route('loket.dashboard'); // Redirect ke dashboard jika berhasil
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return redirect()->route('loginloket')->with('error', 'Email atau password salah!');
    }

    // Method untuk menampilkan dashboard
    public function dashboard()
    {
        return view('loket.dashboard'); // Pastikan file view-nya ada di resources/views/loket/dashboard.blade.php
    }

    // Method untuk logout
    public function logout(Request $request)
    {
        Auth::guard('loket')->logout(); // Logout dari guard 'loket'
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginloket'); // Redirect ke halaman login
    }
}
