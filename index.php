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
    <title>PetShop | Trang chu</title>
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
                <p class="eyebrow">Chăm sóc thú cưng mỗi ngàyy</p>
                <h1>Không gian mua sắm<br>cho <em>Boss & "Sen"</em></h1>
                <p class="hero-sub">PetShop mang đến thú cưng bạn yêu thích và các vật dụng, đồ ăn chất lượng cao mà "Boss" của bạn cần mỗi ngày.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= $base_url ?>/products.php">Xem tất cả sản phẩm</a>
                    <a class="btn btn-outline" href="<?= $base_url ?>/search.php">Tìm kiếm sản phẩm</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-outline" href="<?= $base_url ?>/auth/register.php">Tạo tài khoản</a>
                    <?php endif; ?>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong><?= $productCount ?>+</strong>
                        <span>Sản phẩm</span>
                    </div>
                </div>
            </div>

            <div class="hero-side">
                <div class="promo-card">
                    <span class="promo-tag">Ưu đãi</span>
                    <h3>Giảm đến <em>20%</em></h3>
                    <p>Cho đơn hàng đầu tiên.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-dark" href="<?= $base_url ?>/auth/register.php">Đăng ký ngay</a>
                    <?php else: ?>
                        <a class="btn btn-dark" href="<?= $base_url ?>/products.php">Khám phá ngay</a>
                    <?php endif; ?>
                    <div class="promo-decor">&#128062;</div>
                </div>

                <div class="features-card">
                    <ul>
                        <li><span class="feat-dot"></span>Đặt hàng dễ dàng, giao hàng nhanh</li>
                        <li><span class="feat-dot"></span>Thanh toán linh hoạt</li>
                        <li><span class="feat-dot"></span>Hỗ trợ chăm sóc, tư vấn</li>
                    </ul>
                </div>
            </div>
        </section>

        <nav class="categories-strip" aria-label="Danh muc san pham">
            <div class="categories-inner">
                <a href="<?= $base_url ?>/products.php" class="cat-chip active">tất cả</a>
                <a href="<?= $base_url ?>/search.php?type=pet" class="cat-chip">Thsu cưng</a>
                <a href="<?= $base_url ?>/search.php?category_id=2" class="cat-chip">Thức ăn</a>
                <a href="<?= $base_url ?>/search.php?category_id=3" class="cat-chip">Phụ kiện</a>
                <a href="<?= $base_url ?>/search.php?stock=available" class="cat-chip">Còn hàng</a>
                <a href="<?= $base_url ?>/search.php?sort=price_desc" class="cat-chip">Giá cao</a>
            </div>
        </nav>

        <section class="section products-section">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Sản phẩm nổi bật</p>
                    <h2>Đề xuất cho bạn</h2>
                </div>
                <a class="link-all" href="<?= $base_url ?>/products.php"> Xem tất cả </a>
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
                                    <img src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($productName) ?>" loading="lazy">
                                </div>
                                <div class="product-info">
                                    <h3><?= htmlspecialchars($productName) ?></h3>
                                    <div class="product-footer">
                                        <span class="price"><?= $productPrice ?></span>
                                        <span class="product-cta">Xem chi tiết &rarr;</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>PetShop</p>
                        <h3>Chưa có sản phẩm nào</h3>
                        <p>Sản phẩm sẽ được cập nhật sớm</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <section class="trust-section">
        <div class="trust-inner">
            <p class="eyebrow" style="text-align:center">Cam kết</p>
            <h2 class="trust-title">Vì sao nên chọn Petshop ?</h2>
            <div class="trust-grid">
                <div class="trust-item">
                    <span class="trust-icon">&#128666;</span>
                    <h4>Giao hàng toàn quốc</h4>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#9989;</span>
                    <h4>hàng chính hãng</h4>
                    <p>Sản phẩm rõ ràng, hỗ trợ bảo hành</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#128260;</span>
                    <h4>Đổi trả dễ dàng</h4>
                    <p>Chính sách đổi trả trong vòng 7 ngày nếu có lỗi</p>
                </div>
                <div class="trust-item">
                    <span class="trust-icon">&#127942;</span>
                    <h4>50+ Thương hiệu</h4>
                    <p>Đa dạng thương hiệu</p>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
