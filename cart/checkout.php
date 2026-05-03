<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

// Yêu cầu đăng nhập mới được mua hàng
if (!User::isLoggedIn()) {
    header("Location: ../auth/login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$db = (new Database())->getConnection();

// Xử lý khi người dùng nhấn nút Xác nhận thanh toán
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $shipping_address = trim($_POST['diachi']);
    
    // Tính tổng tiền
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['gia'] * $item['soluong'];
    }

    try {
        // Bắt đầu Transaction để đảm bảo an toàn dữ liệu
        $db->beginTransaction();

        // 1. Lưu vào bảng Orders
        $stmtOrder = $db->prepare("INSERT INTO `orders` (total_amount, order_status, shipping_address, user_id) VALUES (?, 'PENDING', ?, ?)");
        $stmtOrder->execute([$total_amount, $shipping_address, $user_id]);
        
        // Lấy mã đơn hàng vừa được tạo tự động
        $order_id = $db->lastInsertId();

        // 2. Lưu từng sản phẩm vào bảng Order_Details
        $stmtDetail = $db->prepare("INSERT INTO `order_details` (quantity, unit_price, order_id, product_id) VALUES (?, ?, ?, ?)");
        
        foreach ($_SESSION['cart'] as $p_id => $item) {
            $stmtDetail->execute([$item['soluong'], $item['gia'], $order_id, $p_id]);
        }

        // Cam kết lưu dữ liệu vĩnh viễn
        $db->commit();

        // Xóa giỏ hàng và báo thành công
        unset($_SESSION['cart']);
        $thanh_cong = true;

    } catch (Exception $e) {
        // Hủy bỏ toàn bộ nếu có lỗi
        $db->rollBack();
        $loi = "Có lỗi xảy ra trong quá trình đặt hàng: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<main class="container page-section">
    <div class="auth-wrapper" style="max-width: 600px;">
        <div class="auth-card">
            <?php if (isset($thanh_cong)): ?>
                <div style="text-align: center;">
                    <h2 style="color: var(--brand);">🎉 Đặt hàng thành công!</h2>
                    <p style="margin: 15px 0;">Cảm ơn bạn đã mua sắm tại PetShop. Đơn hàng của bạn đang được chờ xử lý.</p>
                    <a href="../index.php" class="btn btn-primary">Trở về Trang chủ</a>
                </div>
            <?php else: ?>
                <span class="eyebrow">Thanh toán</span>
                <h2>Thông tin nhận hàng</h2>
                
                <?php if (isset($loi)): ?>
                    <div class="message" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;"><?= $loi ?></div>
                <?php endif; ?>

                <form method="POST" style="margin-top: 20px;">
                    <label style="font-weight: bold; margin-bottom: 5px; display:block;">Người nhận (Tên tài khoản):</label>
                    <input type="text" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled style="background:#eee;">
                    
                    <label style="font-weight: bold; margin-top:15px; margin-bottom: 5px; display:block;">Địa chỉ giao hàng đầy đủ:</label>
                    <input type="text" name="diachi" placeholder="Số nhà, đường, quận/huyện, thành phố..." required>
                    
                    <button type="submit" name="checkout" class="btn btn-primary" style="margin-top: 20px;">Xác nhận đặt hàng</button>
                    <a href="cart.php" class="btn btn-secondary" style="margin-top: 10px; text-align: center; display: block;">Quay lại Giỏ hàng</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>