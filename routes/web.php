<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/tabung', [DashboardController::class, 'tabung'])->name('tabung');
Route::post('/ambil', [DashboardController::class, 'ambil'])->name('ambil');
Route::post('/pinjam', [DashboardController::class, 'pinjam'])->name('pinjam');
Route::get('/bayar', [DashboardController::class, 'showBayar'])->name('bayar');
Route::post('/bayar', [DashboardController::class, 'bayar']);