<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<link rel="stylesheet" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/assets/css/index.css'; ?>">

<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="/index.php"></a>
        <nav class="site-nav">
            <a href="/index.php">Trang chủ</a>
            <a href="/products.php">Sản phẩm</a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <span style="color: var(--brand); font-weight: bold;">Chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/auth/logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="/auth/login.php">Đăng nhập</a>
                <a href="/auth/register.php" class="btn btn-secondary" style="padding: 8px 20px;">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>