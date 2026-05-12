<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('bank.registerAccount');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create($validated);
        return redirect()->route('login');
    }

    public function showLoginForm()
    {
        return view('bank.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        $user = User::where('username', $validated['username'])->first();
        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('bank.index');
        }
        return redirect()->back()->with('error', 'Username atau password tidak ditemukan');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $activeLoans = Loan::where('user_id', Auth::id())->where('status', 'active')->get();
        return view('bank.index', compact('activeLoans'));
    }
}
