<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
            text-align: center;
            border-top: 4px solid #163055;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #87CEEB, #4a90d9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 36px;
            box-shadow: 0 8px 25px rgba(135,206,235,0.4);
        }

        h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0c2340;
            margin-bottom: 8px;
        }

        p {
            font-size: 14px;
            color: #3a5068;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        a.btn {
            display: block;
            padding: 14px 28px;
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

        a.btn-primary {
            background: linear-gradient(135deg, #163055, #0c2340);
            color: #FFD700;
            box-shadow: 0 4px 15px rgba(12,35,64,0.35);
        }

        a.btn-primary:hover {
            background: linear-gradient(135deg, #0c2340, #081a2e);
            box-shadow: 0 6px 25px rgba(12,35,64,0.5);
            transform: translateY(-1px);
        }

        a.btn-secondary {
            background: #eaf1f8;
            color: #163055;
            border: 1.5px solid #87CEEB;
        }

        a.btn-secondary:hover {
            background: #d4e8fc;
            border-color: #4a90d9;
            color: #0c2340;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-circle">💰</div>
        <h1>Selamat Datang</h1>
        <p>Aplikasi Tabungan & Pinjaman<br>Kelola keuangan Anda dengan mudah</p>
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn btn-primary">🔐 Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">📝 Register</a>
        </div>
    </div>
</body>
</html>