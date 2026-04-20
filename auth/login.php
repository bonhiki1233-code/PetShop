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

if (isset($_POST['login'])) {
    $user = $userObj->login($_POST['username'], $_POST['password']);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../index.php');
        exit();
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
            <span class="eyebrow">Chào mừng trở lại</span>
            <h1>Đăng nhập để tiếp tục mua sắm.</h1>
            <div class="auth-feature-list">
                <div class="panel">
                    <strong>Nhanh</strong>
                    <span>Đăng nhập nhanh chóng</span>
                </div>
                <div class="panel">
                    <strong>Đồng bộ</strong>
                </div>
            </div>
        </article>

        <article class="auth-card">
            <div class="form-heading">
                <h2>Đăng nhập tài khoản</h2>
                <p>Đăng nhập để mua sắm</p>
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

            <p class="auth-note">Chua co tai khoan? <a href="/PetShop/auth/register.php"><strong>Đăng ký ngay</strong></a></p>
        </article>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/footer.php'; ?>
</body>
</html>
