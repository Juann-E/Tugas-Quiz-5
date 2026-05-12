@extends('layouts.master')
@section('title','Ajukan Pinjaman')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:450px">
  <div class="card-body p-4">
    <h5 class="mb-3">Ajukan Pinjaman</h5>
    <div class="alert alert-info">Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</div>
    <form action="{{ route('pinjam.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Jumlah Pinjaman (Rp)</label>
      <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" min="1000" required>
      @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-warning w-100 mb-2">Ajukan Pinjaman</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal</a>
    </form>
  </div>
</div></div>
@endsection
