<?php
require_once '../classes/Database.php';
require_once '../classes/User.php';

$db = (new Database())->getConnection();
$userObj = new User($db);
$message = '';
$messageClass = 'message';

if (isset($_POST['register'])) {
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];

    if ($userObj->register($u, $e, $p)) {
        header('Location: login.php?success=1');
        exit();
    }

    $message = 'Dang ky that bai! Username hoac Email co the da ton tai.';
    $messageClass = 'message message-error';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | Dang ky</title>
    <link rel="stylesheet" href="/PetShop/assets/styles.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>

<main class="container page-section">
    <section class="auth-layout">
        <article class="auth-card auth-card-accent">
            <span class="eyebrow">Bắt đầu cũng Petshop</span>
            <h1>Tạo tài khoản mới</h1>
            <div class="auth-feature-list">
                <div class="panel">
                    <strong>Giá</strong>
                    <span>Chỉ cần mail và mật khẩu để bắt đầu</span>
                </div>
                <div class="panel">
                    <strong>Thống nhất</strong>
                </div>
            </div>
        </article>

        <article class="auth-card">
            <div class="form-heading">
                <h2>Tạo tài khoản</h2>
                <p>Điền đầy đủ thông tin</p>
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
                    <span class="field-label">Email</span>
                    <input class="field-input" type="email" name="email" placeholder="Nhap email" required>
                </label>
                <label class="field-group">
                    <span class="field-label">Password</span>
                    <input class="field-input" type="password" name="password" placeholder="Tao mat khau" required>
                </label>
                <button class="btn btn-primary btn-block" name="register">Dang ky</button>
            </form>

<<<<<<< HEAD
            <p class="auth-note">Da co tai khoan? <a href="/PetShop/auth/login.php"><strong>Dang nhap</strong></a></p>
=======
            <p class="auth-note">Tải lại trang login</p>
>>>>>>> 29d89b0 (giao dien lan 1)
        </article>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/footer.php'; ?>
</body>
</html>
