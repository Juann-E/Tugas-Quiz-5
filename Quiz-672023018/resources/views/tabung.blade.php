@extends('layouts.master')
@section('title','Tabung Uang')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:450px">
  <div class="card-body p-4">
    <h5 class="mb-4">Tabung Uang</h5>
    <form action="{{ route('tabung.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Jumlah Tabungan (Rp)</label>
      <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" min="1000" required>
      @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-success w-100 mb-2">Simpan Tabungan</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal</a>
    </form>
  </div>
</div></div>
@endsection
