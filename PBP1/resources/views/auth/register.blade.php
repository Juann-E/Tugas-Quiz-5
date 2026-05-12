<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { width: 100%; max-width: 400px; border-radius: 8px; }
        .btn-daftar { background-color: #198754; color: white; border-radius: 6px; }
        .btn-daftar:hover { background-color: #157347; color: white; }
    </style>
</head>
<body>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 text-muted" style="font-size: 16px;">Register</h5>
            <hr class="mt-2 mb-0">
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
    <div class="alert alert-danger py-2" style="font-size: 14px;">
        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif
            <form method="POST" action="/daftar-baru">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 14px;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 14px;">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 14px;">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted" style="font-size: 14px;">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-daftar w-100 py-2 mb-3">Daftar</button>
                <div class="text-center">
                    <span class="text-muted" style="font-size: 14px;">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a></span>
                </div>
            </form>
        </div>
    </div>
</body>
</html>