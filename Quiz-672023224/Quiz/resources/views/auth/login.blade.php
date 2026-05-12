@extends('layouts.app')
@section('title', 'Login - Quiz')

@section('extra-styles')
<style>
/* RESET AGAR FULL HEIGHT */
html, body {
    height: 100%;
    margin: 0;
}

/* CENTER WRAPPER (ANTI BENTROK LAYOUT) */
.full-center {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* BACKGROUND */
body {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    font-family: 'Segoe UI', sans-serif;
}

/* WRAP */
.auth-wrap {
    width: 100%;
    max-width: 420px;
    padding: 20px;
}

/* LOGO */
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

/* CARD */
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

/* FORM */
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

/* BUTTON */
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

/* FOOTER */
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

/* ERROR */
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

/* OPTIONAL: HILANGKAN CONTAINER LAYOUT */
.container {
    max-width: 100% !important;
    padding: 0 !important;
}
</style>
@endsection

@section('content')
<div class="full-center">

    <div class="auth-wrap">

        <div class="auth-logo">
            <h1> Bank-Bankan</h1>
            <p>Simpan, Pinjam & Kelola Keuangan Anda</p>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">Login</div>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        required autofocus>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? 
                <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>

    </div>

</div>
@endsection