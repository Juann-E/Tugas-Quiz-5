<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\PembayaranPinjaman;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user           = Auth::user();
        $pinjamanAktif  = $user->pinjamanAktif()->orderBy('created_at', 'desc')->get();

        return view('dashboard.index', compact('user', 'pinjamanAktif'));
    }

    // ─── Tabung ─────────────────────────────────────────────────────────────────

    public function tabung(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah tabungan wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Jumlah minimal Rp 1.000.',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($user, $request) {
            Tabungan::create([
                'user_id'    => $user->id,
                'jumlah'     => $request->jumlah,
                'tipe'       => 'setor',
                'keterangan' => 'Setoran tabungan',
            ]);

            $user->saldo += $request->jumlah;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Tabungan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan.');
    }

    // ─── Ambil ──────────────────────────────────────────────────────────────────

    public function ambil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo,
        ], [
            'jumlah.required' => 'Jumlah penarikan wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Jumlah minimal Rp 1.000.',
            'jumlah.max'      => 'Jumlah melebihi saldo Anda.',
        ]);

        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo tidak mencukupi.']);
        }

        DB::transaction(function () use ($user, $request) {
            Tabungan::create([
                'user_id'    => $user->id,
                'jumlah'     => $request->jumlah,
                'tipe'       => 'tarik',
                'keterangan' => 'Penarikan tabungan',
            ]);

            $user->saldo -= $request->jumlah;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }

    // ─── Pinjam ─────────────────────────────────────────────────────────────────

    public function pinjam(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah pinjaman wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Jumlah minimal Rp 1.000.',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($user, $request) {
            Pinjaman::create([
                'user_id'         => $user->id,
                'jumlah_pinjaman' => $request->jumlah,
                'sisa_pinjaman'   => $request->jumlah,
                'status'          => 'active',
            ]);

            $user->saldo += $request->jumlah;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil dicairkan ke saldo.');
    }

    // ─── Bayar Pinjaman ─────────────────────────────────────────────────────────

    public function bayarPinjaman(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah'      => 'required|numeric|min:1000',
        ], [
            'pinjaman_id.required' => 'Pilih pinjaman yang akan dibayar.',
            'pinjaman_id.exists'   => 'Pinjaman tidak ditemukan.',
            'jumlah.required'      => 'Jumlah pembayaran wajib diisi.',
            'jumlah.numeric'       => 'Jumlah harus berupa angka.',
            'jumlah.min'           => 'Jumlah minimal Rp 1.000.',
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo tidak mencukupi untuk pembayaran ini.']);
        }

        if ($request->jumlah > $pinjaman->sisa_pinjaman) {
            return back()->withErrors(['jumlah' => 'Jumlah pembayaran melebihi sisa pinjaman (Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.') . ').']);
        }

        DB::transaction(function () use ($user, $pinjaman, $request) {
            PembayaranPinjaman::create([
                'pinjaman_id' => $pinjaman->id,
                'user_id'     => $user->id,
                'jumlah_bayar' => $request->jumlah,
            ]);

            $pinjaman->sisa_pinjaman -= $request->jumlah;

            if ($pinjaman->sisa_pinjaman <= 0) {
                $pinjaman->sisa_pinjaman = 0;
                $pinjaman->status        = 'lunas';
            }

            $pinjaman->save();

            $user->saldo -= $request->jumlah;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }
}
