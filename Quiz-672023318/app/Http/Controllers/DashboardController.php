<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Tabungan;
use App\Models\PembayaranPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pinjamanAktif = Pinjaman::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.index', compact('user', 'pinjamanAktif'));
    }

    // ========== TABUNG ==========
    public function tabung(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah tabungan wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Minimal tabungan adalah Rp 1.000.',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($user, $request) {
            $saldoSebelum = $user->saldo;
            $saldoSesudah = $saldoSebelum + $request->jumlah;

            Tabungan::create([
                'user_id'       => $user->id,
                'jumlah'        => $request->jumlah,
                'tipe'          => 'setor',
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan'    => 'Setoran tabungan',
            ]);

            $user->update(['saldo' => $saldoSesudah]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Tabungan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan.');
    }

    // ========== AMBIL ==========
    public function ambil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo,
        ], [
            'jumlah.required' => 'Jumlah penarikan wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Minimal penarikan adalah Rp 1.000.',
            'jumlah.max'      => 'Jumlah penarikan melebihi saldo Anda.',
        ]);

        DB::transaction(function () use ($user, $request) {
            $saldoSebelum = $user->saldo;
            $saldoSesudah = $saldoSebelum - $request->jumlah;

            Tabungan::create([
                'user_id'       => $user->id,
                'jumlah'        => $request->jumlah,
                'tipe'          => 'tarik',
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan'    => 'Penarikan tabungan',
            ]);

            $user->update(['saldo' => $saldoSesudah]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }

    // ========== PINJAM ==========
    public function pinjam(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
        ], [
            'jumlah.required' => 'Jumlah pinjaman wajib diisi.',
            'jumlah.numeric'  => 'Jumlah harus berupa angka.',
            'jumlah.min'      => 'Minimal pinjaman adalah Rp 10.000.',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($user, $request) {
            // Buat record pinjaman
            Pinjaman::create([
                'user_id'         => $user->id,
                'jumlah_pinjaman' => $request->jumlah,
                'sisa_pinjaman'   => $request->jumlah,
                'status'          => 'active',
                'tanggal_pinjam'  => now()->toDateString(),
            ]);

            // Tambahkan ke saldo
            $user->update(['saldo' => $user->saldo + $request->jumlah]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan dan ditambahkan ke saldo.');
    }

    // ========== BAYAR PINJAMAN ==========
    public function bayarPinjaman(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah'      => 'required|numeric|min:1000',
        ], [
            'pinjaman_id.required' => 'Pilih pinjaman yang ingin dibayar.',
            'pinjaman_id.exists'   => 'Pinjaman tidak ditemukan.',
            'jumlah.required'      => 'Jumlah pembayaran wajib diisi.',
            'jumlah.numeric'       => 'Jumlah harus berupa angka.',
            'jumlah.min'           => 'Minimal pembayaran adalah Rp 1.000.',
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo tidak mencukupi untuk pembayaran ini.'])->with('modal', 'bayar');
        }

        if ($request->jumlah > $pinjaman->sisa_pinjaman) {
            return back()->withErrors(['jumlah' => 'Jumlah pembayaran melebihi sisa pinjaman (Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.') . ').'])->with('modal', 'bayar');
        }

        DB::transaction(function () use ($user, $pinjaman, $request) {
            $sisaSebelum = $pinjaman->sisa_pinjaman;
            $sisaSesudah = $sisaSebelum - $request->jumlah;

            // Catat pembayaran
            PembayaranPinjaman::create([
                'pinjaman_id'  => $pinjaman->id,
                'user_id'      => $user->id,
                'jumlah_bayar' => $request->jumlah,
                'sisa_sebelum' => $sisaSebelum,
                'sisa_sesudah' => $sisaSesudah,
            ]);

            // Update sisa pinjaman
            $pinjaman->update([
                'sisa_pinjaman' => $sisaSesudah,
                'status'        => $sisaSesudah <= 0 ? 'lunas' : 'active',
            ]);

            // Kurangi saldo user
            $user->update(['saldo' => $user->saldo - $request->jumlah]);
        });

        $pesan = 'Pembayaran pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.';
        if ($pinjaman->fresh()->status === 'lunas') {
            $pesan .= ' Pinjaman ini telah LUNAS!';
        }

        return redirect()->route('dashboard')->with('success', $pesan);
    }
}
