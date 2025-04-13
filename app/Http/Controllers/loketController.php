<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemakaian;

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
            return redirect()->route('loket.dashboard');
        }

        return redirect()->route('loginloket')->with('error', 'Email atau password salah!');
    }

    public function dashboard()
    {
        return view('loket.dashboard');
    }
    public function laporankeuangan()
    {
        $totalBiayaBeban = Pemakaian::sum('biaya_beban_pemakai');
        $totalBiayaPemakai = Pemakaian::sum('biaya_pemakai');
        $totalBiaya = $totalBiayaBeban + $totalBiayaPemakai;
        return view('loket.laporankeuangan', compact('totalBiayaBeban', 'totalBiayaPemakai', 'totalBiaya'));
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
}
