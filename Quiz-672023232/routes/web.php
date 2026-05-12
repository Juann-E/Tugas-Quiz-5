<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ── AUTH ─────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',         [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login',    [AuthController::class, 'showLogin']);
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── DASHBOARD (protected) ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',              [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tabung',                 [DashboardController::class, 'tabung'])->name('tabung');
    Route::post('/tabung',                [DashboardController::class, 'simpanTabungan'])->name('tabung.post');

    Route::get('/ambil',                  [DashboardController::class, 'ambil'])->name('ambil');
    Route::post('/ambil',                 [DashboardController::class, 'prosesAmbil'])->name('ambil.post');

    Route::get('/pinjam',                 [DashboardController::class, 'pinjam'])->name('pinjam');
    Route::post('/pinjam',                [DashboardController::class, 'ajukanPinjaman'])->name('pinjam.post');

    Route::get('/bayar-pinjaman',         [DashboardController::class, 'bayarPinjaman'])->name('bayar');
    Route::post('/bayar-pinjaman',        [DashboardController::class, 'prosesBayar'])->name('bayar.post');
});
