<?php
include __DIR__ . '/config/db.php';
include __DIR__ . '/includes/product_helpers.php';

$pageStylesheet = '/PetShop/assets/css/index.css';
$basePath = '/PetShop';

$keyword = trim((string) ($_GET['q'] ?? ''));
$categoryId = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;
$typeFilter = (string) ($_GET['type'] ?? '');
$minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float) $_GET['min_price'] : null;
$maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float) $_GET['max_price'] : null;
$stockFilter = (string) ($_GET['stock'] ?? '');
$sort = (string) ($_GET['sort'] ?? 'latest');

$categories = [];
$categoryResult = mysqli_query($conn, "SELECT category_id, category_name FROM Categories ORDER BY category_name ASC");
if ($categoryResult) {
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $row;
    }
}

$conditions = [];
$params = [];
$types = '';

if ($keyword !== '') {
    $conditions[] = "(p.product_name LIKE ? OR p.description LIKE ? OR p.slug LIKE ?)";
    $keywordLike = '%' . $keyword . '%';
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $params[] = $keywordLike;
    $types .= 'sss';
}

if ($categoryId > 0) {
    $conditions[] = "p.category_id = ?";
    $params[] = $categoryId;
    $types .= 'i';
}

if ($typeFilter === 'pet') {
    $conditions[] = "p.is_pet = 1";
} elseif ($typeFilter === 'product') {
    $conditions[] = "p.is_pet = 0";
}

if ($minPrice !== null) {
    $conditions[] = "p.price_new >= ?";
    $params[] = $minPrice;
    $types .= 'd';
}

if ($maxPrice !== null) {
    $conditions[] = "p.price_new <= ?";
    $params[] = $maxPrice;
    $types .= 'd';
}

if ($stockFilter === 'available') {
    $conditions[] = "p.stock_quantity > 0";
} elseif ($stockFilter === 'low') {
    $conditions[] = "p.stock_quantity BETWEEN 1 AND 5";
} elseif ($stockFilter === 'out') {
    $conditions[] = "p.stock_quantity = 0";
}

$orderBy = "p.product_id DESC";
if ($sort === 'price_asc') {
    $orderBy = "p.price_new ASC";
} elseif ($sort === 'price_desc') {
    $orderBy = "p.price_new DESC";
} elseif ($sort === 'name_asc') {
    $orderBy = "p.product_name ASC";
} elseif ($sort === 'stock_desc') {
    $orderBy = "p.stock_quantity DESC";
}

$sql = "
    SELECT
        p.*,
        c.category_name
    FROM Products p
    LEFT JOIN Categories c ON c.category_id = p.category_id
";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY " . $orderBy;

$products = [];
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
}

$resultCount = count($products);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | T&#236;m ki&#7871;m s&#7843;n ph&#7849;m</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/assets/css/search.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="container page-section">
    <section class="section-heading" style="margin-bottom: 24px;">
        <div>
            <span class="eyebrow">T&#236;m ki&#7871;m th&#244;ng minh</span>
            <h1>T&#236;m s&#7843;n ph&#7849;m theo nhi&#7873;u l&#7899;p l&#7885;c</h1>
            <p class="search-card-copy">Trang n&#224;y t&#225;ch ri&#234;ng kh&#7887;i c&#7845;u tr&#250;c hi&#7879;n t&#7841;i, h&#7895; tr&#7907; t&#236;m theo t&#7915; kh&#243;a, danh m&#7909;c, lo&#7841;i, kho&#7843;ng gi&#225;, t&#7891;n kho v&#224; s&#7855;p x&#7871;p.</p>
        </div>
    </section>

    <section class="search-page">
        <aside class="search-panel">
            <form class="search-form" method="get" action="<?php echo $basePath; ?>/search.php">
                <div class="search-group">
                    <label for="q">T&#7915; kh&#243;a</label>
                    <input class="search-input" id="q" type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="T&#234;n, m&#244; t&#7843;, slug...">
                </div>

                <div class="search-group">
                    <label for="category_id">Danh m&#7909;c</label>
                    <select class="search-select" id="category_id" name="category_id">
                        <option value="0">T&#7845;t c&#7843; danh m&#7909;c</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo (int) $category['category_id']; ?>" <?php echo $categoryId === (int) $category['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="search-group">
                    <label for="type">Lo&#7841;i s&#7843;n ph&#7849;m</label>
                    <select class="search-select" id="type" name="type">
                        <option value="">T&#7845;t c&#7843;</option>
                        <option value="pet" <?php echo $typeFilter === 'pet' ? 'selected' : ''; ?>>Th&#250; c&#432;ng</option>
                        <option value="product" <?php echo $typeFilter === 'product' ? 'selected' : ''; ?>>V&#7853;t d&#7909;ng / th&#7913;c &#259;n</option>
                    </select>
                </div>

                <div class="search-group">
                    <label>Kho&#7843;ng gi&#225;</label>
                    <div class="search-range">
                        <input class="search-input" type="number" name="min_price" min="0" step="1000" value="<?php echo $minPrice !== null ? htmlspecialchars((string) $minPrice) : ''; ?>" placeholder="T&#7915;">
                        <input class="search-input" type="number" name="max_price" min="0" step="1000" value="<?php echo $maxPrice !== null ? htmlspecialchars((string) $maxPrice) : ''; ?>" placeholder="&#272;&#7871;n">
                    </div>
                </div>

                <div class="search-group">
                    <label for="stock">T&#7891;n kho</label>
                    <select class="search-select" id="stock" name="stock">
                        <option value="">T&#7845;t c&#7843;</option>
                        <option value="available" <?php echo $stockFilter === 'available' ? 'selected' : ''; ?>>C&#242;n h&#224;ng</option>
                        <option value="low" <?php echo $stockFilter === 'low' ? 'selected' : ''; ?>>S&#7855;p h&#7871;t h&#224;ng</option>
                        <option value="out" <?php echo $stockFilter === 'out' ? 'selected' : ''; ?>>H&#7871;t h&#224;ng</option>
                    </select>
                </div>

                <div class="search-group">
                    <label for="sort">S&#7855;p x&#7871;p</label>
                    <select class="search-select" id="sort" name="sort">
                        <option value="latest" <?php echo $sort === 'latest' ? 'selected' : ''; ?>>M&#7899;i nh&#7845;t</option>
                        <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Gi&#225; t&#259;ng d&#7847;n</option>
                        <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Gi&#225; gi&#7843;m d&#7847;n</option>
                        <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>T&#234;n A-Z</option>
                        <option value="stock_desc" <?php echo $sort === 'stock_desc' ? 'selected' : ''; ?>>T&#7891;n kho cao nh&#7845;t</option>
                    </select>
                </div>

                <div class="search-actions">
                    <button class="btn btn-primary" type="submit">T&#236;m ki&#7871;m</button>
                    <a class="btn btn-secondary" href="<?php echo $basePath; ?>/search.php">&#272;&#7863;t l&#7841;i</a>
                </div>
            </form>
        </aside>

        <div class="search-results">
            <div class="search-meta">
                <div>
                    <span class="eyebrow">K&#7871;t qu&#7843;</span>
                    <h2><?php echo $resultCount; ?> s&#7843;n ph&#7849;m ph&#249; h&#7907;p</h2>
                    <p>B&#7897; l&#7885;c &#273;&#432;&#7907;c t&#225;ch th&#224;nh nhi&#7873;u t&#7847;ng r&#245; r&#224;ng &#273;&#7875; b&#7841;n m&#7903; r&#7897;ng sau n&#224;y m&#224; kh&#244;ng c&#7847;n g&#7897;p v&#224;o c&#225;c file hi&#7879;n c&#243;.</p>
                </div>
            </div>

            <div class="search-badges">
                <?php if ($keyword !== '') : ?><span class="search-badge">T&#7915; kh&#243;a: <?php echo htmlspecialchars($keyword); ?></span><?php endif; ?>
                <?php if ($categoryId > 0) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <?php if ((int) $category['category_id'] === $categoryId) : ?>
                            <span class="search-badge">Danh m&#7909;c: <?php echo htmlspecialchars($category['category_name']); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($typeFilter !== '') : ?><span class="search-badge">Lo&#7841;i: <?php echo $typeFilter === 'pet' ? 'Th&#250; c&#432;ng' : 'V&#7853;t d&#7909;ng / th&#7913;c &#259;n'; ?></span><?php endif; ?>
                <?php if ($minPrice !== null) : ?><span class="search-badge">Gi&#225; t&#7915;: <?php echo number_format($minPrice); ?> VND</span><?php endif; ?>
                <?php if ($maxPrice !== null) : ?><span class="search-badge">Gi&#225; &#273;&#7871;n: <?php echo number_format($maxPrice); ?> VND</span><?php endif; ?>
                <?php if ($stockFilter !== '') : ?><span class="search-badge">T&#7891;n kho: <?php echo htmlspecialchars($stockFilter); ?></span><?php endif; ?>
            </div>

            <?php if ($resultCount === 0) : ?>
                <div class="search-empty" style="margin-top: 24px;">
                    Kh&#244;ng t&#236;m th&#7845;y s&#7843;n ph&#7849;m ph&#249; h&#7907;p. B&#7841;n c&#243; th&#7875; &#273;&#7893;i t&#7915; kh&#243;a, m&#7903; r&#7897;ng kho&#7843;ng gi&#225;, ho&#7863;c b&#7887; b&#7899;t b&#7897; l&#7885;c &#273;&#7875; th&#7917; l&#7841;i.
                </div>
            <?php else : ?>
                <div class="product-grid" style="margin-top: 28px;">
                    <?php foreach ($products as $product) : ?>
                        <?php
                        $productName = $product['product_name'] ?? 'San pham';
                        $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' VND' : 'Lien he';
                        $productImage = petshop_product_image($product);
                        $productDescription = !empty($product['description']) ? $product['description'] : 'Thong tin chi tiet cua san pham se duoc bo sung som.';
                        $categoryName = $product['category_name'] ?? 'Chua phan loai';
                        ?>
                        <article class="product-card">
                            <div class="product-image-shell">
                                <img class="product-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                            </div>
                            <span class="product-badge"><?php echo htmlspecialchars($categoryName); ?></span>
                            <h3><?php echo htmlspecialchars($productName); ?></h3>
                            <p><?php echo htmlspecialchars($productDescription); ?></p>
                            <p class="price"><?php echo htmlspecialchars($productPrice); ?></p>
                            <p class="search-card-copy">T&#7891;n kho: <?php echo (int) ($product['stock_quantity'] ?? 0); ?> | Lo&#7841;i: <?php echo !empty($product['is_pet']) ? 'Th&#250; c&#432;ng' : 'V&#7853;t d&#7909;ng'; ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
