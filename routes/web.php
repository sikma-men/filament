<?php

use App\Http\Controllers\LoketController;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;

// Route untuk menampilkan form login
Route::get('/loket/login', [LoketController::class, 'showLoginForm'])->name('loket.login');

// Route untuk memproses login
Route::post('/loket/login', [LoketController::class, 'loginloket']);

// Route untuk logout
Route::get('/loket/logout', [LoketController::class, 'logout'])->name('loket.logout');

// Group semua yang butuh auth loket
Route::prefix('loket')->middleware('auth:loket')->group(function () {
    Route::get('/pemakaian', [LoketController::class, 'pemakaian'])->name('pemakaian');
    Route::put('/updatestatus/{noPemakaian}', [LoketController::class, 'updateStatus'])->name('loket.updateStatus');
    Route::get('/detailpemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('loket.detailpemakaian');
    Route::get('/laporankeuangan/keseluruhan', [LoketController::class, 'keseluruhan'])->name('loket.laporankeseluruhan');
    Route::get('/laporankeuangan/jenispelanggan', [LoketController::class, 'jenisPelanggan'])->name('loket.laporanjenis');
});

// Rute root untuk pelanggan
Route::get('/', function () {
    return view('pelanggan.dashboard');
})->name('pelanggan.dashboard');

// Rute pemakaian untuk pelanggan
Route::get('/pemakaian/download/{noPemakaian}', [PelangganController::class, 'downloadPDF'])->name('pemakaian.download');
Route::get('/pemakaian', [PelangganController::class, 'pemakaian'])->name('pelanggan.pemakaian');
Route::get('/pemakaian/detail/{noPemakaian}', [PelangganController::class, 'showDetail'])->name('pemakaian.detail');
Route::get('/detailpemakaian/{noPemakaian}', [PelangganController::class, 'show'])->name('pelanggan.detailpemakaian');
