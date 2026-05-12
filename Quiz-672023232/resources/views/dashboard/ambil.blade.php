@extends('layouts.app')
@section('title', 'Ambil Uang — SimpanPinjam')

@section('content')
<div class="page-wrapper">

    <a href="{{ route('dashboard') }}" class="back-link">Kembali ke Dashboard</a>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="inner-card">
        <div class="inner-card-title">💸 Ambil Uang</div>
        <p class="inner-card-subtitle">
            Tarik dana dari saldo tabungan Anda. Pastikan saldo mencukupi sebelum melakukan penarikan.
        </p>

        <div class="saldo-info-bar">
            <span class="saldo-info-label">Saldo Tersedia</span>
            <span class="saldo-info-value">Rp {{ number_format($user->saldo, 0, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('ambil.post') }}">
            @csrf
            <div class="form-group">
                <label for="jumlah">Jumlah Penarikan (Rp)</label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    value="{{ old('jumlah') }}"
                    placeholder="Masukkan nominal penarikan"
                    min="1"
                    max="{{ $user->saldo }}"
                    required
                    autofocus
                >
            </div>
            <button type="submit" class="btn btn-red">
                Ambil Uang
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn btn-gray">
            Batal
        </a>
    </div>

</div>
@endsection
