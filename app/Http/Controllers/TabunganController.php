<?php

namespace App\Http\Controllers;

use App\Models\tabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    /**
     * Display a listing of tabungan.
     */
    public function index()
    {
        $tabungan = tabungan::where('user_id', auth()->id())->get();
        
        $totalSaldo = $tabungan->sum('saldo');
        
        return view('tabungan.index', [
            'tabungan' => $tabungan,
            'totalSaldo' => $totalSaldo,
        ]);
    }

    /**
     * Show the form for creating a new tabungan account.
     */
    public function create()
    {
        return view('tabungan.form');
    }

    /**
     * Store a newly created tabungan account in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        // Generate nomor rekening
        $lastTabungan = tabungan::latest('id')->first();
        $noRekening = 'REK-' . str_pad(($lastTabungan?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $tabungan = tabungan::create([
            'user_id' => auth()->id(),
            'no_rekening' => $noRekening,
            'saldo' => $validated['saldo_awal'],
            'status' => 'aktif',
        ]);

        return redirect()->route('tabungan.index')
            ->with('success', 'Rekening tabungan berhasil dibuat.');
    }

    /**
     * Display the specified tabungan account.
     */
    public function show(tabungan $tabungan)
    {
        $this->authorize('view', $tabungan);
        
        $mutasi = $tabungan->mutasi()
            ->latest('tanggal_transaksi')
            ->paginate(10);
        
        return view('tabungan.show', [
            'tabungan' => $tabungan,
            'mutasi' => $mutasi,
        ]);
    }

    /**
     * Setor (deposit) to tabungan account.
     */
    public function setor(Request $request, tabungan $tabungan)
    {
        $this->authorize('update', $tabungan);

        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $saldoSebelum = $tabungan->saldo;
        $saldoSesudah = $saldoSebelum + $validated['jumlah'];

        $tabungan->update(['saldo' => $saldoSesudah]);

        // Create mutasi record
        $tabungan->mutasi()->create([
            'jenis' => 'setor',
            'jumlah' => $validated['jumlah'],
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $saldoSesudah,
            'tanggal_transaksi' => now()->toDateString(),
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('tabungan.show', $tabungan)
            ->with('success', 'Setor berhasil.');
    }

    /**
     * Tarik (withdraw) from tabungan account.
     */
    public function tarik(Request $request, tabungan $tabungan)
    {
        $this->authorize('update', $tabungan);

        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        if ($validated['jumlah'] > $tabungan->saldo) {
            return redirect()->back()
                ->with('error', 'Saldo tidak cukup.');
        }

        $saldoSebelum = $tabungan->saldo;
        $saldoSesudah = $saldoSebelum - $validated['jumlah'];

        $tabungan->update(['saldo' => $saldoSesudah]);

        // Create mutasi record
        $tabungan->mutasi()->create([
            'jenis' => 'tarik',
            'jumlah' => $validated['jumlah'],
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $saldoSesudah,
            'tanggal_transaksi' => now()->toDateString(),
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('tabungan.show', $tabungan)
            ->with('success', 'Penarikan berhasil.');
    }

    /**
     * Show the form for editing the specified tabungan account.
     */
    public function edit(tabungan $tabungan)
    {
        $this->authorize('update', $tabungan);
        
        return view('tabungan.edit', ['tabungan' => $tabungan]);
    }

    /**
     * Update the specified tabungan account in storage.
     */
    public function update(Request $request, tabungan $tabungan)
    {
        $this->authorize('update', $tabungan);

        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $tabungan->update($validated);

        return redirect()->route('tabungan.show', $tabungan)
            ->with('success', 'Rekening tabungan berhasil diperbarui.');
    }

    /**
     * Delete the specified tabungan account.
     */
    public function destroy(tabungan $tabungan)
    {
        $this->authorize('delete', $tabungan);

        if ($tabungan->saldo > 0) {
            return redirect()->back()
                ->with('error', 'Saldo harus habis sebelum menghapus rekening.');
        }

        $tabungan->delete();

        return redirect()->route('tabungan.index')
            ->with('success', 'Rekening tabungan berhasil dihapus.');
    }
}
