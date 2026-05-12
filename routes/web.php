<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\BayarPinjamanController;

Route::get('/', function () {
    return view('welcome');
});

// ────── Authentication Routes ──────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/home', function () {
    return view('home');
})->name('home');

// Protected Routes (Authentication Required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Simpanan Resource Routes
    Route::resource('simpanan', SimpananController::class);
    
    // Tabungan Resource Routes
    Route::resource('tabungan', TabunganController::class);
    
    // Tabungan Transactions
    Route::post('tabungan/{tabungan}/setor', [TabunganController::class, 'setor'])->name('tabungan.setor');
    Route::post('tabungan/{tabungan}/tarik', [TabunganController::class, 'tarik'])->name('tabungan.tarik');
    
    // Pinjaman Resource Routes
    Route::resource('pinjaman', PinjamanController::class);
    
    // Pinjaman Actions
    Route::post('pinjaman/{pinjaman}/approve', [PinjamanController::class, 'approve'])->name('pinjaman.approve');
    Route::post('pinjaman/{pinjaman}/reject', [PinjamanController::class, 'reject'])->name('pinjaman.reject');
    
    // Bayar Pinjaman Resource Routes
    // web.php
    Route::get('bayar-pinjaman/{pinjaman_id}/create', [BayarPinjamanController::class, 'create'])
        ->name('bayar-pinjaman.create');

    Route::post('bayar-pinjaman', [BayarPinjamanController::class, 'store'])
        ->name('bayar-pinjaman.store');

    Route::get('bayar-pinjaman', [BayarPinjamanController::class, 'index'])
        ->name('bayar-pinjaman.index');

    Route::get('bayar-pinjaman/{bayarPinjaman}', [BayarPinjamanController::class, 'show'])
        ->name('bayar-pinjaman.show');
});

