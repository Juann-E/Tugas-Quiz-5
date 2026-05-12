<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user         = Auth::user();
        $pinjamanAktif = $user->pinjamanAktif()->latest()->get();

        return view('dashboard.index', compact('user', 'pinjamanAktif'));
    }

    // ── TABUNG ──────────────────────────────────────────────────
    public function tabung(): View
    {
        return view('dashboard.tabung', ['user' => Auth::user()]);
    }

    public function simpanTabungan(Request $request): RedirectResponse
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ], ['jumlah.min' => 'Jumlah tabungan minimal Rp 1.']);

        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $user->increment('saldo', $request->jumlah);

            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'tabung',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Tabung uang',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Tabungan berhasil disimpan.');
    }

    // ── AMBIL ───────────────────────────────────────────────────
    public function ambil(): View
    {
        return view('dashboard.ambil', ['user' => Auth::user()]);
    }

    public function prosesAmbil(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => "required|numeric|min:1|max:{$user->saldo}",
        ], [
            'jumlah.max' => 'Jumlah penarikan melebihi saldo Anda.',
            'jumlah.min' => 'Jumlah penarikan minimal Rp 1.',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->decrement('saldo', $request->jumlah);

            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'ambil',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Ambil uang',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Penarikan berhasil.');
    }

    // ── PINJAM ──────────────────────────────────────────────────
    public function pinjam(): View
    {
        return view('dashboard.pinjam', ['user' => Auth::user()]);
    }

    public function ajukanPinjaman(Request $request): RedirectResponse
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ], ['jumlah.min' => 'Jumlah pinjaman minimal Rp 1.']);

        DB::transaction(function () use ($request) {
            $user = Auth::user();

            $pinjaman = Pinjaman::create([
                'user_id' => $user->id,
                'jumlah'  => $request->jumlah,
                'sisa'    => $request->jumlah,
                'status'  => 'active',
            ]);

            $user->increment('saldo', $request->jumlah);

            Transaksi::create([
                'user_id'     => $user->id,
                'jenis'       => 'pinjam',
                'jumlah'      => $request->jumlah,
                'pinjaman_id' => $pinjaman->id,
                'keterangan'  => 'Ajukan pinjaman',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil diajukan.');
    }

    // ── BAYAR PINJAMAN ──────────────────────────────────────────
    public function bayarPinjaman(): View
    {
        $user          = Auth::user();
        $pinjamanAktif = $user->pinjamanAktif()->latest()->get();

        return view('dashboard.bayar', compact('user', 'pinjamanAktif'));
    }

    public function prosesBayar(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah'      => "required|numeric|min:1|max:{$user->saldo}",
        ], [
            'jumlah.max' => 'Jumlah pembayaran melebihi saldo Anda.',
            'jumlah.min' => 'Jumlah pembayaran minimal Rp 1.',
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        $bayar = min($request->jumlah, $pinjaman->sisa);

        DB::transaction(function () use ($bayar, $pinjaman, $user) {
            $sisaBaru = $pinjaman->sisa - $bayar;

            $pinjaman->update([
                'sisa'   => $sisaBaru,
                'status' => $sisaBaru <= 0 ? 'lunas' : 'active',
            ]);

            $user->decrement('saldo', $bayar);

            Transaksi::create([
                'user_id'     => $user->id,
                'jenis'       => 'bayar_pinjaman',
                'jumlah'      => $bayar,
                'pinjaman_id' => $pinjaman->id,
                'keterangan'  => 'Bayar pinjaman',
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', "Pembayaran pinjaman sebesar Rp " . number_format($bayar, 0, ',', '.') . " berhasil.");
    }
}
