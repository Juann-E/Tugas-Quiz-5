<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .login-box { max-width: 350px; margin: 100px auto; background: #fff; padding: 30px; border: 1px solid #ddd; }
        h2 { margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; }
        .btn { width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .alert { padding: 10px; margin-bottom: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="link">
            <a href="/register">Belum punya akun?</a>
        </div>
    </div>
</body>
</html>