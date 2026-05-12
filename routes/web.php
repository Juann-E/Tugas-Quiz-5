<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PinjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tabung',  [TabunganController::class, 'tabungForm'])->name('tabung.form');
    Route::post('/tabung', [TabunganController::class, 'tabung'])->name('tabung.post');
    Route::get('/ambil',   [TabunganController::class, 'ambilForm'])->name('ambil.form');
    Route::post('/ambil',  [TabunganController::class, 'ambil'])->name('ambil.post');
    Route::get('/pinjam',  [PinjamanController::class, 'pinjamForm'])->name('pinjam.form');
    Route::post('/pinjam', [PinjamanController::class, 'pinjam'])->name('pinjam.post');
    Route::get('/bayar',   [PinjamanController::class, 'bayarForm'])->name('bayar.form');
    Route::post('/bayar',  [PinjamanController::class, 'bayar'])->name('bayar.post');
});
