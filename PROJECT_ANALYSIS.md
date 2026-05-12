# 📊 ANALISIS PROJECT KOPERASI SIMPAN PINJAM

## 1. OVERVIEW PROJECT

**Nama Project:** Sistem Manajemen Koperasi Simpan Pinjam  
**Technology Stack:** Laravel 11 + Blade + Tailwind CSS  
**Database:** MySQL  
**Type:** Web Application untuk manajemen keuangan anggota koperasi

---

## 2. LOGIKA BISNIS UTAMA

### A. **Manajemen Anggota (User)**
- Setiap pengguna adalah anggota koperasi
- Anggota dapat login/register untuk mengakses sistem
- Data anggota disimpan dengan nama lengkap, username, email, dan password

**Fields User:**
- `name_panjang` - Nama lengkap anggota
- `username` - Username unik untuk login
- `email` - Email anggota
- `password` - Password terenkripsi

---

### B. **SIMPANAN (Wajib/Pokok/Sukarela)**
Simpanan adalah dana yang disimpan anggota ke koperasi

**Jenis Simpanan:**
1. **Simpanan Pokok** - Harus disetor saat pendaftaran (Mandatory)
2. **Simpanan Wajib** - Dibayar secara berkala/rutin
3. **Simpanan Sukarela** - Sesuai keinginan anggota

**Logika Bisnis:**
- Setiap simpanan tercatat dengan kode unik (SMP-XXXX)
- Data simpanan: jumlah, tanggal, jenis, keterangan
- Semua simpanan anggota dipantau melalui dashboard
- Total simpanan anggota dihitung dari semua jenis simpanan

**Proses:**
1. Anggota membuat simpanan → Form Create Simpanan
2. Validasi jumlah & jenis simpanan
3. Generate kode simpanan otomatis
4. Simpan ke database
5. Tampilkan di list dengan total perhitungan

---

### C. **TABUNGAN (Rekening Tabungan)**
Tabungan adalah rekening untuk menyimpan dana dengan kemampuan setor/tarik

**Logika Bisnis:**
- 1 anggota bisa memiliki banyak rekening tabungan
- Setiap tabungan memiliki nomor rekening unik (REK-XXXX)
- Tabungan memiliki status: aktif/nonaktif
- Saldo dapat berubah dari operasi setor & tarik

**Operasi pada Tabungan:**
1. **CREATE REKENING** - Buat rekening baru dengan saldo awal
2. **SETOR (Deposit)** - Tambah saldo
   - Validasi: jumlah > 0
   - Update saldo
   - Catat mutasi transaksi
3. **TARIK (Withdrawal)** - Kurangi saldo
   - Validasi: saldo cukup, jumlah > 0
   - Update saldo
   - Catat mutasi transaksi

**Mutasi Tabungan:**
- Setiap transaksi setor/tarik dicatat sebagai mutasi
- Mutasi berisi: jenis (setor/tarik), jumlah, saldo sebelum, saldo sesudah, tanggal, keterangan
- Anggota bisa melihat riwayat mutasi

---

### D. **PINJAMAN**
Pinjaman adalah dana yang dipinjamkan kepada anggota dengan sistem cicilan

**Logika Bisnis Pinjaman:**

**Tahap 1: PENGAJUAN PINJAMAN**
```
Input oleh Anggota:
- Jumlah pinjaman (principal)
- Bunga persen (interest rate)
- Tenor bulan (duration)
- Tujuan pinjaman
- Keterangan

Kalkulasi Otomatis:
- Total Bunga = (Jumlah × Bunga% × Tenor) / 100
- Total Bayar = Jumlah + Total Bunga
- Angsuran Per Bulan = Total Bayar / Tenor
- Sisa Pinjaman = Total Bayar (inisial)
- Status = "menunggu"
```

**Contoh Kalkulasi:**
```
Pinjam: Rp 10.000.000
Bunga: 3% per tahun
Tenor: 12 bulan

Total Bunga = (10.000.000 × 3 × 12) / 100 = Rp 3.600.000
Total Bayar = 10.000.000 + 3.600.000 = Rp 13.600.000
Angsuran/Bulan = 13.600.000 / 12 = Rp 1.133.333

Kode Pinjaman = PIN-XXXX (otomatis)
Tanggal Pengajuan = hari ini
```

**Tahap 2: APPROVAL/REJECTION**
- Admin review pengajuan pinjaman
- Bisa approve (status = "disetujui", set tanggal approval)
- Bisa reject (status = "ditolak")

**Tahap 3: CICILAN/ANGSURAN**
- Anggota mulai membayar angsuran tiap bulan
- Setiap pembayaran mencakup: pokok + bunga
- Status pinjaman berubah menjadi "aktif" saat ada pembayaran pertama

---

### E. **BAYAR PINJAMAN (Pembayaran Cicilan)**
Pencatatan pembayaran angsuran pinjaman

**Logika Bisnis:**
```
Saat Pembayaran ke-N:
- Ke_angsuran = nomor cicilan ke berapa (1, 2, 3, ...)
- Jumlah Bayar = angsuran yang dibayarkan
- Pokok Bayar = bagian pokok dari jumlah bayar
- Bunga Bayar = bagian bunga dari jumlah bayar
- Sisa Setelah Bayar = sisa pinjaman total setelah pembayaran
- Kode Bayar = BYR-XXXX (otomatis)
- Metode Bayar = tunai/transfer/etc
- Tanggal Bayar = hari pembayaran
```

**Proses Pembayaran:**
1. Anggota membuat pembayaran
2. Validasi pinjaman masih aktif & ada sisa
3. Hitung breakdown pokok & bunga
4. Catat sebagai bayar_pinjaman
5. Update sisa_pinjaman di table pinjaman
6. Jika sisa = 0, pinjaman LUNAS

---

## 3. RELASI DATA (Entity Relationship)

```
┌─────────────────────────────────────────────────────────┐
│                         USER                             │
│  (Anggota Koperasi)                                      │
│  - id, name_panjang, username, email, password           │
└────────────────────┬────────────────────────────────────┘
                     │ 1:M (one to many)
        ┌────────────┼────────────┬─────────────┐
        │            │            │             │
   SIMPANAN    TABUNGAN      PINJAMAN   BAYAR_PINJAMAN
        │            │            │             │
   (SMP-XXXX)  (REK-XXXX)  (PIN-XXXX)     (BYR-XXXX)
        │            │            │             │
        │            │            └──────┬──────┘
        │            │                   │
        │       MUTASI_TABUNGAN     PINJAMAN
        │       (History)           (Parent)
        │
    Fields:        Fields:         Fields:
    - jenis        - no_rekening   - kode_pinjaman
    - jumlah       - saldo         - jumlah_pinjaman
    - tanggal      - status        - bunga_persen
    - keterangan   - mutasi[]      - tenor_bulan
                                   - angsuran_per_bulan
                                   - total_bayar
                                   - sisa_pinjaman
                                   - status
                                   - pembayaran[]
```

---

## 4. USER FLOWS & BUSINESS PROCESSES

### FLOW 1: Registrasi & Login
```
┌─────────────┐
│   Visitor   │
└──────┬──────┘
       │
       ├─→ [Register] → Input nama, username, password
       │   └─→ Create User → Dashboard
       │
       └─→ [Login] → Input username, password
           └─→ Authenticate → Dashboard
```

### FLOW 2: Manajemen Simpanan
```
┌──────────────┐
│ Anggota      │
│ Login        │
└──────┬───────┘
       │
       └─→ [Simpanan] Menu
           │
           ├─→ [List Simpanan] ← View semua simpanan + total
           │   │
           │   └─→ [Detail] ← Lihat detail 1 simpanan
           │
           └─→ [Tambah Simpanan] ← Form buat simpanan baru
               ├─ Input: jenis (pokok/wajib/sukarela)
               ├─ Input: jumlah
               ├─ Input: tanggal simpan
               ├─ Input: keterangan (optional)
               └─ Generate: kode simpanan (SMP-XXXX)
                   └─ Save → Redirect ke list
```

### FLOW 3: Manajemen Tabungan
```
┌──────────────┐
│ Anggota      │
│ Login        │
└──────┬───────┘
       │
       └─→ [Tabungan] Menu
           │
           ├─→ [List Rekening] ← View semua rekening + total saldo
           │   │
           │   └─→ [Detail Rekening] ← Lihat detail + mutasi
           │       │
           │       ├─→ [Setor Uang] ← Form setor
           │       │   ├─ Input jumlah
           │       │   └─ Proses: saldo += jumlah, catat mutasi
           │       │
           │       └─→ [Tarik Uang] ← Form tarik
           │           ├─ Validasi: saldo >= jumlah?
           │           └─ Proses: saldo -= jumlah, catat mutasi
           │
           └─→ [Buat Rekening] ← Form buat rekening baru
               ├─ Input: saldo awal
               ├─ Generate: no_rekening (REK-XXXX)
               └─ Status: aktif
```

### FLOW 4: Manajemen Pinjaman (Anggota)
```
┌──────────────┐
│ Anggota      │
│ Login        │
└──────┬───────┘
       │
       └─→ [Pinjaman] Menu
           │
           ├─→ [List Pinjaman] ← View semua pinjaman (pending/approved/rejected)
           │   │
           │   └─→ [Detail Pinjaman] ← Detail + riwayat bayar
           │       │
           │       └─→ [Bayar Cicilan] ← Form pembayaran
           │           ├─ Input: jumlah bayar
           │           ├─ Input: metode bayar
           │           └─ Proses: 
           │               ├─ Hitung pokok & bunga breakdown
           │               ├─ Catat ke bayar_pinjaman
           │               ├─ Update sisa_pinjaman
           │               └─ Jika sisa = 0 → LUNAS
           │
           └─→ [Pengajuan Baru] ← Form ajukan pinjaman
               ├─ Input: jumlah pinjaman
               ├─ Input: bunga (%)
               ├─ Input: tenor (bulan)
               ├─ Input: tujuan pinjaman
               ├─ Input: keterangan
               └─ Proses: 
                   ├─ Hitung: total bunga, total bayar, angsuran/bulan
                   ├─ Generate: kode pinjaman (PIN-XXXX)
                   ├─ Set: status = "menunggu"
                   ├─ Save ke database
                   └─ Notify: Admin untuk review
```

### FLOW 5: Admin - Approval Pinjaman
```
┌─────────────┐
│ Admin       │
│ Login       │
└──────┬──────┘
       │
       └─→ [Management Panel]
           │
           └─→ [List Pinjaman Pending]
               │
               └─→ [Review Pinjaman]
                   │
                   ├─→ [Approve]
                   │   ├─ Set status = "disetujui"
                   │   ├─ Catat tanggal disetujui
                   │   └─ Update database
                   │
                   └─→ [Reject]
                       ├─ Set status = "ditolak"
                       └─ Update database
```

---

## 5. HALAMAN-HALAMAN YANG ADA & NAVIGASI

### **Public Pages (Tanpa Login)**
| No | Halaman | Route | Deskripsi |
|---|---|---|---|
| 1 | Welcome/Home | `/` | Landing page project |
| 2 | Login | `/login` | Form login anggota |
| 3 | Register | `/register` | Form registrasi anggota baru |

### **Protected Pages (Perlu Login)**
| No | Halaman | Route | Deskripsi |
|---|---|---|---|
| 1 | Dashboard | `/dashboard` | Ringkasan/overview data anggota |
| 2 | Simpanan - List | `/simpanan` | Daftar semua simpanan anggota |
| 3 | Simpanan - Create | `/simpanan/create` | Form buat simpanan baru |
| 4 | Simpanan - Edit | `/simpanan/{id}/edit` | Form edit simpanan |
| 5 | Simpanan - Show | `/simpanan/{id}` | Detail simpanan |
| 6 | Tabungan - List | `/tabungan` | Daftar rekening tabungan |
| 7 | Tabungan - Create | `/tabungan/create` | Form buat rekening tabungan |
| 8 | Tabungan - Show | `/tabungan/{id}` | Detail rekening + mutasi |
| 9 | Tabungan - Setor | `/tabungan/{id}/setor` | Form setor uang (POST) |
| 10 | Tabungan - Tarik | `/tabungan/{id}/tarik` | Form tarik uang (POST) |
| 11 | Pinjaman - List | `/pinjaman` | Daftar pinjaman anggota |
| 12 | Pinjaman - Create | `/pinjaman/create` | Form pengajuan pinjaman |
| 13 | Pinjaman - Show | `/pinjaman/{id}` | Detail pinjaman + cicilan |
| 14 | Pinjaman - Approve | `/pinjaman/{id}/approve` | Approve pinjaman (Admin) |
| 15 | Pinjaman - Reject | `/pinjaman/{id}/reject` | Reject pinjaman (Admin) |
| 16 | Bayar Pinjaman - List | `/bayar-pinjaman` | Daftar pembayaran cicilan |
| 17 | Bayar Pinjaman - Create | `/bayar-pinjaman/create` | Form pembayaran cicilan |

---

## 6. STRUKTUR DATABASE

```sql
-- Users (Anggota)
users:
  - id (PK)
  - name_panjang
  - username
  - email
  - password

-- Simpanan
simpanan:
  - id (PK)
  - user_id (FK → users)
  - kode_simpanan (UNIQUE)
  - jenis_simpanan (pokok|wajib|sukarela)
  - jumlah
  - tanggal_simpan
  - keterangan

-- Tabungan (Rekening)
tabungan:
  - id (PK)
  - user_id (FK → users)
  - no_rekening (UNIQUE)
  - saldo (DECIMAL)
  - status (aktif|nonaktif)

-- Mutasi Tabungan (History)
mutasi_tabungan:
  - id (PK)
  - tabungan_id (FK → tabungan)
  - jenis (setor|tarik)
  - jumlah
  - saldo_sebelum
  - saldo_sesudah
  - tanggal_transaksi
  - keterangan

-- Pinjaman
pinjaman:
  - id (PK)
  - user_id (FK → users)
  - kode_pinjaman (UNIQUE)
  - jumlah_pinjaman
  - bunga_persen
  - tenor_bulan
  - angsuran_per_bulan
  - total_bayar
  - sisa_pinjaman
  - tanggal_pengajuan
  - tanggal_disetujui
  - status (menunggu|disetujui|ditolak|aktif|lunas)
  - tujuan_pinjaman
  - keterangan

-- Bayar Pinjaman (Cicilan)
bayar_pinjaman:
  - id (PK)
  - pinjaman_id (FK → pinjaman)
  - user_id (FK → users)
  - kode_bayar (UNIQUE)
  - ke_angsuran
  - jumlah_bayar
  - pokok_bayar
  - bunga_bayar
  - sisa_setelah_bayar
  - tanggal_bayar
  - metode_bayar
  - keterangan
```

---

## 7. API ROUTES MAPPING

```
Auth Routes:
  POST   /login                    → Login
  POST   /register                 → Register
  GET    /dashboard                → Dashboard

Simpanan Routes (Resource):
  GET    /simpanan                 → SimpananController@index
  GET    /simpanan/create          → SimpananController@create
  POST   /simpanan                 → SimpananController@store
  GET    /simpanan/{id}            → SimpananController@show
  GET    /simpanan/{id}/edit       → SimpananController@edit
  PUT    /simpanan/{id}            → SimpananController@update
  DELETE /simpanan/{id}            → SimpananController@destroy

Tabungan Routes (Resource + Actions):
  GET    /tabungan                 → TabunganController@index
  GET    /tabungan/create          → TabunganController@create
  POST   /tabungan                 → TabunganController@store
  GET    /tabungan/{id}            → TabunganController@show
  POST   /tabungan/{id}/setor      → TabunganController@setor (Deposit)
  POST   /tabungan/{id}/tarik      → TabunganController@tarik (Withdrawal)

Pinjaman Routes (Resource + Actions):
  GET    /pinjaman                 → PinjamanController@index
  GET    /pinjaman/create          → PinjamanController@create
  POST   /pinjaman                 → PinjamanController@store
  GET    /pinjaman/{id}            → PinjamanController@show
  POST   /pinjaman/{id}/approve    → PinjamanController@approve (Admin)
  POST   /pinjaman/{id}/reject     → PinjamanController@reject (Admin)

Bayar Pinjaman Routes (Resource):
  GET    /bayar-pinjaman           → BayarPinjamanController@index
  GET    /bayar-pinjaman/create    → BayarPinjamanController@create
  POST   /bayar-pinjaman           → BayarPinjamanController@store
  GET    /bayar-pinjaman/{id}      → BayarPinjamanController@show
  DELETE /bayar-pinjaman/{id}      → BayarPinjamanController@destroy
```

---

## 8. VALIDASI & BUSINESS RULES

### Simpanan:
- ✅ Jumlah > 0
- ✅ Jenis harus: pokok, wajib, atau sukarela
- ✅ Tanggal tidak boleh di masa depan

### Tabungan:
- ✅ Saldo awal > 0
- ✅ Setor: jumlah > 0
- ✅ Tarik: jumlah > 0 AND saldo >= jumlah
- ✅ Status hanya: aktif/nonaktif

### Pinjaman:
- ✅ Jumlah pinjaman > 0
- ✅ Bunga >= 0
- ✅ Tenor >= 1 bulan
- ✅ Hanya anggota yg bisa buat pengajuan
- ✅ Admin hanya bisa approve/reject
- ✅ Tidak bisa bayar jika status != aktif

### Bayar Pinjaman:
- ✅ Pinjaman harus status "disetujui" atau "aktif"
- ✅ Jumlah bayar > 0
- ✅ Jumlah bayar <= sisa pinjaman
- ✅ Otomatis hitung pokok & bunga breakdown

---

## 9. STATUS DEFINITIONS

### Status Simpanan:
- **Active** (default) - Simpanan valid

### Status Tabungan:
- **Aktif** - Rekening dapat digunakan
- **Nonaktif** - Rekening ditutup

### Status Pinjaman:
- **Menunggu** - Perlu review admin
- **Disetujui** - Admin approve, bisa mulai bayar
- **Ditolak** - Admin reject
- **Aktif** - Sudah ada pembayaran pertama
- **Lunas** - Sisa pinjaman = 0

### Status Mutasi Tabungan:
- **Setor** - Deposit
- **Tarik** - Withdrawal

---

## 10. KODE GENERATOR LOGIC

```php
// Simpanan
$lastSimpanan = simpanan::latest('id')->first();
$kodeSimpanan = 'SMP-' . str_pad(($lastSimpanan?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);
// Hasil: SMP-0001, SMP-0002, etc

// Tabungan
$lastTabungan = tabungan::latest('id')->first();
$noRekening = 'REK-' . str_pad(($lastTabungan?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);
// Hasil: REK-0001, REK-0002, etc

// Pinjaman
$lastPinjaman = pinjaman::latest('id')->first();
$kodePinjaman = 'PIN-' . str_pad(($lastPinjaman?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);
// Hasil: PIN-0001, PIN-0002, etc

// Bayar Pinjaman
$lastBayar = bayar_pinjaman::latest('id')->first();
$kodeBayar = 'BYR-' . str_pad(($lastBayar?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);
// Hasil: BYR-0001, BYR-0002, etc
```

---

## 11. KEY CALCULATIONS

### Pinjaman - Interest Calculation
```
Formula: Total Bunga = (Principal × Rate% × Time) / 100

Contoh:
- Principal (Jumlah): Rp 10.000.000
- Rate (Bunga %): 3% per tahun
- Time (Tenor): 12 bulan = 1 tahun

Total Bunga = (10.000.000 × 3 × 12) / 100 = Rp 3.600.000
Total Bayar = 10.000.000 + 3.600.000 = Rp 13.600.000
Angsuran/Bulan = 13.600.000 / 12 = Rp 1.133.333,33
```

### Pinjaman - Payment Breakdown
```
Saat membayar cicilan, breakdown:
- Pokok Bayar = (Jumlah Pinjaman / Tenor) 
              = (10.000.000 / 12) 
              = Rp 833.333,33

- Bunga Bayar = Angsuran - Pokok
              = 1.133.333 - 833.333
              = Rp 300.000

- Sisa Pinjaman = Sisa Sebelum - Pokok Bayar
```

---

## 12. PERMISSION & AUTHORIZATION

```
Public (No Auth):
- View landing page
- Login
- Register

Authenticated User (Anggota):
- View own simpanan (not others)
- Create/Read/Update simpanan
- View own tabungan (not others)
- Create tabungan
- Setor/Tarik tabungan sendiri
- View own pinjaman (not others)
- Create pinjaman request
- Bayar cicilan pinjaman sendiri

Admin:
- Approve/Reject pinjaman
- View all pinjaman
- View all users
- Management panel

Policy-based Authorization:
- SimpananPolicy → can view, update, delete only own
- TabunganPolicy → can view, update, setor, tarik only own
- PinjamanPolicy → can view, update only own
- BayarPinjamanPolicy → can view, delete only own
```

---

## 13. DASHBOARD METRICS

Dashboard menampilkan ringkasan untuk anggota:
```
┌─────────────────────────────────┐
│        DASHBOARD ANGGOTA         │
├─────────────────────────────────┤
│ Welcome: [Nama Anggota]          │
│                                  │
│ RINGKASAN KEUANGAN:              │
│ ├─ Total Simpanan     : Rp XXX   │
│ ├─ Total Saldo Tabungan: Rp XXX  │
│ ├─ Total Pinjaman (Aktif): Rp XX │
│ └─ Sisa Pinjaman: Rp XXX         │
│                                  │
│ STATISTIK:                       │
│ ├─ Jumlah Simpanan: X            │
│ ├─ Jumlah Rekening: X            │
│ ├─ Jumlah Pinjaman: X            │
│ └─ Cicilan Bulan Ini: X          │
│                                  │
│ QUICK ACTIONS:                   │
│ ├─ [+ Simpanan Baru]            │
│ ├─ [+ Setor Tabungan]           │
│ ├─ [+ Ajukan Pinjaman]          │
│ └─ [+ Bayar Cicilan]            │
└─────────────────────────────────┘
```

---

## 14. TIPS IMPLEMENTASI NEXT

1. **Lengkapi Views:**
   - Buat template layout utama dengan navbar
   - Implementasi semua halaman CRUD

2. **Tambah Controllers Logic:**
   - Completkan method update/destroy
   - Tambah approval logic untuk pinjaman
   - Handle transaksi database

3. **Validasi & Error Handling:**
   - Tambah validation rules lengkap
   - Form error messages
   - Success/failure feedback

4. **Security:**
   - Implement Policies untuk authorization
   - CSRF protection (default Laravel)
   - Hash password (default Laravel)

5. **Frontend Enhancements:**
   - Responsive design improvements
   - Form validation js
   - Notification/toast messages
   - Data pagination

6. **Reporting:**
   - Laporan simpanan per anggota
   - Laporan pinjaman (pending/approved/lunas)
   - Export PDF/Excel

---

## 15. NEXT STEPS UNTUK KONEKSI PAGE

Lihat file: **PAGE_LINKING_GUIDE.md**
