# 🚀 QUICK IMPLEMENTATION GUIDE

## QUICK START CHECKLIST

### Phase 1: Setup & Layouts ✅ Foundation
- [ ] Create Base Layout (`resources/views/layouts/app.blade.php`)
- [ ] Create Navbar component
- [ ] Create Sidebar (optional)
- [ ] Create Footer component
- [ ] Setup Tailwind CSS utilities

### Phase 2: Authentication 
- [ ] Optimize Login page (`resources/views/auth/login.blade.php`)
- [ ] Register page sudah ada ✓
- [ ] Create Auth Controller with login/register/logout
- [ ] Add Auth middleware to protected routes
- [ ] Add Logout route

### Phase 3: Dashboard & Menu
- [ ] Create Dashboard page (`resources/views/dashboard/index.blade.php`)
- [ ] Add widgets (Total simpanan, saldo tabungan, pinjaman aktif)
- [ ] Quick action buttons to all modules

### Phase 4: Simpanan Module
- [ ] SimpananController - complete all methods
- [ ] Create `resources/views/simpanan/index.blade.php`
- [ ] Create `resources/views/simpanan/create.blade.php`
- [ ] Create `resources/views/simpanan/show.blade.php`
- [ ] Create `resources/views/simpanan/edit.blade.php`
- [ ] Add validation & error handling

### Phase 5: Tabungan Module
- [ ] TabunganController - complete setor/tarik methods
- [ ] Create `resources/views/tabungan/index.blade.php`
- [ ] Create `resources/views/tabungan/create.blade.php`
- [ ] Create `resources/views/tabungan/show.blade.php`
- [ ] Create mutasi views or inline display
- [ ] Add setor/tarik modal forms

### Phase 6: Pinjaman Module
- [ ] PinjamanController - complete approve/reject
- [ ] Create `resources/views/pinjaman/index.blade.php`
- [ ] Create `resources/views/pinjaman/create.blade.php`
- [ ] Create `resources/views/pinjaman/show.blade.php`
- [ ] Add calculation preview on form

### Phase 7: Bayar Pinjaman Module
- [ ] BayarPinjamanController - complete all methods
- [ ] Create `resources/views/bayar-pinjaman/index.blade.php`
- [ ] Create `resources/views/bayar-pinjaman/create.blade.php`
- [ ] Add payment tracking

### Phase 8: Integration & Testing
- [ ] Link all pages with routes
- [ ] Test all CRUD operations
- [ ] Test business logic calculations
- [ ] Test authorization (policies)
- [ ] Test complete user flows

---

## COMMON CODE SNIPPETS

### 1. Navbar/Header Component
```html
<!-- resources/views/components/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="{{ route('dashboard') }}">
    <i class="fas fa-piggy-bank"></i> Koperasi Simpan Pinjam
  </a>
  
  @auth
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('simpanan.index') }}">Simpanan</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('tabungan.index') }}">Tabungan</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('pinjaman.index') }}">Pinjaman</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown">
          {{ auth()->user()->name_panjang }}
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ route('profil') }}">Profil</a>
          <hr class="dropdown-divider">
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button class="dropdown-item" type="submit">Logout</button>
          </form>
        </div>
      </li>
    </ul>
  @else
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
    </ul>
  @endauth
</nav>
```

### 2. Base Layout
```html
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - Koperasi</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  @include('components.navbar')
  
  <div class="container-fluid mt-4">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <strong>Kesalahan!</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')
  </div>

  @include('components.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### 3. Dashboard Page
```blade
<!-- resources/views/dashboard/index.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
  <div class="col-md-12">
    <h1>Selamat Datang, {{ auth()->user()->name_panjang }}</h1>
  </div>
</div>

<!-- Widgets -->
<div class="row">
  <!-- Simpanan Widget -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="card text-white bg-primary">
      <div class="card-body">
        <h5 class="card-title">Total Simpanan</h5>
        <p class="card-text" style="font-size: 1.8rem;">
          Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}
        </p>
        <a href="{{ route('simpanan.index') }}" class="btn btn-sm btn-outline-light">Lihat Detail</a>
      </div>
    </div>
  </div>

  <!-- Tabungan Widget -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="card text-white bg-success">
      <div class="card-body">
        <h5 class="card-title">Saldo Tabungan</h5>
        <p class="card-text" style="font-size: 1.8rem;">
          Rp {{ number_format($totalSaldo ?? 0, 2, ',', '.') }}
        </p>
        <a href="{{ route('tabungan.index') }}" class="btn btn-sm btn-outline-light">Lihat Detail</a>
      </div>
    </div>
  </div>

  <!-- Pinjaman Widget -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="card text-white bg-warning">
      <div class="card-body">
        <h5 class="card-title">Pinjaman Aktif</h5>
        <p class="card-text" style="font-size: 1.8rem;">
          Rp {{ number_format($totalPinjaman ?? 0, 0, ',', '.') }}
        </p>
        <a href="{{ route('pinjaman.index') }}" class="btn btn-sm btn-outline-light">Lihat Detail</a>
      </div>
    </div>
  </div>

  <!-- Profil Widget -->
  <div class="col-md-6 col-lg-3 mb-3">
    <div class="card text-white bg-info">
      <div class="card-body">
        <h5 class="card-title">Profil</h5>
        <p class="card-text">{{ auth()->user()->username }}</p>
        <a href="{{ route('profil') }}" class="btn btn-sm btn-outline-light">Ubah Profil</a>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
  <div class="col-md-12">
    <h3 class="mb-3">Aksi Cepat</h3>
  </div>
  <div class="col-md-3">
    <a href="{{ route('simpanan.create') }}" class="btn btn-primary btn-block w-100 mb-2">
      <i class="fas fa-plus"></i> Simpanan Baru
    </a>
  </div>
  <div class="col-md-3">
    <a href="{{ route('tabungan.create') }}" class="btn btn-success btn-block w-100 mb-2">
      <i class="fas fa-plus"></i> Rekening Baru
    </a>
  </div>
  <div class="col-md-3">
    <a href="{{ route('pinjaman.create') }}" class="btn btn-warning btn-block w-100 mb-2">
      <i class="fas fa-plus"></i> Ajukan Pinjaman
    </a>
  </div>
  <div class="col-md-3">
    <a href="{{ route('bayar-pinjaman.index') }}" class="btn btn-info btn-block w-100 mb-2">
      <i class="fas fa-money-bill"></i> Bayar Cicilan
    </a>
  </div>
</div>
@endsection
```

### 4. List Table Component
```blade
<!-- resources/views/simpanan/index.blade.php -->
@extends('layouts.app')

@section('title', 'Data Simpanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1>Data Simpanan</h1>
  <a href="{{ route('simpanan.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Simpanan
  </a>
</div>

<div class="table-responsive">
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>Kode</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($simpanan as $item)
        <tr>
          <td><strong>{{ $item->kode_simpanan }}</strong></td>
          <td>
            <span class="badge bg-secondary">{{ ucfirst($item->jenis_simpanan) }}</span>
          </td>
          <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
          <td>{{ $item->tanggal_simpan->format('d/m/Y') }}</td>
          <td>
            <a href="{{ route('simpanan.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
            <a href="{{ route('simpanan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('simpanan.destroy', $item->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-muted py-4">
            Belum ada data simpanan. <a href="{{ route('simpanan.create') }}">Buat yang baru</a>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="row mt-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Ringkasan</h5>
        <p class="card-text">
          <strong>Total Simpanan:</strong> 
          <br>Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}
        </p>
      </div>
    </div>
  </div>
</div>

<a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a>
@endsection
```

### 5. Form Create Component
```blade
<!-- resources/views/simpanan/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Simpanan')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <h1 class="mb-4">Tambah Simpanan Baru</h1>

    <div class="card">
      <div class="card-body">
        <form action="{{ route('simpanan.store') }}" method="POST" novalidate>
          @csrf

          <div class="mb-3">
            <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
            <select name="jenis_simpanan" id="jenis_simpanan" class="form-select @error('jenis_simpanan') is-invalid @enderror" required>
              <option value="">-- Pilih Jenis --</option>
              <option value="pokok" {{ old('jenis_simpanan') == 'pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
              <option value="wajib" {{ old('jenis_simpanan') == 'wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
              <option value="sukarela" {{ old('jenis_simpanan') == 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
            </select>
            @error('jenis_simpanan')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" 
                   class="form-control @error('jumlah') is-invalid @enderror"
                   value="{{ old('jumlah') }}"
                   placeholder="0" required>
            @error('jumlah')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="tanggal_simpan" class="form-label">Tanggal Simpan</label>
            <input type="date" name="tanggal_simpan" id="tanggal_simpan"
                   class="form-control @error('tanggal_simpan') is-invalid @enderror"
                   value="{{ old('tanggal_simpan', date('Y-m-d')) }}" required>
            @error('tanggal_simpan')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="form-control @error('keterangan') is-invalid @enderror"
                      placeholder="Opsional">{{ old('keterangan') }}</textarea>
            @error('keterangan')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">
              <i class="fas fa-times"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
```

### 6. Pinjaman dengan Kalkulasi
```blade
<!-- resources/views/pinjaman/create.blade.php -->
@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <h1 class="mb-4">Ajukan Pinjaman</h1>

    <div class="card">
      <div class="card-body">
        <form action="{{ route('pinjaman.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="jumlah_pinjaman" class="form-label">Jumlah Pinjaman (Rp)</label>
            <input type="number" name="jumlah_pinjaman" id="jumlah_pinjaman"
                   class="form-control" placeholder="0" required>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="bunga_persen" class="form-label">Bunga (%/tahun)</label>
                <input type="number" name="bunga_persen" id="bunga_persen"
                       class="form-control" step="0.01" placeholder="0" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="tenor_bulan" class="form-label">Tenor (Bulan)</label>
                <input type="number" name="tenor_bulan" id="tenor_bulan"
                       class="form-control" placeholder="0" required>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="tujuan_pinjaman" class="form-label">Tujuan Pinjaman</label>
            <input type="text" name="tujuan_pinjaman" id="tujuan_pinjaman"
                   class="form-control" placeholder="Contoh: Modal Usaha">
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="form-control"></textarea>
          </div>

          <!-- Preview Kalkulasi -->
          <div id="preview" class="alert alert-info" style="display: none;">
            <h5>Preview Kalkulasi</h5>
            <table class="table table-sm mb-0">
              <tr>
                <td>Jumlah Pinjaman:</td>
                <td class="text-end"><strong id="prev_jumlah">Rp 0</strong></td>
              </tr>
              <tr>
                <td>Total Bunga:</td>
                <td class="text-end"><strong id="prev_bunga">Rp 0</strong></td>
              </tr>
              <tr>
                <td>Total Bayar:</td>
                <td class="text-end"><strong id="prev_total">Rp 0</strong></td>
              </tr>
              <tr>
                <td>Angsuran/Bulan:</td>
                <td class="text-end"><strong id="prev_angsuran">Rp 0</strong></td>
              </tr>
            </table>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
            <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
const jumlah = document.getElementById('jumlah_pinjaman');
const bunga = document.getElementById('bunga_persen');
const tenor = document.getElementById('tenor_bulan');
const preview = document.getElementById('preview');

function formatRupiah(num) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(num);
}

function updatePreview() {
  const j = parseFloat(jumlah.value) || 0;
  const b = parseFloat(bunga.value) || 0;
  const t = parseInt(tenor.value) || 1;

  if (j > 0 && t > 0) {
    const totalBunga = (j * b * t) / 100;
    const totalBayar = j + totalBunga;
    const angsuran = totalBayar / t;

    document.getElementById('prev_jumlah').textContent = formatRupiah(j);
    document.getElementById('prev_bunga').textContent = formatRupiah(totalBunga);
    document.getElementById('prev_total').textContent = formatRupiah(totalBayar);
    document.getElementById('prev_angsuran').textContent = formatRupiah(angsuran);
    preview.style.display = 'block';
  } else {
    preview.style.display = 'none';
  }
}

jumlah.addEventListener('input', updatePreview);
bunga.addEventListener('input', updatePreview);
tenor.addEventListener('input', updatePreview);
</script>
@endsection
```

---

## VALIDATION RULES (In Controller)

### Simpanan
```php
$validated = $request->validate([
    'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
    'jumlah' => 'required|numeric|min:1',
    'tanggal_simpan' => 'required|date|before_or_equal:today',
    'keterangan' => 'nullable|string|max:255',
]);
```

### Tabungan
```php
// Create
$validated = $request->validate([
    'saldo_awal' => 'required|numeric|min:0.01',
]);

// Setor/Tarik
$validated = $request->validate([
    'jumlah' => 'required|numeric|min:0.01',
]);
```

### Pinjaman
```php
$validated = $request->validate([
    'jumlah_pinjaman' => 'required|numeric|min:1',
    'bunga_persen' => 'required|numeric|min:0',
    'tenor_bulan' => 'required|integer|min:1',
    'tujuan_pinjaman' => 'nullable|string|max:255',
    'keterangan' => 'nullable|string|max:255',
]);
```

### Bayar Pinjaman
```php
$validated = $request->validate([
    'pinjaman_id' => 'required|exists:pinjaman,id',
    'jumlah_bayar' => 'required|numeric|min:0.01',
    'metode_bayar' => 'required|in:tunai,transfer,debit',
    'keterangan' => 'nullable|string|max:255',
]);
```

---

## KEY FORMULAS (In Controller)

```php
// Pinjaman Calculation
$totalBunga = ($jumlahPinjaman * $bungaPersen * $tenor) / 100;
$totalBayar = $jumlahPinjaman + $totalBunga;
$angsuranPerBulan = $totalBayar / $tenor;

// Pokok vs Bunga Breakdown
$pokokPerBulan = $jumlahPinjaman / $tenor;
$bungaPerBulan = $totalBunga / $tenor;

// Or if varied:
$pokok = $pembayaran['jumlah'] * ($jumlahPinjaman / $totalBayar);
$bunga = $pembayaran['jumlah'] * ($totalBunga / $totalBayar);
```

---

## DATABASE SEEDING (Optional)

```php
// database/seeders/SimpananSeeder.php
public function run()
{
    $users = User::all();
    
    foreach ($users as $user) {
        Simpanan::create([
            'user_id' => $user->id,
            'kode_simpanan' => 'SMP-' . str_pad(Simpanan::count() + 1, 4, '0', STR_PAD_LEFT),
            'jenis_simpanan' => $this->faker->randomElement(['pokok', 'wajib', 'sukarela']),
            'jumlah' => $this->faker->numberBetween(100000, 5000000),
            'tanggal_simpan' => $this->faker->date(),
        ]);
    }
}
```

---

## TESTING CHECKLIST

### Unit Tests
- [ ] Test pinjaman calculation formula
- [ ] Test tabungan balance updates
- [ ] Test status transitions

### Feature Tests
- [ ] Test create simpanan flow
- [ ] Test setor/tarik tabungan flow
- [ ] Test pinjaman approval flow
- [ ] Test cicilan payment flow
- [ ] Test authorization (can only see own data)

### Integration Tests
- [ ] Full user registration → dashboard → create simpanan → setor
- [ ] Full loan request → approval → payment flow
- [ ] Cross-module data consistency

---

## PERFORMANCE TIPS

1. **Eager Load Relations:**
```php
$pinjaman = Pinjaman::with('user', 'pembayaran')->paginate(10);
```

2. **Cache Totals:**
```php
$totalSimpanan = Cache::remember('user_' . auth()->id() . '_total_simpanan', 3600, function() {
    return Simpanan::where('user_id', auth()->id())->sum('jumlah');
});
```

3. **Index Database Columns:**
- `simpanan.user_id`
- `tabungan.user_id`
- `pinjaman.user_id`
- `bayar_pinjaman.pinjaman_id`

4. **Paginate Large Lists:**
```php
$simpanan = Simpanan::where('user_id', auth()->id())->paginate(15);
```

---

## SECURITY NOTES

1. ✅ All routes protected with `auth` middleware (sudah ada di routes)
2. ✅ Passwords hashed by default in Laravel
3. ⏳ **Add Policies** for fine-grained authorization:
```php
// app/Policies/SimpananPolicy.php
public function view(User $user, Simpanan $simpanan) {
    return $user->id === $simpanan->user_id;
}

public function update(User $user, Simpanan $simpanan) {
    return $user->id === $simpanan->user_id;
}
```

4. ⏳ **Use authorize()** in controllers:
```php
$this->authorize('view', $simpanan);
```

5. ✅ CSRF protection built-in (@csrf in forms)
6. ✅ SQL injection protected by Eloquent ORM

