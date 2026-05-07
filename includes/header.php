<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$basePath = '/PetShop';
$stylesheet = isset($pageStylesheet) ? $pageStylesheet : $basePath . '/assets/css/index.css';
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars($stylesheet, ENT_QUOTES, 'UTF-8'); ?>">

<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="<?php echo $basePath; ?>/index.php">PetShop</a>
        <nav class="site-nav">
            <a href="<?php echo $basePath; ?>/index.php">Trang chủ</a>
            <a href="<?php echo $basePath; ?>/products.php">Sản phẩm</a>
            <a href="<?php echo $basePath; ?>/search.php" class="btn btn-secondary" style="padding: 8px 18px;">Tìm kiếm</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: var(--brand); font-weight: bold;">Chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="<?php echo $basePath; ?>/auth/logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="<?php echo $basePath; ?>/auth/login.php">Đăng nhập</a>
                <a href="<?php echo $basePath; ?>/auth/register.php" class="btn btn-secondary" style="padding: 8px 20px;">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
