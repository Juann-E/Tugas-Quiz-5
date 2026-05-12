<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AmbilController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | TABUNG
    |--------------------------------------------------------------------------
    */

    Route::get('/tabung', [TabunganController::class, 'index']);

    Route::post('/tabung', [TabunganController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | AMBIL UANG
    |--------------------------------------------------------------------------
    */

    Route::get('/ambil', [AmbilController::class, 'index']);

    Route::post('/ambil', [AmbilController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | PINJAM
    |--------------------------------------------------------------------------
    */

    Route::get('/pinjam', [PinjamanController::class, 'index']);

    Route::post('/pinjam', [PinjamanController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | BAYAR
    |--------------------------------------------------------------------------
    */

    Route::get('/bayar', [PembayaranController::class, 'index']);

    Route::post('/bayar', [PembayaranController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| REDIRECT ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect('/login');

});