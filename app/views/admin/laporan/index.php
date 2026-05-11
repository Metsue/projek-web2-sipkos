<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-file-pdf"></i> Laporan Pembayaran</h2>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="bulan" class="form-label">Bulan</label>
                <input type="text" class="form-control" id="bulan" name="bulan" value="<?php echo htmlspecialchars($filter_bulan); ?>" placeholder="Nama bulan">
            </div>
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo htmlspecialchars($filter_tahun); ?>">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0">Laporan Pembayaran <?php echo htmlspecialchars($filter_bulan) . '/' . htmlspecialchars($filter_tahun); ?></h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <form action="<?php echo ROUTE_URL; ?>admin/laporan/export-pdf" method="POST" style="display: inline;">
                            <input type="hidden" name="bulan" value="<?php echo htmlspecialchars($filter_bulan); ?>">
                            <input type="hidden" name="tahun" value="<?php echo htmlspecialchars($filter_tahun); ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaran_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penghuni</th>
                                    <th>Kamar</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_pembayaran = 0;
                                foreach ($pembayaran_list as $key => $item): 
                                    if ($item['status'] === 'lunas') {
                                        $total_pembayaran += $item['total_bayar'];
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo htmlspecialchars($item['nama_penghuni'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($item['nomor_kamar'] ?? '-'); ?></td>
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
                            <tfoot>
                                <tr style="background: #f8f9fa; font-weight: bold;">
                                    <td colspan="3" class="text-end">Total Pembayaran:</td>
                                    <td>Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Tidak ada data pembayaran untuk periode ini</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

