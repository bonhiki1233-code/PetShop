<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../includes/product_helpers.php';

if (!User::isLoggedIn() || !User::isAdmin()) {
    header('Location: ../auth/login.php');
    exit();
}

$db = (new Database())->getConnection();

if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $stmt = $db->prepare("SELECT * FROM `products` WHERE product_id = ?");
    $stmt->execute([$update_id]);
    $fetch_edit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fetch_edit) {
        die("San pham khong ton tai!");
    }
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $product_name = trim($_POST['product_name']);
    $price_old = !empty($_POST['price_old']) ? $_POST['price_old'] : null;
    $price_new = $_POST['price_new'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = trim($_POST['description']);
    $is_pet = isset($_POST['is_pet']) ? 1 : 0;
    $category_id = $_POST['category_id'];

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));

    $stmt = $db->prepare("UPDATE `products` SET product_name = ?, price_old = ?, price_new = ?, stock_quantity = ?, description = ?, is_pet = ?, slug = ?, category_id = ? WHERE product_id = ?");
    $stmt->execute([$product_name, $price_old, $price_new, $stock_quantity, $description, $is_pet, $slug, $category_id, $update_p_id]);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../assets/images/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_folder)) {
            $img_stmt = $db->prepare("UPDATE `products` SET image_url = ? WHERE product_id = ?");
            $img_stmt->execute([$image_name, $update_p_id]);
        } else {
            echo "<script>alert('Khong the luu file anh!');</script>";
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
    <title>S&#7917;a s&#7843;n ph&#7849;m</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
<section class="container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>C&#7853;p nh&#7853;t s&#7843;n ph&#7849;m</h3>

        <div style="text-align: center; margin-bottom: 15px;">
            <p>&#7842;nh hi&#7879;n t&#7841;i:</p>
            <img src="<?php echo htmlspecialchars(getProductImage($fetch_edit['image_url'] ?? '', '/PetShop', $fetch_edit)); ?>" height="150" style="border-radius: 8px; object-fit: cover;">
        </div>

        <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">

        <label>T&#234;n s&#7843;n ph&#7849;m: <span style="color:red">*</span></label>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($fetch_edit['product_name']); ?>" class="box" required>

        <label>Danh m&#7909;c: <span style="color:red">*</span></label>
        <select name="category_id" class="box" required>
            <option value="1" <?php if ($fetch_edit['category_id'] == 1) echo 'selected'; ?>>Thu cung</option>
            <option value="2" <?php if ($fetch_edit['category_id'] == 2) echo 'selected'; ?>>Thuc an</option>
            <option value="3" <?php if ($fetch_edit['category_id'] == 3) echo 'selected'; ?>>Phu kien</option>
        </select>

        <label>Gi&#225; c&#361;:</label>
        <input type="number" name="price_old" value="<?php echo $fetch_edit['price_old']; ?>" class="box" min="0" step="1000">

        <label>Gi&#225; m&#7899;i (VND): <span style="color:red">*</span></label>
        <input type="number" name="price_new" value="<?php echo $fetch_edit['price_new']; ?>" class="box" min="0" step="1000" required>

        <label>S&#7889; l&#432;&#7907;ng t&#7891;n kho:</label>
        <input type="number" name="stock_quantity" value="<?php echo $fetch_edit['stock_quantity']; ?>" class="box" min="0">

        <label>M&#244; t&#7843; s&#7843;n ph&#7849;m:</label>
        <textarea name="description" class="box" rows="4"><?php echo htmlspecialchars($fetch_edit['description'] ?? ''); ?></textarea>

        <label>
            <input type="checkbox" name="is_pet" value="1" <?php if ($fetch_edit['is_pet'] == 1) echo 'checked'; ?>>
            La thu cung
        </label>

        <label>Thay &#273;&#7893;i &#7843;nh:</label>
        <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box">

        <input type="submit" value="Luu thay doi" name="update_product" class="btn btn-success-add">
        <a href="admin_products.php" class="btn" style="background: gray; display:block; text-align:center; margin-top: 10px;">Huy bo</a>
    </form>
</section>
</body>
</html>
