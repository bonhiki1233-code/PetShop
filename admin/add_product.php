<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}

$db = (new Database())->getConnection();

if (isset($_POST['add_product'])) {
    $product_name = trim($_POST['product_name']);
    $price_old = !empty($_POST['price_old']) ? $_POST['price_old'] : null;
    $price_new = $_POST['price_new'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = trim($_POST['description']);
    $is_pet = isset($_POST['is_pet']) ? 1 : 0;
    $category_id = $_POST['category_id'];

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));

    $image_url = null;
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../assets/images/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_folder)) {
            $image_url = $image_name;
        } else {
            echo "<script>alert('Loi khi upload anh!');</script>";
        }
    }

    $stmt = $db->prepare("INSERT INTO `products`
        (product_name, price_old, price_new, stock_quantity, image_url, description, is_pet, slug, category_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([$product_name, $price_old, $price_new, $stock_quantity, $image_url, $description, $is_pet, $slug, $category_id])) {
        echo "<script>alert('Them san pham thanh cong!'); window.location.href='admin_products.php';</script>";
    } else {
        echo "<script>alert('Them san pham that bai!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <title>Thêm sản phẩm</title>
</head>

<body>
    <div class="container">
        <h2>Thêm sản phẩm mới</h2>
        <form action="" method="post" enctype="multipart/form-data">

            <label>Tạn sản phẩm <span style="color:red">*</span></label>
            <input type="text" name="product_name" placeholder="Ten san pham" required>

            <label>Danh mục <span style="color:red">*</span></label>
            <select name="category_id" required>
                <option value="" disabled selected>Chọn danh mục</option>
                <option value="1">Thú cưng</option>
                <option value="2">Thức ăn</option>
                <option value="3">Phụ kiện</option>
            </select>

            <label>Gi&#225; c&#361; (&#273;&#7875; tr&#7889;ng n&#7871;u kh&#244;ng c&#243;)</label>
            <input type="number" name="price_old" placeholder="Gia cu" min="0" step="1000">

            <label>Gi&#225; m&#7899;i <span style="color:red">*</span></label>
            <input type="number" name="price_new" placeholder="Gia ban" min="0" step="1000" required>

            <label>S&#7889; l&#432;&#7907;ng t&#7891;n kho</label>
            <input type="number" name="stock_quantity" placeholder="So luong" min="0" value="0">

            <label>M&#244; t&#7843; s&#7843;n ph&#7849;m</label>
            <textarea name="description" placeholder="Mo ta san pham..." rows="4"></textarea>

            <label>
                <input type="checkbox" name="is_pet" value="1">
                La thu cung
            </label>

            <label>&#7842;nh s&#7843;n ph&#7849;m</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">

            <input type="submit" name="add_product" value="Luu san pham" class="btn btn-success-add">
            <a href="admin_products.php" class="btn" style="background: gray; display:block; text-align:center; margin-top:10px;">Quay lai</a>
        </form>
    </div>
</body>

</html>