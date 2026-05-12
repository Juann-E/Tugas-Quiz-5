@extends('layouts.app')

@section('title', 'Pinjaman')
@section('page-title', 'Pinjaman')
@section('page-subtitle', 'Riwayat pengajuan pinjaman Anda')

@section('content')

<div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="font-serif text-gray-900 text-base">Daftar Pinjaman</h3>
        <a href="{{ route('pinjaman.create') }}"
            class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Ajukan Pinjaman
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left font-medium">Kode</th>
                    <th class="px-6 py-3 text-left font-medium">Jumlah Pinjaman</th>
                    <th class="px-6 py-3 text-left font-medium">Tenor</th>
                    <th class="px-6 py-3 text-left font-medium">Angsuran/Bln</th>
                    <th class="px-6 py-3 text-left font-medium">Sisa</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pinjaman as $p)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-3.5 font-medium text-gray-800">{{ $p->kode_pinjaman }}</td>
                    <td class="px-6 py-3.5 text-gray-700">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $p->tenor_bulan }} bln</td>
                    <td class="px-6 py-3.5 text-gray-700">Rp {{ number_format($p->angsuran_per_bulan, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5 font-semibold
                        {{ $p->sisa_pinjaman > 0 ? 'text-amber-600' : 'text-green-600' }}">
                        Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3.5">
                        @php
                            $badge = [
                                'menunggu'  => 'bg-yellow-100 text-yellow-800',
                                'disetujui' => 'bg-blue-100 text-blue-800',
                                'ditolak'   => 'bg-red-100 text-red-800',
                                'lunas'     => 'bg-green-100 text-green-800',
                            ][$p->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <a href="{{ route('pinjaman.show', $p->id) }}"
                            class="text-green-700 hover:underline text-xs font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        Belum ada pinjaman. <a href="{{ route('pinjaman.create') }}" class="text-green-700 hover:underline">Ajukan sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pinjaman->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $pinjaman->links() }}</div>
    @endif
</div>
@endsection