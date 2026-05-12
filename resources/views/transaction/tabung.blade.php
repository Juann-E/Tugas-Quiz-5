<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabung Uang</title>
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
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1d9e75" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </div>
        <h1 class="font-display text-2xl text-gray-800 leading-snug">
            Tabung <em class="text-emerald-600">Uang</em>
        </h1>
        <p class="text-sm text-gray-400 mt-1.5 font-light">Masukkan jumlah yang ingin ditabung</p>
    </div>

    {{-- Card --}}
    <div class="card-shadow rounded-2xl bg-white p-8">

        {{-- Error --}}
        @if($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-600 font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('tabung.process') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Jumlah Tabungan (Rp)
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
                <button type="submit" class="btn-primary w-full rounded-xl py-3 text-sm font-semibold text-white tracking-wide">
                    Simpan Tabungan
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
