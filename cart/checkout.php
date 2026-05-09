<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$pageStylesheet = '/PetShop/assets/css/login.css';

if (!User::isLoggedIn()) {
    header("Location: ../auth/login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$db = (new Database())->getConnection();
$tong_tien = 0;
foreach ($_SESSION['cart'] as $item) {
    $tong_tien += $item['gia'] * $item['soluong'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $shipping_address = trim($_POST['diachi']);

    try {
        $db->beginTransaction();

        $stmtOrder = $db->prepare("INSERT INTO `orders` (total_amount, order_status, shipping_address, user_id) VALUES (?, 'PENDING', ?, ?)");
        $stmtOrder->execute([$tong_tien, $shipping_address, $user_id]);

        $order_id = $db->lastInsertId();

        $stmtDetail = $db->prepare("INSERT INTO `order_details` (quantity, unit_price, order_id, product_id) VALUES (?, ?, ?, ?)");

        foreach ($_SESSION['cart'] as $p_id => $item) {
            $stmtDetail->execute([$item['soluong'], $item['gia'], $order_id, $p_id]);
        }

        $db->commit();

        unset($_SESSION['cart']);
        $thanh_cong = true;
    } catch (Exception $e) {
        $db->rollBack();
        $loi = "C&#243; l&#7895;i x&#7843;y ra trong qu&#225; tr&#236;nh &#273;&#7863;t h&#224;ng: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<main class="login-page">
    <section class="login-shell login-shell-simple">
        <div class="login-card login-card-simple checkout-card">
            <?php if (isset($thanh_cong)): ?>
                <div class="checkout-success">
                    <span class="login-kicker">&#272;&#7863;t h&#224;ng th&#224;nh c&#244;ng</span>
                    <h2>&#272;&#417;n h&#224;ng &#273;&#227; &#273;&#432;&#7907;c ghi nh&#7853;n</h2>
                    <p>C&#7843;m &#417;n b&#7841;n &#273;&#227; mua s&#7855;m t&#7841;i PetShop. Ch&#250;ng t&#244;i s&#7869; x&#7917; l&#253; &#273;&#417;n h&#224;ng c&#7911;a b&#7841;n s&#7899;m nh&#7845;t c&#243; th&#7875;.</p>
                    <a href="../index.php" class="btn btn-primary login-submit">Tr&#7903; v&#7873; trang ch&#7911;</a>
                </div>
            <?php else: ?>
                <div class="login-card-head">
                    <span class="login-kicker">Thanh to&#225;n</span>
                    <h2>Th&#244;ng tin nh&#7853;n h&#224;ng</h2>
                </div>

                <?php if (isset($loi)): ?>
                    <div class="message message-error"><?= $loi ?></div>
                <?php endif; ?>

                <div class="checkout-summary">
                    <span>T&#7893;ng thanh to&#225;n</span>
                    <strong><?= number_format($tong_tien) ?> VND</strong>
                </div>

                <form method="POST" class="login-form">
                    <div class="form-field">
                        <label for="nguoinhan">Ng&#432;&#7901;i nh&#7853;n</label>
                        <input id="nguoinhan" type="text" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled>
                    </div>

                    <div class="form-field">
                        <label for="diachi">&#272;&#7883;a ch&#7881; giao h&#224;ng</label>
                        <input id="diachi" type="text" name="diachi" placeholder="S&#7889; nh&#224;, &#273;&#432;&#7901;ng, qu&#7853;n/huy&#7879;n, th&#224;nh ph&#7889;..." required>
                    </div>

                    <div class="form-field">
                        <label style="font-weight: bold; margin-bottom: 10px; display: block;">Phương thức thanh toán</label>
                        <div style="display: flex; flex-direction: column; gap: 12px; background: rgba(0,0,0,0.05); padding: 15px; border-radius: 8px;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="COD" checked>
                                <span>Thanh toán khi nhận hàng (COD)</span>
                            </label>
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="BANK">
                                <span>Chuyển khoản ngân hàng (VietQR)</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="checkout" class="btn btn-primary login-submit">X&#225;c nh&#7853;n &#273;&#7863;t h&#224;ng</button>
                    <a href="cart.php" class="btn btn-secondary checkout-back">Quay l&#7841;i gi&#7887; h&#224;ng</a>
                </form>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include "../includes/footer.php"; ?>