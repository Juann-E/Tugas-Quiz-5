# 🎨 VISUAL DIAGRAMS & CHECKLISTS

## 1. ENTITY RELATIONSHIP DIAGRAM (ERD)

```
┌─────────────────────────────────────────────────────────────────┐
│                       DATABASE SCHEMA                            │
├─────────────────────────────────────────────────────────────────┤

                            ┌──────────────┐
                            │    USERS     │
                            ├──────────────┤
                            │ id (PK)      │
                            │ name_panjang │
                            │ username     │
                            │ email        │
                            │ password     │
                            │ created_at   │
                            │ updated_at   │
                            └──────┬───────┘
                                   │ 1
                   ┌───────────────┼───────────────┐
                   │               │               │
                   │ 1:M           │ 1:M          │ 1:M
                   │               │               │
        ┌──────────▼──────┐  ┌─────▼─────┐  ┌────▼──────────┐
        │   SIMPANAN      │  │ TABUNGAN   │  │  PINJAMAN     │
        ├─────────────────┤  ├────────────┤  ├───────────────┤
        │ id (PK)         │  │ id (PK)    │  │ id (PK)       │
        │ user_id (FK)    │  │ user_id(FK)│  │ user_id (FK)  │
        │ kode_simpanan   │  │no_rekening │  │kode_pinjaman  │
        │ jenis_simpanan  │  │ saldo      │  │jumlah_pinjaman│
        │ jumlah          │  │ status     │  │bunga_persen   │
        │ tanggal_simpan  │  │created_at  │  │tenor_bulan    │
        │ keterangan      │  │updated_at  │  │angsuran/bulan │
        │ created_at      │  │            │  │total_bayar    │
        │ updated_at      │  └────┬───────┘  │sisa_pinjaman  │
        └─────────────────┘       │          │status         │
                                  │ 1:M      │tanggal_pengajuan
                                  │          │tanggal_disetujui
                            ┌─────▼──────────┤tujuan_pinjaman│
                            │                │keterangan     │
                     ┌──────▼──────┐         └───────┬───────┘
                     │   MUTASI    │                 │ 1:M
                     │  TABUNGAN   │         ┌───────▼─────────┐
                     ├─────────────┤         │ BAYAR_PINJAMAN  │
                     │ id (PK)     │         ├─────────────────┤
                     │tabungan_id  │         │ id (PK)         │
                     │ (FK)        │         │ pinjaman_id(FK) │
                     │ jenis       │         │ user_id (FK)    │
                     │ jumlah      │         │ kode_bayar      │
                     │saldo_sebelum│         │ ke_angsuran     │
                     │saldo_sesudah│         │ jumlah_bayar    │
                     │tanggal_trans│         │ pokok_bayar     │
                     │keterangan   │         │ bunga_bayar     │
                     │created_at   │         │sisa_setelah_bayar
                     │updated_at   │         │ tanggal_bayar   │
                     └─────────────┘         │ metode_bayar    │
                                            │ keterangan      │
                                            │ created_at      │
                                            │ updated_at      │
                                            └─────────────────┘

KEY:
PK = Primary Key
FK = Foreign Key
1:M = One to Many
```

---

## 2. APPLICATION ARCHITECTURE

```
┌──────────────────────────────────────────────────────────────────┐
│                    BROWSER (Client)                              │
│                   (Blade Templates)                              │
└───────────────────────────┬──────────────────────────────────────┘
                            │
                            ▼
┌──────────────────────────────────────────────────────────────────┐
│                 WEB LAYER (routes/web.php)                       │
│   - Public routes (/, /login, /register)                         │
│   - Protected routes (auth middleware)                           │
└───────────────────────────┬──────────────────────────────────────┘
                            │
                            ▼
┌──────────────────────────────────────────────────────────────────┐
│            CONTROLLER LAYER (Http/Controllers)                   │
│  ┌──────────────┐  ┌────────────┐  ┌──────────┐  ┌────────────┐ │
│  │SimpananCtrl  │  │TabunganCtrl│  │Pinjaman  │  │BayarPinjam │ │
│  │              │  │            │  │Ctrl      │  │Ctrl        │ │
│  │ index()      │  │ index()    │  │index()   │  │index()     │ │
│  │ create()     │  │ create()   │  │create()  │  │create()    │ │
│  │ store()      │  │ store()    │  │store()   │  │store()     │ │
│  │ show()       │  │ show()     │  │show()    │  │show()      │ │
│  │ edit()       │  │ setor()    │  │approve() │  │            │ │
│  │ update()     │  │ tarik()    │  │reject()  │  │            │ │
│  │ destroy()    │  │ delete()   │  │destroy() │  │destroy()   │ │
│  └──────────────┘  └────────────┘  └──────────┘  └────────────┘ │
└───────────────┬───────────┬───────────┬──────────────┬────────────┘
                │           │           │              │
                ▼           ▼           ▼              ▼
┌──────────────────────────────────────────────────────────────────┐
│                    MODEL LAYER (Models)                          │
│  User  │  simpanan │ tabungan │ MutasiTabungan │ pinjaman │     │
│        │           │          │                │          │ Bayar│
│ Relasi │ Relations │Relations │   Relations    │Relations │Pinj │
│--------────────────────────────────────────────────────────────  │
│ Relations built-in (hasMany, belongsTo)                         │
└────────────────────────┬──────────────────────────────────────────┘
                         │
                         ▼
┌──────────────────────────────────────────────────────────────────┐
│               DATABASE LAYER (MySQL)                             │
│  ┌──────┐  ┌──────────┐  ┌─────────┐  ┌──────────────────┐    │
│  │users │  │ simpanan │  │ tabungan│  │mutasi_tabungan   │    │
│  └──────┘  └──────────┘  └─────────┘  └──────────────────┘    │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │         pinjaman      │      bayar_pinjaman            │   │
│  └─────────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────────┘
```

---

## 3. USER FLOW DIAGRAM - Complete Journey

```
START: VISITOR
  │
  ├─ [Lihat Landing] 
  │   └─> Pilih: Masuk atau Daftar?
  │
  ├─► DAFTAR (Register)
  │   ├─ Isi Form: Nama, Username, Password
  │   ├─ Validasi
  │   ├─ Create User
  │   └─► BERHASIL → Redirect ke Login
  │
  └─► MASUK (Login)
      ├─ Isi Username & Password
      ├─ Authenticate
      ├─ Set Session
      └─► DASHBOARD (Main Hub)
           │
           ├─► SIMPANAN MODULE
           │   ├─ [Lihat List] → Tampilkan semua simpanan + total
           │   │   ├─ [Lihat Detail] → Show page
           │   │   ├─ [Edit] → Edit form
           │   │   └─ [Hapus] → Delete
           │   │
           │   └─ [+ Tambah] → Create form
           │       ├─ Input: Jenis, Jumlah, Tanggal
           │       ├─ Generate Kode (SMP-XXXX)
           │       └─► Save → List
           │
           ├─► TABUNGAN MODULE  
           │   ├─ [Lihat List] → Tampilkan semua rekening + total saldo
           │   │   ├─ [Lihat Detail] → Show page + mutasi history
           │   │   │   ├─ [Setor] → Modal → Input jumlah → Proses
           │   │   │   └─ [Tarik] → Modal → Input jumlah → Validasi → Proses
           │   │   └─ [Hapus Rekening] → Delete
           │   │
           │   └─ [+ Buat Rekening] → Create form
           │       ├─ Input: Saldo awal
           │       ├─ Generate No Rekening (REK-XXXX)
           │       └─► Save → List
           │
           ├─► PINJAMAN MODULE
           │   ├─ [Lihat List] → Tampilkan pinjaman (pending/approved/rejected)
           │   │   ├─ [Lihat Detail] → Show page + cicilan history
           │   │   │   └─ [Bayar Cicilan] → Create form (jika approved)
           │   │   │       ├─ Input: Jumlah bayar, Metode
           │   │   │       ├─ Proses: Hitung pokok+bunga, update sisa
           │   │   │       └─► Cicilan tercatat
           │   │   │
           │   │   └─ [Lihat Riwayat Bayar] → Show pembayaran
           │   │
           │   └─ [+ Ajukan Baru] → Create form (Calculate Live)
           │       ├─ Input: Jumlah, Bunga%, Tenor
           │       ├─ Preview: Total Bunga, Total Bayar, Angsuran
           │       ├─ Input: Tujuan, Keterangan
           │       ├─ Generate Kode (PIN-XXXX)
           │       ├─ Set Status "menunggu"
           │       └─► Notification ke Admin
           │
           ├─► PAYMENT TRACKING
           │   └─ [Riwayat Cicilan] → List semua pembayaran
           │       ├─ Tampilkan: Kode, Cicilan ke, Jumlah, Tanggal
           │       └─ [Detail] → Breakdown pokok+bunga
           │
           ├─► PROFIL
           │   ├─ [View Profil] → Show data pribadi
           │   └─ [Edit Profil] → Update data
           │
           └─► [LOGOUT]
                └─► Back to Landing

------- ADMIN PANEL (Separate) --------
  
  ADMIN → Dashboard
     │
     └─► PINJAMAN MANAGEMENT
         ├─ [Review Pending] → List pinjaman menunggu
         │   ├─ [Approve] → Set status "disetujui" + tanggal
         │   └─ [Reject] → Set status "ditolak"
         │
         ├─ [View All] → List semua pinjaman
         └─ [Reports] → Statistik pinjaman
```

---

## 4. DATA FLOW DIAGRAM - Pinjaman (Most Complex)

```
PENGAJUAN PINJAMAN
═════════════════════════════════════════════════════════════

User Input:
  ├─ Jumlah Pinjaman: Rp 10.000.000
  ├─ Bunga (%): 3
  ├─ Tenor (Bulan): 12
  └─ Tujuan: Modal Usaha

         ↓ CALCULATION LAYER

Calculate:
  ├─ Total Bunga = (10.000.000 × 3 × 12) / 100 = Rp 3.600.000
  ├─ Total Bayar = 10.000.000 + 3.600.000 = Rp 13.600.000
  └─ Angsuran/Bulan = 13.600.000 / 12 = Rp 1.133.333

         ↓ DATABASE INSERT

Create pinjaman:
  ├─ kode_pinjaman: PIN-0001
  ├─ user_id: 1
  ├─ jumlah_pinjaman: 10000000
  ├─ bunga_persen: 3
  ├─ tenor_bulan: 12
  ├─ angsuran_per_bulan: 1133333.33
  ├─ total_bayar: 13600000
  ├─ sisa_pinjaman: 13600000
  ├─ status: "menunggu"
  ├─ tanggal_pengajuan: 2026-05-12
  └─ tanggal_disetujui: null

         ↓ APPROVAL PROCESS

Admin Review [Approve] / [Reject]

   APPROVED PATH:                    REJECTED PATH:
   ├─ Set status: "disetujui"       └─ Set status: "ditolak"
   ├─ Set tanggal_disetujui: today      (No further action)
   └─► Ready for Payment

         ↓ PAYMENT PROCESS (Cicilan ke-1)

User Input:
  ├─ Jumlah Bayar: Rp 1.133.333
  ├─ Metode: Transfer
  └─ Tanggal: 2026-06-12

         ↓ PAYMENT CALCULATION

Calculate Breakdown:
  ├─ Pokok Bayar = Jumlah Pinjaman / Tenor
  │              = 10.000.000 / 12 = Rp 833.333
  │
  ├─ Bunga Bayar = Angsuran - Pokok
  │              = 1.133.333 - 833.333 = Rp 300.000
  │
  └─ Sisa Setelah = Sisa Sebelum - Pokok Bayar
                  = 13.600.000 - 833.333 = Rp 12.766.667

         ↓ DATABASE INSERT

Create bayar_pinjaman:
  ├─ pinjaman_id: 1
  ├─ user_id: 1
  ├─ kode_bayar: BYR-0001
  ├─ ke_angsuran: 1
  ├─ jumlah_bayar: 1133333
  ├─ pokok_bayar: 833333
  ├─ bunga_bayar: 300000
  ├─ sisa_setelah_bayar: 12766667
  ├─ tanggal_bayar: 2026-06-12
  ├─ metode_bayar: transfer
  └─ keterangan: null

         ↓ UPDATE pinjaman

Update pinjaman:
  ├─ sisa_pinjaman = 12.766.667
  ├─ status = "aktif" (changed from "disetujui")
  └─ (Continue for cicilan ke-2 → ke-12)

         ↓ AFTER CICILAN KE-12

Final Payment:
  └─ sisa_pinjaman = 0
      ├─ Update status = "lunas"
      └─ ✓ PINJAMAN SELESAI
```

---

## 5. IMPLEMENTATION CHECKLIST

### Phase 1: Foundation ⚙️
- [ ] Review all 3 analysis documents
- [ ] Understand business logic thoroughly
- [ ] Plan database schema verification
- [ ] Setup development environment

### Phase 2: Authentication 🔐
- [ ] Create AuthController (login, logout, register)
- [ ] Implement login.blade.php (similar to register design)
- [ ] Add auth middleware to routes
- [ ] Test login/logout flow
- [ ] Add "Logout" button to navbar
- [ ] Test session management

### Phase 3: Layout & Navigation 🎨
- [ ] Create resources/views/layouts/app.blade.php
- [ ] Create resources/views/components/navbar.blade.php
- [ ] Create resources/views/components/footer.blade.php
- [ ] Add Tailwind CSS / Bootstrap
- [ ] Test navbar on all pages
- [ ] Add breadcrumb navigation
- [ ] Style form error messages
- [ ] Style alert/success messages

### Phase 4: Dashboard 📊
- [ ] Create resources/views/dashboard/index.blade.php
- [ ] Add 4 main widgets (Simpanan, Tabungan, Pinjaman, Profil)
- [ ] Add quick action buttons
- [ ] Calculate totals from models
- [ ] Add dashboard route to navbar
- [ ] Test widget data display

### Phase 5: Simpanan Module 💰
#### Views:
- [ ] resources/views/simpanan/index.blade.php
  - Table with all simpanan
  - Total calculation
  - Action buttons (Create, View, Edit, Delete)
  - Back to dashboard link
  
- [ ] resources/views/simpanan/create.blade.php
  - Form fields (Jenis, Jumlah, Tanggal, Keterangan)
  - Validation error display
  - Submit button
  - Cancel button
  
- [ ] resources/views/simpanan/show.blade.php
  - Display simpanan details
  - Edit button
  - Back link
  
- [ ] resources/views/simpanan/edit.blade.php
  - Pre-filled form
  - Update logic

#### Controller:
- [ ] Complete SimpananController
  - index() - query all + total
  - create() - return form view
  - store() - validate + save + redirect
  - show() - get single item
  - edit() - return edit form
  - update() - validate + save + redirect
  - destroy() - delete + redirect

#### Testing:
- [ ] Test create simpanan
- [ ] Test view list
- [ ] Test view detail
- [ ] Test edit
- [ ] Test delete
- [ ] Test authorization (only own data)

### Phase 6: Tabungan Module 🏦
#### Views:
- [ ] resources/views/tabungan/index.blade.php
  - List rekening with status badge
  - Total saldo calculation
  - Action buttons

- [ ] resources/views/tabungan/create.blade.php
  - Saldo awal input
  - Form submit

- [ ] resources/views/tabungan/show.blade.php
  - Rekening details
  - Current saldo display
  - [Setor] button → modal form
  - [Tarik] button → modal form
  - Mutasi history table with pagination

#### Modal Forms:
- [ ] Setor Modal
  - Input jumlah
  - Submit button
  
- [ ] Tarik Modal
  - Input jumlah
  - Submit button

#### Controller:
- [ ] Complete TabunganController
  - index() - all rekening per user
  - create() - form view
  - store() - create with saldo awal
  - show() - detail + mutasi with pagination
  - setor() - POST handler
    - Validate jumlah > 0
    - Update saldo += jumlah
    - Create mutasi record (jenis: setor)
    - Redirect with success message
    
  - tarik() - POST handler
    - Validate jumlah > 0 AND saldo >= jumlah
    - Update saldo -= jumlah
    - Create mutasi record (jenis: tarik)
    - Redirect with success message

#### Testing:
- [ ] Test create rekening
- [ ] Test setor (check saldo updates)
- [ ] Test tarik (check saldo updates)
- [ ] Test tarik validation (insufficient balance)
- [ ] Test mutasi history displays correctly
- [ ] Test authorization

### Phase 7: Pinjaman Module 📈
#### Views:
- [ ] resources/views/pinjaman/index.blade.php
  - List pinjaman dengan status badges
  - Status color coding (pending=warning, approved=success, rejected=danger)
  - Sisa pinjaman display
  - Pagination

- [ ] resources/views/pinjaman/create.blade.php
  - Jumlah input
  - Bunga (%) input
  - Tenor (bulan) input
  - Tujuan input
  - Keterangan textarea
  - **Live Preview Section:**
    - Shows: Total Bunga, Total Bayar, Angsuran/Bulan
    - Updates on input change (JavaScript)
  - Form submit button

- [ ] resources/views/pinjaman/show.blade.php
  - Pinjaman details (kode, jumlah, bunga%, tenor)
  - Calculated fields (Total bayar, sisa, angsuran)
  - Status badge
  - **[Bayar Cicilan] button** (if status approved/aktif)
  - Riwayat pembayaran table:
    - Columns: Kode Bayar, Ke, Jumlah, Pokok, Bunga, Sisa, Tanggal
  - Back link
  - **Admin only buttons (if status pending):**
    - [Approve] button
    - [Reject] button

#### JavaScript for Create Page:
- [ ] Live calculation preview
  - Triggers on jumlah, bunga, tenor input
  - Formats currency (Rp format)
  - Updates every field automatically

#### Controller:
- [ ] Complete PinjamanController
  - index() - list pinjaman per user
  - create() - form view
  - store() - create pinjaman
    - Validate inputs
    - Calculate: total bunga, total bayar, angsuran
    - Generate kode_pinjaman
    - Set status = "menunggu"
    - Save to DB
    - Redirect to show
    
  - show() - detail + pembayaran history
    - Load pinjaman with pembayaran relation
    - Load dengan pagination untuk pembayaran
    - Eager load untuk performance
    
  - approve() - POST handler (Admin only)
    - Validate user is admin
    - Set status = "disetujui"
    - Set tanggal_disetujui = today
    - Save
    - Redirect with success
    
  - reject() - POST handler (Admin only)
    - Validate user is admin
    - Set status = "ditolak"
    - Save
    - Redirect with success

#### Testing:
- [ ] Test create dengan preview kalkulasi
- [ ] Test calculation accuracy
- [ ] Test list display
- [ ] Test approval flow
- [ ] Test rejection flow
- [ ] Test only approved loans show bayar button

### Phase 8: Bayar Pinjaman Module 💳
#### Views:
- [ ] resources/views/bayar-pinjaman/index.blade.php
  - List semua pembayaran user
  - Table: Kode Bayar, Pinjaman, Cicilan Ke, Jumlah, Tanggal, Status
  - Pagination

- [ ] resources/views/bayar-pinjaman/create.blade.php
  - Get pinjaman_id dari URL parameter
  - Display pinjaman summary:
    - Kode pinjaman
    - Sisa pinjaman
    - Angsuran normal
    - Jumlah cicilan terbayar
  - Form fields:
    - Jumlah bayar (pre-filled with angsuran normal)
    - Max validation (max = sisa pinjaman)
    - Metode bayar (tunai, transfer, debit)
    - Keterangan textarea
  - Submit button

#### Controller:
- [ ] Complete BayarPinjamanController
  - index() - list pembayaran per user
  - create() - form view with pinjaman context
  - store() - process payment
    - Get pinjaman_id dari request
    - Validate pinjaman exists dan user authorized
    - Validate jumlah_bayar <= sisa_pinjaman
    - Calculate:
      - Pokok = Jumlah Pinjaman / Tenor
      - Bunga = Jumlah Bayar - Pokok
      - Sisa baru = Sisa lama - Pokok
    - Create bayar_pinjaman record
    - Update pinjaman.sisa_pinjaman
    - If sisa = 0: set status = "lunas"
    - Redirect to pinjaman show
    
  - show() - detail pembayaran
  - destroy() - delete pembayaran (if needed)

#### Testing:
- [ ] Test create pembayaran
- [ ] Test calculation accuracy
- [ ] Test sisa pinjaman updates
- [ ] Test lunas status triggers at sisa=0
- [ ] Test authorization

### Phase 9: Policies & Authorization 🔐
- [ ] Create SimpananPolicy
  - view() - only own
  - update() - only own
  - delete() - only own
  
- [ ] Create TabunganPolicy
  - view() - only own
  - update() - only own
  - setor() - only own
  - tarik() - only own
  
- [ ] Create PinjamanPolicy
  - view() - only own (or admin)
  - create() - authenticated users
  - approve() - admin only
  - reject() - admin only
  
- [ ] Create BayarPinjamanPolicy
  - view() - only own
  - create() - own pinjaman only
  - delete() - own only

- [ ] Add authorize() calls in all controllers
- [ ] Test policies work correctly

### Phase 10: Form Validation ✓
- [ ] Add validation rules in all controllers
- [ ] Display error messages in views
- [ ] Test validation for edge cases
- [ ] Test old values repopulation on error

### Phase 11: Integration Testing 🧪
- [ ] Test full simpanan flow
- [ ] Test full tabungan flow (create→setor→tarik)
- [ ] Test full pinjaman flow (create→approve→payment)
- [ ] Test cross-module relationships
- [ ] Test authorization on all pages

### Phase 12: Performance & Polish ✨
- [ ] Add pagination to all list views
- [ ] Add query optimization (eager loading)
- [ ] Add loading indicators (optional)
- [ ] Add success/error notifications
- [ ] Add number formatting (currency, dates)
- [ ] Test response times
- [ ] Add database indexes

### Phase 13: Deployment 🚀
- [ ] Setup environment variables (.env)
- [ ] Run migrations on production
- [ ] Run seeders (optional)
- [ ] Test all flows on production
- [ ] Setup error logging
- [ ] Monitor performance

---

## 6. Status Summary

| Component | Status | Priority |
|-----------|--------|----------|
| Database Schema | ✅ DONE | - |
| Models & Relations | ✅ DONE | - |
| Routes | ✅ DONE | - |
| Controllers (skeleton) | ✅ DONE | - |
| Register Page | ✅ DONE | - |
| Auth Flow | ⏳ TODO | HIGH |
| Base Layout | ⏳ TODO | HIGH |
| Dashboard | ⏳ TODO | HIGH |
| Simpanan Views | ⏳ TODO | MEDIUM |
| Tabungan Views | ⏳ TODO | MEDIUM |
| Pinjaman Views | ⏳ TODO | HIGH |
| Bayar Pinjaman Views | ⏳ TODO | HIGH |
| Form Validations | ⏳ TODO | MEDIUM |
| Policies | ⏳ TODO | MEDIUM |
| Testing | ⏳ TODO | LOW |
| Documentation | ✅ DONE | - |

---

## 7. Command Reference for Implementation

```bash
# Create missing migration if needed
php artisan make:migration add_field_to_table --table=table_name

# Create new controller
php artisan make:controller ControllerName --resource

# Create policy
php artisan make:policy PinjamanPolicy --model=pinjaman

# Run seeder
php artisan db:seed --class=SimpananSeeder

# Test specific test class
php artisan test tests/Feature/SimpananTest.php

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Serve locally
php artisan serve --host=127.0.0.1 --port=8000
```

---

**Document Version:** 1.0
**Created:** 2026-05-12
**Status:** Complete & Ready for Development

