<?php
include __DIR__ . '/../config/connect.php';

// Cấu hình báo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Ghi log debug
error_log("=== API dangki.php được gọi ===");
error_log("Method: " . $_SERVER['REQUEST_METHOD']);

// Cho phép CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Xử lý preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents("php://input");
    error_log("Dữ liệu đăng ký: " . $input);
    
    $data = json_decode($input, true);
    
    if (!$data || json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(["loi" => "Dữ liệu JSON không hợp lệ"]);
        exit();
    }
    
    // Kiểm tra dữ liệu bắt buộc
    if (empty($data['HoTen']) || empty($data['Email']) || empty($data['MatKhau'])) {
        http_response_code(400);
        echo json_encode(["loi" => "Họ tên, email và mật khẩu là bắt buộc"]);
        exit();
    }
    
    $hoTen = trim($data['HoTen']);
    $email = trim($data['Email']);
    $matKhau = $data['MatKhau'];
    $soDienThoai = isset($data['SoDienThoai']) ? trim($data['SoDienThoai']) : '';
    $diaChi = isset($data['DiaChi']) ? trim($data['DiaChi']) : '';
    $vaiTro = isset($data['VaiTro']) ? $data['VaiTro'] : 'khachhang';
    
    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["loi" => "Email không hợp lệ"]);
        exit();
    }
    
    // Kiểm tra độ dài mật khẩu
    if (strlen($matKhau) < 6) {
        http_response_code(400);
        echo json_encode(["loi" => "Mật khẩu phải có ít nhất 6 ký tự"]);
        exit();
    }
    
    try {
        // Kiểm tra email đã tồn tại chưa
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM nguoidung WHERE Email = ?");
        $checkStmt->execute([$email]);
        $exists = $checkStmt->fetchColumn();
        
        if ($exists > 0) {
            http_response_code(400);
            echo json_encode(["loi" => "Email đã được sử dụng"]);
            exit();
        }
        
        // Thêm người dùng mới
        $stmt = $conn->prepare("INSERT INTO nguoidung (HoTen, Email, MatKhau, SoDienThoai, DiaChi, VaiTro) VALUES (?, ?, ?, ?, ?, ?)");
        
        if($stmt->execute([$hoTen, $email, $matKhau, $soDienThoai, $diaChi, $vaiTro])) {
            $maNguoiDungMoi = $conn->lastInsertId();
            error_log("Đăng ký người dùng thành công - ID: " . $maNguoiDungMoi);
            
            // Lấy thông tin người dùng vừa tạo (không bao gồm mật khẩu)
            $stmt = $conn->prepare("SELECT MaNguoiDung, HoTen, Email, SoDienThoai, DiaChi, VaiTro, NgayTao, TrangThai FROM nguoidung WHERE MaNguoiDung = ?");
            $stmt->execute([$maNguoiDungMoi]);
            $nguoiDungMoi = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo json_encode([
                "thanhCong" => true,
                "thongBao" => "Đăng ký thành công! Vui lòng đăng nhập.",
                "nguoiDung" => $nguoiDungMoi
            ]);
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Lỗi execute: " . print_r($errorInfo, true));
            http_response_code(400);
            echo json_encode(["loi" => "Đăng ký thất bại"]);
        }
    } catch (PDOException $e) {
        error_log("Lỗi PDO: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["loi" => "Lỗi database: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["loi" => "Method không được hỗ trợ"]);
}
?>