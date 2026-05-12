<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #194a79;
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .navbar h2 {
            color: #333;
            font-size: 24px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info span {
            color: #555;
            font-weight: 600;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #194a79;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .balance-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            margin-bottom: 30px;
        }

        .balance-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .balance-amount {
            color: #194a79;
            font-size: 42px;
            font-weight: 700;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .feature-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid #194a79;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(25, 74, 121, 0.3);
        }

        .feature-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #194a79;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .feature-card p {
            color: #666;
            font-size: 13px;
        }

        .info-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }

        .section-title {
            color: #194a79;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #194a79;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-size: 14px;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Dashboard</h2>
        <div class="navbar-right">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="balance-section">
            <div class="balance-label">Total Saldo Anda</div>
            <div class="balance-amount">Rp {{ number_format(Auth::user()->getBalance(), 2, ',', '.') }}</div>
        </div>

        <div class="features">
            <a href="{{ route('transaction.showSave') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Penabungan</h3>
                <p>Tabung uang Anda</p>
            </a>
            <a href="{{ route('transaction.showWithdraw') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Penarikan</h3>
                <p>Tarik uang Anda</p>
            </a>
            <a href="{{ route('transaction.showBorrow') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Peminjaman</h3>
                <p>Pinjam uang</p>
            </a>
            <a href="{{ route('transaction.showPayLoan') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Bayar Pinjaman</h3>
                <p>Lunasi pinjaman</p>
            </a>
            <a href="{{ route('transaction.history') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Riwayat</h3>
                <p>Lihat riwayat transaksi</p>
            </a>
            <a href="{{ route('transaction.loans') }}" class="feature-card">
                <div class="icon"></div>
                <h3>Daftar Pinjaman</h3>
                <p>Lihat semua pinjaman</p>
            </a>
        </div>

        <div class="info-section">
            <h3 class="section-title">Informasi Akun</h3>
            <div class="info-item">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ Auth::user()->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ Auth::user()->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Bergabung Sejak</span>
                <span class="info-value">{{ Auth::user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>