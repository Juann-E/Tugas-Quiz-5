@extends('layouts.app')

@section('title', 'Tambah Simpanan')
@section('page-title', 'Tambah Simpanan')
@section('page-subtitle', 'Catat simpanan baru')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-6">

        <form method="POST" action="{{ route('simpanan.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Jenis Simpanan</label>
                <select name="jenis_simpanan" required
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">— Pilih jenis simpanan —</option>
                    <option value="pokok"    {{ old('jenis_simpanan') === 'pokok'    ? 'selected' : '' }}>Simpanan Pokok</option>
                    <option value="wajib"    {{ old('jenis_simpanan') === 'wajib'    ? 'selected' : '' }}>Simpanan Wajib</option>
                    <option value="sukarela" {{ old('jenis_simpanan') === 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                </select>
                @error('jenis_simpanan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Jumlah (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1000" step="1000"
                        placeholder="0"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                               placeholder-gray-400 transition-all"
                        required>
                </div>
                @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Tanggal Simpan</label>
                <input type="date" name="tanggal_simpan" value="{{ old('tanggal_simpan', date('Y-m-d')) }}"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                    required>
                @error('tanggal_simpan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan..."
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                           placeholder-gray-400 transition-all resize-none">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('simpanan.index') }}"
                    class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl text-sm transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 bg-green-700 hover:bg-green-800 text-white font-medium py-3 rounded-xl text-sm transition-all shadow-sm hover:shadow-md active:scale-[.98]">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection