{{-- resources/views/tabungan/tabung.blade.php --}}
@extends('layouts.koperasi')
@section('title', 'Tabung Uang')
@section('content')

{{-- Saldo Card --}}
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
        <h5 class="fw-bold mb-4">Tabung Uang</h5>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('tabung.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jumlah Tabungan (Rp)</label>
                <input type="number" name="jumlah" class="form-control form-control-lg @error('jumlah') is-invalid @enderror"
                    value="{{ old('jumlah') }}" min="1000" placeholder="0" required>
                @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-tabung w-100 mb-2">Simpan Tabungan</button>
            <a href="{{ route('dashboard') }}" class="btn w-100" style="background:#607D8B;color:white;">Batal</a>
        </form>
    </div>
</div>

@endsection
