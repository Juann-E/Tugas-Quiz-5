<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan form login
    public function loginForm()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput(['username' => $request->username]);
    }

    // Tampilkan form registrasi
    public function registerForm()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:100',
            'username'              => 'required|string|max:50|unique:users,username',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi',
            'username.required'     => 'Username wajib diisi',
            'username.unique'       => 'Username sudah digunakan',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->username . '@koperasi.local', // email dummy
            'password' => Hash::make($request->password),
            'saldo'    => 0,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
