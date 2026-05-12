<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AdaKhamid</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* 60% Biru */
            --blue-900: #0c1e4a;
            --blue-800: #0f2460;
            --blue-700: #1a3580;
            --blue-600: #1e40af;
            --blue-500: #2563eb;
            --blue-400: #3b82f6;
            --blue-300: #93c5fd;
            --blue-100: #dbeafe;
            --blue-50:  #eff6ff;
            /* 30% Emas/Golden */
            --gold-500: #d4a017;
            --gold-400: #e5b523;
            --gold-300: #f0c842;
            --gold-200: #f8dc80;
            --gold-100: #fdf3c0;
            /* 10% Putih */
            --white: #ffffff;
            --glass: rgba(255,255,255,0.07);
            --glass-border: rgba(212,160,23,0.25);
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--blue-900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated background orbs */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.4) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -15%;
            left: -5%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212,160,23,0.15) 0%, transparent 70%);
            animation: pulse 10s ease-in-out infinite reverse;
            pointer-events: none;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        /* Grid lines background */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(59,130,246,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(32px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo area */
        .logo-area {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 100px;
            padding: 0.5rem 1.25rem;
            margin-bottom: 1rem;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--gold-400), var(--gold-500));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            box-shadow: 0 4px 12px rgba(212,160,23,0.4);
        }
        .logo-name {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.3px;
        }
        .logo-tagline {
            font-size: 0.75rem;
            color: var(--gold-300);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* Card */
        .card {
            background: rgba(15, 36, 96, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(212,160,23,0.2);
            border-radius: 1.75rem;
            padding: 2.5rem 2rem;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.05) inset,
                0 24px 48px rgba(0,0,0,0.3),
                0 0 80px rgba(212,160,23,0.05);
        }

        .card-title {
            font-size: 1.625rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 0.375rem;
            letter-spacing: -0.5px;
        }
        .card-sub {
            font-size: 0.875rem;
            color: var(--blue-300);
            margin-bottom: 2rem;
            font-family: 'DM Sans', sans-serif;
        }

        /* Gold divider */
        .divider {
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-400), var(--gold-200));
            border-radius: 100px;
            margin-bottom: 1.75rem;
        }

        /* Error */
        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            padding: 0.75rem 1rem;
            border-radius: 0.875rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gold-200);
            margin-bottom: 0.5rem;
            letter-spacing: 0.3px;
        }

        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--blue-400);
            font-size: 1rem;
            pointer-events: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.875rem;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(59,130,246,0.25);
            border-radius: 0.875rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9375rem;
            color: var(--white);
            outline: none;
            transition: all 0.25s ease;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(147,197,253,0.4);
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            background: rgba(255,255,255,0.09);
            border-color: var(--gold-400);
            box-shadow:
                0 0 0 4px rgba(212,160,23,0.12),
                0 0 20px rgba(212,160,23,0.08);
        }

        /* Submit button */
        .btn-primary {
            display: block;
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--gold-400) 0%, var(--gold-500) 100%);
            color: var(--blue-900);
            border: none;
            border-radius: 0.875rem;
            font-family: 'Sora', sans-serif;
            font-size: 0.9375rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 0.2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 0.5rem;
            box-shadow: 0 8px 24px rgba(212,160,23,0.3);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212,160,23,0.45);
            filter: brightness(1.05);
        }
        .btn-primary:hover::after { opacity: 1; }
        .btn-primary:active { transform: translateY(0); }

        /* Link row */
        .link-row {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: var(--blue-300);
            font-family: 'DM Sans', sans-serif;
        }
        .link-row a {
            color: var(--gold-300);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .link-row a:hover { color: var(--gold-200); }

        /* Security badge */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: rgba(147,197,253,0.5);
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>
<body>
<div class="bg-grid"></div>

<div class="wrapper">
    <div class="logo-area">
        <div class="logo-badge">
            <div class="logo-icon">🏦</div>
            <span class="logo-name">AdaKhamid</span>
        </div>
        <div class="logo-tagline">Simpan · Pinjam · Sejahtera</div>
    </div>

    <div class="card">
        <div class="card-title">Selamat Datang</div>
        <div class="card-sub">Masuk untuk mengelola keuangan Anda</div>
        <div class="divider"></div>

        @if ($errors->any())
            <div class="alert-error">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username Anda">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔑</span>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password Anda">
                </div>
            </div>

            <button type="submit" class="btn-primary">Masuk ke Dashboard →</button>
        </form>

        <div class="link-row">
            Baru di sini? <a href="{{ route('register') }}">Buat Akun Gratis</a>
        </div>
    </div>

    <div class="security-note">
        🔒 Dilindungi enkripsi 256-bit
    </div>
</div>
</body>
</html>
