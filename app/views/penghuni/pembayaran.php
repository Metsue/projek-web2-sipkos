<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-credit-card"></i> Riwayat Pembayaran</h2>
    </div>
</div>

<div class="card">
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
