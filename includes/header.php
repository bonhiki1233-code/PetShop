<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$basePath = '/PetShop';
$stylesheet = isset($pageStylesheet) ? $pageStylesheet : $basePath . '/assets/css/index.css';
$cartCount = 0;

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += (int) ($cartItem['soluong'] ?? 0);
    }
}
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars($stylesheet, ENT_QUOTES, 'UTF-8'); ?>">

<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="<?php echo $basePath; ?>/index.php">PetShop</a>
        <nav class="site-nav">
<<<<<<< HEAD
            <a href="<?php echo $basePath; ?>/index.php">Trang chu</a>
            <a href="<?php echo $basePath; ?>/products.php">San pham</a>
            <a href="<?php echo $basePath; ?>/cart/cart.php" class="cart-link">
                Gio hang
=======
            <a href="<?php echo $basePath; ?>/index.php">Trang chủ</a>
            <a href="<?php echo $basePath; ?>/products.php">Sản phẩm</a>
            <a href="<?php echo $basePath; ?>/cart/cart.php" class="cart-link">
                Giỏ hàng
>>>>>>> 0ea953d7572768a8c8bf7a06e5aaeb7addb03660
                <?php if ($cartCount > 0): ?>
                    <span class="cart-count"><?php echo "$cartCount"; ?></span>
                <?php endif; ?>
            </a>
<<<<<<< HEAD
            <a href="<?php echo $basePath; ?>/search.php" class="btn btn-secondary">Tim kiem</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                    <a href="<?php echo $basePath; ?>/admin/admin_products.php" class="btn btn-secondary">Quan tri</a>
                    <span class="user-greeting">Admin: <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php else: ?>
                    <span class="user-greeting">Chao, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php endif; ?>
                <a href="<?php echo $basePath; ?>/auth/logout.php">Dang xuat</a>
            <?php else: ?>
                <a href="<?php echo $basePath; ?>/auth/login.php">Dang nhap</a>
                <a href="<?php echo $basePath; ?>/auth/register.php" class="btn btn-secondary">Dang ky</a>
=======
            <a href="<?php echo $basePath; ?>/search.php" class="btn btn-secondary">Tìm kiếm</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                    <a href="<?php echo $basePath; ?>/admin/admin_products.php" class="btn btn-secondary">Quản trị</a>
                    <span class="user-greeting">Admin: <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php else: ?>
                    <span class="user-greeting">Chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php endif; ?>
                <a href="<?php echo $basePath; ?>/auth/logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="<?php echo $basePath; ?>/auth/login.php">Đăng nhập</a>
                <a href="<?php echo $basePath; ?>/auth/register.php" class="btn btn-secondary">Đăng ký</a>
>>>>>>> 0ea953d7572768a8c8bf7a06e5aaeb7addb03660
            <?php endif; ?>
        </nav>
    </div>
</header>