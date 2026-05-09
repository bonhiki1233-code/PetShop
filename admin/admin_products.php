<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../includes/product_helpers.php';

if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}

$db = (new Database())->getConnection();

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM `products` WHERE product_id = ?");
    $stmt->execute([$delete_id]);
    header('location:admin_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <title>Admin - Qu&#7843;n l&#253; s&#7843;n ph&#7849;m</title>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="admin_users.php" class="btn">Qu&#7843;n l&#253; ng&#432;&#7901;i d&#249;ng</a>
            <a href="admin_products.php" class="btn">Qu&#7843;n l&#253; s&#7843;n ph&#7849;m</a>
            <a href="admin_orders.php" class="btn">Qu&#7843;n l&#253; &#273;&#417;n h&#224;ng</a>
            <a href="../index.php" class="btn btn-secondary-admin">Tr&#7903; v&#7873;</a>
        </nav>
    </header>
    <div class="container">
        <h2>Danh s&#225;ch s&#7843;n ph&#7849;m</h2>
        <a href="add_product.php" class="btn btn-success-add">+ Th&#234;m s&#7843;n ph&#7849;m m&#7899;i</a>
        <table>
            <thead>
                <tr>
                    <th>&#7842;nh</th>
                    <th>T&#234;n s&#7843;n ph&#7849;m</th>
                    <th>Danh m&#7909;c</th>
                    <th>Gi&#225; c&#361;</th>
                    <th>Gi&#225; m&#7899;i</th>
                    <th>T&#7891;n kho</th>
                    <th>Thao t&#225;c</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_products = $db->query("SELECT p.*, c.category_name FROM `products` p LEFT JOIN `Categories` c ON c.category_id = p.category_id") or die('Query failed');
                while ($row = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars(getProductImage($row['image_url'] ?? '', '/PetShop', $row)); ?>" height="80" style="border-radius: 8px; object-fit: cover;">
                    </td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars(petshop_product_category_label($row)); ?></td>
                    <td><?php echo !is_null($row['price_old']) ? number_format($row['price_old']) . 'd' : '-'; ?></td>
                    <td><?php echo number_format($row['price_new']) . 'd'; ?></td>
                    <td><?php echo intval($row['stock_quantity']); ?></td>
                    <td>
                        <a href="edit_product.php?update=<?php echo $row['product_id']; ?>" class="btn btn-edit">S&#7917;a</a>
                        <a href="admin_products.php?delete=<?php echo $row['product_id']; ?>" class="btn btn-delete" onclick="return confirm('X&#243;a s&#7843;n ph&#7849;m n&#224;y?')">X&#243;a</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
