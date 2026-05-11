<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-door-open"></i> Data Kamar</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/kamar/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kamar
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($kamar_list)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Kamar</th>
                            <th>Tipe Kamar</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kamar_list as $key => $kamar): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($kamar['nomor_kamar'] ?? '-'); ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo ucfirst($kamar['tipe_kamar'] ?? '-'); ?>
                                    </span>
                                </td>
                                <td>Rp <?php echo number_format($kamar['harga'] ?? 0, 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    $status = $kamar['status'] ?? '';
                                    $badge_class = $status === 'tersedia' ? 'badge-success' : ($status === 'terisi' ? 'badge-danger' : 'badge-warning');
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo ROUTE_URL; ?>admin/kamar/show?id=<?php echo $kamar['id_kamar']; ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo ROUTE_URL; ?>admin/kamar/edit?id=<?php echo $kamar['id_kamar']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo ROUTE_URL; ?>admin/kamar/delete?id=<?php echo $kamar['id_kamar']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted text-center">Tidak ada data kamar</p>
        <?php endif; ?>
    </div>
</div>

