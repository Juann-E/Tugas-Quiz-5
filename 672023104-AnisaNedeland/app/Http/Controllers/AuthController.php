<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Login
    public function showLogin() {
        return view('login');
    }

    // Proses Login
    public function login(Request $request) {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['error' => 'Username atau password salah!']);
    }

    // Menampilkan halaman Register
    public function showRegister() {
        return view('register');
    }

    // Proses Register
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:4|confirmed', // confirmed akan mencocokkan dengan password_confirmation
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Berhasil mendaftar! Silakan login.');
    }

    // Proses Logout
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}