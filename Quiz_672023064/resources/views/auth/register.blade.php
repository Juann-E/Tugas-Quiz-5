@extends('layouts.app')
@section('title', 'Register - GONDRONG LOAN')
@push('styles')
<style>
    body { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px 0; }
    .container { max-width: 400px; width: 100%; }
    .card { background: #1a1a2e; border: 1px solid #2a2a4a; border-radius: 20px; overflow: hidden; }
    .card-header { padding: 28px 28px 20px; text-align: center; }
    .card-logo { font-size: 36px; margin-bottom: 8px; }
    .card-title { font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #a855f7, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .card-subtitle { font-size: 12px; color: #555; margin-top: 4px; }
    .card-body { padding: 8px 28px 28px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 11px; color: #666; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 12px 14px; background: #0f0f1a; border: 1px solid #2a2a4a; border-radius: 10px; font-size: 14px; color: #e2e2f0; outline: none; font-family: 'Poppins', sans-serif; }
    .form-control:focus { border-color: #a855f7; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .btn-primary { width: 100%; padding: 13px; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 4px; font-family: 'Poppins', sans-serif; }
    .btn-primary:hover { opacity: 0.9; }
    .divider { text-align: center; margin: 16px 0; font-size: 12px; color: #444; }
    .link-login { display: block; text-align: center; font-size: 13px; color: #666; }
    .link-login a { color: #a855f7; text-decoration: none; font-weight: 600; }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-logo">💈</div>
        <div class="card-title">GONDRONG LOAN</div>
        <div class="card-subtitle">Buat akun baru</div>
    </div>
    <div class="card-body">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap">
                @error('nama_lengkap')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Masukkan username">
                @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
            </div>
            <button type="submit" class="btn-primary">Daftar Sekarang</button>
        </form>
        <div class="divider">— atau —</div>
        <div class="link-login">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></div>
    </div>
</div>
@endsection