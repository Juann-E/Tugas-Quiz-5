<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="container mx-auto p-4 max-w-4xl">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error mb-4">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Saldo Card --}}
        <div class="card bg-primary text-primary-content text-center p-6 mb-6">
            <h4 class="text-lg">Saldo Anda</h4>
            <h1 class="text-4xl font-bold">Rp {{ number_format($user->saldo, 0, ',', '.') }}</h1>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <button class="btn btn-success" onclick="modalTabung.showModal()">Tabung</button>
            <button class="btn btn-error" onclick="modalAmbil.showModal()">Ambil</button>
            <button class="btn btn-warning" onclick="modalPinjam.showModal()">Pinjam</button>
            <button class="btn btn-info" onclick="modalBayar.showModal()">Bayar Pinjaman</button>
        </div>

        {{-- Tabel Pinjaman Aktif --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Pinjaman Aktif</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Pinjaman</th>
                                <th>Sisa Pinjaman</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjamanAktif as $p)
                            <tr>
                                <td>{{ $p->tanggal }}</td>
                                <td>Rp {{ number_format($p->total_pinjaman, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}</td>
                                <td><span class="badge badge-warning">{{ $p->status }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Anda tidak memiliki pinjaman aktif</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tabung --}}
    <dialog id="modalTabung" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Tabung Uang</h3>
            <form method="POST" action="{{ route('tabung.simpan') }}" class="mt-4">
                @csrf
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Jumlah Tabungan (Rp)</span></label>
                    <input type="number" name="jumlah_tabungan" class="input input-bordered w-full" min="1" required>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn" onclick="modalTabung.close()">Batal</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Modal Ambil --}}
    <dialog id="modalAmbil" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Ambil Uang</h3>
            <form method="POST" action="{{ route('ambil.uang') }}" class="mt-4">
                @csrf
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Jumlah Penarikan (Rp)</span></label>
                    <input type="number" name="jumlah_penarikan" class="input input-bordered w-full" min="1" required>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-error">Ambil</button>
                    <button type="button" class="btn" onclick="modalAmbil.close()">Batal</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Modal Pinjam --}}
    <dialog id="modalPinjam" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Ajukan Pinjaman</h3>
            <form method="POST" action="{{ route('pinjam.ajukan') }}" class="mt-4">
                @csrf
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Jumlah Pinjaman (Rp)</span></label>
                    <input type="number" name="jumlah_pinjaman" class="input input-bordered w-full" min="1" required>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-warning">Ajukan</button>
                    <button type="button" class="btn" onclick="modalPinjam.close()">Batal</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Modal Bayar --}}
    <dialog id="modalBayar" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Bayar Pinjaman</h3>
            <form method="POST" action="{{ route('bayar.pinjaman') }}" class="mt-4">
                @csrf
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Pilih Pinjaman</span></label>
                    <select name="pinjaman_id" class="select select-bordered w-full" required>
                        <option value="" disabled selected>-- Pilih Pinjaman --</option>
                        @foreach($pinjamanAktif as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->tanggal }} - Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Jumlah Pembayaran (Rp)</span></label>
                    <input type="number" name="jumlah_pembayaran" class="input input-bordered w-full" min="1" required>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-info">Bayar</button>
                    <button type="button" class="btn" onclick="modalBayar.close()">Batal</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
</x-layout>
