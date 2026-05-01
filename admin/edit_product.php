<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
 
if (!User::isLoggedIn() || !User::isAdmin()) { 
    header('Location: ../auth/login.php'); 
    exit(); 
}
 
$db = (new Database())->getConnection();
 
// Lấy thông tin sản phẩm cần sửa
if(isset($_GET['update'])){
    $update_id = $_GET['update'];
    $stmt = $db->prepare("SELECT * FROM `products` WHERE product_id = ?");
    $stmt->execute([$update_id]);
    $fetch_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$fetch_edit){
        die("Sản phẩm không tồn tại!");
    }
}
 
// Xử lý cập nhật
if(isset($_POST['update_product'])){
    $update_p_id        = $_POST['update_p_id'];
    $product_name       = trim($_POST['product_name']);
    $price_old          = !empty($_POST['price_old']) ? $_POST['price_old'] : null;
    $price_new          = $_POST['price_new'];
    $stock_quantity     = $_POST['stock_quantity'];
    $description        = trim($_POST['description']);
    $is_pet             = isset($_POST['is_pet']) ? 1 : 0;
    $category_id        = $_POST['category_id'];
 
    // Tạo slug từ tên sản phẩm
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));
 
    // Cập nhật thông tin chính
    $stmt = $db->prepare("UPDATE `products` SET 
        product_name = ?, 
        price_old = ?, 
        price_new = ?, 
        stock_quantity = ?, 
        description = ?, 
        is_pet = ?, 
        slug = ?,
        category_id = ? 
        WHERE product_id = ?");
    $stmt->execute([$product_name, $price_old, $price_new, $stock_quantity, $description, $is_pet, $slug, $category_id, $update_p_id]);
 
    // Xử lý ảnh nếu có upload mới
    if(!empty($_FILES['image']['name'])){
        $image_name     = time() . '_' . basename($_FILES['image']['name']);
        $image_tmp      = $_FILES['image']['tmp_name'];
        $image_folder   = '../uploaded_img/' . $image_name;
        $image_url      = 'uploaded_img/' . $image_name;
 
        if(move_uploaded_file($image_tmp, $image_folder)){
            $img_stmt = $db->prepare("UPDATE `products` SET image_url = ? WHERE product_id = ?");
            $img_stmt->execute([$image_url, $update_p_id]);
        }
    }
 
    header('location:admin_products.php');
    exit();
}
?>
 
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<section class="container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Cập nhật sản phẩm</h3>
 
        <!-- Ảnh hiện tại -->
        <div style="text-align: center; margin-bottom: 15px;">
            <p>Ảnh hiện tại:</p>
            <?php if(!empty($fetch_edit['image_url'])): ?>
                <img src="../<?php echo htmlspecialchars($fetch_edit['image_url']); ?>" height="150" style="border-radius: 8px; object-fit: cover;">
            <?php else: ?>
                <span>Chưa có ảnh</span>
            <?php endif; ?>
        </div>
 
        <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
 
        <label>Tên sản phẩm: <span style="color:red">*</span></label>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($fetch_edit['product_name']); ?>" class="box" required>
 
        <label>Danh mục: <span style="color:red">*</span></label>
        <select name="category_id" class="box" required>
            <option value="1" <?php if($fetch_edit['category_id'] == 1) echo 'selected'; ?>>Thú cưng</option>
            <option value="2" <?php if($fetch_edit['category_id'] == 2) echo 'selected'; ?>>Thức ăn</option>
            <option value="3" <?php if($fetch_edit['category_id'] == 3) echo 'selected'; ?>>Phụ kiện</option>
        </select>
 
        <label>Giá cũ (để trống nếu không có):</label>
        <input type="number" name="price_old" value="<?php echo $fetch_edit['price_old']; ?>" class="box" min="0" step="1000">
 
        <label>Giá mới (VND): <span style="color:red">*</span></label>
        <input type="number" name="price_new" value="<?php echo $fetch_edit['price_new']; ?>" class="box" min="0" step="1000" required>
 
        <label>Số lượng tồn kho:</label>
        <input type="number" name="stock_quantity" value="<?php echo $fetch_edit['stock_quantity']; ?>" class="box" min="0">
 
        <label>Mô tả sản phẩm:</label>
        <textarea name="description" class="box" rows="4"><?php echo htmlspecialchars($fetch_edit['description'] ?? ''); ?></textarea>
 
        <label>
            <input type="checkbox" name="is_pet" value="1" <?php if($fetch_edit['is_pet'] == 1) echo 'checked'; ?>>
            Là thú cưng
        </label>
 
        <label>Thay đổi ảnh (không chọn nếu muốn giữ nguyên):</label>
        <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box">
 
        <input type="submit" value="Lưu thay đổi" name="update_product" class="btn btn-success-add">
        <a href="admin_products.php" class="btn" style="background: gray; display:block; text-align:center; margin-top: 10px;">Hủy bỏ</a>
    </form>
</section>
</body>
</html>