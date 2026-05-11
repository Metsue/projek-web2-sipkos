<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-credit-card"></i> Data Pembayaran</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/pembayaran/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Catat Pembayaran
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($pembayaran_list)): ?>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaran_list as $key => $item): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><strong><?php echo htmlspecialchars($item['nama_penghuni']); ?></strong></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($item['nomor_kamar']); ?></span></td>
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
                                <td>
                                    <a href="<?php echo ROUTE_URL; ?>admin/pembayaran/edit?id=<?php echo $item['id_pembayaran']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo ROUTE_URL; ?>admin/pembayaran/delete?id=<?php echo $item['id_pembayaran']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
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

