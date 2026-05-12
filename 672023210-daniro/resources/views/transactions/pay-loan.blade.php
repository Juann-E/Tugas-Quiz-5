<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pinjaman</title>
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
            max-width: 600px;
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
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        select,
        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        select:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #194a79;
            box-shadow: 0 0 0 3px rgba(25, 74, 121, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .loan-info {
            background: #f8f9fa;
            border-left: 4px solid #194a79;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .loan-info.show {
            display: block;
        }

        .loan-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .loan-info strong {
            color: #194a79;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #194a79;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(25, 74, 121, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h2>Bayar Pinjaman</h2>
            <a href="/dashboard" class="back-btn">← Kembali</a>
        </div>

        <div class="card">
            <h1>Bayar Pinjaman</h1>

            @if (count($loans) === 0)
                <div class="alert alert-info">
                    Anda tidak memiliki pinjaman aktif.
                </div>
                <a href="/dashboard" class="back-btn" style="text-align: center; display: block;">Kembali ke Dashboard</a>
            @else
                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('transaction.payLoan') }}">
                    @csrf

                    <div class="form-group">
                        <label for="loan_id">Pilih Pinjaman</label>
                        <select id="loan_id" name="loan_id" required onchange="updateLoanInfo()">
                            <option value="">-- Pilih Pinjaman --</option>
                            @foreach ($loans as $loan)
                                <option value="{{ $loan->id }}" 
                                    data-total="{{ $loan->amount }}" 
                                    data-remaining="{{ $loan->remaining_amount }}"
                                    data-date="{{ $loan->created_at->format('d/m/Y H:i') }}"
                                    data-description="{{ $loan->description }}">
                                    {{ $loan->description }} (Rp {{ number_format($loan->remaining_amount, 2, ',', '.') }} sisa)
                                </option>
                            @endforeach
                        </select>
                        @error('loan_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="loan-info" id="loanInfo">
                        <p><strong>Total Pinjaman:</strong> Rp <span id="totalAmount">0</span></p>
                        <p><strong>Sisa Pinjaman:</strong> Rp <span id="remainingAmount">0</span></p>
                        <p><strong>Tanggal Peminjaman:</strong> <span id="loanDate">-</span></p>
                        <p><strong>Keterangan:</strong> <span id="loanDescription">-</span></p>
                    </div>

                    <div class="form-group">
                        <label for="amount">Jumlah Pembayaran (Rp)</label>
                        <input type="number" id="amount" name="amount" step="0.01" required>
                        @error('amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit">Bayar Pinjaman</button>
                </form>
            @endif
        </div>
    </div>

    <script>
        function updateLoanInfo() {
            const select = document.getElementById('loan_id');
            const infoDiv = document.getElementById('loanInfo');
            const selectedOption = select.options[select.selectedIndex];

            if (select.value === '') {
                infoDiv.classList.remove('show');
                return;
            }

            document.getElementById('totalAmount').textContent = new Intl.NumberFormat('id-ID').format(selectedOption.dataset.total);
            document.getElementById('remainingAmount').textContent = new Intl.NumberFormat('id-ID').format(selectedOption.dataset.remaining);
            document.getElementById('loanDate').textContent = selectedOption.dataset.date;
            document.getElementById('loanDescription').textContent = selectedOption.dataset.description;

            infoDiv.classList.add('show');
        }
    </script>
</body>
</html>
