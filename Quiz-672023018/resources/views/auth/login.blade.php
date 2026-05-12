@extends('layouts.master')
@section('title','Login')
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width:400px">
  <div class="card-body p-4">
    <h5 class="mb-4">Login</h5>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->has('login'))
      <div class="alert alert-danger">{{ $errors->first('login') }}</div>
    @endif
    <form action="{{ route('login.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100 mb-3">Login</button>
    <p class="text-center mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
    </form>
  </div>
</div></div>
@endsection
