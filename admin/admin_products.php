<?php
 
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
 
if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}
 
$db = (new Database())->getConnection();
 
if(isset($_GET['delete'])){
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
    <link rel="stylesheet" href="admin_style.css">
    <title>Admin - Quản lý sản phẩm</title>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="admin_products.php" class="btn">Quản lý Sản phẩm</a>
            <a href="admin_orders.php" class="btn">Quản lý Đơn hàng</a>
            <a href="../index.php" class="btn btn-secondary-admin">Trở về</a>
        </nav>
    </header>
    <div class="container">
        <h2>Danh sách sản phẩm</h2>
        <a href="add_product.php" class="btn btn-success-add">+ Thêm sản phẩm mới</a>
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá cũ</th>
                    <th>Giá mới</th>
                    <th>Tồn kho</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_products = $db->query("SELECT * FROM `products`") or die('Query failed');
                while($row = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <td>
                        <?php if(!empty($row['image_url'])): ?>
                            <img src="../<?php echo htmlspecialchars($row['image_url']); ?>" width="50" height="50" style="object-fit: cover;">
                        <?php else: ?>
                            <span>Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td>
                        <?php
                            if($row['category_id'] == 1) echo 'Thú cưng';
                            elseif($row['category_id'] == 2) echo 'Thức ăn';
                            elseif($row['category_id'] == 3) echo 'Phụ kiện';
                            else echo 'Chưa phân loại';
                        ?>
                    </td>
                    <td>
                        <?php echo !is_null($row['price_old']) ? number_format($row['price_old']) . 'đ' : '-'; ?>
                    </td>
                    <td><?php echo number_format($row['price_new']); ?>đ</td>
                    <td><?php echo intval($row['stock_quantity']); ?></td>
                    <td>
                        <a href="edit_product.php?update=<?php echo $row['product_id']; ?>" class="btn btn-edit">Sửa</a>
                        <a href="admin_products.php?delete=<?php echo $row['product_id']; ?>" class="btn btn-delete" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<script>
function confirmDelete(id) {
    if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
        window.location.href = 'admin_products.php?delete=' + id;
    }
}
</script>
</body>
</html>