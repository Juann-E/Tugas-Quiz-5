<?php

use App\Http\Controllers\AmbilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BayarPinjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\TabungController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/tabung', [TabungController::class, 'index']);
    Route::post('/tabung', [TabungController::class, 'store']);

    Route::get('/ambil', [AmbilController::class, 'index']);
    Route::post('/ambil', [AmbilController::class, 'store']);

    Route::get('/pinjam', [PinjamController::class, 'index']);
    Route::post('/pinjam', [PinjamController::class, 'store']);

    Route::get('/bayar-pinjaman', [BayarPinjamanController::class, 'index']);
    Route::post('/bayar-pinjaman', [BayarPinjamanController::class, 'store']);
});
