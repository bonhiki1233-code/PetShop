<?php
$host = "localhost";
$user = "petshop_admin";
$pass = "petshop12";
$db   = "petshop_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>