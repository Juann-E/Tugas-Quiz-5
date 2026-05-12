<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Simpan Pinjam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Halo, {{ $user->name }}!</h1>
            <p class="text-slate-500 text-sm">Selamat datang kembali di sistem kuis PBP.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="text-sm font-semibold text-red-600 hover:text-red-800 transition">Keluar</button>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
        <p class="text-sm font-medium">{{ session('success') }} </p>
    </div>
    @endif

    <div class="bg-blue-600 rounded-2xl p-8 mb-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden">
        <div class="relative z-10">
            <h5 class="text-blue-100 font-medium mb-1">Saldo Anda </h5>
            <h2 class="text-4xl font-bold">Rp {{ number_format($user->balance, 0, ',', '.') }} </h2>
        </div>
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500 rounded-full opacity-50"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <a href="{{ route('transaction.deposit.view') }}" class="group bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-md transition-all text-center">
            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-emerald-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <span class="font-bold text-sm text-slate-700">Tabung </span>
        </a>

        <a href="{{ route('transaction.withdraw.view') }}" class="group bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-red-500 hover:shadow-md transition-all text-center">
            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-red-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </div>
            <span class="font-bold text-sm text-slate-700">Ambil </span>
        </a>

        <a href="{{ route('transaction.loan.view') }}" class="group bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-amber-500 hover:shadow-md transition-all text-center">
            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <span class="font-bold text-sm text-slate-700">Pinjam </span>
        </a>

        <a href="{{ route('transaction.repay.view') }}" class="group bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-sky-500 hover:shadow-md transition-all text-center">
            <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-sky-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <span class="font-bold text-sm text-slate-700 text-center">Bayar Pinjaman </span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-lg">Pinjaman Aktif </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal </th>
                        <th class="px-6 py-4 text-center">Total Pinjaman </th>
                        <th class="px-6 py-4 text-center">Sisa Pinjaman </th>
                        <th class="px-6 py-4 text-center">Status </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-700">{{ $loan->created_at->format('d M Y') }} </td>
                        <td class="px-6 py-4 text-center text-slate-600">Rp {{ number_format($loan->total_pinjaman) }} </td>
                        <td class="px-6 py-4 text-center text-slate-900 font-semibold text-orange-600">Rp {{ number_format($loan->sisa_pinjaman) }} </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">{{ $loan->status }} </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Anda tidak memiliki pinjaman aktif </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>