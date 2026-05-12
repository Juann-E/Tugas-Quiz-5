@extends('layouts.app')
@section('title', 'Dashboard - GONDRONG LOAN')
@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    * { font-family: 'Poppins', sans-serif; }

    body { background: #0f0f1a; }

    .saldo-card {
        background: linear-gradient(135deg, #6c3de8, #a855f7, #ec4899);
        border-radius: 20px;
        padding: 32px 24px;
        text-align: center;
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(168,85,247,0.4);
        position: relative;
        overflow: hidden;
    }
    .saldo-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .saldo-card::after {
        content: '';
        position: absolute;
        bottom: -50px; left: -20px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .saldo-greeting { font-size: 13px; color: rgba(255,255,255,0.75); font-weight: 500; margin-bottom: 4px; }
    .saldo-name { font-size: 16px; color: white; font-weight: 700; margin-bottom: 16px; }
    .saldo-label { font-size: 12px; color: rgba(255,255,255,0.7); letter-spacing: 2px; text-transform: uppercase; }
    .saldo-amount { font-size: 40px; font-weight: 800; color: white; margin-top: 4px; line-height: 1.1; }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }
    .action-card {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        border-radius: 16px;
        padding: 16px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .action-card:hover { transform: translateY(-3px); border-color: #6c3de8; }
    .action-card:disabled, .action-card[disabled] { opacity: 0.4; cursor: not-allowed; transform: none; }
    .action-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }
    .icon-tabung  { background: rgba(34,197,94,0.15);  color: #22c55e; }
    .icon-ambil   { background: rgba(239,68,68,0.15);  color: #ef4444; }
    .icon-pinjam  { background: rgba(251,146,60,0.15); color: #fb923c; }
    .icon-bayar   { background: rgba(56,189,248,0.15); color: #38bdf8; }
    .action-label { font-size: 11px; font-weight: 600; color: #aaa; }

    .section-card {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .section-head {
        padding: 16px 20px;
        border-bottom: 1px solid #2a2a4a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-head-icon {
        width: 32px; height: 32px;
        background: rgba(108,61,232,0.2);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    .section-head-title { font-size: 14px; font-weight: 700; color: #e2e2f0; }

    table { width: 100%; border-collapse: collapse; }
    th { padding: 12px 20px; font-size: 11px; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 1px; background: #141428; text-align: left; }
    td { padding: 14px 20px; font-size: 13px; color: #ccc; border-top: 1px solid #1f1f38; }
    .badge-active {
        background: rgba(251,146,60,0.15);
        color: #fb923c;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid rgba(251,146,60,0.3);
    }
    .empty-state { text-align: center; padding: 32px; color: #555; font-size: 13px; }
    .empty-state .empty-icon { font-size: 36px; margin-bottom: 8px; }

    /* MODAL */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 100; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-overlay.active { display: flex; }
    .modal {
        background: #1a1a2e;
        border: 1px solid #2a2a4a;
        border-radius: 20px;
        width: 90%; max-width: 400px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        animation: slideUp 0.25s ease;
    }
    @keyframes slideUp { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header {
        padding: 20px 24px 16px;
        display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid #2a2a4a;
    }
    .modal-header-icon { font-size: 24px; }
    .modal-header-title { font-size: 16px; font-weight: 700; color: #e2e2f0; }
    .modal-body { padding: 20px 24px; }

    .info-box { background: rgba(56,189,248,0.08); border: 1px solid rgba(56,189,248,0.2); border-radius: 10px; padding: 10px 14px; font-size: 12px; color: #38bdf8; margin-bottom: 16px; }
    .saldo-info { font-size: 13px; color: #888; margin-bottom: 16px; }
    .saldo-info strong { color: #a855f7; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; color: #888; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control {
        width: 100%; padding: 12px 14px;
        background: #0f0f1a;
        border: 1px solid #2a2a4a;
        border-radius: 10px;
        font-size: 14px; color: #e2e2f0;
        outline: none;
        transition: border-color 0.2s;
        font-family: 'Poppins', sans-serif;
    }
    .form-control:focus { border-color: #6c3de8; }
    .form-control option { background: #1a1a2e; }

    .btn-submit {
        width: 100%; padding: 13px;
        border: none; border-radius: 12px;
        color: white; font-size: 14px; font-weight: 700;
        cursor: pointer; margin-bottom: 10px;
        font-family: 'Poppins', sans-serif;
        transition: opacity 0.2s, transform 0.1s;
    }
    .btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-cancel {
        width: 100%; padding: 11px;
        background: transparent;
        border: 1px solid #2a2a4a;
        border-radius: 12px; color: #888;
        font-size: 13px; font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }
    .btn-cancel:hover { border-color: #555; color: #aaa; }

    .btn-tabung-submit { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .btn-ambil-submit  { background: linear-gradient(135deg, #dc2626, #ef4444); }
    .btn-pinjam-submit { background: linear-gradient(135deg, #ea580c, #fb923c); }
    .btn-bayar-submit  { background: linear-gradient(135deg, #0284c7, #38bdf8); }
</style>
@endpush

@section('content')

{{-- Saldo Card --}}
<div class="saldo-card">
    <div class="saldo-greeting">Selamat datang,</div>
    <div class="saldo-name">{{ Auth::user()->nama_lengkap }} 👋</div>
    <div class="saldo-label">Total Saldo</div>
    <div class="saldo-amount">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
</div>

{{-- Action Buttons --}}
<div class="action-grid">
    <div class="action-card" onclick="openModal('tabungModal')">
        <div class="action-icon icon-tabung">💰</div>
        <span class="action-label">Tabung</span>
    </div>
    <div class="action-card" onclick="openModal('ambilModal')">
        <div class="action-icon icon-ambil">💸</div>
        <span class="action-label">Ambil</span>
    </div>
    <div class="action-card" onclick="openModal('pinjamModal')">
        <div class="action-icon icon-pinjam">🤝</div>
        <span class="action-label">Pinjam</span>
    </div>
    <div class="action-card {{ $pinjamanAktif->isEmpty() ? 'disabled' : '' }}"
         onclick="{{ $pinjamanAktif->isEmpty() ? '' : 'openModal(\'bayarModal\')' }}"
         @if($pinjamanAktif->isEmpty()) disabled @endif>
        <div class="action-icon icon-bayar">✅</div>
        <span class="action-label">Bayar</span>
    </div>
</div>

{{-- Pinjaman Aktif --}}
<div class="section-card">
    <div class="section-head">
        <div class="section-head-icon">📋</div>
        <span class="section-head-title">Pinjaman Aktif</span>
    </div>
    @if($pinjamanAktif->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            Anda tidak memiliki pinjaman aktif.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Sisa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pinjamanAktif as $p)
                <tr>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                    <td>Rp {{ number_format($p->total_pinjaman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                    <td><span class="badge-active">Active</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- MODAL TABUNG --}}
<div class="modal-overlay" id="tabungModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-header-icon">💰</span>
            <span class="modal-header-title">Tabung Uang</span>
        </div>
        <div class="modal-body">
            <form action="{{ route('tabung') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jumlah Tabungan (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000" placeholder="Contoh: 50000">
                </div>
                <button type="submit" class="btn-submit btn-tabung-submit">Simpan Tabungan</button>
                <button type="button" class="btn-cancel" onclick="closeModal('tabungModal')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL AMBIL --}}
<div class="modal-overlay" id="ambilModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-header-icon">💸</span>
            <span class="modal-header-title">Ambil Uang</span>
        </div>
        <div class="modal-body">
            <p class="saldo-info">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
            <form action="{{ route('ambil') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jumlah Penarikan (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000" max="{{ $user->saldo }}" placeholder="Contoh: 20000">
                </div>
                <button type="submit" class="btn-submit btn-ambil-submit">Ambil Uang</button>
                <button type="button" class="btn-cancel" onclick="closeModal('ambilModal')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PINJAM --}}
<div class="modal-overlay" id="pinjamModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-header-icon">🤝</span>
            <span class="modal-header-title">Ajukan Pinjaman</span>
        </div>
        <div class="modal-body">
            <div class="info-box">💡 Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</div>
            <form action="{{ route('pinjam') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jumlah Pinjaman (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" min="1000" step="1000" placeholder="Contoh: 100000">
                </div>
                <button type="submit" class="btn-submit btn-pinjam-submit">Ajukan Pinjaman</button>
                <button type="button" class="btn-cancel" onclick="closeModal('pinjamModal')">Batal</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL BAYAR PINJAMAN --}}
<div class="modal-overlay" id="bayarModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-header-icon">✅</span>
            <span class="modal-header-title">Bayar Pinjaman</span>
        </div>
        <div class="modal-body">
            <p class="saldo-info">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
            <form action="{{ route('bayar.pinjaman') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Pilih Pinjaman</label>
                    <select name="pinjaman_id" class="form-control" onchange="updateMax(this)">
                        <option value="">-- Pilih Pinjaman --</option>
                        @foreach($pinjamanAktif as $p)
                        <option value="{{ $p->id }}" data-sisa="{{ $p->sisa_pinjaman }}">
                            Pinjaman {{ $p->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Pembayaran (Rp)</label>
                    <input type="number" name="jumlah" id="jumlahBayar" class="form-control" min="1000" step="1000" placeholder="Contoh: 60000">
                </div>
                <button type="submit" class="btn-submit btn-bayar-submit">Bayar Pinjaman</button>
                <button type="button" class="btn-cancel" onclick="closeModal('bayarModal')">Batal</button>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function openModal(id)  { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
    });
    function updateMax(select) {
        const sisa = select.options[select.selectedIndex]?.dataset.sisa;
        if (sisa) document.getElementById('jumlahBayar').max = sisa;
    }
</script>
@endpush