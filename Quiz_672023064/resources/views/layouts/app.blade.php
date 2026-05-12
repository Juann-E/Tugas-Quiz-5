<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GONDRONG LOAN')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background: #0f0f1a; min-height: 100vh; }

        .navbar {
            background: #1a1a2e;
            border-bottom: 1px solid #2a2a4a;
            padding: 14px 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .brand {
            font-size: 18px; font-weight: 800; color: white;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-name { font-size: 13px; color: #888; font-weight: 500; }
        .btn-logout {
            background: rgba(239,68,68,0.1);
            color: #ef4444;
            border: 1px solid rgba(239,68,68,0.3);
            padding: 6px 16px; border-radius: 8px;
            cursor: pointer; font-size: 12px; font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.2); }

        .container { max-width: 680px; margin: 24px auto; padding: 0 16px; }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.1); color: #22c55e; border: 1px solid rgba(34,197,94,0.2); }
        .alert-danger  { background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }
    </style>
    @stack('styles')
</head>
<body>
@auth
<nav class="navbar">
    <div class="brand">💈 GONDRONG LOAN</div>
    <div class="user-info">
        <span class="user-name">{{ Auth::user()->nama_lengkap }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
</nav>
@endauth
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @yield('content')
</div>
@stack('scripts')
</body>
</html>