<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
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

        return view('pelanggan.pemakaian', compact('pemakaian', 'noKontrol'));
    }
    public function show($noPemakaian)
    {
        $data = Pemakaian::where('noPemakaian', $noPemakaian)->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }
}
