<?php
/**
 * Web Routes
 * 
 * Definisi semua routes aplikasi
 * Format: $router->method(route, 'controller@method');
 * 
 * @author SIPKOS Team
 */

// ============================================
// PUBLIC ROUTES
// ============================================

// Authentication
$router->get('/', 'page@index');
$router->get('/login', 'page@login');
$router->post('/login', 'auth@processLogin');
$router->get('/register', 'page@register');
$router->post('/register', 'auth@processRegister');
$router->get('/logout', 'auth@logout');

// ============================================
// ADMIN ROUTES
// ============================================

// Dashboard
$router->get('/admin', 'admin@dashboard');
$router->get('/admin/dashboard', 'admin@dashboard');

// Kamar Management
$router->get('/admin/kamar', 'admin@kamarIndex');
$router->get('/admin/kamar/create', 'admin@kamarCreate');
$router->post('/admin/kamar/store', 'admin@kamarStore');
$router->get('/admin/kamar/edit/:id', 'admin@kamarEdit');
$router->post('/admin/kamar/update/:id', 'admin@kamarUpdate');
$router->get('/admin/kamar/delete/:id', 'admin@kamarDelete');
$router->get('/admin/kamar/show/:id', 'admin@kamarShow');

// Penghuni Management
$router->get('/admin/penghuni', 'admin@penghuniIndex');
$router->get('/admin/penghuni/create', 'admin@penghuniCreate');
$router->post('/admin/penghuni/store', 'admin@penghuniStore');
$router->get('/admin/penghuni/edit/:id', 'admin@penghuniEdit');
$router->post('/admin/penghuni/update/:id', 'admin@penghuniUpdate');
$router->get('/admin/penghuni/delete/:id', 'admin@penghuniDelete');
$router->get('/admin/penghuni/show/:id', 'admin@penghuniShow');

// Pembayaran Management
$router->get('/admin/pembayaran', 'admin@pembayaranIndex');
$router->get('/admin/pembayaran/create', 'admin@pembayaranCreate');
$router->post('/admin/pembayaran/store', 'admin@pembayaranStore');
$router->get('/admin/pembayaran/edit/:id', 'admin@pembayaranEdit');
$router->post('/admin/pembayaran/update/:id', 'admin@pembayaranUpdate');
$router->get('/admin/pembayaran/delete/:id', 'admin@pembayaranDelete');

// Laporan
$router->get('/admin/laporan', 'admin@laporanIndex');
$router->post('/admin/laporan/export-pdf', 'admin@exportPDF');

// ============================================
// PENGHUNI ROUTES
// ============================================

$router->get('/penghuni/dashboard', 'penghuni@dashboard');
$router->get('/penghuni/profil/create', 'penghuni@createProfile');
$router->post('/penghuni/profil/store', 'penghuni@storeProfile');
$router->get('/penghuni/profil', 'penghuni@profil');
$router->post('/penghuni/profil/update', 'penghuni@profilUpdate');
$router->get('/penghuni/pembayaran', 'penghuni@pembayaran');

?>
