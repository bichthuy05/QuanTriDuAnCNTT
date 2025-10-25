<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../connect.php"); // đường dẫn tới file connect.php

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Lấy danh sách hoặc 1 khách hàng
        if (isset($_GET['MaKhachHang'])) {
            $id = intval($_GET['MaKhachHang']);
            $stmt = $conn->prepare("SELECT * FROM khachhang WHERE MaKhachHang = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data ?: ["message" => "Không tìm thấy khách hàng."]);
        } else {
            $stmt = $conn->query("SELECT * FROM khachhang ORDER BY MaKhachHang DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data);
        }
        break;

    case 'POST':
        // Thêm khách hàng mới
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['TenKhachHang']) || empty(trim($input['TenKhachHang']))) {
            echo json_encode(["error" => "Tên khách hàng không được để trống."]);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi) VALUES (?, ?, ?, ?)");
        $ok = $stmt->execute([
            $input['TenKhachHang'],
            $input['SoDienThoai'] ?? null,
            $input['Email'] ?? null,
            $input['DiaChi'] ?? null
        ]);

        echo json_encode($ok ? ["success" => "Thêm khách hàng thành công!"] : ["error" => "Không thể thêm khách hàng."]);
        break;

    case 'PUT':
        // Cập nhật khách hàng
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['MaKhachHang'])) {
            echo json_encode(["error" => "Thiếu mã khách hàng."]);
            exit();
        }

        $stmt = $conn->prepare("UPDATE khachhang SET TenKhachHang=?, SoDienThoai=?, Email=?, DiaChi=? WHERE MaKhachHang=?");
        $ok = $stmt->execute([
            $input['TenKhachHang'],
            $input['SoDienThoai'],
            $input['Email'],
            $input['DiaChi'],
            $input['MaKhachHang']
        ]);

        echo json_encode($ok ? ["success" => "Cập nhật thành công!"] : ["error" => "Không thể cập nhật."]);
        break;

    case 'DELETE':
        // Xóa khách hàng
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (!isset($_DELETE['MaKhachHang'])) {
            echo json_encode(["error" => "Thiếu mã khách hàng để xóa."]);
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM khachhang WHERE MaKhachHang=?");
        $ok = $stmt->execute([$_DELETE['MaKhachHang']]);

        echo json_encode($ok ? ["success" => "Đã xóa khách hàng."] : ["error" => "Không thể xóa khách hàng."]);
        break;

    default:
        echo json_encode(["error" => "Phương thức không được hỗ trợ."]);
        break;
}
?>
