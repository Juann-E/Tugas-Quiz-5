<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PinjamanController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/tabung', [TabunganController::class, 'tabung']);

    Route::post('/ambil', [TabunganController::class, 'ambil']);

    Route::post('/pinjam', [PinjamanController::class, 'store']);

    Route::post('/bayar/{id}', [PinjamanController::class, 'bayar']);
});

require __DIR__.'/auth.php';