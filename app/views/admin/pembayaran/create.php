<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-plus-circle"></i> Catat Pembayaran</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/pembayaran" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo ROUTE_URL; ?>admin/pembayaran/store" method="POST">
                    <div class="form-group mb-3">
                        <label for="id_penghuni" class="form-label">Pilih Penghuni *</label>
                        <select class="form-select" id="id_penghuni" name="id_penghuni" required>
                            <option value="">-- Pilih Penghuni --</option>
                            <?php foreach ($penghuni_list as $penghuni): ?>
                                <option value="<?php echo $penghuni['id_penghuni']; ?>">
                                    <?php echo htmlspecialchars($penghuni['nama'] . ' - Kamar ' . $penghuni['nomor_kamar'] ?? $penghuni['id_kamar']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="bulan" class="form-label">Bulan *</label>
                                <input type="text" class="form-control" id="bulan" name="bulan" placeholder="Contoh: Januari" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tahun" class="form-label">Tahun *</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo date('Y'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="total_bayar" class="form-label">Total Bayar (Rp) *</label>
                        <input type="number" class="form-control" id="total_bayar" name="total_bayar" placeholder="Masukkan total bayar" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="lunas">Lunas</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Catatan pembayaran (opsional)"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo ROUTE_URL; ?>admin/pembayaran" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

