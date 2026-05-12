<?php
namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function index() {
        $user = Auth::user();
        $pinjamanAktif = Pinjaman::where('user_id', $user->id)
                                 ->where('status', 'aktif')
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        return view('dashboard', compact('user', 'pinjamanAktif'));
    }

    public function tabung(Request $request) {
        $request->validate(['jumlah' => 'required|numeric|min:1000'], [
            'jumlah.min' => 'Minimal tabungan Rp 1.000.',
        ]);
        $user = Auth::user();
        DB::transaction(function () use ($user, $request) {
            $user->saldo += $request->jumlah;
            $user->save();
            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'tabung',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Tabungan uang',
            ]);
        });
        return redirect()->route('dashboard')->with('success', 'Tabungan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan.');
    }

    public function ambil(Request $request) {
        $user = Auth::user();
        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo,
        ], [
            'jumlah.min' => 'Minimal penarikan Rp 1.000.',
            'jumlah.max' => 'Saldo tidak mencukupi.',
        ]);
        DB::transaction(function () use ($user, $request) {
            $user->saldo -= $request->jumlah;
            $user->save();
            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'ambil',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Penarikan uang',
            ]);
        });
        return redirect()->route('dashboard')->with('success', 'Penarikan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }

    public function pinjam(Request $request) {
        $request->validate(['jumlah' => 'required|numeric|min:1000'], [
            'jumlah.min' => 'Minimal pinjaman Rp 1.000.',
        ]);
        $user = Auth::user();
        DB::transaction(function () use ($user, $request) {
            $user->saldo += $request->jumlah;
            $user->save();
            Pinjaman::create([
                'user_id'        => $user->id,
                'total_pinjaman' => $request->jumlah,
                'sisa_pinjaman'  => $request->jumlah,
                'status'         => 'aktif',
            ]);
            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'pinjam',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Pengajuan pinjaman',
            ]);
        });
        return redirect()->route('dashboard')->with('success', 'Pinjaman Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan.');
    }

    public function bayarPinjaman(Request $request) {
        $user = Auth::user();
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah'      => 'required|numeric|min:1000',
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
                            ->where('user_id', $user->id)
                            ->where('status', 'aktif')
                            ->firstOrFail();

        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo tidak mencukupi.']);
        }
        if ($request->jumlah > $pinjaman->sisa_pinjaman) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi sisa pinjaman Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.') . '.']);
        }

        DB::transaction(function () use ($user, $pinjaman, $request) {
            $user->saldo -= $request->jumlah;
            $user->save();
            $pinjaman->sisa_pinjaman -= $request->jumlah;
            if ($pinjaman->sisa_pinjaman <= 0) {
                $pinjaman->sisa_pinjaman = 0;
                $pinjaman->status = 'lunas';
            }
            $pinjaman->save();
            Transaksi::create([
                'user_id'    => $user->id,
                'jenis'      => 'bayar_pinjaman',
                'jumlah'     => $request->jumlah,
                'keterangan' => 'Bayar pinjaman #' . $pinjaman->id,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }
}