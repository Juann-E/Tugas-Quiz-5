{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BCS(BANK CENTRAL SALATIGA)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/background.jpg');    
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card-register { 
            border-radius: 12px; 
            border: none; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
        }
        .card-register .card-header { 
            background:  #1890e0; 
            color: white; 
            border-radius: 12px 12px 0 0; 
            font-weight: 700; 
            font-size: 1.1rem; 
        }
        .btn-daftar { 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 1rem; 
        }
        .btn-daftar:hover { 
            background-color: #388E3C; 
            color: white; 
        }
    </style>
</head>
<body>
<div class="card card-register">
    <div class="card-header p-3">Register</div>
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama lengkap" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}" placeholder="Username" required>
                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 6 karakter" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-daftar">Daftar</button>
        </form>

        <p class="text-center mt-3 mb-0 small">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
