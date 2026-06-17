<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- HEADER -->
            <div class="mb-8">

                <h1 class="text-4xl font-extrabold text-gray-800">
                    Profile
                </h1>

                <p class="text-gray-500 mt-2 text-lg">
                    Kelola akun dan keamanan profile Anda
                </p>

            </div>

            <!-- PROFILE INFORMATION -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">

                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Profile Information
                </h2>

                <p class="text-gray-500 mb-6">
                    Update informasi akun Anda.
                </p>

                <form method="post"
                    action="{{ route('profile.update') }}"
                    class="space-y-6">

                    @csrf
                    @method('patch')

                    <!-- NAME -->
                    <div>

                        <label class="block text-gray-700 font-semibold mb-2">
                            Name
                        </label>

                        <input type="text"
                            name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <!-- EMAIL -->
                    <div>

                        <label class="block text-gray-700 font-semibold mb-2">
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white font-bold px-6 py-3 rounded-xl shadow">

                        Save

                    </button>

                </form>

            </div>

            <!-- UPDATE PASSWORD -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">

                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Update Password
                </h2>

                <p class="text-gray-500 mb-6">
                    Gunakan password yang kuat agar akun lebih aman.
                </p>

                <form method="post"
                    action="{{ route('password.update') }}"
                    class="space-y-6">

                    @csrf
                    @method('put')

                    <!-- CURRENT PASSWORD -->
                    <div>

                        <label class="block text-gray-700 font-semibold mb-2">
                            Current Password
                        </label>

                        <input type="password"
                            name="current_password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <!-- NEW PASSWORD -->
                    <div>

                        <label class="block text-gray-700 font-semibold mb-2">
                            New Password
                        </label>

                        <input type="password"
                            name="password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>

                        <label class="block text-gray-700 font-semibold mb-2">
                            Confirm Password
                        </label>

                        <input type="password"
                            name="password_confirmation"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 transition text-white font-bold px-6 py-3 rounded-xl shadow">

                        Save Password

                    </button>

                </form>

            </div>

            <!-- DELETE ACCOUNT -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">

                <h2 class="text-2xl font-bold text-red-600 mb-2">
                    Delete Account
                </h2>

                <p class="text-gray-500 mb-6">
                    Setelah akun dihapus, seluruh data tidak dapat dikembalikan.
                </p>

                <form method="post"
                    action="{{ route('profile.destroy') }}">

                    @csrf
                    @method('delete')

                    <div class="mb-6">

                        <label class="block text-gray-700 font-semibold mb-2">
                            Password
                        </label>

                        <input type="password"
                            name="password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500">

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 transition text-white font-bold px-6 py-3 rounded-xl shadow">

                        Delete Account

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>