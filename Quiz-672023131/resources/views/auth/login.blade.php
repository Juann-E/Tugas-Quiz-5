<x-guest-layout>
<div class="auth-page auth-blue">
    <div class="auth-card animate-up">
        <h1>💰 Simpan Pinjam</h1>
        <p class="subtitle">Login untuk masuk ke dashboard</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" required autofocus>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>

        <p class="bottom-text">
            Belum punya akun?
            <a href="{{ route('register') }}">Register sekarang</a>
        </p>
    </div>
</div>
</x-guest-layout>