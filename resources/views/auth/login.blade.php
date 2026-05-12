{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BCS</title>
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
        .card-login { 
            border-radius: 12px; 
            border: none; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
            width: 100%; max-width: 400px; 
        }
        .card-login .card-header { 
            background: #1890e0; 
            color: white; 
            border-radius: 12px 12px 0 0; 
            font-weight: 700; 
            font-size: 1.1rem; 
        }
        .btn-login { 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 1rem; 
        }
        .btn-login:hover { 
            background-color: #388E3C; 
            color: white; 
        }
    </style>
</head>
<body>
<div class="card card-login">
    <div class="card-header p-3">LOGIN - BANK CENTRAL SALATIGA</div>
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-login">Masuk</button>
        </form>

        <p class="text-center mt-3 mb-0 small">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
