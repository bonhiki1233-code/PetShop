<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
 
if (!User::isLoggedIn() || !User::isAdmin()) { 
    header('Location: ../auth/login.php'); 
    exit(); 
}
 
$db = (new Database())->getConnection();
 
if(isset($_POST['add_product'])){
    $product_name   = trim($_POST['product_name']);
    $price_old      = !empty($_POST['price_old']) ? $_POST['price_old'] : null;
    $price_new      = $_POST['price_new'];
    $stock_quantity = $_POST['stock_quantity'];
    $description    = trim($_POST['description']);
    $is_pet         = isset($_POST['is_pet']) ? 1 : 0;
    $category_id    = $_POST['category_id'];
 
    // Tạo slug từ tên sản phẩm
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));
 
    // Xử lý ảnh
    $image_url = null;
    if(!empty($_FILES['image']['name'])){
        $image_name     = time() . '_' . basename($_FILES['image']['name']);
        $image_tmp      = $_FILES['image']['tmp_name'];
        $image_folder   = '../uploaded_img/' . $image_name;
 
        if(move_uploaded_file($image_tmp, $image_folder)){
            $image_url = 'uploaded_img/' . $image_name;
        } else {
            echo "<script>alert('Lỗi khi upload ảnh!');</script>";
        }
    }
 
    $stmt = $db->prepare("INSERT INTO `products`
        (product_name, price_old, price_new, stock_quantity, image_url, description, is_pet, slug, category_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
 
    if($stmt->execute([$product_name, $price_old, $price_new, $stock_quantity, $image_url, $description, $is_pet, $slug, $category_id])){
        echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='admin_products.php';</script>";
    } else {
        echo "<script>alert('Thêm sản phẩm thất bại!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="admin_style.css">
    <title>Thêm sản phẩm</title>
</head>
<body>
<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="" method="post" enctype="multipart/form-data">
 
        <label>Tên sản phẩm <span style="color:red">*</span></label>
        <input type="text" name="product_name" placeholder="Tên sản phẩm" required>
 
        <label>Danh mục <span style="color:red">*</span></label>
        <select name="category_id" required>
            <option value="" disabled selected>Chọn danh mục</option>
            <option value="1">Thú cưng</option>
            <option value="2">Thức ăn</option>
            <option value="3">Phụ kiện</option>
        </select>
 
        <label>Giá cũ (để trống nếu không có)</label>
        <input type="number" name="price_old" placeholder="Giá cũ" min="0" step="1000">
 
        <label>Giá mới <span style="color:red">*</span></label>
        <input type="number" name="price_new" placeholder="Giá bán" min="0" step="1000" required>
 
        <label>Số lượng tồn kho</label>
        <input type="number" name="stock_quantity" placeholder="Số lượng" min="0" value="0">
 
        <label>Mô tả sản phẩm</label>
        <textarea name="description" placeholder="Mô tả sản phẩm..." rows="4"></textarea>
 
        <label>
            <input type="checkbox" name="is_pet" value="1">
            Là thú cưng
        </label>
 
        <label>Ảnh sản phẩm</label>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
 
        <input type="submit" name="add_product" value="Lưu sản phẩm" class="btn btn-success-add">
        <a href="admin_products.php" class="btn" style="background: gray; display:block; text-align:center; margin-top:10px;">Quay lại</a>
    </form>
</div>
</body>
</html>
