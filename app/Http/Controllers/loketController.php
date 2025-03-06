<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Loket;

class LoketController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('loket.loginLoket'); // Sesuaikan dengan nama file Blade yang digunakan
    }

    // Proses autentikasi login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah email ada di database
        $user = Loket::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ]);
        }

        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password Anda salah.',
            ]);
        }

        // Jika email dan password benar, lakukan login
        if (Auth::guard('loket')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan, silakan coba lagi.',
        ]);
    }


    // Logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
