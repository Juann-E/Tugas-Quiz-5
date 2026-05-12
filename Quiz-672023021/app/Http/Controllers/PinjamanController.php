<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\PembayaranPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    public function pinjamForm()
    {
        $user = Auth::user();
        return view('pinjaman.pinjam', compact('user'));
    }


    public function pinjam(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah pinjaman wajib diisi',
            'jumlah.min'      => 'Minimal pinjaman Rp 1.000',
        ]);

        DB::transaction(function () use ($request) {
            $user = Auth::user();

            Pinjaman::create([
                'user_id'         => $user->id,
                'jumlah_pinjaman' => $request->jumlah,
                'sisa_pinjaman'   => $request->jumlah,
                'tanggal_pinjam'  => now()->toDateString(),
                'status'          => 'active',
            ]);

            $user->saldo += $request->jumlah;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan dan ditambahkan ke saldo.');
    }

    public function bayarForm()
    {
        $user     = Auth::user();
        $pinjaman = $user->pinjaman()->where('status', 'active')->latest()->get();

        if ($pinjaman->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki pinjaman aktif.');
        }

        return view('pinjaman.bayar', compact('user', 'pinjaman'));
    }

    public function bayar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'pinjaman_id'  => 'required|exists:pinjaman,id',
            'jumlah_bayar' => 'required|numeric|min:1000',
        ], [
            'pinjaman_id.required'  => 'Pilih pinjaman yang ingin dibayar',
            'jumlah_bayar.required' => 'Jumlah pembayaran wajib diisi',
            'jumlah_bayar.min'      => 'Minimal pembayaran Rp 1.000',
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        if ($request->jumlah_bayar > $pinjaman->sisa_pinjaman) {
            return back()->withErrors([
                'jumlah_bayar' => 'Jumlah bayar melebihi sisa pinjaman Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.')
            ])->withInput();
        }

        if ($request->jumlah_bayar > $user->saldo) {
            return back()->withErrors([
                'jumlah_bayar' => 'Saldo Anda tidak mencukupi untuk membayar sejumlah ini.'
            ])->withInput();
        }

        DB::transaction(function () use ($request, $user, $pinjaman) {
            $sisa_sebelum = $pinjaman->sisa_pinjaman;
            $sisa_sesudah = $sisa_sebelum - $request->jumlah_bayar;

            PembayaranPinjaman::create([
                'pinjaman_id'   => $pinjaman->id,
                'user_id'       => $user->id,
                'jumlah_bayar'  => $request->jumlah_bayar,
                'sisa_sebelum'  => $sisa_sebelum,
                'sisa_sesudah'  => $sisa_sesudah,
                'tanggal_bayar' => now()->toDateString(),
            ]);

            $pinjaman->sisa_pinjaman = $sisa_sesudah;
            if ($sisa_sesudah <= 0) {
                $pinjaman->status = 'lunas';
            }
            $pinjaman->save();

            $user->saldo -= $request->jumlah_bayar;
            $user->save();
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->jumlah_bayar, 0, ',', '.') . ' berhasil.');
    }
}