@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card header-biru">
    <h2 style="color: #fff;">Saldo: Rp {{ number_format($user->saldo_tabungan, 0, ',', '.') }}</h2>
</div>

<div class="card">
    <h3 style="margin-bottom: 15px;">Menu</h3>
    <div class="menu">
        <a href="/tabung" class="menu-tabung">Tabung</a>
        <a href="/ambil" class="menu-ambil">Ambil</a>
        <a href="/pinjam" class="menu-pinjam">Pinjam</a>
        <a href="/bayar-pinjaman" class="menu-bayar">Bayar Pinjaman</a>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 15px;">Pinjaman Aktif</h3>
    @if($pinjamanAktif->isEmpty())
        <p>Tidak ada pinjaman aktif</p>
    @else
        <table>
            <tr>
                <th>ID</th>
                <th>Jumlah</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
            @foreach($pinjamanAktif as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($p->jumlah_dibayar, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($p->jumlah - $p->jumlah_dibayar, 0, ',', '.') }}</td>
                <td>{{ ucfirst($p->status) }}</td>
            </tr>
            @endforeach
        </table>
    @endif
</div>
@endsection