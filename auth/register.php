<?php
require_once '../classes/Database.php';
require_once '../classes/User.php';

$pageStylesheet = '/PetShop/assets/css/login.css';

$db = (new Database())->getConnection();
$userObj = new User($db);
$error = "";

if (isset($_POST['register'])) {
    $u = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $e = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $p = $_POST['password'];

    if ($userObj->register($u, $e, $p)) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error = "Dang ky that bai! Username hoac Email co the da ton tai.";
    }
}

include '../includes/header.php';
?>

<main class="login-page">
    <section class="login-shell login-shell-simple">
        <div class="login-card login-card-simple">
            <div class="login-card-head">
                <span class="login-kicker">Dang ky</span>
                <h2>Tao tai khoan</h2>
            </div>

            <?php if ($error): ?>
                <div class="message message-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-field">
                    <label for="username">Ten dang nhap</label>
                    <input id="username" type="text" name="username" placeholder="Nhap ten dang nhap" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Nhap email" required>
                </div>

                <div class="form-field">
                    <label for="password">Mat khau</label>
                    <input id="password" type="password" name="password" placeholder="Nhap mat khau" required>
                </div>

                <button type="submit" name="register" class="btn btn-primary login-submit">Dang ky tai khoan</button>
            </form>

            <div class="login-register">
                <p>Da co tai khoan?</p>
                <a href="login.php">Dang nhap</a>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
