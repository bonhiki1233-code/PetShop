<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$pageStylesheet = '/PetShop/assets/css/login.css';

$db = (new Database())->getConnection();
$userObj = new User($db);
$message = "";
$messageType = "error";

if (isset($_GET['error']) && $_GET['error'] == 'locked') {
    $message = "Tai khoan cua ban da bi khoa boi Quan tri vien!";
}

if (isset($_GET['success'])) {
    $message = "Dang ky thanh cong! Moi ban dang nhap.";
    $messageType = "success";
}

if (isset($_POST['login'])) {
    $user = $userObj->login($_POST['username'], $_POST['password']);

    if ($user) {
        if (isset($user['is_active']) && $user['is_active'] == 0) {
            $message = "Tai khoan nay da bi khoa. Vui long lien he Admin!";
        } else {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
            exit();
        }
    } else {
        $message = "Sai tai khoan hoac mat khau!";
    }
}

include '../includes/header.php';
?>

<main class="login-page">
    <section class="login-shell">
        <div class="login-copy">
            <span class="eyebrow">Chao mung tro lai</span>
            <h1>Dang nhap</h1>
            <p class="login-subcopy">Tiep tuc mua sam cho Boss va Sen voi tai khoan cua ban.</p>
        </div>

        <div class="login-card">
            <div class="login-card-head">
                <span class="login-kicker">Tai khoan thanh vien</span>
                <h2>Dang nhap vao PetShop</h2>
            </div>

            <?php if ($message): ?>
                <div class="message <?php echo $messageType === 'success' ? 'message-success' : 'message-error'; ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-field">
                    <label for="username">Ten dang nhap</label>
                    <input id="username" type="text" name="username" placeholder="Nhap ten dang nhap" required>
                </div>

                <div class="form-field">
                    <label for="password">Mat khau</label>
                    <input id="password" type="password" name="password" placeholder="Nhap mat khau" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary login-submit">Dang nhap</button>
            </form>

            <div class="login-register">
                <p>Chua co tai khoan?</p>
                <a href="register.php">Dang ky ngay</a>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
