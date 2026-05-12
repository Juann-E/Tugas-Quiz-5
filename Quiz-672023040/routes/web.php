<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth routes (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/tabung', [DashboardController::class, 'tabung'])->name('tabung');
    Route::post('/ambil', [DashboardController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam', [DashboardController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar-pinjaman', [DashboardController::class, 'bayarPinjaman'])->name('bayar.pinjaman');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});