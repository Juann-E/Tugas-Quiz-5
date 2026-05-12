    @extends('layouts.master')
@section('title','Ambil Uang')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:450px">
  <div class="card-body p-4">
    <h5 class="mb-1">Ambil Uang</h5>
    <p class="mb-3">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
    <form action="{{ route('ambil.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Jumlah Penarikan (Rp)</label>
      <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" min="1000" max="{{ $user->saldo }}" required>
      @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-danger w-100 mb-2">Ambil Uang</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal</a>
    </form>
  </div>
</div></div>
@endsection
