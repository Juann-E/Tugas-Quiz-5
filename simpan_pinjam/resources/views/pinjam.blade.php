<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Pinjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 w-full max-w-md">
        <h2 class="text-xl font-bold text-slate-900 mb-2 text-center">Ajukan Pinjaman</h2>
        <p class="text-center text-amber-600 text-xs font-medium mb-6 px-4 italic leading-relaxed">Pinjaman yang diajukan akan langsung ditambahkan ke saldo Anda.</p>
        <form action="{{ route('transaction.loan') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Jumlah Pinjaman (Rp)</label>
                <input type="number" name="amount" required placeholder="Contoh: 80000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-4 text-lg font-semibold focus:ring-2 focus:ring-amber-500 outline-none transition text-amber-700">
            </div>
            <div class="flex flex-col gap-2">
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg transition">Ajukan Pinjaman</button>
                <a href="{{ route('dashboard') }}" class="w-full text-center text-slate-400 hover:text-slate-600 py-2 text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>