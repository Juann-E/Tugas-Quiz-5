# Project Analysis & Implementation Report
## Quiz1 PBP - Laravel Finance Management System

### Project Overview
A Laravel-based financial management system for managing savings (simpanan), savings accounts (tabungan), loans (pinjaman), and loan payments (bayar_pinjaman).

---

## ✅ COMPLETED IMPLEMENTATION

### 1. **Models** (Updated with Relationships & Fillables)

#### `User.php` - Enhanced with Relations
- `simpanan()` - hasMany relationship
- `tabungan()` - hasMany relationship  
- `pinjaman()` - hasMany relationship
- `bayarPinjaman()` - hasMany relationship

#### `pinjaman.php` - Loan Model
- Fillable: user_id, kode_pinjaman, jumlah_pinjaman, bunga_persen, tenor_bulan, angsuran_per_bulan, total_bayar, sisa_pinjaman, tanggal_pengajuan, tanggal_disetujui, status, tujuan_pinjaman, keterangan
- Relationships: `user()` belongsTo User, `pembayaran()` hasMany bayar_pinjaman

#### `simpanan.php` - Savings Model
- Fillable: user_id, kode_simpanan, jenis_simpanan, jumlah, tanggal_simpan, keterangan
- Relationships: `user()` belongsTo User

#### `tabungan.php` - Savings Account Model
- Fillable: user_id, no_rekening, saldo, status
- Relationships: `user()` belongsTo User, `mutasi()` hasMany MutasiTabungan

#### `bayar_pinjaman.php` - Loan Payment Model
- Fillable: pinjaman_id, user_id, kode_bayar, ke_angsuran, jumlah_bayar, pokok_bayar, bunga_bayar, sisa_setelah_bayar, tanggal_bayar, metode_bayar, keterangan
- Relationships: `pinjaman()` belongsTo pinjaman, `user()` belongsTo User

#### `MutasiTabungan.php` - NEW Savings Transaction Model
- Fillable: tabungan_id, jenis, jumlah, saldo_sebelum, saldo_sesudah, tanggal_transaksi, keterangan
- Relationships: `tabungan()` belongsTo tabungan

---

### 2. **Controllers** (4 New Controllers Created)

#### `SimpananController.php`
- **index()** - List all user's savings
- **create()** - Show create form
- **store()** - Save new savings record
- **show()** - Display specific savings
- **edit()** - Show edit form
- **update()** - Update savings record
- **destroy()** - Delete savings record
- Auto-generate kode_simpanan (SMP-0001, SMP-0002, etc.)

#### `TabunganController.php`
- **index()** - List all user's savings accounts with total balance
- **create()** - Show account creation form
- **store()** - Create new savings account
- **show()** - Display account details and transaction history
- **setor()** - Deposit money (increases balance, records mutasi)
- **tarik()** - Withdraw money (decreases balance with validation, records mutasi)
- Auto-generate no_rekening (REK-0001, REK-0002, etc.)

#### `PinjamanController.php`
- **index()** - List all user's loans
- **create()** - Show loan application form
- **store()** - Submit loan application with automatic calculations
  - Calculates: angsuran_per_bulan, total_bayar (pokok + bunga), sisa_pinjaman
  - Uses formula: Total Bunga = (Principal × Rate × Time) / 100
- **show()** - Display loan details and payment history
- **edit()** - Show edit form (only for 'menunggu' status)
- **update()** - Update loan (recalculates all values)
- **approve()** - Change status to 'disetujui'
- **reject()** - Change status to 'ditolak'
- Auto-generate kode_pinjaman (PIN-0001, PIN-0002, etc.)

#### `BayarPinjamanController.php`
- **index()** - List all loan payments for user + active loans
- **create()** - Show payment form with pre-calculated amount
- **store()** - Record loan payment
  - Validates payment amount doesn't exceed sisa_pinjaman
  - Auto-calculates pokok_bayar and bunga_bayar
  - Updates pinjaman sisa_pinjaman
  - Changes loan status to 'lunas' when fully paid
- **show()** - Display payment details
- Auto-generate kode_bayar (BAY-0001, BAY-0002, etc.)

---

### 3. **Routes** (Updated web.php)

```php
// Public Routes
GET  /                    - Welcome page
GET  /login               - Login form
GET  /register            - Register form
GET  /home                - Home page
GET  /dashboard           - Dashboard
GET  /transaksi           - Transactions page
GET  /dompet              - Wallet page
GET  /profil              - Profile page

// Protected Routes (Auth Required)
GET    /simpanan           - List all savings
POST   /simpanan           - Create new savings
GET    /simpanan/create    - Show create form
GET    /simpanan/{id}      - Show specific savings
GET    /simpanan/{id}/edit - Show edit form
PUT    /simpanan/{id}      - Update savings
DELETE /simpanan/{id}      - Delete savings

GET    /tabungan           - List all accounts
POST   /tabungan           - Create new account
GET    /tabungan/create    - Show create form
GET    /tabungan/{id}      - Show account details
POST   /tabungan/{id}/setor   - Deposit money
POST   /tabungan/{id}/tarik   - Withdraw money

GET    /pinjaman           - List all loans
POST   /pinjaman           - Submit loan application
GET    /pinjaman/create    - Show application form
GET    /pinjaman/{id}      - Show loan details
GET    /pinjaman/{id}/edit - Show edit form
PUT    /pinjaman/{id}      - Update loan
POST   /pinjaman/{id}/approve - Approve loan
POST   /pinjaman/{id}/reject  - Reject loan

GET    /bayar-pinjaman     - List all payments
POST   /bayar-pinjaman     - Record payment
GET    /bayar-pinjaman/create - Show payment form
GET    /bayar-pinjaman/{id}   - Show payment details
```

---

## 📊 Business Logic Implemented

### Savings (Simpanan)
- Users can create multiple savings records
- Each record tracks: jenis_simpanan (pokok/wajib/sukarela), amount, date
- Auto-generated codes for reference

### Savings Account (Tabungan)
- Users create savings accounts with initial balance
- Track balance changes through mutasi_tabungan table
- Deposit (setor) and withdraw (tarik) operations
- Balance validation for withdrawals
- Transaction history maintained

### Loan (Pinjaman)
- Calculate angsuran (installment) based on: Principal, Interest Rate, Tenor
- Formula: Total Bunga = (Pokok × Rate% × Tenor) / 100
- Auto-calculate: Total Bayar = Pokok + Total Bunga, Angsuran = Total Bayar / Tenor
- Status workflow: menunggu → disetujui/ditolak → lunas
- Track remaining loan balance (sisa_pinjaman)
- Only editable in 'menunggu' status

### Loan Payment (Bayar Pinjaman)
- Track each installment payment
- Separate pokok_bayar (principal portion) and bunga_bayar (interest portion)
- Auto-calculate sisa_pinjaman after each payment
- Update loan status to 'lunas' when fully paid
- Payment methods: tunai (cash) or transfer
- Auto-numbered payment codes

---

## 📂 File Structure Created/Modified

```
Controllers:
  ✅ SimpananController.php (NEW)
  ✅ TabunganController.php (NEW)
  ✅ PinjamanController.php (NEW)
  ✅ BayarPinjamanController.php (NEW)

Models:
  ✅ User.php (UPDATED - added relationships)
  ✅ pinjaman.php (UPDATED - added relationships & fillables)
  ✅ simpanan.php (UPDATED - added relationships & fillables)
  ✅ tabungan.php (UPDATED - added relationships & fillables)
  ✅ bayar_pinjaman.php (UPDATED - added relationships & fillables)
  ✅ MutasiTabungan.php (NEW)

Routes:
  ✅ web.php (UPDATED - added resource routes)
```

---

## 🔒 Security Features

- **Authorization**: Uses `authorize()` method in controllers to verify ownership
- **Validation**: Comprehensive input validation in all forms
- **Balance Checks**: Prevents invalid withdrawals and overpayments
- **Status Validation**: Ensures operations only on appropriate statuses
- **User Isolation**: All queries filtered by `auth()->id()`

---

## ⚡ Next Steps (Optional Enhancements)

1. Create blade view templates for forms and listings
2. Add policy classes for authorization
3. Add model factories and seeders for testing
4. Implement email notifications for loan approvals
5. Add dashboard statistics and reporting
6. Add admin panel for loan approval
7. Add API endpoints for mobile app
8. Implement transaction export (PDF/Excel)
9. Add audit logs
10. Add email verification for users

---

**Status**: ✅ All core functionality implemented and ready for testing
