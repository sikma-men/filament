<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('pelanggan', function (blueprint $table) {
            $table->integer('noKontrol')->primary();
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('jenis_plg');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        //
    }
};
