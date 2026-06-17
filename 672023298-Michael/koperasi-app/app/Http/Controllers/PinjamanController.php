<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function create()
    {
        return view('pinjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        Pinjaman::create([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'sisa_pinjaman' => $request->jumlah,
            'status' => 'Active',
        ]);

        return redirect('/dashboard');
    }
}
