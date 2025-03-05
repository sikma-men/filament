<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemakaian extends Model
{
    protected $primaryKey = 'noPemakaian';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'pemakaian';

    protected $fillable = [
        'noPemakaian',
        'noKontrol',
        'meter_awal',
        'meter_akhir',
        'jumlah_pakai',
        'biaya_pemakai',
        'biaya_beban_pemakai',
        'status',
    ];

    // Relasi ke tabel Pelanggan
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'noKontrol', 'noKontrol');
    }

    // Relasi ke tabel Tarif melalui Pelanggan
    public function tarif()
    {
        return $this->hasOneThrough(
            Tarif::class,
            Pelanggan::class,
            'noKontrol', // Foreign key di tabel Pelanggan
            'jenis_pelanggan', // Foreign key di tabel Tarif
            'noKontrol', // Local key di tabel Pemakaian
            'jenis_pelanggan' // Local key di tabel Pelanggan
        );
    }

}
