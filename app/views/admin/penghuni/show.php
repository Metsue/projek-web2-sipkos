<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-info-circle"></i> Detail Penghuni</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/penghuni" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Penghuni</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 150px;"><strong>Nama</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($penghuni['nama']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($penghuni['email']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nomor HP</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($penghuni['nomor_hp']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat Asal</strong></td>
                        <td>:</td>
                        <td><?php echo nl2br(htmlspecialchars($penghuni['alamat_asal'])); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Masuk</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($penghuni['tanggal_masuk']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:</td>
                        <td>
                            <?php 
                            $status = $penghuni['status'];
                            $badge_class = $status === 'aktif' ? 'badge-success' : 'badge-danger';
                            ?>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="<?php echo ROUTE_URL; ?>admin/penghuni/edit?id=<?php echo $penghuni['id_penghuni']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo ROUTE_URL; ?>admin/penghuni/delete?id=<?php echo $penghuni['id_penghuni']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus penghuni ini?');">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Pembayaran</h5>
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

