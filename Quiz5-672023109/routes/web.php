<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\TabunganController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/user/{id}', [UserController::class, 'show']);

// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

// Login routes
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->middleware('auth')->name('logout');

// Dashboard routes (auth-protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TabunganController::class, 'index'])->name('dashboard');
    Route::post('/tabung', [TabunganController::class, 'tabung'])->name('tabung.simpan');
    Route::post('/ambil', [TabunganController::class, 'ambil'])->name('ambil.uang');
    Route::post('/pinjam', [TabunganController::class, 'pinjam'])->name('pinjam.ajukan');
    Route::post('/bayar', [TabunganController::class, 'bayar'])->name('bayar.pinjaman');
});
