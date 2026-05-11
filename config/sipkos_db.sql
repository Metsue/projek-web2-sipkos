-- ============================================
-- SIPKOS DATABASE SCHEMA
-- Sistem Informasi Pengelolaan Kos
-- ============================================

-- Membuat database
CREATE DATABASE IF NOT EXISTS sipkos_db;
USE sipkos_db;

-- ============================================
-- TABEL: users
-- Untuk menyimpan data user (admin & penghuni)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'penghuni') NOT NULL DEFAULT 'penghuni',
    foto_profil VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: kamar
-- Untuk menyimpan data kamar kos
-- ============================================
CREATE TABLE IF NOT EXISTS kamar (
    id_kamar INT PRIMARY KEY AUTO_INCREMENT,
    nomor_kamar VARCHAR(20) UNIQUE NOT NULL,
    tipe_kamar ENUM('single', 'double', 'triple') NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    status ENUM('tersedia', 'terisi', 'maintenance') NOT NULL DEFAULT 'tersedia',
    fasilitas TEXT NULL,
    foto VARCHAR(255) NULL,
    deskripsi TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_tipe (tipe_kamar)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: penghuni
-- Untuk menyimpan data penghuni kos
-- ============================================
CREATE TABLE IF NOT EXISTS penghuni (
    id_penghuni INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nomor_hp VARCHAR(15) NOT NULL,
    alamat_asal TEXT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    id_kamar INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('aktif', 'tidak_aktif') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kamar) REFERENCES kamar(id_kamar) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id_user) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_kamar (id_kamar),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: pembayaran
-- Untuk menyimpan data pembayaran sewa kamar
-- ============================================
CREATE TABLE IF NOT EXISTS pembayaran (
    id_pembayaran INT PRIMARY KEY AUTO_INCREMENT,
    id_penghuni INT NOT NULL,
    bulan VARCHAR(20) NOT NULL,
    tahun INT NOT NULL,
    tanggal_bayar DATE NULL,
    total_bayar DECIMAL(10, 2) NOT NULL,
    status ENUM('lunas', 'pending', 'terlambat') NOT NULL DEFAULT 'pending',
    keterangan TEXT NULL,
    bukti_bayar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penghuni) REFERENCES penghuni(id_penghuni) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_penghuni (id_penghuni),
    INDEX idx_bulan_tahun (bulan, tahun),
    UNIQUE KEY unique_pembayaran (id_penghuni, bulan, tahun)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: aktivitas_log (Optional - untuk audit)
-- ============================================
CREATE TABLE IF NOT EXISTS aktivitas_log (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    aksi VARCHAR(255) NOT NULL,
    tabel VARCHAR(100) NOT NULL,
    id_record INT NULL,
    detail TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    INDEX idx_user (id_user),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DUMMY DATA UNTUK TESTING
-- ============================================

-- Insert Admin User
INSERT INTO users (nama, email, username, password, role) VALUES 
('Admin SIPKOS', 'admin@sipkos.com', 'admin', '$2y$10$dS2uEbf8XxlDyXUhx8w3.uxZC9qZ7Zl0nKj5rW5rW5rW5rW5rW', 'admin');

-- Insert Sample Kamar
INSERT INTO kamar (nomor_kamar, tipe_kamar, harga, status, fasilitas, deskripsi) VALUES 
('A01', 'single', 1000000, 'tersedia', 'WiFi, AC, Kasur, Lemari', 'Kamar single dengan fasilitas lengkap'),
('A02', 'double', 1500000, 'tersedia', 'WiFi, AC, Kasur, Lemari, TV', 'Kamar double yang nyaman'),
('B01', 'single', 950000, 'terisi', 'WiFi, AC, Kasur', 'Kamar single ekonomis'),
('B02', 'double', 1400000, 'terisi', 'WiFi, AC, Kasur, Lemari', 'Kamar double dengan pemandangan'),
('C01', 'triple', 3000000, 'tersedia', 'WiFi, AC, 2x Kasur, Lemari Besar', 'Kamar triple untuk rombongan');

-- ============================================
-- VIEWS (Optional - untuk query kompleks)
-- ============================================

-- View untuk dashboard statistik
CREATE OR REPLACE VIEW v_dashboard_stats AS
SELECT 
    (SELECT COUNT(*) FROM kamar) as total_kamar,
    (SELECT COUNT(*) FROM kamar WHERE status = 'terisi') as kamar_terisi,
    (SELECT COUNT(*) FROM kamar WHERE status = 'tersedia') as kamar_kosong,
    (SELECT COUNT(*) FROM penghuni WHERE status = 'aktif') as total_penghuni,
    (SELECT SUM(total_bayar) FROM pembayaran WHERE MONTH(tanggal_bayar) = MONTH(CURDATE()) AND YEAR(tanggal_bayar) = YEAR(CURDATE())) as total_pembayaran_bulan_ini;

-- View untuk status pembayaran penghuni
CREATE OR REPLACE VIEW v_pembayaran_penghuni AS
SELECT 
    p.id_pembayaran,
    pen.id_penghuni,
    pen.nama as nama_penghuni,
    k.nomor_kamar,
    p.bulan,
    p.tahun,
    p.total_bayar,
    p.status,
    p.tanggal_bayar,
    p.created_at
FROM pembayaran p
JOIN penghuni pen ON p.id_penghuni = pen.id_penghuni
JOIN kamar k ON pen.id_kamar = k.id_kamar
ORDER BY p.created_at DESC;
