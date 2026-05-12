<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Memastikan hanya user login yang datanya diambil
        $user = Auth::user(); 
        
        // Mengambil pinjaman yang statusnya 'Active' milik user tersebut [cite: 32, 36, 40]
        $loans = $user->loans()->where('status', 'Active')->get();

        return view('dashboard', compact('user', 'loans'));
    }
}