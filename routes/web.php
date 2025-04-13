<?php
use App\Http\Controllers\LoketController;
use Illuminate\Support\Facades\Route;


// Route untuk menampilkan form login
Route::get('/loginloket', [LoketController::class, 'showLoginForm'])->name('loginloket');

// Route untuk memproses login
Route::post('loginloket', [LoketController::class, 'loginloket']);

// Route untuk logout
Route::post('/logout', [LoketController::class, 'logout'])->name('logout');

Route::middleware('auth:loket')->group(function () {
    Route::get('/dashboard-loket', [LoketController::class, 'dashboard'])->name('loket.dashboard');
    Route::get('/pemakaian', [LoketController::class, 'pemakaian'])->name('pemakaian');
    Route::get('/pemakaian/{noPemakaian}', [LoketController::class, 'show'])->name('pemakaian.show');
    Route::post('/pemakaian/update-status', [LoketController::class, 'updateStatus'])->name('pemakaian.update-status');
    Route::get('/carinokontrol', function () {
        return view('loket.carinokontrol');
    })->name('carinokontrol');
    Route::get('/laporankeuangan', [LoketController::class, 'laporankeuangan'])->name('laporankeuangan');
});
