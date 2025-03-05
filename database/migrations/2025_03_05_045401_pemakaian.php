<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemakaian', function (Blueprint $table) {
            $table->string('noPemakaian')->primary(); // Primary Key
            $table->integer('noKontrol'); // Foreign Key ke pelanggan
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->integer('biaya_beban_pemakai');
            $table->integer('jumlah_pakai');
            $table->integer('biaya_pemakai');
            $table->string('status');
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('noKontrol')
                  ->references('noKontrol')->on('pelanggan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaian');
    }
};
