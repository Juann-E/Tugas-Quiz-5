<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah']);
        }

        session(['user_id' => $user->id, 'username' => $user->username]);
        return redirect()->route('dashboard');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|unique:users,username|max:50',
            'password'     => 'required|min:6|confirmed',
        ], [
            'username.unique'      => 'Username sudah digunakan',
            'password.confirmed'   => 'Konfirmasi password tidak cocok',
            'password.min'         => 'Password minimal 6 karakter',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => password_hash($request->password, PASSWORD_BCRYPT),
            'saldo'        => 0,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout() {
        session()->flush();
        return redirect()->route('login');
    }
}
