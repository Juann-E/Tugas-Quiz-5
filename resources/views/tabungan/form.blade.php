@extends('layouts.app')

@section('title', $jenis === 'setor' ? 'Setor Tabungan' : 'Tarik Tabungan')
@section('page-title', $jenis === 'setor' ? 'Setor Tabungan' : 'Tarik Tabungan')
@section('page-subtitle', $jenis === 'setor' ? 'Tambah saldo tabungan Anda' : 'Ambil saldo tabungan Anda')

@section('content')
<div class="max-w-lg">

    {{-- Saldo info --}}
    <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4 mb-6 flex items-center justify-between">
        <div>
            <p class="text-green-700 text-xs font-medium uppercase tracking-wide">Saldo Saat Ini</p>
            <p class="font-serif text-green-900 text-xl mt-0.5">Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</p>
        </div>
        <p class="text-green-600 text-sm">{{ $tabungan->no_rekening }}</p>
    </div>

    <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6">
        <form method="POST" action="{{ route('tabungan.' . $jenis . '.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">
                    Jumlah {{ ucfirst($jenis) }} (Rp)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1000" step="1000"
                        @if($jenis === 'tarik') max="{{ $tabungan->saldo }}" @endif
                        placeholder="0"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                               placeholder-gray-400 transition-all"
                        required>
                </div>
                @if($jenis === 'tarik')
                <p class="text-gray-400 text-xs mt-1">Maksimal penarikan: Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}</p>
                @endif
                @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                    required>
                @error('tanggal_transaksi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan..."
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                           placeholder-gray-400 transition-all resize-none">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('tabungan.index') }}"
                    class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl text-sm transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 font-medium py-3 rounded-xl text-sm transition-all shadow-sm hover:shadow-md active:scale-[.98] text-white
                        {{ $jenis === 'setor' ? 'bg-green-700 hover:bg-green-800' : 'bg-red-600 hover:bg-red-700' }}">
                    {{ $jenis === 'setor' ? 'Setor Sekarang' : 'Tarik Sekarang' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection