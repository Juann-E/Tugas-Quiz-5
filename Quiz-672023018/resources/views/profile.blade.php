@extends('layouts.master')
@section('title', 'Profile')
@section('content')
<div class="container py-4">

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-4">

    {{-- Info Profile --}}
    <div class="col-md-4">
      <div class="card text-center p-4">
        <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center mx-auto mb-3"
             style="width:80px;height:80px;font-size:32px;font-weight:bold">
          {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
        </div>
        <h5 class="mb-1">{{ $user->nama_lengkap }}</h5>
        <p class="text-muted mb-1">{{ $user->username }}</p>
        <p class="text-muted small mb-3">Bergabung: {{ $user->created_at->format('d M Y') }}</p>
        <div class="card bg-info text-white py-2">
          <small class="mb-0">Saldo</small>
          <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger w-100 mt-3">Logout</a>
      </div>
    </div>

    <div class="col-md-8">

      {{-- Edit Profile --}}
      <div class="card mb-4">
        <div class="card-header fw-bold">Edit Profil</div>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap"
                   class="form-control @error('nama_lengkap') is-invalid @enderror"
                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
            @error('nama_lengkap')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="{{ $user->username }}" disabled>
            <small class="text-muted">Username tidak dapat diubah</small>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
          </form>
        </div>
      </div>

      {{-- Ganti Password --}}
      <div class="card">
        <div class="card-header fw-bold">Ganti Password</div>
        <div class="card-body">
          <form action="{{ route('profile.password') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" name="password_lama"
                   class="form-control @error('password_lama') is-invalid @enderror" required>
            @error('password_lama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-warning">Ganti Password</button>
          </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
