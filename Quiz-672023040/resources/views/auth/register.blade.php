<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(160deg, #e0f0ff 0%, #d4e8fc 40%, #c9ddf5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #1a2744;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 48px 40px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(12,35,64,0.12), 0 0 0 1px rgba(12,35,64,0.06);
            border-top: 4px solid #163055;
        }

        h2 {
            font-size: 24px;
            font-weight: 800;
            color: #0c2340;
            margin-bottom: 8px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #6b7fa3;
            margin-bottom: 28px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert ul {
            margin: 0;
            padding-left: 16px;
        }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #3a5068;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #bfd4ea;
            border-radius: 12px;
            font-size: 15px;
            background: #f8fafc;
            color: #1a2744;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4a90d9;
            box-shadow: 0 0 0 3px rgba(135,206,235,0.2);
            background: #fff;
        }

        .error {
            color: #f87171;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #163055, #0c2340);
            color: #FFD700;
            box-shadow: 0 4px 15px rgba(12,35,64,0.3);
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0c2340, #081a2e);
            box-shadow: 0 6px 25px rgba(12,35,64,0.5);
            transform: translateY(-1px);
        }

        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7fa3;
        }

        .link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .link a:hover {
            color: #1a4a8a;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>📝 Register</h2>
        <p class="subtitle">Buat akun baru Anda</p>

        @if(session('error'))
            <div class="alert alert-danger">⚠️ {{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                @error('name')<span class="error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="Pilih username">
                @error('username')<span class="error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Buat password">
                @error('password')<span class="error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password">
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>