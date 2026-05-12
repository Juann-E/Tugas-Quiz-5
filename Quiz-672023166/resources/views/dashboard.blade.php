<x-app-layout>

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-6xl mx-auto px-6">

            <h1 class="text-4xl font-bold text-center text-blue-700 mb-10">
                DASHBOARD SIMPAN PINJAM
            </h1>

            <div class="grid md:grid-cols-2 gap-8">

                <a href="{{ url('/tabungan') }}"
                   class="bg-white rounded-3xl shadow-lg p-10 hover:scale-105 transition duration-300 border-l-8 border-green-500 block">

                    <h2 class="text-3xl font-bold text-green-600 mb-4">
                        MENU TABUNGAN
                    </h2>

                    <p class="text-gray-600 text-lg">
                        Klik untuk membuka halaman tabungan.
                    </p>

                </a>

                <a href="{{ url('/pinjaman') }}"
                   class="bg-white rounded-3xl shadow-lg p-10 hover:scale-105 transition duration-300 border-l-8 border-blue-500 block">

                    <h2 class="text-3xl font-bold text-blue-600 mb-4">
                        MENU PINJAMAN
                    </h2>

                    <p class="text-gray-600 text-lg">
                        Klik untuk membuka halaman pinjaman.
                    </p>

                </a>

            </div>

        </div>

    </div>

</x-app-layout>