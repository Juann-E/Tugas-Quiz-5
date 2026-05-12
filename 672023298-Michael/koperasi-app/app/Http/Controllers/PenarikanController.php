<?php

namespace App\Http\Controllers;

use App\Models\Penarikan;
use App\Models\Pinjaman;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function create()
    {
        $saldoMasuk = Tabungan::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldoKeluar = Penarikan::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldoPinjaman = Pinjaman::where('user_id', Auth::id())
            ->sum('jumlah');

        // SALDO TOTAL
        $saldo = $saldoMasuk + $saldoPinjaman - $saldoKeluar;

        return view('penarikan.create', compact('saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $saldoMasuk = Tabungan::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldoKeluar = Penarikan::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldoPinjaman = Pinjaman::where('user_id', Auth::id())
            ->sum('jumlah');

        // SALDO TOTAL
        $saldo = $saldoMasuk + $saldoPinjaman - $saldoKeluar;

        // VALIDASI SALDO
        if ($request->jumlah > $saldo) {

            return back()->with('error', 'Saldo tidak cukup');
        }

        // SIMPAN PENARIKAN
        Penarikan::create([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/dashboard');
    }
}
