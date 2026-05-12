<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Rute untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', function () { return redirect()->route('login'); });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute yang butuh login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Fitur dari jawaban sebelumnya
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/tabung', [DashboardController::class, 'tabung'])->name('tabung');
    Route::post('/ambil', [DashboardController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam', [DashboardController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar', [DashboardController::class, 'bayar'])->name('bayar');
});