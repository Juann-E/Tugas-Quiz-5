<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PinjamanController;
use Illuminate\Support\Facades\Auth;

Route::get('/',
    [DashboardController::class, 'index'])
    ->name('dashboard');

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard',
        [DashboardController::class, 'index']);

    // tabung
    Route::post('/tabung',
        [TabunganController::class, 'tabung']);

    // ambil
    Route::post('/ambil',
        [TabunganController::class, 'ambil']);

    // pinjaman
    Route::get('/pinjaman',
        [PinjamanController::class, 'index']);

    Route::post('/pinjaman/store',
        [PinjamanController::class, 'store']);

    Route::post('/pinjaman/bayar/{id}',
        [PinjamanController::class, 'bayar']);
});
