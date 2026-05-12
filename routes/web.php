<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tabung', [TransactionController::class, 'showTabung'])->name('tabung.form');
    Route::post('/tabung', [TransactionController::class, 'processTabung'])->name('tabung.process');

    Route::get('/ambil', [TransactionController::class, 'showAmbil'])->name('ambil.form');
    Route::post('/ambil', [TransactionController::class, 'processAmbil'])->name('ambil.process');

    Route::get('/pinjam', [TransactionController::class, 'showPinjam'])->name('pinjam.form');
    Route::post('/pinjam', [TransactionController::class, 'processPinjam'])->name('pinjam.process');

    Route::get('/bayar', [TransactionController::class, 'showBayar'])->name('bayar.form');
    Route::post('/bayar', [TransactionController::class, 'processBayar'])->name('bayar.process');
});
