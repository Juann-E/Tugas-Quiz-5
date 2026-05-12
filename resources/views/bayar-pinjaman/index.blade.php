@extends('layouts.app')

@section('title', 'Pembayaran Pinjaman')
@section('page-title', 'Pembayaran Pinjaman')
@section('page-subtitle', 'Riwayat & pembayaran angsuran')

@section('content')
<div class="space-y-6">

    {{-- Pinjaman Aktif (bisa dibayar) --}}
    @if($pinjamanAktif->count() > 0)
    <div>
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Pinjaman Aktif</h2>
        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($pinjamanAktif as $p)
            @php
                $pct = $p->total_bayar > 0
                    ? (($p->total_bayar - $p->sisa_pinjaman) / $p->total_bayar * 100)
                    : 0;
                $angsuranKe = $p->pembayaran()->count() + 1;
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 card-shadow p-5 flex flex-col gap-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">{{ $p->kode_pinjaman }}</p>
                        <p class="font-serif text-gray-900 text-lg">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</p>
                    </div>
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                        Aktif
                    </span>
                </div>

                <div>
                    <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                        <span>Terbayar {{ number_format($pct, 0) }}%</span>
                        <span>Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-1.5 rounded-full transition-all"
                            style="width: {{ $pct }}%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400">Angsuran ke-{{ $angsuranKe }}</p>
                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($p->angsuran_per_bulan, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('bayar-pinjaman.create', $p->id) }}"
                        class="bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-[.97]">
                        Bayar
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-gray-100 card-shadow p-8 text-center">
        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Tidak ada pinjaman aktif yang perlu dibayar.</p>
    </div>
    @endif

    {{-- Riwayat Pembayaran --}}
    <div>
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Riwayat Pembayaran</h2>

        @if($pembayaran->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 card-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Kode</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Pinjaman</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Ke-</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Jumlah</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Metode</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pembayaran as $b)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs text-gray-500">{{ $b->kode_bayar }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-gray-800 font-medium">{{ $b->pinjaman->kode_pinjaman ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-gray-600">Angsuran {{ $b->ke_angsuran }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-gray-900 font-semibold">Rp {{ number_format($b->jumlah_bayar, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize
                                    {{ $b->metode_bayar === 'tunai' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $b->metode_bayar }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-500">
                                {{ \Carbon\Carbon::parse($b->tanggal_bayar)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('bayar-pinjaman.show', $b->id) }}"
                                    class="text-green-700 hover:text-green-800 text-xs font-medium">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($pembayaran->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $pembayaran->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl border border-gray-100 card-shadow p-8 text-center">
            <p class="text-gray-400 text-sm">Belum ada riwayat pembayaran.</p>
        </div>
        @endif
    </div>

</div>
@endsection