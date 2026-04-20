<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="/PetShop/index.php">PetShop</a>
        <nav class="site-nav">
            <a href="/PetShop/index.php">Trang chủ</a>
            <a href="/PetShop/products.php">Sản phẩm</a>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="#">Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="/PetShop/auth/logout.php">Đăng xuất</a>
            <?php else : ?>
                <a href="/PetShop/auth/login.php">Đăng nhập</a>
                <a href="/PetShop/auth/register.php">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
