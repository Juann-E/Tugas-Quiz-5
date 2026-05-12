<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tabungan;
use Illuminate\Support\Facades\Auth;

class TabunganController extends Controller
{
    // hitung saldo
    public function saldo()
    {
        $tabung = Tabungan::where('user_id', Auth::id())
            ->where('jenis', 'tabung')
            ->sum('nominal');

        $ambil = Tabungan::where('user_id', Auth::id())
            ->where('jenis', 'ambil')
            ->sum('nominal');

        return $tabung - $ambil;
    }

    // tabung uang
    public function tabung(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:50000|max:10000000'
        ]);

        Tabungan::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'jenis' => 'tabung'
        ]);

        return back()->with('success', 'Berhasil menabung');
    }

    // ambil uang
    public function ambil(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:50000|max:10000000'
        ]);

        $saldo = $this->saldo();

        if ($saldo < $request->nominal) {
            return back()->with('error', 'Saldo tidak cukup');
        }

        Tabungan::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'jenis' => 'ambil'
        ]);

        return back()->with('success', 'Berhasil mengambil uang');
    }
}