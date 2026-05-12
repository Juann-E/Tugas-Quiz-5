<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
 
// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));
 
// Auth routes (tanpa middleware)
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
 
// Dashboard routes (wajib login)
Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard',     [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/tabung',        [DashboardController::class, 'tabung'])->name('tabung');
    Route::post('/ambil',         [DashboardController::class, 'ambil'])->name('ambil');
    Route::post('/pinjam',        [DashboardController::class, 'pinjam'])->name('pinjam');
    Route::post('/bayar',         [DashboardController::class, 'bayar'])->name('bayar');
});
