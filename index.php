<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$base_url = petshop_base_url();
$products = [];
$productCount = 0;

$sql = "
    SELECT
        p.*,
        c.category_name
    FROM Products p
    LEFT JOIN Categories c ON c.category_id = p.category_id
";

$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    $productCount = count($products);
}

$featuredProducts = array_slice($products, 0, 4);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | Trang ch&#7911;</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/index.css">
</head>
<body>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Ch&#259;m s&#243;c th&#250; c&#432;ng m&#7895;i ng&#224;y</p>
                <h1>Kh&#244;ng gian mua s&#7855;m<br>cho <em>Boss</em> v&#224; <em>"Sen"</em></h1>
                <p class="hero-sub">PetShop mang &#273;&#7871;n th&#250; c&#432;ng b&#7841;n y&#234;u th&#237;ch c&#249;ng c&#225;c v&#7853;t d&#7909;ng, th&#7913;c &#259;n ch&#7845;t l&#432;&#7907;ng m&#224; "Boss" c&#7911;a b&#7841;n c&#7847;n m&#7895;i ng&#224;y.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= $base_url ?>/products.php">Xem t&#7845;t c&#7843; s&#7843;n ph&#7849;m</a>
                    <a class="btn btn-outline" href="<?= $base_url ?>/search.php">T&#236;m ki&#7871;m s&#7843;n ph&#7849;m</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-outline" href="<?= $base_url ?>/auth/register.php">T&#7841;o t&#224;i kho&#7843;n mi&#7877;n ph&#237;</a>
                    <?php endif; ?>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong><?= $productCount ?>+</strong>
                        <span>S&#7843;n ph&#7849;m</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <strong>24/7</strong>
                        <span>H&#7895; tr&#7907;</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <strong>100%</strong>
                        <span>Ch&#237;nh h&#227;ng</span>
                    </div>
                </div>
            </div>

            <div class="hero-side">
                <div class="promo-card">
                    <span class="promo-tag">&#431;u &#273;&#227;i h&#244;m nay</span>
                    <h3>Gi&#7843;m &#273;&#7871;n <em>20%</em></h3>
                    <p>Cho &#273;&#417;n h&#224;ng &#273;&#7847;u ti&#234;n khi &#273;&#259;ng k&#253; th&#224;nh vi&#234;n m&#7899;i.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-dark" href="<?= $base_url ?>/auth/register.php">&#272;&#259;ng k&#253; ngay</a>
                    <?php else: ?>
                        <a class="btn btn-dark" href="<?= $base_url ?>/products.php">Kh&#225;m ph&#225; ngay</a>
                    <?php endif; ?>
                    <div class="promo-decor">&#128062;</div>
                </div>

                <div class="features-card">
                    <ul>
                        <li><span class="feat-dot"></span>&#272;&#7863;t h&#224;ng nhanh, giao h&#224;ng t&#7853;n n&#417;i</li>
                        <li><span class="feat-dot"></span>S&#7843;n ph&#7849;m ch&#237;nh h&#227;ng, ki&#7875;m &#273;&#7883;nh ch&#7845;t l&#432;&#7907;ng</li>
                        <li><span class="feat-dot"></span>Thanh to&#225;n linh ho&#7841;t, b&#7843;o m&#7853;t</li>
                        <li><span class="feat-dot"></span>H&#7895; tr&#7907; t&#432; v&#7845;n ch&#259;m s&#243;c th&#250; c&#432;ng</li>
                    </ul>
                </div>
            </div>
        </section>

        <nav class="categories-strip" aria-label="Danh m&#7909;c s&#7843;n ph&#7849;m">
            <div class="categories-inner">
                <a href="<?= $base_url ?>/products.php" class="cat-chip active">T&#7845;t c&#7843;</a>
                <a href="<?= $base_url ?>/search.php?type=pet" class="cat-chip">Th&#250; c&#432;ng</a>
                <a href="<?= $base_url ?>/search.php?category_id=2" class="cat-chip">Th&#7913;c &#259;n</a>
                <a href="<?= $base_url ?>/search.php?category_id=3" class="cat-chip">Ph&#7909; ki&#7879;n</a>
                <a href="<?= $base_url ?>/search.php?stock=available" class="cat-chip">C&#242;n h&#224;ng</a>
                <a href="<?= $base_url ?>/search.php?sort=price_desc" class="cat-chip">Gi&#225; cao</a>
            </div>
        </nav>

        <section class="section products-section">
            <div class="section-head">
                <div>
                    <p class="eyebrow">S&#7843;n ph&#7849;m n&#7893;i b&#7853;t</p>
                    <h2>&#272;&#7873; xu&#7845;t cho b&#7841;n</h2>
                </div>
                <a class="link-all" href="<?= $base_url ?>/products.php">Xem t&#7845;t c&#7843; &rarr;</a>
            </div>

            <div class="product-grid">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                        <?php
                        $productName = $product['product_name'] ?? 'San pham';
                        $productPrice = isset($product['price_new'])
                            ? number_format((float) $product['price_new'], 0, ',', '.') . ' VND'
                            : 'Lien he';
                        $category = petshop_product_category_label($product);
                        $productImage = petshop_product_image($product);
                        ?>
                        <article class="product-card">
                            <a href="<?= $base_url ?>/products.php">
                                <div class="product-img-wrap">
                                    <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                                    <img
                                        src="<?= htmlspecialchars($productImage) ?>"
                                        alt="<?= htmlspecialchars($productName) ?>"
                                        loading="lazy"
                                    >
                                </div>
                                <div class="product-info">
                                    <h3><?= htmlspecialchars($productName) ?></h3>
                                    <div class="product-footer">
                                        <span class="price"><?= $productPrice ?></span>
                                        <span class="product-cta">Xem chi ti&#7871;t &rarr;</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>PetShop</p>
                        <h3>Ch&#432;a c&#243; s&#7843;n ph&#7849;m n&#224;o</h3>
                        <p>S&#7843;n ph&#7849;m s&#7869; &#273;&#432;&#7907;c c&#7853;p nh&#7853;t s&#7899;m.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <section class="trust-section">
        <div class="trust-inner">
            <p class="eyebrow" style="text-align:center">Cam k&#7871;t c&#7911;a ch&#250;ng t&#244;i</p>
            <h2 class="trust-title">V&#236; sao ch&#7885;n PetShop?</h2>
            <div class="trust-grid">
                <div class="trust-item">
                    <span class="trust-icon">&#128666;</span>
                    <h4>Giao h&#224;ng to&#224;n qu&#7889;c</h4>
                    <p>Giao h&#224;ng nhanh 24-48h t&#7841;i TP.HCM v&#224; c&#225;c t&#7881;nh th&#224;nh tr&#234;n to&#224;n qu&#7889;c.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#9989;</span>
                    <h4>H&#224;ng ch&#237;nh h&#227;ng</h4>
                    <p>100% s&#7843;n ph&#7849;m c&#243; ngu&#7891;n g&#7889;c r&#245; r&#224;ng, &#273;&#432;&#7907;c ki&#7875;m &#273;&#7883;nh ch&#7845;t l&#432;&#7907;ng tr&#432;&#7899;c khi xu&#7845;t kho.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#128260;</span>
                    <h4>&#272;&#7893;i tr&#7843; d&#7877; d&#224;ng</h4>
                    <p>Ch&#237;nh s&#225;ch &#273;&#7893;i tr&#7843; trong v&#242;ng 7 ng&#224;y n&#7871;u s&#7843;n ph&#7849;m c&#243; l&#7895;i t&#7915; nh&#224; s&#7843;n xu&#7845;t.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#127942;</span>
                    <h4>50+ Th&#432;&#417;ng hi&#7879;u</h4>
                    <p>H&#7907;p t&#225;c v&#7899;i h&#417;n 50 th&#432;&#417;ng hi&#7879;u uy t&#237;n trong v&#224; ngo&#224;i n&#432;&#7899;c.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
