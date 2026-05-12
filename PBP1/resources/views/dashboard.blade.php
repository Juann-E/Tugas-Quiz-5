<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-tabung { background-color: #198754; color: white; }
        .btn-ambil { background-color: #dc3545; color: white; }
        .btn-pinjam { background-color: #ffc107; color: black; }
        .btn-bayar { background-color: #0dcaf0; color: black; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="{{ route('dashboard') }}">SimpanPinjamApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Halo, {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Akun Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card text-white bg-primary mb-4 text-center">
        <div class="card-body py-4">
            <h4 class="card-title">Saldo Anda</h4>
            <h1 class="display-4">Rp {{ number_format($user->saldo, 0, ',', '.') }}</h1>
        </div>
    </div>

    <div class="row mb-4 text-center">
        <div class="col-md-3 d-grid">
            <button class="btn btn-tabung btn-lg" data-bs-toggle="modal" data-bs-target="#modalTabung">Tabung </button>
        </div>
        <div class="col-md-3 d-grid">
            <button class="btn btn-ambil btn-lg" data-bs-toggle="modal" data-bs-target="#modalAmbil">Ambil </button>
        </div>
        <div class="col-md-3 d-grid">
            <button class="btn btn-pinjam btn-lg" data-bs-toggle="modal" data-bs-target="#modalPinjam">Pinjam </button>
        </div>
        <div class="col-md-3 d-grid">
            <button class="btn btn-bayar btn-lg" data-bs-toggle="modal" data-bs-target="#modalBayar">Bayar Pinjaman </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Pinjaman Aktif</h5>
        </div>
        <div class="card-body">
            @if($pinjamanAktif->count() > 0)
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Tanggal </th>
                            <th>Total Pinjaman </th>
                            <th>Sisa Pinjaman</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjamanAktif as $loan)
                        <tr>
                            <td>{{ $loan->created_at->format('d M Y') }} </td>
                            <td>Rp {{ number_format($loan->total_pinjaman, 0, ',', '.') }} </td>
                            <td>Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }} </td>
                            <td><span class="badge bg-warning text-dark">{{ $loan->status }}</span> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center mt-3">Anda tidak memiliki pinjaman aktif</p>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="modalTabung" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('tabung') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tabung Uang </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label>Jumlah Tabungan (Rp) </label>
        <input type="number" name="jumlah_tabungan" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal </button>
        <button type="submit" class="btn btn-success">Simpan Tabungan </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalAmbil" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('ambil') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Ambil Uang </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong> </p>
        <label>Jumlah Penarikan (Rp) </label>
        <input type="number" name="jumlah_penarikan" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal </button>
        <button type="submit" class="btn btn-danger">Ambil Uang </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalPinjam" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('pinjam') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Ajukan Pinjaman </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</div>
        <label>Jumlah Pinjaman (Rp) </label>
        <input type="number" name="jumlah_pinjaman" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal </button>
        <button type="submit" class="btn btn-warning">Ajukan Pinjaman </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalBayar" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('bayar') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Bayar Pinjaman </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong> </p>
        
        <div class="mb-3">
            <label>Pilih Pinjaman</label>
            <select name="loan_id" class="form-select" required>
                @foreach($pinjamanAktif as $loan)
                    <option value="{{ $loan->id }}">Pinjaman {{ $loan->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Pembayaran (Rp)</label>
            <input type="number" name="jumlah_pembayaran" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal </button>
        <button type="submit" class="btn btn-info text-white">Bayar Pinjaman </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>