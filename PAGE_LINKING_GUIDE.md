# 🔗 PAGE LINKING & NAVIGATION GUIDE

## 1. NAVIGATION ARCHITECTURE

### Main Navigation Flow
```
┌─────────────────────────────────────────────────────────────┐
│                      HEADER/NAVBAR                           │
│  [Logo]  [Menu]  [Simpanan] [Tabungan] [Pinjaman] [Profil]  │
│  [Dashboard] [Logout]                                       │
└──────────────────────────────────────┬──────────────────────┘
                                       │
                                   Breadcrumb
                                       │
                    ┌──────────────────┼──────────────────┐
                    │                  │                  │
            [Content Area]      [Sidebar (optional)] [Footer]
```

---

## 2. HALAMAN-HALAMAN YANG PERLU DIKONEKSI

### A. AUTHENTICATION FLOW

#### 1. Landing Page (welcome.blade.php)
**Tujuan:** Entry point aplikasi
- **Link Masuk:**
  - Dari URL langsung: `/`
- **Link Keluar:**
  - Jika sudah login → [Dashboard Link] → `/dashboard`
  - Jika belum → [Login Link] → `/login`
  - Jika belum → [Register Link] → `/register`
- **Navbar:** Login | Register (jika guest)
- **Navbar:** Dashboard | Logout (jika auth)

```html
@auth
  <a href="{{ route('dashboard') }}" class="btn">Go to Dashboard</a>
@else
  <a href="{{ route('login') }}" class="btn">Login</a>
  <a href="{{ route('register') }}" class="btn">Register</a>
@endauth
```

---

#### 2. Register Page (resources/views/auth/register.blade.php) ✓
**Tujuan:** Registrasi user baru
**Status:** ✅ SUDAH ADA
- **Link Masuk:**
  - Dari Landing → `{{ route('register') }}`
  - Dari Login → Link "Belum punya akun? Daftar di sini"
- **Link Keluar (After Register):**
  - Success → Redirect ke `/dashboard` atau `/login`
  - Submit form → `POST /register` → Controller handle
- **Navbar:** Back to Login
- **Form Submit:** Register button

```html
<!-- Di register.blade.php -->
<form action="{{ route('register') }}" method="POST">
  @csrf
  <!-- form fields -->
  <button type="submit">Buat Akun</button>
</form>

<!-- Link ke login -->
<a href="{{ route('login') }}">Sudah punya akun? Masuk di sini</a>
```

---

#### 3. Login Page (resources/views/auth/login.blade.php)
**Tujuan:** Login user
- **Link Masuk:**
  - Dari Landing → `{{ route('login') }}`
  - Dari Register → Link "Sudah punya akun? Login"
- **Link Keluar (After Login):**
  - Success → Redirect ke `/dashboard`
  - Form submit → `POST /login` → Middleware Auth
- **Navbar:** Back to Register
- **Form:** Username/Email, Password, Remember Me

```html
<!-- Di login.blade.php -->
<form action="{{ route('login') }}" method="POST">
  @csrf
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Masuk</button>
</form>

<!-- Link ke register -->
<a href="{{ route('register') }}">Belum punya akun? Daftar di sini</a>
```

---

### B. MAIN DASHBOARD & MENU

#### 4. Dashboard (resources/views/pages/dashboard.blade.php / dashboard/index.blade.php)
**Tujuan:** Ringkasan & quick access ke semua modul
- **Link Masuk:**
  - Dari Landing (auth) → `{{ route('dashboard') }}`
  - Dari Login success → Redirect ke dashboard
  - Dari mana saja → Navbar "Dashboard" link
- **Link Keluar:**
  - [Simpanan] → `/simpanan` (index)
  - [Tabungan] → `/tabungan` (index)
  - [Pinjaman] → `/pinjaman` (index)
  - [Profil] → `/profil`
  - [Logout] → POST `/logout`

```html
<!-- Di dashboard.blade.php -->
<div class="dashboard-grid">
  <!-- Card 1: Simpanan -->
  <a href="{{ route('simpanan.index') }}" class="card">
    <h3>Simpanan</h3>
    <p>Total: Rp {{ $totalSimpanan ?? 0 }}</p>
  </a>

  <!-- Card 2: Tabungan -->
  <a href="{{ route('tabungan.index') }}" class="card">
    <h3>Tabungan</h3>
    <p>Saldo: Rp {{ $totalSaldo ?? 0 }}</p>
  </a>

  <!-- Card 3: Pinjaman -->
  <a href="{{ route('pinjaman.index') }}" class="card">
    <h3>Pinjaman</h3>
    <p>Aktif: {{ $pinjamanAktif ?? 0 }}</p>
  </a>

  <!-- Card 4: Profil -->
  <a href="{{ route('profil') }}" class="card">
    <h3>Profil</h3>
    <p>Lihat Data Pribadi</p>
  </a>
</div>

<!-- Navbar -->
<nav class="navbar">
  <a href="{{ route('dashboard') }}">Dashboard</a>
  <a href="{{ route('simpanan.index') }}">Simpanan</a>
  <a href="{{ route('tabungan.index') }}">Tabungan</a>
  <a href="{{ route('pinjaman.index') }}">Pinjaman</a>
  <a href="{{ route('profil') }}">Profil</a>
  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</nav>
```

---

### C. SIMPANAN MODULE

#### 5. Simpanan - Index (resources/views/simpanan/index.blade.php)
**Tujuan:** Daftar simpanan user
- **Link Masuk:**
  - Dari Dashboard → `{{ route('simpanan.index') }}`
  - Dari Navbar → Simpanan menu
- **Link Keluar:**
  - [+ Tambah Simpanan] → `{{ route('simpanan.create') }}`
  - [Lihat Detail] → `{{ route('simpanan.show', $simpanan->id) }}`
  - [Back to Dashboard] → `{{ route('dashboard') }}`

```html
<!-- Di simpanan/index.blade.php -->
<div class="page-header">
  <h1>Data Simpanan</h1>
  <a href="{{ route('simpanan.create') }}" class="btn btn-primary">+ Tambah Simpanan</a>
</div>

<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($simpanan as $item)
        <tr>
          <td>{{ $item->kode_simpanan }}</td>
          <td>{{ ucfirst($item->jenis_simpanan) }}</td>
          <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
          <td>{{ $item->tanggal_simpan->format('d/m/Y') }}</td>
          <td>
            <a href="{{ route('simpanan.show', $item->id) }}" class="btn btn-sm">Lihat</a>
            <a href="{{ route('simpanan.edit', $item->id) }}" class="btn btn-sm">Edit</a>
            <a href="{{ route('simpanan.destroy', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="summary">
  <p><strong>Total Simpanan:</strong> Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</p>
</div>

<a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali ke Dashboard</a>
```

---

#### 6. Simpanan - Create Form (resources/views/simpanan/create.blade.php)
**Tujuan:** Form buat simpanan baru
- **Link Masuk:**
  - Dari Index → [+ Tambah Simpanan]
  - From Dashboard → [+ Simpanan]
- **Link Keluar:**
  - [Simpan] → POST `/simpanan` → Redirect ke Index
  - [Cancel] → Back ke Index
  - [Back] → `{{ route('simpanan.index') }}`

```html
<!-- Di simpanan/create.blade.php -->
<div class="page-header">
  <h1>Tambah Simpanan Baru</h1>
</div>

<form action="{{ route('simpanan.store') }}" method="POST" class="form">
  @csrf
  
  <div class="form-group">
    <label for="jenis_simpanan">Jenis Simpanan</label>
    <select name="jenis_simpanan" id="jenis_simpanan" required>
      <option value="">-- Pilih Jenis --</option>
      <option value="pokok">Simpanan Pokok</option>
      <option value="wajib">Simpanan Wajib</option>
      <option value="sukarela">Simpanan Sukarela</option>
    </select>
  </div>

  <div class="form-group">
    <label for="jumlah">Jumlah (Rp)</label>
    <input type="number" name="jumlah" id="jumlah" placeholder="0" required>
  </div>

  <div class="form-group">
    <label for="tanggal_simpan">Tanggal Simpan</label>
    <input type="date" name="tanggal_simpan" id="tanggal_simpan" value="{{ date('Y-m-d') }}" required>
  </div>

  <div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" rows="3" placeholder="Optional"></textarea>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
```

---

#### 7. Simpanan - Show (resources/views/simpanan/show.blade.php)
**Tujuan:** Detail simpanan
- **Link:**
  - Back → `{{ route('simpanan.index') }}`
  - Edit → `{{ route('simpanan.edit', $simpanan->id) }}`

```html
<!-- Di simpanan/show.blade.php -->
<div class="page-header">
  <h1>Detail Simpanan</h1>
  <a href="{{ route('simpanan.edit', $simpanan->id) }}" class="btn btn-primary">Edit</a>
</div>

<div class="detail-card">
  <div class="row">
    <div class="col">
      <p><strong>Kode:</strong> {{ $simpanan->kode_simpanan }}</p>
      <p><strong>Jenis:</strong> {{ ucfirst($simpanan->jenis_simpanan) }}</p>
      <p><strong>Jumlah:</strong> Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</p>
      <p><strong>Tanggal:</strong> {{ $simpanan->tanggal_simpan->format('d/m/Y') }}</p>
      <p><strong>Keterangan:</strong> {{ $simpanan->keterangan }}</p>
    </div>
  </div>
</div>

<a href="{{ route('simpanan.index') }}" class="btn btn-secondary">← Kembali ke List</a>
```

---

### D. TABUNGAN MODULE

#### 8. Tabungan - Index (resources/views/tabungan/index.blade.php)
**Tujuan:** Daftar rekening tabungan
- **Link:**
  - [+ Buat Rekening] → `{{ route('tabungan.create') }}`
  - [Lihat Detail] → `{{ route('tabungan.show', $tabungan->id) }}`
  - [Back] → `{{ route('dashboard') }}`

```html
<!-- Di tabungan/index.blade.php -->
<div class="page-header">
  <h1>Rekening Tabungan</h1>
  <a href="{{ route('tabungan.create') }}" class="btn btn-primary">+ Buat Rekening</a>
</div>

<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>No. Rekening</th>
        <th>Saldo</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tabungan as $item)
        <tr>
          <td>{{ $item->no_rekening }}</td>
          <td>Rp {{ number_format($item->saldo, 2, ',', '.') }}</td>
          <td>
            <span class="badge {{ $item->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
              {{ ucfirst($item->status) }}
            </span>
          </td>
          <td>
            <a href="{{ route('tabungan.show', $item->id) }}" class="btn btn-sm">Lihat</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="summary">
  <p><strong>Total Saldo:</strong> Rp {{ number_format($totalSaldo, 2, ',', '.') }}</p>
</div>

<a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali ke Dashboard</a>
```

---

#### 9. Tabungan - Create (resources/views/tabungan/create.blade.php)
**Tujuan:** Form buat rekening baru
- **Link:**
  - Form Submit → `/tabungan` POST → Index
  - Cancel → `{{ route('tabungan.index') }}`

```html
<!-- Di tabungan/create.blade.php -->
<div class="page-header">
  <h1>Buat Rekening Tabungan Baru</h1>
</div>

<form action="{{ route('tabungan.store') }}" method="POST" class="form">
  @csrf
  
  <div class="form-group">
    <label for="saldo_awal">Saldo Awal (Rp)</label>
    <input type="number" name="saldo_awal" id="saldo_awal" step="0.01" required>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Buat Rekening</button>
    <a href="{{ route('tabungan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
```

---

#### 10. Tabungan - Show (resources/views/tabungan/show.blade.php)
**Tujuan:** Detail rekening + history transaksi + aksi setor/tarik
- **Link:**
  - [Setor] → Form POST `/tabungan/{id}/setor`
  - [Tarik] → Form POST `/tabungan/{id}/tarik`
  - [Back] → `{{ route('tabungan.index') }}`

```html
<!-- Di tabungan/show.blade.php -->
<div class="page-header">
  <h1>Detail Rekening</h1>
</div>

<div class="detail-card">
  <div class="row">
    <div class="col-md-6">
      <p><strong>No. Rekening:</strong> {{ $tabungan->no_rekening }}</p>
      <p><strong>Saldo:</strong> <span class="text-success">Rp {{ number_format($tabungan->saldo, 2, ',', '.') }}</span></p>
      <p><strong>Status:</strong> {{ ucfirst($tabungan->status) }}</p>
    </div>
    <div class="col-md-6">
      <!-- Action Buttons -->
      <button class="btn btn-success" data-toggle="modal" data-target="#setorModal">Setor Uang</button>
      <button class="btn btn-warning" data-toggle="modal" data-target="#tarikModal">Tarik Uang</button>
    </div>
  </div>
</div>

<!-- Modal Setor -->
<div class="modal" id="setorModal">
  <form action="{{ route('tabungan.setor', $tabungan->id) }}" method="POST">
    @csrf
    <div class="modal-header">
      <h5>Setor Uang</h5>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label>Jumlah Setor (Rp)</label>
        <input type="number" name="jumlah" step="0.01" required>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Setor</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </div>
  </form>
</div>

<!-- Modal Tarik -->
<div class="modal" id="tarikModal">
  <form action="{{ route('tabungan.tarik', $tabungan->id) }}" method="POST">
    @csrf
    <div class="modal-header">
      <h5>Tarik Uang</h5>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label>Jumlah Tarik (Rp)</label>
        <input type="number" name="jumlah" step="0.01" required>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Tarik</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </div>
  </form>
</div>

<!-- Tabel Mutasi -->
<div class="mt-5">
  <h3>Riwayat Transaksi</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Saldo Sebelum</th>
        <th>Saldo Sesudah</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($mutasi as $m)
        <tr>
          <td>{{ ucfirst($m->jenis) }}</td>
          <td>Rp {{ number_format($m->jumlah, 2, ',', '.') }}</td>
          <td>Rp {{ number_format($m->saldo_sebelum, 2, ',', '.') }}</td>
          <td>Rp {{ number_format($m->saldo_sesudah, 2, ',', '.') }}</td>
          <td>{{ $m->tanggal_transaksi->format('d/m/Y H:i') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $mutasi->links() }}
</div>

<a href="{{ route('tabungan.index') }}" class="btn btn-secondary">← Kembali ke List</a>
```

---

### E. PINJAMAN MODULE

#### 11. Pinjaman - Index (resources/views/pinjaman/index.blade.php)
**Tujuan:** Daftar pinjaman user
- **Link:**
  - [+ Ajukan Pinjaman] → `{{ route('pinjaman.create') }}`
  - [Lihat Detail] → `{{ route('pinjaman.show', $pinjaman->id) }}`
  - [Back] → `{{ route('dashboard') }}`

```html
<!-- Di pinjaman/index.blade.php -->
<div class="page-header">
  <h1>Data Pinjaman</h1>
  <a href="{{ route('pinjaman.create') }}" class="btn btn-primary">+ Ajukan Pinjaman</a>
</div>

<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Jumlah</th>
        <th>Tenor</th>
        <th>Status</th>
        <th>Sisa</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pinjaman as $item)
        <tr>
          <td>{{ $item->kode_pinjaman }}</td>
          <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
          <td>{{ $item->tenor_bulan }} bulan</td>
          <td>
            <span class="badge badge-{{ $item->status === 'disetujui' ? 'success' : ($item->status === 'menunggu' ? 'warning' : 'danger') }}">
              {{ ucfirst($item->status) }}
            </span>
          </td>
          <td>Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}</td>
          <td>
            <a href="{{ route('pinjaman.show', $item->id) }}" class="btn btn-sm">Lihat</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{ $pinjaman->links() }}

<a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali ke Dashboard</a>
```

---

#### 12. Pinjaman - Create (resources/views/pinjaman/create.blade.php)
**Tujuan:** Form pengajuan pinjaman
- **Link:**
  - Form Submit → `/pinjaman` POST → Show page
  - Cancel → `{{ route('pinjaman.index') }}`

```html
<!-- Di pinjaman/create.blade.php -->
<div class="page-header">
  <h1>Ajukan Pinjaman</h1>
</div>

<form action="{{ route('pinjaman.store') }}" method="POST" class="form">
  @csrf
  
  <div class="form-group">
    <label for="jumlah_pinjaman">Jumlah Pinjaman (Rp)</label>
    <input type="number" name="jumlah_pinjaman" id="jumlah_pinjaman" required>
  </div>

  <div class="form-group">
    <label for="bunga_persen">Bunga (%)</label>
    <input type="number" name="bunga_persen" id="bunga_persen" step="0.01" required>
  </div>

  <div class="form-group">
    <label for="tenor_bulan">Tenor (Bulan)</label>
    <input type="number" name="tenor_bulan" id="tenor_bulan" required>
  </div>

  <div class="form-group">
    <label for="tujuan_pinjaman">Tujuan Pinjaman</label>
    <input type="text" name="tujuan_pinjaman" id="tujuan_pinjaman">
  </div>

  <div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" rows="3"></textarea>
  </div>

  <!-- Preview Kalkulasi -->
  <div id="preview" class="alert alert-info" style="display: none;">
    <p><strong>Preview Kalkulasi:</strong></p>
    <p>Total Bunga: <span id="prev_bunga">0</span></p>
    <p>Total Bayar: <span id="prev_total">0</span></p>
    <p>Angsuran/Bulan: <span id="prev_angsuran">0</span></p>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Ajukan</button>
    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>

<script>
// Real-time calculation preview
const jumlah = document.getElementById('jumlah_pinjaman');
const bunga = document.getElementById('bunga_persen');
const tenor = document.getElementById('tenor_bulan');
const preview = document.getElementById('preview');

function updatePreview() {
  const j = parseFloat(jumlah.value) || 0;
  const b = parseFloat(bunga.value) || 0;
  const t = parseInt(tenor.value) || 1;

  if (j > 0 && t > 0) {
    const totalBunga = (j * b * t) / 100;
    const totalBayar = j + totalBunga;
    const angsuran = totalBayar / t;

    document.getElementById('prev_bunga').textContent = 'Rp ' + totalBunga.toLocaleString('id-ID');
    document.getElementById('prev_total').textContent = 'Rp ' + totalBayar.toLocaleString('id-ID');
    document.getElementById('prev_angsuran').textContent = 'Rp ' + angsuran.toLocaleString('id-ID');
    preview.style.display = 'block';
  }
}

jumlah.addEventListener('input', updatePreview);
bunga.addEventListener('input', updatePreview);
tenor.addEventListener('input', updatePreview);
</script>
```

---

#### 13. Pinjaman - Show (resources/views/pinjaman/show.blade.php)
**Tujuan:** Detail pinjaman + cicilan history + tombol bayar
- **Link:**
  - [Bayar Cicilan] → Modal/redirect to bayar-pinjaman/create
  - [Approve] (Admin) → POST `/pinjaman/{id}/approve`
  - [Reject] (Admin) → POST `/pinjaman/{id}/reject`
  - [Back] → `{{ route('pinjaman.index') }}`

```html
<!-- Di pinjaman/show.blade.php -->
<div class="page-header">
  <h1>Detail Pinjaman</h1>
  @if(auth()->user()->is_admin && $pinjaman->status === 'menunggu')
    <form action="{{ route('pinjaman.approve', $pinjaman->id) }}" method="POST" style="display: inline;">
      @csrf
      <button class="btn btn-success">Approve</button>
    </form>
    <form action="{{ route('pinjaman.reject', $pinjaman->id) }}" method="POST" style="display: inline;">
      @csrf
      <button class="btn btn-danger">Reject</button>
    </form>
  @endif
</div>

<div class="detail-card">
  <div class="row">
    <div class="col-md-6">
      <p><strong>Kode:</strong> {{ $pinjaman->kode_pinjaman }}</p>
      <p><strong>Jumlah Pinjaman:</strong> Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
      <p><strong>Bunga:</strong> {{ $pinjaman->bunga_persen }}%</p>
      <p><strong>Tenor:</strong> {{ $pinjaman->tenor_bulan }} bulan</p>
      <p><strong>Angsuran/Bulan:</strong> Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</p>
    </div>
    <div class="col-md-6">
      <p><strong>Total Bayar:</strong> Rp {{ number_format($pinjaman->total_bayar, 0, ',', '.') }}</p>
      <p><strong>Sisa Pinjaman:</strong> <span class="text-danger">Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</span></p>
      <p><strong>Status:</strong> <span class="badge">{{ ucfirst($pinjaman->status) }}</span></p>
      <p><strong>Tujuan:</strong> {{ $pinjaman->tujuan_pinjaman ?? '-' }}</p>
    </div>
  </div>
</div>

@if(in_array($pinjaman->status, ['disetujui', 'aktif']))
  <a href="{{ route('bayar-pinjaman.create', ['pinjaman_id' => $pinjaman->id]) }}" class="btn btn-primary">+ Bayar Cicilan</a>
@endif

<div class="mt-5">
  <h3>Riwayat Pembayaran</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Kode Bayar</th>
        <th>Ke</th>
        <th>Jumlah</th>
        <th>Pokok</th>
        <th>Bunga</th>
        <th>Sisa</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pinjaman->pembayaran as $bayar)
        <tr>
          <td>{{ $bayar->kode_bayar }}</td>
          <td>{{ $bayar->ke_angsuran }}</td>
          <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($bayar->pokok_bayar, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($bayar->bunga_bayar, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($bayar->sisa_setelah_bayar, 0, ',', '.') }}</td>
          <td>{{ $bayar->tanggal_bayar->format('d/m/Y') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center">Belum ada pembayaran</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">← Kembali ke List</a>
```

---

#### 14. Bayar Pinjaman - Create (resources/views/bayar-pinjaman/create.blade.php)
**Tujuan:** Form pembayaran cicilan
- **Link:**
  - Form Submit → `/bayar-pinjaman` POST → Detail pinjaman
  - Cancel → `{{ route('pinjaman.show', $pinjaman->id) }}`

```html
<!-- Di bayar-pinjaman/create.blade.php -->
<div class="page-header">
  <h1>Bayar Cicilan Pinjaman</h1>
</div>

<div class="detail-card mb-4">
  <p><strong>Kode Pinjaman:</strong> {{ $pinjaman->kode_pinjaman }}</p>
  <p><strong>Sisa Pinjaman:</strong> Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</p>
  <p><strong>Angsuran Normal:</strong> Rp {{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}</p>
  <p><strong>Jumlah Cicilan Terbayar:</strong> {{ count($pinjaman->pembayaran) }}</p>
</div>

<form action="{{ route('bayar-pinjaman.store') }}" method="POST" class="form">
  @csrf
  
  <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">

  <div class="form-group">
    <label for="jumlah_bayar">Jumlah Bayar (Rp)</label>
    <input type="number" name="jumlah_bayar" id="jumlah_bayar" 
           value="{{ $pinjaman->angsuran_per_bulan }}" 
           max="{{ $pinjaman->sisa_pinjaman }}"
           step="0.01" required>
    <small>Max: Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</small>
  </div>

  <div class="form-group">
    <label for="metode_bayar">Metode Pembayaran</label>
    <select name="metode_bayar" id="metode_bayar" required>
      <option value="">-- Pilih Metode --</option>
      <option value="tunai">Tunai</option>
      <option value="transfer">Transfer</option>
      <option value="debit">Kartu Debit</option>
    </select>
  </div>

  <div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" rows="2"></textarea>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Bayar</button>
    <a href="{{ route('pinjaman.show', $pinjaman->id) }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
```

---

#### 15. Bayar Pinjaman - Index (resources/views/bayar-pinjaman/index.blade.php)
**Tujuan:** Daftar semua pembayaran cicilan
- **Link:**
  - Detail → `{{ route('bayar-pinjaman.show', $bayar->id) }}`
  - Back → `{{ route('dashboard') }}`

```html
<!-- Di bayar-pinjaman/index.blade.php -->
<div class="page-header">
  <h1>Riwayat Pembayaran Cicilan</h1>
</div>

<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>Kode Bayar</th>
        <th>Pinjaman</th>
        <th>Cicilan Ke</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bayarPinjaman as $item)
        <tr>
          <td>{{ $item->kode_bayar }}</td>
          <td>{{ $item->pinjaman->kode_pinjaman }}</td>
          <td>{{ $item->ke_angsuran }}</td>
          <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
          <td>{{ $item->tanggal_bayar->format('d/m/Y') }}</td>
          <td>Terbayar</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{ $bayarPinjaman->links() }}

<a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali ke Dashboard</a>
```

---

## 3. NAVIGATION MAP (Visual)

```
                          ┌─────────────────────────────────┐
                          │   START: Landing (/)             │
                          │   - Login → /login               │
                          │   - Register → /register         │
                          └────────────┬────────────────────┘
                                       │
                    ┌──────────────────┴──────────────────┐
                    │                                     │
            ┌───────▼────────┐                  ┌────────▼────────┐
            │ LOGIN (/login) │                  │ REGISTER (/reg) │
            └───────┬────────┘                  └────────┬────────┘
                    │ Success                           │ Success
                    └──────────────┬────────────────────┘
                                   │
                        ┌──────────▼──────────┐
                        │ DASHBOARD (/)       │
                        │ - Quick Access Btn  │
                        └──┬─┬─┬─┬──────┬────┘
                       /│  │ │ │  └─────┘ \
                   /───  │  │ │           ────\
                  │      │  │ │                 │
        ┌─────────▼┐  ┌──▼──▼┐ ┌───────┐  ┌────▼─────┐
        │SIMPANAN  │  │TABUNGAN│  │PINJAMAN│ │ PROFIL  │
        │ /simpanan│  │/tabu   │  │/pinjam │ │/profil  │
        └─┬───────┬┘  │       │  │        │ └─────────┘
          │       │   └─┬───┬─┘  │        │
          │    ┌──▼─────▼──┐├────▼──────┐
    ┌─────▼──┐ │  DETAIL   ││  PINJAMAN │
    │ CREATE ├─┤ TABUNGAN  ││  DETAIL   │
    │SIMPANAN│ │ + MUTASI  ││           │
    │ FORM   │ └──┬──────┬─┘└─────┬─────┘
    └────────┘   │ SETOR │      │
              ┌──▼──┐ ┌──▼────┐ │
              │TARIK│ │ BAYAR ├─┘
              │FORM │ │ FORM  │
              └─────┘ └───┬───┘
                          │
                   ┌──────▼───────┐
                   │ BAYAR PINJAM │
                   │ (Cicilan)    │
                   └──────────────┘
```

---

## 4. LINKING CHECKLIST

### Routes dalam web.php yang Harus Dikoneksi:

- [ ] GET `/` → Landing page with navbar auth links
- [ ] GET `/login` → Login form
- [ ] GET `/register` → Register form  ✓ (sudah ada)
- [ ] GET `/dashboard` → Dashboard dengan 4 cards (Simpanan, Tabungan, Pinjaman, Profil)
- [ ] GET `/simpanan` → List simpanan dengan link ke create & detail
- [ ] GET `/simpanan/create` → Form create
- [ ] GET `/simpanan/{id}` → Detail
- [ ] GET `/simpanan/{id}/edit` → Edit form
- [ ] GET `/tabungan` → List tabungan dengan link ke create & detail
- [ ] GET `/tabungan/create` → Form create
- [ ] GET `/tabungan/{id}` → Detail + mutasi + modal setor/tarik
- [ ] POST `/tabungan/{id}/setor` → Process setor
- [ ] POST `/tabungan/{id}/tarik` → Process tarik
- [ ] GET `/pinjaman` → List pinjaman dengan link ke create & detail
- [ ] GET `/pinjaman/create` → Form create dengan preview kalkulasi
- [ ] GET `/pinjaman/{id}` → Detail + pembayaran + tombol bayar
- [ ] POST `/pinjaman/{id}/approve` → Admin approve
- [ ] POST `/pinjaman/{id}/reject` → Admin reject
- [ ] GET `/bayar-pinjaman` → List pembayaran
- [ ] GET `/bayar-pinjaman/create` → Form pembayaran (with pinjaman_id param)
- [ ] GET `/profil` → Profile page

---

## 5. NEXT STEPS

1. ✅ Analyze business logic (sudah done)
2. ⏳ **CREATE LAYOUT & NAVBAR** - Base layout dengan navbar yang konsisten
3. ⏳ **BUAT HALAMAN PUBLIC** - Welcome/Landing
4. ⏳ **BUAT AUTH PAGES** - Login (perlu dioptimasi dari register yang sudah ada)
5. ⏳ **BUAT DASHBOARD** - Main hub dengan quick access
6. ⏳ **IMPLEMENT SIMPANAN MODULE** - All CRUD pages
7. ⏳ **IMPLEMENT TABUNGAN MODULE** - All CRUD + transaksi
8. ⏳ **IMPLEMENT PINJAMAN MODULE** - All CRUD + approval + payments
9. ⏳ **LINKING & NAVIGATION** - Connect all pages
10. ⏳ **TEST ALL FLOWS** - UAT

