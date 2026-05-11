<?php
$current_user = $_SESSION['user'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <div>
            <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="ms-auto">
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    <i class="fas fa-user-circle"></i>
                    <?php echo htmlspecialchars($current_user['nama'] ?? 'User'); ?>
                </span>
                <a href="<?php echo BASE_URL; ?>logout" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
    });
</script>
