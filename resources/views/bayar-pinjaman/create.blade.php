@extends('layouts.app')

@section('title', 'Bayar Angsuran')
@section('page-title', 'Bayar Angsuran')
@section('page-subtitle', 'Pembayaran angsuran ke-' . $keAngsuran)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="grid lg:grid-cols-5 gap-6">

        {{-- Form Pembayaran --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6">
                <h3 class="font-serif text-gray-900 text-base mb-5">Form Pembayaran</h3>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                    @foreach($errors->all() as $error)
                        <p class="text-red-600 text-sm">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('bayar-pinjaman.store') }}" class="space-y-5">
                    @csrf

                    {{-- Hidden pinjaman_id --}}
                    <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">

                    {{-- Jumlah Bayar --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1.5">
                            Jumlah Pembayaran (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                            <input type="number"
                                name="jumlah_bayar"
                                id="jumlahBayar"
                                value="{{ old('jumlah_bayar', $jumlahBayar) }}"
                                min="1"
                                max="{{ $pinjaman->sisa_pinjaman }}"
                                step="1000"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-800
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                       transition-all"
                                required
                                oninput="updateSisa()">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Angsuran normal: <strong>Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</strong> &nbsp;|&nbsp;
                            Maks: <strong>Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</strong>
                        </p>
                        @error('jumlah_bayar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Metode Bayar --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="metode_bayar" value="tunai"
                                    class="peer sr-only"
                                    {{ old('metode_bayar', 'tunai') === 'tunai' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3
                                            peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Tunai</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="metode_bayar" value="transfer"
                                    class="peer sr-only"
                                    {{ old('metode_bayar') === 'transfer' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3
                                            peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Transfer</span>
                                </div>
                            </label>
                        </div>
                        @error('metode_bayar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1.5">
                            Keterangan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="2"
                            placeholder="Catatan tambahan..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                   placeholder-gray-400 transition-all resize-none">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('bayar-pinjaman.index') }}"
                            class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl text-sm transition-all">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-green-700 hover:bg-green-800 text-white font-medium py-3 rounded-xl text-sm transition-all shadow-sm hover:shadow-md active:scale-[.98]">
                            Konfirmasi Bayar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar Info Pinjaman --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Detail Pinjaman --}}
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-5 sticky top-24">
                <h3 class="font-serif text-gray-900 text-base mb-4">Detail Pinjaman</h3>

                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Kode</dt>
                        <dd class="font-mono text-gray-700 font-medium">{{ $pinjaman->kode_pinjaman }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Pokok Pinjaman</dt>
                        <dd class="text-gray-800 font-medium">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tenor</dt>
                        <dd class="text-gray-800 font-medium">{{ $pinjaman->tenor_bulan }} bulan</dd>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-gray-100">
                        <dt class="text-gray-500">Angsuran Normal</dt>
                        <dd class="text-gray-800 font-medium">Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</dd>
                    </div>

                    {{-- Progress --}}
                    @php
                        $pct = $pinjaman->total_bayar > 0
                            ? (($pinjaman->total_bayar - $pinjaman->sisa_pinjaman) / $pinjaman->total_bayar * 100)
                            : 0;
                    @endphp
                    <div class="pt-1">
                        <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                            <span>Progress pelunasan</span>
                            <span class="text-green-600 font-semibold">{{ number_format($pct, 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-2 rounded-full"
                                style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    {{-- Sisa setelah bayar (dinamis) --}}
                    <div class="bg-amber-50 rounded-xl p-4 mt-2">
                        <p class="text-amber-600 text-xs font-medium uppercase tracking-wide mb-1">Sisa Sekarang</p>
                        <p class="font-serif text-amber-900 text-xl">Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-green-50 rounded-xl p-4" id="sisaPreview">
                        <p class="text-green-600 text-xs font-medium uppercase tracking-wide mb-1">Sisa Setelah Bayar</p>
                        <p class="font-serif text-green-900 text-xl" id="sisaSetelahBayar">
                            Rp {{ number_format($pinjaman->sisa_pinjaman - $jumlahBayar, 0, ',', '.') }}
                        </p>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const sisaPinjaman = {{ $pinjaman->sisa_pinjaman }};

function fmt(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function updateSisa() {
    const bayar = parseFloat(document.getElementById('jumlahBayar').value) || 0;
    const sisa  = Math.max(0, sisaPinjaman - bayar);
    document.getElementById('sisaSetelahBayar').textContent = fmt(sisa);
}
</script>
@endpush