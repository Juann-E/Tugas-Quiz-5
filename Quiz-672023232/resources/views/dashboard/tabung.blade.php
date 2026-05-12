@extends('layouts.app')
@section('title', 'Tabung Uang — SimpanPinjam')

@section('content')
<div class="page-wrapper">

    <a href="{{ route('dashboard') }}" class="back-link">Kembali ke Dashboard</a>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="inner-card">
        <div class="inner-card-title">💵 Tabung Uang</div>
        <p class="inner-card-subtitle">
            Tambahkan dana ke saldo tabungan Anda. Dana akan langsung masuk setelah konfirmasi.
        </p>

        <div class="divider"></div>

        <form method="POST" action="{{ route('tabung.post') }}">
            @csrf
            <div class="form-group">
                <label for="jumlah">Jumlah Tabungan (Rp)</label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    value="{{ old('jumlah') }}"
                    placeholder="Contoh: 500000"
                    min="1"
                    required
                    autofocus
                >
            </div>
            <button type="submit" class="btn btn-green">
                Simpan Tabungan
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn btn-gray">
            Batal
        </a>
    </div>

</div>
@endsection
