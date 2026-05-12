@extends('layouts.app')

@section('title', 'Detail Pinjaman')
@section('page-title', 'Detail Pinjaman')
@section('page-subtitle', $pinjaman->kode_pinjaman)

@section('content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Info pinjaman --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Status banner --}}
        @php
            $bannerColor = [
                'menunggu'  => 'bg-yellow-50 border-yellow-200',
                'disetujui' => 'bg-blue-50 border-blue-200',
                'ditolak'   => 'bg-red-50 border-red-200',
                'lunas'     => 'bg-green-50 border-green-200',
            ][$pinjaman->status] ?? 'bg-gray-50 border-gray-200';
            $textColor = [
                'menunggu'  => 'text-yellow-800',
                'disetujui' => 'text-blue-800',
                'ditolak'   => 'text-red-800',
                'lunas'     => 'text-green-800',
            ][$pinjaman->status] ?? 'text-gray-800';
        @endphp
        <div class="border rounded-xl px-5 py-3 flex items-center gap-3 {{ $bannerColor }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ $textColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p class="{{ $textColor }} text-sm font-medium">
                Status Pinjaman: <strong>{{ ucfirst($pinjaman->status) }}</strong>
                @if($pinjaman->tanggal_disetujui)
                    · Disetujui {{ \Carbon\Carbon::parse($pinjaman->tanggal_disetujui)->format('d M Y') }}
                @endif
            </p>
        </div>

        {{-- Detail --}}
        <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6">
            <h3 class="font-serif text-gray-900 text-base mb-5">Informasi Pinjaman</h3>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div>
                    <dt class="text-gray-500">Kode Pinjaman</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $pinjaman->kode_pinjaman }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Tanggal Pengajuan</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Jumlah Pinjaman</dt>
                    <dd class="text-gray-800 font-semibold mt-0.5">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Bunga</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $pinjaman->bunga_persen }}% / bulan (flat)</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Tenor</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $pinjaman->tenor_bulan }} bulan</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Angsuran / Bulan</dt>
                    <dd class="text-gray-800 font-semibold mt-0.5">Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Total Bayar</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">Rp {{ number_format($pinjaman->total_bayar, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Tujuan Pinjaman</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $pinjaman->tujuan_pinjaman }}</dd>
                </div>
            </dl>
        </div>

        {{-- Riwayat bayar --}}
        <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-serif text-gray-900 text-base">Riwayat Pembayaran</h3>
                @if($pinjaman->status === 'disetujui' && $pinjaman->sisa_pinjaman > 0)
                <a href="{{ route('bayar-pinjaman.create', $pinjaman->id) }}"
                    class="flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Bayar Angsuran
                </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                            <th class="px-6 py-3 text-left font-medium">Ke-</th>
                            <th class="px-6 py-3 text-left font-medium">Tanggal</th>
                            <th class="px-6 py-3 text-left font-medium">Jumlah Bayar</th>
                            <th class="px-6 py-3 text-left font-medium">Sisa Setelah</th>
                            <th class="px-6 py-3 text-left font-medium">Metode</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pembayaran as $b)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3.5 text-gray-700 font-medium">Angsuran {{ $b->ke_angsuran }}</td>
                            <td class="px-6 py-3.5 text-gray-500">{{ \Carbon\Carbon::parse($b->tanggal_bayar)->format('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-green-700 font-semibold">Rp {{ number_format($b->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-3.5 text-amber-600">Rp {{ number_format($b->sisa_setelah_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-3.5 text-gray-500 capitalize">{{ $b->metode_bayar }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar kanan --}}
    <div class="space-y-4">
        {{-- Sisa pinjaman --}}
        <div class="bg-green-800 rounded-2xl p-5">
            <p class="text-green-300 text-xs uppercase tracking-widest font-medium mb-1">Sisa Pinjaman</p>
            <p class="font-serif text-white text-2xl">Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</p>
            @php $pct = $pinjaman->total_bayar > 0 ? (($pinjaman->total_bayar - $pinjaman->sisa_pinjaman) / $pinjaman->total_bayar * 100) : 0; @endphp
            <div class="mt-4 bg-green-700/50 rounded-full h-2">
                <div class="bg-green-300 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
            </div>
            <p class="text-green-400 text-xs mt-2">{{ number_format($pct, 0) }}% terbayar</p>
        </div>

        {{-- Angsuran berikutnya --}}
        @if($pinjaman->status === 'disetujui' && $pinjaman->sisa_pinjaman > 0)
        <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-5">
            <p class="text-gray-500 text-xs uppercase tracking-wide font-medium mb-1">Angsuran Ke-</p>
            <p class="font-serif text-gray-900 text-xl">{{ $pembayaran->count() + 1 }} dari {{ $pinjaman->tenor_bulan }}</p>
            <p class="text-gray-500 text-xs mt-3 mb-1">Jumlah</p>
            <p class="text-green-700 font-semibold">Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</p>
            <a href="{{ route('bayar-pinjaman.create', $pinjaman->id) }}"
                class="mt-4 w-full flex items-center justify-center bg-green-700 hover:bg-green-800 text-white text-sm font-medium py-2.5 rounded-xl transition-all">
                Bayar Sekarang
            </a>
        </div>
        @endif

        <a href="{{ route('pinjaman.index') }}"
            class="flex items-center justify-center gap-2 w-full border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium py-2.5 rounded-xl transition-all">
            ← Kembali ke daftar
        </a>
    </div>
</div>
@endsection