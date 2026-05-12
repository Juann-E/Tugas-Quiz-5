<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #F9F6F0; /* Krem lembut */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #4A4A4A;
        }
        
        .card-custom {
            background-color: #FFFFFF;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .saldo-box { 
            background-color: #8C6A53; /* Cokelat bumi */
            color: white; 
            border-radius: 12px;
        }

        /* Styling tombol sidebar */
        .btn-sidebar { 
            border-radius: 10px; 
            font-weight: 500; 
            border: none; 
            text-align: left;
            padding: 12px 20px;
            transition: all 0.2s ease;
        }
        .btn-sidebar:hover { 
            transform: translateX(4px); /* Animasi geser ke kanan sedikit saat disentuh */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-tabung { background-color: #6B8E23; color: white; }
        .btn-tabung:hover { background-color: #55711B; color: white; }

        .btn-ambil { background-color: #C08081; color: white; }
        .btn-ambil:hover { background-color: #A66B6C; color: white; }

        .btn-pinjam { background-color: #DDB771; color: #333; }
        .btn-pinjam:hover { background-color: #C29F5D; color: #333; }

        .btn-bayar { background-color: #728C96; color: white; }
        .btn-bayar:hover { background-color: #5A717A; color: white; }

        .table th { border-bottom: 2px solid #EAE3D9; font-weight: 600; color: #8C6A53; }
        .table td { vertical-align: middle; color: #555; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-12 col-lg-4">
            <div class="card-custom p-4 mb-3 text-center">
                <h5 class="fw-bold mb-1" style="color: #8C6A53;">Halo, {{ $user->name }}</h5>
                <p class="text-muted small mb-4">Selamat datang kembali</p>

                <div class="saldo-box p-4 mb-4">
                    <p class="mb-1 opacity-75 small">Total Saldo Anda</p>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($user->balance, 0, ',', '.') }}</h3>
                </div>

                <hr style="border-color: #EAE3D9;">

                <div class="d-flex flex-column gap-3 mt-4">
                    <button class="btn btn-sidebar btn-tabung w-100" data-bs-toggle="modal" data-bs-target="#modalTabung">
                        + Tabung Uang
                    </button>
                    <button class="btn btn-sidebar btn-ambil w-100" data-bs-toggle="modal" data-bs-target="#modalAmbil">
                        - Tarik Saldo
                    </button>
                    <button class="btn btn-sidebar btn-pinjam w-100" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                        ↗ Ajukan Pinjaman
                    </button>
                    <button class="btn btn-sidebar btn-bayar w-100" data-bs-toggle="modal" data-bs-target="#modalBayar">
                        ✓ Bayar Cicilan
                    </button>
                </div>

                <hr style="border-color: #EAE3D9;" class="my-4">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100" style="border-radius: 10px;">Logout</button>
                </form>
            </div>
        </div>


        <div class="col-12 col-lg-8">
            
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 shadow-sm">{{ session('error') }}</div>
            @endif

            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: #8C6A53;">Riwayat Pinjaman Aktif</h5>
                </div>

                @if($activeLoans->isEmpty())
                    <div class="text-center py-5 text-muted h-100 d-flex flex-column justify-content-center">
                        <p class="mb-0">Belum ada pinjaman yang sedang berjalan saat ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total Pinjaman</th>
                                    <th>Sisa Tagihan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeLoans as $loan)
                                <tr class="border-bottom">
                                    <td>{{ $loan->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($loan->remaining_amount, 0, ',', '.') }}</strong></td>
                                    <td><span class="badge" style="background-color: #DDB771; color: #333;">Aktif</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTabung" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('tabung') }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
      @csrf
      <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Tabung Uang</h5></div>
      <div class="modal-body">
        <label class="text-muted mb-2">Jumlah Tabungan (Rp)</label>
        <input type="number" name="amount" class="form-control" style="border-radius: 8px;" required min="1">
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn text-muted" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-tabung px-4" style="border-radius: 8px;">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalAmbil" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('ambil') }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
      @csrf
      <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Tarik Saldo</h5></div>
      <div class="modal-body">
        <p class="text-muted small mb-3">Saldo tersedia: <strong style="color: #8C6A53;">Rp {{ number_format($user->balance, 0, ',', '.') }}</strong></p>
        <label class="text-muted mb-2">Jumlah Penarikan (Rp)</label>
        <input type="number" name="amount" class="form-control" style="border-radius: 8px;" required min="1">
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn text-muted" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-ambil px-4" style="border-radius: 8px;">Tarik Uang</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('pinjam') }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
      @csrf
      <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Ajukan Pinjaman</h5></div>
      <div class="modal-body">
        <div class="alert" style="background-color: #F0F4F8; color: #5A717A; border-radius: 8px; font-size: 0.9rem;">
            Dana pinjaman akan langsung ditambahkan ke total saldo Anda.
        </div>
        <label class="text-muted mb-2">Jumlah Pinjaman (Rp)</label>
        <input type="number" name="amount" class="form-control" style="border-radius: 8px;" required min="1">
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn text-muted" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-pinjam px-4" style="border-radius: 8px;">Ajukan</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalBayar" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('bayar') }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
      @csrf
      <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Bayar Cicilan</h5></div>
      <div class="modal-body">
        <p class="text-muted small mb-3">Saldo tersedia: <strong style="color: #8C6A53;">Rp {{ number_format($user->balance, 0, ',', '.') }}</strong></p>
        
        <label class="text-muted mb-2">Pilih Pinjaman</label>
        <select name="loan_id" class="form-select mb-3" style="border-radius: 8px;" required>
            <option value="" disabled selected>-- Pilih riwayat --</option>
            @foreach($activeLoans as $loan)
                <option value="{{ $loan->id }}">
                    Tgl {{ $loan->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($loan->remaining_amount, 0, ',', '.') }}
                </option>
            @endforeach
        </select>

        <label class="text-muted mb-2">Jumlah Pembayaran (Rp)</label>
        <input type="number" name="amount" class="form-control" style="border-radius: 8px;" required min="1">
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn text-muted" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-bayar px-4" style="border-radius: 8px;">Bayar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>