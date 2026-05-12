<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpan Pinjam</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { text-align: center; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; }
        p { color: #666; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; border-radius: 4px; text-decoration: none; margin: 0 10px; }
        .btn-login { background: #28a745; color: white; }
        .btn-login:hover { background: #218838; }
        .btn-register { background: #007bff; color: white; }
        .btn-register:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aplikasi Simpan Pinjam</h1>
        <p>Sistem management simpanan dan pinjaman anggota</p>
        
        @if (Route::has('login'))
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                @endif
            @endauth
        @endif
    </div>
</body>
</html>