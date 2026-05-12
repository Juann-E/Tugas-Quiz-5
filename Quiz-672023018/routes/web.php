<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Auth
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::get('/logout',   [AuthController::class, 'logout'])->name('logout');

// Protected routes (harus login)
Route::middleware('auth.custom')->group(function() {
    Route::get('/profile',           [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tabung',    [SavingController::class, 'showTabung'])->name('tabung');
    Route::post('/tabung',   [SavingController::class, 'tabung'])->name('tabung.post');
    Route::get('/ambil',     [SavingController::class, 'showAmbil'])->name('ambil');
    Route::post('/ambil',    [SavingController::class, 'ambil'])->name('ambil.post');
    Route::get('/pinjam',    [LoanController::class, 'showPinjam'])->name('pinjam');
    Route::post('/pinjam',   [LoanController::class, 'pinjam'])->name('pinjam.post');
    Route::get('/bayar',     [LoanController::class, 'showBayar'])->name('bayar');
    Route::post('/bayar',    [LoanController::class, 'bayar'])->name('bayar.post');
});
