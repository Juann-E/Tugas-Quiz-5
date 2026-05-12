<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Halaman Publik
Route::get('/', function () { return view('register'); });
Route::get('/register', function () { return view('register'); })->name('register');
Route::post('/register', [TransactionController::class, 'register'])->name('register.post');
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [TransactionController::class, 'login'])->name('login.post');

// Halaman Terproteksi (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');
    Route::post('/tabung', [TransactionController::class, 'tabung'])->name('tabung');
    
    // TAMBAHKAN RUTE INI AGAR TIDAK ERROR "NOT DEFINED" LAGI
    Route::post('/ambil', [TransactionController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam', [TransactionController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar', [TransactionController::class, 'bayar'])->name('bayar');
    
    Route::get('/logout', [TransactionController::class, 'logout'])->name('logout');
});