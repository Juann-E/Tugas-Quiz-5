<?php

namespace App\Http\Controllers;

use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;

class TabungController extends Controller
{
    public function index()
    {
        return view('tabung');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $user->saldo_tabungan += $validated['jumlah'];
        $user->save();

        TransaksiTabungan::create([
            'user_id' => $user->id,
            'tipe' => 'tabung',
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect('/dashboard')->with('success', 'Tabungan berhasil ditambahkan');
    }
}
