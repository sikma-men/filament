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
        return redirect()->route('login');
    }

    public function pemakaian(Request $request)
    {
        $noKontrol = $request->input('no_kontrol');
        $status = $request->input('status');

        $pemakaian = collect([]);

        if ($noKontrol) {
            $query = Pemakaian::where('noKontrol', $noKontrol);

            if ($status) {
                $query->where('status', $status);
            }

            $pemakaian = $query->get();
        }

        return view('loket.cariNoKontrol', compact('pemakaian', 'noKontrol'));
    }

    public function show($noPemakaian)
    {
        $data = Pemakaian::where('noPemakaian', $noPemakaian)->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function laporan()
    {
        $pemakaian = Pemakaian::all();
        return view('loket.laporan', compact('pemakaian'));
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
            ->where('pelanggan.jenis_pelanggan', 'R-1')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianR2 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'R-2')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianR3 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'R-3')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianB1 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'B-1')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianB2 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'B-2')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianB3 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'B-3')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianI2 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'I-2')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianI3 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'I-3')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaPemakaianI4 = DB::table('pemakaian')
            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
            ->where('pelanggan.jenis_pelanggan', 'I-4')
            ->where('pemakaian.status', 'sudah lunas')
            ->sum('pemakaian.biaya_pemakai');

        $totalBiayaBeban = Pemakaian::where('status', 'sudah lunas')->sum('biaya_beban_pemakai');
        $totalBiayaPemakai = Pemakaian::where('status', 'sudah lunas')->sum('biaya_pemakai');
        $totalBiaya = $totalBiayaBeban + $totalBiayaPemakai;

        return view('loket.laporankeuangan', compact(
            'totalBiayaBeban',
            'totalBiayaPemakai',
            'totalBiaya',
            'totalBiayaPemakaianR1',
            'totalBiayaPemakaianR2',
            'totalBiayaPemakaianR3',
            'totalBiayaPemakaianB1',
            'totalBiayaPemakaianB2',
            'totalBiayaPemakaianB3',
            'totalBiayaPemakaianI2',
            'totalBiayaPemakaianI3',
            'totalBiayaPemakaianI4'
        ));
    }
}
