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
            <a href="<?php echo $basePath; ?>/index.php">Trang ch&#7911;</a>
            <a href="<?php echo $basePath; ?>/products.php">S&#7843;n ph&#7849;m</a>
            <a href="<?php echo $basePath; ?>/cart/cart.php" class="cart-link">
                Gi&#7887; h&#224;ng
                <?php if ($cartCount > 0): ?>
                    <span class="cart-count"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo $basePath; ?>/search.php" class="btn btn-secondary">T&#236;m ki&#7871;m</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
                    <a href="<?php echo $basePath; ?>/admin/admin_products.php" class="btn btn-secondary">Qu&#7843;n tr&#7883;</a>
                    <span class="user-greeting">Admin: <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php else: ?>
                <span class="user-greeting">Ch&#224;o, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php endif; ?>
                <a href="<?php echo $basePath; ?>/auth/logout.php">&#272;&#259;ng xu&#7845;t</a>
            <?php else: ?>
                <a href="<?php echo $basePath; ?>/auth/login.php">&#272;&#259;ng nh&#7853;p</a>
                <a href="<?php echo $basePath; ?>/auth/register.php" class="btn btn-secondary">&#272;&#259;ng k&#253;</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
