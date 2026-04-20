<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$db = (new Database())->getConnection();
$userObj = new User($db);
$message = '';
$messageClass = 'message';

if (isset($_GET['success'])) {
    $message = 'Đăng ký thành công! Mời đăng nhập';
    $messageClass = 'message message-success';
}

<<<<<<< HEAD
if (isset($_POST['login'])) {
    $user = $userObj->login($_POST['username'], $_POST['password']);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../index.php');
        exit();
=======
    if ($res && mysqli_num_rows($res) > 0) {
        $message = 'Dang nhap thanh cong!';
        $messageClass = 'message message-success';
    } else {
        $message = 'Sai tài khoản hoặc sai mật khẩu.';
        $messageClass = 'message message-error';
>>>>>>> 29d89b0 (giao dien lan 1)
    }

    $message = 'Sai tài khoản hoặc mật khẩu';
    $messageClass = 'message message-error';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | Dang nhap</title>
    <link rel="stylesheet" href="/PetShop/assets/styles.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>

<main class="container page-section">
    <section class="auth-layout">
        <article class="auth-card auth-card-accent">
<<<<<<< HEAD
            <span class="eyebrow">Chào mừng trở lại</span>
=======
            <span class="eyebrow">Chào mừng đến với Petshop</span>
>>>>>>> 29d89b0 (giao dien lan 1)
            <h1>Đăng nhập để tiếp tục mua sắm.</h1>
            <div class="auth-feature-list">
                <div class="panel">
                    <strong>Nhanh</strong>
<<<<<<< HEAD
                    <span>Đăng nhập nhanh chóng</span>
=======
>>>>>>> 29d89b0 (giao dien lan 1)
                </div>
                <div class="panel">
                    <strong>Đồng bộ</strong>
                </div>
            </div>
        </article>

        <article class="auth-card">
            <div class="form-heading">
                <h2>Đăng nhập tài khoản</h2>
<<<<<<< HEAD
                <p>Đăng nhập để mua sắm</p>
=======
                <p>Sử dụng tài khoản của bạn</p>
>>>>>>> 29d89b0 (giao dien lan 1)
            </div>

            <?php if ($message !== '') : ?>
                <div class="<?php echo htmlspecialchars($messageClass); ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" class="stack-form">
                <label class="field-group">
                    <span class="field-label">Username</span>
                    <input class="field-input" type="text" name="username" placeholder="Nhap username" required>
                </label>
                <label class="field-group">
                    <span class="field-label">Password</span>
                    <input class="field-input" type="password" name="password" placeholder="Nhap mat khau" required>
                </label>
                <button class="btn btn-primary btn-block" name="login">Đăng nhập</button>
            </form>

<<<<<<< HEAD
            <p class="auth-note">Chua co tai khoan? <a href="/PetShop/auth/register.php"><strong>Đăng ký ngay</strong></a></p>
=======
            <p class="auth-note"> Tài khoản demo: <strong>demo</strong> / mat khau: <strong>123456</strong></p>
>>>>>>> 29d89b0 (giao dien lan 1)
        </article>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/footer.php'; ?>
</body>
</html>
