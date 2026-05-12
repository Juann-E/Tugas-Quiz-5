<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function history()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->orderBy('created_at', 'desc')->paginate(10);
        $balance = $user->getBalance();
        
        return view('transactions.history', compact('transactions', 'balance'));
    }

    public function showSave()
    {
        return view('transactions.save');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'savings',
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? 'Penabungan manual',
        ]);

        return redirect('/transactions/history')->with('success', 'Uang berhasil ditabung!');
    }


    public function showWithdraw()
    {
        $balance = Auth::user()->getBalance();
        return view('transactions.withdraw', compact('balance'));
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $balance = $user->getBalance();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'description' => 'nullable|string|max:255',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? 'Penarikan manual',
        ]);

        return redirect('/transactions/history')->with('success', 'Uang berhasil ditarik!');
    }

    public function showBorrow()
    {
        return view('transactions.borrow');
    }

    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();
        $amount = $validated['amount'];
        $desc = $validated['description'] ?? 'Peminjaman';


        Loan::create([
            'user_id' => $userId,
            'amount' => $amount,
            'remaining_amount' => $amount,
            'status' => 'active',
            'description' => $desc,
        ]);

    
        Transaction::create([
            'user_id' => $userId,
            'type' => 'savings', 
            'amount' => $amount,
            'description' => 'Pencairan Pinjaman: ' . $desc,
        ]);

        return redirect('/loans')->with('success', 'Pinjaman berhasil! Uang telah ditambahkan ke saldo Anda.');
    }

    public function loans()
    {
        $user = Auth::user();
        $loans = $user->loans()->where('status', 'active')->orderBy('created_at', 'desc')->get();
        $paidLoans = $user->loans()->where('status', 'paid')->orderBy('created_at', 'desc')->get();

        return view('transactions.loans', compact('loans', 'paidLoans'));
    }
    public function showPayLoan()
    {
        $user = Auth::user();
        $loans = $user->loans()->where('status', 'active')->get();

        return view('transactions.pay-loan', compact('loans'));
    }

    public function payLoan(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $loan = Loan::findOrFail($validated['loan_id']);

        if ($loan->user_id !== $user->id) {
            return back()->withErrors(['loan_id' => 'Data pinjaman tidak valid.']);
        }

        if ($validated['amount'] > $loan->remaining_amount) {
            return back()->withErrors(['amount' => 'Pembayaran melebihi sisa utang!']);
        }

        if ($user->getBalance() < $validated['amount']) {
            return back()->withErrors(['amount' => 'Saldo tidak cukup untuk membayar hutang ini. Silakan menabung dulu!']);
        }

        LoanPayment::create([
            'loan_id' => $loan->id,
            'amount' => $validated['amount'],
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal', 
            'amount' => $validated['amount'],
            'description' => 'Bayar Cicilan Pinjaman #' . $loan->id,
        ]);

        $loan->remaining_amount -= $validated['amount'];
        if ($loan->remaining_amount <= 0) {
            $loan->status = 'paid';
        }
        $loan->save();

        return redirect('/loans')->with('success', 'Berhasil membayar cicilan! Saldo otomatis terpotong.');
    }
}