<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#1e293b] min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-green-100 via-slate-50 to-emerald-50">

    <div class="w-full max-w-lg">
        <!-- Logo/Brand Placeholder -->
        <div class="flex justify-center mb-8">
            <div class="h-12 w-12 bg-green-600 rounded-xl shadow-lg shadow-green-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden">
            <!-- Content Header -->
            <div class="px-10 pt-10 pb-6 text-center">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-2">Mulai Sekarang</h1>
                <p class="text-slate-500 font-medium">Bergabunglah dengan komunitas kami hari ini.</p>
            </div>

            <!-- Form -->
            <form id="registerForm" action="{{ route('register.store') }}" method="POST" class="px-10 pb-10 space-y-5">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
                        <p class="text-sm font-bold text-red-700 mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-xs text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label for="name_panjang" class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name_panjang"
                        name="name_panjang"
                        placeholder="John Doe"
                        value="{{ old('name_panjang') }}"
                        class="w-full px-5 py-3.5 bg-slate-50 border @error('name_panjang') border-red-400 @else border-slate-200 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all duration-300 placeholder:text-slate-400"
                        required
                    />
                    @error('name_panjang')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="space-y-1.5">
                    <label for="username" class="text-sm font-bold text-slate-700 ml-1">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="johndoe123"
                        value="{{ old('username') }}"
                        class="w-full px-5 py-3.5 bg-slate-50 border @error('username') border-red-400 @else border-slate-200 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all duration-300 placeholder:text-slate-400"
                        required
                    />
                    @error('username')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-bold text-slate-700 ml-1">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="john@example.com"
                        value="{{ old('email') }}"
                        class="w-full px-5 py-3.5 bg-slate-50 border @error('email') border-red-400 @else border-slate-200 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all duration-300 placeholder:text-slate-400"
                        required
                    />
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-sm font-bold text-slate-700 ml-1">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-5 py-3.5 bg-slate-50 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all duration-300 placeholder:text-slate-400"
                            required
                        />
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-sm font-bold text-slate-700 ml-1">Konfirmasi</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="••••••••"
                            class="w-full px-5 py-3.5 bg-slate-50 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 transition-all duration-300 placeholder:text-slate-400"
                            required
                        />
                    </div>
                </div>

                <!-- Real-time Validation Message -->
                <div id="match_message" class="text-xs font-semibold px-2 transition-all duration-300 opacity-0 h-4">
                    Pencocokan password...
                </div>

                <!-- Register Button -->
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-slate-900 hover:bg-green-600 text-white font-bold py-4 rounded-2xl transition-all duration-500 shadow-lg shadow-slate-200 hover:shadow-green-200 flex items-center justify-center gap-2 group"
                >
                    Buat Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <!-- Footer -->
            <div class="px-10 py-6 bg-slate-50/50 border-t border-slate-100 text-center">
                <p class="text-slate-500 text-sm font-medium">
                    Sudah bergabung sebelumnya? 
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold underline underline-offset-4 decoration-2">
                        Masuk
                    </a>
                </p>
            </div>
        </div>
        
        <p class="text-center mt-8 text-slate-400 text-xs">
            &copy; 2024 Design Studio. Seluruh hak cipta dilindungi.
        </p>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const message = document.getElementById('match_message');
        const submitBtn = document.getElementById('submitBtn');

        function validatePassword() {
            const val1 = password.value;
            const val2 = confirm.value;

            // Jika input konfirmasi masih kosong, sembunyikan pesan
            if (val2.length === 0) {
                message.classList.add('opacity-0');
                confirm.className = "w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all duration-300 placeholder:text-slate-400";
                return;
            }

            message.classList.remove('opacity-0');

            if (val1 === val2) {
                // Jika Cocok
                message.textContent = "✓ Password cocok";
                message.className = "text-xs font-semibold px-2 transition-all duration-300 text-green-600";
                confirm.className = "w-full px-5 py-3.5 bg-slate-50 border-2 border-green-500 rounded-2xl focus:outline-none transition-all duration-300";
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                // Jika Tidak Cocok
                message.textContent = "✕ Password tidak sesuai";
                message.className = "text-xs font-semibold px-2 transition-all duration-300 text-red-500";
                confirm.className = "w-full px-5 py-3.5 bg-slate-50 border-2 border-red-400 rounded-2xl focus:outline-none transition-all duration-300";
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        password.addEventListener('input', validatePassword);
        confirm.addEventListener('input', validatePassword);

        // Mencegah form submit jika tidak valid (tambahan proteksi)
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (password.value !== confirm.value) {
                e.preventDefault();
                alert('Pastikan password sudah sesuai!');
            }
        });
    </script>
</body>
</html>