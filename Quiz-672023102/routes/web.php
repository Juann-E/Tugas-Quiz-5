<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimpanPinjamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [SimpanPinjamController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/tabungan', [SimpanPinjamController::class, 'storeTabungan'])->name('tabungan.store');
    Route::post('/pinjaman', [SimpanPinjamController::class, 'storePinjaman'])->name('pinjaman.store');
    Route::post('/pembayaran', [SimpanPinjamController::class, 'storePembayaran'])->name('pembayaran.store');
});

require __DIR__.'/auth.php';
