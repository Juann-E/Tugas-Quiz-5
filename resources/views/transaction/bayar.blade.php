<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pinjaman</title>
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
            appearance: none;
            -webkit-appearance: none;
        }
        .input-field::placeholder { color: #a8bfb2; }
        .input-field:focus {
            border-color: #0891b2;
            box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.08);
        }

        .select-wrapper {
            position: relative;
        }
        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #a8bfb2;
            pointer-events: none;
        }

        .btn-sky {
            background: #0891b2;
            transition: background 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 10px rgba(8, 145, 178, 0.22);
        }
        .btn-sky:hover {
            background: #0e7490;
            box-shadow: 0 4px 16px rgba(8, 145, 178, 0.30);
        }
        .btn-sky:active { background: #155e75; }

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
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12l2 2 4-4"/>
                <rect x="3" y="6" width="18" height="13" rx="2"/>
                <path d="M3 10h18"/>
            </svg>
        </div>
        <h1 class="font-display text-2xl text-gray-800 leading-snug">
            Bayar <em class="text-sky-600">Pinjaman</em>
        </h1>
        <p class="text-sm text-gray-400 mt-1.5 font-light">Pilih pinjaman dan masukkan jumlah pembayaran</p>
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

        <form action="{{ route('bayar.process') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pilih Pinjaman --}}
            <div>
                <label class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Pilih Pinjaman
                </label>
                <div class="select-wrapper">
                    <select
                        name="loan_id"
                        required
                        class="input-field w-full rounded-xl px-4 py-3 text-sm"
                    >
                        <option value="" disabled selected>Pilih pinjaman yang ingin dibayar</option>
                        @foreach($pinjamanAktif as $pinjaman)
                            <option value="{{ $pinjaman->id }}">
                                Pinjaman {{ $pinjaman->created_at->format('d/m/Y') }} — Sisa: Rp {{ number_format($pinjaman->remaining_amount, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Jumlah Pembayaran --}}
            <div>
                <label class="block text-xs font-semibold tracking-wider text-gray-400 uppercase mb-2">
                    Jumlah Pembayaran (Rp)
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
                <button type="submit" class="btn-sky w-full rounded-xl py-3 text-sm font-semibold text-white tracking-wide">
                    Bayar Pinjaman
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
