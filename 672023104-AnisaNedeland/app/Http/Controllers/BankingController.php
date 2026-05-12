<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class BankingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $loans = $user->loans()->where('status', 'active')->get();
        return view('dashboard', compact('user', 'loans'));
    }

    public function tabung(Request $request)
    {
        $request->validate(['nominal' => 'required|numeric|min:1000']);
        
        $user = Auth::user();
        $user->saldo += $request->nominal;
        $user->save();

        // TAMBAHKAN KODE INI YANG TADI KETINGGALAN
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'tabung',
            'amount' => $request->nominal,
            'description' => 'Menabung uang ke saldo utama'
        ]);

        // Pakai redirect ke dashboard biar datanya langsung ter-refresh
        return redirect()->route('dashboard')->with('success', 'Berhasil menabung uang!');
    }

    public function ambil(Request $request) {
        $request->validate(['nominal' => 'required|numeric|min:1']);
        $user = Auth::user();

        if ($user->saldo < $request->nominal) {
            return back()->withErrors(['nominal' => 'Saldo tidak mencukupi!']);
        }

        $user->decrement('saldo', $request->nominal);

        // CATAT KE RIWAYAT
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'ambil',
            'amount' => $request->nominal,
            'description' => 'Penarikan tunai'
        ]);

        return redirect()->route('dashboard')->with('success', 'Uang berhasil diambil!');
    }

    public function pinjam(Request $request) {
        // 1. Validasi awal (harus angka dan minimal 1 rupiah)
        $request->validate(['nominal' => 'required|numeric|min:1']);
        
        $user = Auth::user();
        
        // 2. LOGIC LIMIT: Hitung batas maksimal (50% dari saldo)
        $limitPinjaman = $user->saldo * 0.5;

        // 3. CEK VALIDASI LIMIT
        if ($request->nominal > $limitPinjaman) {
            return back()->withErrors(['nominal' => 'Pinjaman ditolak! Maksimal pinjaman adalah 50% dari saldo Anda (Rp ' . number_format($limitPinjaman, 0, ',', '.') . ').']);
        }

        // 4. Jika lolos, buat data pinjaman
        $user->loans()->create([
            'total_pinjaman' => $request->nominal,
            'sisa_pinjaman' => $request->nominal,
            'status' => 'active',
        ]);

        // 5. Tambah saldo user
        $user->increment('saldo', $request->nominal);

        // 6. Catat ke riwayat transaksi
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'pinjam',
            'amount' => $request->nominal,
            'description' => 'Pencairan pinjaman (Limit 50% saldo)'
        ]);

        return redirect()->route('dashboard')->with('success', 'Pinjaman berhasil dicairkan!');
    }

    public function bayar(Request $request) {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'nominal' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $loan = $user->loans()->findOrFail($request->loan_id);

        if ($user->saldo < $request->nominal) {
            return back()->withErrors(['nominal' => 'Saldo tidak cukup untuk membayar!']);
        }

        if ($request->nominal > $loan->sisa_pinjaman) {
            return back()->withErrors(['nominal' => 'Nominal bayar melebihi sisa pinjaman!']);
        }

        $user->decrement('saldo', $request->nominal);
        $loan->decrement('sisa_pinjaman', $request->nominal);

        if ($loan->sisa_pinjaman <= 0) {
            $loan->update(['status' => 'paid']);
        }

        // CATAT KE RIWAYAT
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'bayar',
            'amount' => $request->nominal,
            'description' => 'Pembayaran angsuran pinjaman'
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function showTabung() {
        return view('banking.tabung');
    }

    public function showAmbil() {
        $user = Auth::user();
        return view('banking.ambil', compact('user'));
    }

    public function showPinjam() {
        return view('banking.pinjam');
    }

    public function showBayar() {
        $user = Auth::user();
        $loans = $user->loans()->where('status', 'active')->get();
        return view('banking.bayar', compact('loans', 'user'));
    }

    public function generatePDF() {
        $user = Auth::user();
        // Ambil SEMUA transaksi user untuk laporan lengkap
        $transactions = $user->transactions()->latest()->get();

        // Data yang akan dikirim ke tampilan PDF
        $data = [
            'user' => $user,
            'transactions' => $transactions,
            'date' => date('d/m/Y'),
        ];

        // Load view khusus laporan dan download sebagai file PDF
        $pdf = Pdf::loadView('banking.report_pdf', $data);
        
        return $pdf->download('Rekening_Koran_' . $user->username . '.pdf');
    }
}