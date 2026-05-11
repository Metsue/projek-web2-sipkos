# 📚 DOKUMENTASI INDEX - SIPKOS

Panduan lengkap untuk menavigasi dokumentasi SIPKOS.

---

## 🚀 Mulai Dari Sini

### Untuk Pengguna Baru (Setup)
1. **[README.md](README.md)** ← START HERE
   - Deskripsi singkat aplikasi
   - Persyaratan sistem
   - Langkah instalasi cepat
   - Struktur folder
   - FAQ cepat

2. **[SETUP.md](SETUP.md)** ← JIKA ADA MASALAH
   - Setup detail step-by-step
   - Konfigurasi database
   - Troubleshooting 6 kategori
   - Tips & tricks
   - Security checklist

---

## 📖 Untuk Memahami Sistem

### 1. Sistem Design & Architecture
**File: [DOKUMENTASI.md](DOKUMENTASI.md)**

Berisi:
- [x] Deskripsi sistem (apa itu SIPKOS)
- [x] User roles & actors
- [x] Fitur-fitur lengkap
- [x] Entity Relationship Diagram (ERD)
- [x] Use case diagram
- [x] Activity diagram
- [x] Technology stack
- [x] Database schema detail

**Kapan membaca:**
- Ingin memahami sistem secara keseluruhan
- Perlu dokumentasi untuk project
- Ingin lihat diagram & flowchart
- Butuh daftar teknologi yang digunakan

---

### 2. OOP & MVC Implementation
**File: [IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md)**

Berisi:
- [x] Penjelasan OOP concepts
  - Encapsulation dengan contoh
  - Inheritance dengan contoh
  - Polymorphism dengan contoh
  - Abstraction
  - Constructor
- [x] MVC Pattern explanation
  - Model layer (data)
  - View layer (presentation)
  - Controller layer (logic)
  - MVC flow lengkap
- [x] Class structure explanation
  - Base Model class
  - Base Controller class
  - Router system
- [x] Database layer (PDO)
- [x] Authentication flow
- [x] CRUD operation examples
- [x] File upload handling
- [x] Session management
- [x] Input validation
- [x] Best practices

**Kapan membaca:**
- Ingin pelajari OOP concepts
- Ingin pahami MVC architecture
- Ingin lihat code examples
- Sedang belajar web development
- Ingin improve coding skills

**Contoh code snippets:**
```php
// Di dalamnya ada contoh:
// - Cara membuat class
// - Cara extend class
// - Cara menggunakan Model
// - Cara membuat Controller
// - Cara validate input
// - Cara handle upload
```

---

## 🛠️ Untuk Development

### 1. Setup & Configuration
**File: [SETUP.md](SETUP.md)**

Bagian-bagian penting:
- Step 1: Persiapan file
- Step 2: Konfigurasi database
- Step 3: Konfigurasi PHP
- Step 4: Jalankan aplikasi
- Troubleshooting (6 kategori)
- Testing checklist

**Gunakan untuk:**
- Pertama kali setup aplikasi
- Jika ada error saat jalankan
- Ingin optimize performance
- Ingin setup security

---

### 2. Development Workflow
**File: [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)**

Isi lengkap:
- [x] Development workflow (planning → deployment)
- [x] Cara menambah fitur baru
- [x] Contoh lengkap: Fitur "Pesan Kamar"
  - Buat database schema
  - Buat model
  - Buat controller
  - Tambah routes
  - Buat views
  - Test fitur
- [x] Struktur file yang benar
- [x] Naming convention
- [x] Code standards
- [x] Testing patterns
- [x] Debugging techniques
- [x] Performance optimization
- [x] Deployment checklist

**Gunakan untuk:**
- Menambah fitur baru
- Memahami workflow development
- Membuat code yang konsisten
- Optimize performance
- Deploy ke production

**Contoh di dalamnya:**
```php
// Complete example: Add "Pesan Kamar" feature
// 1. Database: CREATE TABLE pemesanan
// 2. Model: class Pemesanan extends Model
// 3. Controller: class PemesananController
// 4. Routes: $router->get('/pemesanan', ...)
// 5. Views: app/views/pemesanan/index.php
// 6. Test: Run feature & verify
```

---

## 📋 Quick Reference

### File Structure
**Lihat di:** [README.md - Folder Structure](README.md#-folder-structure)

Struktur lengkap:
```
projek-web2-sipkos/
├── app/
│   ├── core/          (Base classes)
│   ├── models/        (Data layer)
│   ├── controllers/   (Logic layer)
│   └── views/         (Presentation)
├── config/            (Database config)
├── routes/            (URL routing)
├── public/            (Frontend files)
└── Documentation/
```

---

### Database Schema
**Lihat di:** [README.md - Database Schema](README.md#-database-schema)

5 Tabel utama:
1. users (authentication)
2. kamar (room management)
3. penghuni (resident data)
4. pembayaran (payment tracking)
5. aktivitas_log (audit trail)

---

### Security Measures
**Lihat di:** [README.md - Security](README.md#-security)

Implementasi:
- [x] Password hashing (bcrypt)
- [x] SQL injection prevention (PDO)
- [x] XSS prevention (escaping)
- [x] Session security
- [x] File upload validation

---

## 🔍 Topik-Topik Spesifik

### Authentication
**Lihat di:**
- [IMPLEMENTASI_OOP_MVC.md - Authentication Flow](IMPLEMENTASI_OOP_MVC.md#5-authentication-flow)
- [README.md - How It Works](README.md#-how-it-works)

### CRUD Operations
**Lihat di:**
- [IMPLEMENTASI_OOP_MVC.md - CRUD Example](IMPLEMENTASI_OOP_MVC.md#6-crud-operation-example)
- Code di: `app/controllers/AdminController.php`

### File Upload
**Lihat di:**
- [IMPLEMENTASI_OOP_MVC.md - File Upload](IMPLEMENTASI_OOP_MVC.md#7-file-upload-handling)
- Code di: `app/controllers/AdminController.php` method `uploadFoto()`

### Database
**Lihat di:**
- [DOKUMENTASI.md - Database Schema](DOKUMENTASI.md#-database-schema)
- [README.md - Database Schema Detail](README.md#-database-schema-detail)
- File: `config/sipkos_db.sql`

### Routing
**Lihat di:**
- [IMPLEMENTASI_OOP_MVC.md - Router Class](IMPLEMENTASI_OOP_MVC.md#c-router-class)
- Code di: `app/core/Router.php` dan `routes/web.php`

### Validation
**Lihat di:**
- [IMPLEMENTASI_OOP_MVC.md - Input Validation](IMPLEMENTASI_OOP_MVC.md#9-input-validation)
- Code di: `app/core/Controller.php` method `validate()`

---

## 📊 Project Status

**File: [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)**

Berisi:
- Status project (100% complete)
- Statistics
- Feature checklist
- Architecture decisions
- Performance metrics
- Quality metrics
- Future enhancements

---

## ✅ Verification

**File: [FINAL_CHECKLIST.md](FINAL_CHECKLIST.md)**

Berisi:
- File structure verification
- Feature checklist
- Security checklist
- Database verification
- Code quality checklist
- Documentation checklist
- Deployment readiness

**Gunakan untuk:**
- Verify semua file ada
- Pastikan semua fitur implemented
- Confirm security measures
- Pre-deployment check

---

## 🎓 Learning Path

### Untuk Pemula (Baru kenal web development)
1. Baca [README.md](README.md) - Pahami apa itu SIPKOS
2. Baca [DOKUMENTASI.md](DOKUMENTASI.md) - Lihat design & diagram
3. Baca [IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md) - Pelajari konsep
4. Setup aplikasi dengan [SETUP.md](SETUP.md)
5. Explore code files di `app/` folder
6. Buat fitur kecil dengan [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)

### Untuk Developer (Sudah familiar)
1. Baca [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Overview
2. Setup dengan [SETUP.md](SETUP.md)
3. Explore code structure
4. Baca [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md) jika mau add feature
5. Refer ke [IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md) untuk spesifik

### Untuk Project Manager
1. Baca [README.md](README.md) - Features & requirements
2. Baca [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - Status & metrics
3. Check [FINAL_CHECKLIST.md](FINAL_CHECKLIST.md) - Verification
4. Lihat [DOKUMENTASI.md](DOKUMENTASI.md) - Design & scope

---

## 📞 Troubleshooting Quick Links

**Jika ada error:**
1. Baca [SETUP.md - Troubleshooting](SETUP.md#-troubleshooting)
2. Cek error log (lihat di SETUP.md)
3. Lihat FINAL_CHECKLIST untuk verify setup

**Jika ingin add feature:**
1. Lihat [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)
2. Ikuti workflow step-by-step
3. Refer ke existing code untuk pattern

**Jika ingin pelajari code:**
1. Mulai dari [IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md)
2. Baca code comments di files
3. Trace dari Controller → Model → Database

---

## 📄 File Descriptions Summary

| File | Purpose | Audience |
|------|---------|----------|
| README.md | Quick start & overview | Everyone |
| SETUP.md | Detailed setup & troubleshooting | Developers, Ops |
| DOKUMENTASI.md | System design & architecture | Architects, Analysts |
| IMPLEMENTASI_OOP_MVC.md | Technical explanation | Developers, Learners |
| DEVELOPMENT_GUIDE.md | How to add features | Developers |
| PROJECT_SUMMARY.md | Project status & metrics | Managers, Reviewers |
| FINAL_CHECKLIST.md | Verification checklist | QA, Ops |
| DOCUMENTATION_INDEX.md | This file - Navigation | Everyone |

---

## 🎯 Common Use Cases

### "Bagaimana cara setup aplikasi?"
→ Mulai dengan [README.md](README.md), lalu detail di [SETUP.md](SETUP.md)

### "Ada error, bagaimana solusinya?"
→ Lihat [SETUP.md - Troubleshooting](SETUP.md#-troubleshooting)

### "Gimana cara menambah fitur baru?"
→ Ikuti [DEVELOPMENT_GUIDE.md](DEVELOPMENT_GUIDE.md)

### "Saya ingin pelajari OOP dan MVC"
→ Baca [IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md)

### "Apa aja fitur yang ada?"
→ Lihat [README.md](README.md) atau [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)

### "Bagaimana sistem database-nya?"
→ Lihat [DOKUMENTASI.md - Database](DOKUMENTASI.md#-database-schema)

### "Apakah aplikasi sudah siap deploy?"
→ Check [FINAL_CHECKLIST.md](FINAL_CHECKLIST.md)

### "Gimana security implementasi-nya?"
→ Lihat [README.md - Security](README.md#-security)

---

## 📚 Cross-References

### Dari README.md
- [Security explanation → IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md#-best-practices-implemented)
- [How it works → DOKUMENTASI.md](DOKUMENTASI.md)
- [Setup issues → SETUP.md](SETUP.md#-troubleshooting)

### Dari SETUP.md
- [Database schema → config/sipkos_db.sql](config/sipkos_db.sql)
- [Database explanation → DOKUMENTASI.md](DOKUMENTASI.md#-database-schema)
- [Controller code → app/controllers/](app/controllers/)

### Dari DEVELOPMENT_GUIDE.md
- [OOP concepts → IMPLEMENTASI_OOP_MVC.md](IMPLEMENTASI_OOP_MVC.md#1-object-oriented-programming-oop)
- [Database design → DOKUMENTASI.md](DOKUMENTASI.md#-database-schema)
- [Code examples → app/ folder](app/)

---

## 🔗 File Tree

```
DOKUMENTASI SIPKOS/
├── README.md                      ← START HERE
│   └── Instalasi & deskripsi
├── SETUP.md                       ← Jika ada masalah
│   └── Setup detail & troubleshooting
├── DOKUMENTASI.md                 ← Untuk memahami sistem
│   └── Design, ERD, use case
├── IMPLEMENTASI_OOP_MVC.md        ← Untuk pelajar OOP/MVC
│   └── Konsep & code examples
├── DEVELOPMENT_GUIDE.md           ← Untuk add feature
│   └── Workflow & best practices
├── PROJECT_SUMMARY.md             ← Untuk status
│   └── Overview & metrics
├── FINAL_CHECKLIST.md             ← Untuk verify
│   └── Verification checklist
└── DOCUMENTATION_INDEX.md         ← Ini file
    └── Navigation guide
```

---

## ✨ Tips

### Best Practice Membaca Dokumentasi
1. **Jangan baca semua sekaligus** - Baca sesuai kebutuhan
2. **Mulai dari README** - Dapatkan overview dulu
3. **Gunakan index ini** - Navigasi ke file yang dibutuhkan
4. **Code reading** - Baca file di `app/` untuk lihat implementasi
5. **Search di file** - Cari topik spesifik dengan Ctrl+F

### Cara Menggunakan Links
- Gunakan Ctrl+Click untuk buka file di editor
- Atau copy path dan buka manual
- Atau gunakan fitur search di IDE

---

## 📞 Need Help?

Jika masih bingung:
1. **Topik spesifik?** → Cari di tabel di atas
2. **Error?** → Cek SETUP.md troubleshooting
3. **Ingin code example?** → Baca IMPLEMENTASI_OOP_MVC.md
4. **Ingin development?** → Ikuti DEVELOPMENT_GUIDE.md

---

## 🎉 Final Note

Dokumentasi SIPKOS dirancang untuk:
- ✅ Easy to navigate
- ✅ Complete coverage
- ✅ Multiple audiences
- ✅ Quick reference
- ✅ Learning resource

**Gunakan index ini sebagai panduan navigasi!**

---

Versi: 1.0.0
Last Updated: 2024
