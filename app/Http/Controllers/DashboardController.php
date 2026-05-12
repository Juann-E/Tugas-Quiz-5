<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $saldo = $user->balance;
        $pinjamanAktif = $user->loans()->where('status', 'Active')->get();

        return view('dashboard', compact('saldo', 'pinjamanAktif'));
    }
}
