<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Lengkapi Profil - SIPKOS'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e7f2ff;
            min-height: 100vh;
        }
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .profile-card {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        }
        .profile-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1f334f;
        }
        .profile-card p {
            color: #6d7c99;
            margin-bottom: 24px;
        }
        .form-label {
            font-weight: 600;
            color: #3c4f71;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 14px;
            border: 1px solid #dfe7f5;
            padding: 12px 14px;
            background: #f8fbff;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 0.18rem rgba(74, 108, 247, 0.18);
        }
        .btn-primary {
            border-radius: 14px;
            padding: 12px 0;
            font-weight: 700;
        }
        .alert {
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="profile-card">
            <h1>Lengkapi Profil Anda</h1>
            <p>Untuk dapat mengakses dashboard dan melakukan pemesanan kamar, silakan lengkapi data di bawah ini.</p>

            <?php if (isset($flash)): ?>
                <?php $alertClass = $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info'); ?>
                <div class="alert alert-<?php echo htmlspecialchars($alertClass); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo ROUTE_URL; ?>penghuni/profil/store" method="POST">
                <div class="mb-3">
                    <label for="nomor_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="0812xxxxxxx" required>
                </div>
                <div class="mb-3">
                    <label for="alamat_asal" class="form-label">Alamat Asal</label>
                    <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" placeholder="Alamat asal" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="id_kamar" class="form-label">Pilih Kamar</label>
                    <select class="form-select" id="id_kamar" name="id_kamar" required>
                        <option value="">Pilih kamar tersedia</option>
                        <?php if (!empty($available_rooms)): ?>
                            <?php foreach ($available_rooms as $room): ?>
                                <option value="<?php echo htmlspecialchars($room['id_kamar']); ?>">
                                    <?php echo htmlspecialchars($room['nomor_kamar'] . ' - ' . ucfirst($room['tipe_kamar']) . ' - Rp ' . number_format($room['harga'], 0, ',', '.')); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Tidak ada kamar tersedia</option>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan Profil</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
