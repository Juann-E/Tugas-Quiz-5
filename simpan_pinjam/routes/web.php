<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard & Transaksi (Gunakan middleware auth agar hanya yang login yang bisa akses)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tabung
    Route::get('/tabung', [TransactionController::class, 'showDepositForm'])->name('transaction.deposit.view');
    Route::post('/tabung', [TransactionController::class, 'deposit'])->name('transaction.deposit');

    // Ambil
    Route::get('/ambil', [TransactionController::class, 'showWithdrawForm'])->name('transaction.withdraw.view');
    Route::post('/ambil', [TransactionController::class, 'withdraw'])->name('transaction.withdraw');

    // Pinjam
    Route::get('/pinjam', [TransactionController::class, 'showLoanForm'])->name('transaction.loan.view');
    Route::post('/pinjam', [TransactionController::class, 'loan'])->name('transaction.loan');

    // Bayar
    Route::get('/bayar', [TransactionController::class, 'showRepayForm'])->name('transaction.repay.view');
    Route::post('/bayar', [TransactionController::class, 'repay'])->name('transaction.repay');
});
