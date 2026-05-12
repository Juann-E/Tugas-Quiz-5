@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan Anda')

@section('content')

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- Total Simpanan --}}
    <div class="bg-white rounded-2xl p-5 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Total Simpanan</p>
        <p class="font-serif text-gray-900 text-xl mt-1">
            Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}
        </p>
    </div>

    {{-- Saldo Tabungan --}}
    <div class="bg-white rounded-2xl p-5 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Saldo Tabungan</p>
        <p class="font-serif text-gray-900 text-xl mt-1">
            Rp {{ number_format($saldoTabungan ?? 0, 0, ',', '.') }}
        </p>
    </div>

    {{-- Total Pinjaman Aktif --}}
    <div class="bg-white rounded-2xl p-5 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">Sisa Pinjaman</p>
        <p class="font-serif text-gray-900 text-xl mt-1">
            Rp {{ number_format($sisaPinjaman ?? 0, 0, ',', '.') }}
        </p>
    </div>

    {{-- Angsuran Bulan Ini --}}
    <div class="bg-green-800 rounded-2xl p-5 card-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-700 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
            </div>
        </div>
        <p class="text-green-300 text-xs font-medium uppercase tracking-wide">Angsuran / Bulan</p>
        <p class="font-serif text-white text-xl mt-1">
            Rp {{ number_format($angsuranBulanIni ?? 0, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Bottom section: Pinjaman aktif + Riwayat simpanan --}}
<div class="grid lg:grid-cols-2 gap-6">

    {{-- Pinjaman Aktif --}}
    <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-serif text-gray-900 text-base">Pinjaman Aktif</h3>
            <a href="{{ route('pinjaman.index') }}" class="text-green-700 text-xs font-medium hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($pinjamanAktif ?? [] as $p)
            <div class="px-6 py-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-800 text-sm font-medium">{{ $p->kode_pinjaman }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $p->tujuan_pinjaman }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-amber-600 text-sm font-semibold">Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</p>
                        <p class="text-gray-400 text-xs">sisa pinjaman</p>
                    </div>
                </div>
                {{-- Progress bar --}}
                @php
                    $pct = $p->total_bayar > 0 ? (($p->total_bayar - $p->sisa_pinjaman) / $p->total_bayar * 100) : 0;
                @endphp
                <div class="mt-3 bg-gray-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                </div>
                <p class="text-gray-400 text-xs mt-1">{{ number_format($pct, 0) }}% terbayar</p>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <p class="text-gray-400 text-sm">Tidak ada pinjaman aktif</p>
                <a href="{{ route('pinjaman.create') }}" class="text-green-700 text-xs font-medium mt-1 inline-block hover:underline">Ajukan pinjaman →</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Riwayat Simpanan Terbaru --}}
    <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-serif text-gray-900 text-base">Simpanan Terbaru</h3>
            <a href="{{ route('simpanan.index') }}" class="text-green-700 text-xs font-medium hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($simpananTerbaru ?? [] as $s)
            <div class="px-6 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg
                        {{ $s->jenis_simpanan === 'pokok' ? 'bg-green-100' : ($s->jenis_simpanan === 'wajib' ? 'bg-blue-100' : 'bg-purple-100') }}
                        flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 {{ $s->jenis_simpanan === 'pokok' ? 'text-green-700' : ($s->jenis_simpanan === 'wajib' ? 'text-blue-700' : 'text-purple-700') }}"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800 text-sm font-medium capitalize">{{ $s->jenis_simpanan }}</p>
                        <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($s->tanggal_simpan)->format('d M Y') }}</p>
                    </div>
                </div>
                <p class="text-green-700 text-sm font-semibold">+Rp {{ number_format($s->jumlah, 0, ',', '.') }}</p>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <p class="text-gray-400 text-sm">Belum ada simpanan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection