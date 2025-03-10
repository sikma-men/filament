<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class loket extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('akun_loket')->insert([
            'nama' => 'Wataligma',
            'email' => 'n@gmail.com',
            'password' =>bcrypt('n'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
