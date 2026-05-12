<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pinjaman;
use App\Models\PembayaranPinjaman;
use App\Models\Tabungan;

class PembayaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN BAYAR
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $pinjamans = Pinjaman::where(
                'user_id',
                Auth::id()
            )
            ->where('status', 'BELUM LUNAS')
            ->latest()
            ->get();

        return view(
            'bayar',
            compact('pinjamans')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES BAYAR
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'pinjaman_id' => 'required',

            'nominal_bayar' => 'required|numeric|min:1'

        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL PINJAMAN
        |--------------------------------------------------------------------------
        */

        $pinjaman = Pinjaman::findOrFail(
            $request->pinjaman_id
        );

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO USER
        |--------------------------------------------------------------------------
        */

        $saldo = Tabungan::where(
                'user_id',
                Auth::id()
            )
            ->selectRaw("
                SUM(
                    CASE
                        WHEN jenis='TABUNG'
                        THEN nominal
                        ELSE -nominal
                    END
                ) as total
            ")
            ->value('total');

        $saldo = $saldo ?? 0;

        /*
        |--------------------------------------------------------------------------
        | CEK SALDO MENCUKUPI
        |--------------------------------------------------------------------------
        */

        if ($saldo < $request->nominal_bayar) {

            return redirect('/dashboard')->with(

                'error',

                'Saldo tidak mencukupi untuk melakukan pembayaran'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TIDAK BOLEH LEBIH BESAR DARI SISA
        |--------------------------------------------------------------------------
        */

        if ($request->nominal_bayar > $pinjaman->sisa) {

            return redirect('/dashboard')->with(

                'error',

                'Pembayaran melebihi sisa pinjaman'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN RIWAYAT PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        PembayaranPinjaman::create([

            'pinjaman_id' => $pinjaman->id,

            'nominal_bayar' => $request->nominal_bayar

        ]);

        /*
        |--------------------------------------------------------------------------
        | KURANGI SALDO USER
        |--------------------------------------------------------------------------
        */

        Tabungan::create([

            'user_id' => Auth::id(),

            'jenis' => 'TARIK',

            'nominal' => $request->nominal_bayar

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE SISA PINJAMAN
        |--------------------------------------------------------------------------
        */

        $pinjaman->sisa -= $request->nominal_bayar;

        /*
        |--------------------------------------------------------------------------
        | JIKA LUNAS
        |--------------------------------------------------------------------------
        */

        if ($pinjaman->sisa <= 0) {

            $pinjaman->sisa = 0;

            $pinjaman->status = 'LUNAS';
        }

        $pinjaman->save();

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect('/dashboard')->with(

            'success',

            'Pembayaran berhasil'

        );
    }
}