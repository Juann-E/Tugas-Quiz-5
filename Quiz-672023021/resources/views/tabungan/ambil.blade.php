{{-- resources/views/tabungan/ambil.blade.php --}}
@extends('layouts.koperasi')
@section('title', 'Ambil Uang')
@section('content')

<div class="saldo-card">
    <div class="label">Saldo Anda</div>
    <div class="amount">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
</div>

<div class="action-grid mb-4">
    <a href="{{ route('tabung.form') }}" class="btn btn-tabung text-center">Tabung</a>
    <a href="{{ route('ambil.form') }}"  class="btn btn-ambil text-center">Ambil</a>
    <a href="{{ route('pinjam.form') }}" class="btn btn-pinjam text-center">Pinjam</a>
    <a href="{{ route('bayar.form') }}"  class="btn btn-bayar text-center">Bayar Pinjaman</a>
</div>

<div class="card card-form">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1">Ambil Uang</h5>
        <p class="text-muted mb-4">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('ambil.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jumlah Penarikan (Rp)</label>
                <input type="number" name="jumlah" class="form-control form-control-lg @error('jumlah') is-invalid @enderror"
                    value="{{ old('jumlah') }}" min="1000" max="{{ $user->saldo }}" placeholder="0" required>
                @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-ambil w-100 mb-2">Ambil Uang</button>
            <a href="{{ route('dashboard') }}" class="btn w-100" style="background:#607D8B;color:white;">Batal</a>
        </form>
    </div>
</div>

@endsection
