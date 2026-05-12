<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard M-Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        /* EFEK HOVER: KARTU AKAN NAIK SEDIKIT SAAT DISENTUH MOUSE */
        .card-menu:hover { transform: translateY(-5px); transition: 0.3s; }
    </style>
</head>
<body>

    <div class="container pt-3 text-end">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm fw-bold">Logout</button>
        </form>
    </div>

    <div class="container pb-5">
        
        <div class="card bg-primary text-white text-center my-4 shadow border-0">
            <div class="card-body py-5">
                <h5 class="fw-normal mb-2 opacity-75">Total Saldo Anda</h5>
                <h1 class="display-5 fw-bold mb-0">Rp {{ number_format($user->saldo, 0, ',', '.') }}</h1>
                
                <p class="fw-normal mb-2 opacity-75 mt-3 fst-italic">
                    "Save money, and money will save you."
                </p>
            </div>
        </div>

        <div class="row text-center mb-5 g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('tabung.view') }}" class="btn btn-success w-100 py-3 fw-bold shadow-sm card-menu">Tabung</a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('ambil.view') }}" class="btn btn-danger w-100 py-3 fw-bold shadow-sm card-menu">Ambil</a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pinjam.view') }}" class="btn btn-warning w-100 py-3 fw-bold text-dark shadow-sm card-menu">Pinjam</a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('bayar.view') }}" class="btn btn-info w-100 py-3 fw-bold text-dark shadow-sm card-menu">Bayar</a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-secondary">Pinjaman Aktif</h6>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr class="small text-secondary">
                            <th>TANGGAL</th>
                            <th>TOTAL PINJAMAN</th>
                            <th>SISA PINJAMAN</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                        <tr>
                            <td class="align-middle small">{{ $loan->created_at->format('d M Y') }}</td>
                            <td class="align-middle">Rp {{ number_format($loan->total_pinjaman, 0, ',', '.') }}</td>
                            <td class="align-middle fw-bold text-danger">Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td class="align-middle">
                                <span class="badge bg-warning text-dark px-3">Active</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fst-italic small">Anda tidak memiliki pinjaman aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Riwayat Transaksi Terakhir</h6>

                <a href="{{ route('report.pdf') }}" class="btn btn-sm btn-light fw-bold shadow-sm px-3">
                    <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                </a>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr class="small text-secondary text-center">
                            <th>WAKTU</th>
                            <th>JENIS</th>
                            <th>NOMINAL</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->transactions()->latest()->take(5)->get() as $trx)
                        <tr class="text-center">
                            <td class="align-middle small text-secondary">{{ $trx->created_at->format('d/m H:i') }}</td>
                            <td class="align-middle">
                                @php
                                    $badgeColor = 'bg-secondary'; // Warna default (Abu-abu)
                                    if($trx->type == 'tabung') $badgeColor = 'bg-success'; // Hijau
                                    if($trx->type == 'ambil')  $badgeColor = 'bg-danger';  // Merah
                                    if($trx->type == 'pinjam') $badgeColor = 'bg-warning text-dark'; // Kuning
                                    if($trx->type == 'bayar')  $badgeColor = 'bg-info text-dark';    // Biru Muda
                                @endphp
                                
                                <span class="badge {{ $badgeColor }} px-3 py-2 fw-bold" style="min-width: 85px;">
                                    {{ strtoupper($trx->type) }}
                                </span>
                            </td>
                            <td class="align-middle fw-bold text-dark">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="align-middle small text-muted">{{ $trx->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fst-italic small">Belum ada riwayat transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if (session('success'))
        <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cek jika ada elemen toast sukses
            var successEl = document.getElementById('successToast');
            if (successEl) {
                var toast = new bootstrap.Toast(successEl, { delay: 3000 }); // Hilang dalam 3 detik
                toast.show();
            }

            // Cek jika ada elemen toast error
            var errorEl = document.getElementById('errorToast');
            if (errorEl) {
                var toast = new bootstrap.Toast(errorEl, { delay: 5000 }); // Error lebih lama dikit (5 detik)
                toast.show();
            }
        });
    </script>

</body>
</html>