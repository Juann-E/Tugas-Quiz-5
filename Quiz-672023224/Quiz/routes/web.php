<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::redirect('/', '/login');

// ─── AUTH (Guest Only) ───────────────────────────────────────────────
Route::controller(AuthController::class)
    ->middleware('guest')
    ->group(function () {

        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('login.post');

        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->name('register.post');
    });

// ─── DASHBOARD (Auth Only) ───────────────────────────────────────────
Route::controller(DashboardController::class)
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', 'index')->name('dashboard');

        Route::post('/tabung', 'tabung')->name('tabung');
        Route::post('/ambil', 'ambil')->name('ambil');
        Route::post('/pinjam', 'pinjam')->name('pinjam');
        Route::post('/bayar-pinjaman', 'bayarPinjaman')->name('bayar.pinjaman');
    });

// ─── LOGOUT ─────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');