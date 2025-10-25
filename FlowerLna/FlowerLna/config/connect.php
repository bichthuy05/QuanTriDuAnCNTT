<?php
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$username = 'root';
$password = '';  // Mặc định XAMPP để trống
$database = 'flower_shop';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ghi log kết nối thành công
    error_log("✅ Kết nối database thành công: " . $database);
    
} catch(PDOException $e) {
    error_log("❌ Lỗi kết nối database: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Kết nối database thất bại: " . $e->getMessage()]);
    exit();
}
?>