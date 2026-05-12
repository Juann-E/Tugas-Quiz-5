<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- TITLE -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">
            Register
        </h1>

        <!-- ERROR -->
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 text-sm">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}">

            @csrf

            <!-- Nama -->
            <div class="mb-5">

                <label class="block text-gray-800 font-semibold mb-2">
                    Nama Lengkap
                </label>

                <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- Username -->
            <div class="mb-5">

                <label class="block text-gray-800 font-semibold mb-2">
                    Username
                </label>

                <input type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- Password -->
            <div class="mb-5">

                <label class="block text-gray-800 font-semibold mb-2">
                    Password
                </label>

                <input type="password"
                    name="password"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- Konfirmasi -->
            <div class="mb-6">

                <label class="block text-gray-800 font-semibold mb-2">
                    Konfirmasi Password
                </label>

                <input type="password"
                    name="password_confirmation"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 transition duration-300 text-white font-bold py-3 rounded-xl text-lg shadow-md">

                Daftar

            </button>

            <!-- LOGIN -->
            <div class="text-center mt-6 text-gray-700">

                Sudah punya akun?

                <a href="{{ route('login') }}"
                    class="text-blue-600 font-semibold hover:underline">

                    Login di sini

                </a>

            </div>

        </form>

    </div>

</x-guest-layout>