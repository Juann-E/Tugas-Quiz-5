<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tarik Tunai - CapitalTrust</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { background-color: #F8FAFC; font-family: 'Manrope', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">remove_circle</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Tarik Tunai</h1>
            <p class="text-slate-500 text-sm mt-1">Ambil saldo kebutuhanmu sekarang</p>
        </div>

        <div class="glass-card rounded-3xl p-8 shadow-xl">
            <div class="mb-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Saldo Tersedia</p>
                <p class="text-xl font-extrabold text-slate-800">Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-sm font-bold">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('ambil') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Nominal Penarikan (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                        <input type="number" name="nominal" 
                            class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-bold text-lg text-slate-800" 
                            placeholder="Masukkan jumlah" required autofocus>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit" class="w-full py-4 bg-red-500 hover:bg-red-600 text-white rounded-2xl font-bold shadow-lg shadow-red-200 transition-all active:scale-95">
                        Konfirmasi Penarikan
                    </button>
                    <a href="{{ route('dashboard') }}" class="w-full py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-bold flex items-center justify-center transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-8">Pemrogramman Berorientasi Objek</p>
    </div>

</body>
</html>