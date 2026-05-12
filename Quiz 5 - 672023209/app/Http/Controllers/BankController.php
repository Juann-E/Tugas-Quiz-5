<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index()
    {
        $activeLoans = Loan::where('user_id', Auth::id())->where('status', 'active')->get();
        return view('bank.index', compact('activeLoans'));
    }

    // --- TABUNG ---
    public function tabungForm()
    {
        return view('bank.tabung');
    }

    public function tabungProcess(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();

        return redirect('/dashboard')->with('success', 'Berhasil menabung sebesar Rp ' . number_format($request->amount, 0, ',', '.'));
    }

    // --- AMBIL TABUNGAN ---
    public function ambilTabunganForm()
    {
        return view('bank.ambil');
    }

    public function ambilTabunganProcess(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->balance < $request->amount) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        $user->balance -= $request->amount;
        $user->save();

        return redirect('/dashboard')->with('success', 'Berhasil menarik tabungan sebesar Rp ' . number_format($request->amount, 0, ',', '.'));
    }

    // --- PINJAM ---
    public function pinjamForm()
    {
        return view('bank.pinjam');
    }

    public function pinjamProcess(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Buat pinjaman baru (bisa lebih dari satu)
        Loan::create([
            'user_id' => $user->id,
            'total_amount' => $request->amount,
            'remaining_amount' => $request->amount,
            'status' => 'active'
        ]);

        // Tambah saldo user
        $user->balance += $request->amount;
        $user->save();

        return redirect('/dashboard')->with('success', 'Berhasil meminjam uang sebesar Rp ' . number_format($request->amount, 0, ',', '.') . '. Saldo Anda telah bertambah.');
    }

    // --- BAYAR PINJAMAN ---
    public function bayarPinjamanForm()
    {
        $activeLoans = Loan::where('user_id', Auth::id())->where('status', 'active')->get();
        return view('bank.bayarPinjaman', compact('activeLoans'));
    }

    public function bayarPinjamanProcess(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1000'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $amount = $request->amount;

        $activeLoan = Loan::where('id', $request->loan_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$activeLoan) {
            return redirect()->back()->with('error', 'Pinjaman tidak valid atau sudah lunas.');
        }

        if ($amount > $activeLoan->remaining_amount) {
            return redirect()->back()->with('error', 'Nominal melebihi sisa pinjaman Anda (Rp ' . number_format($activeLoan->remaining_amount, 0, ',', '.') . ').');
        }

        if ($user->balance < $amount) {
            return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk membayar pinjaman ini.');
        }

        // Kurangi saldo
        $user->balance -= $amount;
        $user->save();

        // Kurangi sisa pinjaman
        $activeLoan->remaining_amount -= $amount;

        if ($activeLoan->remaining_amount <= 0) {
            $activeLoan->status = 'paid';
        }

        $activeLoan->save();

        if ($activeLoan->status == 'paid') {
            return redirect('/dashboard')->with('success', 'Pinjaman Anda telah lunas! Pembayaran sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dipotong dari saldo.');
        }

        return redirect('/dashboard')->with('success', 'Berhasil membayar pinjaman sebesar Rp ' . number_format($amount, 0, ',', '.'));
    }
}
