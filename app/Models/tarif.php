<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tarif extends Model
{
    use HasFactory;
    protected $table = 'tarif';
    protected $primaryKey = 'jenis_pelanggan';
    protected $keyType = 'string';
    protected $fillable = [
        'jenis_pelanggan',
        'biayabeban',
        'tarifkwh',
    ];
}
