<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel di database

    protected $primaryKey = 'noKontrol'; // Primary key tabel

    public $incrementing = false; // Karena primary key bukan auto-increment

    protected $keyType = 'string'; // Tipe data primary key

    protected $fillable = [
        'noKontrol',
        'nama',
        'alamat',
        'telepon',
        'jenis_plg',
    ];
}
