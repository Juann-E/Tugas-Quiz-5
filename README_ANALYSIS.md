# 📋 PROJECT SUMMARY & QUICK REFERENCE

## Project Overview

**Sistem Manajemen Koperasi Simpan Pinjam** adalah aplikasi web Laravel untuk mengelola keuangan anggota koperasi dengan fitur:
- 👥 Manajemen anggota (User/Auth)
- 💰 Simpanan (Pokok, Wajib, Sukarela)
- 🏦 Tabungan dengan transaksi setor/tarik
- 📊 Pinjaman dengan cicilan berbunga
- 📈 Tracking pembayaran cicilan

---

## Logika Bisnis CORE

### 1️⃣ SIMPANAN
```
Anggota menabung dana ke koperasi dengan 3 jenis:
- Pokok: Mandatory, disetor saat daftar
- Wajib: Berkala/rutin 
- Sukarela: Sesuka hati

Fitur: Create, Read, Update, Delete
Status: Tercatat (tidak ada approval)
```

### 2️⃣ TABUNGAN
```
Rekening dengan kemampuan setor/tarik:
- 1 Anggota = Banyak Rekening
- Nomor Rekening Unik (REK-XXXX)
- Saldo dapat berubah dari transaksi

Transaksi:
1. SETOR (Deposit)
   Input: jumlah
   Proses: saldo += jumlah, catat mutasi
   
2. TARIK (Withdrawal)
   Validasi: saldo >= jumlah
   Proses: saldo -= jumlah, catat mutasi
```

### 3️⃣ PINJAMAN
```
Dana pinjam dengan sistem cicilan berbunga:

TAHAP 1: PENGAJUAN
- Anggota input: jumlah, bunga%, tenor
- Otomatis hitung: total bunga, total bayar, angsuran/bulan
- Status: "menunggu"

TAHAP 2: APPROVAL
- Admin review & approve/reject
- Jika approve: status = "disetujui"

TAHAP 3: CICILAN
- Anggota bayar angsuran setiap bulan
- Per pembayaran breakdown: pokok + bunga
- Update sisa pinjaman
- Jika sisa = 0 → LUNAS

Formula:
Total Bunga = (Principal × Bunga% × Tenor) / 100
Total Bayar = Principal + Total Bunga
Angsuran = Total Bayar / Tenor
```

---

## Database Structure (5 Tables)

```
users (Anggota)
├─ id, name_panjang, username, email, password

simpanan
├─ id, user_id (FK), kode_simpanan, jenis_simpanan, jumlah, tanggal_simpan
└─ Relations: belongs to user

tabungan (Rekening)
├─ id, user_id (FK), no_rekening, saldo, status
└─ Relations: belongs to user, has many mutasi

mutasi_tabungan (History Setor/Tarik)
├─ id, tabungan_id (FK), jenis, jumlah, saldo_sebelum, saldo_sesudah, tanggal_transaksi
└─ Relations: belongs to tabungan

pinjaman
├─ id, user_id (FK), kode_pinjaman, jumlah_pinjaman, bunga_persen, tenor_bulan,
│  angsuran_per_bulan, total_bayar, sisa_pinjaman, tanggal_pengajuan,
│  tanggal_disetujui, status, tujuan_pinjaman
└─ Relations: belongs to user, has many bayar_pinjaman

bayar_pinjaman (Cicilan)
├─ id, pinjaman_id (FK), user_id (FK), kode_bayar, ke_angsuran, jumlah_bayar,
│  pokok_bayar, bunga_bayar, sisa_setelah_bayar, tanggal_bayar, metode_bayar
└─ Relations: belongs to pinjaman, belongs to user
```

---

## User Flows

### FLOW 1: Register → Login → Dashboard
```
Visitor 
  ↓
[Register] → Form (nama, username, pwd) 
  ↓ 
User Created 
  ↓
[Login] → Authenticate 
  ↓ 
[Dashboard] ← Main hub
```

### FLOW 2: Manage Simpanan
```
Dashboard 
  → [Simpanan Menu] 
    → [List] (view all + total)
      → [+Add] → Form → Create
      → [Detail] → Show detail
      → [Edit] → Form → Update
      → [Delete] → Remove
```

### FLOW 3: Manage Tabungan
```
Dashboard 
  → [Tabungan Menu] 
    → [List] (view all + total saldo)
      → [+Create] → Form → Create
      → [Detail] → Show detail + mutasi history
        → [Setor] → Modal form → Process
        → [Tarik] → Modal form → Validate → Process
        → [View Mutasi] → Setor/tarik history
```

### FLOW 4: Manage Pinjaman (Complete)
```
Dashboard 
  → [Pinjaman Menu]

USER SIDE:
    → [List Pinjaman] 
      → [+Ajukan] → Form (jumlah, bunga, tenor) 
        → Hitung otomatis → Create → [Menunggu] status
        
      → [Detail Pinjaman]
        → View: jumlah, angsuran, sisa, status
        → [Bayar Cicilan] → Form → Create bayar → Update sisa
        
ADMIN SIDE:
    → [Review Pinjaman] (menunggu status)
      → [Approve] → Set status "disetujui"
      → [Reject] → Set status "ditolak"
```

### FLOW 5: Payment Tracking
```
Dashboard 
  → [Cicilan] 
    → [List Pembayaran] ← All bayar_pinjaman records
      → [Detail] → View ke berapa, jumlah, breakdown
```

---

## Routes Map (20 Routes)

```
PUBLIC:
GET  /                    Welcome
GET  /login              Login form
GET  /register           Register form ✓ SUDAH ADA

PROTECTED (Auth Required):
GET  /dashboard          Dashboard

SIMPANAN (Resource):
GET    /simpanan         Index
GET    /simpanan/create  Create form
POST   /simpanan         Store
GET    /simpanan/{id}    Show
GET    /simpanan/{id}/edit Edit form
PUT    /simpanan/{id}    Update
DELETE /simpanan/{id}    Delete

TABUNGAN (Resource + Actions):
GET    /tabungan         Index
GET    /tabungan/create  Create form
POST   /tabungan         Store
GET    /tabungan/{id}    Show (+ mutasi)
POST   /tabungan/{id}/setor   Deposit
POST   /tabungan/{id}/tarik   Withdraw

PINJAMAN (Resource + Actions):
GET    /pinjaman         Index
GET    /pinjaman/create  Create form
POST   /pinjaman         Store
GET    /pinjaman/{id}    Show (+ cicilan)
POST   /pinjaman/{id}/approve  Admin approve
POST   /pinjaman/{id}/reject   Admin reject

BAYAR PINJAMAN (Resource):
GET    /bayar-pinjaman   Index (all payments)
GET    /bayar-pinjaman/create Create form
POST   /bayar-pinjaman   Store

OTHER:
GET    /profil           Profile page
```

---

## Page Linking Map (Visual Flow)

```
┌─────────────────────────┐
│   WELCOME               │
│ [Login] [Register]      │
└────────────┬────────────┘
             │
  ┌──────────┴──────────┐
  │                     │
  ▼                     ▼
[Login]             [Register] ✓
Form            Form (EXISTS)
  │                     │
  └──────────┬──────────┘
             │ Success
             ▼
      ┌──────────────────────────────┐
      │     DASHBOARD                │
      │ [Simpanan] [Tabungan]        │
      │ [Pinjaman] [Profil]          │
      │ [Logout]                     │
      └──┬───────┬──────────┬────────┘
        /        │          \
       ▼         ▼           ▼
  [SIMPANAN] [TABUNGAN] [PINJAMAN]
   ├─List    ├─List      ├─List
   ├─Create  ├─Create    ├─Create (Form + Calc)
   ├─Show    ├─Show      ├─Show
   ├─Edit    ├─Setor     ├─Approve (Admin)
   └─Delete  ├─Tarik     ├─Reject (Admin)
            └─Mutasi    └─Payment List
```

---

## Documentation Files Created

✅ **PROJECT_ANALYSIS.md**
- 15 sections lengkap
- Business logic detail
- Database structure
- Calculations & formulas
- 45+ pages worth of analysis

✅ **PAGE_LINKING_GUIDE.md**
- Navigation architecture
- 15 halaman terdetail
- Link relationships
- Code snippets untuk setiap page
- Linking checklist

✅ **IMPLEMENTATION_GUIDE.md**
- Quick checklist phases
- 6+ code snippets siap pakai
- Navbar, Layout, Dashboard components
- Validation rules
- Formula implementations
- Testing checklist
- Performance & Security tips

---

## Key Points for Developers

### ⚡ Most Important Logic

1. **Pinjaman Calculation** (Most Complex)
```
Total Bunga = (Jumlah × Bunga% × Tenor) / 100
Total Bayar = Jumlah + Bunga
Angsuran = Total Bayar / Tenor
```

2. **Tabungan Transactions** (Most Frequent)
```
Setor: saldo += amount, catat mutasi
Tarik: if (saldo >= amount) saldo -= amount, catat mutasi
```

3. **Status Workflows**
```
Pinjaman: menunggu → disetujui/ditolak → aktif → lunas
Tabungan: aktif (fixed)
Simpanan: (no status changes)
```

### 🎯 Priority Implementation Order

1. **Authentication** (Login/Register/Logout)
2. **Dashboard** (Hub untuk semua module)
3. **Simpanan** (Paling simple - CRUD only)
4. **Tabungan** (Medium - +Transaksi+Mutasi)
5. **Pinjaman** (Complex - +Approval+Calculation+Payment)

### 🔗 Must Implement Linking

- [ ] Navbar with all module links
- [ ] Dashboard quick action buttons
- [ ] Breadcrumb navigation
- [ ] "Back to List/Dashboard" links
- [ ] Success/error flash messages
- [ ] Form validation messages

### 💡 Quick Tips

1. Use existing register.blade.php as template for login design
2. Copy list table structure for all index pages
3. Use form component for all create/edit pages
4. Implement Policies for row-level authorization
5. Cache dashboard totals for performance
6. Paginate all list views (15-20 items per page)

---

## Status

### ✅ COMPLETED
- Project structure & migrations
- Models with relationships
- Routes defined
- Controllers skeleton
- Register page design

### ⏳ TODO (In Order)
1. Create Auth middleware & controllers
2. Build Base Layout & Navbar
3. Create Dashboard page
4. Implement all Simpanan pages
5. Implement all Tabungan pages
6. Implement all Pinjaman pages
7. Add form validations
8. Add authorization policies
9. Test all flows
10. Deploy

---

## File Locations

```
Project Root
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── SimpananController.php
│   │       ├── TabunganController.php
│   │       ├── PinjamanController.php
│   │       └── BayarPinjamanController.php
│   └── Models/
│       ├── User.php
│       ├── simpanan.php
│       ├── tabungan.php
│       ├── MutasiTabungan.php
│       ├── pinjaman.php
│       └── bayar_pinjaman.php
│
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php (TODO)
│   │   └── register.blade.php (✓ EXISTS)
│   ├── dashboard/
│   │   └── index.blade.php (TODO)
│   ├── layouts/
│   │   └── app.blade.php (TODO)
│   ├── components/
│   │   ├── navbar.blade.php (TODO)
│   │   └── footer.blade.php (TODO)
│   ├── simpanan/ (TODO)
│   ├── tabungan/ (TODO)
│   ├── pinjaman/ (TODO)
│   └── bayar-pinjaman/ (TODO)
│
├── routes/
│   ├── web.php (✓ Routes sudah defined)
│   └── console.php
│
├── database/
│   ├── migrations/ (✓ Semua sudah ada)
│   └── seeders/
│
├── PROJECT_ANALYSIS.md (✓ NEW)
├── PAGE_LINKING_GUIDE.md (✓ NEW)
└── IMPLEMENTATION_GUIDE.md (✓ NEW)
```

---

## Quick Command Reference

```bash
# Run seeder
php artisan db:seed

# Create new migration
php artisan make:migration migration_name

# Create new model with migration
php artisan make:model ModelName -m

# Create controller with resource methods
php artisan make:controller ControllerName --resource

# Serve locally
php artisan serve

# Run tests
php artisan test

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Next Immediate Steps

1. **📖 READ** the 3 analysis documents fully
2. **🏗️ CREATE** Base Layout (`resources/views/layouts/app.blade.php`)
3. **🎨 CREATE** Navbar Component
4. **🏠 CREATE** Dashboard page dengan 4 widgets
5. **📝 START** Simpanan module (easiest)
6. **🔗 LINK** everything using routes

---

**Created:** 2026-05-12
**Version:** 1.0
**Status:** Documentation Complete ✓
**Implementation:** Ready to Start

