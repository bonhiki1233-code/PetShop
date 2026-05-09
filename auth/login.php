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
    $message = "T&#224;i kho&#7843;n c&#7911;a b&#7841;n &#273;&#227; b&#7883; kh&#243;a b&#7903;i Qu&#7843;n tr&#7883; vi&#234;n!";
}

if (isset($_GET['success'])) {
    $message = "&#272;&#259;ng k&#253; th&#224;nh c&#244;ng! M&#7901;i b&#7841;n &#273;&#259;ng nh&#7853;p.";
    $messageType = "success";
}

if (isset($_POST['login'])) {
    $user = $userObj->login($_POST['username'], $_POST['password']);

    if ($user) {
        if (isset($user['is_active']) && $user['is_active'] == 0) {
            $message = "T&#224;i kho&#7843;n n&#224;y &#273;&#227; b&#7883; kh&#243;a. Vui l&#242;ng li&#234;n h&#7879; Admin!";
        } else {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
            exit();
        }
    } else {
        $message = "Sai t&#224;i kho&#7843;n ho&#7863;c m&#7853;t kh&#7849;u!";
    }
}

include '../includes/header.php';
?>

<main class="login-page">
    <section class="login-shell">
        <div class="login-copy">
            <span class="eyebrow">Ch&#224;o m&#7915;ng tr&#7903; l&#7841;i</span>
            <h1>&#272;&#259;ng nh&#7853;p</h1>
            <p class="login-subcopy">Ti&#7871;p t&#7909;c mua s&#7855;m cho Boss v&#224; Sen v&#7899;i t&#224;i kho&#7843;n c&#7911;a b&#7841;n.</p>

            <ul class="login-highlights">
                <li>Mua s&#7855;m nhanh h&#417;n v&#7899;i th&#244;ng tin &#273;&#227; l&#432;u</li>
                <li>Theo d&#245;i &#273;&#417;n h&#224;ng v&#224; tr&#7841;ng th&#225;i giao h&#224;ng</li>
                <li>Nh&#7853;n &#432;u &#273;&#227;i d&#224;nh ri&#234;ng cho th&#224;nh vi&#234;n</li>
            </ul>
        </div>

        <div class="login-card">
            <div class="login-card-head">
                <span class="login-kicker">T&#224;i kho&#7843;n th&#224;nh vi&#234;n</span>
                <h2>&#272;&#259;ng nh&#7853;p v&#224;o PetShop</h2>
            </div>

            <?php if ($message): ?>
                <div class="message <?php echo $messageType === 'success' ? 'message-success' : 'message-error'; ?>"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-field">
                    <label for="username">T&#234;n &#273;&#259;ng nh&#7853;p</label>
                    <input id="username" type="text" name="username" placeholder="Nh&#7853;p t&#234;n &#273;&#259;ng nh&#7853;p" required>
                </div>

                <div class="form-field">
                    <label for="password">M&#7853;t kh&#7849;u</label>
                    <input id="password" type="password" name="password" placeholder="Nh&#7853;p m&#7853;t kh&#7849;u" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary login-submit">&#272;&#259;ng nh&#7853;p</button>
            </form>

            <div class="login-register">
                <p>Ch&#432;a c&#243; t&#224;i kho&#7843;n?</p>
                <a href="register.php">&#272;&#259;ng k&#253; ngay</a>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
