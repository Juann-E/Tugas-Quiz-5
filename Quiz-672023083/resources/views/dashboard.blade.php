@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Dashboard</h1>

    <div class="card p-3 mb-3">
        <h3>Saldo Tabungan</h3>
        <h2>Rp {{ number_format($saldo) }}</h2>
    </div>

    <div class="card p-3 mb-3">
        <h3>Total Pinjaman</h3>
        <h2>Rp {{ number_format($totalPinjaman) }}</h2>
    </div>

    {{-- TABUNG --}}
    <div class="card p-3 mb-3">

        <h4>Tabung Uang</h4>

        <form action="/tabung" method="POST">

            @csrf

            <input type="number"
                name="nominal"
                class="form-control mb-2"
                placeholder="Nominal">

            <button class="btn btn-primary">
                Tabung
            </button>

        </form>

    </div>

    {{-- AMBIL --}}
    <div class="card p-3 mb-3">

        <h4>Ambil Uang</h4>

        <form action="/ambil" method="POST">

            @csrf

            <input type="number"
                name="nominal"
                class="form-control mb-2"
                placeholder="Nominal">

            <button class="btn btn-danger">
                Ambil
            </button>

        </form>

    </div>

    <a href="/pinjaman" class="btn btn-success">
        Menu Pinjaman
    </a>

    <hr>

    <h3>Riwayat Transaksi</h3>

    <table class="table table-bordered">

        <tr>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Tanggal</th>
        </tr>

        @foreach($riwayat as $r)

        <tr>

            <td>

                @if($r['jenis'] == 'tabung')

                <span class="badge bg-primary">
                    Tabung
                </span>

                @elseif($r['jenis'] == 'ambil')

                <span class="badge bg-danger">
                    Ambil
                </span>

                @elseif($r['jenis'] == 'pinjam')

                <span class="badge bg-warning text-dark">
                    Pinjam
                </span>

                @else

                <span class="badge bg-success">
                    Bayar Pinjaman
                </span>

                @endif

            </td>

            <td>
                Rp {{ number_format($r['nominal']) }}
            </td>

            <td>
                {{ $r['tanggal'] }}
            </td>

        </tr>

        @endforeach

    </table>

</div>

@endsection