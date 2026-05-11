<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-edit"></i> Edit Pembayaran</h2>
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
                <form action="<?php echo ROUTE_URL; ?>admin/pembayaran/update?id=<?php echo $pembayaran['id_pembayaran']; ?>" method="POST">
                    <input type="hidden" name="id_pembayaran" value="<?php echo $pembayaran['id_pembayaran']; ?>">

                    <div class="form-group mb-3">
                        <label class="form-label">Penghuni</label>
                        <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($pembayaran['nama_penghuni'] ?? '-'); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Bulan</label>
                                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($pembayaran['bulan']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($pembayaran['tahun']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="total_bayar" class="form-label">Total Bayar (Rp) *</label>
                        <input type="number" class="form-control" id="total_bayar" name="total_bayar" value="<?php echo htmlspecialchars($pembayaran['total_bayar']); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" <?php echo $pembayaran['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="lunas" <?php echo $pembayaran['status'] === 'lunas' ? 'selected' : ''; ?>>Lunas</option>
                            <option value="terlambat" <?php echo $pembayaran['status'] === 'terlambat' ? 'selected' : ''; ?>>Terlambat</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo htmlspecialchars($pembayaran['keterangan'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
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

