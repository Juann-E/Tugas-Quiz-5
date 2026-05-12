@extends('layouts.app')
@section('title', 'Login — SimpanPinjam')

@section('content')
<div class="auth-wrapper">

    {{-- Brand Panel --}}
    <div class="auth-brand-panel">
        <div class="brand-logo">
            <div class="brand-logo-icon">💰</div>
            <span class="brand-logo-text">SimpanPinjam</span>
        </div>

        <h1 class="brand-headline">
            Kelola keuangan<br>
            Anda dengan <span>mudah</span>
        </h1>
        <p class="brand-desc">
            Platform simpan pinjam modern yang aman, transparan,
            dan mudah digunakan untuk kebutuhan finansial Anda.
        </p>

        <div class="brand-features">
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Tabung & tarik kapan saja
            </div>
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Ajukan pinjaman dengan mudah
            </div>
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Pantau transaksi secara real-time
            </div>
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="auth-form-panel">
        <div class="auth-form-inner">

            <h2 class="auth-form-title">Selamat datang 👋</h2>
            <p class="auth-form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username Anda"
                        required
                        autofocus
                    >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 8px;">
                    Masuk ke Akun
                </button>
            </form>

            <p class="auth-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>

        </div>
    </div>

</div>
@endsection
