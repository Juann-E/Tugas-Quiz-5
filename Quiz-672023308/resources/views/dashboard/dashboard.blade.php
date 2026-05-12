{{-- resources/views/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pinjam Petir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:    #f8fafc;       
            --bg-card:    #333c4d;       
            --bg-input:   #1e293b;       
            --border:     rgba(255,255,255,.08);
            --accent:     #facc15;
            --accent2:    #eab308;
            --text-main:  #ffffff;       
            --text-muted: #cbd5e1;       
            --text-body:  #64748b;       
            --green:      #4ade80;       
            --red:        #f87171;
            --teal:       #2dd4bf;
        }

        body {
            background: var(--bg-base);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-body);
            min-height: 100vh;
        }

        /* ── NAVBAR ─────────────────────────────── */
        .navbar {
            background: var(--bg-card) !important;
            border-bottom: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0,0,0,.05);
        }

        .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            font-weight: 800; font-size: 1.15rem;
            color: var(--text-main) !important; text-decoration: none;
        }

        .navbar-brand svg { color: var(--accent); }

        .navbar-right { display: flex; align-items: center; gap: 14px; }

        .user-pill { display: flex; align-items: center; gap: 10px; }

        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.05);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-main);
        }
        .user-avatar svg { width: 22px; height: 22px; }

        .user-info { line-height: 1.2; }
        .user-name  { font-weight: 700; font-size: .95rem; color: var(--text-main); }
        .user-role  { font-size: .75rem; color: var(--text-muted); }

        .btn-logout {
            display: flex; align-items: center; gap: 8px;
            background: transparent; border: 1.5px solid var(--accent);
            color: var(--accent); border-radius: 10px;
            padding: 8px 18px; font-weight: 600; font-size: .85rem;
            cursor: pointer; transition: background .2s, color .2s;
        }
        .btn-logout:hover { background: var(--accent); color: #111827; }

        /* ── LAYOUT ──────────────────────────────── */
        .main-wrapper {
            max-width: 1100px; margin: 0 auto;
            padding: 36px 24px 60px;
        }

        /* ── SALDO CARD ──────────────────────────── */
        .saldo-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; padding: 32px 36px;
            display: flex; align-items: center; gap: 24px;
            margin-bottom: 28px; box-shadow: 0 10px 25px rgba(0,0,0,.05);
            color: var(--text-main);
        }

        .saldo-icon-wrap {
            width: 80px; height: 80px; flex-shrink: 0; border-radius: 50%;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.05);
            display: flex; align-items: center; justify-content: center;
        }
        .saldo-icon-wrap svg { width: 40px; height: 40px; color: var(--accent); }

        .saldo-label { font-size: .95rem; color: var(--text-muted); margin-bottom: 6px; }
        .saldo-amount {
            font-size: 2.6rem; font-weight: 800; color: var(--text-main); letter-spacing: -.5px;
        }

        /* ── ACTION CARDS GRID ───────────────────── */
        .action-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 32px;
        }

        .action-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 18px; padding: 22px 20px;
            display: flex; align-items: center; gap: 16px;
            cursor: pointer; transition: border-color .2s, background .2s, transform .15s;
            box-shadow: 0 10px 25px rgba(0,0,0,.05); color: var(--text-main);
            user-select: none;
        }
        .action-card:hover, .action-card.active {
            transform: translateY(-2px); border-color: rgba(255,255,255,.2);
            background: var(--bg-input);
        }
        .action-card.active { border-color: var(--accent); }

        .action-icon {
            width: 52px; height: 52px; flex-shrink: 0; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .action-icon svg { width: 26px; height: 26px; }

        .action-icon-green  { background: rgba(74, 222, 128, .15); color: var(--green); }
        .action-icon-red    { background: rgba(248, 113, 113, .15); color: var(--red); }
        .action-icon-yellow { background: rgba(250, 204, 21, .15); color: var(--accent); }
        .action-icon-teal   { background: rgba(45, 212, 191, .15); color: var(--teal); }

        .action-text-title { font-weight: 700; font-size: 1rem; color: var(--text-main); margin-bottom: 2px; }
        .action-text-sub { font-size: .78rem; color: var(--text-muted); }

        /* ── FORM INLINE SECTION ─────────────────── */
        .inline-form-container {
            display: none; /* Disembunyikan secara default */
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 36px;
            margin-bottom: 32px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
            color: var(--text-main);
            animation: slideDown .3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-header-inline {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px; padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .form-title-inline { font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        
        .btn-close-inline {
            background: none; border: none; color: var(--text-muted);
            font-size: 1.5rem; cursor: pointer; line-height: 1;
        }
        .btn-close-inline:hover { color: var(--text-main); }

        .form-label { display: block; color: var(--text-muted); font-size: .82rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .04em; }
        .form-control, .form-select { width: 100%; height: 50px; background: var(--bg-input); border: 1px solid var(--border); color: var(--text-main); border-radius: 12px; padding: 0 16px; font-size: .95rem; outline: none; transition: border-color .2s; }
        .form-control::placeholder { color: #64748b; }
        .form-control:focus, .form-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(250,204,21,.15); }
        .form-select option { background: var(--bg-input); }
        .form-hint { font-size: .78rem; color: var(--text-muted); margin-top: 6px; }
        .mb-4-form { margin-bottom: 20px; }

        .btn-submit {
            width: 100%; height: 50px; border: none; border-radius: 12px;
            font-weight: 700; font-size: 1rem; cursor: pointer;
            transition: opacity .2s, transform .15s; margin-top: 8px; color: white;
        }
        .btn-submit:hover { opacity: .9; transform: translateY(-1px); }

        .btn-green  { background: #16a34a; }
        .btn-red    { background: #dc2626; }
        .btn-yellow { background: linear-gradient(135deg, #facc15, #eab308); color: #111827; }
        .btn-teal   { background: #0d9488; }

        /* ── TABLE SECTION ───────────────────────── */
        .table-section { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,.05); color: var(--text-main); }
        .table-header { display: flex; align-items: center; justify-content: space-between; padding: 24px 28px 20px; }
        .table-title { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.1rem; }
        .table-title svg { color: var(--accent); width: 22px; height: 22px; }
        .btn-lihat-semua { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); padding: 8px 20px; border-radius: 10px; font-weight: 600; font-size: .85rem; cursor: pointer; transition: background .2s, color .2s; }
        .btn-lihat-semua:hover { background: var(--accent); color: #111827; }
        .table { width: 100%; border-collapse: collapse; }
        .table thead tr { background: var(--bg-input); }
        .table th { padding: 14px 28px; text-align: left; font-size: .8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; border: none; }
        .table td { padding: 18px 28px; border-top: 1px solid var(--border); font-size: .92rem; vertical-align: middle; }
        .table tbody tr:hover { background: rgba(255,255,255,.03); }
        .badge-aktif { display: inline-block; padding: 5px 14px; border-radius: 999px; background: rgba(250, 204, 21, 0.15); color: var(--accent); font-size: .78rem; font-weight: 700; }
        .badge-lunas { display: inline-block; padding: 5px 14px; border-radius: 999px; background: rgba(74, 222, 128, 0.15); color: var(--green); font-size: .78rem; font-weight: 700; }
        .empty-state { text-align: center; padding: 48px; color: var(--text-muted); }

        /* ── ALERT ───────────────────────────────── */
        .flash-alert { border-radius: 14px; border: none; padding: 14px 20px; margin-bottom: 20px; font-size: .9rem; font-weight: 500; }
        .flash-success { background: rgba(74, 222, 128, 0.15); color: var(--green); }
        .flash-error   { background: rgba(248, 113, 113, 0.15); color: var(--red); }

        /* ── FOOTER ──────────────────────────────── */
        .footer { text-align: left; color: var(--text-body); font-size: .8rem; padding-top: 32px; }

        @media (max-width: 768px) {
            .action-grid { grid-template-columns: repeat(2, 1fr); }
            .saldo-amount { font-size: 1.9rem; }
        }
        @media (max-width: 480px) {
            .action-grid { grid-template-columns: 1fr; }
            .saldo-card { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="#" class="navbar-brand">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/>
            <line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/>
            <line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 20 7 4 7"/>
        </svg>
        Pinjam Petir
    </a>
    <div class="navbar-right">
        <div class="user-pill">
            <div class="user-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="user-info">
                <div class="user-name">{{ $user->name ?? 'User' }}</div>
                <div class="user-role">Anggota</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="main-wrapper">

    @if(session('success'))
        <div class="flash-alert flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-alert flash-error">{{ session('error') }}</div>
    @endif

    {{-- SALDO --}}
    <div class="saldo-card">
        <div class="saldo-icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="1" y="4" width="22" height="16" rx="3" ry="3"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
        </div>
        <div>
            <div class="saldo-label">Saldo Anda</div>
            <div class="saldo-amount">Rp {{ number_format($user->saldo ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- ACTION CARDS --}}
    <div class="action-grid">
        <div class="action-card" id="btn-tabung" onclick="toggleForm('formTabung', 'btn-tabung')">
            <div class="action-icon action-icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="3"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <div class="action-text-title">Tabung</div>
                <div class="action-text-sub">Simpan uang Anda</div>
            </div>
        </div>

        <div class="action-card" id="btn-ambil" onclick="toggleForm('formAmbil', 'btn-ambil')">
            <div class="action-icon action-icon-red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            </div>
            <div>
                <div class="action-text-title">Ambil</div>
                <div class="action-text-sub">Tarik saldo Anda</div>
            </div>
        </div>

        <div class="action-card" id="btn-pinjam" onclick="toggleForm('formPinjam', 'btn-pinjam')">
            <div class="action-icon action-icon-yellow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <div>
                <div class="action-text-title">Pinjam</div>
                <div class="action-text-sub">Ajukan pinjaman</div>
            </div>
        </div>

        <div class="action-card" id="btn-bayar" onclick="toggleForm('formBayar', 'btn-bayar')">
            <div class="action-icon action-icon-teal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="3"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <div class="action-text-title">Bayar Pinjaman</div>
                <div class="action-text-sub">Bayar cicilan pinjaman</div>
            </div>
        </div>
    </div>

    {{-- AREA FORM INLINE (Menggantikan Pop Up Modal) --}}
    
    {{-- Form Tabung --}}
    <div class="inline-form-container" id="formTabung">
        <div class="form-header-inline">
            <div class="form-title-inline"><span style="color:var(--green)">💰</span> Tabung Uang</div>
            <button class="btn-close-inline" onclick="toggleForm('formTabung', 'btn-tabung')">&times;</button>
        </div>
        <form action="{{ route('tabung') }}" method="POST">
            @csrf
            <div class="mb-4-form">
                <label class="form-label">Jumlah Tabungan</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah yang ingin ditabung" required>
            </div>
            <button type="submit" class="btn-submit btn-green">Simpan Tabungan</button>
        </form>
    </div>

    {{-- Form Ambil --}}
    <div class="inline-form-container" id="formAmbil">
        <div class="form-header-inline">
            <div class="form-title-inline"><span style="color:var(--red)">💸</span> Ambil Uang</div>
            <button class="btn-close-inline" onclick="toggleForm('formAmbil', 'btn-ambil')">&times;</button>
        </div>
        <form action="{{ route('ambil') }}" method="POST">
            @csrf
            <div class="mb-4-form">
                <label class="form-label">Jumlah Penarikan</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah yang ingin ditarik" required>
            </div>
            <button type="submit" class="btn-submit btn-red">Tarik Saldo</button>
        </form>
    </div>

    {{-- Form Pinjam --}}
    <div class="inline-form-container" id="formPinjam">
        <div class="form-header-inline">
            <div class="form-title-inline"><span style="color:var(--accent)">🏦</span> Ajukan Pinjaman</div>
            <button class="btn-close-inline" onclick="toggleForm('formPinjam', 'btn-pinjam')">&times;</button>
        </div>
        <form action="{{ route('pinjam') }}" method="POST">
            @csrf
            <div class="mb-4-form">
                <label class="form-label">Jumlah Pinjaman</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Masukkan nominal pinjaman" required>
            </div>
            <button type="submit" class="btn-submit btn-yellow">Ajukan Pinjaman</button>
        </form>
    </div>

    {{-- Form Bayar --}}
    <div class="inline-form-container" id="formBayar">
        <div class="form-header-inline">
            <div class="form-title-inline"><span style="color:var(--teal)">💳</span> Bayar Pinjaman</div>
            <button class="btn-close-inline" onclick="toggleForm('formBayar', 'btn-bayar')">&times;</button>
        </div>
        @if(isset($pinjaman) && $pinjaman->count() > 0)
            <form action="{{ route('bayar') }}" method="POST">
                @csrf
                <div class="mb-4-form">
                    <label class="form-label">Pilih Pinjaman</label>
                    <select name="pinjaman_id" class="form-select" id="selectPinjaman" onchange="updateMaxBayar(this)">
                        @foreach($pinjaman as $p)
                            <option value="{{ $p->id }}" data-sisa="{{ $p->sisa }}">
                                Pinjaman {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }} – Rp {{ number_format($p->sisa, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4-form">
                    <label class="form-label">Jumlah Pembayaran</label>
                    <input type="number" name="jumlah" id="inputBayar" class="form-control" placeholder="Masukkan jumlah bayar" required>
                    <div class="form-hint" id="infoBayar"></div>
                </div>
                <button type="submit" class="btn-submit btn-teal">Bayar Sekarang</button>
            </form>
        @else
            <div style="color:var(--text-muted); padding:10px 0;">
                Anda tidak memiliki pinjaman aktif saat ini.
            </div>
        @endif
    </div>
    {{-- AKHIR AREA FORM INLINE --}}


    {{-- TABLE PINJAMAN --}}
    <div class="table-section">
        <div class="table-header">
            <div class="table-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
                Pinjaman Aktif
            </div>
            <button class="btn-lihat-semua">Lihat Semua</button>
        </div>

        @if(isset($pinjaman) && $pinjaman->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Pinjaman</th>
                            <th>Sisa Pinjaman</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjaman as $p)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($p->sisa, 0, ',', '.') }}</td>
                                <td>
                                    @if($p->status == 'active')
                                        <span class="badge-aktif">Aktif</span>
                                    @else
                                        <span class="badge-lunas">Lunas</span>
                                    @endif
                                </td>
                                <td><button class="action-dots">•••</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                Anda tidak memiliki riwayat pinjaman.
            </div>
        @endif
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Koperasi App. Semua hak dilindungi.
    </div>

</div>

<script>
    // Fungsi untuk menampilkan/menyembunyikan form di bawah deretan tombol
    function toggleForm(formId, btnId) {
        // Ambil semua container form & semua tombol
        const allForms = document.querySelectorAll('.inline-form-container');
        const allBtns = document.querySelectorAll('.action-card');
        
        const targetForm = document.getElementById(formId);
        const targetBtn = document.getElementById(btnId);

        // Cek apakah form yang diklik sedang terbuka
        const isCurrentlyOpen = targetForm.style.display === 'block';

        // Tutup semua form dan hapus class active dari semua tombol
        allForms.forEach(form => form.style.display = 'none');
        allBtns.forEach(btn => btn.classList.remove('active'));

        // Jika sebelumnya tidak terbuka, maka buka
        if (!isCurrentlyOpen) {
            targetForm.style.display = 'block';
            targetBtn.classList.add('active');
            
            // Opsional: Scroll layar perlahan agar form terlihat
            targetForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function updateMaxBayar(select) {
        if(!select) return;
        const sisa  = parseFloat(select.options[select.selectedIndex].dataset.sisa);
        const saldo = {{ $user->saldo ?? 0 }};
        const max   = Math.min(sisa, saldo);
        const input = document.getElementById('inputBayar');
        if(input) {
            input.max   = max;
            input.value = max;
        }
        const info = document.getElementById('infoBayar');
        if(info) {
            info.textContent = 'Maksimal pembayaran dari saldo Anda: Rp ' + max.toLocaleString('id-ID');
        }
    }

    window.addEventListener('load', function () {
        const sel = document.getElementById('selectPinjaman');
        if (sel) updateMaxBayar(sel);
    });

    // Auto-dismiss flash alerts
    setTimeout(function () {
        document.querySelectorAll('.flash-alert').forEach(el => {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 4000);
</script>

</body>
</html>