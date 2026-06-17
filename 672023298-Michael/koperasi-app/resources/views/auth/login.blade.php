<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        <!-- TITLE -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">
            Login
        </h1>

        <!-- SESSION STATUS -->
        @if (session('status'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm">
            {{ session('status') }}
        </div>
        @endif

        <!-- ERROR -->
        @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-600 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}">

            @csrf

            <!-- USERNAME -->
            <div class="mb-5">

                <label class="block text-gray-800 font-semibold mb-2">
                    Username
                </label>

                <input type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- PASSWORD -->
            <div class="mb-6">

                <label class="block text-gray-800 font-semibold mb-2">
                    Password
                </label>

                <input type="password"
                    name="password"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 transition duration-300 text-white font-bold py-3 rounded-xl text-lg shadow-md">

                Login

            </button>

            <!-- REGISTER -->
            <div class="text-center mt-6 text-gray-700">

                Belum punya akun?

                <a href="{{ route('register') }}"
                    class="text-blue-600 font-semibold hover:underline">

                    Register sekarang

                </a>

            </div>

        </form>

    </div>

</x-guest-layout>