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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | San pham</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>

<main class="container page-section">
    <section class="section-heading">
        <div>
            <span class="eyebrow">Danh muc san pham</span>
            <h1>Tat ca san pham cho thu cung</h1>
            <p>Trang nay hien thi danh sach san pham tu bang Products theo giao dien de xem va de mo rong sau nay.</p>
        </div>
        <a class="btn btn-primary" href="/PetShop/auth/login.php">Dang nhap de mua hang</a>
    </section>

    <?php if (!empty($products)) : ?>
        <section class="product-grid">
            <?php foreach ($products as $product) : ?>
                <?php
                $productName = $product['product_name'] ?? 'San pham dang cap nhat';
                $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' VND' : 'Lien he';
                $productDescription = $product['description'] ?? 'Thong tin chi tiet cua san pham se duoc cap nhat them.';
                $category = $product['category'] ?? 'Pet care';
                $productImage = petshop_product_image($product);
                $productAlt = petshop_product_alt($product);
                ?>
                <article class="product-card">
                    <div class="product-image-shell">
                        <img class="product-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productAlt); ?>">
                    </div>
                    <span class="product-badge"><?php echo htmlspecialchars($category); ?></span>
                    <h3><?php echo htmlspecialchars($productName); ?></h3>
                    <p><?php echo htmlspecialchars($productDescription); ?></p>
                    <p class="price"><?php echo htmlspecialchars($productPrice); ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else : ?>
        <section class="empty-state">
            <h3>Chua tim thay san pham</h3>
            <p>Database da ket noi, nhung bang Products chua co du lieu de hien thi.</p>
        </section>
    <?php endif; ?>
</main>
</body>
</html>
