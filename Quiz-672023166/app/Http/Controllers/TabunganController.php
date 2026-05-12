<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tabungan;

class TabunganController extends Controller
{
    public function index()
    {
        $tabungan = Tabungan::where(
            'user_id',
            auth()->id()
        )->get();

        return view(
            'tabungan.index',
            compact('tabungan')
        );
    }

    public function store(Request $request)
    {
        Tabungan::create([
            'user_id' => auth()->id(),
            'jumlah' => $request->jumlah,
            'jenis' => 'tabung'
        ]);

        return back();
    }
}