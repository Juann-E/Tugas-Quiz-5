<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    
    public function tabungForm()
    {
        $user = Auth::user();
        return view('tabungan.tabung', compact('user'));
    }


    public function tabung(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
        ], [
            'jumlah.required' => 'Jumlah tabungan wajib diisi',
            'jumlah.min'      => 'Minimal tabungan Rp 1.000',
        ]);

        DB::transaction(function () use ($request) {
            $user           = Auth::user();
            $saldo_sebelum  = $user->saldo;
            $saldo_sesudah  = $saldo_sebelum + $request->jumlah;
            $user->saldo = $saldo_sesudah;
            $user->save();

            Tabungan::create([
                'user_id'       => $user->id,
                'jenis'         => 'setor',
                'jumlah'        => $request->jumlah,
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Tabungan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan.');
    }

    public function ambilForm()
    {
        $user = Auth::user();
        return view('tabungan.ambil', compact('user'));
    }

    public function ambil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo,
        ], [
            'jumlah.required' => 'Jumlah penarikan wajib diisi',
            'jumlah.min'      => 'Minimal penarikan Rp 1.000',
            'jumlah.max'      => 'Jumlah penarikan melebihi saldo Anda',
        ]);

        DB::transaction(function () use ($request, $user) {
            $saldo_sebelum = $user->saldo;
            $saldo_sesudah = $saldo_sebelum - $request->jumlah;

            $user->saldo = $saldo_sesudah;
            $user->save();

            Tabungan::create([
                'user_id'       => $user->id,
                'jenis'         => 'tarik',
                'jumlah'        => $request->jumlah,
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }
}
