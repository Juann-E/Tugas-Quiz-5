@extends('layouts.app')

@section('title', 'Bayar Pinjaman')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Bayar Pinjaman</h1>
        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">← Kembali</a>
    </div>
    
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-4 mb-6 text-white">
        <p class="text-sm opacity-90">Saldo Anda</p>
        <p class="text-3xl font-bold">Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
    </div>
    
    @if($pinjamanAktif->count() > 0)
        <h2 class="font-bold text-lg mb-3">Pilih pinjaman yang ingin dibayar:</h2>
        @foreach($pinjamanAktif as $pinjaman)
        <div class="border rounded-xl p-4 mb-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="text-gray-500 text-sm">{{ date('d M Y', strtotime($pinjaman->tanggal)) }}</p>
                    <p class="font-semibold">Total Pinjaman: Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</p>
                    <p class="text-orange-600 font-bold">Sisa: Rp {{ number_format($pinjaman->sisa, 0, ',', '.') }}</p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Aktif</span>
            </div>
            
            <form method="POST" action="{{ route('bayar') }}" class="mt-3">
                @csrf
                <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">
                <div class="flex gap-3 items-end">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm mb-1">Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah" class="w-full px-3 py-2 border rounded-lg" required min="1" max="{{ $pinjaman->sisa }}">
                    </div>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Bayar</button>
                </div>
            </form>
        </div>
        @endforeach
    @else
        <div class="text-center py-12 text-gray-500">
            <p class="text-lg">🎉 Anda tidak memiliki pinjaman aktif.</p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-indigo-600 hover:underline">Kembali ke Dashboard</a>
        </div>
    @endif
</div>
@endsection