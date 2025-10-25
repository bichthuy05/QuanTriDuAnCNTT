<?php
$servername = "localhost";
$username = "root";             
$password = "thuy2005.";              
$database = "flower_shop";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>