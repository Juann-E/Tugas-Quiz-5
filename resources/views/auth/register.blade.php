<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .register-box { max-width: 350px; margin: 80px auto; background: #fff; padding: 30px; border: 1px solid #ddd; }
        h2 { margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; }
        .btn { width: 100%; padding: 10px; background: #28a745; color: #fff; border: none; cursor: pointer; }
        .btn:hover { background: #218838; }
        .alert { padding: 10px; margin-bottom: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>
        <div class="link">
            <a href="/login">Sudah punya akun?</a>
        </div>
    </div>
</body>
</html>