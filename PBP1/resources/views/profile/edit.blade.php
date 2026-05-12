<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">SimpanPinjamApp</a>
        <div class="ms-auto">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Notifikasi Sukses --}}
            @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('status') === 'profile-updated' ? 'Profil berhasil diperbarui!' : 'Password berhasil diganti!' }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Notifikasi Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- KARTU 1: INFORMASI PROFIL --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white font-weight-bold">Informasi Profil</div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            {{-- KARTU 2: GANTI PASSWORD --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">Ganti Password</div>
                <div class="card-body">
                    {{-- Form ini harus mandiri, tidak boleh dibungkus form lain --}}
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        {{-- TANPA @method('put') KARENA KITA PAKAI ROUTE::POST --}}

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label><br>
                            <small class="text-muted">Harus sama jika salah tidak terjadi apa apa</small>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Minimal 8 karakter.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger">Perbarui Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>