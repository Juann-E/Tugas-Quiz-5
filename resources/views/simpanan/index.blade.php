@extends('layouts.app')

@section('title', 'Simpanan')
@section('page-title', 'Simpanan')
@section('page-subtitle', 'Riwayat simpanan Anda')

@section('content')

{{-- Summary cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @foreach([['label'=>'Simpanan Pokok','key'=>'pokok','color'=>'green'],['label'=>'Simpanan Wajib','key'=>'wajib','color'=>'blue'],['label'=>'Simpanan Sukarela','key'=>'sukarela','color'=>'purple']] as $item)
    <div class="bg-white rounded-2xl p-4 card-shadow border border-gray-100">
        <p class="text-gray-500 text-xs uppercase tracking-wide font-medium mb-1">{{ $item['label'] }}</p>
        <p class="font-serif text-gray-900 text-lg">
            Rp {{ number_format($totalPerJenis[$item['key']] ?? 0, 0, ',', '.') }}
        </p>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="font-serif text-gray-900 text-base">Daftar Simpanan</h3>
        <a href="{{ route('simpanan.create') }}"
            class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Simpanan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left font-medium">Kode</th>
                    <th class="px-6 py-3 text-left font-medium">Jenis</th>
                    <th class="px-6 py-3 text-left font-medium">Jumlah</th>
                    <th class="px-6 py-3 text-left font-medium">Tanggal</th>
                    <th class="px-6 py-3 text-left font-medium">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($simpanan as $s)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-3.5 font-medium text-gray-800">{{ $s->kode_simpanan }}</td>
                    <td class="px-6 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $s->jenis_simpanan === 'pokok' ? 'bg-green-100 text-green-800' :
                               ($s->jenis_simpanan === 'wajib' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ ucfirst($s->jenis_simpanan) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-green-700 font-semibold">Rp {{ number_format($s->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5 text-gray-500">{{ \Carbon\Carbon::parse($s->tanggal_simpan)->format('d M Y') }}</td>
                    <td class="px-6 py-3.5 text-gray-400">{{ $s->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        Belum ada simpanan. <a href="{{ route('simpanan.create') }}" class="text-green-700 hover:underline">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($simpanan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $simpanan->links() }}
    </div>
    @endif
</div>

@endsection