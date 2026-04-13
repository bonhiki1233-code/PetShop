<?php
$conn = mysqli_connect("localhost", "root", "", "petshop_db");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>