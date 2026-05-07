<?php
include __DIR__ . '/config/db.php';

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

function petshop_search_image(array $product): string
{
    $imageUrl = trim((string) ($product['image_url'] ?? ''));
    if ($imageUrl !== '') {
        if (preg_match('#^https?://#i', $imageUrl) || strpos($imageUrl, '/') === 0) {
            return $imageUrl;
        }

        if (strpos($imageUrl, 'assets/') === 0) {
            return '/PetShop/' . ltrim($imageUrl, '/');
        }

        return '/PetShop/assets/images/' . ltrim($imageUrl, '/');
    }

    if ((int) ($product['category_id'] ?? 0) === 2) {
        return '/PetShop/assets/images/meo_anh.jpg';
    }

    return '/PetShop/assets/images/husky.jpg';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | Tìm kiếm sản phẩm</title>
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="container page-section">
    <section class="section-heading" style="margin-bottom: 24px;">
        <div>
            <span class="eyebrow">Tìm kiếm thông minh</span>
            <h1>Tìm sản phẩm theo nhiều lớp lọc</h1>
            <p class="search-card-copy">Trang này tách riêng khỏi cấu trúc hiện tại, hỗ trợ tìm theo từ khóa, danh mục, loại, khoảng giá, tồn kho và sắp xếp.</p>
        </div>
    </section>

    <section class="search-page">
        <aside class="search-panel">
            <form class="search-form" method="get" action="<?php echo $basePath; ?>/search.php">
                <div class="search-group">
                    <label for="q">Từ khóa</label>
                    <input class="search-input" id="q" type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Tên, mô tả, slug...">
                </div>

                <div class="search-group">
                    <label for="category_id">Danh mục</label>
                    <select class="search-select" id="category_id" name="category_id">
                        <option value="0">Tất cả danh mục</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo (int) $category['category_id']; ?>" <?php echo $categoryId === (int) $category['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="search-group">
                    <label for="type">Loại sản phẩm</label>
                    <select class="search-select" id="type" name="type">
                        <option value="">Tất cả</option>
                        <option value="pet" <?php echo $typeFilter === 'pet' ? 'selected' : ''; ?>>Thú cưng</option>
                        <option value="product" <?php echo $typeFilter === 'product' ? 'selected' : ''; ?>>Vật dụng / thức ăn</option>
                    </select>
                </div>

                <div class="search-group">
                    <label>Khoảng giá</label>
                    <div class="search-range">
                        <input class="search-input" type="number" name="min_price" min="0" step="1000" value="<?php echo $minPrice !== null ? htmlspecialchars((string) $minPrice) : ''; ?>" placeholder="Từ">
                        <input class="search-input" type="number" name="max_price" min="0" step="1000" value="<?php echo $maxPrice !== null ? htmlspecialchars((string) $maxPrice) : ''; ?>" placeholder="Đến">
                    </div>
                </div>

                <div class="search-group">
                    <label for="stock">Tồn kho</label>
                    <select class="search-select" id="stock" name="stock">
                        <option value="">Tất cả</option>
                        <option value="available" <?php echo $stockFilter === 'available' ? 'selected' : ''; ?>>Còn hàng</option>
                        <option value="low" <?php echo $stockFilter === 'low' ? 'selected' : ''; ?>>Sắp hết hàng</option>
                        <option value="out" <?php echo $stockFilter === 'out' ? 'selected' : ''; ?>>Hết hàng</option>
                    </select>
                </div>

                <div class="search-group">
                    <label for="sort">Sắp xếp</label>
                    <select class="search-select" id="sort" name="sort">
                        <option value="latest" <?php echo $sort === 'latest' ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                        <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                        <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                        <option value="stock_desc" <?php echo $sort === 'stock_desc' ? 'selected' : ''; ?>>Tồn kho cao nhất</option>
                    </select>
                </div>

                <div class="search-actions">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    <a class="btn btn-secondary" href="<?php echo $basePath; ?>/search.php">Đặt lại</a>
                </div>
            </form>
        </aside>

        <div class="search-results">
            <div class="search-meta">
                <div>
                    <span class="eyebrow">Kết quả</span>
                    <h2><?php echo $resultCount; ?> sản phẩm phù hợp</h2>
                    <p>Bộ lọc được tách thành nhiều tầng rõ ràng để bạn mở rộng sau này mà không cần gộp vào các file hiện có.</p>
                </div>
            </div>

            <div class="search-badges">
                <?php if ($keyword !== '') : ?><span class="search-badge">Từ khóa: <?php echo htmlspecialchars($keyword); ?></span><?php endif; ?>
                <?php if ($categoryId > 0) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <?php if ((int) $category['category_id'] === $categoryId) : ?>
                            <span class="search-badge">Danh mục: <?php echo htmlspecialchars($category['category_name']); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($typeFilter !== '') : ?><span class="search-badge">Loại: <?php echo $typeFilter === 'pet' ? 'Thú cưng' : 'Vật dụng / thức ăn'; ?></span><?php endif; ?>
                <?php if ($minPrice !== null) : ?><span class="search-badge">Giá từ: <?php echo number_format($minPrice); ?> VND</span><?php endif; ?>
                <?php if ($maxPrice !== null) : ?><span class="search-badge">Giá đến: <?php echo number_format($maxPrice); ?> VND</span><?php endif; ?>
                <?php if ($stockFilter !== '') : ?><span class="search-badge">Tồn kho: <?php echo htmlspecialchars($stockFilter); ?></span><?php endif; ?>
            </div>

            <?php if ($resultCount === 0) : ?>
                <div class="search-empty" style="margin-top: 24px;">
                    Không tìm thấy sản phẩm phù hợp. Bạn có thể đổi từ khóa, mở rộng khoảng giá, hoặc bỏ bớt bộ lọc để thử lại.
                </div>
            <?php else : ?>
                <div class="product-grid" style="margin-top: 28px;">
                    <?php foreach ($products as $product) : ?>
                        <?php
                        $productName = $product['product_name'] ?? 'Sản phẩm';
                        $productPrice = isset($product['price_new']) ? number_format((float) $product['price_new']) . ' VND' : 'Liên hệ';
                        $productImage = petshop_search_image($product);
                        $productDescription = !empty($product['description']) ? $product['description'] : 'Thông tin chi tiết của sản phẩm sẽ được bổ sung sớm.';
                        $categoryName = $product['category_name'] ?? 'Chưa phân loại';
                        ?>
                        <article class="product-card">
                            <div class="product-image-shell">
                                <img class="product-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                            </div>
                            <span class="product-badge"><?php echo htmlspecialchars($categoryName); ?></span>
                            <h3><?php echo htmlspecialchars($productName); ?></h3>
                            <p><?php echo htmlspecialchars($productDescription); ?></p>
                            <p class="price"><?php echo htmlspecialchars($productPrice); ?></p>
                            <p class="search-card-copy">Tồn kho: <?php echo (int) ($product['stock_quantity'] ?? 0); ?> | Loại: <?php echo !empty($product['is_pet']) ? 'Thú cưng' : 'Vật dụng'; ?></p>
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
