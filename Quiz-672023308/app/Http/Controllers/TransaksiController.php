<?php
namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // ======== TABUNG ========
    public function tabung(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah tabungan wajib diisi',
            'jumlah.min'      => 'Minimal tabungan Rp 1.000',
        ]);

        $user = Auth::user();
        $user->increment('saldo', $request->jumlah);

        Transaksi::create([
            'user_id'    => $user->id,
            'jenis'      => 'tabung',
            'jumlah'     => $request->jumlah,
            'keterangan' => 'Tabung uang',
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Tabungan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan!');
    }

    // ======== AMBIL ========
    public function ambil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo,
        ], [
            'jumlah.required' => 'Jumlah penarikan wajib diisi',
            'jumlah.min'      => 'Minimal penarikan Rp 1.000',
            'jumlah.max'      => 'Saldo tidak mencukupi',
        ]);

        $user->decrement('saldo', $request->jumlah);

        Transaksi::create([
            'user_id'    => $user->id,
            'jenis'      => 'ambil',
            'jumlah'     => $request->jumlah,
            'keterangan' => 'Ambil uang',
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil!');
    }

    // ======== PINJAM ========
    public function pinjam(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah pinjaman wajib diisi',
            'jumlah.min'      => 'Minimal pinjaman Rp 1.000',
        ]);

        $user = Auth::user();

        // Buat record pinjaman
        $pinjaman = Pinjaman::create([
            'user_id' => $user->id,
            'jumlah'  => $request->jumlah,
            'sisa'    => $request->jumlah,
            'status'  => 'active',
            'tanggal' => now()->toDateString(),
        ]);

        // Tambah saldo user
        $user->increment('saldo', $request->jumlah);

        Transaksi::create([
            'user_id'     => $user->id,
            'pinjaman_id' => $pinjaman->id,
            'jenis'       => 'pinjam',
            'jumlah'      => $request->jumlah,
            'keterangan'  => 'Pinjam uang',
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan!');
    }

    // ======== BAYAR PINJAMAN ========
    public function bayar(Request $request)
    {
        $user     = Auth::user();
        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
                            ->where('user_id', $user->id)
                            ->where('status', 'active')
                            ->firstOrFail();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . min($user->saldo, $pinjaman->sisa),
        ], [
            'jumlah.required' => 'Jumlah pembayaran wajib diisi',
            'jumlah.min'      => 'Minimal pembayaran Rp 1.000',
            'jumlah.max'      => 'Jumlah melebihi saldo atau sisa pinjaman',
        ]);

        $bayar = $request->jumlah;

        // Kurangi saldo user
        $user->decrement('saldo', $bayar);

        // Kurangi sisa pinjaman
        $pinjaman->sisa -= $bayar;

        // Kalau lunas, ubah status
        if ($pinjaman->sisa <= 0) {
            $pinjaman->sisa   = 0;
            $pinjaman->status = 'lunas';
        }
        $pinjaman->save();

        Transaksi::create([
            'user_id'     => $user->id,
            'pinjaman_id' => $pinjaman->id,
            'jenis'       => 'bayar',
            'jumlah'      => $bayar,
            'keterangan'  => 'Bayar pinjaman #' . $pinjaman->id,
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($bayar, 0, ',', '.') . ' berhasil!');
    }
}