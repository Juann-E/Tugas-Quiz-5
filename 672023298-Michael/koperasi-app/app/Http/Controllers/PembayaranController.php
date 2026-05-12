<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Penarikan;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function create()
    {
        $masuk = Tabungan::where('user_id', Auth::id())
            ->sum('jumlah');

        $keluar = Penarikan::where('user_id', Auth::id())
            ->sum('jumlah');

        $pinjamanTotal = Pinjaman::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldo = $masuk + $pinjamanTotal - $keluar;

        $pinjaman = Pinjaman::where('user_id', Auth::id())
            ->where('status', 'Active')
            ->get();

        return view('pembayaran.create', compact('saldo', 'pinjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);

        $masuk = Tabungan::where('user_id', Auth::id())
            ->sum('jumlah');

        $keluar = Penarikan::where('user_id', Auth::id())
            ->sum('jumlah');

        $pinjamanTotal = Pinjaman::where('user_id', Auth::id())
            ->sum('jumlah');

        $saldo = $masuk + $pinjamanTotal - $keluar;

        if ($request->jumlah > $saldo) {

            return back()->with('error', 'Saldo tidak cukup');
        }

        if ($request->jumlah > $pinjaman->sisa_pinjaman) {

            return back()->with('error', 'Pembayaran melebihi sisa pinjaman');
        }

        $pinjaman->sisa_pinjaman =
            $pinjaman->sisa_pinjaman - $request->jumlah;

        if ($pinjaman->sisa_pinjaman <= 0) {

            $pinjaman->status = 'Lunas';
        }

        $pinjaman->save();

        Penarikan::create([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/dashboard')
            ->with('success', 'Pembayaran pinjaman berhasil');
    }
}
