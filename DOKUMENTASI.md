# DOKUMENTASI SIPKOS - Sistem Informasi Pengelolaan Kos

## 1. ANALISIS KEBUTUHAN SISTEM

### 1.1 Deskripsi Sistem
SIPKOS adalah sistem informasi untuk mengelola data kos-kostan mencakup:
- Manajemen kamar kos
- Data penghuni
- Pengelolaan pembayaran sewa
- Laporan dan statistik
- Sistem autentikasi role-based

### 1.2 Aktor Sistem
1. **Admin**: Mengelola semua data sistem, melihat laporan, statistik
2. **Penghuni/User**: Melihat informasi kamar, riwayat pembayaran, profil

### 1.3 Fitur Utama Sistem

#### A. Authentication & User Management
- [x] Register pengguna baru
- [x] Login dengan email/username
- [x] Logout
- [x] Session management
- [x] Password hashing (bcrypt)
- [x] Middleware proteksi route

#### B. Dashboard
- [x] Statistik jumlah kamar total
- [x] Jumlah penghuni aktif
- [x] Jumlah kamar kosong
- [x] Total pembayaran bulan ini
- [x] Grafik pembayaran (chart.js)
- [x] Daftar pembayaran terbaru

#### C. CRUD Kamar
- [x] Tambah kamar (nomor, tipe, harga, fasilitas, foto)
- [x] Edit data kamar
- [x] Hapus kamar
- [x] Detail kamar
- [x] Upload foto kamar
- [x] Filter by tipe/status
- [x] Pagination

#### D. CRUD Penghuni
- [x] Tambah data penghuni
- [x] Edit data penghuni
- [x] Hapus penghuni
- [x] Detail penghuni
- [x] Lihat riwayat pembayaran penghuni
- [x] Pagination & search

#### E. CRUD Pembayaran
- [x] Catat pembayaran sewa
- [x] Edit data pembayaran
- [x] Hapus pembayaran
- [x] Status pembayaran (lunas/pending)
- [x] Filter by status/bulan
- [x] Pagination

#### F. Laporan
- [x] Laporan pembayaran bulanan
- [x] Filter by tanggal/bulan
- [x] Export to PDF
- [x] Statistik pembayaran

### 1.4 Atribut Entitas

#### Users
- id_user (PK)
- nama
- email (unique)
- username (unique)
- password (hashed)
- role (admin/penghuni)
- created_at

#### Kamar
- id_kamar (PK)
- nomor_kamar (unique)
- tipe_kamar (single/double)
- harga
- status (tersedia/terisi/maintenance)
- fasilitas
- foto
- created_at

#### Penghuni
- id_penghuni (PK)
- nama
- email
- nomor_hp
- alamat_asal
- tanggal_masuk
- id_kamar (FK)
- user_id (FK)
- status (aktif/tidak_aktif)
- created_at

#### Pembayaran
- id_pembayaran (PK)
- id_penghuni (FK)
- bulan
- tahun
- tanggal_bayar
- total_bayar
- status (lunas/pending)
- keterangan
- created_at

---

## 2. USE CASE DIAGRAM

```
┌─────────────────────────────────────────────────────────────┐
│                        SYSTEM SIPKOS                         │
└─────────────────────────────────────────────────────────────┘

                    ┌──────────────────┐
                    │      Admin       │
                    └────────┬─────────┘
                             │
          ┌──────────────────┼──────────────────┐
          │                  │                  │
      ◯ Login           ◯ View Dashboard   ◯ Manage Kamar
          │                  │              ├─ Create
          │                  │              ├─ Read
          │                  │              ├─ Update
          │                  │              └─ Delete
          │                  │
      ◯ Manage Penghuni  ◯ Manage Pembayaran  ◯ View Laporan
          │                  │
      ├─ Create            ├─ Create
      ├─ Read              ├─ Read
      ├─ Update            ├─ Update
      ├─ Delete            └─ Delete
      
                    ┌──────────────────┐
                    │    Penghuni      │
                    └────────┬─────────┘
                             │
      ┌──────────────────────┼──────────────────────┐
      │                      │                      │
  ◯ Login             ◯ View Profil      ◯ View Pembayaran
      │                      │                      │
      └──────────────────────┴──────────────────────┘
```

---

## 3. ACTIVITY DIAGRAM

### Login Activity
```
[Start] → Input Email/Password → Validasi Kredensial
              ↓
         ✓ Valid?
        ↙     ↘
      Yes      No → Display Error → [End]
      ↓
   Check Role
   ↙      ↘
Admin   Penghuni
  ↓         ↓
Redirect  Redirect
Admin     Dashboard
Dashboard Penghuni
  ↓         ↓
[End]     [End]
```

### CRUD Kamar Activity
```
[Start] → Admin Menu → Choose Action
                    ├─ Add → Input Data → Upload Foto → Validasi
                    │                          ↓
                    │                      Valid? → Save DB → Success [End]
                    │                          ↓
                    │                       Invalid → Error [End]
                    │
                    ├─ Edit → Select Kamar → Input Data → Validasi → Update [End]
                    │
                    ├─ Delete → Select Kamar → Confirm → Delete [End]
                    │
                    └─ View → Display List → Pagination/Search [End]
```

---

## 4. ENTITY RELATIONSHIP DIAGRAM (ERD)

```
┌─────────────────┐
│     Users       │
├─────────────────┤
│ id_user (PK)    │
│ nama            │
│ email (U)       │
│ username (U)    │
│ password        │
│ role            │
│ created_at      │
└────────┬────────┘
         │1
         │
      (1:N)
         │
         │N
    ┌────┴──────────────────────┐
    │                           │
    │1                          │
┌───┴──────────────┐    ┌──────┴────────┐
│    Penghuni      │    │     Kamar      │
├──────────────────┤    ├────────────────┤
│id_penghuni (PK)  │    │ id_kamar (PK)  │
│ nama             │    │ nomor_kamar(U) │
│ email            │    │ tipe_kamar     │
│ nomor_hp         │    │ harga          │
│ alamat_asal      │    │ status         │
│ tanggal_masuk    │    │ fasilitas      │
│ id_kamar (FK)    │◄───┤ foto           │
│ user_id (FK)     │1   │ created_at     │
│ status           │    └────────────────┘
│ created_at       │
└────┬─────────────┘
     │1
     │
  (1:N)
     │
     │N
     │
┌────┴─────────────────┐
│    Pembayaran        │
├──────────────────────┤
│ id_pembayaran (PK)   │
│ id_penghuni (FK)     │
│ bulan                │
│ tahun                │
│ tanggal_bayar        │
│ total_bayar          │
│ status               │
│ keterangan           │
│ created_at           │
└──────────────────────┘

Legend:
PK = Primary Key
FK = Foreign Key
U = Unique
(1:N) = One to Many
```

---

## 5. STRUKTUR DATABASE

### Relasi Tabel
1. **Users ← Penghuni** (1:N) - Satu user dapat menjadi penghuni di satu kamar
2. **Users ← Pembayaran** (1:N) melalui Penghuni - Admin catat pembayaran penghuni
3. **Kamar ← Penghuni** (1:N) - Satu kamar dapat ditempati satu penghuni
4. **Penghuni ← Pembayaran** (1:N) - Satu penghuni dapat memiliki banyak pembayaran

### Normalisasi
- 1NF: Setiap atribut bernilai atomik ✓
- 2NF: Semua atribut non-key bergantung pada PK ✓
- 3NF: Tidak ada ketergantungan transitif ✓

---

## 6. TEKNOLOGI & TOOLS

### Backend
- PHP 7.4+ (Native)
- MySQL 5.7+
- OOP Principles
- PDO/MySQLi

### Frontend
- HTML5
- CSS3
- Bootstrap 5
- JavaScript (Vanilla)
- Chart.js (untuk grafik)
- DataTables (untuk tabel dinamis)

### Tools
- Composer (PSR-4 Autoloading)
- FPDF (PDF Export)
- Git (Version Control)

---

## 7. FITUR KEAMANAN

1. ✓ Password Hashing (bcrypt)
2. ✓ Session Management
3. ✓ CSRF Protection (token)
4. ✓ Input Validation
5. ✓ SQL Injection Prevention (Prepared Statements)
6. ✓ XSS Prevention (htmlspecialchars)
7. ✓ Role-Based Access Control

---

## 8. RENCANA IMPLEMENTASI

### Phase 1: Setup & Foundation
- [ ] Struktur folder MVC
- [ ] Konfigurasi database
- [ ] Database class
- [ ] Base Controller & Model
- [ ] Routing system
- [ ] SQL schema

### Phase 2: Authentication
- [ ] User model & controller
- [ ] Login form & validation
- [ ] Register form
- [ ] Session management
- [ ] Logout
- [ ] Middleware

### Phase 3: Core Features
- [ ] CRUD Kamar
- [ ] CRUD Penghuni
- [ ] CRUD Pembayaran
- [ ] Dashboard

### Phase 4: Additional Features
- [ ] Upload gambar
- [ ] Laporan PDF
- [ ] Pagination
- [ ] Search & Filter
- [ ] Validasi form

### Phase 5: UI & Polish
- [ ] Responsive design
- [ ] CSS styling
- [ ] Layout Figma
- [ ] Testing
- [ ] Documentation

---

Dokumen ini akan terus diperbarui seiring pengembangan proyek.
