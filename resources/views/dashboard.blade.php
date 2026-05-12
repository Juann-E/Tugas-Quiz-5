@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
        </form>
    </div>
    
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 mb-6 text-white">
        <p class="text-sm opacity-90">Saldo Anda</p>
        <p class="text-4xl font-bold">Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <button onclick="openModal('tabungModal')" class="bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">Tabung</button>
        <button onclick="openModal('ambilModal')" class="bg-yellow-500 text-white py-3 rounded-xl font-semibold hover:bg-yellow-600 transition">Ambil</button>
        <button onclick="openModal('pinjamModal')" class="bg-blue-500 text-white py-3 rounded-xl font-semibold hover:bg-blue-600 transition">Pinjam</button>
        <a href="{{ route('bayar') }}" class="bg-purple-500 text-white py-3 rounded-xl font-semibold hover:bg-purple-600 transition text-center">Bayar Pinjaman</a>
    </div>
    
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pinjaman Aktif</h2>
        @if($user->pinjamanAktif->count() > 0)
            @foreach($user->pinjamanAktif as $pinjaman)
            <div class="border rounded-xl p-4 mb-3 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal: {{ date('d M Y', strtotime($pinjaman->tanggal)) }}</p>
                        <p class="font-semibold">Total Pinjaman: Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</p>
                        <p class="text-orange-600">Sisa: Rp {{ number_format($pinjaman->sisa, 0, ',', '.') }}</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-8 text-gray-500">Anda tidak memiliki pinjaman aktif.</div>
        @endif
    </div>
</div>

{{-- Modal Tabung --}}
<div id="tabungModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Tabung Uang</h2>
        <form method="POST" action="{{ route('tabung') }}">
            @csrf
            <label class="block text-gray-700 mb-2">Jumlah Tabungan (Rp)</label>
            <input type="number" name="jumlah" class="w-full px-4 py-2 border rounded-lg mb-4" required>
            <div class="flex gap-3">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex-1">Simpan Tabungan</button>
                <button type="button" onclick="closeModal('tabungModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ambil --}}
<div id="ambilModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Ambil Uang</h2>
        <p class="text-gray-600 mb-3">Saldo saat ini: <strong>Rp {{ number_format($user->saldo, 0, ',', '.') }}</strong></p>
        <form method="POST" action="{{ route('ambil') }}">
            @csrf
            <label class="block text-gray-700 mb-2">Jumlah Penarikan (Rp)</label>
            <input type="number" name="jumlah" class="w-full px-4 py-2 border rounded-lg mb-4" required>
            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg flex-1">Ambil Uang</button>
                <button type="button" onclick="closeModal('ambilModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Pinjam --}}
<div id="pinjamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Ajukan Pinjaman</h2>
        <p class="text-gray-500 text-sm mb-3">Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</p>
        <form method="POST" action="{{ route('pinjam') }}">
            @csrf
            <label class="block text-gray-700 mb-2">Jumlah Pinjaman (Rp)</label>
            <input type="number" name="jumlah" class="w-full px-4 py-2 border rounded-lg mb-4" required min="1000">
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex-1">Ajukan Pinjaman</button>
                <button type="button" onclick="closeModal('pinjamModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('flex');
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
}
</script>
@endsection