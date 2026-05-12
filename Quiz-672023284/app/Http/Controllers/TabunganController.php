<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tabungan;

class TabunganController extends Controller
{
    public function index()
    {
        return view('tabung');
    }

    public function store(Request $request)
    {
        Tabungan::create([
            'user_id' => Auth::id(),
            'jenis' => 'TABUNG',
            'nominal' => $request->nominal
        ]);

        return redirect('/dashboard');
    }
}