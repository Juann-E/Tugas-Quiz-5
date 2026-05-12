<!DOCTYPE html>
<html lang="id">
<head>
    <title>Bayar Pinjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-info">
                    <div class="card-header bg-white fw-bold text-info">Bayar Pinjaman</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                        @endif

                        <p class="text-secondary small mb-3">Saldo Anda: <strong class="text-dark">Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
                        
                        <form action="{{ route('bayar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Pilih Pinjaman yang Ingin Dibayar</label>
                                <select name="loan_id" class="form-select" required>
                                    <option value="">-- Pilih Daftar Pinjaman --</option>
                                    @foreach($loans as $loan)
                                        <option value="{{ $loan->id }}">
                                            Pinjaman {{ $loan->created_at->format('d/m/Y') }} - Sisa Tagihan: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Nominal Pembayaran (Rp)</label>
                                <input type="number" name="nominal" class="form-control" placeholder="Masukkan jumlah bayar" required>
                            </div>
                            <button type="submit" class="btn btn-info text-dark fw-bold w-100 mb-2">Proses Pembayaran</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal / Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>