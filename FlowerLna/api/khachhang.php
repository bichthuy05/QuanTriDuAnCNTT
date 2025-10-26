<?php
// api/khachhang.php

// Cấu hình CORS và header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// KẾT NỐI DATABASE - SỬA ĐƯỜNG DẪN NÀY
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'flower_shop';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Kết nối database thất bại: " . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Lấy danh sách khách hàng
        if(isset($_GET['MaKhachHang'])) {
            // Lấy chi tiết 1 khách hàng
            $id = $_GET['MaKhachHang'];
            $stmt = $conn->prepare("SELECT * FROM khachhang WHERE MaKhachHang = ?");
            $stmt->execute([$id]);
            $khachhang = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($khachhang);
        } else {
            // Lấy danh sách + tìm kiếm
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            if (!empty($search)) {
                $sql = "SELECT * FROM khachhang 
                        WHERE TenKhachHang LIKE ? OR SoDienThoai LIKE ? OR Email LIKE ? 
                        ORDER BY MaKhachHang DESC";
                $stmt = $conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            } else {
                $sql = "SELECT * FROM khachhang ORDER BY MaKhachHang DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }
            $khachhang_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($khachhang_list);
        }
        break;
        
    case 'POST':
        // Thêm khách hàng mới
        $input = file_get_contents("php://input");
        error_log("Raw POST data: " . $input);
        
        $data = json_decode($input, true);
        
        if (!$data || json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Dữ liệu JSON không hợp lệ"]);
            exit();
        }
        
        if (empty($data['TenKhachHang']) || empty($data['SoDienThoai'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Tên khách hàng và số điện thoại là bắt buộc"]);
            exit();
        }
        
        $TenKhachHang = trim($data['TenKhachHang']);
        $SoDienThoai = trim($data['SoDienThoai']);
        $Email = isset($data['Email']) ? trim($data['Email']) : '';
        $DiaChi = isset($data['DiaChi']) ? trim($data['DiaChi']) : '';
        
        try {
            // Kiểm tra trùng số điện thoại
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM khachhang WHERE SoDienThoai = ?");
            $checkStmt->execute([$SoDienThoai]);
            $exists = $checkStmt->fetchColumn();
            
            if ($exists > 0) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Số điện thoại đã tồn tại"]);
                exit();
            }
            
            $stmt = $conn->prepare("INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi) VALUES (?, ?, ?, ?)");
            
            if($stmt->execute([$TenKhachHang, $SoDienThoai, $Email, $DiaChi])) {
                $newId = $conn->lastInsertId();
                error_log("Thêm khách hàng thành công - ID: " . $newId);
                
                echo json_encode([
                    "success" => true, 
                    "message" => "Thêm khách hàng thành công", 
                    "MaKhachHang" => $newId
                ]);
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Lỗi execute: " . print_r($errorInfo, true));
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Thêm khách hàng thất bại"]);
            }
        } catch (PDOException $e) {
            error_log("Lỗi PDO: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Lỗi database: " . $e->getMessage()]);
        }
        break;
        
    case 'PUT':
        // Cập nhật khách hàng
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        
        if (!$data || empty($data['MaKhachHang']) || empty($data['TenKhachHang'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
            exit();
        }
        
        $MaKhachHang = $data['MaKhachHang'];
        $TenKhachHang = $data['TenKhachHang'];
        $SoDienThoai = $data['SoDienThoai'] ?? '';
        $Email = $data['Email'] ?? '';
        $DiaChi = $data['DiaChi'] ?? '';
        
        try {
            $stmt = $conn->prepare("UPDATE khachhang SET TenKhachHang=?, SoDienThoai=?, Email=?, DiaChi=? WHERE MaKhachHang=?");
            if($stmt->execute([$TenKhachHang, $SoDienThoai, $Email, $DiaChi, $MaKhachHang])) {
                echo json_encode(["success" => true, "message" => "Cập nhật khách hàng thành công"]);
            } else {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Cập nhật khách hàng thất bại"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Lỗi database: " . $e->getMessage()]);
        }
        break;
        
    case 'DELETE':
        // Xóa khách hàng
        if(isset($_GET['MaKhachHang'])) {
            $MaKhachHang = $_GET['MaKhachHang'];
            
            try {
                // Kiểm tra xem khách hàng có đơn hàng không
                $check_stmt = $conn->prepare("SELECT COUNT(*) FROM donhang WHERE MaKhachHang = ?");
                $check_stmt->execute([$MaKhachHang]);
                $order_count = $check_stmt->fetchColumn();
                
                if($order_count > 0) {
                    http_response_code(400);
                    echo json_encode([
                        "success" => false, 
                        "message" => "Không thể xóa khách hàng vì có đơn hàng liên quan"
                    ]);
                } else {
                    $stmt = $conn->prepare("DELETE FROM khachhang WHERE MaKhachHang = ?");
                    if($stmt->execute([$MaKhachHang])) {
                        echo json_encode(["success" => true, "message" => "Xóa khách hàng thành công"]);
                    } else {
                        http_response_code(400);
                        echo json_encode(["success" => false, "message" => "Xóa khách hàng thất bại"]);
                    }
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Lỗi database: " . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Thiếu MaKhachHang"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Method không được hỗ trợ"]);
        break;
}
?>