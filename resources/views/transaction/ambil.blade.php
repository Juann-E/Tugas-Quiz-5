<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Uang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;1,400&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
        }

        .btn-danger {
            background: #ef4444;
            transition: background 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 10px rgba(239, 68, 68, 0.22);
        }
        .btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.30);
        }
        .btn-danger:active { background: #b91c1c; }

        .btn-cancel {
            border: 1.5px solid #e2ede8;
            color: #6b7280;
            transition: border-color 0.15s, color 0.15s, background 0.15s;
        }
        .btn-cancel:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            color: #374151;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10">

<div class="w-full max-w-sm">

    {{-- Brand --}}
    <div class="text-center mb-7">
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-red-50 border border-red-100 mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"/>
            </svg>
        </div>
        <h1 class="font-display text-2xl text-gray-800 leading-snug">
            Ambil <em class="text-red-500">Uang</em>
        </h1>
        <p class="text-sm text-gray-400 mt-1.5 font-light">Masukkan jumlah yang ingin ditarik</p>
    </div>

    {{-- Card --}}
    <div class="card-shadow rounded-2xl bg-white p-8">

        {{-- Saldo info --}}
        <div class="rounded-xl bg-gray-50 border border-gray-100 px-4 py-3 mb-6 flex items-center justify-between">
            <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Saldo Saat Ini</span>
            <span class="text-sm font-bold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
        </div>

        {{-- Error --}}
        @if($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-600 font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('ambil.process') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Jumlah Penarikan (Rp)
                </label>
                <input
                    type="number"
                    name="amount"
                    placeholder="0"
                    required
                    min="1"
                    class="input-field w-full rounded-xl px-4 py-3 text-sm"
                >
            </div>

            <div class="pt-1 space-y-3">
                <button type="submit" class="btn-danger w-full rounded-xl py-3 text-sm font-semibold text-white tracking-wide">
                    Ambil Uang
                </button>
                <a href="{{ route('dashboard') }}" class="btn-cancel w-full rounded-xl py-3 text-sm font-semibold bg-white block text-center">
                    Batal
                </a>
            </div>

        </form>

    </div>

    <p class="text-center text-xs text-gray-300 mt-5">
        Hubungi admin jika mengalami kendala
    </p>

</div>

</body>
</html>
