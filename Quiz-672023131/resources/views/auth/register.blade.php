<x-guest-layout>
<div class="auth-page auth-purple">
    <div class="auth-card animate-up">
        <h1>✨ Buat Akun</h1>
        <p class="subtitle">Daftar dulu sebelum memakai aplikasi</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

            <button type="submit">Register</button>
        </form>

        <p class="bottom-text">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</div>
</x-guest-layout>