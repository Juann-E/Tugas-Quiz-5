{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.koperasi')

@section('title', 'Dashboard')

@section('content')

<div class="saldo-card">
    <div class="label">Saldo Anda</div>
    <div class="amount">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
</div>
<div class="action-grid mb-4">
    <a href="{{ route('tabung.form') }}" class="btn btn-tabung text-center">Tabung</a>
    <a href="{{ route('ambil.form') }}"  class="btn btn-ambil text-center">Ambil</a>
    <a href="{{ route('pinjam.form') }}" class="btn btn-pinjam text-center">Pinjam</a>
    <a href="{{ route('bayar.form') }}"  class="btn btn-bayar text-center">Bayar Pinjaman</a>
</div>
<div class="card card-form">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Pinjaman Aktif</h6>
        @if($pinjaman->isEmpty())
            <p class="text-center text-muted mb-0">Anda tidak memiliki pinjaman aktif.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Pinjaman</th>
                            <th>Sisa Pinjaman</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjaman as $p)
                        <tr>
                            <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td>Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status === 'active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-lunas">Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
