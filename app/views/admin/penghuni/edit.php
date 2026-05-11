<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-edit"></i> Edit Penghuni</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo BASE_URL; ?>admin/penghuni" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>admin/penghuni/update?id=<?php echo $penghuni['id_penghuni']; ?>" method="POST">
                    <input type="hidden" name="id_penghuni" value="<?php echo $penghuni['id_penghuni']; ?>">

                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($penghuni['nama']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($penghuni['email']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_hp" class="form-label">Nomor HP *</label>
                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?php echo htmlspecialchars($penghuni['nomor_hp']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat_asal" class="form-label">Alamat Asal *</label>
                        <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" required><?php echo htmlspecialchars($penghuni['alamat_asal']); ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk *</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo htmlspecialchars($penghuni['tanggal_masuk']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?php echo $penghuni['status'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="tidak_aktif" <?php echo $penghuni['status'] === 'tidak_aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo BASE_URL; ?>admin/penghuni" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
