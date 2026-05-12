<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    /**
     * Menampilkan Dashboard Utama
     * Menampilkan saldo user dan daftar pinjaman yang masih aktif.
     */
    public function index()
    {
        $user = Auth::user();
        // Mengambil pinjaman yang statusnya masih 'Active'
        $pinjamanAktif = Pinjaman::where('user_id', $user->id)
                                 ->where('status', 'Active')
                                 ->get();

        return view('dashboard.dashboard', compact('user', 'pinjamanAktif'));
    }

    /**
     * Modul Tabung Uang
     * Menambah jumlah saldo pada akun pengguna.
     */
    public function tabung(Request $request)
    {
        $request->validate(['jumlah_tabungan' => 'required|integer|min:1']);
        
        // Untuk Tabung
        User::where('id', Auth::id())->increment('saldo', $request->jumlah_tabungan);

        return back()->with('success', 'Tabungan sebesar Rp ' . number_format($request->jumlah_tabungan) . ' berhasil disimpan');
    }

    /**
     * Modul Ambil Uang
     * Mengurangi saldo pengguna dengan validasi kecukupan saldo.
     */
    public function ambil(Request $request)
    {
        $request->validate(['jumlah_penarikan' => 'required|integer|min:1']);
        
        $user = Auth::user();

        if ($user->saldo < $request->jumlah_penarikan) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini');
        }
        User::where('id', Auth::id())->decrement('saldo', $request->jumlah_penarikan);
        return back()->with('success', 'Penarikan berhasil diproses');
    }

    /**
     * Modul Ajukan Pinjaman
     * Saldo bertambah dan record pinjaman baru tercipta di database.
     */
    public function pinjam(Request $request)
    {
        $request->validate(['jumlah_pinjaman' => 'required|integer|min:1']);

        DB::transaction(function () use ($request) {
            $user = Auth::user();
            // 1. Tambah saldo user dari hasil pinjaman
            User::where('id', Auth::id())->increment('saldo', $request->jumlah_pinjaman);

            // 2. Buat catatan pinjaman baru
            Pinjaman::create([
                'user_id' => $user->id,
                'tanggal' => now(),
                'total_pinjaman' => $request->jumlah_pinjaman,
                'sisa_pinjaman' => $request->jumlah_pinjaman,
                'status' => 'Active'
            ]);
        });

        return back()->with('success', 'Pinjaman berhasil diajukan dan saldo telah bertambah');
    }

    /**
     * Modul Bayar Pinjaman
     * Mengurangi saldo untuk memotong sisa pinjaman spesifik.
     */
    public function bayar(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjamans,id',
            'jumlah_pembayaran' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = Auth::user();
                $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
                                    ->where('user_id', $user->id)
                                    ->lockForUpdate()
                                    ->firstOrFail();

                // Validasi saldo cukup untuk membayar
                if ($user->saldo < $request->jumlah_pembayaran) {
                    throw new \Exception('Saldo Anda tidak mencukupi untuk melakukan pembayaran');
                }

                // Validasi pembayaran tidak melebihi sisa hutang
                if ($request->jumlah_pembayaran > $pinjaman->sisa_pinjaman) {
                    throw new \Exception('Jumlah pembayaran melebihi sisa pinjaman aktif');
                }
                
                // 1. Potong saldo user (Gunakan decrement dan variabel yang benar)
                User::where('id', Auth::id())->decrement('saldo', $request->jumlah_pembayaran);

                // 2. Potong sisa hutang pada pinjaman terpilih
                $pinjaman->decrement('sisa_pinjaman', $request->jumlah_pembayaran);

                // 3. Cek pelunasan
                // Refresh data pinjaman untuk mendapatkan sisa_pinjaman terbaru setelah decrement
                $pinjaman->refresh();
                if ($pinjaman->sisa_pinjaman <= 0) {
                    $pinjaman->update(['status' => 'Lunas']);
                }
            });

            return back()->with('success', 'Pembayaran pinjaman berhasil');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }   
}