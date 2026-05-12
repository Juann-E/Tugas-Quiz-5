<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .balance-card {
            background: linear-gradient(135deg, #1d9e75 0%, #0f6e56 100%);
            box-shadow: 0 8px 32px rgba(29, 158, 117, 0.30), 0 2px 8px rgba(0,0,0,0.06);
        }

        .action-btn {
            border: 1.5px solid;
            transition: transform 0.12s, box-shadow 0.12s;
        }
        .action-btn:hover { transform: translateY(-2px); }
        .action-btn:active { transform: translateY(0); }

        .table-row:last-child td { border-bottom: none; }

        .badge-active {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .logout-btn {
            border: 1.5px solid #e2ede8;
            color: #6b7280;
            transition: border-color 0.15s, color 0.15s, background 0.15s;
        }
        .logout-btn:hover {
            border-color: #fca5a5;
            color: #ef4444;
            background: #fff5f5;
        }
    </style>
</head>
<body class="min-h-screen py-10 px-4">

<div class="max-w-3xl mx-auto">

    {{-- Top bar --}}
    <div class="flex items-center justify-between mb-7">
        <div>
            <p class="text-xs font-semibold tracking-wider text-gray-400 uppercase mb-0.5">Sistem Informasi</p>
            <h1 class="font-display text-2xl text-gray-800 leading-tight">
                Halo,<em class="text-emerald-600 ml-1">{{ Auth::user()->username }}</em>
            </h1>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn rounded-xl px-4 py-2 text-sm font-semibold bg-white">
                Logout
            </button>
        </form>
    </div>

    {{-- Success alert --}}
    @if(session('success'))
        <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700 font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Balance card --}}
    <div class="balance-card rounded-2xl px-8 py-8 mb-6 text-white">
        <p class="text-sm font-medium text-white/70 mb-1 tracking-wide">Saldo {{ Auth::user()->username }}</p>
        <p class="font-display text-4xl font-light leading-none">
            Rp {{ number_format($saldo, 0, ',', '.') }}
        </p>
    </div>

    {{-- Action buttons --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

        <a href="{{ route('tabung.form') }}"
           class="action-btn rounded-2xl bg-white border-emerald-200 text-emerald-700 flex flex-col items-center justify-center py-6 gap-2 text-sm font-semibold card-shadow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tabung
        </a>

        <a href="{{ route('ambil.form') }}"
           class="action-btn rounded-2xl bg-white border-red-200 text-red-500 flex flex-col items-center justify-center py-6 gap-2 text-sm font-semibold card-shadow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"/>
            </svg>
            Ambil
        </a>

        <a href="{{ route('pinjam.form') }}"
           class="action-btn rounded-2xl bg-white border-amber-200 text-amber-600 flex flex-col items-center justify-center py-6 gap-2 text-sm font-semibold card-shadow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="6" width="18" height="13" rx="2"/>
                <path d="M3 10h18"/>
            </svg>
            Pinjam
        </a>

        <a href="{{ route('bayar.form') }}"
           class="action-btn rounded-2xl bg-white border-sky-200 text-sky-600 flex flex-col items-center justify-center py-6 gap-2 text-sm font-semibold card-shadow">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12l2 2 4-4"/>
                <rect x="3" y="6" width="18" height="13" rx="2"/>
                <path d="M3 10h18"/>
            </svg>
            Bayar Pinjaman
        </a>

    </div>

    {{-- Active loans table --}}
    <div class="card-shadow rounded-2xl bg-white overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Pinjaman Aktif</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-semibold tracking-wider text-gray-400 uppercase px-6 py-3">Tanggal</th>
                    <th class="text-left text-xs font-semibold tracking-wider text-gray-400 uppercase px-6 py-3">Total Pinjaman</th>
                    <th class="text-left text-xs font-semibold tracking-wider text-gray-400 uppercase px-6 py-3">Sisa Pinjaman</th>
                    <th class="text-left text-xs font-semibold tracking-wider text-gray-400 uppercase px-6 py-3">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pinjamanAktif as $pinjaman)
                    <tr class="table-row border-b border-gray-50 hover:bg-gray-50/60">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pinjaman->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">Rp {{ number_format($pinjaman->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">Rp {{ number_format($pinjaman->remaining_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="badge-active rounded-lg px-3 py-1 text-xs font-semibold">{{ $pinjaman->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400">
                            Anda tidak memiliki pinjaman aktif.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-gray-300 mt-6">
        Hubungi admin jika mengalami kendala
    </p>

</div>

</body>
</html>
