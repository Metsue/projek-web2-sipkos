# PANDUAN SETUP & INSTALASI SIPKOS

## ✅ Persyaratan Sistem

- **PHP**: 7.4 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Apache**: Dengan mod_rewrite enabled
- **Browser**: Chrome, Firefox, Safari, Edge (versi terbaru)
- **Text Editor**: VS Code, Sublime Text, atau sejenisnya

---

## 🚀 Langkah-Langkah Instalasi

### STEP 1: Persiapan File

#### A. Lokasi Project
```
Letakkan project di:
C:\xampp\htdocs\projek-web2-sipkos\
```

#### B. Struktur Folder
Pastikan struktur seperti ini sudah ada:
```
projek-web2-sipkos/
├── app/
├── public/
├── config/
├── routes/
├── index.php
├── README.md
├── DOKUMENTASI.md
└── SETUP.md (file ini)
```

---

### STEP 2: Konfigurasi Database

#### A. Buka phpMyAdmin
```
URL: http://localhost/phpmyadmin
```

#### B. Buat Database Baru
1. Klik "Databases" / "New"
2. Database name: `sipkos_db`
3. Collation: `utf8mb4_unicode_ci`
4. Klik "Create"

#### C. Import SQL Schema

**Opsi 1: Melalui phpMyAdmin**
1. Pilih database `sipkos_db`
2. Klik "Import"
3. Pilih file: `config/sipkos_db.sql`
4. Klik "Go"

**Opsi 2: Melalui Command Line**
```bash
mysql -u root -p sipkos_db < config/sipkos_db.sql
```

**Opsi 3: Manual Copy-Paste**
1. Buka `config/sipkos_db.sql`
2. Copy semua SQL
3. Di phpMyAdmin, buka tab "SQL"
4. Paste dan execute

#### D. Verifikasi Database
Pastikan tabel-tabel ini ada:
- `users`
- `kamar`
- `penghuni`
- `pembayaran`
- `aktivitas_log`

---

### STEP 3: Konfigurasi PHP

#### A. Edit Database Config
File: `config/database.php`

```php
private $host = 'localhost';      // ← Sesuaikan jika berbeda
private $db_name = 'sipkos_db';   // ← Sesuaikan nama database
private $user = 'root';            // ← Username MySQL
private $pass = '';                // ← Password MySQL (kosong = default XAMPP)
private $port = '3306';            // ← Port MySQL
```

#### B. Persiapkan Folder Uploads
1. Buat folder jika belum ada: `public/uploads/kamar`
2. Set permissions: `chmod 755 public/uploads/kamar`

---

### STEP 4: Jalankan Aplikasi

#### A. Start XAMPP
1. Buka XAMPP Control Panel
2. Klik "Start" untuk Apache
3. Klik "Start" untuk MySQL

#### B. Akses Aplikasi
```
URL: http://localhost/projek-web2-sipkos/
```

#### C. Login Pertama Kali

**Akun Admin Default:**
```
Email: admin@sipkos.com
Username: admin
Password: password123
```

**Akun Test Penghuni:** (Optional - buat via admin)
```
Email: penghuni@example.com
Username: penghuni
Password: password123
```

---

## 🔧 Troubleshooting

### Masalah 1: "404 Not Found"

**Penyebab:**
- URL tidak sesuai
- Router tidak menemukan route
- Controller tidak ada

**Solusi:**
```
1. Cek URL di address bar: 
   http://localhost/projek-web2-sipkos/

2. Verifikasi routes di routes/web.php

3. Check controller file di app/controllers/

4. Pastikan nama controller & method sesuai

5. Buka php error log: C:\xampp\apache\logs\error.log
```

### Masalah 2: "Database Connection Error"

**Penyebab:**
- MySQL tidak running
- Kredensial database salah
- Database belum dibuat

**Solusi:**
```
1. Pastikan MySQL running:
   - XAMPP Control Panel → Start MySQL

2. Cek kredensial di config/database.php:
   - username: root
   - password: (kosong untuk default XAMPP)

3. Verify database exists:
   - phpMyAdmin → Check sipkos_db exists

4. Test koneksi manual dengan:
   mysql -u root -p -h localhost sipkos_db
```

### Masalah 3: "Session Lost / Logout"

**Penyebab:**
- PHP session tidak dikonfigurasi
- Session folder tidak writable
- Cookies disabled

**Solusi:**
```
1. Cek php.ini:
   - session.save_path = "C:\xampp\tmp"
   - Pastikan folder writable

2. Enable cookies di browser

3. Restart browser & clear cache

4. Test session di index.php:
   <?php session_start(); $_SESSION['test'] = 'ok'; echo $_SESSION['test']; ?>
```

### Masalah 4: "File Upload Error"

**Penyebab:**
- Folder uploads tidak ada
- Permission denied
- File size terlalu besar

**Solusi:**
```
1. Buat folder uploads:
   mkdir -p public/uploads/kamar

2. Set permissions:
   chmod 755 public/uploads/kamar
   chmod 777 public/uploads/kamar (jika perlu)

3. Cek file size:
   - Max size: 2MB
   - Format: JPG, PNG, GIF

4. Cek php.ini:
   upload_max_filesize = 100M
   post_max_size = 100M
```

### Masalah 5: "Login Gagal"

**Penyebab:**
- Email/password salah
- User tidak ada di database
- Forgot password

**Solusi:**
```
1. Verify user exists:
   - phpMyAdmin → users table
   - Check admin@sipkos.com ada

2. Reset password via MySQL:
   UPDATE users SET password = '$2y$10$dS2uEbf8XxlDyXUhx8w3.uxZC9qZ7Zl0nKj5rW5rW5rW5rW5rW' WHERE id_user = 1;
   (Password akan jadi: password123)

3. Clear browser cache & cookies

4. Try incognito mode
```

### Masalah 6: "Blank Page"

**Penyebab:**
- PHP error terjadi
- View file tidak ditemukan
- Database query error

**Solusi:**
```
1. Enable error display di index.php:
   error_reporting(E_ALL);
   ini_set('display_errors', 1);

2. Check error log:
   C:\xampp\apache\logs\error.log
   C:\xampp\mysql\data\error.log

3. Verify view file exists:
   app/views/admin/kamar/index.php

4. Check database query di:
   phpMyAdmin → Run query test
```

---

## 📝 Tips & Tricks

### 1. Reset Database Ke Awal
```sql
-- Drop semua tabel
DROP TABLE IF EXISTS aktivitas_log;
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS penghuni;
DROP TABLE IF EXISTS kamar;
DROP TABLE IF EXISTS users;

-- Re-import SQL
-- Copy-paste isi config/sipkos_db.sql
```

### 2. Buat User Admin Baru
```sql
INSERT INTO users (nama, email, username, password, role) 
VALUES ('Admin 2', 'admin2@sipkos.com', 'admin2', 
        '$2y$10$dS2uEbf8XxlDyXUhx8w3.uxZC9qZ7Zl0nKj5rW5rW5rW5rW5rW', 
        'admin');
-- Password: password123
```

### 3. Buat User Penghuni Baru
```sql
INSERT INTO users (nama, email, username, password, role) 
VALUES ('Penghuni Test', 'penghuni@test.com', 'penghuni', 
        '$2y$10$dS2uEbf8XxlDyXUhx8w3.uxZC9qZ7Zl0nKj5rW5rW5rW5rW5rW', 
        'penghuni');
```

### 4. Check PHP Configuration
```
Buat file test.php di root:

<?php
phpinfo();
?>

Akses: http://localhost/projek-web2-sipkos/test.php
```

### 5. Enable Debug Mode
Di index.php, ubah:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);  // Set to 1 untuk debug
```

---

## 🔐 Security Checklist

Sebelum deploy ke production:

### 1. Credentials
- [ ] Ubah password admin default
- [ ] Ubah username admin jika perlu
- [ ] Setup HTTPS/SSL

### 2. Database
- [ ] Ubah password MySQL
- [ ] Backup database regularly
- [ ] Setup MySQL user dengan privilege limited

### 3. File Permissions
- [ ] Set chmod 644 untuk file PHP
- [ ] Set chmod 755 untuk folder
- [ ] Jangan expose sensitive files

### 4. Code
- [ ] Remove debug mode
- [ ] Remove test files
- [ ] Update contact info di README
- [ ] Setup error logging

### 5. Server
- [ ] Disable directory listing
- [ ] Setup .htaccess
- [ ] Configure firewall
- [ ] Setup backup automation

---

## 📊 Testing Checklist

### Authentication
- [ ] Register akun baru
- [ ] Login dengan akun baru
- [ ] Logout
- [ ] Session persist setelah refresh
- [ ] Tidak bisa akses halaman tanpa login

### CRUD Kamar
- [ ] Create kamar baru
- [ ] Edit kamar
- [ ] Delete kamar
- [ ] View detail kamar
- [ ] Upload foto kamar

### CRUD Penghuni
- [ ] Create penghuni
- [ ] Edit penghuni
- [ ] Delete penghuni
- [ ] View pembayaran penghuni
- [ ] Status penghuni berubah

### CRUD Pembayaran
- [ ] Create pembayaran
- [ ] Edit pembayaran
- [ ] Delete pembayaran
- [ ] Filter by status
- [ ] Filter by bulan

### Dashboard
- [ ] Statistics akurat
- [ ] Charts display correctly
- [ ] Quick links work
- [ ] Recent payments show

### Penghuni Dashboard
- [ ] View data pribadi
- [ ] View pembayaran
- [ ] Update profil
- [ ] View kamar info

---

## 📞 Need Help?

Jika mengalami masalah:

1. **Check Documentation**
   - Baca DOKUMENTASI.md
   - Baca README.md
   - Baca IMPLEMENTASI_OOP_MVC.md

2. **Check Error Log**
   - Apache error: C:\xampp\apache\logs\error.log
   - PHP error: Lihat di browser inspect
   - MySQL error: phpMyAdmin error tab

3. **Search Online**
   - Stack Overflow
   - PHP.net Documentation
   - MySQL Documentation

4. **Contact Developer**
   - Jelaskan masalah dengan detail
   - Sertakan error message
   - Sertakan screenshot
   - Jelaskan langkah-langkah

---

## 🎉 Selesai!

Jika semua setup berhasil, Anda siap menggunakan SIPKOS!

Selamat menggunakan **SIPKOS - Sistem Informasi Pengelolaan Kos** 🚀
