<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>
<?php
include '../config/db.php'; 

if(isset($_POST['register'])){
    $u = $_POST['username'];
    $e = $_POST['email'];
    $p = $_POST['password'];

    // Lệnh SQL phải viết trên một dòng hoặc nối chuỗi cẩn thận
    $sql = "INSERT INTO Users (username, email, password, role) VALUES ('$u', '$e', '$p', 'CUSTOMER')";
    
    if(mysqli_query($conn, $sql)){
        echo "Đăng ký thành công!";
    } else {
        echo "Lỗi kết nối database: " . mysqli_error($conn);
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="User" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Pass" required><br>
    <button name="register">Đăng ký</button>
</form>