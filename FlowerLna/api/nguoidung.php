<?php
include __DIR__ . '/../config/connect.php';

// Cấu hình báo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Ghi log debug
error_log("=== API nguoidung.php được gọi ===");
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
        // Lấy danh sách người dùng hoặc 1 người dùng cụ thể
        if(isset($_GET['MaNguoiDung'])) {
            $MaNguoiDung = $_GET['MaNguoiDung'];
            $stmt = $conn->prepare("SELECT MaNguoiDung, Email, HoTen, SoDienThoai, DiaChi, VaiTro, NgayTao, TrangThai FROM nguoidung WHERE MaNguoiDung = ?");
            $stmt->execute([$MaNguoiDung]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else if(isset($_GET['Email'])) {
            $Email = $_GET['Email'];
            $stmt = $conn->prepare("SELECT MaNguoiDung, Email, HoTen, SoDienThoai, DiaChi, VaiTro, NgayTao, TrangThai FROM nguoidung WHERE Email = ?");
            $stmt->execute([$Email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->query("SELECT MaNguoiDung, Email, HoTen, SoDienThoai, DiaChi, VaiTro, NgayTao, TrangThai FROM nguoidung ORDER BY MaNguoiDung DESC");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($result);
        break;

    case 'POST':
        // Đăng ký người dùng mới hoặc đăng nhập
        $input = file_get_contents("php://input");
        error_log("Raw POST data: " . $input);
        
        $data = json_decode($input, true);
        
        if (!$data || json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["loi" => "Dữ liệu JSON không hợp lệ"]);
            exit();
        }
        
        // Kiểm tra xem là đăng nhập hay đăng ký
        if (isset($data['dangNhap']) && $data['dangNhap'] === true) {
            // XỬ LÝ ĐĂNG NHẬP
            if (empty($data['Email']) || empty($data['MatKhau'])) {
                http_response_code(400);
                echo json_encode(["loi" => "Email và mật khẩu là bắt buộc"]);
                exit();
            }
            
            $Email = trim($data['Email']);
            $MatKhau = $data['MatKhau'];
            
            try {
                $stmt = $conn->prepare("SELECT * FROM nguoidung WHERE Email = ? AND TrangThai = 'hoatdong'");
                $stmt->execute([$Email]);
                $nguoiDung = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($nguoiDung) {
                    // Kiểm tra mật khẩu (trong thực tế nên dùng password_hash)
                    if ($MatKhau === $nguoiDung['MatKhau']) {
                        // Đăng nhập thành công
                        unset($nguoiDung['MatKhau']); // Không trả về mật khẩu
                        echo json_encode([
                            "thanhCong" => true,
                            "thongBao" => "Đăng nhập thành công",
                            "nguoiDung" => $nguoiDung
                        ]);
                    } else {
                        http_response_code(401);
                        echo json_encode(["loi" => "Email hoặc mật khẩu không đúng"]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["loi" => "Email hoặc mật khẩu không đúng"]);
                }
            } catch (PDOException $e) {
                error_log("Lỗi đăng nhập: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(["loi" => "Lỗi server: " . $e->getMessage()]);
            }
            
        } else {
            // XỬ LÝ ĐĂNG KÝ
            if (empty($data['Email']) || empty($data['MatKhau']) || empty($data['HoTen'])) {
                http_response_code(400);
                echo json_encode(["loi" => "Email, mật khẩu và họ tên là bắt buộc"]);
                exit();
            }
            
            $Email = trim($data['Email']);
            $MatKhau = $data['MatKhau'];
            $HoTen = trim($data['HoTen']);
            $SoDienThoai = isset($data['SoDienThoai']) ? trim($data['SoDienThoai']) : '';
            $DiaChi = isset($data['DiaChi']) ? trim($data['DiaChi']) : '';
            $VaiTro = isset($data['VaiTro']) ? $data['VaiTro'] : 'khachhang';
            
            // THÊM VALIDATION: Chỉ cho phép 2 vai trò
            if (!in_array($VaiTro, ['khachhang', 'quantri'])) {
                $VaiTro = 'khachhang'; // Mặc định là khách hàng nếu sai
            }
            
            try {
                // Kiểm tra email đã tồn tại chưa
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM nguoidung WHERE Email = ?");
                $checkStmt->execute([$Email]);
                $exists = $checkStmt->fetchColumn();
                
                if ($exists > 0) {
                    http_response_code(400);
                    echo json_encode(["loi" => "Email đã được sử dụng"]);
                    exit();
                }
                
                // Thêm người dùng mới
                $stmt = $conn->prepare("INSERT INTO nguoidung (Email, MatKhau, HoTen, SoDienThoai, DiaChi, VaiTro) VALUES (?, ?, ?, ?, ?, ?)");
                
                if($stmt->execute([$Email, $MatKhau, $HoTen, $SoDienThoai, $DiaChi, $VaiTro])) {
                    $newId = $conn->lastInsertId();
                    error_log("Đăng ký người dùng thành công - ID: " . $newId);
                    
                    // Lấy thông tin người dùng vừa tạo (không bao gồm mật khẩu)
                    $stmt = $conn->prepare("SELECT MaNguoiDung, Email, HoTen, SoDienThoai, DiaChi, VaiTro, NgayTao, TrangThai FROM nguoidung WHERE MaNguoiDung = ?");
                    $stmt->execute([$newId]);
                    $nguoiDungMoi = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    echo json_encode([
                        "thanhCong" => true,
                        "thongBao" => "Đăng ký thành công", 
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
        }
        break;

    case 'PUT':
        // Cập nhật thông tin người dùng
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(["loi" => "Dữ liệu JSON không hợp lệ"]);
            exit();
        }
        
        if (empty($data['MaNguoiDung'])) {
            http_response_code(400);
            echo json_encode(["loi" => "Thiếu MaNguoiDung"]);
            exit();
        }
        
        $MaNguoiDung = $data['MaNguoiDung'];
        $HoTen = $data['HoTen'] ?? '';
        $SoDienThoai = $data['SoDienThoai'] ?? '';
        $DiaChi = $data['DiaChi'] ?? '';
        $TrangThai = $data['TrangThai'] ?? '';
        
        try {
            $sql = "UPDATE nguoidung SET HoTen = ?, SoDienThoai = ?, DiaChi = ?";
            $params = [$HoTen, $SoDienThoai, $DiaChi];
            
            if (!empty($TrangThai)) {
                $sql .= ", TrangThai = ?";
                $params[] = $TrangThai;
            }
            
            $sql .= " WHERE MaNguoiDung = ?";
            $params[] = $MaNguoiDung;
            
            $stmt = $conn->prepare($sql);
            if($stmt->execute($params)) {
                echo json_encode(["thanhCong" => true, "thongBao" => "Cập nhật thông tin thành công"]);
            } else {
                http_response_code(400);
                echo json_encode(["loi" => "Cập nhật thông tin thất bại"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["loi" => "Lỗi database: " . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        // Xóa người dùng (chỉ đổi trạng thái)
        if(!isset($_GET['MaNguoiDung'])) {
            http_response_code(400);
            echo json_encode(["loi" => "Thiếu MaNguoiDung"]);
            exit();
        }
        
        $MaNguoiDung = $_GET['MaNguoiDung'];
        
        try {
            $stmt = $conn->prepare("UPDATE nguoidung SET TrangThai = 'khoa' WHERE MaNguoiDung = ?");
            if($stmt->execute([$MaNguoiDung])) {
                echo json_encode(["thanhCong" => true, "thongBao" => "Khóa người dùng thành công"]);
            } else {
                http_response_code(400);
                echo json_encode(["loi" => "Khóa người dùng thất bại"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["loi" => "Lỗi database: " . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["loi" => "Method không được hỗ trợ"]);
        break;
}
?>