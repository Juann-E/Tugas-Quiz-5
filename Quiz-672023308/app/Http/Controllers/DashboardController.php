<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $pinjaman = $user->pinjaman()->where('status', 'active')->get();
        return view('dashboard.dashboard', compact('user', 'pinjaman'));
    }
}