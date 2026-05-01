<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
 
if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}
 
$db = (new Database())->getConnection();
 
if(isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $update_status = $_POST['update_status'];
    $stmt = $db->prepare("UPDATE `orders` SET order_status = ? WHERE order_id = ?");
    $stmt->execute([$update_status, $order_id]);
}
 
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM `orders` WHERE order_id = ?");
    $stmt->execute([$delete_id]);
    header('location:admin_orders.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="admin_products.php" class="btn">Quản lý Sản phẩm</a>
            <a href="admin_orders.php" class="btn">Quản lý Đơn hàng</a>
            <a href="../index.php" class="btn btn-secondary-admin">Trở về</a>
        </nav>
    </header>
    <section class="container">
        <h1 class="heading">Danh sách đơn hàng</h1>
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Tên người đặt</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_orders = $db->query("
                    SELECT o.*, u.username 
                    FROM `orders` o
                    LEFT JOIN `users` u ON o.user_id = u.user_id
                    ORDER BY o.order_date DESC
                ");
                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <td>#<?php echo $fetch_orders['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($fetch_orders['username'] ?? 'Không rõ'); ?></td>
                    <td><?php echo htmlspecialchars($fetch_orders['shipping_address'] ?? '-'); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($fetch_orders['order_date'])); ?></td>
                    <td><?php echo number_format($fetch_orders['total_amount']); ?>đ</td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($fetch_orders['order_status']); ?>">
                            <?php echo htmlspecialchars($fetch_orders['order_status']); ?>
                        </span>
                    </td>
                    <td>
                        <form action="" method="post" style="display:inline-flex; gap:5px; align-items:center;">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['order_id']; ?>">
                            <select name="update_status">
                                <option value="PENDING"   <?php if($fetch_orders['order_status'] == 'PENDING')   echo 'selected'; ?>>PENDING</option>
                                <option value="SHIPPING"  <?php if($fetch_orders['order_status'] == 'SHIPPING')  echo 'selected'; ?>>SHIPPING</option>
                                <option value="DELIVERED" <?php if($fetch_orders['order_status'] == 'DELIVERED') echo 'selected'; ?>>DELIVERED</option>
                                <option value="CANCELED"  <?php if($fetch_orders['order_status'] == 'CANCELED')  echo 'selected'; ?>>CANCELED</option>
                            </select>
                            <input type="submit" name="update_order" value="Cập nhật" class="btn btn-edit">
                        </form>
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['order_id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Xóa đơn hàng này?');">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>
