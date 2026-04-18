<?php
include '../config/db.php'; // Đảm bảo đường dẫn đúng như trong ảnh ed9440.png

// Xử lý cập nhật trạng thái đơn hàng
if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_status = $_POST['update_status'];
   mysqli_query($conn, "UPDATE `orders` SET status = '$update_status' WHERE id = '$order_id'");
}

// Xử lý xóa đơn hàng
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'");
   header('location:admin_orders.php');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <title>Quản lý đơn hàng</title>
   <link rel="stylesheet" href="admin_style.css"> </head>
<body>
<header class="header">
   <nav class="navbar">
      <a href="admin_products.php" class="btn btn-edit">Quản lý Sản phẩm</a>
      <a href="admin_orders.php" class="btn btn-add">Quản lý Đơn hàng</a>
   </nav>
</header>
   <section class="container">
      <h1 class="heading">Đơn hàng đặt mới</h1>
      <table>
         <thead>
            <th>Tên khách</th>
            <th>SĐT</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
         </thead>
         <tbody>
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
            ?>
            <tr>
               <td><?php echo $fetch_orders['user_name']; ?></td>
               <td><?php echo $fetch_orders['number']; ?></td>
               <td><?php echo number_format($fetch_orders['total_price']); ?>đ</td>
               <td>
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <select name="update_status">
                        <option value="" selected disabled><?php echo $fetch_orders['status']; ?></option>
                        <option value="Đang xử lý">Đang xử lý</option>
                        <option value="Đã hoàn thành">Đã hoàn thành</option>
                     </select>
                     <input type="submit" name="update_order" value="Cập nhật" class="btn btn-add">
                  </form>
               </td>
               <td>
                  <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="btn btn-delete" onclick="return confirm('Xóa đơn hàng này?');">Xóa</a>
               </td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </section>
</body>
</html>