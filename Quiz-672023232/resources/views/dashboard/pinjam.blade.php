@extends('layouts.app')
@section('title', 'Ajukan Pinjaman — SimpanPinjam')

@section('content')
<div class="page-wrapper">

    <a href="{{ route('dashboard') }}" class="back-link">Kembali ke Dashboard</a>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="inner-card">
        <div class="inner-card-title">📋 Ajukan Pinjaman</div>
        <p class="inner-card-subtitle">
            Isi formulir di bawah untuk mengajukan pinjaman baru.
        </p>

        <div class="info-box">
            Dana pinjaman yang disetujui akan langsung ditambahkan ke saldo akun Anda secara otomatis.
        </div>

        <form method="POST" action="{{ route('pinjam.post') }}">
            @csrf
            <div class="form-group">
                <label for="jumlah">Jumlah Pinjaman (Rp)</label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    value="{{ old('jumlah') }}"
                    placeholder="Contoh: 1000000"
                    min="1"
                    required
                    autofocus
                >
            </div>
            <button type="submit" class="btn btn-yellow">
                Ajukan Pinjaman
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn btn-gray">
            Batal
        </a>
    </div>

</div>
@endsection
