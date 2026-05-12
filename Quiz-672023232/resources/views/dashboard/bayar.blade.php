@extends('layouts.app')
@section('title', 'Bayar Pinjaman — SimpanPinjam')

@section('content')
<div class="page-wrapper">

    <a href="{{ route('dashboard') }}" class="back-link">Kembali ke Dashboard</a>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="inner-card">
        <div class="inner-card-title">✅ Bayar Pinjaman</div>
        <p class="inner-card-subtitle">
            Lunasi pinjaman aktif Anda. Pembayaran akan langsung memperbarui sisa tagihan.
        </p>

        <div class="saldo-info-bar">
            <span class="saldo-info-label">Saldo Tersedia</span>
            <span class="saldo-info-value">Rp {{ number_format($user->saldo, 0, ',', '.') }}</span>
        </div>

        @if($pinjamanAktif->isEmpty())
            <div class="info-box">
                🎉 Selamat! Anda tidak memiliki pinjaman aktif saat ini.
            </div>
        @else
            <form method="POST" action="{{ route('bayar.post') }}">
                @csrf
                <div class="form-group">
                    <label for="pinjaman_id">Pilih Pinjaman</label>
                    <select id="pinjaman_id" name="pinjaman_id" required>
                        @foreach($pinjamanAktif as $p)
                            <option value="{{ $p->id }}" {{ old('pinjaman_id') == $p->id ? 'selected' : '' }}>
                                Pinjaman {{ $p->created_at->format('d/m/Y') }} — Sisa: Rp {{ number_format($p->sisa, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah Pembayaran (Rp)</label>
                    <input
                        type="number"
                        id="jumlah"
                        name="jumlah"
                        value="{{ old('jumlah') }}"
                        placeholder="Masukkan nominal pembayaran"
                        min="1"
                        max="{{ $user->saldo }}"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-cyan">
                    Bayar Sekarang
                </button>
            </form>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-gray">
            Batal
        </a>
    </div>

</div>
@endsection
