<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Loket extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun_loket';
    protected $fillable = ['nama', 'email', 'password'];
    protected $hidden = ['password']; // Sembunyikan password dalam response JSON
}
