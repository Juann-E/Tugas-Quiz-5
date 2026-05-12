@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', $pembayaran->kode_bayar)

@section('content')

<div class="max-w-3xl mx-auto">
    {{-- Success Message --}}
    <div class="bg-green-50 border border-green-200 rounded-2xl px-6 py-5 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-serif text-green-900 text-lg mb-1">Pembayaran Berhasil</p>
                <p class="text-green-700 text-sm">Terima kasih atas pembayaran Anda. Bukti pembayaran telah tersimpan.</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Receipt Card --}}
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-8">
                <div class="text-center mb-8 pb-8 border-b border-gray-100">
                    <p class="text-gray-500 text-sm mb-2">Bukti Pembayaran</p>
                    <p class="font-serif text-gray-900 text-3xl">{{ $pembayaran->kode_bayar }}</p>
                </div>

                {{-- Receipt Details --}}
                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500 font-medium">Pinjaman</dt>
                        <dd class="text-gray-800 font-medium">{{ $pembayaran->pinjaman->kode_pinjaman }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 font-medium">Angsuran Ke-</dt>
                        <dd class="text-gray-800 font-medium">{{ $pembayaran->ke_angsuran }} dari {{ $pembayaran->pinjaman->tenor_bulan }}</dd>
                    </div>
                    <div class="flex justify-between pb-4 border-b border-gray-100">
                        <dt class="text-gray-500 font-medium">Tanggal Pembayaran</dt>
                        <dd class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</dd>
                    </div>

                    <div class="flex justify-between py-4 border-y border-gray-100">
                        <dt class="text-gray-500 font-medium">Pokok Bayar</dt>
                        <dd class="text-gray-800 font-medium">Rp {{ number_format($pembayaran->pokok_bayar, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 font-medium">Bunga Bayar</dt>
                        <dd class="text-gray-800 font-medium">Rp {{ number_format($pembayaran->bunga_bayar, 0, ',', '.') }}</dd>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-gray-100 bg-green-50 px-4 py-3 rounded-lg">
                        <dt class="text-green-700 font-bold">TOTAL PEMBAYARAN</dt>
                        <dd class="text-green-700 font-bold text-lg">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</dd>
                    </div>

                    <div class="flex justify-between pt-4">
                        <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                        <dd class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full capitalize">
                            {{ $pembayaran->metode_bayar }}
                        </dd>
                    </div>

                    @if($pembayaran->keterangan)
                    <div class="pt-4 border-t border-gray-100">
                        <dt class="text-gray-500 font-medium mb-2">Keterangan</dt>
                        <dd class="text-gray-700 bg-gray-50 px-4 py-3 rounded-lg text-sm">{{ $pembayaran->keterangan }}</dd>
                    </div>
                    @endif
                </dl>

                {{-- Actions --}}
                <div class="flex gap-3 pt-8 border-t border-gray-100 mt-8">
                    <a href="{{ route('bayar-pinjaman.index') }}"
                        class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl transition-all">
                        Kembali
                    </a>
                    <a href="{{ route('pinjaman.show', $pembayaran->pinjaman_id) }}"
                        class="flex-1 bg-green-700 hover:bg-green-800 text-white font-medium py-3 rounded-xl transition-all">
                        Lihat Pinjaman
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-4">
            {{-- Status Pinjaman --}}
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-5">
                <h3 class="font-serif text-gray-900 text-base mb-4">Status Pinjaman</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Sisa Pinjaman</p>
                        <p class="font-serif text-amber-600 text-lg">Rp {{ number_format($pembayaran->sisa_setelah_bayar, 0, ',', '.') }}</p>
                    </div>

                    @php
                        $pct = $pembayaran->pinjaman->total_bayar > 0 
                            ? (($pembayaran->pinjaman->total_bayar - $pembayaran->sisa_setelah_bayar) / $pembayaran->pinjaman->total_bayar * 100) 
                            : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-gray-500 text-xs">Progress</p>
                            <p class="text-green-600 text-xs font-semibold">{{ number_format($pct, 0) }}%</p>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    @if($pembayaran->sisa_setelah_bayar <= 0)
                    <div class="bg-green-100 border border-green-300 rounded-lg px-3 py-2 text-center">
                        <p class="text-green-700 text-xs font-semibold uppercase">✓ Lunas</p>
                    </div>
                    @else
                    <div class="bg-blue-50 rounded-lg px-3 py-2">
                        <p class="text-blue-600 text-xs mb-1">Angsuran Berikutnya</p>
                        <p class="font-semibold text-blue-900">Rp {{ number_format($pembayaran->pinjaman->angsuran_per_bulan, 0, ',', '.') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Print/Download --}}
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-5">
                <a href="javascript:window.print()" class="w-full flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 rounded-lg transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H9a2 2 0 00-2 2v2a2 2 0 002 2h6a2 2 0 002-2v-2a2 2 0 00-2-2zm-6-4h.01M9 16h.01"/>
                    </svg>
                    Cetak
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
