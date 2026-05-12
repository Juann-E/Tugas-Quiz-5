<?php
// routes/web.php

use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Routes untuk Tabung, Ambil, Pinjam, Bayar Pinjaman
    Route::get('/tabung', [BankController::class, 'tabungForm'])->name('tabung');
    Route::post('/tabung', [BankController::class, 'tabungProcess']);

    Route::get('/ambilTabungan', [BankController::class, 'ambilTabunganForm'])->name('ambilTabungan');
    Route::post('/ambilTabungan', [BankController::class, 'ambilTabunganProcess']);

    Route::get('/pinjam', [BankController::class, 'pinjamForm'])->name('pinjam');
    Route::post('/pinjam', [BankController::class, 'pinjamProcess']);

    Route::get('/bayarPinjaman', [BankController::class, 'bayarPinjamanForm'])->name('bayarPinjaman');
    Route::post('/bayarPinjaman', [BankController::class, 'bayarPinjamanProcess']);

    Route::get('/index', [BankController::class, 'index'])->name('bank.index');
});
