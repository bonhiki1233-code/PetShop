<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$products = [];
$sql = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | San pham</title>
    <link rel="stylesheet" href="/PetShop/assets/styles.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>

<main>
    <div class="page-header">
        <div class="container page-header-inner">
            <div>
                <span class="eyebrow">Danh muc san pham</span>
                <h1>Tat ca san pham cho thu cung</h1>
                <p>Kham pha day du thuc an, phu kien va san pham cham soc danh cho nguoi ban nho cua ban.</p>
            </div>
            <a class="btn btn-primary" href="/PetShop/auth/login.php">Dang nhap de mua hang</a>
        </div>
    </div>

    <?php if (!empty($products)) : ?>
        <div class="count-strip container">
            Tim thay <strong><?php echo count($products); ?> san pham</strong>
        </div>

        <section class="product-section container">
            <div class="product-grid">
                <?php foreach ($products as $product) : ?>
                    <?php
                    $productName = $product['product_name'] ?? 'San pham dang cap nhat';
                    $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' VND' : 'Lien he';
                    $productDescription = $product['description'] ?? 'Thong tin chi tiet cua san pham se duoc cap nhat them.';
                    $category = $product['category'] ?? 'Pet care';
                    $productImage = petshop_product_image($product);
                    $productAlt = petshop_product_alt($product);
                    $productId = $product['product_id'] ?? '#';
                    ?>
                    <article class="product-card">
                        <div class="product-image-shell">
                            <img class="product-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productAlt); ?>" loading="lazy">
                        </div>
                        <div class="product-body">
                            <span class="product-badge"><?php echo htmlspecialchars($category); ?></span>
                            <h3><?php echo htmlspecialchars($productName); ?></h3>
                            <p><?php echo htmlspecialchars($productDescription); ?></p>
                            <div class="product-footer">
                                <span class="price"><?php echo htmlspecialchars($productPrice); ?></span>
                                <a class="btn-cart" href="/PetShop/product_detail.php?id=<?php echo htmlspecialchars($productId); ?>">Xem chi tiet</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php else : ?>
        <section class="product-section container">
            <div class="empty-state">
                <div class="empty-icon">Pet</div>
                <h3>Chua tim thay san pham nao</h3>
                <p>Database da ket noi, nhung bang Products chua co du lieu de hien thi.</p>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/footer.php'; ?>
</body>
</html>
