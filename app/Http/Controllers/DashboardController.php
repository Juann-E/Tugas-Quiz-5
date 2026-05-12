<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $pinjamanAktif = Pinjaman::where('user_id', $user->id)
            ->where('status', 'berlangsung')
            ->get();

        return view('dashboard', [
            'user' => $user,
            'pinjamanAktif' => $pinjamanAktif,
        ]);
    }
}
