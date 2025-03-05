<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tarif extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data tarif berdasarkan jenis pelanggan
        $tarifList = [
            [
                'jenis_pelanggan' => 'R-1', // Rumah Tangga 1
                'biayaBeban' => 15000,    // Biaya beban
                'tarifKWH' => 1444,      // Tarif per KWH (dalam rupiah)
            ],
            [
                'jenis_pelanggan' => 'R-2', // Rumah Tangga 2
                'biayaBeban' => 20000,
                'tarifKWH' => 1444,
            ],
            [
                'jenis_pelanggan' => 'R-3', // Rumah Tangga 3
                'biayaBeban' => 25000,
                'tarifKWH' => 1444,
            ],
            [
                'jenis_pelanggan' => 'B-1', // Bisnis 1
                'biayaBeban' => 30000,
                'tarifKWH' => 1699,      // Tarif lebih tinggi untuk bisnis
            ],
            [
                'jenis_pelanggan' => 'B-2', // Bisnis 2
                'biayaBeban' => 35000,
                'tarifKWH' => 1699,
            ],
            [
                'jenis_pelanggan' => 'B-3', // Bisnis 3
                'biayaBeban' => 40000,
                'tarifKWH' => 1699,
            ],
            [
                'jenis_pelanggan' => 'I-2', // Industri 2
                'biayaBeban' => 45000,
                'tarifKWH' => 1999,      // Tarif lebih tinggi untuk industri
            ],
            [
                'jenis_pelanggan' => 'I-3', // Industri 3
                'biayaBeban' => 50000,
                'tarifKWH' => 1999,
            ],
            [
                'jenis_pelanggan' => 'I-4', // Industri 4
                'biayaBeban' => 55000,
                'tarifKWH' => 1999,
            ],
        ];

        // Masukkan data ke tabel tarif
        DB::table('tarif')->insert($tarifList);
    }
}
