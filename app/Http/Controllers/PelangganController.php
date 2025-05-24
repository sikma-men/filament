<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PelangganController extends Controller
{


    public function downloadPDF($noPemakaian)
    {
        $data = Pemakaian::where('noPemakaian', $noPemakaian)->firstOrFail();
        $pdf = Pdf::loadView('pelanggan.detail-pemakaian', compact('data'));
        return $pdf->download('Detail_Pemakaian_' . $noPemakaian . '.pdf');
    }
    public function showDetail($noPemakaian)
    {
        $data = Pemakaian::where('noPemakaian', $noPemakaian)->firstOrFail();
        return view('pelanggan.detail-pemakaian', compact('data'));
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
