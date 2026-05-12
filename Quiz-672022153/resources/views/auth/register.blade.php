<!DOCTYPE html>
<html lang='id'><head>
    <meta charset='UTF-8'>
    <title>Login - KoperasiKu</title>
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:Arial,sans-serif; min-height:100vh; display:flex;
               align-items:center; justify-content:center;
               background:linear-gradient(135deg,#1565C0,#1B5E20); }
        .card { background:#fff; border-radius:12px; padding:36px;
                width:100%; max-width:400px; box-shadow:0 20px 60px rgba(0,0,0,.25); }
        .logo { text-align:center; margin-bottom:24px; }
        .logo h1 { font-size:22px; font-weight:800; color:#37474F; }
        .form-title { font-size:18px; font-weight:700; margin-bottom:20px;
                      padding-bottom:12px; border-bottom:2px solid #ECEFF1; }
        .form-group { margin-bottom:16px; }
        .form-group label { display:block; font-size:13px; font-weight:600;
                           margin-bottom:6px; color:#37474F; }
        .form-group input { width:100%; padding:10px 12px;
                           border:1.5px solid #CFD8DC; border-radius:8px;
                           font-size:14px; outline:none; }
        .form-group input:focus { border-color:#1976D2; }
        .btn { width:100%; padding:12px; border:none; border-radius:8px;
               font-size:15px; font-weight:700; cursor:pointer; }
        .btn-blue { background:#1565C0; color:#fff; }
        .alert-error { background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2;
                       padding:10px 14px; border-radius:8px; margin-bottom:14px;
                       font-size:13px; }
        .link-row { text-align:center; margin-top:16px; font-size:13px; color:#546E7A; }
        .link-row a { color:#1976D2; font-weight:600; text-decoration:none; }
    </style>
</head><body>
<div class='card'>
    <div class='logo'><h1>&#127970; KoperasiKu</h1></div>
    <div class='form-title'>Register</div>
    @if ($errors->has('login'))
        <div class='alert-error'>{{ $errors->first('login') }}</div>
    @endif
    <form method='POST' action='{{ route("register") }}'>
    @csrf
    <div class='form-group'>
        <label>Nama Lengkap</label>
        <input type='text' name='nama' value='{{ old("nama") }}'>
        @error('nama')<small style='color:red'>{{ $message }}</small>@enderror
    </div>
    <div class='form-group'>
        <label>Username</label>
        <input type='text' name='username' value='{{ old("username") }}'>
        @error('username')<small style='color:red'>{{ $message }}</small>@enderror
    </div>
    <div class='form-group'>
        <label>Password</label>
        <input type='password' name='password'>
        @error('password')<small style='color:red'>{{ $message }}</small>@enderror
    </div>
    <div class='form-group'>
        <label>Konfirmasi Password</label>
        <input type='password' name='password_confirmation'>
    </div>
    <button class='btn btn-blue' type='submit'>Daftar</button>
    </form>
    <div class='link-row'>
        Sudah punya akun? <a href='{{ route("login") }}'>Login di sini</a>
    </div>
</div>
</body></html>

