<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kuis 1_PBP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                "colors": {
                    "error-container": "#FEE2E2",
                    "on-error": "#ffffff",
                    "primary": "#031635",
                    "on-tertiary-container": "#00a774",
                    "on-secondary-fixed-variant": "#004395",
                    "inverse-surface": "#2d3133",
                    "surface-tint": "#4e5e81",
                    "on-primary-fixed": "#081b3a",
                    "primary-fixed": "#d8e2ff",
                    "surface-container-highest": "#e0e3e5",
                    "surface-bright": "#f7f9fb",
                    "on-secondary-container": "#fefcff",
                    "surface-container-low": "#f2f4f6",
                    "surface-container-high": "#e6e8ea",
                    "surface-dim": "#d8dadc",
                    "on-background": "#191c1e",
                    "tertiary-container": "#DCFCE7",
                    "secondary-fixed-dim": "#adc6ff",
                    "on-secondary-fixed": "#001a42",
                    "tertiary-fixed-dim": "#4edea3",
                    "on-primary": "#ffffff",
                    "surface": "#f7f9fb",
                    "primary-fixed-dim": "#b6c6ef",
                    "on-surface-variant": "#64748B",
                    "background": "#F8FAFC",
                    "inverse-primary": "#b6c6ef",
                    "primary-container": "#E2E8F0",
                    "on-tertiary-fixed": "#002113",
                    "tertiary": "#10B981",
                    "outline": "#E2E8F0",
                    "on-tertiary": "#ffffff",
                    "outline-variant": "#E2E8F0",
                    "inverse-on-surface": "#eff1f3",
                    "surface-container-lowest": "#ffffff",
                    "secondary": "#2563EB",
                    "secondary-container": "#DBEAFE",
                    "secondary-fixed": "#d8e2ff",
                    "on-primary-container": "#334155",
                    "on-tertiary-fixed-variant": "#005236",
                    "on-surface": "#1E293B",
                    "on-secondary": "#ffffff",
                    "surface-variant": "#F1F5F9",
                    "surface-container": "#F1F5F9",
                    "error": "#EF4444",
                    "on-error-container": "#93000a",
                    "tertiary-fixed": "#6ffbbe",
                    "on-primary-fixed-variant": "#364768"
                },
                "borderRadius": {
                    "xl": "1.25rem",
                },
                "spacing": {
                    "gutter": "24px",
                    "lg": "2rem",
                    "xl": "3rem",
                }
                },
            },
        }
    </script>
    <style>
        body { background-color: #F8FAFC; font-family: 'Manrope', sans-serif; }
        .card-shadow { box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.04); }
        .card-shadow-hover:hover { box-shadow: 0px 12px 32px rgba(0, 0, 0, 0.08); transform: translateY(-4px); transition: all 0.3s ease; }
        .sidebar-item-active {
            background: linear-gradient(90deg, #2563EB 0%, rgba(37, 99, 235, 0.05) 100%);
            border-left: 4px solid #2563EB;
        }
        .balance-gradient {
            background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        }
    </style>
</head>

<body class="text-on-surface">

<aside class="h-screen w-64 fixed left-0 top-0 bg-white text-on-surface flex flex-col py-8 px-4 shadow-sm border-r border-outline-variant z-50">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">account_balance</span>
        </div>
        <div>
            <h1 class="text-xl font-extrabold text-primary leading-none">PBP</h1>
            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-1">Kuis 5 - 672023104</p>
        </div>
    </div>
    
    <nav class="flex-grow space-y-1">
        <a class="flex items-center gap-3 px-4 py-3 text-secondary font-bold sidebar-item-active transition-all" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-error hover:bg-error-container/30 rounded-lg transition-all font-bold">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </nav>
</aside>

<main class="ml-64 min-h-screen">
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-20 bg-white/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center px-8 z-40">
        <div class="flex items-center gap-4">
            <h2 class="font-bold text-primary">Welcome back, {{ $user->name }}!</h2>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3 border-l pl-6">
                <div class="text-right">
                    <p class="font-bold text-sm text-on-surface">{{ $user->username }}</p>
                    <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest">Semester 6 Student</p>
                </div>
                <div class="w-11 h-11 rounded-full bg-secondary-container flex items-center justify-center text-secondary font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <div class="pt-28 px-8 pb-12 max-w-7xl mx-auto">
        
        <div class="fixed bottom-6 right-6 z- flex flex-col gap-3">
            @if(session('success'))
            <div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-white bg-emerald-500 rounded-2xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <div class="ms-3 text-sm font-bold">{{ session('success') }}</div>
                <button type="button" onclick="closeToast('toast-success')" class="ms-auto -mx-1.5 -my-1.5 text-white/70 hover:text-white p-1.5 inline-flex items-center justify-center h-8 w-8 transition-colors">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div id="toast-error" class="flex items-center w-full max-w-xs p-4 text-white bg-rose-500 rounded-2xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-rose-500 bg-rose-100 rounded-lg">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">error</span>
                </div>
                <div class="ms-3 text-sm font-bold">Terjadi kesalahan!</div>
                <button type="button" onclick="closeToast('toast-error')" class="ms-auto -mx-1.5 -my-1.5 text-white/70 hover:text-white p-1.5 inline-flex items-center justify-center h-8 w-8 transition-colors">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-8 balance-gradient rounded-3xl p-8 flex flex-col justify-between h-[300px] text-white card-shadow relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <span class="material-symbols-outlined text-[180px]">account_balance_wallet</span>
                </div>
                <div class="z-10">
                    <p class="font-bold text-xs uppercase tracking-[0.2em] opacity-80">Total Balance</p>
                    <h2 class="text-[56px] font-extrabold mt-2 tracking-tight">Rp {{ number_format($user->saldo, 0, ',', '.') }}</h2>
                </div>
                <div class="z-10 bg-white/10 backdrop-blur-xl p-4 rounded-2xl inline-block self-start mt-auto border border-white/20">
                    <p class="text-sm text-white/90 font-medium italic">"Save money, and money will save you."</p>
                </div>
            </div>

            <div class="col-span-4 grid grid-cols-2 gap-6">
                <a href="{{ route('tabung.view') }}" class="bg-white rounded-3xl p-4 flex flex-col items-center justify-center gap-3 card-shadow card-shadow-hover group">
                    <div class="w-14 h-14 bg-tertiary-container rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-tertiary text-3xl" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                    </div>
                    <span class="font-bold text-sm text-on-surface">Tabung</span>
                </a>
                <a href="{{ route('ambil.view') }}" class="bg-white rounded-3xl p-4 flex flex-col items-center justify-center gap-3 card-shadow card-shadow-hover group">
                    <div class="w-14 h-14 bg-error-container rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-error text-3xl" style="font-variation-settings: 'FILL' 1;">remove_circle</span>
                    </div>
                    <span class="font-bold text-sm text-on-surface">Ambil</span>
                </a>
                <a href="{{ route('pinjam.view') }}" class="bg-white rounded-3xl p-4 flex flex-col items-center justify-center gap-3 card-shadow card-shadow-hover group">
                    <div class="w-14 h-14 bg-secondary-container rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary text-3xl" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                    </div>
                    <span class="font-bold text-sm text-on-surface">Pinjam</span>
                </a>
                <a href="{{ route('bayar.view') }}" class="bg-white rounded-3xl p-4 flex flex-col items-center justify-center gap-3 card-shadow card-shadow-hover group">
                    <div class="w-14 h-14 bg-primary-container rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">payments</span>
                    </div>
                    <span class="font-bold text-sm text-on-surface">Bayar</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-4 bg-white rounded-3xl card-shadow overflow-hidden flex flex-col">
                <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-variant/30">
                    <h3 class="font-bold text-lg text-primary">Pinjam Aktif</h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($loans as $loan)
                    <div class="p-4 bg-white rounded-2xl border border-outline-variant shadow-sm hover:border-secondary transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <p class="font-bold text-on-surface text-sm">Loan ID #{{ $loan->id }}</p>
                            <span class="px-2.5 py-1 bg-tertiary-container text-tertiary text-[10px] font-extrabold rounded-full">ACTIVE</span>
                        </div>
                        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Due: {{ $loan->created_at->addMonths(1)->format('d M Y') }}</p>
                        <div class="mt-4">
                            <div class="flex justify-between text-[11px] font-bold mb-2">
                                <span class="text-on-surface-variant">Sisa Tagihan</span>
                                <span class="text-primary">Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-surface-variant h-1.5 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 opacity-50 italic text-sm">Tidak ada pinjaman aktif.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-span-8 bg-white rounded-3xl card-shadow overflow-hidden flex flex-col">
                <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-variant/30">
                    <h3 class="font-bold text-lg text-primary">Riwayat Transaksi</h3>
                    <a href="{{ route('report.pdf') }}" class="px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:bg-secondary transition-all">
                        Cetak Rekening Koran (PDF)
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-surface-variant/10">
                                <th class="px-6 py-4 font-bold text-[10px] text-on-surface-variant uppercase tracking-widest">Waktu</th>
                                <th class="px-6 py-4 font-bold text-[10px] text-on-surface-variant uppercase tracking-widest">Tipe</th>
                                <th class="px-6 py-4 font-bold text-[10px] text-on-surface-variant uppercase tracking-widest">Nominal</th>
                                <th class="px-6 py-4 font-bold text-[10px] text-on-surface-variant uppercase tracking-widest">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @forelse($user->transactions()->latest()->take(5)->get() as $trx)
                            <tr class="hover:bg-surface-variant/20 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-on-surface">{{ $trx->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-on-surface-variant font-medium">{{ $trx->created_at->format('H:i A') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full @if($trx->type == 'tabung') bg-tertiary @elseif($trx->type == 'ambil') bg-error @elseif($trx->type == 'pinjam') bg-secondary @else bg-primary @endif"></div>
                                        <span class="text-xs font-bold text-on-surface">{{ strtoupper($trx->type) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-xs @if($trx->type == 'tabung' || $trx->type == 'pinjam') text-tertiary @else text-error @endif">
                                    {{ ($trx->type == 'tabung' || $trx->type == 'pinjam') ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant text-xs font-medium">{{ $trx->description }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 opacity-50 italic text-sm">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Fungsi untuk menutup toast secara manual
    function closeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 500);
        }
    }

    // Otomatis tutup setelah 3 detik
    document.addEventListener('DOMContentLoaded', () => {
        const successToast = document.getElementById('toast-success');
        const errorToast = document.getElementById('toast-error');

        if (successToast) {
            setTimeout(() => closeToast('toast-success'), 3000);
        }
        if (errorToast) {
            setTimeout(() => closeToast('toast-error'), 5000);
        }
    });
</script>

</body>
</html>