<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankingController;
use App\Http\Controllers\AuthController;

// --- RUTE GUEST (Bisa dibuka sebelum login) ---
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// --- RUTE AUTH (Hanya bisa dibuka setelah login) ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BankingController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Sudah ada namanya sekarang
    Route::get('/report/pdf', [BankingController::class, 'generatePDF'])->name('report.pdf');

    // Rute Tampilan Halaman (GET)
    Route::get('/tabung', [BankingController::class, 'showTabung'])->name('tabung.view');
    Route::get('/ambil', [BankingController::class, 'showAmbil'])->name('ambil.view');
    Route::get('/pinjam', [BankingController::class, 'showPinjam'])->name('pinjam.view');
    Route::get('/bayar', [BankingController::class, 'showBayar'])->name('bayar.view');

    // Rute Proses Transaksi (POST)
    Route::post('/tabung', [BankingController::class, 'tabung'])->name('tabung');
    Route::post('/ambil', [BankingController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam', [BankingController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar', [BankingController::class, 'bayar'])->name('bayar');
});