<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Pinjamanss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $tabungan = $user->tabungan;

        if (!$tabungan) {
            $tabungan = Tabungan::create([
                'user_id' => $user->id,
                'saldo'   => 0,
            ]);
        }

        $pinjamanss = Pinjamanss::where('user_id', $user->id)->get();

        return view('dashboard.index', compact('tabungan', 'pinjamanss'));
    }

    public function tabung(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $tabungan = $user->tabungan;

        if (!$tabungan) {
            $tabungan = Tabungan::create([
                'user_id' => $user->id,
                'saldo'   => 0,
            ]);
        }

        $tabungan->saldo += $request->jumlah;
        $tabungan->save();

        return redirect()->route('dashboard')->with('success', 'Tabungan berhasil ditambahkan.');
    }

    public function ambil(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $tabungan = $user->tabungan;

        if (!$tabungan || $tabungan->saldo < $request->jumlah) {
            return redirect()->route('dashboard')->with('error', 'Saldo tidak mencukupi.');
        }

        $tabungan->saldo -= $request->jumlah;
        $tabungan->save();

        return redirect()->route('dashboard')->with('success', 'Uang berhasil diambil.');
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $tabungan = $user->tabungan;

        if (!$tabungan) {
            $tabungan = Tabungan::create([
                'user_id' => $user->id,
                'saldo'   => 0,
            ]);
        }

        $tabungan->saldo += $request->jumlah;
        $tabungan->save();

        Pinjamanss::create([
            'user_id'        => $user->id,
            'total_pinjaman' => $request->jumlah,
            'sisa_pinjaman'  => $request->jumlah,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil diajukan.');
    }

    public function bayarPinjaman(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjamanss,id',
            'jumlah'      => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $tabungan = $user->tabungan;
        $pinjaman = Pinjamanss::findOrFail($request->pinjaman_id);

        if (!$tabungan || $tabungan->saldo < $request->jumlah) {
            return redirect()->route('dashboard')->with('error', 'Saldo tidak mencukupi.');
        }

        if ($request->jumlah > $pinjaman->sisa_pinjaman) {
            return redirect()->route('dashboard')->with('error', 'Jumlah pembayaran melebihi sisa pinjaman.');
        }

        $tabungan->saldo -= $request->jumlah;
        $tabungan->save();

        $pinjaman->sisa_pinjaman -= $request->jumlah;
        $pinjaman->save();

        return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil dibayar.');
    }
}