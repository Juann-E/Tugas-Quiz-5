<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\PembayaranPinjaman;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    // tampil data pinjaman
    public function index()
    {
        $pinjamans = Pinjaman::where('user_id', Auth::id())->get();

        return view('pinjaman.index', compact('pinjamans'));
    }

    // proses pinjam uang
    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:50000|max:10000000',
            'tanggal_pembayaran' => 'required|date'
        ]);

        Pinjaman::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'sisa_pinjaman' => $request->nominal,
            'status' => 'belum_lunas',
            'tanggal_pembayaran' => $request->tanggal_pembayaran
        ]);

        return redirect()->back()
            ->with('success', 'Pinjaman berhasil dibuat');
    }

    // bayar pinjaman
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'nominal_bayar' => 'required|numeric|min:50000|max:10000000'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);

        if ($pinjaman->status == 'lunas') {
            return redirect()->back()
                ->with('error', 'Pinjaman sudah lunas');
        }

        $bayar = $request->nominal_bayar;

        // simpan riwayat pembayaran
        PembayaranPinjaman::create([
            'pinjaman_id' => $pinjaman->id,
            'nominal_bayar' => $bayar
        ]);

        // jika bayar lebih besar dari sisa
        if ($bayar >= $pinjaman->sisa_pinjaman) {

            $pinjaman->sisa_pinjaman = 0;
            $pinjaman->status = 'lunas';
        } else {

            $pinjaman->sisa_pinjaman =
                $pinjaman->sisa_pinjaman - $bayar;
        }

        $pinjaman->save();

        return redirect()->back()
            ->with('success', 'Pembayaran berhasil');
    }
}
