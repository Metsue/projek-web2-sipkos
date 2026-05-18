<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Login - SIPKOS'; ?></title>
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
            background: #e7f2ff;
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
            max-width: 380px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 28px;
            padding: 36px 30px;
            box-shadow: 0 22px 45px rgba(0, 0, 0, 0.12);
        }

        .brand-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #dbe8ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .brand-circle i {
            font-size: 30px;
            color: #2f5ad4;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1f334f;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: #6d7c99;
            font-size: 14px;
        }

        .form-label {
            font-weight: 600;
            color: #3c4f71;
            margin-bottom: 8px;
            display: block;
            font-size: 13px;
        }

        .form-control {
            border-radius: 14px;
            border: 1px solid #dfe7f5;
            padding: 12px 14px;
            background: #f9fbff;
        }

        .form-control:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 0.18rem rgba(74, 108, 247, 0.18);
        }

        .btn-login {
            width: 100%;
            border-radius: 14px;
            padding: 12px 0;
            font-weight: 700;
            background: #2f5ad4;
            border: none;
            color: white;
        }

        .btn-login:hover {
            background: #244bb0;
        }

        .form-footer {
            text-align: center;
            margin-top: 18px;
            color: #6d7c99;
            font-size: 14px;
        }

        .form-footer a {
            color: #2f5ad4;
            font-weight: 700;
            text-decoration: none;
        }

        .alert {
            border-radius: 16px;
            border: none;
            margin-bottom: 24px;
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
                <h1>SIPKOS</h1>
                <p>Masuk untuk mulai mencari kos favoritmu</p>
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

            <form action="<?php echo ROUTE_URL; ?>login" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email atau Username</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Masukkan email atau username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-login">Masuk</button>
            </form>

            <div class="form-footer">
                Belum punya akun? <a href="<?php echo ROUTE_URL; ?>register">Daftar di sini</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

