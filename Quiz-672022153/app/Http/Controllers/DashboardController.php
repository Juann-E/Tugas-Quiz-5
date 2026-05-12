<?php
namespace App\Http\Controllers;
 
use App\Models\User;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
 
class DashboardController extends Controller
{
    private function getUser()
    {
        return User::findOrFail(Session::get('user_id'));
    }
 
    // Halaman dashboard
    public function index()
    {
        $user  = $this->getUser();
        $loans = Loan::where('user_id', $user->id)
                     ->where('status','active')->get();
        $history = Transaction::where('user_id', $user->id)
                     ->latest()->take(20)->get();
        return view('dashboard', compact('user','loans','history'));
    }
 
    // Tabung uang
    public function tabung(Request $request)
    {
        $request->validate(['jumlah' => 'required|numeric|min:1000']);
        $user = $this->getUser();
        $user->saldo += $request->jumlah;
        $user->save();
        Transaction::create([
            'user_id'    => $user->id,
            'type'       => 'tabung',
            'jumlah'     => $request->jumlah,
            'keterangan' => 'Tabung uang',
        ]);
        return back()->with('success', 'Tabungan berhasil disimpan!');
    }
 
    // Ambil uang
    public function ambil(Request $request)
    {
        $request->validate(['jumlah' => 'required|numeric|min:1000']);
        $user = $this->getUser();
        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['ambil' => 'Saldo tidak mencukupi!']);
        }
        $user->saldo -= $request->jumlah;
        $user->save();
        Transaction::create([
            'user_id'    => $user->id,
            'type'       => 'ambil',
            'jumlah'     => $request->jumlah,
            'keterangan' => 'Ambil uang',
        ]);
        return back()->with('success', 'Penarikan berhasil!');
    }
 
    // Ajukan pinjaman
    public function pinjam(Request $request)
    {
        $request->validate(['jumlah' => 'required|numeric|min:1000']);
        $user = $this->getUser();
        $loan = Loan::create([
            'user_id' => $user->id,
            'total'   => $request->jumlah,
            'sisa'    => $request->jumlah,
            'status'  => 'active',
        ]);
        $user->saldo += $request->jumlah;
        $user->save();
        Transaction::create([
            'user_id'    => $user->id,
            'type'       => 'pinjam',
            'jumlah'     => $request->jumlah,
            'loan_id'    => $loan->id,
            'keterangan' => 'Pinjaman cair',
        ]);
        return back()->with('success', 'Pinjaman berhasil diajukan!');
    }
 
    // Bayar pinjaman
    public function bayar(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'jumlah'  => 'required|numeric|min:1000',
        ]);
        $user = $this->getUser();
        $loan = Loan::where('id', $request->loan_id)
                    ->where('user_id', $user->id)->firstOrFail();
 
        if ($request->jumlah > $loan->sisa) {
            return back()->withErrors(['bayar' => 'Jumlah melebihi sisa pinjaman!']);
        }
        if ($request->jumlah > $user->saldo) {
            return back()->withErrors(['bayar' => 'Saldo tidak mencukupi!']);
        }
 
        $loan->sisa -= $request->jumlah;
        if ($loan->sisa <= 0) { $loan->status = 'lunas'; }
        $loan->save();
 
        $user->saldo -= $request->jumlah;
        $user->save();
 
        Transaction::create([
            'user_id'    => $user->id,
            'type'       => 'bayar',
            'jumlah'     => $request->jumlah,
            'loan_id'    => $loan->id,
            'keterangan' => $loan->status === 'lunas' ? 'Pinjaman LUNAS' : 'Bayar pinjaman',
        ]);
 
        $msg = $loan->status === 'lunas'
             ? 'Pinjaman LUNAS!'
             : 'Pembayaran berhasil!';
        return back()->with('success', $msg);
    }
}
