<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>
<?php
// 1. Kết nối database
$conn = mysqli_connect("localhost", "root", "", "petshop_db");

// 2. Lấy danh sách sản phẩm
$sql = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);

echo "<h1>DANH SÁCH SẢN PHẨM PET SHOP</h1>";

// 3. Hiển thị ra màn hình
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Tên: " . $row["product_name"] . " - Giá: " . number_format($row["price_new"]) . " VNĐ<br>";
    }
} else {
    echo "Chưa có sản phẩm nào!";
}
?>