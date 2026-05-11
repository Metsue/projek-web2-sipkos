<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-user-plus"></i> Tambah Penghuni</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/penghuni" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo ROUTE_URL; ?>admin/penghuni/store" method="POST">
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_hp" class="form-label">Nomor HP *</label>
                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat_asal" class="form-label">Alamat Asal *</label>
                        <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" placeholder="Masukkan alamat asal" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk *</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_kamar" class="form-label">Pilih Kamar *</label>
                        <select class="form-select" id="id_kamar" name="id_kamar" required>
                            <option value="">-- Pilih Kamar --</option>
                            <?php foreach ($kamar_list as $kamar): ?>
                                <option value="<?php echo $kamar['id_kamar']; ?>">
                                    <?php echo htmlspecialchars($kamar['nomor_kamar'] . ' - ' . $kamar['tipe_kamar'] . ' (Rp ' . number_format($kamar['harga'], 0, ',', '.') . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Password default: <strong>password123</strong>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo ROUTE_URL; ?>admin/penghuni" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

