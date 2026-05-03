<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$base_url = (strpos($_SERVER['REQUEST_URI'], '/PetShop') === 0) ? '/PetShop' : '';
$img_path = $base_url . '/assets/images/';
?>
<link rel="stylesheet" href="<?= $base_url ?>/assets/css/styles.css">
<link rel="stylesheet" href="<?= $base_url ?>/assets/css/index.css">

<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="<?= $base_url ?>/index.php" style="color: var(--clr-primary); font-weight: 800;">PetShop</a>

        <nav class="site-nav" style="align-items: center;">
            <a href="<?= $base_url ?>/index.php">Trang chủ</a>
            <a href="<?= $base_url ?>/products.php">Sản phẩm</a>
            
            <a href="<?= $base_url ?>/cart/cart.php">Giỏ hàng</a>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                <a href="<?= $base_url ?>/admin/admin_products.php">Quản trị</a>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
                <span style="color: var(--brand); font-weight: bold; margin-left: 10px;">Chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="<?= $base_url ?>/auth/logout.php" class="btn btn-secondary" style="padding: 6px 16px; margin-left: 8px;">Đăng xuất</a>
            <?php else: ?>
                <a href="<?= $base_url ?>/auth/login.php" style="margin-left: 10px;">Đăng nhập</a>
                <a href="<?= $base_url ?>/auth/register.php" class="btn btn-secondary" style="padding: 6px 16px;">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>