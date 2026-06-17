<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TabunganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/tabung', [TabunganController::class, 'create'])
        ->name('tabung.create');

    Route::post('/tabung', [TabunganController::class, 'store'])
        ->name('tabung.store');
});

Route::middleware('auth')->group(function () {

    Route::get('/ambil', [PenarikanController::class, 'create'])
        ->name('ambil.create');

    Route::post('/ambil', [PenarikanController::class, 'store'])
        ->name('ambil.store');
});

Route::middleware('auth')->group(function () {

    Route::get('/pinjam', [PinjamanController::class, 'create'])
        ->name('pinjam.create');

    Route::post('/pinjam', [PinjamanController::class, 'store'])
        ->name('pinjam.store');
});

Route::middleware('auth')->group(function () {

    Route::get('/bayar', [PembayaranController::class, 'create'])
        ->name('bayar.create');

    Route::post('/bayar', [PembayaranController::class, 'store'])
        ->name('bayar.store');
});

require __DIR__ . '/auth.php';
