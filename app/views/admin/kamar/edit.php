<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-edit"></i> Edit Kamar</h2>
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
                <form action="<?php echo BASE_URL; ?>admin/kamar/update?id=<?php echo $kamar['id_kamar']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_kamar" value="<?php echo $kamar['id_kamar']; ?>">

                    <div class="form-group mb-3">
                        <label for="nomor_kamar" class="form-label">Nomor Kamar *</label>
                        <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="<?php echo htmlspecialchars($kamar['nomor_kamar']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tipe_kamar" class="form-label">Tipe Kamar *</label>
                        <select class="form-select" id="tipe_kamar" name="tipe_kamar" required>
                            <option value="single" <?php echo $kamar['tipe_kamar'] === 'single' ? 'selected' : ''; ?>>Single</option>
                            <option value="double" <?php echo $kamar['tipe_kamar'] === 'double' ? 'selected' : ''; ?>>Double</option>
                            <option value="triple" <?php echo $kamar['tipe_kamar'] === 'triple' ? 'selected' : ''; ?>>Triple</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga (Rp) *</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($kamar['harga']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="tersedia" <?php echo $kamar['status'] === 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="terisi" <?php echo $kamar['status'] === 'terisi' ? 'selected' : ''; ?>>Terisi</option>
                            <option value="maintenance" <?php echo $kamar['status'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3"><?php echo htmlspecialchars($kamar['fasilitas'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($kamar['deskripsi'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto" class="form-label">Foto Kamar</label>
                        <?php if (!empty($kamar['foto'])): ?>
                            <div class="mb-2">
                                <img src="<?php echo BASE_URL . 'public/uploads/kamar/' . htmlspecialchars($kamar['foto']); ?>" alt="Foto Kamar" style="max-width: 200px; border-radius: 6px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Ukuran maksimal: 2MB. Kosongkan jika tidak ingin mengubah foto</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo BASE_URL; ?>admin/kamar" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
