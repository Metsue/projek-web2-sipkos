<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-users"></i> Data Penghuni</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo BASE_URL; ?>admin/penghuni/create" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Penghuni
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($penghuni_list)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th>Kamar</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penghuni_list as $key => $penghuni): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><strong><?php echo htmlspecialchars($penghuni['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($penghuni['email']); ?></td>
                                <td><?php echo htmlspecialchars($penghuni['nomor_hp']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($penghuni['nomor_kamar']); ?></span></td>
                                <td><?php echo htmlspecialchars($penghuni['tanggal_masuk']); ?></td>
                                <td>
                                    <?php 
                                    $status = $penghuni['status'];
                                    $badge_class = $status === 'aktif' ? 'badge-success' : 'badge-danger';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>admin/penghuni/show?id=<?php echo $penghuni['id_penghuni']; ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/penghuni/edit?id=<?php echo $penghuni['id_penghuni']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/penghuni/delete?id=<?php echo $penghuni['id_penghuni']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted text-center">Tidak ada data penghuni</p>
        <?php endif; ?>
    </div>
</div>
