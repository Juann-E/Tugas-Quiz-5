<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Menampilkan Dashboard Utama
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil hanya pinjaman yang masih aktif milik user yang sedang login
        $pinjamanAktif = Loan::where('user_id', $user->id)
                            ->where('status', 'Active')
                            ->get();

        return view('dashboard', compact('user', 'pinjamanAktif'));
    }

    /**
     * Fitur Menabung
     */
    public function tabung(Request $request)
    {
        $request->validate(['jumlah_tabungan' => 'required|numeric|min:1']);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->saldo += $request->jumlah_tabungan;
        $user->save(); // Sekarang Intelephense tidak akan protes lagi

        return back()->with('success', 'Berhasil menabung Rp ' . number_format($request->jumlah_tabungan, 0, ',', '.'));
    }

    /**
     * Fitur Ambil Uang
     */
    public function ambil(Request $request)
    {
        $request->validate(['jumlah_penarikan' => 'required|numeric|min:1']);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->saldo < $request->jumlah_penarikan) {
            return back()->with('error', 'Saldo tidak mencukupi!');
        }

        $user->saldo -= $request->jumlah_penarikan;
        $user->save();

        return back()->with('success', 'Berhasil mengambil uang Rp ' . number_format($request->jumlah_penarikan, 0, ',', '.'));
    }

    /**
     * Fitur Pinjam Uang
     */
    public function pinjam(Request $request)
    {
        $request->validate(['jumlah_pinjaman' => 'required|numeric|min:1']);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $jumlah = $request->jumlah_pinjaman;

        // 1. Update Saldo User
        $user->saldo += $jumlah; 
        $user->save(); // Menggunakan save() lebih konsisten daripada update() di sini

        // 2. Buat Record Pinjaman Baru
        Loan::create([
            'user_id' => $user->id,
            'total_pinjaman' => $jumlah,
            'sisa_pinjaman' => $jumlah,
            'status' => 'Active'
        ]);

        return back()->with('success', 'Pinjaman Rp ' . number_format($jumlah, 0, ',', '.') . ' berhasil ditambahkan ke saldo!');
    }

    /**
     * Fitur Bayar Pinjaman (Mendukung Pembayaran Parsial)
     */
    public function bayar(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'jumlah_pembayaran' => 'required|numeric|min:1'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        /** @var \App\Models\Loan $loan */
        $loan = Loan::findOrFail($request->loan_id);
        $jumlah_bayar = $request->jumlah_pembayaran;

        // Proteksi: Pastikan pinjaman ini milik user yang login
        if ($loan->user_id !== $user->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Cek Sisa Pinjaman
        if ($jumlah_bayar > $loan->sisa_pinjaman) {
            return back()->with('error', 'Jumlah bayar melebihi sisa pinjaman (Sisa: Rp ' . number_format($loan->sisa_pinjaman, 0, ',', '.') . ')');
        }

        // Cek Kecukupan Saldo
        if ($user->saldo < $jumlah_bayar) {
            return back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan pembayaran ini.');
        }

        // --- Eksekusi Pembayaran ---
        
        // 1. Kurangi Saldo User
        $user->saldo -= $jumlah_bayar;
        $user->save();

        // 2. Kurangi Sisa Pinjaman
        $loan->sisa_pinjaman -= $jumlah_bayar;
        
        // 3. Update Status jika lunas
        if ($loan->sisa_pinjaman <= 0) {
            $loan->status = 'Paid';
        }
        $loan->save();

        return back()->with('success', 'Berhasil membayar Rp ' . number_format($jumlah_bayar, 0, ',', '.') . ' untuk pinjaman terpilih.');
    }
}