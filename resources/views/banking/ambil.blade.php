<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ambil Uang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-white fw-bold text-danger">Ambil Uang</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                        @endif

                        <p class="text-secondary small mb-3">Saldo saat ini: <strong class="text-dark">Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
                        
                        <form action="{{ route('ambil') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Jumlah Penarikan (Rp)</label>
                                <input type="number" name="nominal" class="form-control" placeholder="Masukkan nominal" required autofocus>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 mb-2">Ambil Uang Sekarang</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal / Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>