<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KoperasiKu') — Simpan & Pinjam</title>
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
                    colors: {
                        brand: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        ink: '#0f1a13',
                        muted: '#6b7280',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f7faf8; }
        .sidebar-link.active { background: #14532d; color: #fff; }
        .sidebar-link.active svg { color: #4ade80; }
        .sidebar-link { transition: all .18s; }
        .sidebar-link:hover:not(.active) { background: #dcfce7; color: #14532d; }
        .card-shadow { box-shadow: 0 2px 16px 0 rgba(20,83,45,.08); }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-brand-900 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-6 border-b border-brand-800">
            <div class="w-9 h-9 rounded-xl bg-brand-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-brand-900" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <div>
                <p class="font-serif text-white text-lg leading-tight">KoperasiKu</p>
                <p class="text-brand-400 text-xs font-light">Simpan · Pinjam · Sejahtera</p>
            </div>
        </div>

        {{-- User info --}}
        <div class="px-6 py-4 border-b border-brand-800">
            <p class="text-brand-400 text-xs uppercase tracking-widest font-medium mb-1">Anggota</p>
            <p class="text-white font-medium text-sm truncate">{{ Auth::user()->name_panjang ?? 'Nama Anggota' }}</p>
            <p class="text-brand-400 text-xs">@{{ Auth::user()->username ?? 'username' }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-200 text-sm font-medium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 w-5 h-5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <p class="px-3 pt-4 pb-1 text-brand-600 text-xs uppercase tracking-widest font-semibold">Keuangan</p>

            <a href="{{ route('simpanan.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-200 text-sm font-medium {{ request()->routeIs('simpanan.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/><path d="M12 6v6l4 2"/>
                </svg>
                Simpanan
            </a>

            <a href="{{ route('tabungan.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-200 text-sm font-medium {{ request()->routeIs('tabungan.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Tabungan
            </a>

            <a href="{{ route('pinjaman.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-200 text-sm font-medium {{ request()->routeIs('pinjaman.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
                Pinjaman
            </a>

            <a href="{{ route('bayar-pinjaman.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-200 text-sm font-medium {{ request()->routeIs('bayar-pinjaman.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Bayar Pinjaman
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-brand-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-300 hover:bg-red-900/40 hover:text-red-300 text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-4 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-brand-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div>
                    <h1 class="font-serif text-ink text-xl leading-tight">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-muted text-xs mt-0.5">@yield('page-subtitle')</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center">
                    <span class="text-brand-700 text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name_panjang ?? 'A', 0, 1)) }}</span>
                </div>
            </div>
        </header>

        {{-- Flash message --}}
        @if(session('success'))
        <div class="mx-4 lg:mx-8 mt-4 bg-brand-50 border border-brand-200 text-brand-800 rounded-xl px-4 py-3 flex items-center gap-3 text-sm">
            <svg class="w-5 h-5 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mx-4 lg:mx-8 mt-4 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 flex items-center gap-3 text-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 px-4 lg:px-8 py-6">
            @yield('content')
        </main>

        <footer class="px-4 lg:px-8 py-4 border-t border-gray-100 text-center text-xs text-muted">
            KoperasiKu &copy; {{ date('Y') }} — Sistem Simpan Pinjam
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const s = document.getElementById('sidebar');
            const o = document.getElementById('overlay');
            s.classList.toggle('-translate-x-full');
            o.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>