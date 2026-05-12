<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showTabung()
    {
        return view('transaction.tabung');
    }

    public function processTabung(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil menabung.');
    }

    public function showAmbil()
    {
        $saldo = Auth::user()->balance;
        return view('transaction.ambil', compact('saldo'));
    }

    public function processAmbil(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = Auth::user();

        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi.']);
        }

        $user->balance -= $request->amount;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil mengambil uang.');
    }

    public function showPinjam()
    {
        return view('transaction.pinjam');
    }

    public function processPinjam(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $user = Auth::user();

        Loan::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'remaining_amount' => $request->amount,
            'status' => 'Active',
        ]);

        $user->balance += $request->amount;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil diajukan dan masuk ke saldo.');
    }

    public function showBayar()
    {
        $user = Auth::user();
        $saldo = $user->balance;
        $pinjamanAktif = $user->loans()->where('status', 'Active')->get();

        return view('transaction.bayar', compact('saldo', 'pinjamanAktif'));
    }

    public function processBayar(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $loan = $user->loans()->where('id', $request->loan_id)->where('status', 'Active')->firstOrFail();

        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk melakukan pembayaran.']);
        }

        if ($request->amount > $loan->remaining_amount) {
            return back()->withErrors(['amount' => 'Jumlah pembayaran melebihi sisa pinjaman.']);
        }

        $user->balance -= $request->amount;
        $user->save();

        $loan->remaining_amount -= $request->amount;
        if ($loan->remaining_amount == 0) {
            $loan->status = 'Lunas';
        }
        $loan->save();

        return redirect()->route('dashboard')->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil.');
    }
}
