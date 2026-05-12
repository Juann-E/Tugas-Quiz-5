<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::where(
            'user_id',
            auth()->id()
        )->get();

        return view(
            'pinjaman.index',
            compact('pinjaman')
        );
    }

    public function store(Request $request)
    {
        Pinjaman::create([
            'user_id' => auth()->id(),
            'jumlah_pinjaman' => $request->jumlah,
            'sisa_pinjaman' => $request->jumlah
        ]);

        return back();
    }
}