<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}

$db = (new Database())->getConnection();

if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_status = $_POST['update_status'];
    $stmt = $db->prepare("UPDATE `orders` SET order_status = ? WHERE order_id = ?");
    $stmt->execute([$update_status, $order_id]);
}

if (isset($_GET['delete'])) {
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
    <title>Qu&#7843;n l&#253; &#273;&#417;n h&#224;ng</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
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
    <section class="container">
        <h1 class="heading">Danh s&#225;ch &#273;&#417;n h&#224;ng</h1>
        <table>
            <thead>
                <tr>
                    <th>M&#227; &#273;&#417;n</th>
                    <th>T&#234;n ng&#432;&#7901;i &#273;&#7863;t</th>
                    <th>&#272;&#7883;a ch&#7881; giao h&#224;ng</th>
                    <th>Ng&#224;y &#273;&#7863;t h&#224;ng</th>
                    <th>T&#7893;ng ti&#7873;n</th>
                    <th>Tr&#7841;ng th&#225;i</th>
                    <th>Thao t&#225;c</th>
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
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td>#<?php echo $fetch_orders['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($fetch_orders['username'] ?? 'Khong ro'); ?></td>
                    <td><?php echo htmlspecialchars($fetch_orders['shipping_address'] ?? '-'); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($fetch_orders['order_date'])); ?></td>
                    <td><?php echo number_format($fetch_orders['total_amount']); ?>d</td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($fetch_orders['order_status']); ?>">
                            <?php echo htmlspecialchars($fetch_orders['order_status']); ?>
                        </span>
                    </td>
                    <td>
                        <form action="" method="post" style="display:inline-flex; gap:5px; align-items:center;">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['order_id']; ?>">
                            <select name="update_status">
                                <option value="PENDING" <?php if ($fetch_orders['order_status'] == 'PENDING') echo 'selected'; ?>>PENDING</option>
                                <option value="SHIPPING" <?php if ($fetch_orders['order_status'] == 'SHIPPING') echo 'selected'; ?>>SHIPPING</option>
                                <option value="DELIVERED" <?php if ($fetch_orders['order_status'] == 'DELIVERED') echo 'selected'; ?>>DELIVERED</option>
                                <option value="CANCELED" <?php if ($fetch_orders['order_status'] == 'CANCELED') echo 'selected'; ?>>CANCELED</option>
                            </select>
                            <input type="submit" name="update_order" value="C&#7853;p nh&#7853;t" class="btn btn-edit">
                        </form>
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['order_id']; ?>"
                           class="btn btn-delete"
                           onclick="return confirm('X&#243;a &#273;&#417;n h&#224;ng n&#224;y?');">X&#243;a</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>
