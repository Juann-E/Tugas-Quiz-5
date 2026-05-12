<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman form registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Memproses data registrasi yang dikirim.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi murni hanya mengecek username (TIDAK ADA EMAIL)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Buat user baru ke database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'saldo' => 0, // Saldo awal diberikan 0
        ]);

        event(new Registered($user));

        Auth::login($user);

        // 3. Arahkan langsung ke dashboard
        return redirect(route('dashboard', absolute: false));
    }
}