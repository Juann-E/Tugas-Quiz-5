<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())->where('status', 'active')->get();
        return view('dashboard', compact('loans'));
    }

    public function register(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'balance' => 0
        ]);
        return redirect()->route('login')->with('success', 'Daftar berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        return back()->with('error', 'Email atau Password salah!');
    }

    public function tabung(Request $request)
    {
        $user = User::find(Auth::id());
        $user->balance += $request->amount;
        $user->save();
        return back();
    }

    public function ambil(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->balance >= $request->amount) {
            $user->balance -= $request->amount;
            $user->save();
        }
        return back();
    }

    public function pinjam(Request $request)
    {
        DB::transaction(function () use ($request) {
            Loan::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'remaining' => $request->amount,
                'status' => 'active'
            ]);
            $user = User::find(Auth::id());
            $user->balance += $request->amount;
            $user->save();
        });
        return back();
    }

    public function bayar(Request $request)
    {
        $loan = Loan::findOrFail($request->loan_id);
        $user = User::find(Auth::id());
        if ($user->balance >= $loan->remaining) {
            DB::transaction(function () use ($user, $loan) {
                $user->balance -= $loan->remaining;
                $user->save();
                $loan->update(['remaining' => 0, 'status' => 'paid']);
            });
        }
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}