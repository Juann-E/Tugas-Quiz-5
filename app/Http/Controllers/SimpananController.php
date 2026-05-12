<?php

namespace App\Http\Controllers;

use App\Models\simpanan;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    /**
     * Display a listing of simpanan.
     */
    public function index()
    {
        $simpanan = simpanan::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        
        $totalSimpanan = simpanan::where('user_id', auth()->id())->sum('jumlah');
        
        return view('simpanan.index', [
            'simpanan' => $simpanan,
            'totalSimpanan' => $totalSimpanan,
        ]);
    }

    /**
     * Show the form for creating a new simpanan.
     */
    public function create()
    {
        return view('simpanan.create');
    }

    /**
     * Store a newly created simpanan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_simpan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Generate kode simpanan
        $lastSimpanan = simpanan::latest('id')->first();
        $kodeSimpanan = 'SMP-' . str_pad(($lastSimpanan?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $simpanan = simpanan::create([
            'user_id' => auth()->id(),
            'kode_simpanan' => $kodeSimpanan,
            'jenis_simpanan' => $validated['jenis_simpanan'],
            'jumlah' => $validated['jumlah'],
            'tanggal_simpan' => $validated['tanggal_simpan'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil ditambahkan.');
    }

    /**
     * Display the specified simpanan.
     */
    public function show(simpanan $simpanan)
    {
        $this->authorize('view', $simpanan);
        return view('simpanan.show', ['simpanan' => $simpanan]);
    }

    /**
     * Show the form for editing the specified simpanan.
     */
    public function edit(simpanan $simpanan)
    {
        $this->authorize('update', $simpanan);
        return view('simpanan.edit', ['simpanan' => $simpanan]);
    }

    /**
     * Update the specified simpanan in storage.
     */
    public function update(Request $request, simpanan $simpanan)
    {
        $this->authorize('update', $simpanan);

        $validated = $request->validate([
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_simpan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $simpanan->update($validated);

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil diperbarui.');
    }

    /**
     * Remove the specified simpanan from storage.
     */
    public function destroy(simpanan $simpanan)
    {
        $this->authorize('delete', $simpanan);
        
        $simpanan->delete();

        return redirect()->route('simpanan.index')
            ->with('success', 'Simpanan berhasil dihapus.');
    }
}
