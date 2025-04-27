<?php

use App\Http\Controllers\LoketController;
use Illuminate\Support\Facades\Route;

// Route untuk menampilkan form login
Route::get('/loket/login', [LoketController::class, 'showLoginForm'])->name('loket.login');

// Route untuk memproses login
Route::post('/loket/login', [LoketController::class, 'loginloket']);

// Route untuk logout
Route::post('/loket/logout', [LoketController::class, 'logout'])->name('loket.logout');

// Route root langsung redirect ke dashboard loket (optional bisa disesuaikan)
Route::get('/loket', function () {
    return redirect()->route('loket.dashboard');
});

// Group semua yang butuh auth loket
Route::prefix('loket')->middleware('auth:loket')->group(function () {
    Route::get('/dashboard', [LoketController::class, 'dashboard'])->name('loket.dashboard');
    Route::get('/pemakaian', [LoketController::class, 'pemakaian'])->name('loket.pemakaian');
    Route::post('/pemakaian/update-status', [LoketController::class, 'updateStatus'])->name('loket.pemakaian.update-status');

    Route::get('/pemakaian', function () {
        return view('loket.carinokontrol');
    })->name('loket.pemakaian');

    Route::get('/detailpemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('loket.detailpemakaian');
    Route::get('/pemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('loket.pemakaian.detail');

    Route::get('/laporan', [LoketController::class, 'laporan'])->name('loket.laporan');
    Route::get('/laporankeuangan', [LoketController::class, 'laporankeuangan'])->name('loket.laporankeuangan');
    Route::get('/laporankeseluruhan', [LoketController::class, 'keseluruhan'])->name('loket.laporankeseluruhan');
    Route::get('/laporanjenis', [LoketController::class, 'jenisPelanggan'])->name('loket.laporanjenis');
});
