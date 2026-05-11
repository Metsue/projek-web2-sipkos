<?php
$current_user = $_SESSION['user'] ?? null;
$is_admin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>

<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-building"></i> SIPKOS</h4>
        <p class="sidebar-brand-subtitle">Manajemen Kos</p>
    </div>

    <nav class="sidebar-menu">
        <?php if ($is_admin): ?>
            <!-- Admin Menu -->
            <p class="sidebar-menu-category">Dashboard</p>
            <a href="<?php echo ROUTE_URL; ?>admin" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin') === 0 ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>

            <p class="sidebar-menu-category">Manajemen</p>
            <a href="<?php echo ROUTE_URL; ?>admin/kamar" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/kamar') !== false ? 'active' : ''; ?>">
                <i class="fas fa-door-open"></i> Data Kamar
            </a>
            <a href="<?php echo ROUTE_URL; ?>admin/penghuni" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/penghuni') !== false ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Data Penghuni
            </a>
            <a href="<?php echo ROUTE_URL; ?>admin/pembayaran" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/pembayaran') !== false ? 'active' : ''; ?>">
                <i class="fas fa-credit-card"></i> Pembayaran
            </a>

            <p class="sidebar-menu-category">Lainnya</p>
            <a href="<?php echo ROUTE_URL; ?>admin/laporan" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/laporan') !== false ? 'active' : ''; ?>">
                <i class="fas fa-file-pdf"></i> Laporan
            </a>

        <?php else: ?>
            <!-- Penghuni Menu -->
            <p class="sidebar-menu-category">Menu</p>
            <a href="<?php echo ROUTE_URL; ?>penghuni/dashboard" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/penghuni/dashboard') !== false ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="<?php echo ROUTE_URL; ?>penghuni/profil" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/profil') !== false ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> Profil Saya
            </a>
            <a href="<?php echo ROUTE_URL; ?>penghuni/pembayaran" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/pembayaran') !== false ? 'active' : ''; ?>">
                <i class="fas fa-wallet"></i> Riwayat Pembayaran
            </a>
        <?php endif; ?>

        <p class="sidebar-menu-category">Akun</p>
        <a href="<?php echo ROUTE_URL; ?>logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</div>

