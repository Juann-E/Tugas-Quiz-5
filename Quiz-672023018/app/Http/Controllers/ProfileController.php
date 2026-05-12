<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller {

    public function show() {
        $user = User::findOrFail(session('user_id'));
        return view('profile', compact('user'));
    }

    public function update(Request $request) {
        $user = User::findOrFail(session('user_id'));

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_hp'        => 'nullable|string|max:15',
            'alamat'       => 'nullable|string',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
        ]);

        return redirect()->route('profile')
                         ->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePassword(Request $request) {
        $user = User::findOrFail(session('user_id'));

        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min'       => 'Password minimal 6 karakter',
        ]);

        if (!password_verify($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }

        $user->update([
            'password' => password_hash($request->password, PASSWORD_BCRYPT)
        ]);

        return redirect()->route('profile')
                         ->with('success', 'Password berhasil diubah!');
    }
}
