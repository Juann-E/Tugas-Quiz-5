<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Simpan Pinjam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .card-saldo { background: linear-gradient(45deg, #1e3c72, #2a5298); color: white; border-radius: 20px; }
        .btn-action { border-radius: 15px; padding: 20px; font-weight: bold; transition: 0.3s; }
        .btn-action:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card card-saldo shadow-lg mb-4">
        <div class="card-body text-center">
            <h5 class="text-uppercase opacity-75">Total Saldo Anda</h5>
            <h1 class="display-3 font-weight-bold">
                Rp {{ Auth::check() ? number_format(Auth::user()->balance, 0, ',', '.') : '0' }}
            </h1>
            @if(!Auth::check())
                <p class="badge badge-warning">Peringatan: Anda belum login!</p>
            @endif
        </div>
    </div>

    <div class="row text-center mb-5">
        <div class="col-4">
            <button class="btn btn-success btn-block btn-action shadow" data-toggle="modal" data-target="#modalTabung">TABUNG</button>
        </div>
        <div class="col-4">
            <button class="btn btn-warning btn-block btn-action shadow text-white" data-toggle="modal" data-target="#modalAmbil">AMBIL</button>
        </div>
        <div class="col-4">
            <button class="btn btn-danger btn-block btn-action shadow" data-toggle="modal" data-target="#modalPinjam">PINJAM</button>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white font-weight-bold">Daftar Pinjaman Aktif (Pilih untuk melunasi)</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Sisa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr>
                        <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                        <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                        <td class="text-danger font-weight-bold">Rp {{ number_format($loan->remaining, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('bayar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                <button type="submit" class="btn btn-sm btn-primary px-4 shadow-sm">LUNASI</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">Anda tidak memiliki pinjaman aktif</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTabung" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tabung') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Tambah Tabungan</h5></div>
            <div class="modal-body">
                <label>Jumlah (Rp)</label>
                <input type="number" name="amount" class="form-control" placeholder="Contoh: 10000" required>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-success">Simpan Tabungan</button></div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalAmbil" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('ambil') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Tarik Tunai</h5></div>
            <div class="modal-body">
                <label>Jumlah yang diambil (Rp)</label>
                <input type="number" name="amount" class="form-control" placeholder="Contoh: 5000" required>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-warning text-white">Tarik Uang</button></div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pinjam') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Ajukan Pinjaman</h5></div>
            <div class="modal-body">
                <label>Jumlah Pinjaman (Rp)</label>
                <input type="number" name="amount" class="form-control" placeholder="Minimal 1000" required>
                <small class="text-muted">Pinjaman akan otomatis menambah saldo Anda.</small>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-danger">Ajukan Sekarang</button></div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>