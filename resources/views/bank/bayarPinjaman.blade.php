<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pinjaman - MyBank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; color: #0d6efd !important; }
        .form-card { border: none; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .icon-circle { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; }
        .btn-primary-gradient { background: linear-gradient(to right, #0d6efd, #0b5ed7); border: none; color: white; transition: all 0.3s; }
        .btn-primary-gradient:hover { background: linear-gradient(to right, #0b5ed7, #0a53be); color: white; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.3); }
        .input-group-text { background-color: #f8f9fa; border-right: none; }
        .form-control, .form-select { border-left: none; }
        .form-control:focus, .form-select:focus { border-color: #dee2e6; box-shadow: none; }
        .input-group:focus-within, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); border-radius: 0.5rem; }
        .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: #0d6efd; }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-white shadow-sm border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm rounded-pill fw-medium px-3 text-secondary d-flex align-items-center border">
                <i class="bi bi-arrow-left me-2"></i> <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
            </a>
            <span class="navbar-brand mb-0 h1 d-flex align-items-center gap-2 m-0">
                <i class="bi bi-bank fs-4 text-primary"></i> MyBank
            </span>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card form-card bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <h3 class="fw-bold text-dark">Bayar Pinjaman</h3>
                            <p class="text-muted small">Bayar cicilan atau lunasi pinjaman Anda.</p>
                        </div>

                        @if(session('success'))
                        <div class="alert alert-success rounded-4 border-0 bg-success bg-opacity-10 text-success fw-medium small mb-4">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger rounded-4 border-0 bg-danger bg-opacity-10 text-danger fw-medium small mb-4">
                            {{ session('error') }}
                        </div>
                        @endif

                        @if(isset($activeLoans) && $activeLoans->count() > 0)
                        <form action="{{ url('/bayarPinjaman') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="loan_id" class="form-label fw-semibold text-secondary small">Pilih Pinjaman</label>
                                <select name="loan_id" id="loan_id" class="form-select form-select-lg rounded-3 border" required>
                                    <option value="" disabled selected>-- Pilih Pinjaman --</option>
                                    @foreach($activeLoans as $loan)
                                        <option value="{{ $loan->id }}">
                                            [{{ $loan->created_at->format('d M Y') }}] Sisa: Rp {{ number_format($loan->remaining_amount, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="amount" class="form-label fw-semibold text-secondary small">Nominal Pembayaran (Rp)</label>
                                <div class="input-group input-group-lg rounded-3 overflow-hidden border">
                                    <span class="input-group-text fw-medium text-secondary" id="addon-rp">Rp</span>
                                    <input type="number" class="form-control" name="amount" id="amount" required min="1000" placeholder="0" aria-describedby="addon-rp">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-gradient w-100 py-3 rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-credit-card"></i> Proses Pembayaran
                            </button>
                        </form>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-check2-circle text-success fs-1 mb-3"></i>
                            <h5 class="fw-bold">Tidak ada pinjaman aktif</h5>
                            <p class="text-muted small">Anda tidak memiliki pinjaman yang perlu dibayar saat ini.</p>
                            <a href="{{ url('/pinjam') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3 fw-medium">Ajukan Pinjaman Baru</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
