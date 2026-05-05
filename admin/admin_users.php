<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
 
// 1. Kiểm tra quyền truy cập Admin
if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}
 
$db = (new Database())->getConnection();
 
// 2. Xử lý chức năng Xóa tài khoản[cite: 9]
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    // Ngăn chặn xóa chính mình hoặc Admin khác[cite: 9]
    $stmt = $db->prepare("DELETE FROM `users` WHERE user_id = ? AND role != 'ADMIN'");
    $stmt->execute([$delete_id]);
    header('location:admin_users.php');
    exit();
}

// 3. Xử lý chức năng Khóa/Mở khóa bằng cột is_active
if(isset($_GET['toggle_status'])){
    $user_id = $_GET['toggle_status'];
    $current_status = $_GET['current']; // Đây là giá trị của is_active hiện tại
    
    // Đảo ngược: 1 (Active) -> 0 (Inactive) và ngược lại
    $new_status = ($current_status == 1) ? 0 : 1; 

    // Cập nhật vào cột is_active[cite: 9]
    $stmt = $db->prepare("UPDATE `users` SET is_active = ? WHERE user_id = ? AND role != 'ADMIN'");
    $stmt->execute([$new_status, $user_id]);
    header('location:admin_users.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <style>
        .action-container { display: flex; flex-direction: column; gap: 8px; margin-top: 10px; }
        .status-text { font-size: 0.85rem; margin-bottom: 5px; display: block; }
        .locked { color: #e03131; font-weight: bold; }
        .active { color: #2d6a4f; font-weight: bold; }
        .container { max-width: 1100px; margin: 20px auto; }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="admin_users.php" class="btn" style="color: purple; font-weight: bold;">Quản lý Người dùng</a>
            <a href="admin_products.php" class="btn">Quản lý Sản phẩm</a>
            <a href="admin_orders.php" class="btn">Quản lý Đơn hàng</a>
            <a href="../index.php" class="btn btn-secondary-admin">Trở về</a>
        </nav>
    </header>

    <section class="container">
        <h1 class="heading">Danh sách người dùng</h1>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 30%;">Tên đăng nhập</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 30%;">Quyền hạn & Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy dữ liệu bao gồm cột is_active[cite: 9]
                $select_users = $db->query("SELECT * FROM `users` ORDER BY role ASC, user_id DESC");
                while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                    $is_active = $fetch_users['is_active']; 
                ?>
                <tr>
                    <td>#<?php echo $fetch_users['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($fetch_users['username']); ?></td>
                    <td><strong><?php echo htmlspecialchars($fetch_users['email']); ?></strong></td>
                    <td>
                        <span class="badge <?php echo ($fetch_users['role'] === 'ADMIN') ? 'badge-admin' : 'badge-user'; ?>">
                            <?php echo $fetch_users['role']; ?>
                        </span>

                        <div class="action-container">
                            <span class="status-text">
                                Trạng thái: <?php echo ($is_active == 1) ? '<span class="active">Hoạt động</span>' : '<span class="locked">Đã khóa</span>'; ?>
                            </span>

                            <?php if($fetch_users['role'] !== 'ADMIN'): ?>
                                <div style="display: flex; gap: 15px;">
                                    <!-- Nút bấm gửi giá trị is_active hiện tại qua biến current -->
                                    <a href="admin_users.php?toggle_status=<?php echo $fetch_users['user_id']; ?>&current=<?php echo $is_active; ?>" 
                                       style="color: #1976d2; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                                       <?php echo ($is_active == 1) ? '🔒 Khóa' : '🔓 Mở khóa'; ?>
                                    </a>

                                    <a href="admin_users.php?delete=<?php echo $fetch_users['user_id']; ?>" 
                                       style="color: #e03131; text-decoration: none; font-weight: bold; font-size: 0.9rem;"
                                       onclick="return confirm('Xóa vĩnh viễn người dùng này?');">
                                       🗑️ Xóa
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>