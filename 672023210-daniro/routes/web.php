<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Transaction Routes
Route::middleware('auth')->group(function () {
    Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transaction.history');
    Route::get('/transaction/save', [TransactionController::class, 'showSave'])->name('transaction.showSave');
    Route::post('/transaction/save', [TransactionController::class, 'save'])->name('transaction.save');
    
    Route::get('/transaction/withdraw', [TransactionController::class, 'showWithdraw'])->name('transaction.showWithdraw');
    Route::post('/transaction/withdraw', [TransactionController::class, 'withdraw'])->name('transaction.withdraw');
    
    Route::get('/transaction/borrow', [TransactionController::class, 'showBorrow'])->name('transaction.showBorrow');
    Route::post('/transaction/borrow', [TransactionController::class, 'borrow'])->name('transaction.borrow');
    
    Route::get('/loans', [TransactionController::class, 'loans'])->name('transaction.loans');
    Route::get('/transaction/pay-loan', [TransactionController::class, 'showPayLoan'])->name('transaction.showPayLoan');
    Route::post('/transaction/pay-loan', [TransactionController::class, 'payLoan'])->name('transaction.payLoan');
});
