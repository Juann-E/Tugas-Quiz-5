@extends('layouts.app')

@section('title', 'Pinjam')

@section('content')
<div class="header header-kuning">
    <h2>Pinjam Uang</h2>
</div>

<div class="card">
    <form method="POST" action="/pinjam">
        @csrf
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" min="10000" required>
        </div>
        <button type="submit" class="btn btn-warning">Ajukan</button>
    </form>
    <p style="margin-top: 15px;"><a href="/dashboard">Kembali</a></p>
</div>
@endsection