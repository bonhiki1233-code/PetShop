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

$order_id = null;
$qr_url = null;
$thanh_cong = false;
$loi = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $shipping_address = trim($_POST['diachi']);
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'COD';

    try {
        $db->beginTransaction();

        $stmtOrder = $db->prepare("INSERT INTO `orders` (total_amount, order_status, payment_method, shipping_address, user_id) VALUES (?, 'PENDING', ?, ?, ?)");
        $stmtOrder->execute([$tong_tien, $payment_method, $shipping_address, $user_id]);

        $order_id = $db->lastInsertId();

        $stmtDetail = $db->prepare("INSERT INTO `order_details` (quantity, unit_price, order_id, product_id) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $p_id => $item) {
            $stmtDetail->execute([$item['soluong'], $item['gia'], $order_id, $p_id]);
        }

        $db->commit();
        unset($_SESSION['cart']);
        $thanh_cong = true;

        if ($payment_method === 'BANK') {
            $bank_id = "MB"; 
            $account_no = "0123456789"; 
            $template = "compact2";
            $qr_url = "https://img.vietqr.io/image/{$bank_id}-{$account_no}-{$template}.png?amount={$tong_tien}&addInfo=PetShop%20Don%20Hang%20{$order_id}";
        }

    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        $loi = "Có lỗi xảy ra: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<main class="login-page">
    <section class="login-shell login-shell-simple">
        <div class="login-card login-card-simple checkout-card">
            
            <?php if ($thanh_cong): ?>
                <div class="checkout-success" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                    <span class="login-kicker">Đặt hàng thành công</span>
                    <h2>Đơn hàng #<?= htmlspecialchars((string)$order_id) ?> đã được ghi nhận</h2>
                    
                    <?php if ($qr_url): ?>
                        <div style="margin: 25px 0; padding: 20px; border: 1px dashed #A07850; border-radius: 12px; background: #fffdf9; width: 100%; max-width: 320px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <p style="font-weight: 600; margin-bottom: 15px; color: #4A2C1A;">Thanh toán qua VietQR</p>
                            <img src="<?= $qr_url ?>" alt="VietQR" style="max-width: 250px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <p style="font-size: 0.85rem; color: #6B4E35; margin-top: 15px; text-align: center;">Nội dung: <strong>PetShop Don Hang <?= $order_id ?></strong></p>
                        </div>
                    <?php endif; ?>

                    <p style="margin-bottom: 20px;">Cảm ơn bạn đã tin tưởng PetShop. Chúng tôi sẽ sớm liên hệ xác nhận đơn hàng.</p>
                    <a href="../index.php" class="btn btn-primary login-submit">Trở về trang chủ</a>
                </div>

            <?php else: ?>
                <div class="login-card-head">
                    <span class="login-kicker">Thanh toán</span>
                    <h2>Thông tin nhận hàng</h2>
                </div>

                <?php if ($loi): ?>
                    <div class="message message-error"><?= $loi ?></div>
                <?php endif; ?>

                <div class="checkout-summary" style="display: flex; justify-content: space-between; align-items: center; background: rgba(160, 120, 80, 0.1); padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                    <span style="font-weight: 500;">Tổng cộng:</span>
                    <strong style="color: #C85A2A; font-size: 1.25rem;"><?= number_format($tong_tien) ?> VND</strong>
                </div>

                <form method="POST" class="login-form">
                    <div class="form-field">
                        <label for="nguoinhan">Người nhận</label>
                        <input id="nguoinhan" type="text" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled>
                    </div>

                    <div class="form-field">
                        <label for="diachi">Địa chỉ giao hàng</label>
                        <input id="diachi" type="text" name="diachi" placeholder="Số nhà, tên đường, quận/huyện..." required>
                    </div>

                    <div class="form-field">
                        <label style="font-weight: 600; margin-bottom: 8px; display: block;">Phương thức thanh toán</label>
                        <div style="display: grid; gap: 10px; background: #fff; border: 1px solid #eadfce; padding: 15px; border-radius: 12px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="COD" checked style="width: 18px; height: 18px;">
                                <span>Tiền mặt khi nhận hàng (COD)</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="radio" name="payment_method" value="BANK" style="width: 18px; height: 18px;">
                                <span>Chuyển khoản VietQR</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="checkout" class="btn btn-primary login-submit" style="margin-top: 10px;">Xác nhận đặt hàng</button>
                    <a href="cart.php" class="btn btn-secondary checkout-back" style="display: block; text-align: center; margin-top: 10px;">Quay lại giỏ hàng</a>
                </form>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php include "../includes/footer.php"; ?>