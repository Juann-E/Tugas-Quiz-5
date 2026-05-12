<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Tabungan;

class AmbilController extends Controller
{
    public function index()
    {
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

        return view(
            'ambil',
            compact('saldo')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'nominal' => 'required|numeric|min:1'

        ]);

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO
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
        | CEK SALDO
        |--------------------------------------------------------------------------
        */

        if ($request->nominal > $saldo) {

            return redirect('/dashboard')->with(

                'error',

                'Saldo tidak mencukupi'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENARIKAN
        |--------------------------------------------------------------------------
        */

        Tabungan::create([

            'user_id' => Auth::id(),

            'jenis' => 'TARIK',

            'nominal' => $request->nominal

        ]);

        return redirect('/dashboard')->with(

            'success',

            'Berhasil mengambil uang'

        );
    }
}