<?php
include '../config/db.php';

if(isset($_POST['add_product'])){
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $insert = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')");
   if($insert){
      move_uploaded_file($image_tmp_name, $image_folder);
      echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='admin_products.php';</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="" method="post" enctype="multipart/form-data" class="admin-form">
        <input type="text" name="name" placeholder="Tên sản phẩm" required>
        <input type="number" name="price" placeholder="Giá bán" required>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required>
        <input type="submit" name="add_product" value="Lưu sản phẩm" class="btn btn-success-add">
        <a href="admin_products.php" class="btn" style="background: gray;">Quay lại</a>
    </form>
</div>
</body>s
</html>