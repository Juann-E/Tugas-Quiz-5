<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpanPinjamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return view('anggota.index', [
                'anggota' => null,
                'anggotas' => collect([])
            ]);
        }

        $anggota->load(['tabungans', 'pinjamans.pembayarans']);

        $anggotas = Anggota::with(['tabungans', 'pinjamans.pembayarans'])->get();

        return view('anggota.index', compact('anggota', 'anggotas'));
    }

    public function storeTabungan(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return back()->with('error', 'Anggota tidak ditemukan');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Tabungan::create([
            'anggota_id' => $anggota->id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Tabungan berhasil ditambahkan');
    }

    public function storePinjaman(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return back()->with('error', 'Anggota tidak ditemukan');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Pinjaman::create([
            'anggota_id' => $anggota->id,
            'jumlah' => $request->jumlah,
            'sisa' => $request->jumlah,
            'status' => 'aktif',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pinjaman berhasil ditambahkan');
    }

    public function storePembayaran(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return back()->with('error', 'Anggota tidak ditemukan');
        }

        $request->validate([
            'pinjaman_id' => 'required|exists:pinjamen,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);

        if ($pinjaman->anggota_id != $anggota->id) {
            return back()->with('error', 'Tidak diizinkan');
        }

        $jumlahBayar = $request->jumlah;

        if ($jumlahBayar > $pinjaman->sisa) {
            $jumlahBayar = $pinjaman->sisa;
        }

        $totalTabungan = $anggota->tabungans()->sum('jumlah');

        if ($jumlahBayar > $totalTabungan) {
            return back()->with('error', 'Saldo tabungan tidak mencukupi');
        }

        Tabungan::create([
            'anggota_id' => $anggota->id,
            'jumlah' => -$jumlahBayar,
            'keterangan' => 'Pembayaran pinjaman #' . $pinjaman->id,
        ]);

        Pembayaran::create([
            'pinjaman_id' => $pinjaman->id,
            'jumlah' => $jumlahBayar,
        ]);

        $pinjaman->sisa -= $jumlahBayar;

        if ($pinjaman->sisa <= 0) {
            $pinjaman->sisa = 0;
            $pinjaman->status = 'lunas';
        }

        $pinjaman->save();

        return back()->with('success', 'Pembayaran berhasil dicatat');
    }

    public function show()
    {
        $anggota = Auth::user()->anggota;

        if ($anggota) {
            $anggota->load(['tabungans', 'pinjamans.pembayarans']);
        }

        return view('anggota.show', compact('anggota'));
    }
}