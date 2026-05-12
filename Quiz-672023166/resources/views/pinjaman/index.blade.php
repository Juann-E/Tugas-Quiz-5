<x-app-layout>

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-5xl mx-auto px-6">
        <div class="mb-6">

    <a href="/dashboard"
       class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-lg font-bold">

        ← Kembali ke Dashboard

    </a>

        </div>

        <!-- FORM PINJAMAN -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-10">

            <h1 class="text-4xl font-bold text-blue-600 text-center mb-8">
                AJUKAN PINJAMAN BARU
            </h1>

            <form method="POST" action="{{ url('/pinjaman') }}">

                @csrf

                <div class="flex gap-4">

                    <input type="number"
                           name="jumlah"
                           placeholder="Masukkan jumlah pinjaman"
                           class="w-full rounded-2xl border-gray-300 shadow-sm"
                           required>

                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-2xl font-bold">
                        PINJAM
                    </button>

                </div>

            </form>

        </div>

        <!-- DATA PINJAMAN -->
        <div class="space-y-6">

            @forelse($pinjaman as $p)

            <div class="bg-white rounded-3xl shadow-xl p-8 border-l-8 border-blue-500">

                <h2 class="text-2xl font-bold text-blue-700 mb-3">
                    Data Pinjaman
                </h2>

                <p class="text-xl text-gray-700 mb-2">
                    Total Pinjaman :
                    <span class="font-bold">
                        Rp{{ number_format($p->jumlah_pinjaman,0,',','.') }}
                    </span>
                </p>

                <p class="text-xl text-red-500 font-bold mb-6">
                    Sisa Pinjaman :
                    Rp{{ number_format($p->sisa_pinjaman,0,',','.') }}
                </p>

                <form method="POST"
                      action="{{ url('/bayar/'.$p->id) }}">

                    @csrf

                    <div class="flex gap-4">

                        <input type="number"
                               name="jumlah_bayar"
                               placeholder="Masukkan pembayaran"
                               class="w-full rounded-2xl border-gray-300 shadow-sm"
                               required>

                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-2xl font-bold">
                            BAYAR
                        </button>

                    </div>

                </form>

            </div>

            @empty

            <div class="bg-white rounded-3xl shadow p-8 text-center text-gray-500">
                Belum ada data pinjaman.
            </div>

            @endforelse

        </div>

    </div>

</div>

</x-app-layout>