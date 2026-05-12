<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function store(Request $request, $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        Pembayaran::create([
            'pinjaman_id' => $pinjaman->id,
            'jumlah_bayar' => $request->jumlah_bayar
        ]);

        $pinjaman->sisa_pinjaman -=
            $request->jumlah_bayar;

        if($pinjaman->sisa_pinjaman < 0)
        {
            $pinjaman->sisa_pinjaman = 0;
        }

        $pinjaman->save();

        return back();
    }
}