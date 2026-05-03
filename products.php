<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$products = [];
$sql = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $products[] = $row; }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PetShop | Sản phẩm</title>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container page-section">
        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
            <?php
                $productName = $product['product_name'] ?? 'Sản phẩm';
                $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' ₫' : 'Liên hệ';
                $category = $product['category'] ?? 'Pet care';
                
                // Khắc phục hardcode đường dẫn
                $productImage = !empty($product['image_url']) ? $img_path . htmlspecialchars($product['image_url']) : petshop_product_image($product);
            ?>
            <article class="product-card">
                <div class="product-image-shell">
                    <img class="product-image" src="<?= $productImage ?>" alt="img">
                </div>
                <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                <h3><?= htmlspecialchars($productName) ?></h3>
                <p class="price"><?= $productPrice ?></p>
    
                <form action="cart/cart.php" method="POST" style="margin-top: 15px;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($productName) ?>">
                    <input type="hidden" name="price" value="<?= $product['price_new'] ?>">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Thêm vào giỏ</button>
                </form>
            </article>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>