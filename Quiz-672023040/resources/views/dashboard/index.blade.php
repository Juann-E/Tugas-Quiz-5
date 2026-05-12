@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── Saldo card ───────────────────────────────────────────────────────── --}}
<div style="background:linear-gradient(135deg, #163055 0%, #0c2340 100%);border-radius:16px;padding:28px;text-align:center;margin-bottom:20px;box-shadow:0 8px 30px rgba(12,35,64,0.35);">
    <div style="color:rgba(255,215,0,0.9);font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Saldo Anda</div>
    <div style="color:#fff;font-size:36px;font-weight:800;margin-top:6px;font-family:'Inter',sans-serif;">
        Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}
    </div>
</div>

{{-- ── Action buttons ───────────────────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:24px;">
    <button onclick="toggleForm('form-tabung')" class="btn-action btn-green">💰 Tabung</button>
    <button onclick="toggleForm('form-ambil')" class="btn-action btn-red">💸 Ambil</button>
    <button onclick="toggleForm('form-pinjam')" class="btn-action btn-yellow">📈 Pinjam</button>
    <button onclick="toggleForm('form-bayar')" class="btn-action btn-cyan">💳 Bayar Pinjaman</button>
</div>

{{-- ── Form: Tabung ─────────────────────────────────────────────────────── --}}
<div id="form-tabung" class="form-card" style="display:none;">
    <h3 style="margin-bottom:16px;font-size:16px;font-weight:700;color:#0c2340;">💰 Tabung Uang</h3>
    <form method="POST" action="{{ route('tabung') }}">
        @csrf
        <div class="form-group">
            <label>Jumlah Tabungan (Rp)</label>
            <input type="number" name="jumlah" min="1" placeholder="0" required>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-action-save">Simpan Tabungan</button>
            <button type="button" onclick="toggleForm('form-tabung')" class="btn-action-cancel">Batal</button>
        </div>
    </form>
</div>

{{-- ── Form: Ambil ──────────────────────────────────────────────────────── --}}
<div id="form-ambil" class="form-card" style="display:none;">
    <h3 style="margin-bottom:8px;font-size:16px;font-weight:700;color:#0c2340;">💸 Ambil Uang</h3>
    <p style="font-size:13px;margin-bottom:14px;color:#6b7fa3;">
        Saldo saat ini: <strong style="color:#163055;">Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</strong>
    </p>
    <form method="POST" action="{{ route('ambil') }}">
        @csrf
        <div class="form-group">
            <label>Jumlah Penarikan (Rp)</label>
            <input type="number" name="jumlah" min="1" max="{{ $tabungan->saldo }}" placeholder="0" required>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-action-danger">Ambil Uang</button>
            <button type="button" onclick="toggleForm('form-ambil')" class="btn-action-cancel">Batal</button>
        </div>
    </form>
</div>

{{-- ── Form: Pinjam ─────────────────────────────────────────────────────── --}}
<div id="form-pinjam" class="form-card" style="display:none;">
    <h3 style="margin-bottom:8px;font-size:16px;font-weight:700;color:#0c2340;">📈 Ajukan Pinjaman</h3>
    <div style="background:rgba(255,215,0,0.08);border-radius:10px;padding:12px 16px;margin-bottom:14px;font-size:13px;color:#8B6914;border:1px solid rgba(255,215,0,0.25);">
        Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.
    </div>
    <form method="POST" action="{{ route('pinjam') }}">
        @csrf
        <div class="form-group">
            <label>Jumlah Pinjaman (Rp)</label>
            <input type="number" name="jumlah" min="1" placeholder="0" required>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-action-yellow">Ajukan Pinjaman</button>
            <button type="button" onclick="toggleForm('form-pinjam')" class="btn-action-cancel">Batal</button>
        </div>
    </form>
</div>

{{-- ── Form: Bayar Pinjaman ─────────────────────────────────────────────── --}}
<div id="form-bayar" class="form-card" style="display:none;">
    <h3 style="margin-bottom:8px;font-size:16px;font-weight:700;color:#0c2340;">💳 Bayar Pinjaman</h3>
    <p style="font-size:13px;margin-bottom:14px;color:#6b7fa3;">
        Saldo saat ini: <strong style="color:#163055;">Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</strong>
    </p>

    @if($pinjamanss->count() > 0)
        <form method="POST" action="{{ route('bayar.pinjaman') }}">
            @csrf
            <div class="form-group">
                <label>Pilih Pinjaman</label>
                <select name="pinjaman_id" id="select-pinjaman" onchange="updateSisa(this)" style="width:100%;padding:12px 16px;border:1.5px solid #bfd4ea;border-radius:12px;font-size:14px;background:#fff;color:#1a2744;font-family:'Inter',sans-serif;">
                    @foreach($pinjamanss as $p)
                        <option value="{{ $p->id }}"
                                data-sisa="{{ $p->sisa_pinjaman }}"
                                data-tanggal="{{ $p->created_at->format('d/m/Y') }}">
                            Pinjaman {{ $p->created_at->format('d/m/Y') }}
                            - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Pembayaran (Rp)</label>
                <input type="number" name="jumlah" id="input-bayar" min="1" placeholder="0" required>
                <small id="info-sisa" style="color:#FFD700;font-size:12px;"></small>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-action-cyan">Bayar Pinjaman</button>
                <button type="button" onclick="toggleForm('form-bayar')" class="btn-action-cancel">Batal</button>
            </div>
        </form>
    @else
        <p style="color:#94a3b8;font-size:13px;">Tidak ada pinjaman aktif untuk dibayar.</p>
        <button type="button" onclick="toggleForm('form-bayar')" class="btn-action-cancel" style="margin-top:10px;">Tutup</button>
    @endif
</div>

{{-- ── Tabel Pinjaman Aktif ─────────────────────────────────────────────── --}}
<div class="card" style="background:#fff;border:1px solid #e0e8f0;border-radius:16px;padding:24px;box-shadow:0 2px 10px rgba(12,35,64,0.05);">
    <h3 style="margin-bottom:16px;font-size:15px;font-weight:700;color:#0c2340;">📋 Pinjaman Aktif</h3>

    @if($pinjamanss->count() > 0)
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="border-bottom:2px solid #e0e8f0;">
                        <th style="text-align:left;padding:10px 12px;color:#6b7fa3;font-weight:600;">Tanggal</th>
                        <th style="text-align:left;padding:10px 12px;color:#6b7fa3;font-weight:600;">Total Pinjaman</th>
                        <th style="text-align:left;padding:10px 12px;color:#6b7fa3;font-weight:600;">Sisa Pinjaman</th>
                        <th style="text-align:left;padding:10px 12px;color:#6b7fa3;font-weight:600;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pinjamanss as $p)
                    <tr style="border-bottom:1px solid #f0f4f8;">
                        <td style="padding:10px 12px;color:#3a5068;">{{ $p->created_at->format('d M Y') }}</td>
                        <td style="padding:10px 12px;color:#163055;font-weight:600;">Rp {{ number_format($p->total_pinjaman, 0, ',', '.') }}</td>
                        <td style="padding:10px 12px;color:#8B6914;font-weight:600;">Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                        <td style="padding:10px 12px;">
                            <span style="background:rgba(255,215,0,0.1);color:#8B6914;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;">
                                🟡 Active
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="color:#94a3b8;font-size:13px;text-align:center;padding:20px;">Anda tidak memiliki pinjaman aktif.</p>
    @endif
</div>

{{-- ── Logout ───────────────────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('logout') }}" style="margin-top:20px;">
    @csrf
    <button type="submit" class="btn-action-cancel">🚪 Logout ({{ Auth::user()->name }})</button>
</form>

@section('styles')
<style>
    .form-card {
        background: #fff;
        border: 1px solid #e0e8f0;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
        box-shadow: 0 2px 10px rgba(12,35,64,0.05);
    }

    .btn-action {
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        color: #fff;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .btn-green {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        box-shadow: 0 4px 12px rgba(34,197,94,0.25);
    }
    .btn-green:hover {
        box-shadow: 0 6px 20px rgba(34,197,94,0.35);
    }

    .btn-red {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 4px 12px rgba(239,68,68,0.25);
    }
    .btn-red:hover {
        box-shadow: 0 6px 20px rgba(239,68,68,0.35);
    }

    .btn-yellow {
        background: linear-gradient(135deg, #eab308, #d97706);
        box-shadow: 0 4px 12px rgba(234,179,8,0.25);
    }
    .btn-yellow:hover {
        box-shadow: 0 6px 20px rgba(234,179,8,0.35);
    }

    .btn-cyan {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        box-shadow: 0 4px 12px rgba(6,182,212,0.25);
    }
    .btn-cyan:hover {
        box-shadow: 0 6px 20px rgba(6,182,212,0.35);
    }

    .btn-action-save {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .btn-action-save:hover {
        background: linear-gradient(135deg, #16a34a, #15803d);
        transform: translateY(-1px);
    }

    .btn-action-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .btn-action-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }

    .btn-action-yellow {
        background: linear-gradient(135deg, #eab308, #d97706);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .btn-action-yellow:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-1px);
    }

    .btn-action-cyan {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .btn-action-cyan:hover {
        background: linear-gradient(135deg, #0891b2, #155e75);
        transform: translateY(-1px);
    }

    .btn-action-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 12px 24px;
        border: 1.5px solid #e0e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .btn-action-cancel:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .form-group { margin-bottom: 18px; }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #6b7fa3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e0e8f0;
        border-radius: 10px;
        font-size: 15px;
        background: #f8fafc;
        color: #1a2744;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input::placeholder, .form-group select {
        color: #94a3b8;
    }

    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #4a90d9;
        box-shadow: 0 0 0 3px rgba(135,206,235,0.2);
        background: #fff;
    }
</style>
@endsection

<script>
function toggleForm(id) {
    var forms = ['form-tabung','form-ambil','form-pinjam','form-bayar'];
    forms.forEach(function(f) {
        var el = document.getElementById(f);
        el.style.display = (f === id && el.style.display === 'none') ? 'block' : 'none';
    });
    if (id === 'form-bayar') updateSisa(document.getElementById('select-pinjaman'));
}

function updateSisa(sel) {
    if (!sel) return;
    var opt = sel.options[sel.selectedIndex];
    var sisa = opt ? parseFloat(opt.dataset.sisa) : 0;
    var info = document.getElementById('info-sisa');
    var inp = document.getElementById('input-bayar');
    if (info) info.textContent = 'Sisa pinjaman: Rp ' + sisa.toLocaleString('id-ID');
    if (inp) inp.max = sisa;
}
</script>
@endsection