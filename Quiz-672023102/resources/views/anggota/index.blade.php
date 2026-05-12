<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Simpan Pinjam</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { color: #333; margin-bottom: 15px; font-size: 18px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        button { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        button:hover { background: #218838; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        .btn-bayar { background: #007bff; padding: 5px 10px; font-size: 12px; }
        .btn-bayar:hover { background: #0056b3; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-aktif { background: #ffc107; color: #333; }
        .badge-lunas { background: #28a745; color: white; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .tabs { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
        .tab-btn { padding: 8px 16px; border: 1px solid #ddd; background: #f8f9fa; cursor: pointer; border-radius: 4px; }
        .tab-btn.active { background: #28a745; color: white; border-color: #28a745; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .section-title { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px; }
        .user-info { text-align: right; margin-bottom: 20px; }
        .logout-btn { background: #dc3545; padding: 8px 16px; font-size: 14px; }
        .logout-btn:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <strong>{{ Auth::user()->name }}</strong>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <h1>Aplikasi Simpan Pinjam</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if(!$anggota)
            <div class="card">
                <p>Silakanhubungi admin untuk aktivasi anggota.</p>
            </div>
        @else
        <div class="grid">
            <div class="card">
                <h2 class="section-title">Tambah Tabungan</h2>
                <form action="{{ route('tabungan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" placeholder="Opsional">
                    </div>
                    <button type="submit">Simpan Tabungan</button>
                </form>
            </div>

            <div class="card">
                <h2 class="section-title">Ajukan Pinjaman</h2>
                <form action="{{ route('pinjaman.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" placeholder="Opsional">
                    </div>
                    <button type="submit">Ajukan Pinjaman</button>
                </form>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title">Ringkasan</h2>
            <p><strong>Total Tabungan:</strong> Rp {{ number_format($anggota->total_tabungan, 0, ',', '.') }}</p>
            <p><strong>Total Pinjaman Aktif:</strong> Rp {{ number_format($anggota->total_pinjaman, 0, ',', '.') }}</p>
        </div>

        <div class="card">
            <h2 class="section-title">Data Saya</h2>
            
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('tabungan-{{ $anggota->id }}')">Tabungan</button>
                <button class="tab-btn" onclick="showTab('pinjaman-{{ $anggota->id }}')">Pinjaman</button>
                <button class="tab-btn" onclick="showTab('bayar-{{ $anggota->id }}')">Bayar Pinjaman</button>
            </div>

            <div id="tabungan-{{ $anggota->id }}" class="tab-content active">
                <h3>Riwayat Tabungan</h3>
                @if($anggota->tabungans->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota->tabungans as $tabungan)
                            <tr>
                                <td>{{ $tabungan->created_at->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($tabungan->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $tabungan->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Belum ada tabungan.</p>
                @endif
            </div>

            <div id="pinjaman-{{ $anggota->id }}" class="tab-content">
                <h3>Riwayat Pinjaman</h3>
                @if($anggota->pinjamans->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Awal</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota->pinjamans as $pinjaman)
                            <tr>
                                <td>{{ $pinjaman->created_at->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($pinjaman->sisa, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $pinjaman->status == 'lunas' ? 'badge-lunas' : 'badge-aktif' }}">
                                        {{ ucfirst($pinjaman->status) }}
                                    </span>
                                </td>
                                <td>{{ $pinjaman->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Belum ada pinjaman.</p>
                @endif
            </div>

            <div id="bayar-{{ $anggota->id }}" class="tab-content">
                <h3>Bayar Pinjaman - Pilih Pinjaman yang Ingin Dilunasi</h3>
                @php
                    $aktifPinjaman = $anggota->pinjamans->where('status', 'aktif');
                @endphp
                @if($aktifPinjaman->count() > 0)
                    @foreach($aktifPinjaman as $pinjaman)
                    <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                        <p><strong>Pinjaman {{ $loop->iteration }}</strong></p>
                        <p>Jumlah: Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }} | 
                           Sisa: Rp {{ number_format($pinjaman->sisa, 0, ',', '.') }}</p>
                        <form action="{{ route('pembayaran.store') }}" method="POST" style="margin-top: 10px; display: flex; gap: 10px; align-items: center;">
                            @csrf
                            <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">
                            <input type="number" name="jumlah" min="1" max="{{ $pinjaman->sisa }}" placeholder="Jumlah Bayar" style="width: 150px;" required>
                            <button type="submit" class="btn-bayar">Bayar</button>
                        </form>
                    </div>
                    @endforeach
                @else
                    <p>Tidak ada pinjaman aktif.</p>
                @endif
            </div>
        </div>
        @endif

        @if($anggotas && $anggotas->count() > 0)
        <div class="card">
            <h2 class="section-title">Daftar Semua Anggota</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Tabungan</th>
                        <th>Total Pinjaman Aktif</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggotas as $a)
                    <tr>
                        <td>{{ $a->nama }}</td>
                        <td>Rp {{ number_format($a->total_tabungan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($a->total_pinjaman, 0, ',', '.') }}</td>
                        <td>
                            @if($a->total_pinjaman > 0)
                                <span class="badge badge-aktif">Memiliki Pinjaman</span>
                            @else
                                <span class="badge badge-lunas">Tidak Ada Pinjaman</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <script>
        function showTab(tabId) {
            const content = document.getElementById(tabId);
            const parent = content.parentElement;
            
            parent.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            parent.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            content.classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>