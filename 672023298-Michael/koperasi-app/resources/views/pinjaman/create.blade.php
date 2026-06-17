<x-app-layout>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-4">
                Pinjam
            </h2>

            <div class="bg-white shadow rounded-lg p-6">

                <div class="bg-cyan-100 border border-cyan-300 text-cyan-900 p-4 rounded mb-6 text-lg">

                    Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.

                </div>

                <form method="POST" action="{{ route('pinjam.store') }}">

                    @csrf

                    <div>
                        <label class="block mb-2 text-lg">
                            Jumlah Pinjaman (Rp)
                        </label>

                        <input type="number"
                            name="jumlah"
                            class="w-full border rounded p-3"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-400 text-black py-3 rounded mt-6 text-lg font-bold">
                        Ajukan Pinjaman
                    </button>

                    <a href="/dashboard"
                        class="block text-center bg-gray-500 text-white py-3 rounded mt-4 text-lg">
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>