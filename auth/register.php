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
        $error = "&#272;&#259;ng k&#253; th&#7845;t b&#7841;i! Username ho&#7863;c Email c&#243; th&#7875; &#273;&#227; t&#7891;n t&#7841;i.";
    }
}

include '../includes/header.php';
?>

<main class="login-page">
    <section class="login-shell login-shell-simple">
        <div class="login-card login-card-simple">
            <div class="login-card-head">
                <span class="login-kicker">&#272;&#259;ng k&#253;</span>
                <h2>T&#7841;o t&#224;i kho&#7843;n</h2>
            </div>

            <?php if ($error): ?>
                <div class="message message-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-field">
                    <label for="username">T&#234;n &#273;&#259;ng nh&#7853;p</label>
                    <input id="username" type="text" name="username" placeholder="Nh&#7853;p t&#234;n &#273;&#259;ng nh&#7853;p" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Nh&#7853;p email" required>
                </div>

                <div class="form-field">
                    <label for="password">M&#7853;t kh&#7849;u</label>
                    <input id="password" type="password" name="password" placeholder="Nh&#7853;p m&#7853;t kh&#7849;u" required>
                </div>

                <button type="submit" name="register" class="btn btn-primary login-submit">&#272;&#259;ng k&#253; t&#224;i kho&#7843;n</button>
            </form>

            <div class="login-register">
                <p>&#272;&#227; c&#243; t&#224;i kho&#7843;n?</p>
                <a href="login.php">&#272;&#259;ng nh&#7853;p</a>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
