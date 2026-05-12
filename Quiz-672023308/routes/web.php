<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/',         [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Protected routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/tabung', [TransaksiController::class, 'tabung'])->name('tabung');
    Route::post('/ambil',  [TransaksiController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam', [TransaksiController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar',  [TransaksiController::class, 'bayar'])->name('bayar');
});