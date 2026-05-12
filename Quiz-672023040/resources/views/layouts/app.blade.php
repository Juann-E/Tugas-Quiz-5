<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Tabungan')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #eaf1f8;
            color: #1a2744;
            min-height: 100vh;
        }

        /* Navbar - Navy */
        .navbar {
            background: linear-gradient(135deg, #0c2340 0%, #163055 100%);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(12,35,64,0.35);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color: #FFD700;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-nav a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-nav a:hover {
            color: #fff;
            background: rgba(255,215,0,0.15);
        }

        .btn-logout-nav {
            background: rgba(255,215,0,0.12);
            color: #FFD700;
            border: 1px solid rgba(255,215,0,0.3);
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-logout-nav:hover {
            background: rgba(255,215,0,0.25);
            color: #fff;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        /* Alerts */
        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(34,197,94,0.03) 100%);
            color: #166534;
            border: 1px solid rgba(34,197,94,0.25);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239,68,68,0.1) 0%, rgba(239,68,68,0.03) 100%);
            color: #991b1b;
            border: 1px solid rgba(239,68,68,0.25);
        }

        @yield('styles')
    </style>
</head>
<body>
    @if(Auth::check())
    <nav class="navbar">
        <div class="navbar-brand">💰 <span>TabunganKu</span></div>
        <div class="navbar-nav">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout-nav">🚪 Logout</button>
            </form>
        </div>
    </nav>
    @endif

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>