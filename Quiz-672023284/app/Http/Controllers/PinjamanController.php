<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pinjaman;

class PinjamanController extends Controller
{
    public function index()
    {
        return view('pinjam');
    }

    public function store(Request $request)
    {
        Pinjaman::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'sisa' => $request->nominal,
            'status' => 'BELUM LUNAS'
        ]);

        return redirect('/dashboard');
    }
}