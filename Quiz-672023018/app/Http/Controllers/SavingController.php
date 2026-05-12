<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller {

    public function showTabung() {
        $user = User::findOrFail(session('user_id'));
        return view('tabung', compact('user'));
    }

    public function tabung(Request $request) {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000'
        ], ['jumlah.min' => 'Minimal tabungan Rp 1.000']);

        $user = User::findOrFail(session('user_id'));
        $user->increment('saldo', $request->jumlah);

        Saving::create([
            'user_id' => $user->id,
            'jumlah'  => $request->jumlah,
            'tipe'    => 'tabung',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Tabungan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil disimpan.');
    }

    public function showAmbil() {
        $user = User::findOrFail(session('user_id'));
        return view('ambil', compact('user'));
    }

    public function ambil(Request $request) {
        $user = User::findOrFail(session('user_id'));

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . $user->saldo
        ], [
            'jumlah.max' => 'Saldo tidak mencukupi',
            'jumlah.min' => 'Minimal penarikan Rp 1.000',
        ]);

        $user->decrement('saldo', $request->jumlah);

        Saving::create([
            'user_id' => $user->id,
            'jumlah'  => $request->jumlah,
            'tipe'    => 'ambil',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Penarikan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }
}
