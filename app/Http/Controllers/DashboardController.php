<?php

namespace App\Http\Controllers;

use App\Models\pinjaman;
use App\Models\simpanan;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Total simpanan
        $totalSimpanan = simpanan::where('user_id', $userId)->sum('jumlah');

        // Saldo tabungan = simpanan jenis tabungan saja
        $saldoTabungan = simpanan::where('user_id', $userId)
            ->where('jenis_simpanan', 'tabungan')
            ->sum('jumlah');

        // Sisa pinjaman aktif
        $sisaPinjaman = pinjaman::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->sum('sisa_pinjaman');

        // Angsuran bulan ini = total angsuran semua pinjaman aktif
        $angsuranBulanIni = pinjaman::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('angsuran_per_bulan');

        // Pinjaman aktif untuk card list
        $pinjamanAktif = pinjaman::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->latest()
            ->take(3)
            ->get();

        // Simpanan terbaru
        $simpananTerbaru = simpanan::where('user_id', $userId)
            ->latest('tanggal_simpan')
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalSimpanan',
            'saldoTabungan',
            'sisaPinjaman',
            'angsuranBulanIni',
            'pinjamanAktif',
            'simpananTerbaru'
        ));
    }
}