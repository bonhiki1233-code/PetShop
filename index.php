<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php'; 

$products     = [];
$productCount = 0;
$sql    = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $products[] = $row; }
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/index.css">
</head>
<body>

    <!-- Announcement Bar -->
    <div class="announce-bar">
        <span>🚚 Miễn phí giao hàng cho đơn từ <strong>299.000 ₫</strong></span>
        <span class="sep">|</span>
        <span>Hỗ trợ 24/7</span>
        <span class="sep">|</span>
        <span>Hàng chính hãng 100%</span>
    </div>

    <?php include __DIR__ . '/includes/header.php'; ?>

    <main>

        <!-- ════ HERO ════ -->
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Chăm sóc thú cưng mỗi ngày</p>
                <h1>Không gian mua sắm<br>cho <em>Boss</em> và <em>"Sen"</em></h1>
                <p class="hero-sub">PetShop mang đến thú cưng bạn yêu thích cùng các vật dụng, thức ăn chất lượng mà "Boss" của bạn cần mỗi ngày.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= $base_url ?>/products.php">Xem tất cả sản phẩm</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-outline" href="<?= $base_url ?>/auth/register.php">Tạo tài khoản miễn phí</a>
                    <?php endif; ?>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong><?= $productCount ?>+</strong>
                        <span>Sản phẩm</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <strong>24/7</strong>
                        <span>Hỗ trợ</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <strong>100%</strong>
                        <span>Chính hãng</span>
                    </div>
                </div>
            </div>

            <div class="hero-side">
                <div class="promo-card">
                    <span class="promo-tag">Ưu đãi hôm nay</span>
                    <h3>Giảm đến <em>20%</em></h3>
                    <p>Cho đơn hàng đầu tiên khi đăng ký thành viên mới.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-dark" href="<?= $base_url ?>/auth/register.php">Đăng ký ngay</a>
                    <?php else: ?>
                    <a class="btn btn-dark" href="<?= $base_url ?>/products.php">Khám phá ngay</a>
                    <?php endif; ?>
                    <div class="promo-decor">🐾</div>
        </section>

        <!-- ════ CATEGORY STRIP ════ -->
        <nav class="categories-strip" aria-label="Danh mục sản phẩm">
            <div class="categories-inner">
                <a href="<?= $base_url ?>/products.php" class="cat-chip active">🐾 Tất cả</a>
                <a href="<?= $base_url ?>/products.php?cat=food" class="cat-chip">🍖 Thức ăn</a>
                <a href="<?= $base_url ?>/products.php?cat=toy" class="cat-chip">🎾 Đồ chơi</a>
                <a href="<?= $base_url ?>/products.php?cat=care" class="cat-chip">🛁 Chăm sóc</a>
                <a href="<?= $base_url ?>/products.php?cat=cage" class="cat-chip">🏠 Chuồng & nhà</a>
                <a href="<?= $base_url ?>/products.php?cat=leash" class="cat-chip">🦮 Dây dắt</a>
                <a href="<?= $base_url ?>/products.php?cat=supplement" class="cat-chip">💊 Thực phẩm bổ sung</a>
            </div>
        </nav>

        <!-- ════ FEATURED PRODUCTS ════ -->
        <section class="section products-section">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Sản phẩm nổi bật</p>
                    <h2>Đề xuất cho bạn</h2>
                </div>
                <a class="link-all" href="<?= $base_url ?>/products.php">Xem tất cả →</a>
            </div>

            <div class="product-grid">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <?php
                        $productName  = $product['product_name'] ?? 'Sản phẩm';
                        $productPrice = isset($product['price_new'])
                            ? number_format((float) $product['price_new'], 0, ',', '.') . ' ₫'
                            : 'Liên hệ';
                        $category     = $product['category'] ?? 'Pet care';
                        $productImage = !empty($product['image_url'])
                            ? $img_path . htmlspecialchars($product['image_url'])
                            : petshop_product_image($product);
                    ?>
                    <article class="product-card">
                        <a href="<?= $base_url ?>/product_detail.php?id=<?= $product['product_id'] ?>">
                            <div class="product-img-wrap">
                                <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                                <img src="<?= $productImage ?>"
                                     alt="<?= htmlspecialchars($productName) ?>"
                                     loading="lazy">
                            </div>
                            <div class="product-info">
                                <h3><?= htmlspecialchars($productName) ?></h3>
                                <div class="product-footer">
                                    <span class="price"><?= $productPrice ?></span>
                                    <span class="product-cta">Xem chi tiết →</span>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>🐾</p>
                        <h3>Chưa có sản phẩm nào</h3>
                        <p>Sản phẩm sẽ được cập nhật sớm.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <!-- ════ TRUST SECTION ════ -->
    <section class="trust-section">
        <div class="trust-inner">
            <p class="eyebrow" style="text-align:center">Cam kết của chúng tôi</p>
            <h2 class="trust-title">Vì sao chọn PetShop?</h2>
            <div class="trust-grid">
                <div class="trust-item">
                    <span class="trust-icon">🚚</span>
                    <h4>Giao hàng toàn quốc</h4>
                    <p>Giao hàng nhanh 24–48h tại TP.HCM và các tỉnh thành trên toàn quốc.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">✅</span>
                    <h4>Hàng chính hãng</h4>
                    <p>100% sản phẩm có nguồn gốc rõ ràng, được kiểm định chất lượng trước khi xuất kho.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">🔄</span>
                    <h4>Đổi trả dễ dàng</h4>
                    <p>Chính sách đổi trả trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">🏆</span>
                    <h4>50+ Thương hiệu</h4>
                    <p>Hợp tác với hơn 50 thương hiệu uy tín trong và ngoài nước.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>