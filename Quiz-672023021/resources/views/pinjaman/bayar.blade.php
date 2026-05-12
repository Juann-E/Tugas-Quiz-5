{{-- resources/views/pinjaman/bayar.blade.php --}}
@extends('layouts.koperasi')
@section('title', 'Bayar Pinjaman')
@section('content')

<div class="saldo-card">
    <div class="label">Saldo Anda</div>
    <div class="amount">Rp {{ number_format($user->saldo, 0, ',', '.') }}</div>
</div>

<div class="action-grid mb-4">
    <a href="{{ route('tabung.form') }}" class="btn btn-tabung text-center">Tabung</a>
    <a href="{{ route('ambil.form') }}"  class="btn btn-ambil text-center">Ambil</a>
    <a href="{{ route('pinjam.form') }}" class="btn btn-pinjam text-center">Pinjam</a>
    <a href="{{ route('bayar.form') }}"  class="btn btn-bayar text-center">Bayar Pinjaman</a>
</div>

<div class="card card-form">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1">Bayar Pinjaman</h5>
        <p class="text-muted mb-4">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form action="{{ route('bayar.post') }}" method="POST">
            @csrf
            {{-- Pilih pinjaman --}}
            <div class="mb-3">
                <label class="form-label">Pilih Pinjaman</label>
                <select name="pinjaman_id" class="form-select form-select-lg @error('pinjaman_id') is-invalid @enderror"
                    id="pinjamanSelect" required>
                    <option value="">-- Pilih Pinjaman --</option>
                    @foreach($pinjaman as $p)
                        <option value="{{ $p->id }}"
                            data-sisa="{{ $p->sisa_pinjaman }}"
                            {{ old('pinjaman_id') == $p->id ? 'selected' : '' }}>
                            Pinjaman {{ $p->tanggal_pinjam->format('d/m/Y') }}
                            - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('pinjaman_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Jumlah bayar --}}
            <div class="mb-3">
                <label class="form-label">Jumlah Pembayaran (Rp)</label>
                <input type="number" name="jumlah_bayar" id="jumlahBayar"
                    class="form-control form-control-lg @error('jumlah_bayar') is-invalid @enderror"
                    value="{{ old('jumlah_bayar') }}" min="1000" placeholder="0" required>
                <div class="form-text" id="sisaInfo"></div>
                @error('jumlah_bayar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-bayar w-100 mb-2">Bayar Pinjaman</button>
            <a href="{{ route('dashboard') }}" class="btn w-100" style="background:#607D8B;color:white;">Batal</a>
        </form>
    </div>
</div>

<script>
    // Otomatis isi max jumlah bayar sesuai sisa pinjaman yang dipilih
    document.getElementById('pinjamanSelect').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const sisa = selected.getAttribute('data-sisa');
        const input = document.getElementById('jumlahBayar');
        const info  = document.getElementById('sisaInfo');
        if (sisa) {
            input.max = sisa;
            input.value = sisa;
            info.textContent = 'Maksimal pembayaran: Rp ' + parseInt(sisa).toLocaleString('id-ID');
        } else {
            input.max = '';
            input.value = '';
            info.textContent = '';
        }
    });
</script>

@endsection
