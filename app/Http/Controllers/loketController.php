<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemakaian;
use Barryvdh\DomPDF\Facade as PDF;

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
    public function pemakaian(Request $request)
    {
        $noKontrol = $request->input('no_kontrol');

        // Ambil data pemakaian berdasarkan noKontrol
        $pemakaian = Pemakaian::where('noKontrol', $noKontrol)->get();

        return view('loket.cariNoKontrol', compact('pemakaian', 'noKontrol'));
    }
    public function show($noPemakaian)
    {
        $pemakaian = Pemakaian::where('noPemakaian', $noPemakaian)->firstOrFail();
        return response()->json($pemakaian);
    }
    public function updateStatus(Request $request)
{
    $request->validate([
        'noPemakaian' => 'required|exists:pemakaian,noPemakaian',
    ]);

    $pemakaian = Pemakaian::where('noPemakaian', $request->noPemakaian)->first();

    if ($pemakaian) {
        $pemakaian->status = 'Sudah Lunas'; // Ubah status
        $pemakaian->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!',
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Data tidak ditemukan!',
    ], 404);
}
public function downloadPDF($noKontrol)
{
    $pemakaian = Pemakaian::where('noKontrol', $noKontrol)->get();

    $pdf = PDF::loadView('pemakaian.pdf', compact('pemakaian'));
    return $pdf->download('pemakaian_' . $noKontrol . '.pdf');
}


}
