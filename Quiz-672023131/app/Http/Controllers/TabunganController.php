<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tabungan;

class TabunganController extends Controller
{
    public function tabung(Request $request)
    {
        Tabungan::create([
            'user_id' => auth()->id(),
            'jenis' => 'tabung',
            'jumlah' => $request->jumlah
        ]);

        return back();
    }

    public function ambil(Request $request)
    {
        Tabungan::create([
            'user_id' => auth()->id(),
            'jenis' => 'ambil',
            'jumlah' => $request->jumlah
        ]);

        return back();
    }
}