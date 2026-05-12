<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function deposit(Request $request) {
    $user = Auth::user();
    
    // Pastikan 'amount' sesuai dengan name="amount" di view tabung.blade.php
    $user->balance += $request->amount; 
    $user->save();

    // Mengalihkan kembali ke dashboard agar saldo yang baru terlihat
    return redirect()->route('dashboard')->with('success', 'Simpan tabungan berhasil!');
}

public function withdraw(Request $request) {
    $user = Auth::user();

    // 1. Gunakan 'amount' agar sinkron dengan file blade
    $amount = $request->amount;

    // 2. Validasi saldo agar tidak bisa ambil melebihi saldo yang ada
    if ($user->balance < $amount) {
        return redirect()->back()->with('error', 'Saldo tidak mencukupi!');
    }

    // 3. Kurangi saldo
    $user->balance -= $amount;
    $user->save();

    // 4. Alihkan ke dashboard agar perubahan saldo terlihat [cite: 71]
    return redirect()->route('dashboard')->with('success', 'Penarikan uang berhasil!');
}

public function loan(Request $request) {
    $user = Auth::user();
    
    // Gunakan $request->amount agar sinkron dengan Blade
    $amount = $request->amount;

    // 1. Buat data pinjaman baru
    Loan::create([
        'user_id' => $user->id,
        'total_pinjaman' => $amount,
        'sisa_pinjaman' => $amount,
        'status' => 'Active'
    ]);

    // 2. Tambahkan ke saldo user
    $user->balance += $amount;
    $user->save();

    // Redirect ke dashboard agar tabel langsung terupdate
    return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil diajukan!');
}

public function repay(Request $request) {
    $user = Auth::user();
    $loan = Loan::find($request->loan_id);
    
    // Gunakan $request->amount agar sinkron dengan Blade
    $amount = $request->amount;

    if ($user->balance < $amount) {
        return redirect()->back()->with('error', 'Saldo tidak cukup untuk bayar!');
    }

    // Kurangi sisa pinjaman dan saldo user
    $loan->sisa_pinjaman -= $amount;
    $user->balance -= $amount;

    // Jika sudah lunas atau sisa minus, set jadi 0 dan status Paid
    if ($loan->sisa_pinjaman <= 0) {
        $loan->sisa_pinjaman = 0;
        $loan->status = 'Paid';
    }

    $loan->save();
    $user->save();

    return redirect()->route('dashboard')->with('success', "Pembayaran berhasil!");
}

public function showDepositForm() {
    return view('tabung');
}

public function showWithdrawForm() {
    return view('ambil', ['user' => Auth::user()]);
}

public function showLoanForm() {
    return view('pinjam');
}
public function showRepayForm()
{
    $user = Auth::user(); // Ambil data user yang sedang login
    
    // Ambil semua pinjaman milik user tersebut yang statusnya masih 'Active'
    $loans = $user->loans()->where('status', 'Active')->get(); 

    // Kirim data user dan loans ke halaman bayar.blade.php
    return view('bayar', compact('user', 'loans'));
}
}
