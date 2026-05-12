<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'username' => 'required|unique:users',

            'password' => 'required|min:3|confirmed'

        ]);

        User::create([

            'name' => $request->name,

            'username' => $request->username,

            // email otomatis agar tidak error
            'email' => $request->username . '@gmail.com',

            'password' => Hash::make(
                $request->password
            )

        ]);

        return redirect('/login')->with(
            'success',
            'Register berhasil'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [

            'username' => $request->username,

            'password' => $request->password

        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->with(
            'error',
            'Username atau password salah'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}