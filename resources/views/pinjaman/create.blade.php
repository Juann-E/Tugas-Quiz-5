@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')
@section('page-subtitle', 'Isi formulir pengajuan pinjaman')

@section('content')
<div class="grid lg:grid-cols-5 gap-6">

    {{-- Form (kiri) --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6">
            <form method="POST" action="{{ route('pinjaman.store') }}" class="space-y-5" id="pinjamanForm">
                @csrf

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Jumlah Pinjaman (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                        <input type="number" name="jumlah_pinjaman" id="jumlahPinjaman"
                            value="{{ old('jumlah_pinjaman') }}" min="100000" step="100000"
                            placeholder="0"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-800
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                   placeholder-gray-400 transition-all"
                            required oninput="hitung()">
                    </div>
                    @error('jumlah_pinjaman') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Tenor (bulan)</label>
                    <select name="tenor_bulan" id="tenorBulan" required onchange="hitung()"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <option value="">— Pilih tenor —</option>
                        @foreach([3, 6, 12, 18, 24, 36] as $t)
                        <option value="{{ $t }}" {{ old('tenor_bulan') == $t ? 'selected' : '' }}>{{ $t }} bulan</option>
                        @endforeach
                    </select>
                    @error('tenor_bulan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Tujuan Pinjaman</label>
                    <textarea name="tujuan_pinjaman" rows="3"
                        placeholder="Contoh: Modal usaha, renovasi rumah, biaya pendidikan..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                               placeholder-gray-400 transition-all resize-none"
                        required>{{ old('tujuan_pinjaman') }}</textarea>
                    @error('tujuan_pinjaman') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        required>
                    @error('tanggal_pengajuan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('pinjaman.index') }}"
                        class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 bg-green-700 hover:bg-green-800 text-white font-medium py-3 rounded-xl text-sm transition-all shadow-sm hover:shadow-md active:scale-[.98]">
                        Ajukan Pinjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Simulasi (kanan) --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6 sticky top-24">
            <h3 class="font-serif text-gray-900 text-base mb-4">Simulasi Angsuran</h3>
            <p class="text-gray-500 text-xs mb-5">Bunga flat 1.5% per bulan</p>

            <div id="simulasiKosong" class="text-center py-6">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 7V4h16v3M4 20h16V7H4v13z"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-sm">Isi jumlah dan tenor<br>untuk melihat simulasi</p>
            </div>

            <div id="simulasiHasil" class="hidden space-y-3">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500 text-sm">Pokok Pinjaman</span>
                    <span class="text-gray-800 font-medium text-sm" id="resPokok">—</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500 text-sm">Total Bunga</span>
                    <span class="text-gray-800 font-medium text-sm" id="resBunga">—</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-500 text-sm">Total Bayar</span>
                    <span class="text-gray-800 font-semibold text-sm" id="resTotalBayar">—</span>
                </div>
                <div class="bg-green-50 rounded-xl p-4 mt-2">
                    <p class="text-green-700 text-xs font-medium uppercase tracking-wide mb-1">Angsuran per Bulan</p>
                    <p class="font-serif text-green-900 text-2xl" id="resAngsuran">—</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fmt(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}
function hitung() {
    const pokok  = parseFloat(document.getElementById('jumlahPinjaman').value) || 0;
    const tenor  = parseFloat(document.getElementById('tenorBulan').value) || 0;
    const bunga  = 0.015;

    if (pokok < 1 || tenor < 1) {
        document.getElementById('simulasiKosong').classList.remove('hidden');
        document.getElementById('simulasiHasil').classList.add('hidden');
        return;
    }

    const totalBunga  = pokok * bunga * tenor;
    const totalBayar  = pokok + totalBunga;
    const angsuran    = totalBayar / tenor;

    document.getElementById('resPokok').textContent     = fmt(pokok);
    document.getElementById('resBunga').textContent     = fmt(totalBunga);
    document.getElementById('resTotalBayar').textContent = fmt(totalBayar);
    document.getElementById('resAngsuran').textContent  = fmt(angsuran);

    document.getElementById('simulasiKosong').classList.add('hidden');
    document.getElementById('simulasiHasil').classList.remove('hidden');
}
</script>
@endpush