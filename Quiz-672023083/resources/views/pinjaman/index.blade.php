@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Pinjaman</h2>

    {{-- FORM PINJAM --}}
    <form action="/pinjaman/store" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nominal</label>
            <input type="number"
                   name="nominal"
                   class="form-control"
                   min="50000"
                   max="10000000"
                   required>
        </div>

        <div class="mb-3">
            <label>Tanggal Pembayaran</label>
            <input type="date"
                   name="tanggal_pembayaran"
                   class="form-control"
                   required>
        </div>

        <button class="btn btn-primary">
            Pinjam Uang
        </button>

    </form>

    <hr>

    <h3>Daftar Pinjaman</h3>

    <table class="table table-bordered">

        <tr>
            <th>ID</th>
            <th>Nominal</th>
            <th>Sisa</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach($pinjamans as $p)

        <tr>

            <td>{{ $p->id }}</td>

            <td>Rp {{ number_format($p->nominal) }}</td>

            <td>Rp {{ number_format($p->sisa_pinjaman) }}</td>

            <td>{{ $p->status }}</td>

            <td>

                @if($p->status != 'lunas')

                <form action="/pinjaman/bayar/{{ $p->id }}"
                      method="POST">

                    @csrf

                    <input type="number"
                           name="nominal_bayar"
                           placeholder="Bayar">

                    <button class="btn btn-success btn-sm">
                        Bayar
                    </button>

                </form>

                @else

                <span class="text-success">
                    Sudah Lunas
                </span>

                @endif

            </td>

        </tr>

        @endforeach

    </table>

</div>

@endsection