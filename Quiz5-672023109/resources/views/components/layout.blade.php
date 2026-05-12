<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Koperasi Simpan Pinjam' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-base-200">
    {{-- Navbar --}}
    <div class="navbar bg-base-100 shadow-md">
        <div class="navbar-start">
            <a href="/" class="btn btn-ghost text-xl">Koperasi</a>
        </div>
        <div class="navbar-end gap-2">
            @auth
                <span class="text-sm">{{ auth()->user()->name }}</span>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
            @endauth
        </div>
    </div>

    {{-- Main Content --}}
    <main class="py-8">
        {{ $slot }}
    </main>
</body>
</html>
