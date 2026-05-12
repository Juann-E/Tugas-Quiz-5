<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Simpan Pinjam')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #007bff; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 600px; margin: 20px auto; padding: 0 15px; }
        .card { background: #fff; padding: 20px; margin-bottom: 15px; border: 1px solid #ddd; }
        .header { padding: 15px 20px; margin-bottom: 15px; color: #fff; }
        .header-biru { background: #007bff; }
        .header-hijau { background: #28a745; }
        .header-merah { background: #dc3545; }
        .header-kuning { background: #f39c12; }
        .header-birumuda { background: #17a2b8; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; }
        .btn { padding: 10px 20px; border: none; cursor: pointer; color: #fff; }
        .btn-primary { background: #007bff; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #f39c12; }
        .btn-info { background: #17a2b8; }
        .alert { padding: 10px; margin-bottom: 15px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        a { color: #007bff; text-decoration: none; }
        .menu { display: flex; gap: 10px; flex-wrap: wrap; }
        .menu a { flex: 1; text-align: center; padding: 15px; color: #fff; }
        .menu a:hover { opacity: 0.9; }
        .menu-tabung { background: #28a745; }
        .menu-ambil { background: #dc3545; }
        .menu-pinjam { background: #f39c12; }
        .menu-bayar { background: #17a2b8; }
    </style>
</head>
<body>
    @auth
        <nav class="navbar">
            <span style="font-size: 1.2rem;">Aplikasi Simpan Pinjam</span>
            <span>{{ auth()->user()->name }} - 
            <form method="POST" action="/logout" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">Logout</button>
            </form>
            </span>
        </nav>
    @endauth
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>