<?php
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
 
class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }
 
    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
 
        $user = User::where('username', $request->username)->first();
 
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah.']);
        }
 
        Session::put('user_id', $user->id);
        Session::put('user_nama', $user->nama);
        return redirect()->route('dashboard');
    }
 
    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }
 
    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|unique:users|max:50',
            'password' => 'required|min:6|confirmed',
        ]);
 
        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'saldo'    => 0,
        ]);
 
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
 
    // Logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
