<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<link rel="stylesheet" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/PetShop/assets/styles.css'; ?>">

<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="/PetShop/index.php">PetShop</a>
        <nav class="site-nav">
            <a href="/PetShop/index.php">Trang chủ</a>
            <a href="/PetShop/products.php">Sản phẩm</a>
            
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                    <a href="/PetShop/admin/admin_products.php">Quản trị</a>
                <?php endif; ?>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <span style="color: var(--brand); font-weight: bold;">Chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/PetShop/auth/logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="/PetShop/auth/login.php">Đăng nhập</a>
                <a href="/PetShop/auth/register.php" class="btn btn-secondary" style="padding: 8px 20px;">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>