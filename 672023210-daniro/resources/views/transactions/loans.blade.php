<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pinjaman</title>
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

        .container {
            max-width: 900px;
            margin: 0 auto;
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

        .navbar-buttons {
            display: flex;
            gap: 10px;
        }

        .back-btn, .btn {
            padding: 10px 20px;
            background: #194a79;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
            font-size: 14px;
        }

        .back-btn:hover, .btn:hover {
            background: #0d2a47;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-bottom: 30px;
        }

        h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .section-title {
            color: #194a79;
            font-size: 18px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #194a79;
        }

        .loan-item {
            background: #f8f9fa;
            border-left: 4px solid #194a79;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .loan-item.paid {
            border-left-color: #28a745;
            opacity: 0.7;
        }

        .loan-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .loan-description {
            color: #333;
            font-weight: 600;
            font-size: 16px;
        }

        .loan-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .loan-status.active {
            background: #fff3cd;
            color: #856404;
        }

        .loan-status.paid {
            background: #d4edda;
            color: #155724;
        }

        .loan-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .info-item {
            font-size: 13px;
        }

        .info-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            font-size: 15px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state p {
            margin-bottom: 20px;
        }

        .add-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #194a79;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .add-btn:hover {
            background: #0d2a47;
        }

        .alert {
            padding: 12px 15px;
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
    <div class="container">
        <div class="navbar">
            <h2>Daftar Pinjaman</h2>
            <div class="navbar-buttons">
                <a href="/transaction/borrow" class="btn">+ Pinjam Uang</a>
                <a href="/transaction/pay-loan" class="btn">Bayar Pinjaman</a>
                <a href="/dashboard" class="back-btn">← Kembali</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Active Loans -->
        <div class="card">
            <h3 class="section-title">Pinjaman Aktif</h3>

            @if (count($loans) > 0)
                @foreach ($loans as $loan)
                    <div class="loan-item">
                        <div class="loan-header">
                            <div>
                                <div class="loan-description">{{ $loan->description }}</div>
                            </div>
                            <span class="loan-status active">AKTIF</span>
                        </div>
                        <div class="loan-info">
                            <div class="info-item">
                                <div class="info-label">Total Pinjaman</div>
                                <div class="info-value">Rp {{ number_format($loan->amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Sisa Pinjaman</div>
                                <div class="info-value">Rp {{ number_format($loan->remaining_amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Sudah Dibayar</div>
                                <div class="info-value">Rp {{ number_format($loan->amount - $loan->remaining_amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Peminjaman</div>
                                <div class="info-value">{{ $loan->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>Tidak ada pinjaman aktif</p>
                    <a href="/transaction/borrow" class="add-btn">Pinjam Uang Sekarang</a>
                </div>
            @endif
        </div>

        <!-- Paid Loans -->
        @if (count($paidLoans) > 0)
            <div class="card">
                <h3 class="section-title">Pinjaman Lunas</h3>

                @foreach ($paidLoans as $loan)
                    <div class="loan-item paid">
                        <div class="loan-header">
                            <div>
                                <div class="loan-description">{{ $loan->description }}</div>
                            </div>
                            <span class="loan-status paid">LUNAS</span>
                        </div>
                        <div class="loan-info">
                            <div class="info-item">
                                <div class="info-label">Total Pinjaman</div>
                                <div class="info-value">Rp {{ number_format($loan->amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Peminjaman</div>
                                <div class="info-value">{{ $loan->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Lunas</div>
                                <div class="info-value">{{ $loan->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
