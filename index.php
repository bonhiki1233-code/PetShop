<?php
include __DIR__ . '/database/config/db.php';
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
    <title>PetShop | Trang chủ</title>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container page-section">
        <section class="hero">
            <div class="hero-card">
                <span class="eyebrow">Chăm sóc thú cưng mỗi ngày</span>
                <h1>Không gian mua sắm cho "Boss & Sen".</h1>
                <p>PetShop mang đến thú cưng bạn yêu thích cùng các vật dụng, thức ăn chất lượng mà "Boss" của bạn cần mỗi ngày.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?= $base_url ?>/products.php">🛍️ Xem tất cả sản phẩm</a>
                    <?php if(!isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-secondary" href="<?= $base_url ?>/auth/register.php">Tạo tài khoản</a>
                    <?php endif; ?>
                </div>
                <div class="stats">
                    <div class="panel"><strong><?= $productCount ?>+</strong><span>sản phẩm</span></div>
                    <div class="panel"><strong>24/7</strong><span>Hỗ trợ đặt hàng</span></div>
                    <div class="panel"><strong>100%</strong><span>Tập trung vào thú cưng</span></div>
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
                <?php foreach ($featuredProducts as $product) : ?>
                <?php
                    $productName = $product['product_name'] ?? 'Sản phẩm';
                    $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' ₫' : 'Liên hệ';
                    $category = $product['category'] ?? 'Pet care';
                    
                    $productImage = !empty($product['image_url']) ? $img_path . htmlspecialchars($product['image_url']) : petshop_product_image($product);
                ?>
                <article class="product-card">
                    <div class="product-image-shell">
                        <img class="product-image" src="<?= $productImage ?>" alt="img">
                    </div>
                    <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                    <h3><?= htmlspecialchars($productName) ?></h3>
                    <p>Thông tin chi tiết sẽ được bổ sung sớm.</p>
                    <p class="price"><?= $productPrice ?></p>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>