<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ajukan Pinjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-white fw-bold text-warning">Ajukan Pinjaman</div>
                    <div class="card-body">
                        <div class="alert alert-warning py-2 small border-warning">
                            Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.
                        </div>
                        
                        <form action="{{ route('pinjam') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Jumlah Pinjaman (Rp)</label>
                                <input type="number" name="nominal" class="form-control" placeholder="Contoh: 500000" required autofocus>
                                <div class="form-text text-danger small fw-bold">
                                    Limit pinjaman Anda saat ini: Rp {{ number_format(auth()->user()->saldo * 0.5, 0, ',', '.') }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning text-dark fw-bold w-100 mb-2">Ajukan Sekarang</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal / Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>