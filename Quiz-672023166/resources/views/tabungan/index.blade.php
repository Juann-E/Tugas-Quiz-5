<x-app-layout>

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-6">

    <a href="/dashboard"
       class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-lg font-bold">

        ← Kembali ke Dashboard

    </a>

        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h1 class="text-4xl font-bold text-green-600 mb-8 text-center">
                MENU TABUNGAN
            </h1>

            <form method="POST" action="/tabungan" class="mb-10">

                @csrf

                <div class="flex gap-4">

                    <input type="number"
                           name="jumlah"
                           placeholder="Masukkan jumlah tabungan"
                           class="w-full rounded-2xl border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">

                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg">
                        TABUNG
                    </button>

                </div>

            </form>

            <div class="space-y-4">

                @foreach($tabungan as $t)

                <div class="bg-green-50 border-l-8 border-green-500 p-5 rounded-2xl shadow">

                    <h3 class="text-xl font-bold text-green-700">
                        {{ strtoupper($t->jenis) }}
                    </h3>

                    <p class="text-2xl font-semibold text-gray-700 mt-2">
                        Rp{{ number_format($t->jumlah,0,',','.') }}
                    </p>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

</x-app-layout>