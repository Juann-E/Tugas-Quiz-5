@extends('layouts.app')
@section('title', 'Dashboard — SimpanPinjam')

@section('content')
<div class="page-wrapper">

    {{-- Top Bar --}}
    <div class="topbar">
        <div class="topbar-logo">
            <div class="topbar-logo-icon">💰</div>
            <span class="topbar-logo-text">SimpanPinjam</span>
        </div>
        <div class="topbar-user">
            <div class="topbar-greeting">
                <span>Selamat datang,</span>
                <strong>{{ $user->nama_lengkap ?? $user->username }}</strong>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Saldo Card --}}
    <div class="saldo-card">
        <div class="saldo-label">Total Saldo Anda</div>
        <div class="saldo-amount">
            <span class="currency">Rp</span>{{ number_format($user->saldo, 0, ',', '.') }}
        </div>
        <div class="saldo-hint">Diperbarui secara otomatis setiap transaksi</div>
    </div>

    {{-- Action Buttons --}}
    <div class="action-row">
        <a href="{{ route('tabung') }}" class="action-btn">
            <div class="action-btn-icon green">💵</div>
            Tabung
        </a>
        <a href="{{ route('ambil') }}" class="action-btn">
            <div class="action-btn-icon red">💸</div>
            Ambil
        </a>
        <a href="{{ route('pinjam') }}" class="action-btn">
            <div class="action-btn-icon amber">📋</div>
            Pinjam
        </a>
        <a href="{{ route('bayar') }}" class="action-btn">
            <div class="action-btn-icon cyan">✅</div>
            Bayar
        </a>
    </div>

    {{-- Pinjaman Aktif --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">Pinjaman Aktif</span>
            <span class="table-card-meta">{{ $pinjamanAktif->count() }} pinjaman</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Pinjaman</th>
                    <th>Sisa Pinjaman</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pinjamanAktif as $p)
                    <tr>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->sisa, 0, ',', '.') }}</td>
                        <td><span class="badge badge-active">Aktif</span></td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="4">
                            🎉 Tidak ada pinjaman aktif saat ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
