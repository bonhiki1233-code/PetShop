<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$db = (new Database())->getConnection();
$userObj = new User($db);
$message = "";

if (isset($_GET['error']) && $_GET['error'] == 'locked') {
    $message = "Tài khoản của bạn đã bị khóa bởi Quản trị viên!";
}

if (isset($_GET['success'])) $message = "Đăng ký thành công! Mời bạn đăng nhập.";

if (isset($_POST['login'])) {
    $user = $userObj->login($_POST['username'], $_POST['password']);
    
    if ($user) {
        if (isset($user['is_active']) && $user['is_active'] == 0) {
            $message = "Tài khoản này đã bị khóa. Vui lòng liên hệ Admin!";
        } else {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../index.php");
        exit();
        }
    } else {
        $message = "Sai tài khoản hoặc mật khẩu!";
    }
}

include '../includes/header.php';
?>

<main class="auth-wrapper">
    <div class="auth-card">
        <span class="eyebrow">Chào mừng trở lại</span>
        <h1>Đăng nhập</h1>
        
        <?php if($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>
        </form>

        <div style="margin-top: 24px; text-align: center;">
            <p>Chưa có tài khoản? <a href="register.php" style="color: var(--brand); font-weight: 700;">Đăng ký ngay</a></p>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>