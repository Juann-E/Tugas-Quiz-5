<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — AdaKhamid</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-900: #0c1e4a;
            --blue-800: #0f2460;
            --blue-700: #1a3580;
            --blue-600: #1e40af;
            --blue-500: #2563eb;
            --blue-400: #3b82f6;
            --blue-300: #93c5fd;
            --blue-200: #bfdbfe;
            --blue-100: #dbeafe;
            --gold-500: #d4a017;
            --gold-400: #e5b523;
            --gold-300: #f0c842;
            --gold-200: #f8dc80;
            --gold-100: #fdf3c0;
            --white: #ffffff;
            --green:  #22c55e;
            --red:    #ef4444;
            --glass:  rgba(255,255,255,0.07);
            --glass-border: rgba(212,160,23,0.2);
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--blue-900);
            min-height: 100vh;
            color: var(--white);
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(59,130,246,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        /* ──── NAVBAR ──── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(12, 30, 74, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold-400), var(--gold-500));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.125rem;
            box-shadow: 0 4px 12px rgba(212,160,23,0.35);
            flex-shrink: 0;
        }
        .brand-name {
            font-size: 1.125rem; font-weight: 800;
            color: var(--white); letter-spacing: -0.3px;
        }
        .navbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .user-pill {
            display: flex; align-items: center; gap: 0.5rem;
            background: var(--glass);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 100px;
            padding: 0.375rem 0.875rem;
        }
        .user-avatar {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-400));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
        }
        .user-name {
            font-size: 0.8125rem; font-weight: 600;
            color: var(--blue-200); font-family: 'DM Sans', sans-serif;
        }
        .btn-logout {
            background: rgba(212,160,23,0.12);
            border: 1px solid rgba(212,160,23,0.3);
            color: var(--gold-300);
            padding: 0.4rem 1rem;
            border-radius: 0.625rem;
            font-family: 'Sora', sans-serif;
            font-size: 0.8125rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(212,160,23,0.2); border-color: var(--gold-400); }

        /* ──── MAIN ──── */
        .main {
            position: relative; z-index: 1;
            padding: 1.5rem;
            max-width: 680px; margin: 0 auto;
        }

        /* ──── ALERTS ──── */
        .alert {
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem; font-weight: 500;
            display: flex; align-items: center; gap: 0.5rem;
            animation: slideDown 0.3s ease;
            font-family: 'DM Sans', sans-serif;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background:rgba(34,197,94,0.12); border:1px solid rgba(34,197,94,0.3); color:#86efac; }
        .alert-error   { background:rgba(239,68,68,0.12);  border:1px solid rgba(239,68,68,0.3); color:#fca5a5; }

        /* ──── SALDO CARD ──── */
        .saldo-card {
            background: linear-gradient(135deg, var(--blue-700) 0%, var(--blue-600) 50%, #2563eb 100%);
            border: 1px solid rgba(212,160,23,0.25);
            border-radius: 1.5rem;
            padding: 2rem 1.75rem;
            margin-bottom: 1.25rem;
            position: relative; overflow: hidden;
            box-shadow: 0 12px 40px rgba(30,64,175,0.4), 0 0 0 1px rgba(255,255,255,0.06) inset;
        }
        .saldo-card::before {
            content: ''; position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: radial-gradient(circle, rgba(212,160,23,0.2) 0%, transparent 70%);
        }
        .saldo-card::after {
            content: ''; position: absolute;
            bottom: -30px; left: 30%;
            width: 140px; height: 140px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
        }
        .saldo-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1rem; position: relative; z-index: 1;
        }
        .saldo-label {
            font-size: 0.8125rem; font-weight: 600;
            color: var(--blue-200); text-transform: uppercase;
            letter-spacing: 1px; font-family: 'DM Sans', sans-serif;
        }
        .saldo-chip {
            background: rgba(212,160,23,0.15); border: 1px solid rgba(212,160,23,0.35);
            border-radius: 100px; padding: 0.25rem 0.75rem;
            font-size: 0.75rem; font-weight: 600; color: var(--gold-300);
        }
        .saldo-amount {
            font-size: 2.625rem; font-weight: 800; color: var(--white);
            letter-spacing: -1.5px; position: relative; z-index: 1;
            text-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }
        .saldo-amount .currency { font-size: 1.25rem; font-weight: 600; opacity: 0.75; letter-spacing: 0; }
        .saldo-footer {
            display: flex; align-items: center; gap: 0.375rem;
            margin-top: 0.875rem; position: relative; z-index: 1;
        }
        .saldo-dot {
            width: 8px; height: 8px; background: var(--gold-400); border-radius: 50%;
            box-shadow: 0 0 8px rgba(212,160,23,0.6);
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .saldo-status { font-size: 0.8125rem; color: var(--blue-200); font-family: 'DM Sans', sans-serif; }

        /* ──── ACTION AREA ──── */
        .action-area { margin-bottom: 1.5rem; }

        .actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .action-btn {
            display: flex; flex-direction: column; align-items: center;
            gap: 0.5rem; padding: 1.125rem 0.5rem;
            border: 2px solid transparent; border-radius: 1.125rem;
            font-family: 'Sora', sans-serif;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2px;
            cursor: pointer; color: var(--white); background: none;
            position: relative; overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .action-btn::before {
            content: ''; position: absolute; inset: 0;
            background: rgba(255,255,255,0); transition: background 0.2s;
        }
        .action-btn:hover::before { background: rgba(255,255,255,0.1); }
        .action-btn:hover          { transform: translateY(-3px); }
        .action-btn:active         { transform: translateY(0); }
        /* Active/open state */
        .action-btn.is-open {
            transform: translateY(0) !important;
            border-color: rgba(255,255,255,0.4) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.1) !important;
        }
        .action-btn.is-open::before { background: rgba(255,255,255,0.14); }

        .action-icon { font-size: 1.5rem; line-height: 1; }

        .btn-tabung { background: linear-gradient(145deg, #1a5e36, #16a34a); border-color: rgba(34,197,94,0.3);  box-shadow: 0 4px 16px rgba(22,163,74,0.3); }
        .btn-ambil  { background: linear-gradient(145deg, #991b1b, #ef4444); border-color: rgba(239,68,68,0.3);  box-shadow: 0 4px 16px rgba(239,68,68,0.3); }
        .btn-pinjam { background: linear-gradient(145deg, var(--gold-500), var(--gold-400)); border-color: rgba(212,160,23,0.4); box-shadow: 0 4px 16px rgba(212,160,23,0.3); color: var(--blue-900); }
        .btn-bayar  { background: linear-gradient(145deg, #0e7490, #0891b2); border-color: rgba(8,145,178,0.3);  box-shadow: 0 4px 16px rgba(8,145,178,0.3); }

        /* ──── ACCORDION PANEL ──── */
        .accordion-wrap {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-8px);
            transition:
                max-height 0.45s cubic-bezier(0.16, 1, 0.3, 1),
                opacity    0.3s  ease,
                transform  0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .accordion-wrap.is-open {
            max-height: 700px;
            opacity: 1;
            transform: translateY(0);
        }

        .accordion-panel {
            background: rgba(15, 36, 96, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-top: none;
            border-radius: 0 0 1.25rem 1.25rem;
            padding: 1.5rem 1.5rem 1.375rem;
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
            position: relative;
        }
        /* Colored top stripe matching active button */
        .accordion-panel::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            border-radius: 0;
        }
        .caret-tabung::before { background: #22c55e; }
        .caret-ambil::before  { background: #ef4444; }
        .caret-pinjam::before { background: var(--gold-400); }
        .caret-bayar::before  { background: #0891b2; }

        .panel-title {
            font-size: 1rem; font-weight: 800; color: var(--white);
            margin-bottom: 0.25rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .panel-divider {
            height: 2px;
            background: linear-gradient(90deg, var(--gold-400), transparent);
            border-radius: 2px; margin-bottom: 1.125rem;
        }
        .panel-saldo-info {
            background: rgba(212,160,23,0.1); border: 1px solid rgba(212,160,23,0.2);
            color: var(--gold-200); border-radius: 0.75rem;
            padding: 0.5rem 0.875rem; font-size: 0.8125rem;
            margin-bottom: 1rem; font-family: 'DM Sans', sans-serif;
        }
        .panel-info {
            background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
            color: var(--blue-200); border-radius: 0.75rem;
            padding: 0.5rem 0.875rem; font-size: 0.8125rem;
            margin-bottom: 1rem; font-family: 'DM Sans', sans-serif;
        }

        /* Form inside panels */
        .form-group { margin-bottom: 1.125rem; }
        .form-label {
            display: block; font-size: 0.8rem; font-weight: 600;
            color: var(--gold-200); margin-bottom: 0.4rem; letter-spacing: 0.2px;
        }
        .form-control {
            width: 100%; padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(59,130,246,0.25);
            border-radius: 0.75rem;
            font-family: 'DM Sans', sans-serif; font-size: 0.9375rem;
            color: var(--white); transition: all 0.2s; outline: none;
        }
        .form-control::placeholder { color: rgba(147,197,253,0.4); }
        .form-control:focus {
            background: rgba(255,255,255,0.09);
            border-color: var(--gold-400);
            box-shadow: 0 0 0 4px rgba(212,160,23,0.12);
        }
        .form-control.is-invalid { border-color: rgba(239,68,68,0.6); }
        select.form-control {
            cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2393c5fd' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        select.form-control option { background: #1a3580; color: #fff; }
        .error-msg { font-size: 0.8125rem; color: #fca5a5; margin-top: 0.3rem; font-family: 'DM Sans', sans-serif; }

        .panel-btns { display: flex; gap: 0.625rem; margin-top: 0.25rem; }
        .btn {
            flex: 1; padding: 0.8rem; border: none; border-radius: 0.75rem;
            font-family: 'Sora', sans-serif; font-size: 0.875rem; font-weight: 700;
            cursor: pointer; transition: all 0.25s; text-align: center;
        }
        .btn-green  { background: linear-gradient(135deg,#16a34a,#22c55e); color:#fff; box-shadow:0 4px 14px rgba(34,197,94,0.3); }
        .btn-red    { background: linear-gradient(135deg,#dc2626,#ef4444); color:#fff; box-shadow:0 4px 14px rgba(239,68,68,0.3); }
        .btn-yellow { background: linear-gradient(135deg,var(--gold-500),var(--gold-400)); color:var(--blue-900); box-shadow:0 4px 14px rgba(212,160,23,0.3); }
        .btn-cyan   { background: linear-gradient(135deg,#0e7490,#0891b2); color:#fff; box-shadow:0 4px 14px rgba(8,145,178,0.3); }
        .btn-gray   { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); color:var(--blue-200); flex: 0 0 auto; padding-left:1.25rem; padding-right:1.25rem; }
        .btn:hover  { transform:translateY(-1px); filter:brightness(1.08); }
        .btn-gray:hover { background:rgba(255,255,255,0.14); filter:none; }

        .panel-empty {
            padding: 0.5rem 0 0.25rem;
            text-align: center; color: var(--blue-300);
            font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
        }

        /* ──── SECTION CARD (Table) ──── */
        .section-card {
            background: rgba(15, 36, 96, 0.5);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem; overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        .section-header {
            padding: 1rem 1.25rem; font-size: 0.9375rem; font-weight: 700;
            color: var(--white); border-bottom: 1px solid rgba(212,160,23,0.15);
            background: rgba(255,255,255,0.03);
            display: flex; align-items: center; gap: 0.5rem;
        }
        .section-header-dot { width: 8px; height: 8px; background: var(--gold-400); border-radius: 50%; }
        table { width: 100%; border-collapse: collapse; }
        th {
            padding: 0.75rem 1.125rem; text-align: left;
            font-size: 0.75rem; font-weight: 700; color: var(--blue-300);
            text-transform: uppercase; letter-spacing: 0.75px;
            border-bottom: 1px solid rgba(59,130,246,0.15);
            font-family: 'DM Sans', sans-serif;
        }
        td {
            padding: 0.9rem 1.125rem; font-size: 0.875rem;
            color: var(--blue-100); border-bottom: 1px solid rgba(59,130,246,0.08);
            font-family: 'DM Sans', sans-serif;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.03); }
        .badge { display:inline-block; padding:0.2rem 0.625rem; border-radius:99px; font-size:0.6875rem; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; }
        .badge-active { background:rgba(212,160,23,0.15); border:1px solid rgba(212,160,23,0.35); color:var(--gold-300); }
        .badge-lunas  { background:rgba(34,197,94,0.12); border:1px solid rgba(34,197,94,0.3); color:#86efac; }
        .empty-state { padding:2.5rem; text-align:center; color:var(--blue-300); font-size:0.875rem; font-family:'DM Sans',sans-serif; }
        .empty-icon  { font-size:2rem; display:block; margin-bottom:0.5rem; opacity:0.5; }

        @media (max-width: 480px) {
            .actions { grid-template-columns: repeat(2, 1fr); }
            .saldo-amount { font-size: 2rem; }
            .user-name { display: none; }
            .panel-btns { flex-wrap: wrap; }
            .btn-gray { flex: 1; }
        }
    </style>
</head>
<body>
<div class="bg-grid"></div>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-brand">
        <div class="brand-icon">🏦</div>
        <span class="brand-name">AdaKhamid</span>
    </div>
    <div class="navbar-right">
        <div class="user-pill">
            <div class="user-avatar">👤</div>
            <span class="user-name">{{ auth()->user()->nama_lengkap }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="main">

    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if ($errors->any() && !session('panel'))
        <div class="alert alert-error">⚠️ {{ $errors->first() }}</div>
    @endif

    <!-- SALDO CARD -->
    <div class="saldo-card">
        <div class="saldo-top">
            <div class="saldo-label">Saldo Tabungan</div>
            <div class="saldo-chip">💳 Aktif</div>
        </div>
        <div class="saldo-amount">
            <span class="currency">Rp </span>{{ number_format($user->saldo, 0, ',', '.') }}
        </div>
        <div class="saldo-footer">
            <div class="saldo-dot"></div>
            <span class="saldo-status">Rekening terverifikasi · {{ auth()->user()->nama_lengkap }}</span>
        </div>
    </div>

    <!-- ──── ACTION AREA ──── -->
    <div class="action-area">

        <!-- 4 tombol aksi -->
        <div class="actions">
            <button class="action-btn btn-tabung" id="btnTabung" onclick="togglePanel('tabung')">
                <span class="action-icon">💰</span> Tabung
            </button>
            <button class="action-btn btn-ambil" id="btnAmbil" onclick="togglePanel('ambil')">
                <span class="action-icon">🏧</span> Ambil
            </button>
            <button class="action-btn btn-pinjam" id="btnPinjam" onclick="togglePanel('pinjam')">
                <span class="action-icon">📋</span> Pinjam
            </button>
            <button class="action-btn btn-bayar" id="btnBayar" onclick="togglePanel('bayar')">
                <span class="action-icon">💳</span> Bayar
            </button>
        </div>

        <!-- ===== PANEL TABUNG ===== -->
        <div class="accordion-wrap" id="panelTabung">
            <div class="accordion-panel caret-tabung">
                <div class="panel-title">💰 Tabung Uang</div>
                <div class="panel-divider"></div>

                @if ($errors->has('jumlah') && session('panel') == 'tabung')
                    <div class="alert alert-error" style="margin-bottom:1rem">⚠️ {{ $errors->first('jumlah') }}</div>
                @endif

                <form method="POST" action="{{ route('tabung') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="jumlah_tabung">Jumlah Tabungan (Rp)</label>
                        <input type="number" id="jumlah_tabung" name="jumlah"
                               class="form-control {{ $errors->has('jumlah') && session('panel')=='tabung' ? 'is-invalid' : '' }}"
                               min="1000" step="1000"
                               value="{{ old('jumlah') }}"
                               placeholder="Minimal Rp 1.000">
                        @if($errors->has('jumlah') && session('panel')=='tabung')
                            <div class="error-msg">{{ $errors->first('jumlah') }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="panel" value="tabung">
                    <div class="panel-btns">
                        <button type="submit" class="btn btn-green">Simpan Tabungan</button>
                        <button type="button" class="btn btn-gray" onclick="togglePanel('tabung')">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== PANEL AMBIL ===== -->
        <div class="accordion-wrap" id="panelAmbil">
            <div class="accordion-panel caret-ambil">
                <div class="panel-title">🏧 Ambil Uang</div>
                <div class="panel-divider"></div>
                <div class="panel-saldo-info">💰 Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></div>

                <form method="POST" action="{{ route('ambil') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="jumlah_ambil">Jumlah Penarikan (Rp)</label>
                        <input type="number" id="jumlah_ambil" name="jumlah"
                               class="form-control {{ $errors->has('jumlah') && session('panel')=='ambil' ? 'is-invalid' : '' }}"
                               min="1000" step="1000" max="{{ $user->saldo }}"
                               placeholder="Masukkan jumlah">
                        @if($errors->has('jumlah') && session('panel')=='ambil')
                            <div class="error-msg">{{ $errors->first('jumlah') }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="panel" value="ambil">
                    <div class="panel-btns">
                        <button type="submit" class="btn btn-red">Ambil Uang</button>
                        <button type="button" class="btn btn-gray" onclick="togglePanel('ambil')">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== PANEL PINJAM ===== -->
        <div class="accordion-wrap" id="panelPinjam">
            <div class="accordion-panel caret-pinjam">
                <div class="panel-title">📋 Ajukan Pinjaman</div>
                <div class="panel-divider"></div>
                <div class="panel-info">ℹ️ Pinjaman langsung ditambahkan ke saldo Anda setelah diajukan.</div>

                <form method="POST" action="{{ route('pinjam') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="jumlah_pinjam">Jumlah Pinjaman (Rp)</label>
                        <input type="number" id="jumlah_pinjam" name="jumlah"
                               class="form-control {{ $errors->has('jumlah') && session('panel')=='pinjam' ? 'is-invalid' : '' }}"
                               min="10000" step="1000"
                               placeholder="Minimal Rp 10.000">
                        @if($errors->has('jumlah') && session('panel')=='pinjam')
                            <div class="error-msg">{{ $errors->first('jumlah') }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="panel" value="pinjam">
                    <div class="panel-btns">
                        <button type="submit" class="btn btn-yellow">Ajukan Pinjaman</button>
                        <button type="button" class="btn btn-gray" onclick="togglePanel('pinjam')">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== PANEL BAYAR ===== -->
        <div class="accordion-wrap" id="panelBayar">
            <div class="accordion-panel caret-bayar">
                <div class="panel-title">💳 Bayar Pinjaman</div>
                <div class="panel-divider"></div>
                <div class="panel-saldo-info">💰 Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></div>

                @if ($pinjamanAktif->count() > 0)
                <form method="POST" action="{{ route('bayar.pinjaman') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="pinjaman_id">Pilih Pinjaman</label>
                        <select id="pinjaman_id" name="pinjaman_id"
                                class="form-control {{ $errors->has('pinjaman_id') && session('panel')=='bayar' ? 'is-invalid' : '' }}"
                                onchange="setSisaPinjaman(this)">
                            <option value="">-- Pilih Pinjaman --</option>
                            @foreach ($pinjamanAktif as $p)
                                <option value="{{ $p->id }}" data-sisa="{{ $p->sisa_pinjaman }}">
                                    {{ $p->tanggal_pinjam->format('d/m/Y') }} — Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('pinjaman_id') && session('panel')=='bayar')
                            <div class="error-msg">{{ $errors->first('pinjaman_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="jumlah_bayar">Jumlah Pembayaran (Rp)</label>
                        <input type="number" id="jumlah_bayar" name="jumlah"
                               class="form-control {{ $errors->has('jumlah') && session('panel')=='bayar' ? 'is-invalid' : '' }}"
                               min="1000" step="1000"
                               placeholder="Masukkan jumlah pembayaran">
                        @if($errors->has('jumlah') && session('panel')=='bayar')
                            <div class="error-msg">{{ $errors->first('jumlah') }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="panel" value="bayar">
                    <div class="panel-btns">
                        <button type="submit" class="btn btn-cyan">Bayar Pinjaman</button>
                        <button type="button" class="btn btn-gray" onclick="togglePanel('bayar')">Batal</button>
                    </div>
                </form>
                @else
                    <div class="panel-empty">✅ Tidak ada pinjaman aktif yang perlu dibayar.</div>
                    <div class="panel-btns" style="margin-top:0.75rem">
                        <button type="button" class="btn btn-gray" onclick="togglePanel('bayar')">Tutup</button>
                    </div>
                @endif
            </div>
        </div>

    </div><!-- /.action-area -->

    <!-- PINJAMAN AKTIF TABLE -->
    <div class="section-card">
        <div class="section-header">
            <span class="section-header-dot"></span>
            Pinjaman Aktif
        </div>
        @if ($pinjamanAktif->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Pinjaman</th>
                        <th>Sisa Pinjaman</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pinjamanAktif as $p)
                    <tr>
                        <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td>Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                        <td><span class="badge badge-active">Aktif</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                Tidak ada pinjaman aktif saat ini.
            </div>
        @endif
    </div>

</div><!-- /.main -->

<script>
    let current = null;

    function togglePanel(name) {
        if (current === name) {
            closePanel(name);
            current = null;
        } else {
            if (current) closePanel(current);
            openPanel(name);
            current = name;
        }
    }

    function openPanel(name) {
        const id = cap(name);
        document.getElementById('panel' + id).classList.add('is-open');
        document.getElementById('btn'   + id).classList.add('is-open');
        setTimeout(() => {
            document.getElementById('panel' + id)
                .scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 80);
    }

    function closePanel(name) {
        const id = cap(name);
        document.getElementById('panel' + id).classList.remove('is-open');
        document.getElementById('btn'   + id).classList.remove('is-open');
    }

    function cap(s) { return s.charAt(0).toUpperCase() + s.slice(1); }

    function setSisaPinjaman(select) {
        const opt   = select.options[select.selectedIndex];
        const sisa  = opt.dataset.sisa || '';
        const input = document.getElementById('jumlah_bayar');
        if (sisa) { input.max = sisa; input.value = sisa; }
        else      { input.removeAttribute('max'); input.value = ''; }
    }

    // Re-open correct panel after validation error redirect
    @if(session('panel'))
        openPanel('{{ session('panel') }}');
    @endif
</script>

</body>
</html>
