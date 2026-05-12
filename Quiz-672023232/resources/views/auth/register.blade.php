@extends('layouts.app')
@section('title', 'Daftar — SimpanPinjam')

@section('content')
<div class="auth-wrapper">

    {{-- Brand Panel --}}
    <div class="auth-brand-panel">
        <div class="brand-logo">
            <div class="brand-logo-icon">💰</div>
            <span class="brand-logo-text">SimpanPinjam</span>
        </div>

        <h1 class="brand-headline">
            Bergabung dan<br>
            mulai <span>menabung</span>
        </h1>
        <p class="brand-desc">
            Buat akun gratis dan nikmati kemudahan mengelola tabungan
            serta pinjaman dalam satu platform terpercaya.
        </p>

        <div class="brand-features">
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Daftar gratis, tanpa biaya admin
            </div>
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Data Anda aman & terenkripsi
            </div>
            <div class="brand-feature">
                <div class="brand-feature-dot"></div>
                Akses 24 jam, 7 hari seminggu
            </div>
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="auth-form-panel">
        <div class="auth-form-inner">

            <h2 class="auth-form-title">Buat akun baru</h2>
            <p class="auth-form-subtitle">Isi data diri Anda di bawah ini</p>

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        placeholder="Nama sesuai KTP"
                        required
                        autofocus
                    >
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Pilih username unik"
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password Anda"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 8px;">
                    Buat Akun
                </button>
            </form>

            <p class="auth-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>

        </div>
    </div>

</div>
@endsection
