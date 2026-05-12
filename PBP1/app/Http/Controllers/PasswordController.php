<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
   public function update(Request $request)
{
    // 1. Validasi format input saja dulu
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    // 2. Cek Manual: Apakah password lama cocok dengan database?
    if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $request->user()->password)) {
        // Jika tidak cocok, kirim balik dengan pesan error manual
        return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah!']);
    }

    // 3. Jika cocok, baru simpan
    $user = $request->user();
    $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    $user->save();

    return back()->with('status', 'password-updated');
}
}