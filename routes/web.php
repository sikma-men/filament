<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Livewire\Auth\Login;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login', function () {
    return view('auth.loginAdmin');
})->name('filament.auth.login');
