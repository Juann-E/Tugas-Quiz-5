<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Tabungan;
use App\Models\Pinjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO
        |--------------------------------------------------------------------------
        */

        $saldo = Tabungan::where('user_id', $userId)
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

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA PINJAMAN USER
        |--------------------------------------------------------------------------
        */

        $pinjamans = Pinjaman::where(
                'user_id',
                $userId
            )
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PINJAMAN BELUM LUNAS
        |--------------------------------------------------------------------------
        */

        $totalPinjaman = Pinjaman::where(
                'user_id',
                $userId
            )
            ->where('status', 'BELUM LUNAS')
            ->sum('sisa');

        return view('dashboard', compact(

            'saldo',

            'pinjamans',

            'totalPinjaman'

        ));
    }
}