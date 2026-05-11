# SIPKOS - Sistem Informasi Pengelolaan Kos

Aplikasi web untuk mengelola sistem informasi pengelolaan kos-kostan dengan fitur lengkap meliputi manajemen kamar, penghuni, pembayaran, dan laporan.

## 🚀 Fitur Utama

### Authentication & Authorization
- ✅ Login / Register
- ✅ Role-based Access (Admin & Penghuni)
- ✅ Session Management
- ✅ Password Hashing (Bcrypt)
- ✅ Logout

### Dashboard Admin
- ✅ Statistik Kamar (Total, Terisi, Kosong)
- ✅ Statistik Penghuni
- ✅ Statistik Pembayaran Bulanan
- ✅ Grafik & Chart
- ✅ Pembayaran Terbaru
- ✅ Quick Access Links

### Management Kamar
- ✅ CRUD Kamar (Create, Read, Update, Delete)
- ✅ Upload Foto Kamar
- ✅ Filter by Tipe & Status
- ✅ Manajemen Fasilitas
- ✅ Pagination & Search

### Management Penghuni
- ✅ CRUD Penghuni
- ✅ Assign Kamar
- ✅ Status Penghuni (Aktif/Tidak Aktif)
- ✅ Riwayat Pembayaran
- ✅ Pagination & Search

### Management Pembayaran
- ✅ CRUD Pembayaran
- ✅ Catat Pembayaran Sewa
- ✅ Status Pembayaran (Lunas/Pending)
- ✅ Filter by Status & Bulan
- ✅ Pagination

### Dashboard Penghuni
- ✅ View Kamar Pribadi
- ✅ Lihat Riwayat Pembayaran
- ✅ Update Profil
- ✅ Status Pembayaran

### Laporan
- ✅ Laporan Pembayaran Bulanan
- ✅ Filter by Tanggal
- ✅ Export PDF (Coming Soon)

### UI/UX
- ✅ Responsive Design
- ✅ Modern & Minimalis
- ✅ Sidebar Navigation
- ✅ Bootstrap 5
- ✅ Font Awesome Icons
- ✅ DataTables Integration

## 📋 Persyaratan Sistem

- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx
- Web Browser Modern

## 🛠️ Instalasi

### 1. Clone/Download Project
```bash
cd c:\xampp\htdocs\projek-web2-sipkos
```

### 2. Konfigurasi Database
```bash
# Buka phpMyAdmin
http://localhost/phpmyadmin
```

- Buat database baru: `sipkos_db`
- Import file SQL: `config/sipkos_db.sql`

Atau jalankan script SQL manual:
```sql
CREATE DATABASE IF NOT EXISTS sipkos_db;
USE sipkos_db;
-- Import dari config/sipkos_db.sql
```

### 3. Konfigurasi Database Connection
Edit file: `config/database.php`

```php
private $host = 'localhost';
private $db_name = 'sipkos_db';
private $user = 'root';
private $pass = '';  // Kosong untuk default XAMPP
```

### 4. Akses Aplikasi
```
http://localhost/projek-web2-sipkos/
```

### 5. Login Pertama Kali
**Akun Admin:**
- Email: `admin@sipkos.com`
- Username: `admin`
- Password: `password123` (silahkan ganti setelah login)

## 📁 Struktur Folder

```
project-root/
│
├── app/
│   ├── controllers/        # Tempat logic aplikasi
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── PageController.php
│   │   └── PenghuniController.php
│   │
│   ├── models/            # Tempat query database
│   │   ├── User.php
│   │   ├── Kamar.php
│   │   ├── Penghuni.php
│   │   ├── Pembayaran.php
│   │   └── LogActivity.php
│   │
│   ├── views/             # Tempat template HTML
│   │   ├── layouts/
│   │   │   ├── master.php
│   │   │   ├── sidebar.php
│   │   │   └── navbar.php
│   │   ├── auth/
│   │   ├── admin/
│   │   └── penghuni/
│   │
│   └── core/              # Kelas dasar framework
│       ├── Controller.php
│       ├── Model.php
│       └── Router.php
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/
│       └── kamar/         # Upload foto kamar
│
├── config/
│   ├── database.php       # Konfigurasi database
│   └── sipkos_db.sql      # Database schema
│
├── routes/
│   └── web.php            # Definisi routes aplikasi
│
├── index.php              # Entry point aplikasi
└── DOKUMENTASI.md         # Dokumentasi lengkap
```

## 🔄 Alur Aplikasi

### 1. Entry Point (index.php)
```
index.php
  ↓
Session Start & Constants Define
  ↓
Autoloader Register
  ↓
Database Config Load
  ↓
Router Initialize
  ↓
Routes Load (web.php)
  ↓
Request Dispatch
  ↓
Controller Execute
  ↓
View Render
```

### 2. MVC Flow
```
Request
  ↓
Router -> Controller
  ↓
Controller -> Model (Query DB)
  ↓
Model -> Database
  ↓
Controller -> View (Data Pass)
  ↓
View -> Response (HTML Render)
```

## 🔐 Keamanan

### Implementasi Keamanan:
1. **Password Hashing**: Menggunakan `password_hash()` dengan algorithm BCRYPT
2. **SQL Injection Prevention**: Prepared Statements dengan PDO
3. **XSS Prevention**: Output dengan `htmlspecialchars()`
4. **CSRF Protection**: Session token (bisa ditambahkan)
5. **Session Management**: Check login sebelum akses halaman
6. **Role-Based Access**: Middleware untuk check role user
7. **File Upload Validation**: Check tipe & ukuran file

## 📱 Responsive Design

- ✅ Desktop (1200px+)
- ✅ Tablet (768px - 1199px)
- ✅ Mobile (< 768px)
- ✅ Toggle Sidebar (Mobile)
- ✅ Responsive Tables
- ✅ Touch-friendly Buttons

## 🗄️ Database Schema

### Tabel Users
```sql
- id_user (PK)
- nama
- email (UNIQUE)
- username (UNIQUE)
- password (HASHED)
- role (admin/penghuni)
- foto_profil
- created_at
- updated_at
```

### Tabel Kamar
```sql
- id_kamar (PK)
- nomor_kamar (UNIQUE)
- tipe_kamar (single/double/triple)
- harga
- status (tersedia/terisi/maintenance)
- fasilitas
- foto
- deskripsi
- created_at
- updated_at
```

### Tabel Penghuni
```sql
- id_penghuni (PK)
- nama
- email
- nomor_hp
- alamat_asal
- tanggal_masuk
- id_kamar (FK -> kamar)
- user_id (FK -> users)
- status (aktif/tidak_aktif)
- created_at
- updated_at
```

### Tabel Pembayaran
```sql
- id_pembayaran (PK)
- id_penghuni (FK -> penghuni)
- bulan
- tahun
- tanggal_bayar
- total_bayar
- status (lunas/pending/terlambat)
- keterangan
- bukti_bayar
- created_at
- updated_at
```

## 🎯 OOP Concepts Used

1. **Encapsulation**
   ```php
   protected $table;      // Encapsulated property
   private $last_error;   // Restricted access
   ```

2. **Inheritance**
   ```php
   class User extends Model { }
   class AdminController extends Controller { }
   ```

3. **Polymorphism**
   ```php
   public function insert($data) { }  // Base class
   // Bisa di-override di child class
   ```

4. **Abstraction**
   ```php
   // Base Model menyediakan interface
   // Child models hanya menggunakan
   ```

5. **Constructor**
   ```php
   public function __construct() {
       $this->db = new Database()->connect();
   }
   ```

## 🚀 Penggunaan API Routes

### Authentication Routes
```
GET    /login              → Show login form
POST   /login              → Process login
GET    /register           → Show register form
POST   /register           → Process register
GET    /logout             → Logout
```

### Admin Routes
```
GET    /admin              → Dashboard
GET    /admin/kamar        → List kamar
POST   /admin/kamar/store  → Store kamar
GET    /admin/kamar/edit?id=X  → Edit form
POST   /admin/kamar/update?id=X → Update
GET    /admin/kamar/delete?id=X → Delete
GET    /admin/kamar/show?id=X   → Detail

(Similar pattern untuk penghuni & pembayaran)
```

### Penghuni Routes
```
GET    /penghuni/dashboard     → Dashboard penghuni
GET    /penghuni/profil        → View profil
POST   /penghuni/profil/update → Update profil
GET    /penghuni/pembayaran    → Riwayat pembayaran
```

## 💡 Tips & Tricks

### 1. Menambah Controller Baru
```php
class NamaController extends Controller {
    public function methodName() {
        // Logic here
    }
}
```

### 2. Menambah Model Baru
```php
class NamaModel extends Model {
    protected $table = 'nama_tabel';
}
```

### 3. Menambah Route Baru
```php
$router->get('/path', 'controller@method');
$router->post('/path', 'controller@method');
```

### 4. Akses Database
```php
// Dalam controller/model
require_once APP . 'models/Kamar.php';
$kamar = new Kamar();
$result = $kamar->getAll();
```

## 🐛 Troubleshooting

### 1. 404 Not Found
- Periksa routing di `routes/web.php`
- Pastikan controller & method ada
- Check URL format

### 2. Database Connection Error
- Pastikan database sudah dibuat
- Check config di `config/database.php`
- Verify MySQL running

### 3. File Upload Error
- Check folder permissions: `public/uploads/kamar`
- Verify file size < 2MB
- Check file type (JPG, PNG, GIF)

### 4. Session Lost
- Check `session_start()` di index.php
- Verify cookies enabled
- Check browser cookie settings

## 📝 Development Notes

### Next Phase Development:
- [ ] Export PDF dengan FPDF
- [ ] Email Notification
- [ ] SMS Gateway Integration
- [ ] API REST untuk Mobile App
- [ ] Advanced Reporting
- [ ] User Activity Log
- [ ] Backup Database Auto
- [ ] Two-Factor Authentication
- [ ] Dashboard Charts & Graphs
- [ ] Export Excel CSV

## 👥 User Roles

### Admin
- Akses penuh ke semua fitur
- Manage kamar, penghuni, pembayaran
- View laporan & statistik
- Lihat aktivitas user

### Penghuni
- View kamar pribadi
- View riwayat pembayaran
- Update profil
- Lihat informasi pembayaran

## 📞 Support & Contact

Untuk pertanyaan atau issue, silahkan hubungi developer.

---

**Versi**: 1.0
**Release Date**: 2024
**Author**: SIPKOS Development Team
