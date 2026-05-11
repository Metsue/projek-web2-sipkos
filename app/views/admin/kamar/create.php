<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-plus-circle"></i> Tambah Kamar</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo ROUTE_URL; ?>admin/kamar" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo ROUTE_URL; ?>admin/kamar/store" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="nomor_kamar" class="form-label">Nomor Kamar *</label>
                        <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" placeholder="Contoh: A01" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tipe_kamar" class="form-label">Tipe Kamar *</label>
                        <select class="form-select" id="tipe_kamar" name="tipe_kamar" required>
                            <option value="">-- Pilih Tipe Kamar --</option>
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                            <option value="triple">Triple</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga (Rp) *</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="terisi">Terisi</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3" placeholder="Masukkan fasilitas (pisahkan dengan koma)"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi kamar"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto" class="form-label">Foto Kamar</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Ukuran maksimal: 2MB</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo ROUTE_URL; ?>admin/kamar" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

