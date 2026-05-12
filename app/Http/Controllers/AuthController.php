<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil masuk!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah']);
    }

    /**
     * Show register form
     */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name_panjang' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name_panjang.required' => 'Nama lengkap harus diisi',
            'name_panjang.min' => 'Nama lengkap minimal 3 karakter',
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Create user
        $user = User::create([
            'name_panjang' => $validated['name_panjang'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auto login after registration
        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('dashboard'))->with('success', 'Akun berhasil dibuat! Selamat datang!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'))->with('success', 'Berhasil keluar.');
    }
}
