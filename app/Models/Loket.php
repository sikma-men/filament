<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Loket extends Authenticatable
{
    use Notifiable;

    protected $table = 'akun_loket'; // Tambahkan ini!

    protected $fillable = ['nama', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed', // Jika pakai Laravel 10 ke atas
    ];
}
