<?php
require_once '../classes/Database.php';
require_once '../classes/User.php';

$db = (new Database())->getConnection();
$userObj = new User($db);
$error = "";

if (isset($_POST['register'])) {
    //$u = $_POST['username'];
    $u = filter_input(INPUT_POST, "username",
                    FILTER_SANITIZE_SPECIAL_CHARS);    

    //$e = $_POST['email'];
    $e = filter_input(INPUT_POST, "email",
                    FILTER_SANITIZE_EMAIL);     
    $p = $_POST['password'];

    if ($userObj->register($u, $e, $p)) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error = "Đăng ký thất bại! Username hoặc Email có thể đã tồn tại.";
    }
}

include '../includes/header.php';
?>

<main class="auth-wrapper">
    <div class="auth-card">
        <span class="eyebrow">Đăng ký</span>
        <h1>Tạo tài khoản</h1>
        <p>Tham gia cộng đồng yêu thú cưng ngay hôm nay.</p>

        <?php if($error): ?>
            <div class="message" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">
                <?=  $error ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit" name="register" class="btn btn-primary">Đăng ký tài khoản</button>
        </form>

        <div style="margin-top: 24px; text-align: center;">
            <p>Đã có tài khoản? <a href="login.php" style="color: var(--brand); font-weight: 700;">Đăng nhập</a></p>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>