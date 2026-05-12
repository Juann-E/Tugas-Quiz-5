<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabunganController extends Controller
{
    public function create()
    {
        return view('tabungan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        Tabungan::create([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/dashboard');
    }
}
