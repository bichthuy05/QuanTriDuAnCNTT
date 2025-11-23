<?php
include __DIR__ . '/../config/connect.php';

// Cấu hình báo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Ghi log debug
error_log("=== API loaihoa.php được gọi ===");
error_log("Method: " . $_SERVER['REQUEST_METHOD']);

// Cho phép CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Lấy danh sách loại hoa hoặc 1 loại hoa cụ thể
        if(isset($_GET['MaLoai'])) {
            $MaLoai = $_GET['MaLoai'];
            $stmt = $conn->prepare("SELECT * FROM loaihoa WHERE MaLoai = ?");
            $stmt->execute([$MaLoai]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->query("SELECT * FROM loaihoa ORDER BY MaLoai DESC");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($result);
        break;

    case 'POST':
        // Thêm loại hoa mới
        $input = file_get_contents("php://input");
        error_log("Raw POST data: " . $input);
        
        $data = json_decode($input, true);
        
        if (!$data || json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["error" => "Dữ liệu JSON không hợp lệ"]);
            exit();
        }
        
        // Kiểm tra dữ liệu bắt buộc
        if (empty($data['TenLoai'])) {
            http_response_code(400);
            echo json_encode(["error" => "Tên loại hoa là bắt buộc"]);
            exit();
        }
        
        $TenLoai = trim($data['TenLoai']);
        $MoTa = isset($data['MoTa']) ? trim($data['MoTa']) : '';
        
        try {
            // Kiểm tra trùng tên loại hoa
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM loaihoa WHERE TenLoai = ?");
            $checkStmt->execute([$TenLoai]);
            $exists = $checkStmt->fetchColumn();
            
            if ($exists > 0) {
                http_response_code(400);
                echo json_encode(["error" => "Tên loại hoa đã tồn tại"]);
                exit();
            }
            
            // Thêm mới loại hoa
            $stmt = $conn->prepare("INSERT INTO loaihoa (TenLoai, MoTa) VALUES (?, ?)");
            
            if($stmt->execute([$TenLoai, $MoTa])) {
                $newId = $conn->lastInsertId();
                error_log("Thêm loại hoa thành công - ID: " . $newId);
                echo json_encode([
                    "success" => "Thêm loại hoa thành công", 
                    "MaLoai" => $newId
                ]);
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Lỗi execute: " . print_r($errorInfo, true));
                http_response_code(400);
                echo json_encode(["error" => "Thêm loại hoa thất bại"]);
            }
        } catch (PDOException $e) {
            error_log("Lỗi PDO: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Lỗi database: " . $e->getMessage()]);
        }
        break;

    case 'PUT':
        // Cập nhật loại hoa
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "Dữ liệu JSON không hợp lệ"]);
            exit();
        }
        
        if (empty($data['MaLoai']) || empty($data['TenLoai'])) {
            http_response_code(400);
            echo json_encode(["error" => "Thiếu thông tin bắt buộc"]);
            exit();
        }
        
        $MaLoai = $data['MaLoai'];
        $TenLoai = $data['TenLoai'];
        $MoTa = $data['MoTa'] ?? '';
        
        try {
            $stmt = $conn->prepare("UPDATE loaihoa SET TenLoai = ?, MoTa = ? WHERE MaLoai = ?");
            if($stmt->execute([$TenLoai, $MoTa, $MaLoai])) {
                echo json_encode(["success" => "Cập nhật loại hoa thành công"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Cập nhật loại hoa thất bại"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi database: " . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        // Xóa loại hoa
        if(!isset($_GET['MaLoai'])) {
            http_response_code(400);
            echo json_encode(["error" => "Thiếu MaLoai"]);
            exit();
        }
        
        $MaLoai = $_GET['MaLoai'];
        
        try {
            // Kiểm tra xem loại hoa có đang được sử dụng không
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM hoa WHERE MaLoai = ?");
            $checkStmt->execute([$MaLoai]);
            $count = $checkStmt->fetchColumn();
            
            if($count > 0) {
                http_response_code(400);
                echo json_encode(["error" => "Không thể xóa loại hoa vì có hoa thuộc loại này"]);
            } else {
                $stmt = $conn->prepare("DELETE FROM loaihoa WHERE MaLoai = ?");
                if($stmt->execute([$MaLoai])) {
                    echo json_encode(["success" => "Xóa loại hoa thành công"]);
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "Xóa loại hoa thất bại"]);
                }
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi database: " . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method không được hỗ trợ"]);
        break;
}
?>