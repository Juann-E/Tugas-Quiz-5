@extends('layouts.app')

@section('title', 'Ambil')

@section('content')
<div class="header header-merah">
    <h2>Ambil Uang</h2>
</div>

<div class="card">
    <p style="margin-bottom: 15px;">Saldo: <strong>Rp {{ number_format(auth()->user()->saldo_tabungan, 0, ',', '.') }}</strong></p>
    <form method="POST" action="/ambil">
        @csrf
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1000" required>
        </div>
        <button type="submit" class="btn btn-danger">Ambil</button>
    </form>
    <p style="margin-top: 15px;"><a href="/dashboard">Kembali</a></p>
</div>
@endsection