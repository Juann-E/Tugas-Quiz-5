@extends('layouts.master')
@section('title','Register')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:400px">
  <div class="card-body p-4">
    <h5 class="mb-4">Register</h5>
    <form action="{{ route('register.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
      @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
      @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100 mb-3">Daftar</button>
    <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </form>
  </div>
</div></div>
@endsection
