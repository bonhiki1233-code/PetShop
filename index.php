<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$products = [];
$productCount = 0;

$sql = "SELECT * FROM Products";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="/PetShop/styles.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main>

    <section class="hero">

        <div class="hero-main">
            <span class="eyebrow">Chăm sóc thú cưng yêu thương</span>
            <h1>Nơi gửi trọn yêu thương<br>cho người bạn nhỏ của bạn.</h1>
            <p>
                PetShop cung cấp thức ăn, phụ kiện và sản phẩm chăm sóc chất lượng cao
                cho chó, mèo và nhiều thú cưng khác — giao hàng tận nơi, đặt hàng dễ dàng 24/7.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="/PetShop/products.php">🛍 Xem tất cả sản phẩm</a>
                <a class="btn btn-secondary" href="/PetShop/auth/register.php">Tạo tài khoản miễn phí</a>
            </div>
            <div class="stats">
                <div class="panel">
                    <strong><?php echo $productCount; ?>+</strong>
                    <span>Sản phẩm</span>
                </div>
                <div class="panel">
                    <strong>24/7</strong>
                    <span>Đặt hàng online</span>
                </div>
                <div class="panel">
                    <strong>100%</strong>
                    <span>Tập trung thú cưng</span>
                </div>
            </div>
        </div>

        <aside class="hero-aside">
            <h2>Tại sao chọn PetShop?</h2>
            <ul class="aside-list">
                <li>Sản phẩm được kiểm định chất lượng, an toàn cho thú cưng</li>
                <li>Giao hàng nhanh trong ngày tại TP.HCM và các tỉnh lân cận</li>
                <li>Tư vấn chăm sóc thú cưng miễn phí qua chat hoặc hotline</li>
                <li>Đổi trả dễ dàng trong vòng 7 ngày nếu sản phẩm lỗi</li>
            </ul>
            <div class="aside-cta">
                <a class="btn btn-green" href="/PetShop/auth/register.php">Đăng ký nhận ưu đãi</a>
            </div>
        </aside>

    </section>
    <div class="section-wrap">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Sản phẩm nổi bật</span>
                <h2>Gợi ý cho lần mua sắm đầu tiên</h2>
                <p>Những sản phẩm được yêu thích nhất tại PetShop.</p>
            </div>
            <a class="btn btn-secondary" href="/PetShop/products.php">Xem toàn bộ danh mục →</a>
        </div>

        <?php if (!empty($featuredProducts)) : ?>
            <div class="product-grid">
                <?php foreach ($featuredProducts as $product) : ?>
                    <?php
                    $productName        = $product['product_name'] ?? 'Sản phẩm đang cập nhật';
                    $productPrice       = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' ₫' : 'Liên hệ';
                    $productDescription = $product['description'] ?? 'Sản phẩm chất lượng cao dành cho thú cưng của bạn.';
                    $category           = $product['category'] ?? 'Pet care';
                    $productImage       = petshop_product_image($product);
                    $productAlt         = petshop_product_alt($product);
                    $productId          = $product['product_id'] ?? '#';
                    ?>
                    <article class="product-card">
                        <div class="product-image-shell">
                            <img class="product-image"
                                 src="<?php echo htmlspecialchars($productImage); ?>"
                                 alt="<?php echo htmlspecialchars($productAlt); ?>"
                                 loading="lazy">
                        </div>
                        <div class="product-body">
                            <span class="product-badge"><?php echo htmlspecialchars($category); ?></span>
                            <h3><?php echo htmlspecialchars($productName); ?></h3>
                            <p><?php echo htmlspecialchars($productDescription); ?></p>
                            <div class="product-footer">
                                <span class="price"><?php echo htmlspecialchars($productPrice); ?></span>
                                <a class="btn-cart" href="/PetShop/products.php?id=<?php echo htmlspecialchars($productId); ?>">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="empty-state">
                <h3>Chưa có sản phẩm nào trong hệ thống</h3>
                <p>Hãy kiểm tra bảng <code>Products</code> trong database <code>petshop_db</code> để hiển thị dữ liệu tại đây.</p>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>