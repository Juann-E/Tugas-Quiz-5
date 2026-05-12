<?php

namespace App\Http\Controllers;

use App\Models\bayar_pinjaman;
use App\Models\pinjaman;
use Illuminate\Http\Request;

class BayarPinjamanController extends Controller
{
    /**
     * Display a listing of pembayaran pinjaman.
     */
    public function index()
    {

    
        $pembayaran = bayar_pinjaman::with('pinjaman')  // tambah with()
            ->where('user_id', auth()->id())
            ->latest('tanggal_bayar')
            ->paginate(10);

        $pinjamanAktif = pinjaman::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get();

        return view('bayar-pinjaman.index', [
            'pembayaran'    => $pembayaran,
            'pinjamanAktif' => $pinjamanAktif,
        ]);
    }
    /**
     * Show the form for creating a new pembayaran pinjaman.
     */
    public function create($pinjaman_id = null)
    {
        $pinjaman = pinjaman::where('user_id', auth()->id())->findOrFail($pinjaman_id);
        
        if ($pinjaman->status !== 'disetujui' || $pinjaman->sisa_pinjaman <= 0) {
            return redirect()->route('bayar-pinjaman.index')
                ->with('error', 'Pinjaman tidak dapat dibayar.');
        }

        // Calculate next installment
        $angsuranKe = $pinjaman->pembayaran()->count() + 1;
        $sisa = $pinjaman->sisa_pinjaman;
        $jumlahBayar = min($pinjaman->angsuran_per_bulan, $sisa);

        return view('bayar-pinjaman.create', [
            'pinjaman' => $pinjaman,
            'keAngsuran' => $angsuranKe,   // ganti key ini
            'jumlahBayar' => $jumlahBayar,
        ]);
    }

    /**
     * Store a newly created pembayaran pinjaman in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'metode_bayar' => 'required|in:tunai,transfer',
            'keterangan' => 'nullable|string',
        ], [
            'pinjaman_id.required' => 'Pinjaman harus dipilih',
            'jumlah_bayar.required' => 'Jumlah bayar harus diisi',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka',
            'tanggal_bayar.required' => 'Tanggal pembayaran harus diisi',
            'tanggal_bayar.date' => 'Format tanggal tidak valid',
            'metode_bayar.required' => 'Metode pembayaran harus dipilih',
        ]);

        $pinjaman = pinjaman::where('user_id', auth()->id())
            ->findOrFail($validated['pinjaman_id']);

        if ($pinjaman->status !== 'disetujui' || $pinjaman->sisa_pinjaman <= 0) {
            return redirect()->back()
                ->with('error', 'Pinjaman tidak dapat dibayar.');
        }

        if ($validated['jumlah_bayar'] > $pinjaman->sisa_pinjaman) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah bayar tidak boleh melebihi sisa pinjaman: Rp ' . number_format($pinjaman->sisa_pinjaman, 0, ',', '.'));
        }

        // Calculate pokok dan bunga dari angsuran
        $jumlahBayar = $validated['jumlah_bayar'];
        $bungaBayar = ($pinjaman->jumlah_pinjaman * $pinjaman->bunga_persen * 1) / 100;
        $pokokBayar = $jumlahBayar - $bungaBayar;

        $sisaSetelahBayar = $pinjaman->sisa_pinjaman - $jumlahBayar;

        // Generate kode bayar
        $lastBayar = bayar_pinjaman::latest('id')->first();
        $kodeBayar = 'BAY-' . str_pad(($lastBayar?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $keAngsuran = $pinjaman->pembayaran()->count() + 1;

        $pembayaran = bayar_pinjaman::create([
            'pinjaman_id' => $pinjaman->id,
            'user_id' => auth()->id(),
            'kode_bayar' => $kodeBayar,
            'ke_angsuran' => $keAngsuran,
            'jumlah_bayar' => $jumlahBayar,
            'pokok_bayar' => $pokokBayar,
            'bunga_bayar' => $bungaBayar,
            'sisa_setelah_bayar' => $sisaSetelahBayar,
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'metode_bayar' => $validated['metode_bayar'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        // Update pinjaman sisa
        $pinjaman->update([
            'sisa_pinjaman' => $sisaSetelahBayar,
            'status' => $sisaSetelahBayar <= 0 ? 'lunas' : 'disetujui',
        ]);

        return redirect()->route('bayar-pinjaman.show', $pembayaran->id)
            ->with('success', 'Pembayaran berhasil tercatat. Terima kasih!');
    }

    /**
     * Display the specified pembayaran pinjaman.
     */
    public function show(bayar_pinjaman $bayarPinjaman)
    {
        if ($bayarPinjaman->user_id !== auth()->id()) {
            abort(403);
        }
        $bayarPinjaman->load('pinjaman');


        return view('bayar-pinjaman.show', ['pembayaran' => $bayarPinjaman]);
    }
}
