<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Pinjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="max-w-md mx-auto mt-20 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">
        <h2 class="text-xl font-bold text-slate-900 mb-2">Bayar Pinjaman</h2>
        
        <p class="text-slate-500 text-sm mb-6 font-medium">
            Saldo saat ini: <span class="text-blue-600 font-bold">Rp {{ number_format($user->balance, 0, ',', '.') }} </span>
        </p>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-3 rounded-lg text-xs font-bold mb-4 border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('transaction.repay') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-wider">Pilih Pinjaman </label>
                <select name="loan_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sky-500 focus:bg-white outline-none transition-all cursor-pointer">
                    @forelse($loans as $loan)
                        <option value="{{ $loan->id }}">
                            Pinjaman {{ $loan->created_at->format('d/m/Y') }} - Sisa: Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }} 
                        </option>
                    @empty
                        <option disabled>Tidak ada pinjaman aktif</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-wider">Jumlah Pembayaran (Rp) </label>
                <input type="number" name="amount" required placeholder="Contoh: 60000" 
                    [cite_start]class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sky-500 focus:bg-white outline-none transition-all ">
            </div>

            <div class="pt-4 flex flex-col gap-2">
                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-sky-100 transition-all active:scale-[0.98] ">
                    Bayar Pinjaman
                </button>
                <a href="{{ route('dashboard') }}" class="w-full text-center text-slate-400 hover:text-slate-600 py-2 text-sm font-semibold transition-colors ">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>