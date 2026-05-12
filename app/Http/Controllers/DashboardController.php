<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    private function getUser()
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return null;
        }
        return User::with('pinjamanAktif')->find($userId);
    }

    public function index()
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('dashboard', compact('user'));
    }

    public function tabung(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1'
        ]);

        $user->saldo += $request->jumlah;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil menabung Rp ' . number_format($request->jumlah, 0, ',', '.'));
    }

    public function ambil(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1|max:' . $user->saldo
        ]);

        $user->saldo -= $request->jumlah;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil mengambil Rp ' . number_format($request->jumlah, 0, ',', '.'));
    }

    public function pinjam(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1000'
        ]);

        $user->saldo += $request->jumlah;
        $user->save();

        Pinjaman::create([
            'user_id' => $user->id,
            'jumlah' => $request->jumlah,
            'sisa' => $request->jumlah,
            'status' => 'aktif',
            'tanggal' => now()
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil meminjam Rp ' . number_format($request->jumlah, 0, ',', '.'));
    }

    public function showBayar()
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $pinjamanAktif = Pinjaman::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->get();

        return view('bayar', compact('user', 'pinjamanAktif'));
    }

    public function bayar(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $pinjaman = Pinjaman::where('id', $request->pinjaman_id)
            ->where('user_id', $user->id)
            ->where('status', 'aktif')
            ->first();

        if (!$pinjaman) {
            return back()->with('error', 'Pinjaman tidak ditemukan!');
        }

        if ($request->jumlah > $pinjaman->sisa) {
            return back()->with('error', 'Jumlah bayar melebihi sisa pinjaman!');
        }

        if ($request->jumlah > $user->saldo) {
            return back()->with('error', 'Saldo tidak mencukupi!');
        }

        $user->saldo -= $request->jumlah;
        $user->save();

        $pinjaman->sisa -= $request->jumlah;

        if ($pinjaman->sisa <= 0) {
            $pinjaman->status = 'lunas';
            $pinjaman->sisa = 0;
        }

        $pinjaman->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil membayar pinjaman Rp ' . number_format($request->jumlah, 0, ',', '.'));
    }
}