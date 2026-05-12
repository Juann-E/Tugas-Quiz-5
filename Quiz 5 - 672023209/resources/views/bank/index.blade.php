<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; color: #0d6efd !important; }
        .card-balance { background: linear-gradient(135deg, #0d6efd, #6610f2); color: white; border: none; border-radius: 1rem; }
        .action-card { border: none; border-radius: 1rem; transition: transform 0.3s, box-shadow 0.3s; }
        .action-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 15px; }
        .table-custom { background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <i class="bi bi-bank fs-4 text-primary"></i> MyBank
            </a>
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex align-items-center bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-wallet2 me-2"></i> Saldo: Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}
                </div>
                <span class="text-muted d-none d-sm-block">Hello, <span class="fw-semibold">{{ Auth::user()->name ?? 'User' }}</span></span>
                <form action="{{ url('/logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-medium shadow-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-3 fs-5"></i> 
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i> 
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card card-balance shadow-lg mb-5 position-relative overflow-hidden">
            <div class="position-absolute" style="top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: -50px; left: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            
            <div class="card-body p-4 p-md-5 position-relative z-1">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title fw-normal opacity-75 mb-0">Total Saldo</h5>
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25 rounded-pill px-3 py-2">Aktif</span>
                </div>
                <h2 class="display-4 fw-bold mb-0 text-white">Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>

        <h4 class="fw-bold mb-4 text-dark">Menu Transaksi</h4>
        <div class="row g-4 mb-5 text-center">
            <div class="col-6 col-md-3">
                <a href="{{ url('/tabung') }}" class="text-decoration-none">
                    <div class="card action-card shadow-sm h-100 p-4">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <h6 class="text-dark fw-bold m-0">Tabung</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ url('/ambilTabungan') }}" class="text-decoration-none">
                    <div class="card action-card shadow-sm h-100 p-4">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-dash-lg"></i>
                        </div>
                        <h6 class="text-dark fw-bold m-0">Ambil</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ url('/pinjam') }}" class="text-decoration-none">
                    <div class="card action-card shadow-sm h-100 p-4">
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <h6 class="text-dark fw-bold m-0">Pinjam</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ url('/bayarPinjaman') }}" class="text-decoration-none">
                    <div class="card action-card shadow-sm h-100 p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h6 class="text-dark fw-bold m-0">Bayar Pinjaman</h6>
                    </div>
                </a>
            </div>
        </div>

        @if(isset($activeLoans) && count($activeLoans) > 0)
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0 text-dark">Daftar Pinjaman Aktif</h4>
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">{{ count($activeLoans) }} Pinjaman</span>
        </div>
        <div class="table-custom mb-5">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="py-3 px-4 text-muted fw-semibold border-0">ID</th>
                            <th class="py-3 px-4 text-muted fw-semibold border-0">Tanggal Pinjaman</th>
                            <th class="py-3 px-4 text-muted fw-semibold border-0">Total Pinjaman</th>
                            <th class="py-3 px-4 text-muted fw-semibold border-0">Sisa Pinjaman</th>
                            <th class="py-3 px-4 text-muted fw-semibold border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($activeLoans as $loan)
                        <tr>
                            <td class="py-3 px-4 border-light">
                                <span class="bg-secondary bg-opacity-10 text-secondary fw-bold rounded-circle d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                    #{{ $loan->id }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-light">
                                <div class="fw-bold text-dark">{{ $loan->created_at->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $loan->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="py-3 px-4 border-light fw-medium text-secondary">Rp {{ number_format($loan->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 border-light">
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-3">Rp {{ number_format($loan->remaining_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 px-4 border-light">
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-bold border border-success border-opacity-25">
                                    <i class="bi bi-circle-fill me-1" style="font-size:0.4rem; vertical-align:middle;"></i>
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>