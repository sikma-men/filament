<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemakaian;
use Illuminate\Support\Facades\DB;

class LoketController extends Controller
{
    public function showLoginForm()
    {
        return view('loket.loginLoket');
    }

    public function loginloket(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('loket')->attempt($request->only('email', 'password'))) {
            return redirect()->route('carinokontrol')
                ->with('success', 'Login berhasil!');
        }

        return redirect()->route('loginloket')->with('error', 'Email atau password salah!');
    }

    public function dashboard()
    {
        return view('loket.dashboard');
    }


    public function logout(Request $request)
    {
        Auth::guard('loket')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginloket');
    }

    public function pemakaian(Request $request)
    {
        $noKontrol = $request->input('no_kontrol');
        $pemakaian = $noKontrol ? Pemakaian::where('noKontrol', $noKontrol)->get() : collect([]);

        return view('loket.cariNoKontrol', compact('pemakaian', 'noKontrol'));
    }

    public function show($noPemakaian)
    {
        return response()->json(Pemakaian::where('noPemakaian', $noPemakaian)->firstOrFail());
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'noPemakaian' => 'required|exists:pemakaian,noPemakaian',
        ]);

        $pemakaian = Pemakaian::where('noPemakaian', $request->noPemakaian)->first();

        if ($pemakaian) {
            $pemakaian->status = 'Sudah Lunas';
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
    public function laporankeuangan()
    {
        $totalBiayaPemakaianR1 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'R-1')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianR2 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'R-2')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianR3 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'R-3')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianB1 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'B-1')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianB2 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'B-2')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianB3 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'B-3')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianI2 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'I-2')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianI3 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'I-3')
        ->sum('pemakaian.biaya_pemakai');

    $totalBiayaPemakaianI4 = DB::table('pemakaian')
        ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
        ->where('pelanggan.jenis_plg', 'I-4')
        ->sum('pemakaian.biaya_pemakai');


        $totalBiayaBeban = Pemakaian::sum('biaya_beban_pemakai');
        $totalBiayaPemakai = Pemakaian::sum('biaya_pemakai');
        $totalBiaya = $totalBiayaBeban + $totalBiayaPemakai;
        return view('loket.laporankeuangan', compact('totalBiayaBeban', 'totalBiayaPemakai', 'totalBiaya', 'totalBiayaPemakaianR1',
        'totalBiayaPemakaianR2',
        'totalBiayaPemakaianR3',
        'totalBiayaPemakaianB1',
        'totalBiayaPemakaianB2',
        'totalBiayaPemakaianB3',
        'totalBiayaPemakaianI2',
        'totalBiayaPemakaianI3',
        'totalBiayaPemakaianI4',));
    }
}
