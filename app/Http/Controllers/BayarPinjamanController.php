<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\TransaksiPinjaman;
use Illuminate\Http\Request;

class BayarPinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::where('user_id', auth()->id())
            ->where('status', 'berlangsung')
            ->get();

        return view('bayar-pinjaman', ['pinjaman' => $pinjaman]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $pinjaman = Pinjaman::where('id', $validated['pinjaman_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $user->saldo_tabungan -= $validated['jumlah'];
        $user->save();

        $pinjaman->jumlah_dibayar += $validated['jumlah'];

        if ($pinjaman->jumlah_dibayar >= $pinjaman->jumlah) {
            $pinjaman->status = 'lunas';
        }
        $pinjaman->save();

        TransaksiPinjaman::create([
            'user_id' => $user->id,
            'pinjaman_id' => $pinjaman->id,
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect('/dashboard')->with('success', 'Pembayaran berhasil');
    }
}
