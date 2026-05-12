<x-app-layout>
<div class="dashboard-page">

    <div class="dashboard-header animate-up">
        <div>
            <h1>💰 Dashboard Simpan Pinjam</h1>
            <p>Kelola tabungan, pinjaman, dan pembayaran kamu.</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    @if(session('error'))
        <div class="alert error animate-up">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert success animate-up">
            {{ session('success') }}
        </div>
    @endif

    <div class="saldo-card animate-up">
        <p>Saldo Kamu</p>
        <h2>Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
    </div>

    <div class="action-grid">

        <div class="action-card animate-up">
            <div class="icon blue">💵</div>
            <h3>Tabung Uang</h3>
            <form method="POST" action="/tabung">
                @csrf
                <input type="number" name="jumlah" placeholder="Masukkan jumlah" required>
                <button class="btn blue-btn">Tabung</button>
            </form>
        </div>

        <div class="action-card animate-up">
            <div class="icon red">🏧</div>
            <h3>Ambil Uang</h3>
            <form method="POST" action="/ambil">
                @csrf
                <input type="number" name="jumlah" placeholder="Masukkan jumlah" required>
                <button class="btn red-btn">Ambil</button>
            </form>
        </div>

        <div class="action-card animate-up">
            <div class="icon green">🤝</div>
            <h3>Pinjam Uang</h3>
            <form method="POST" action="/pinjam">
                @csrf
                <input type="number" name="jumlah" placeholder="Masukkan jumlah" required>
                <button class="btn green-btn">Pinjam</button>
            </form>
        </div>

    </div>

    <div class="loan-section animate-up">
        <h2>📋 Daftar Pinjaman</h2>

        @forelse($pinjaman as $p)
            <div class="loan-card">
                <div>
                    <p>Total Pinjaman</p>
                    <h3>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</h3>
                    <p>Sisa Pinjaman</p>
                    <h3 class="debt">Rp {{ number_format($p->sisa, 0, ',', '.') }}</h3>
                </div>

                <form method="POST" action="/bayar/{{ $p->id }}" class="pay-form">
                    @csrf
                    <input type="number" name="jumlah" placeholder="Jumlah bayar" required>
                    <button>Bayar</button>
                </form>
            </div>
        @empty
            <div class="empty-card">
                🎉 Tidak ada pinjaman aktif.
            </div>
        @endforelse
    </div>

</div>
</x-app-layout>