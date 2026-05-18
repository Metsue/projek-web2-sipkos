<div class="top-panel mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="mb-0">SIPKOS</h2>
            <p class="text-muted mb-0">Temukan kos impian Anda</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="#" class="text-dark text-decoration-none">Kos</a>
            <a href="<?php echo ROUTE_URL; ?>penghuni/pembayaran" class="text-dark text-decoration-none">My Bookings</a>
            <a href="<?php echo ROUTE_URL; ?>admin" class="text-dark text-decoration-none">Admin</a>
        </div>
    </div>
</div>

<div class="search-card mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <button class="btn btn-outline-primary rounded-pill px-4">Filter</button>
        </div>
        <div class="col">
            <input type="text" class="form-control form-control-lg" placeholder="Cari Lokasi Kos">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary px-4 py-2">Cari</button>
        </div>
    </div>
</div>

<div class="section-title text-center mb-4">
    <h3>Temukan Kos Impian Anda</h3>
</div>

<div class="row gy-4">
    <?php if (!empty($available_rooms)): ?>
        <?php foreach ($available_rooms as $room): ?>
            <div class="col-md-4">
                <div class="card room-card h-100">
                    <div class="room-image"></div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($room['nomor_kamar']); ?></h5>
                        <p class="card-text text-muted mb-3"><?php echo htmlspecialchars($room['deskripsi'] ?: 'Deskripsi kos belum tersedia'); ?></p>
                        <p class="mb-2"><strong>Harga:</strong> Rp <?php echo number_format($room['harga'], 0, ',', '.'); ?></p>
                        <p class="mb-3"><strong>Tipe:</strong> <?php echo ucfirst($room['tipe_kamar']); ?></p>
                        <a href="<?php echo ROUTE_URL; ?>penghuni/profil" class="btn btn-primary w-100">Lihat Kos</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada kamar tersedia saat ini. Silakan periksa kembali nanti.
            </div>
        </div>
    <?php endif; ?>
</div>
