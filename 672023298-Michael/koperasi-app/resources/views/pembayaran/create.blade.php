<x-app-layout>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-4">
                Bayar Pinjaman
            </h2>

            <div class="bg-white shadow rounded-lg p-6">

                @if(session('error'))

                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">

                    {{ session('error') }}

                </div>

                @endif

                <p class="text-xl mb-6">

                    Saldo saat ini:
                    <strong>
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </strong>

                </p>

                <form method="POST" action="{{ route('bayar.store') }}">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2 text-lg">
                            Pilih Pinjaman
                        </label>

                        <select name="pinjaman_id"
                            class="w-full border rounded p-3"
                            required>

                            @foreach($pinjaman as $item)

                            <option value="{{ $item->id }}">

                                Pinjaman
                                {{ $item->created_at->format('d/m/Y') }}
                                -
                                Sisa:
                                Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2 text-lg">
                            Jumlah Pembayaran (Rp)
                        </label>

                        <input type="number"
                            name="jumlah"
                            class="w-full border rounded p-3"
                            required>

                    </div>

                    <button type="submit"
                        class="w-full bg-cyan-400 text-white py-3 rounded mt-6 text-lg">

                        Bayar Pinjaman

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