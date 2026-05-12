@extends('layouts.app')
@section('title', 'Register - Quiz')

@section('extra-styles')
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        font-family: 'Segoe UI', sans-serif;
        padding: 20px;
    }

    .auth-wrap {
        width: 100%;
        max-width: 420px;
    }

    .auth-logo {
        text-align: center;
        margin-bottom: 30px;
        color: #fff;
    }

    .auth-logo h1 {
        font-size: 30px;
        font-weight: 800;
    }

    .auth-logo p {
        font-size: 14px;
        opacity: 0.85;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(14px);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.4);
        color: #fff;
    }

    .auth-card-header {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        outline: none;
        background: rgba(255,255,255,0.18);
        color: #fff;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.6);
    }

    .form-control:focus {
        box-shadow: 0 0 0 2px rgba(147,197,253,0.7);
    }

    .btn {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-primary {
        background: #3b82f6;
        color: #fff;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .auth-footer {
        text-align: center;
        margin-top: 18px;
        font-size: 14px;
    }

    .auth-footer a {
        color: #93c5fd;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .alert-error {
        background: rgba(255, 0, 0, 0.2);
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .invalid-feedback {
        color: #fecaca;
        font-size: 12px;
        margin-top: 4px;
    }
</style>
@endsection

@section('content')
<div class="auth-wrap">

    <div class="auth-logo">
        <h1>💰 Quiz</h1>
        <p>Buat akun baru Anda</p>
    </div>

    <div class="auth-card">
        <div class="auth-card-header">Register</div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                       class="form-control @error('nama_lengkap') is-invalid @enderror"
                       value="{{ old('nama_lengkap') }}"
                       placeholder="Nama lengkap Anda"
                       required autofocus>
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username"
                       class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username') }}"
                       placeholder="Pilih username unik"
                       required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 6 karakter"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>

</div>
@endsection