@extends('layouts.app')
@section('title', 'Dashboard')
@section('styles')
<style>
  .balance-card { background:linear-gradient(135deg,#1565C0,#0D47A1);
                  border-radius:10px; padding:28px; text-align:center;
                  color:#fff; margin-bottom:16px; }
  .balance-card .lbl { font-size:13px; opacity:.85; margin-bottom:8px; }
  .balance-card .amt { font-size:36px; font-weight:800; }
  .action-grid { display:grid; grid-template-columns:repeat(4,1fr);
                 gap:10px; margin-bottom:16px; }
  .action-btn { padding:12px; border:none; border-radius:8px; font-size:13px;
                font-weight:700; cursor:pointer; }
  .btn-green{background:#2E7D32;color:#fff;}
  .btn-red{background:#C62828;color:#fff;}
  .btn-yellow{background:#F9A825;color:#fff;}
  .btn-teal{background:#00838F;color:#fff;}
  .btn-gray{background:#546E7A;color:#fff;}
  .panel { background:#fff; border-radius:10px; box-shadow:0 2px 12px
           rgba(0,0,0,.1); padding:24px; margin-bottom:16px;
           display:none; }
  .panel.active { display:block; }
  .panel h3 { margin-bottom:16px; padding-bottom:12px;
              border-bottom:2px solid #ECEFF1; }
  .form-group { margin-bottom:16px; }
  .form-group label { display:block; font-size:13px; font-weight:600;
                      margin-bottom:6px; }
  .form-group input,.form-group select { width:100%; padding:10px 12px;
    border:1.5px solid #CFD8DC; border-radius:8px; font-size:14px; }
  .btn-full { width:100%; padding:12px; border:none; border-radius:8px;
              font-size:15px; font-weight:700; cursor:pointer;
              margin-bottom:8px; }
  .section-card { background:#fff; border-radius:10px; overflow:hidden;
                  box-shadow:0 2px 12px rgba(0,0,0,.1); margin-bottom:16px; }
  .section-hdr { padding:14px 20px; font-weight:700; background:#FAFAFA;
                 border-bottom:1px solid #E0E0E0; }
  table { width:100%; border-collapse:collapse; }
  th { padding:10px 16px; text-align:left; font-size:12px; font-weight:700;
       color:#546E7A; background:#FAFAFA; border-bottom:1px solid #E0E0E0; }
  td { padding:12px 16px; font-size:13px; border-bottom:1px solid #F5F5F5; }
  .badge-active { background:#FFF8E1; color:#F57F17; border:1px solid #FFE082;
                  padding:3px 10px; border-radius:20px; font-size:11px;
                  font-weight:700; }
  .info-box { background:#E3F2FD; color:#1565C0; padding:10px 14px;
              border-radius:8px; font-size:13px; margin-bottom:14px; }
</style>
@endsection
@section('content')
 
{{-- Balance Card --}}
<div class='balance-card'>
    <div class='lbl'>Saldo Anda</div>
    <div class='amt'>Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
</div>
 
{{-- Action Buttons --}}
<div class='action-grid'>
    <button class='action-btn btn-green' onclick="togglePanel('tabungPanel')">Tabung</button>
    <button class='action-btn btn-red'   onclick="togglePanel('ambilPanel')">Ambil</button>
    <button class='action-btn btn-yellow' onclick="togglePanel('pinjamPanel')">Pinjam</button>
    <button class='action-btn btn-teal'  onclick="togglePanel('bayarPanel')">Bayar Pinjaman</button>
</div>
 
{{-- Panel: Tabung --}}
<div class='panel' id='tabungPanel'>
    <h3>Tabung Uang</h3>
    <form method='POST' action='{{ route("tabung") }}'>
        @csrf
        <div class='form-group'>
            <label>Jumlah Tabungan (Rp)</label>
            <input type='number' name='jumlah' min='1000' required>
        </div>
        <button class='btn-full btn-green' type='submit'>Simpan Tabungan</button>
        <button class='btn-full btn-gray' type='button' onclick="closePanel('tabungPanel')">Batal</button>
    </form>
</div>
 
{{-- Panel: Ambil --}}
<div class='panel' id='ambilPanel'>
    <h3>Ambil Uang</h3>
    <p>Saldo saat ini: <strong>Rp {{ number_format($user->saldo,0,',','.') }}</strong></p>
    <br>
    @if($errors->has('ambil'))
        <div style='color:red;font-size:13px;margin-bottom:12px'>{{ $errors->first('ambil') }}</div>
    @endif
    <form method='POST' action='{{ route("ambil") }}'>
        @csrf
        <div class='form-group'>
            <label>Jumlah Penarikan (Rp)</label>
            <input type='number' name='jumlah' min='1000' required>
        </div>
        <button class='btn-full btn-red' type='submit'>Ambil Uang</button>
        <button class='btn-full btn-gray' type='button' onclick="closePanel('ambilPanel')">Batal</button>
    </form>
</div>
 
{{-- Panel: Pinjam --}}
<div class='panel' id='pinjamPanel'>
    <h3>Ajukan Pinjaman</h3>
    <div class='info-box'>Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</div>
    <form method='POST' action='{{ route("pinjam") }}'>
        @csrf
        <div class='form-group'>
            <label>Jumlah Pinjaman (Rp)</label>
            <input type='number' name='jumlah' min='1000' required>
        </div>
        <button class='btn-full btn-yellow' type='submit'>Ajukan Pinjaman</button>
        <button class='btn-full btn-gray' type='button' onclick="closePanel('pinjamPanel')">Batal</button>
    </form>
</div>
 
{{-- Panel: Bayar Pinjaman --}}
<div class='panel' id='bayarPanel'>
    <h3>Bayar Pinjaman</h3>
    <p>Saldo saat ini: <strong>Rp {{ number_format($user->saldo,0,',','.') }}</strong></p>
    <br>
    @if($errors->has('bayar'))
        <div style='color:red;font-size:13px;margin-bottom:12px'>{{ $errors->first('bayar') }}</div>
    @endif
    <form method='POST' action='{{ route("bayar") }}'>
        @csrf
        <div class='form-group'>
            <label>Pilih Pinjaman</label>
            <select name='loan_id' required>
                <option value=''>-- Pilih pinjaman --</option>
                @foreach($loans as $loan)
                <option value='{{ $loan->id }}'
                    {{ old('loan_id') == $loan->id ? 'selected' : '' }}>
                    Pinjaman {{ $loan->created_at->format('d/m/Y') }}
                    - Sisa: Rp {{ number_format($loan->sisa,0,',','.') }}
                </option>
                @endforeach
            </select>
        </div>
        <div class='form-group'>
            <label>Jumlah Pembayaran (Rp)</label>
            <input type='number' name='jumlah' min='1000' required>
        </div>
        <button class='btn-full btn-teal' type='submit'>Bayar Pinjaman</button>
        <button class='btn-full btn-gray' type='button' onclick="closePanel('bayarPanel')">Batal</button>
    </form>
</div>
 
{{-- Tabel Pinjaman Aktif --}}
<div class='section-card'>
    <div class='section-hdr'>Pinjaman Aktif</div>
    @if($loans->isEmpty())
        <p style='padding:20px;color:#78909C;font-style:italic'>Tidak ada pinjaman aktif.</p>
    @else
    <table>
        <thead><tr>
            <th>Tanggal</th><th>Total Pinjaman</th>
            <th>Sisa Pinjaman</th><th>Status</th>
        </tr></thead>
        <tbody>
        @foreach($loans as $loan)
        <tr>
            <td>{{ $loan->created_at->format('d M Y') }}</td>
            <td>Rp {{ number_format($loan->total,0,',','.') }}</td>
            <td>Rp {{ number_format($loan->sisa,0,',','.') }}</td>
            <td><span class='badge-active'>Active</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
 
{{-- Riwayat Transaksi --}}
<div class='section-card'>
    <div class='section-hdr'>Riwayat Transaksi</div>
    @if($history->isEmpty())
        <p style='padding:20px;color:#78909C;font-style:italic'>Belum ada transaksi.</p>
    @else
    <table>
        <thead><tr><th>Tanggal</th><th>Tipe</th><th>Jumlah</th></tr></thead>
        <tbody>
        @foreach($history as $trx)
        <tr>
            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
            <td>{{ ucfirst($trx->type) }}</td>
            <td style='color:{{ in_array($trx->type,["tabung","pinjam"]) ? "#2E7D32" : "#C62828" }};font-weight:700'>
                {{ in_array($trx->type,["tabung","pinjam"]) ? "+" : "-" }}
                Rp {{ number_format($trx->jumlah,0,',','.') }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
 
<script>
function togglePanel(id) {
    var panels = ['tabungPanel','ambilPanel','pinjamPanel','bayarPanel'];
    panels.forEach(function(p) {
        var el = document.getElementById(p);
        if (p === id) el.classList.toggle('active');
        else el.classList.remove('active');
    });
}
function closePanel(id) {
    document.getElementById(id).classList.remove('active');
}
@if($errors->has('ambil'))
    togglePanel('ambilPanel');
@endif
@if($errors->has('bayar'))
    togglePanel('bayarPanel');
@endif
</script>
@endsection
