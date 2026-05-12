<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tabung Uang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-success">
                    <div class="card-header bg-white fw-bold text-success">Tabung Uang</div>
                    <div class="card-body">
                        <form action="{{ route('tabung') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Jumlah Tabungan (Rp)</label>
                                <input type="number" name="nominal" class="form-control" required autofocus>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2">Simpan Tabungan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Batal / Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>