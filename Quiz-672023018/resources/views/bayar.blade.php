@extends('layouts.master')
@section('title','Bayar Pinjaman')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:450px">
  <div class="card-body p-4">
    <h5 class="mb-1">Bayar Pinjaman</h5>
    <p class="mb-3">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>

    @if($loans->count() == 0)
      <div class="alert alert-info">Anda tidak memiliki pinjaman aktif.</div>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Kembali</a>
    @else
      <form action="{{ route('bayar.post') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Pilih Pinjaman</label>
        <select name="loan_id" class="form-select" required>
          @foreach($loans as $loan)
            <option value="{{ $loan->id }}">
              Pinjaman {{ $loan->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Jumlah Pembayaran (Rp)</label>
        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" min="1000" required>
        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <button type="submit" class="btn btn-info w-100 mb-2">Bayar Pinjaman</button>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal</a>
      </form>
    @endif
  </div>
</div></div>
@endsection
