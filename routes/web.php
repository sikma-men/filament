<?php

use App\Http\Controllers\LoketController;
use App\Http\Controllers\PelangganController;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route untuk menampilkan form login
Route::get('/loket/login', [LoketController::class, 'showLoginForm'])->name('loket.login');
Route::get('/', [LoketController::class, 'login'])->name('pelanggan.dashboard');
// Route untuk memproses login
Route::post('/loket/login', [LoketController::class, 'loginloket']);

// Route untuk logout
Route::post('/loket/logout', [LoketController::class, 'logout'])->name('loket.logout');

// Route root langsung redirect ke dashboard loket (optional bisa disesuaikan)
Route::get('/loket', function () {
    return redirect()->route('loket.dashboard');
});
Route::get('/pemakaian', function () {
    return view('pelanggan.pemakaian');
});
Route::get('/', function () {
    return view('pelanggan.dashboard');
});
// Group semua yang butuh auth loket
Route::prefix('loket')->middleware('auth:loket')->group(function () {
    // Route::post('/loket/ubahstatus/{noPemakaian}', [LoketController::class, 'ubahStatus']);
    Route::get('/dashboard', [LoketController::class, 'dashboard'])->name('loket.dashboard');
    Route::get('/pemakaian', [LoketController::class, 'pemakaian'])->name('loket.pemakaian');
    Route::put('/updatestatus/{noPemakaian}', [LoketController::class, 'updateStatus'])->name('loket.updateStatus');
    Route::get('/detailpemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('loket.detailpemakaian');
    Route::get('/pemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('loket.pemakaian.detail');

    // Route::get('/laporan', [LoketController::class, 'laporan'])->name('loket.laporan');
    Route::get('/laporankeuangan/keseluruhan', [LoketController::class, 'laporankeuangan'])->name('loket.laporankeuangan');
    Route::get('/laporankeuangan/keseluruhan', [LoketController::class, 'keseluruhan'])->name('loket.laporankeseluruhan');
    Route::get('/laporankeuangan/jenispelanggan', [LoketController::class, 'jenisPelanggan'])->name('loket.laporanjenis');
});


//pelanggan
Route::get('/pemakaian', [PelangganController::class, 'pemakaian'])->name('pelanggan.pemakaian');
Route::get('/detailpemakaian/{noPemakaian}', [PelangganController::class, 'show'])->name('pelanggan.detailpemakaian');
