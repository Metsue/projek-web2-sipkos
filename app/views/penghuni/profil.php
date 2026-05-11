<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-user"></i> Profil Saya</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Penghuni</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo ROUTE_URL; ?>penghuni/profil/update" method="POST">
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($penghuni['nama']); ?>" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($penghuni['email']); ?>" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Nomor Kamar</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($penghuni['nomor_kamar'] ?? '-'); ?>" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($penghuni['tanggal_masuk']); ?>" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?php echo htmlspecialchars($penghuni['nomor_hp']); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat_asal" class="form-label">Alamat Asal</label>
                        <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3"><?php echo htmlspecialchars($penghuni['alamat_asal']); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo ROUTE_URL; ?>penghuni/dashboard" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($kamar)): ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Kamar</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($kamar['foto'])): ?>
                        <img src="<?php echo BASE_URL . 'public/uploads/kamar/' . htmlspecialchars($kamar['foto']); ?>" alt="Foto Kamar" style="width: 100%; border-radius: 6px; margin-bottom: 15px;">
                    <?php endif; ?>

                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nomor</strong></td>
                            <td><?php echo htmlspecialchars($kamar['nomor_kamar']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tipe</strong></td>
                            <td><?php echo ucfirst($kamar['tipe_kamar']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Harga</strong></td>
                            <td>Rp <?php echo number_format($kamar['harga'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fasilitas</strong></td>
                            <td><?php echo htmlspecialchars($kamar['fasilitas'] ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

