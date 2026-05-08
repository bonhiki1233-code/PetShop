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
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/index.css">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="page-section">

        <section class="hero">
            <div class="hero-card">
                <span class="eyebrow">Chăm sóc thú cưng mỗi ngày</span>
                <h1>Không gian mua sắm cho<br><em style="color:var(--clr-primary);font-style:normal;">Boss và " Sen"</em>.</h1>
                <p>PetShop mang đến thú cưng bạn yêu thích cùng các vật dụng, thức ăn chất lượng mà "Boss" của bạn cần mỗi ngày.</p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= $base_url ?>/products.php">🛍️ Xem tất cả sản phẩm</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-secondary" href="<?= $base_url ?>/auth/register.php">Tạo tài khoản</a>
                    <?php endif; ?>
                </div>

                <div class="stats">
                    <div class="panel">
                        <strong><?= $productCount ?>+</strong>
                        <span>Sản phẩm</span>
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

            <aside class="hero-card hero-aside">
                <h2>Dễ dàng cho người dùng</h2>
                <ul class="aside-features">
                    <li>Đặt hàng nhanh, giao hàng tận nơi</li>
                    <li>Sản phẩm chính hãng, kiểm định chất lượng</li>
                    <li>Thanh toán linh hoạt, bảo mật</li>
                    <li>Hỗ trợ tư vấn chăm sóc thú cưng</li>
                </ul>
            </aside>
        </section>

        <section>
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Sản phẩm nổi bật</span>
                    <h2>Đề xuất cho bạn</h2>
                </div>
                <a class="btn btn-secondary" href="<?= $base_url ?>/products.php">Xem tất cả</a>
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
                        <a href="<?= $base_url ?>/product_detail.php?id=<?= $product['product_id'] ?>" style="text-decoration:none;color:inherit;display:contents;">
                            <div class="product-image-shell">
                                <img class="product-image"
                                     src="<?= $productImage ?>"
                                     alt="<?= htmlspecialchars($productName) ?>"
                                     loading="lazy">
                            </div>
                            <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                            <h3><?= htmlspecialchars($productName) ?></h3>
                            <p>Thông tin chi tiết sẽ được bổ sung sớm.</p>
                            <p class="price"><?= $productPrice ?></p>
                        </a>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state" style="grid-column:1/-1">
                        <h3>🐾 Chưa có sản phẩm nào</h3>
                        <p>Sản phẩm sẽ được cập nhật sớm.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main><!-- /page-section -->

    <!-- ══ TRUST SECTION (full-bleed, ngoài .page-section) ══ -->
    <section class="trust-section">
        <div class="trust-inner">

            <!-- Tiêu đề -->
            <div class="trust-header">
                <span class="eyebrow">Cam kết của chúng tôi</span>
                <h2>Vì sao chọn PetShop?</h2>
                <p>Chúng tôi cam kết mang lại trải nghiệm mua sắm tốt nhất cho "Boss" của bạn.</p>
            </div>

            <!-- 4 ô uy tín -->
            <div class="trust-badges">
                <div class="trust-badge">
                    <span class="badge-icon">🔒</span>
                    <h4>Thanh toán bảo mật</h4>
                    <p>Mã hoá SSL 256-bit, hỗ trợ COD, chuyển khoản & ví điện tử an toàn.</p>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">🚚</span>
                    <h4>Giao hàng toàn quốc</h4>
                    <p>Giao hàng nhanh 24–48h tại TP.HCM và các tỉnh thành trên toàn quốc.</p>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">✅</span>
                    <h4>Hàng chính hãng</h4>
                    <p>100% sản phẩm có nguồn gốc rõ ràng, được kiểm định chất lượng trước khi xuất kho.</p>
                </div>
                <div class="trust-badge">
                    <span class="badge-icon">🔄</span>
                    <h4>Đổi trả dễ dàng</h4>
                    <p>Chính sách đổi trả trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.</p>
                </div>
            </div>

            <hr class="trust-divider">

            <!-- Review khách hàng -->
            <div class="trust-social">
                <div class="review-card">
                    <div class="review-stars">★★★★★</div>
                    <blockquote>"Mình đặt thức ăn cho boss mèo lần đầu, giao hàng nhanh, hàng y như mô tả. Sẽ ủng hộ dài dài!"</blockquote>
                    <div class="review-author">
                        <div class="review-avatar">N</div>
                        <div class="review-author-info">
                            <strong>Ngọc Anh</strong>
                            <span>Khách hàng tại TP.HCM</span>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">
                    <blockquote>"Shop tư vấn rất nhiệt tình, giúp mình chọn đúng loại thức ăn phù hợp cho cún nhà mình. Cảm ơn shop!"</blockquote>
                    <div class="review-author">
                        <div class="review-avatar">M</div>
                        <div class="review-author-info">
                            <strong>Minh Khôi</strong>
                            <span>Khách hàng tại Hà Nội</span>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">★★★★☆</div>
                    <blockquote>"Sản phẩm tốt, giá hợp lý, đóng gói cẩn thận. Boss nhà mình rất thích món đồ chơi mua ở đây."</blockquote>
                    <div class="review-author">
                        <div class="review-avatar">T</div>
                        <div class="review-author-info">
                            <strong>Thu Hà</strong>
                            <span>Khách hàng tại Đà Nẵng</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Số liệu thống kê -->
            <div class="trust-stats">
                <div class="trust-stat">
                    <strong>2,500+</strong>
                    <span>Đơn hàng hoàn thành</span>
                </div>
                <div class="trust-stat">
                    <strong>98%</strong>
                    <span>Khách hàng hài lòng</span>
                </div>
                <div class="trust-stat">
                    <strong>50+</strong>
                    <span>Thương hiệu uy tín</span>
                </div>
                <div class="trust-stat">
                    <strong>24/7</strong>
                    <span>Hỗ trợ trực tuyến</span>
                </div>
            </div>

        </div><!-- /trust-inner -->
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>