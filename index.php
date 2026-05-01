<?php
// ── Data & Logic ───────────────────────────────────────────────────────────────
include __DIR__ . '/database/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$products     = [];
$productCount = 0;

$sql    = "SELECT * FROM Products";
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
    <title>PetShop | Trang chủ</title>

    <!-- Google Fonts preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Page stylesheet (tách riêng) -->
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main class="container page-section">

    <!-- ── Hero ──────────────────────────────────────────── -->
    <section class="hero">

        <!-- Main hero card -->
        <div class="hero-card">
            <span class="eyebrow">Chăm sóc thú cưng mỗi ngày</span>
            <h1>Không gian mua sắm cho&nbsp;"Boss &amp; Sen".</h1>
            <p>
                PetShop mang đến thú cưng bạn yêu thích cùng các vật dụng,
                thức ăn chất lượng mà "Boss" của bạn cần mỗi ngày.
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="/products.php">
                    🛍️ Xem tất cả sản phẩm
                </a>
                <a class="btn btn-secondary" href="/auth/register.php">
                    Tạo tài khoản
                </a>
            </div>

            <!-- Stats strip -->
            <div class="stats">
                <div class="panel">
                    <strong><?php echo $productCount; ?>+</strong>
                    <span>sản phẩm</span>
                </div>
                <div class="panel">
                    <strong>24/7</strong>
                    <span>Hỗ trợ đặt hàng</span>
                </div>
                <div class="panel">
                    <strong>100%</strong>
                    <span>Tập trung vào thú cưng</span>
                </div>
            </div>
        </div>

        <!-- Aside info card -->
        <aside class="hero-card hero-aside">
            <h2>Dễ dàng cho người dùng</h2>
            <ul class="aside-features">
                <li>Đặt hàng nhanh, giao hàng tận nơi</li>
                <li>Sản phẩm chính hãng, kiểm định chất lượng</li>
                <li>Thanh toán linh hoạt, bảo mật</li>
                <li>Hỗ trợ tư vấn chăm sóc thú cưng</li>
            </ul>
        </aside>

    </section><!-- /hero -->

    <!-- ── Featured Products ──────────────────────────────── -->
    <section>
        <div class="section-heading">
            <div>
                <span class="eyebrow">Sản phẩm nổi bật</span>
                <h2>Đề xuất cho bạn</h2>
            </div>
            <a class="btn btn-secondary" href="/products.php">Xem tất cả</a>
        </div>

        <?php if (!empty($featuredProducts)) : ?>
            <div class="product-grid">
                <?php foreach ($featuredProducts as $product) : ?>
                    <?php
                    $productName        = $product['product_name']  ?? 'Sản phẩm đang cập nhật';
                    $productPrice       = isset($product['price_new'])
                                            ? number_format((float) $product['price_new']) . ' ₫'
                                            : 'Liên hệ';
                    $productDescription = $product['description']   ?? 'Thông tin chi tiết sẽ được bổ sung sớm.';
                    $category           = $product['category']      ?? 'Pet care';
                    $productImage       = petshop_product_image($product);
                    $productAlt         = petshop_product_alt($product);
                    ?>
                    <article class="product-card">
                        <div class="product-image-shell">
                            <img
                                class="product-image"
                                src="<?php echo htmlspecialchars($productImage); ?>"
                                alt="<?php echo htmlspecialchars($productAlt); ?>"
                                loading="lazy"
                            >
                        </div>
                        <span class="product-badge"><?php echo htmlspecialchars($category); ?></span>
                        <h3><?php echo htmlspecialchars($productName); ?></h3>
                        <p><?php echo htmlspecialchars($productDescription); ?></p>
                        <p class="price"><?php echo htmlspecialchars($productPrice); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="empty-state">
                <h3>🐾 Chưa có sản phẩm nào trong hệ thống</h3>
            </div>
        <?php endif; ?>

    </section><!-- /featured products -->

</main>

</body>
</html>