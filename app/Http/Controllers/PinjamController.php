<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function index()
    {
        return view('pinjam');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        Pinjaman::create([
            'user_id' => auth()->id(),
            'jumlah' => $validated['jumlah'],
            'jumlah_dibayar' => 0,
            'status' => 'berlangsung',
        ]);

        return redirect('/dashboard')->with('success', 'Pinjaman berhasil diajukan');
    }
}
