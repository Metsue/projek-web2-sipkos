<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-home"></i> Dashboard Penghuni</h2>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-door-open fa-2x" style="color: #667eea;"></i>
            <h3><?php echo htmlspecialchars($penghuni['nomor_kamar'] ?? 'N/A'); ?></h3>
            <p>Kamar Anda</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-calendar fa-2x" style="color: #28a745;"></i>
            <h3><?php echo htmlspecialchars($stats['tanggal_masuk']); ?></h3>
            <p>Tanggal Masuk</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-receipt fa-2x" style="color: #ffc107;"></i>
            <h3><?php echo $stats['total_pembayaran']; ?></h3>
            <p>Total Pembayaran</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-check-circle fa-2x" style="color: #28a745;"></i>
            <h3><?php echo $stats['pembayaran_lunas']; ?></h3>
            <p>Pembayaran Lunas</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-clock fa-2x" style="color: #dc3545;"></i>
            <h3><?php echo $stats['pembayaran_pending']; ?></h3>
            <p>Pembayaran Pending</p>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <i class="fas fa-user-check fa-2x" style="color: #17a2b8;"></i>
            <h3><?php echo ucfirst($stats['status']); ?></h3>
            <p>Status</p>
        </div>
    </div>
</div>

<!-- Recent Payments -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Riwayat Pembayaran Terbaru
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaran)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan/Tahun</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembayaran as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['bulan'] . '/' . $item['tahun']); ?></td>
                                        <td>Rp <?php echo number_format($item['total_bayar'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $status = $item['status'];
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
                    <p class="text-muted text-center">Tidak ada riwayat pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
