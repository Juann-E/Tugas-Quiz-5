<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
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

        .back-btn {
            padding: 10px 20px;
            background: #194a79;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #0d2a47;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .balance-info {
            background: #f8f9fa;
            border-left: 4px solid #194a79;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .balance-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .balance-amount {
            color: #194a79;
            font-size: 24px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #194a79;
        }

        table th {
            padding: 15px;
            text-align: left;
            color: #194a79;
            font-weight: 600;
            font-size: 14px;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .type-savings {
            background: #d4edda;
            color: #155724;
        }

        .type-withdrawal {
            background: #f8d7da;
            color: #721c24;
        }

        .amount {
            font-weight: 600;
            color: #333;
        }

        .amount.positive {
            color: #28a745;
        }

        .amount.negative {
            color: #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #194a79;
            border-radius: 5px;
            color: #194a79;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination a:hover {
            background: #194a79;
            color: white;
        }

        .pagination .active {
            background: #194a79;
            color: white;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h2>Riwayat Transaksi</h2>
            <a href="/dashboard" class="back-btn">← Kembali</a>
        </div>

        <div class="card">
            <h1>Riwayat Transaksi Anda</h1>

            <div class="balance-info">
                <p>Total Saldo Anda</p>
                <div class="balance-amount">Rp {{ number_format($balance, 2, ',', '.') }}</div>
            </div>

            @if (count($transactions) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="type-badge {{ $transaction->type === 'savings' ? 'type-savings' : 'type-withdrawal' }}">
                                        {{ $transaction->type === 'savings' ? 'Penabungan' : 'Penarikan' }}
                                    </span>
                                </td>
                                <td>{{ $transaction->description }}</td>
                                <td style="text-align: right;">
                                    <span class="amount {{ $transaction->type === 'savings' ? 'positive' : 'negative' }}">
                                        {{ $transaction->type === 'savings' ? '+' : '-' }}
                                        Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($transactions->hasPages())
                    <div class="pagination">
                        {{ $transactions->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <p>Tidak ada data transaksi</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
