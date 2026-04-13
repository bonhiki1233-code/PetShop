<?php include $_SERVER['DOCUMENT_ROOT'] . '/PetShop/includes/header.php'; ?>
<?php
include '../config/db.php';
if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];
    $sql = "SELECT * FROM Users WHERE username='$u' AND password='$p'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0){
        echo "Đăng nhập thành công!";
    } else {
        echo "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<form method="POST">
    User: <input type="text" name="username"><br>
    Pass: <input type="password" name="password"><br>
    <button name="login">Đăng nhập</button>
</form>