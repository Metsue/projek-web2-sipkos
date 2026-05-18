<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Register - SIPKOS'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e6f0ff;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 24px;
            padding: 42px 32px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.12);
        }

        .brand-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #cfe0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .brand-circle i {
            color: #2d5bd0;
            font-size: 28px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1f324f;
        }

        .auth-header p {
            color: #6b7a99;
            margin-top: 8px;
            font-size: 14px;
        }

        .form-label {
            font-weight: 600;
            color: #3d4f70;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .form-control {
            border-radius: 14px;
            border: 1px solid #dce4f2;
            padding: 12px 14px;
            background: #f8fbff;
        }

        .form-control:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 0.2rem rgba(74, 108, 247, 0.16);
        }

        .btn-register {
            border-radius: 14px;
            padding: 12px 0;
            font-weight: 700;
            width: 100%;
            background: #2d5bd0;
            border: none;
        }

        .btn-register:hover {
            background: #244cb0;
        }

        .form-footer {
            text-align: center;
            margin-top: 18px;
            color: #6b7a99;
            font-size: 14px;
        }

        .form-footer a {
            color: #2d5bd0;
            font-weight: 700;
            text-decoration: none;
        }

        .alert {
            border-radius: 16px;
            border: none;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="brand-circle">
                <i class="fas fa-building"></i>
            </div>
            <div class="auth-header">
                <h1>Daftar SIPKOS</h1>
                <p>Buat akun untuk mengakses dashboard kos</p>
            </div>

            <?php if (isset($flash)): ?>
                <?php
                $alertClass = $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : ($flash['type'] === 'warning' ? 'warning' : 'info'));
                ?>
                <div class="alert alert-<?php echo htmlspecialchars($alertClass); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo ROUTE_URL; ?>register" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email aktif" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-register">Daftar</button>
            </form>

            <div class="form-footer">
                Sudah punya akun? <a href="<?php echo ROUTE_URL; ?>login">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

