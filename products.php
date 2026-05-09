<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$base_url = petshop_base_url();
$products = [];

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
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | S&#7843;n ph&#7849;m</title>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container page-section">
        <div class="section-head">
            <div>
                <p class="eyebrow">Danh m&#7909;c s&#7843;n ph&#7849;m</p>
                <h2>T&#7845;t c&#7843; s&#7843;n ph&#7849;m</h2>
            </div>
            <a class="link-all" href="<?= $base_url ?>/search.php">T&#236;m n&#226;ng cao &rarr;</a>
        </div>

        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
                <?php
                $productName = $product['product_name'] ?? 'San pham';
                $productPrice = isset($product['price_new'])
                    ? number_format((float) $product['price_new'], 0, ',', '.') . ' VND'
                    : 'Lien he';
                $category = petshop_product_category_label($product);
                $productImage = petshop_product_image($product);
                ?>
                <article class="product-card">
                    <div class="product-image-shell">
                        <img class="product-image" src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($productName) ?>">
                    </div>
                    <span class="product-badge"><?= htmlspecialchars($category) ?></span>
                    <h3><?= htmlspecialchars($productName) ?></h3>
                    <p class="price"><?= $productPrice ?></p>

                    <form action="<?= $base_url ?>/cart/cart.php" method="POST" style="margin-top: 15px;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($productName) ?>">
                        <input type="hidden" name="price" value="<?= $product['price_new'] ?>">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Th&#234;m v&#224;o gi&#7887;</button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
