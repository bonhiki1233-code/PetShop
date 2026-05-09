<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}

$db = (new Database())->getConnection();

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM `users` WHERE user_id = ? AND role != 'ADMIN'");
    $stmt->execute([$delete_id]);
    header('location:admin_users.php');
    exit();
}

if (isset($_GET['toggle_status'])) {
    $user_id = $_GET['toggle_status'];
    $current_status = $_GET['current'];
    $new_status = ($current_status == 1) ? 0 : 1;

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
    <title>Qu&#7843;n l&#253; ng&#432;&#7901;i d&#249;ng</title>
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
            <a href="admin_users.php" class="btn" style="color: purple; font-weight: bold;">Qu&#7843;n l&#253; ng&#432;&#7901;i d&#249;ng</a>
            <a href="admin_products.php" class="btn">Qu&#7843;n l&#253; s&#7843;n ph&#7849;m</a>
            <a href="admin_orders.php" class="btn">Qu&#7843;n l&#253; &#273;&#417;n h&#224;ng</a>
            <a href="../index.php" class="btn btn-secondary-admin">Tr&#7903; v&#7873;</a>
        </nav>
    </header>

    <section class="container">
        <h1 class="heading">Danh s&#225;ch ng&#432;&#7901;i d&#249;ng</h1>

        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 30%;">T&#234;n &#273;&#259;ng nh&#7853;p</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 30%;">Quy&#7873;n h&#7841;n &amp; Tr&#7841;ng th&#225;i</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_users = $db->query("SELECT * FROM `users` ORDER BY role ASC, user_id DESC");
                while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
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
                                Tr&#7841;ng th&#225;i: <?php echo ($is_active == 1) ? '<span class="active">Hoat dong</span>' : '<span class="locked">Da khoa</span>'; ?>
                            </span>

                            <?php if ($fetch_users['role'] !== 'ADMIN'): ?>
                                <div style="display: flex; gap: 15px;">
                                    <a href="admin_users.php?toggle_status=<?php echo $fetch_users['user_id']; ?>&current=<?php echo $is_active; ?>"
                                       style="color: #1976d2; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                                       <?php echo ($is_active == 1) ? 'Khoa' : 'Mo khoa'; ?>
                                    </a>

                                    <a href="admin_users.php?delete=<?php echo $fetch_users['user_id']; ?>"
                                       style="color: #e03131; text-decoration: none; font-weight: bold; font-size: 0.9rem;"
                                       onclick="return confirm('Xoa vinh vien nguoi dung nay?');">
                                       Xoa
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
