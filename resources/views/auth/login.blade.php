<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — KoperasiKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"DM Serif Display"', 'serif'],
                        sans:  ['"DM Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .bg-pattern {
            background-color: #14532d;
            background-image: radial-gradient(circle at 20% 50%, #166534 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, #15803d 0%, transparent 40%),
                              radial-gradient(circle at 60% 80%, #14532d 0%, transparent 40%);
        }
        .input-field {
            @apply w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800
                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                   placeholder-gray-400 transition-all;
        }
        .fade-in { animation: fadeIn .5s ease forwards; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- Left panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-pattern flex-col justify-between p-12">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-400 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-900" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <span class="font-serif text-white text-xl">KoperasiKu</span>
        </div>

        <div>
            <p class="text-green-300 text-sm uppercase tracking-widest font-medium mb-4">Sistem Simpan Pinjam</p>
            <h2 class="font-serif text-white text-4xl xl:text-5xl leading-tight mb-6">
                Kelola keuangan<br><em>dengan mudah</em><br>dan transparan.
            </h2>
            <p class="text-green-300 text-base leading-relaxed max-w-sm">
                Pantau simpanan, tabungan, dan pinjaman Anda dalam satu platform yang sederhana dan terpercaya.
            </p>
        </div>

        <div class="flex gap-8">
            <div>
                <p class="text-white font-serif text-2xl">100%</p>
                <p class="text-green-400 text-xs mt-1">Transparan</p>
            </div>
            <div>
                <p class="text-white font-serif text-2xl">Mudah</p>
                <p class="text-green-400 text-xs mt-1">Digunakan</p>
            </div>
            <div>
                <p class="text-white font-serif text-2xl">Aman</p>
                <p class="text-green-400 text-xs mt-1">Terpercaya</p>
            </div>
        </div>
    </div>

    {{-- Right panel --}}
    <div class="flex-1 flex items-center justify-center bg-white px-6 py-12">
        <div class="w-full max-w-sm fade-in">

            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-9 h-9 rounded-xl bg-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="font-serif text-gray-900 text-xl">KoperasiKu</span>
            </div>

            <h1 class="font-serif text-gray-900 text-3xl mb-2">Selamat datang</h1>
            <p class="text-gray-500 text-sm mb-8">Masuk untuk mengakses akun Anda.</p>

            {{-- Errors --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6">
                <p class="text-sm font-medium text-red-700 mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-xs text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Success Messages --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="your@email.com"
                        class="w-full bg-gray-50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                               placeholder-gray-400 transition-all"
                        required autofocus>
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="••••••••"
                            class="w-full bg-gray-50 border @error('password') border-red-400 @else border-gray-200 @enderror rounded-xl px-4 py-3 pr-11 text-sm text-gray-800
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                   placeholder-gray-400 transition-all"
                            required>
                        <button type="button" onclick="togglePwd()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember"
                        class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white font-medium rounded-xl py-3 text-sm transition-all duration-200 shadow-sm hover:shadow-md active:scale-[.98]">
                    Masuk ke Akun
                </button>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold">
                        Daftar di sini
                    </a>
                </p>
            </form>

            <p class="text-center text-gray-400 text-xs mt-8">
                KoperasiKu &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

    <script>
        function togglePwd() {
            const i = document.getElementById('passwordInput');
            i.type = i.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>