<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Pinjaman;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // TABUNG
        $tabung = Tabungan::where('user_id', $userId)
            ->where('jenis', 'tabung')
            ->sum('jumlah');

        // AMBIL
        $ambil = Tabungan::where('user_id', $userId)
            ->where('jenis', 'ambil')
            ->sum('jumlah');

        // PINJAM (uang masuk → saldo naik)
        $pinjam = Pinjaman::where('user_id', $userId)
            ->sum('jumlah');

        // BAYAR PINJAMAN (uang keluar → saldo turun)
        $bayar = Pembayaran::whereHas('pinjaman', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->sum('jumlah_bayar');

        // SALDO FINAL
        $saldo = ($tabung + $pinjam) - ($ambil + $bayar);

        $pinjaman = Pinjaman::where('user_id', $userId)->get();

        return view('dashboard', compact('saldo', 'pinjaman'));
    }
}