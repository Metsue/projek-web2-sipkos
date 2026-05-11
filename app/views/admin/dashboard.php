<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-0">
            <i class="fas fa-chart-line"></i> Dashboard Admin
        </h2>
        <p class="text-muted">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['user']['nama'] ?? 'Admin'); ?></p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-door-open fa-2x" style="color: #667eea;"></i>
            <h3><?php echo $stats['total_kamar'] ?? 0; ?></h3>
            <p>Total Kamar</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-check-circle fa-2x" style="color: #28a745;"></i>
            <h3><?php echo $stats['kamar_terisi'] ?? 0; ?></h3>
            <p>Kamar Terisi</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-times-circle fa-2x" style="color: #ffc107;"></i>
            <h3><?php echo $stats['kamar_kosong'] ?? 0; ?></h3>
            <p>Kamar Kosong</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-users fa-2x" style="color: #dc3545;"></i>
            <h3><?php echo $stats['total_penghuni'] ?? 0; ?></h3>
            <p>Total Penghuni</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-user-check fa-2x" style="color: #17a2b8;"></i>
            <h3><?php echo $stats['penghuni_aktif'] ?? 0; ?></h3>
            <p>Penghuni Aktif</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-check-double fa-2x" style="color: #20c997;"></i>
            <h3><?php echo $stats['pembayaran_lunas_bulan_ini'] ?? 0; ?></h3>
            <p>Pembayaran Lunas Bulan Ini</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-money-bill fa-2x" style="color: #6f42c1;"></i>
            <h3>Rp <?php echo number_format($stats['total_pembayaran_bulan_ini'] ?? 0, 0, ',', '.'); ?></h3>
            <p>Total Pembayaran Bulan Ini</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <a href="<?php echo ROUTE_URL; ?>admin/laporan" style="color: inherit; text-decoration: none;">
                <i class="fas fa-file-pdf fa-2x" style="color: #fd7e14;"></i>
                <h3 style="font-size: 18px; margin-top: 10px;">Laporan</h3>
                <p>Lihat Laporan</p>
            </a>
        </div>
    </div>
</div>

<!-- Recent Payments -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Pembayaran Terbaru
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaran_terbaru)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penghuni</th>
                                    <th>Kamar</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembayaran_terbaru as $key => $item): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo htmlspecialchars($item['nama_penghuni'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($item['nomor_kamar'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($item['bulan'] . '/' . $item['tahun']); ?></td>
                                        <td>Rp <?php echo number_format($item['total_bayar'] ?? 0, 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $status = $item['status'] ?? '';
                                            $badge_class = $status === 'lunas' ? 'badge-success' : ($status === 'pending' ? 'badge-warning' : 'badge-danger');
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <?php echo ucfirst($status); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($item['tanggal_bayar'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada data pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-link"></i> Akses Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="<?php echo ROUTE_URL; ?>admin/kamar/create" class="btn btn-outline-primary btn-block w-100">
                            <i class="fas fa-plus"></i> Tambah Kamar
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="<?php echo ROUTE_URL; ?>admin/penghuni/create" class="btn btn-outline-info btn-block w-100">
                            <i class="fas fa-user-plus"></i> Tambah Penghuni
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="<?php echo ROUTE_URL; ?>admin/pembayaran/create" class="btn btn-outline-warning btn-block w-100">
                            <i class="fas fa-receipt"></i> Catat Pembayaran
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="<?php echo ROUTE_URL; ?>admin/laporan" class="btn btn-outline-success btn-block w-100">
                            <i class="fas fa-file-pdf"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

