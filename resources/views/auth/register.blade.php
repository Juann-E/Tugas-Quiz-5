<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Nunito', sans-serif; }
        .font-display { font-family: 'Lora', serif; }

        body {
            background-color: #f4f7f5;
            background-image:
                radial-gradient(ellipse 70% 50% at 15% 0%, rgba(29, 158, 117, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 85% 100%, rgba(15, 110, 86, 0.06) 0%, transparent 55%);
        }

        .card-shadow {
            box-shadow:
                0 0 0 1px rgba(29, 158, 117, 0.10),
                0 20px 48px rgba(15, 110, 86, 0.08),
                0 4px 12px rgba(0,0,0,0.04);
        }

        .input-field {
            background: #ffffff;
            border: 1.5px solid #e2ede8;
            color: #1a2e23;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .input-field::placeholder { color: #a8bfb2; }
        .input-field:focus {
            border-color: #1d9e75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.10);
        }

        .btn-primary {
            background: #1d9e75;
            transition: background 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 10px rgba(29, 158, 117, 0.25);
        }
        .btn-primary:hover {
            background: #198a65;
            box-shadow: 0 4px 16px rgba(29, 158, 117, 0.35);
        }
        .btn-primary:active { background: #147a58; }

        .divider-line {
            background: linear-gradient(to right, transparent, #cdddd5, transparent);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10">

<div class="w-full max-w-sm">

    {{-- Brand --}}
    <div class="text-center mb-7">
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L3 7v10l9 5 9-5V7L12 2z" stroke="#1d9e75" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M12 12l9-5M12 12v10M12 12L3 7" stroke="#1d9e75" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>
        <h1 class="font-display text-2xl text-gray-800 leading-snug">
            Buat Akun<br><em class="text-emerald-600">Baru</em>
        </h1>
        <p class="text-sm text-gray-400 mt-1.5 font-light">Lengkapi data diri untuk mendaftar</p>
    </div>

    {{-- Card --}}
    <div class="card-shadow rounded-2xl bg-white p-8">

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                    autofocus
                    class="input-field w-full rounded-xl px-4 py-3 text-sm"
                >
                @error('name')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                    class="input-field w-full rounded-xl px-4 py-3 text-sm"
                >
                @error('username')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="input-field w-full rounded-xl px-4 py-3 text-sm"
                >
                @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                    class="input-field w-full rounded-xl px-4 py-3 text-sm"
                >
            </div>

            {{-- Submit --}}
            <div class="pt-1">
                <button type="submit" class="btn-primary w-full rounded-xl py-3 text-sm font-semibold text-white tracking-wide">
                    Daftar
                </button>
            </div>

        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-5">
            <div class="flex-1 h-px divider-line"></div>
            <span class="text-xs text-gray-300 font-light">atau</span>
            <div class="flex-1 h-px divider-line"></div>
        </div>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors duration-150 ml-1">
                Login di sini →
            </a>
        </p>

    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-gray-300 mt-5">
        Hubungi admin jika mengalami kendala
    </p>

</div>

</body>
</html>
