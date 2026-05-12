<?php

namespace App\Http\Controllers;

use App\Models\pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    /**
     * Display a listing of pinjaman.
     */
    public function index()
    {
        $pinjaman = pinjaman::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        
        return view('pinjaman.index', ['pinjaman' => $pinjaman]);
    }

    /**
     * Show the form for creating a new pinjaman.
     */
    public function create()
    {
        return view('pinjaman.create');
    }

    /**
     * Store a newly created pinjaman in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah_pinjaman'  => 'required|numeric|min:100000',
            'tenor_bulan'      => 'required|integer|min:1',
            'tujuan_pinjaman'  => 'nullable|string',
            'tanggal_pengajuan'=> 'required|date',
        ]);

        $jumlahPinjaman = $validated['jumlah_pinjaman'];
        $bungaPersen    = 1.5; // hardcode flat 1.5%/bulan
        $tenor          = $validated['tenor_bulan'];

        $totalBunga      = $jumlahPinjaman * ($bungaPersen / 100) * $tenor;
        $totalBayar      = $jumlahPinjaman + $totalBunga;
        $angsuranPerBulan = $totalBayar / $tenor;

        $lastPinjaman = pinjaman::latest('id')->first();
        $kodePinjaman = 'PIN-' . str_pad(($lastPinjaman?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $pinjaman = pinjaman::create([
            'user_id'           => auth()->id(),
            'kode_pinjaman'     => $kodePinjaman,
            'jumlah_pinjaman'   => $jumlahPinjaman,
            'bunga_persen'      => $bungaPersen,
            'tenor_bulan'       => $tenor,
            'angsuran_per_bulan'=> $angsuranPerBulan,
            'total_bayar'       => $totalBayar,
            'sisa_pinjaman'     => $totalBayar,
            'tanggal_pengajuan' => $validated['tanggal_pengajuan'],
            'status'            => 'menunggu',
            'tujuan_pinjaman'   => $validated['tujuan_pinjaman'] ?? null,
        ]);

        return redirect()->route('pinjaman.show', $pinjaman)
            ->with('success', 'Pengajuan pinjaman berhasil dibuat.');
    }

    /**
     * Display the specified pinjaman.
     */
    public function show(pinjaman $pinjaman)
    {
        // Ganti authorize() dengan manual check
        if ($pinjaman->user_id !== auth()->id()) {
            abort(403);
        }
        
        $pembayaran = $pinjaman->pembayaran()
            ->latest('tanggal_bayar')
            ->paginate(5);
        
        return view('pinjaman.show', [
            'pinjaman' => $pinjaman,
            'pembayaran' => $pembayaran,
        ]);
    }


    /**
     * Show the form for editing the specified pinjaman.
     */
    public function edit(pinjaman $pinjaman)
    {
        if ($pinjaman->user_id !== auth()->id()) {
            abort(403);
        }
        
        if ($pinjaman->status !== 'menunggu') {
            return redirect()->route('pinjaman.show', $pinjaman)
                ->with('error', 'Hanya pinjaman dalam status menunggu yang dapat diubah.');
        }
        
        return view('pinjaman.edit', ['pinjaman' => $pinjaman]);
    }


    /**
     * Update the specified pinjaman in storage.
     */
    public function update(Request $request, pinjaman $pinjaman)
    {
        if ($pinjaman->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pinjaman->status !== 'menunggu') {
            return redirect()->route('pinjaman.show', $pinjaman)
                ->with('error', 'Hanya pinjaman dalam status menunggu yang dapat diubah.');
        }

        $validated = $request->validate([
            'jumlah_pinjaman' => 'required|numeric|min:1',
            'bunga_persen' => 'required|numeric|min:0',
            'tenor_bulan' => 'required|integer|min:1',
            'tujuan_pinjaman' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Recalculate angsuran dan total
        $jumlahPinjaman = $validated['jumlah_pinjaman'];
        $bungaPersen = $validated['bunga_persen'];
        $tenor = $validated['tenor_bulan'];

        $totalBunga = ($jumlahPinjaman * $bungaPersen * $tenor) / 100;
        $totalBayar = $jumlahPinjaman + $totalBunga;
        $angsuranPerBulan = $totalBayar / $tenor;

        $pinjaman->update([
            'jumlah_pinjaman' => $jumlahPinjaman,
            'bunga_persen' => $bungaPersen,
            'tenor_bulan' => $tenor,
            'angsuran_per_bulan' => $angsuranPerBulan,
            'total_bayar' => $totalBayar,
            'sisa_pinjaman' => $totalBayar,
            'tujuan_pinjaman' => $validated['tujuan_pinjaman'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('pinjaman.show', $pinjaman)
            ->with('success', 'Pinjaman berhasil diperbarui.');
    }

    /**
     * Approve pinjaman (admin only).
     */
    public function approve(pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Pinjaman harus dalam status menunggu.');
        }

        $pinjaman->update([
            'status' => 'disetujui',
            'tanggal_disetujui' => now()->toDateString(),
        ]);

        return redirect()->back()
            ->with('success', 'Pinjaman berhasil disetujui.');
    }

    /**
     * Reject pinjaman.
     */
    public function reject(Request $request, pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Pinjaman harus dalam status menunggu.');
        }

        $pinjaman->update(['status' => 'ditolak']);

        return redirect()->back()
            ->with('success', 'Pinjaman ditolak.');
    }

    /**
     * Delete the specified pinjaman.
     */
    public function destroy(pinjaman $pinjaman)
    {
        if ($pinjaman->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pinjaman->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Hanya pinjaman dalam status menunggu yang dapat dihapus.');
        }

        $pinjaman->delete();

        return redirect()->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil dihapus.');
    }
}
