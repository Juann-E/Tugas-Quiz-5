<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mengambil pinjaman yang masih aktif [cite: 28, 48]
        $activeLoans = $user->loans()->where('status', 'active')->get(); 
        return view('dashboard', compact('user', 'activeLoans'));
    }

    public function tabung(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = Auth::user();
        $user->balance += $request->amount; // Menambah saldo
        $user->save();

        return back()->with('success', 'Berhasil menyimpan tabungan.');
    }

    public function ambil(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = Auth::user();

        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $user->balance -= $request->amount; // Mengurangi saldo
        $user->save();

        return back()->with('success', 'Berhasil menarik uang.');
    }

    public function pinjam(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = Auth::user();

        // Pinjaman langsung masuk ke saldo [cite: 66]
        $user->balance += $request->amount; 
        $user->save();

        // Mencatat pinjaman baru
        Loan::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'remaining_amount' => $request->amount,
            'status' => 'active'
        ]);

        return back()->with('success', 'Pinjaman berhasil diajukan dan ditambahkan ke saldo.');
    }

    public function bayar(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $loan = Loan::where('id', $request->loan_id)->where('user_id', $user->id)->firstOrFail();

        // Validasi pembayaran
        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi untuk membayar.');
        }
        if ($request->amount > $loan->remaining_amount) {
            return back()->with('error', 'Jumlah bayar melebihi sisa pinjaman.');
        }

        // Kurangi saldo pengguna
        $user->balance -= $request->amount;
        $user->save();

        // Kurangi sisa pinjaman [cite: 116, 130]
        $loan->remaining_amount -= $request->amount;
        
        // Jika lunas, ubah status [cite: 36, 114]
        if ($loan->remaining_amount <= 0) {
            $loan->status = 'paid';
        }
        $loan->save();

        return back()->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil.');
    }
}