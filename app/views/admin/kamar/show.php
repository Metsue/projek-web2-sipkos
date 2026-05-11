<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-info-circle"></i> Detail Kamar</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo BASE_URL; ?>admin/kamar" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($kamar['foto'])): ?>
                    <div class="mb-4">
                        <img src="<?php echo BASE_URL . 'public/uploads/kamar/' . htmlspecialchars($kamar['foto']); ?>" alt="Foto Kamar" style="width: 100%; max-width: 500px; border-radius: 8px;">
                    </div>
                <?php endif; ?>

                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nomor Kamar</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($kamar['nomor_kamar']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tipe Kamar</strong></td>
                        <td>:</td>
                        <td><span class="badge bg-info"><?php echo ucfirst($kamar['tipe_kamar']); ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Harga</strong></td>
                        <td>:</td>
                        <td><strong>Rp <?php echo number_format($kamar['harga'], 0, ',', '.'); ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:</td>
                        <td>
                            <?php 
                            $status = $kamar['status'];
                            $badge_class = $status === 'tersedia' ? 'badge-success' : ($status === 'terisi' ? 'badge-danger' : 'badge-warning');
                            ?>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fasilitas</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($kamar['fasilitas'] ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>:</td>
                        <td><?php echo nl2br(htmlspecialchars($kamar['deskripsi'] ?? '-')); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Pada</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($kamar['created_at']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate Pada</strong></td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($kamar['updated_at']); ?></td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="<?php echo BASE_URL; ?>admin/kamar/edit?id=<?php echo $kamar['id_kamar']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/kamar/delete?id=<?php echo $kamar['id_kamar']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?');">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
