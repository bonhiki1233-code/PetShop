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
            <span class="eyebrow">Bat dau cung PetShop</span>
            <h1>Tao tai khoan moi trong mot buoc.</h1>
            <p>Dang ky de luu thong tin co ban va giu giao dien mua sam cua ban lien mach giua cac trang.</p>
            <div class="auth-feature-list">
                <div class="panel">
                    <strong>Don gian</strong>
                    <span>Chi can username, email va mat khau de bat dau.</span>
                </div>
                <div class="panel">
                    <strong>Thong nhat</strong>
                    <span>Form dang ky da dong bo cung mot bo giao dien voi toan bo website.</span>
                </div>
            </div>
        </article>

        <article class="auth-card">
            <div class="form-heading">
                <h2>Tao tai khoan</h2>
                <p>Dien thong tin ben duoi de tao tai khoan khach hang moi.</p>
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

            <p class="auth-note">Da co tai khoan? <a href="/PetShop/auth/login.php"><strong>Dang nhap</strong></a></p>
        </article>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/footer.php'; ?>
</body>
</html>
