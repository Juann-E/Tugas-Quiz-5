<x-app-layout>

    @php

    $masuk = \App\Models\Tabungan::where('user_id', auth()->id())
    ->sum('jumlah');

    $keluar = \App\Models\Penarikan::where('user_id', auth()->id())
    ->sum('jumlah');

    $pinjaman = \App\Models\Pinjaman::where('user_id', auth()->id())
    ->sum('jumlah');

    $saldo = $masuk + $pinjaman - $keluar;

    $pinjamanAktif = \App\Models\Pinjaman::where('user_id', auth()->id())
    ->get();

    @endphp

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Judul -->
            <h2 class="text-2xl font-semibold mb-4">
                Dashboard
            </h2>

            <!-- Alert -->
            @if(session('success'))

            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">

                {{ session('success') }}

            </div>

            @endif

            <!-- Card Saldo -->
            <div class="bg-blue-600 rounded-lg shadow p-6 text-center text-white mb-6">

                <h3 class="text-3xl font-bold">
                    Saldo Anda
                </h3>

                <p class="text-5xl mt-4">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </p>

            </div>

            <!-- Menu -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <!-- Tabung -->
                <a href="{{ route('tabung.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-center py-6 rounded-lg shadow font-bold">

                    Tabung

                </a>

                <!-- Ambil -->
                <a href="{{ route('ambil.create') }}"
                    class="bg-red-500 hover:bg-red-600 text-white text-center py-6 rounded-lg shadow font-bold">

                    Ambil

                </a>

                <!-- Pinjam -->
                <a href="{{ route('pinjam.create') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-black text-center py-6 rounded-lg shadow font-bold">

                    Pinjam

                </a>

                <!-- Bayar -->
                <a href="{{ route('bayar.create') }}"
                    class="bg-cyan-400 hover:bg-cyan-500 text-white text-center py-6 rounded-lg shadow font-bold">

                    Bayar Pinjaman

                </a>

            </div>

            <!-- Tabel Pinjaman -->
            <div class="bg-white rounded-lg shadow overflow-hidden">

                <div class="p-4 border-b">

                    <h3 class="text-lg font-semibold">
                        Pinjaman Aktif
                    </h3>

                </div>

                @if($pinjamanAktif->count() > 0)

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="text-left px-6 py-3">
                                Tanggal
                            </th>

                            <th class="text-left px-6 py-3">
                                Total Pinjaman
                            </th>

                            <th class="text-left px-6 py-3">
                                Sisa Pinjaman
                            </th>

                            <th class="text-left px-6 py-3">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($pinjamanAktif as $item)

                        <tr class="border-t">

                            <td class="px-6 py-4">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">

                                @if($item->status == 'Lunas')

                                <span class="bg-green-500 text-white px-3 py-1 rounded text-sm font-bold">

                                    Lunas

                                </span>

                                @else

                                <span class="bg-yellow-400 text-black px-3 py-1 rounded text-sm font-bold">

                                    Active

                                </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                <div class="p-10 text-center text-gray-500">

                    Anda tidak memiliki pinjaman aktif.

                </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>