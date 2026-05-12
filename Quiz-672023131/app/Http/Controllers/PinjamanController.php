<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Pembayaran;

class PinjamanController extends Controller
{
    public function store(Request $request)
    {
        Pinjaman::create([
            'user_id' => auth()->id(),
            'jumlah' => $request->jumlah,
            'sisa' => $request->jumlah
        ]);

        return back();
    }

    public function bayar(Request $request, $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        $jumlahBayar = $request->jumlah;

        // Tidak boleh bayar lebih besar dari sisa
        if ($jumlahBayar > $pinjaman->sisa) {

            return back()->with(
                'error',
                'Pembayaran melebihi sisa pinjaman!'
            );
        }

        Pembayaran::create([
            'pinjaman_id' => $id,
            'jumlah_bayar' => $jumlahBayar
        ]);

        $pinjaman->sisa -= $jumlahBayar;

        // Jika lunas
        if ($pinjaman->sisa <= 0) {

            $pinjaman->delete();

        } else {

            $pinjaman->save();
        }

        return back()->with(
            'success',
            'Pembayaran berhasil!'
        );
    }
}