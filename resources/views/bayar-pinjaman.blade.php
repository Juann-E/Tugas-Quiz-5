@extends('layouts.app')

@section('title', 'Bayar Pinjaman')

@section('content')
<div class="header header-birumuda">
    <h2>Bayar Pinjaman</h2>
</div>

<div class="card">
    @if($pinjaman->isEmpty())
        <p>Tidak ada pinjaman aktif</p>
    @else
        <form method="POST" action="/bayar-pinjaman">
            @csrf
            <div class="form-group">
                <label>Pilih Pinjaman</label>
                <select name="pinjaman_id" required>
                    <option value="">-- Pilih --</option>
                    @foreach($pinjaman as $p)
                    <option value="{{ $p->id }}">
                        #{{ $p->id }} - Rp {{ number_format($p->jumlah, 0, ',', '.') }} (Sisa: Rp {{ number_format($p->jumlah - $p->jumlah_dibayar, 0, ',', '.') }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Bayar</label>
                <input type="number" name="jumlah" min="1000" required>
            </div>
            <button type="submit" class="btn btn-info">Bayar</button>
        </form>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <h3>Daftar Pinjaman</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Jumlah</th>
                <th>Dibayar</th>
                <th>Sisa</th>
            </tr>
            @foreach($pinjaman as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($p->jumlah_dibayar, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($p->jumlah - $p->jumlah_dibayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    @endif
    <p style="margin-top: 15px;"><a href="/dashboard">Kembali</a></p>
</div>
@endsection