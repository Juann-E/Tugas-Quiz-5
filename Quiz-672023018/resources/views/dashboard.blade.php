@extends('layouts.master')
@section('title','Dashboard')
@section('content')
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Halo, {{ $user->nama_lengkap }}!</h5>
    <a href="{{ route('profile') }}" class="btn btn-primary">Profile</a>
  </div>

  @if(session('success'))
    <div class="alert alert-info alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card text-white mb-4 text-center py-4"
       id="saldo-card"
       style="transition: transform 0.3s ease;">
    <p class="mb-1 fw-bold">Saldo Anda</p>
    <h2 class="mb-0" id="saldo-display">Rp 0</h2>
  </div>

  <div class="row g-2 mb-4">
    <div class="col"><a href="{{ route('tabung') }}" class="btn btn-success w-100">Tabung</a></div>
    <div class="col"><a href="{{ route('ambil') }}" class="btn btn-danger w-100">Ambil</a></div>
    <div class="col"><a href="{{ route('pinjam') }}" class="btn btn-warning w-100">Pinjam</a></div>
    <div class="col"><a href="{{ route('bayar') }}" class="btn btn-info w-100">Bayar Pinjaman</a></div>
  </div>

  {{-- Pinjaman Aktif --}}
  <div class="card">
    <div class="card-header">Pinjaman Aktif</div>
    <div class="card-body p-0">
      @if($user->activeLoans->count() > 0)
        <table class="table mb-0">
          <thead><tr>
            <th>Tanggal</th>
            <th>Total Pinjaman</th>
            <th>Sisa Pinjaman</th>
            <th>Status</th>
          </tr></thead>
          <tbody>
          @foreach($user->activeLoans as $loan)
            <tr>
              <td>{{ $loan->created_at->format('d M Y') }}</td>
              <td>Rp {{ number_format($loan->total_pinjaman, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</td>
              <td><span class="badge bg-warning text-dark">Active</span></td>
            </tr>
          @endforeach
          </tbody>
        </table>
      @else
        <p class="text-center text-muted py-3 mb-0">Anda tidak memiliki pinjaman aktif.</p>
      @endif
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetSaldo = {{ $user->saldo }};
    const display    = document.getElementById('saldo-display');
    const card       = document.getElementById('saldo-card');
    const duration   = 1500;
    const startTime  = performance.now();
    const startValue = 0;

    function formatRupiah(angka) {
        return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
    }

    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }

    function animate(currentTime) {
        const elapsed  = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased    = easeOutQuart(progress);
        const current  = startValue + (targetSaldo - startValue) * eased;

        display.textContent = formatRupiah(current);

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            display.textContent = formatRupiah(targetSaldo);
        }
    }

    card.style.opacity    = '0';
    card.style.transform  = 'translateY(20px)';
    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

    setTimeout(function() {
        card.style.opacity   = '1';
        card.style.transform = 'translateY(0)';
        requestAnimationFrame(animate);

        if (targetSaldo === 0) {
            card.style.background = '#C2C2C2';
        } else if (targetSaldo < 100000) {
            card.style.background = '#dc3545';
        } else if (targetSaldo < 1000000) {
            card.style.background = '#fd7e14';
        } else {
            card.style.background = '#29FF4C';
        }
    }, 200);
});
</script>
@endsection
