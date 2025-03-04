<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    use HasFactory;

    protected $table = 'pemakaian';
    protected $primaryKey = 'noPemakaian';

    protected $fillable = [
        'noPemakaian',
        'meter_awal',
        'meter_akhir',
        'biaya_beban_pemakai',
        'status',
    ];

    // Getter untuk menghitung jumlah_pakai secara otomatis
    public function getJumlahPakaiAttribute()
    {
        return $this->meter_akhir - $this->meter_awal;
    }
}
