<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiayaBebanPemakaiToPemakaianTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemakaian', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->decimal('jumlah_pakai', 10, 2)->default(0)->after('meter_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemakaian', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('biaya_beban_pemakai');
        });
    }
}
