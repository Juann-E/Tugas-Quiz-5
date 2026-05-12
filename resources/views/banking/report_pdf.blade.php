<!DOCTYPE html>
<html>
<head>
    <title>Rekening Koran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN REKENING KORAN</h2>
        <h3>M-BANKING APP</h3>
    </div>

    <div class="info">
        <p><strong>Nama Nasabah:</strong> {{ $user->name }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ $date }}</p>
        <p><strong>Total Saldo Saat Ini:</strong> Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ strtoupper($trx->type) }}</td>
                <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                <td>{{ $trx->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem pada {{ date('d M Y H:i:s') }}</p>
    </div>
</body>
</html>