<?php
include __DIR__ . '/../config/connect.php';

// CẤU HÌNH ĐƠN GIẢN ĐỂ TEST
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");

// CHO PHÉP CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    // LẤY DỮ LIỆU
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    // KIỂM TRA DỮ LIỆU
    if (!$data) {
        echo json_encode(["error" => "Không có dữ liệu"]);
        exit();
    }
    
    if (empty($data['TenLoai'])) {
        echo json_encode(["error" => "Thiếu tên loại hoa"]);
        exit();
    }
    
    $TenLoai = $data['TenLoai'];
    $MoTa = $data['MoTa'] ?? '';
    
    try {
        // THÊM VÀO DATABASE
        $stmt = $conn->prepare("INSERT INTO loaihoa (TenLoai, MoTa) VALUES (?, ?)");
        
        if ($stmt->execute([$TenLoai, $MoTa])) {
            echo json_encode([
                "success" => true,
                "message" => "Thêm thành công",
                "MaLoai" => $conn->lastInsertId()
            ]);
        } else {
            echo json_encode(["error" => "Lỗi khi thêm vào database"]);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Lỗi: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Method không hợp lệ"]);
}
?>