<?php
session_start();

// 1. Xử lý logic Thêm sản phẩm vào giỏ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $id = $_POST['product_id'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Nếu đã có trong giỏ thì tăng số lượng, chưa có thì thêm mới
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['soluong'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'ten' => $_POST['product_name'],
            'gia' => $_POST['price'],
            'soluong' => 1
        ];
    }
    // Tránh việc người dùng F5 bị cộng dồn lại
    header("Location: cart.php");
    exit;
}

// 2. Xử lý Xóa sản phẩm khỏi giỏ
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}

// 3. Hiển thị giao diện
include "../includes/header.php"; // Sửa lại đường dẫn đúng
$total = 0;
?>

<main class="container page-section">
    <div class="panel">
        <h2>Giỏ hàng của bạn</h2>
        
        <?php if(empty($_SESSION['cart'])): ?>
            <div class="empty-state">
                <p>Giỏ hàng đang trống!</p>
                <a href="../products.php" class="btn btn-primary" style="margin-top:15px;">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <table style="width:100%; margin-top:20px; border-collapse: collapse;">
                <tr style="border-bottom: 2px solid var(--line); text-align: left;">
                    <th style="padding: 10px;">Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Thao tác</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $id => $item): 
                    $subtotal = $item['gia'] * $item['soluong'];
                    $total += $subtotal;
                ?>
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 15px 10px;"><strong><?= htmlspecialchars($item['ten']) ?></strong></td>
                    <td><?= number_format($item['gia']) ?> ₫</td>
                    <td><?= $item['soluong'] ?></td>
                    <td style="color: var(--brand); font-weight: bold;"><?= number_format($subtotal) ?> ₫</td>
                    <td><a href="cart.php?remove=<?= $id ?>" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem;">Xóa</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            <div style="text-align: right; margin-top: 20px;">
                <h3 style="font-size: 1.5rem;">Tổng cộng: <span style="color: var(--brand);"><?= number_format($total) ?> ₫</span></h3>
                <a href="checkout.php" class="btn btn-primary" style="margin-top: 15px;">Tiến hành thanh toán</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include "../includes/footer.php"; ?>