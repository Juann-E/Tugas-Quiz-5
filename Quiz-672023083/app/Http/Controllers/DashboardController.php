<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Tabungan;
use App\Models\PembayaranPinjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // SALDO TABUNGAN
        $tabung = Tabungan::where('user_id', Auth::id())
            ->where('jenis', 'tabung')
            ->sum('nominal');

        $ambil = Tabungan::where('user_id', Auth::id())
            ->where('jenis', 'ambil')
            ->sum('nominal');

        $saldo = $tabung - $ambil;

        // TOTAL PINJAMAN AKTIF
        $totalPinjaman = Pinjaman::where('user_id', Auth::id())
            ->where('status', 'belum_lunas')
            ->sum('sisa_pinjaman');

        // RIWAYAT TABUNGAN
        $riwayatTabungan = Tabungan::where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {

                return [
                    'jenis' => $item->jenis,
                    'nominal' => $item->nominal,
                    'tanggal' => $item->created_at,
                ];
            });

        // RIWAYAT PINJAMAN
        $riwayatPinjaman = Pinjaman::where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {

                return [
                    'jenis' => 'pinjam',
                    'nominal' => $item->nominal,
                    'tanggal' => $item->created_at,
                ];
            });

        // RIWAYAT PEMBAYARAN
        $riwayatPembayaran = PembayaranPinjaman::with('pinjaman')
            ->get()
            ->filter(function ($item) {

                return $item->pinjaman->user_id == Auth::id();
            })
            ->map(function ($item) {

                return [
                    'jenis' => 'bayar pinjaman',
                    'nominal' => $item->nominal_bayar,
                    'tanggal' => $item->created_at,
                ];
            });

        // GABUNG SEMUA RIWAYAT
        $riwayat = collect()
            ->merge($riwayatTabungan)
            ->merge($riwayatPinjaman)
            ->merge($riwayatPembayaran)
            ->sortByDesc('tanggal');

        return view('dashboard', compact(
            'saldo',
            'totalPinjaman',
            'riwayat'
        ));
    }
}