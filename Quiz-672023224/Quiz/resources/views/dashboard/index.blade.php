@extends('layouts.app')
@section('title', 'Dashboard - Quiz')

@section('extra-styles')
<style>
    /* ── Layout ── */
    .page { max-width: 680px; margin: 0 auto; padding: 20px 16px 40px; }

    /* ── Topbar ── */
    .topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }
    .topbar {
    display: flex; 
    align-items: center; 
    justify-content: b;
    width: 100%;
    margin-bottom: 20px;
}

.topbar-brand { 
    font-size: 20px; 
    font-weight: 800; 
    color: #ffffff; 
    flex-grow: 1; 
}

.topbar-user { 
    display: flex;
    align-items: center;
    gap: 12px; 
}
    .btn-logout {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 6px 14px; background: var(--red-light); color: var(--red-dark);
        border: none; border-radius: 8px; font-family: inherit;
        font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none;
        transition: background .15s;
    }
    .btn-logout:hover { background: #991b1b; }

    /* ── Saldo Card ── */
    .saldo-card {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        border-radius: 14px;
        padding: 28px 24px;
        color: #fff;
        text-align: center;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(2,132,199,.35);
    }
    .saldo-label { font-size: 14px; font-weight: 600; opacity: .85; letter-spacing: .5px; }
    .saldo-amount { font-size: 40px; font-weight: 800; margin-top: 4px; letter-spacing: -1px; }

    /* ── Action Buttons ── */
    .action-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 20px;
    }
    .action-btn {
        padding: 12px 8px;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: filter .15s, transform .1s;
    }
    .action-btn:active { transform: scale(.96); }
    .action-btn-green  { background: var(--green);  color: #fff; }
    .action-btn-red    { background: var(--red);    color: #fff; }
    .action-btn-yellow { background: var(--yellow); color: #fff; }
    .action-btn-blue   { background: var(--blue);   color: #fff; }
    .action-btn:hover  { filter: brightness(1.1); }

    /* ── Pinjaman Section ── */
    .section-title {
        font-size: 14px; font-weight: 700; color: var(--gray-600);
        margin-bottom: 10px; padding: 0 2px;
    }
    .empty-state {
        text-align: center; padding: 28px; color: var(--gray-400); font-size: 14px;
    }

    /* ── Info box in modal ── */
    .info-box {
        background: var(--blue-light); color: var(--blue-dark);
        border-radius: 8px; padding: 12px 14px; font-size: 13px;
        font-weight: 500; margin-bottom: 18px; line-height: 1.5;
    }
    .saldo-info {
        font-size: 14px; color: var(--gray-700); margin-bottom: 16px;
    }
    .saldo-info strong { color: var(--gray-900); }
</style>
@endsection

@section('content')
<div class="page">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-brand">Bank-Bankan</div>
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="topbar-user">Halo, <span>{{ $user->nama_lengkap }}</span></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">⬅ Keluar</button>
            </form>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">⚠️ {{ $errors->first() }}</div>
    @endif

    {{-- Saldo --}}
    <div class="saldo-card">
        <div class="saldo-label">Saldo Anda</div>
        <div class="saldo-amount">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
    </div>

    {{-- Action Buttons --}}
    <div class="action-grid">

    <button class="action-btn action-btn-green"
            onclick="openModal('modal-tabung')">

        <div class="action-icon">💰</div>
        <div>Tabung</div>

    </button>

    <button class="action-btn action-btn-red"
            onclick="openModal('modal-ambil')">

        <div class="action-icon">🏧</div>
        <div>Ambil</div>

    </button>

    <button class="action-btn action-btn-yellow"
            onclick="openModal('modal-pinjam')">

        <div class="action-icon">🤝</div>
        <div>Pinjam</div>

    </button>

    <button class="action-btn action-btn-blue"
            onclick="openModal('modal-bayar')">

        <div class="action-icon">💳</div>
        <div>Bayar</div>

    </button>

</div>

    {{-- Pinjaman Aktif --}}
    <div class="card">
        <div class="card-header">Pinjaman Aktif</div>
        <div class="table-wrap">
            @if ($pinjamanAktif->isEmpty())
                <div class="empty-state">Anda tidak memiliki pinjaman aktif.</div>
            @else
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
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td><span class="badge badge-yellow">Active</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>

{{-- ═══════════════ MODAL TABUNG ═══════════════ --}}
<div class="modal-overlay" id="modal-tabung">
    <div class="modal">
        <div class="modal-header">Tabung Uang</div>
        <div class="modal-body">
            <form method="POST" action="{{ route('tabung') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Jumlah Tabungan (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000"
                           placeholder="Contoh: 50000" required>
                </div>
                <button type="submit" class="btn btn-green" style="margin-bottom:10px;">Simpan Tabungan</button>
                <button type="button" class="btn btn-gray" onclick="closeModal('modal-tabung')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL AMBIL ═══════════════ --}}
<div class="modal-overlay" id="modal-ambil">
    <div class="modal">
        <div class="modal-header">Ambil Uang</div>
        <div class="modal-body">
            <div class="saldo-info">
                Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong>
            </div>
            <form method="POST" action="{{ route('ambil') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Jumlah Penarikan (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000"
                           max="{{ $user->saldo }}" placeholder="Contoh: 20000" required>
                </div>
                <button type="submit" class="btn btn-red" style="margin-bottom:10px;">Ambil Uang</button>
                <button type="button" class="btn btn-gray" onclick="closeModal('modal-ambil')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL PINJAM ═══════════════ --}}
<div class="modal-overlay" id="modal-pinjam">
    <div class="modal">
        <div class="modal-header">Ajukan Pinjaman</div>
        <div class="modal-body">
            <div class="info-box">
                Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.
            </div>
            <form method="POST" action="{{ route('pinjam') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Jumlah Pinjaman (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000"
                           placeholder="Contoh: 100000" required>
                </div>
                <button type="submit" class="btn btn-yellow" style="margin-bottom:10px;">Ajukan Pinjaman</button>
                <button type="button" class="btn btn-gray" onclick="closeModal('modal-pinjam')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL BAYAR PINJAMAN ═══════════════ --}}
<div class="modal-overlay" id="modal-bayar">
    <div class="modal">
        <div class="modal-header">Bayar Pinjaman</div>
        <div class="modal-body">
            <div class="saldo-info">
                Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong>
            </div>

            @if ($pinjamanAktif->isEmpty())
                <div class="empty-state" style="padding:20px 0;">Tidak ada pinjaman aktif.</div>
                <button type="button" class="btn btn-gray" onclick="closeModal('modal-bayar')">Tutup</button>
            @else
                <form method="POST" action="{{ route('bayar.pinjaman') }}" id="form-bayar">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Pilih Pinjaman</label>
                        <select name="pinjaman_id" id="select-pinjaman" class="form-control" required onchange="updateSisa()">
                            @foreach ($pinjamanAktif as $p)
                            <option value="{{ $p->id }}"
                                    data-sisa="{{ $p->sisa_pinjaman }}"
                                    data-tanggal="{{ $p->created_at->format('d/m/Y') }}">
                                Pinjaman {{ $p->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Pembayaran (Rp)</label>
                        <input type="number" name="jumlah" id="input-bayar" class="form-control"
                               min="1000" step="1000" placeholder="Masukkan jumlah bayar" required>
                        <div style="font-size:12px;color:var(--gray-500);margin-top:4px;" id="sisa-info"></div>
                    </div>

                    <button type="submit" class="btn btn-blue" style="margin-bottom:10px;">Bayar Pinjaman</button>
                    <button type="button" class="btn btn-gray" onclick="closeModal('modal-bayar')">Batal</button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
function openModal(id)  { document.getElementById(id).classList.add('active');    document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow = ''; }

// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

// Update sisa info on pinjaman select
function updateSisa() {
    const sel  = document.getElementById('select-pinjaman');
    const opt  = sel.options[sel.selectedIndex];
    const sisa = parseInt(opt.dataset.sisa || 0);
    const inp  = document.getElementById('input-bayar');
    const info = document.getElementById('sisa-info');
    inp.max = sisa;
    if (info) info.textContent = 'Sisa pinjaman: Rp ' + sisa.toLocaleString('id-ID');
}

// Init sisa on load
document.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('select-pinjaman');
    if (sel) updateSisa();
});

// Auto open modal if there's an error (re-open the form that had errors)
@if ($errors->any())
    // Reopen relevant modal based on previous action
    const lastAction = '{{ session("last_action", "") }}';
    if (lastAction) openModal('modal-' + lastAction);
@endif
</script>
@endsection
