<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Livewire\Auth\Login;
use App\Http\Controllers\LoketController;

Route::get('/', [LoketController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoketController::class, 'login'])->name('login');
Route::post('/logout', [LoketController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('loket.dashboard');
})->middleware(['auth'])->name('dashboard');
