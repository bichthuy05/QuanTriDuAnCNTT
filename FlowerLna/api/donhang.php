<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include '../connect.php'; // Kết nối DB

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // =====================================================
    // 🟢 LẤY DANH SÁCH HOẶC 1 ĐƠN HÀNG
    // =====================================================
    case 'GET':
        if (isset($_GET['MaDonHang'])) {
            $id = intval($_GET['MaDonHang']);
            $sql = "SELECT d.*, k.TenKhachHang 
                    FROM donhang d 
                    JOIN khachhang k ON d.MaKhachHang = k.MaKhachHang
                    WHERE d.MaDonHang = $id";
            $result = $conn->query($sql);
            if ($row = $result->fetch_assoc()) {
                echo json_encode($row);
            } else {
                echo json_encode(["message" => "Không tìm thấy đơn hàng"]);
            }
        } else {
            $sql = "SELECT d.*, k.TenKhachHang 
                    FROM donhang d 
                    JOIN khachhang k ON d.MaKhachHang = k.MaKhachHang
                    ORDER BY d.MaDonHang DESC";
            $result = $conn->query($sql);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    // =====================================================
    // 🟡 THÊM ĐƠN HÀNG MỚI
    // =====================================================
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        $MaKhachHang = intval($input['MaKhachHang']);
        $NgayDat = $conn->real_escape_string($input['NgayDat']);
        $NgayGiao = $conn->real_escape_string($input['NgayGiao']);
        $TongTien = floatval($input['TongTien']);
        $TrangThai = $conn->real_escape_string($input['TrangThai']);

        $sql = "INSERT INTO donhang (MaKhachHang, NgayDat, NgayGiao, TongTien, TrangThai)
                VALUES ($MaKhachHang, '$NgayDat', '$NgayGiao', $TongTien, '$TrangThai')";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Thêm đơn hàng thành công"]);
        } else {
            echo json_encode(["message" => "Lỗi thêm đơn hàng: " . $conn->error]);
        }
        break;

    // =====================================================
    // 🟠 CẬP NHẬT ĐƠN HÀNG
    // =====================================================
    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);

        $MaDonHang = intval($input['MaDonHang']);
        $MaKhachHang = intval($input['MaKhachHang']);
        $NgayDat = $conn->real_escape_string($input['NgayDat']);
        $NgayGiao = $conn->real_escape_string($input['NgayGiao']);
        $TongTien = floatval($input['TongTien']);
        $TrangThai = $conn->real_escape_string($input['TrangThai']);

        $sql = "UPDATE donhang 
                SET MaKhachHang=$MaKhachHang, NgayDat='$NgayDat', NgayGiao='$NgayGiao',
                    TongTien=$TongTien, TrangThai='$TrangThai'
                WHERE MaDonHang=$MaDonHang";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Cập nhật đơn hàng thành công"]);
        } else {
            echo json_encode(["message" => "Lỗi cập nhật: " . $conn->error]);
        }
        break;

    // =====================================================
    // 🔴 XÓA ĐƠN HÀNG
    // =====================================================
    case 'DELETE':
        if (isset($_GET['MaDonHang'])) {
            $id = intval($_GET['MaDonHang']);
            $sql = "DELETE FROM donhang WHERE MaDonHang=$id";
            if ($conn->query($sql)) {
                echo json_encode(["message" => "Xóa đơn hàng thành công"]);
            } else {
                echo json_encode(["message" => "Lỗi xóa: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "Thiếu mã đơn hàng để xóa"]);
        }
        break;

    default:
        echo json_encode(["message" => "Phương thức không hợp lệ"]);
}

$conn->close();
?>
