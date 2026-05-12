<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller {

    public function showPinjam() {
        $user = User::findOrFail(session('user_id'));
        return view('pinjam', compact('user'));
    }

    public function pinjam(Request $request) {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000'
        ], ['jumlah.min' => 'Minimal pinjaman Rp 1.000']);

        $user = User::findOrFail(session('user_id'));
        $user->increment('saldo', $request->jumlah);

        Loan::create([
            'user_id'        => $user->id,
            'total_pinjaman' => $request->jumlah,
            'sisa_pinjaman'  => $request->jumlah,
            'status'         => 'active',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Pinjaman Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan.');
    }

    public function showBayar() {
        $user  = User::findOrFail(session('user_id'));
        $loans = Loan::where('user_id', $user->id)
                      ->where('status', 'active')
                      ->get();
        return view('bayar', compact('user', 'loans'));
    }

    public function bayar(Request $request) {
        $user = User::findOrFail(session('user_id'));
        $loan = Loan::where('id', $request->loan_id)
                     ->where('user_id', $user->id)
                     ->where('status', 'active')
                     ->firstOrFail();

        $request->validate([
            'jumlah' => 'required|numeric|min:1000|max:' . min($loan->sisa_pinjaman, $user->saldo),
        ], [
            'jumlah.max' => 'Jumlah melebihi sisa pinjaman atau saldo tidak cukup',
            'jumlah.min' => 'Minimal pembayaran Rp 1.000',
        ]);

        $user->decrement('saldo', $request->jumlah);
        $loan->decrement('sisa_pinjaman', $request->jumlah);
        $loan->refresh();

        if ($loan->sisa_pinjaman <= 0) {
            $loan->update(['sisa_pinjaman' => 0, 'status' => 'lunas']);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran pinjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil.');
    }
}
