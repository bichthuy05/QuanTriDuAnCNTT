<?php
// api/donhang.php
include_once '../connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if(isset($_GET['MaDonHang'])) {
            // Lấy chi tiết 1 đơn hàng
            $id = $_GET['MaDonHang'];
            $stmt = $conn->prepare("
                SELECT d.*, k.TenKhachHang, k.SoDienThoai, k.Email 
                FROM donhang d 
                JOIN khachhang k ON d.MaKhachHang = k.MaKhachHang 
                WHERE d.MaDonHang = ?
            ");
            $stmt->execute([$id]);
            $donhang = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($donhang);
        } else {
            // Lấy danh sách đơn hàng
            $stmt = $conn->prepare("
                SELECT d.*, k.TenKhachHang, k.SoDienThoai 
                FROM donhang d 
                JOIN khachhang k ON d.MaKhachHang = k.MaKhachHang 
                ORDER BY d.NgayDat DESC
            ");
            $stmt->execute();
            $donhang_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($donhang_list);
        }
        break;
        
    case 'POST':
        // Thêm đơn hàng mới
        $data = json_decode(file_get_contents("php://input"), true);
        $MaKhachHang = $data['MaKhachHang'];
        $NgayDat = $data['NgayDat'] ?? date('Y-m-d');
        $NgayGiao = $data['NgayGiao'] ?? null;
        $TongTien = $data['TongTien'];
        $TrangThai = $data['TrangThai'] ?? 'Chờ xác nhận';
        
        $stmt = $conn->prepare("INSERT INTO donhang (MaKhachHang, NgayDat, NgayGiao, TongTien, TrangThai) VALUES (?, ?, ?, ?, ?)");
        if($stmt->execute([$MaKhachHang, $NgayDat, $NgayGiao, $TongTien, $TrangThai])) {
            echo json_encode([
                "success" => true, 
                "message" => "Thêm đơn hàng thành công", 
                "MaDonHang" => $conn->lastInsertId()
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Thêm đơn hàng thất bại"]);
        }
        break;
        
    case 'PUT':
        // Cập nhật đơn hàng
        $data = json_decode(file_get_contents("php://input"), true);
        $MaDonHang = $data['MaDonHang'];
        
        if(isset($data['TrangThai'])) {
            // Cập nhật trạng thái
            $TrangThai = $data['TrangThai'];
            $stmt = $conn->prepare("UPDATE donhang SET TrangThai = ? WHERE MaDonHang = ?");
            if($stmt->execute([$TrangThai, $MaDonHang])) {
                echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công"]);
            } else {
                echo json_encode(["success" => false, "message" => "Cập nhật trạng thái thất bại"]);
            }
        } else {
            // Cập nhật thông tin đơn hàng
            $MaKhachHang = $data['MaKhachHang'];
            $NgayDat = $data['NgayDat'];
            $NgayGiao = $data['NgayGiao'];
            $TongTien = $data['TongTien'];
            
            $stmt = $conn->prepare("UPDATE donhang SET MaKhachHang=?, NgayDat=?, NgayGiao=?, TongTien=? WHERE MaDonHang=?");
            if($stmt->execute([$MaKhachHang, $NgayDat, $NgayGiao, $TongTien, $MaDonHang])) {
                echo json_encode(["success" => true, "message" => "Cập nhật đơn hàng thành công"]);
            } else {
                echo json_encode(["success" => false, "message" => "Cập nhật đơn hàng thất bại"]);
            }
        }
        break;
        
    case 'DELETE':
        // Xóa đơn hàng
        $data = json_decode(file_get_contents("php://input"), true);
        $MaDonHang = $data['MaDonHang'];
        
        // Xóa chi tiết đơn hàng trước
        $stmt_detail = $conn->prepare("DELETE FROM chitietdonhang WHERE MaDonHang = ?");
        $stmt_detail->execute([$MaDonHang]);
        
        // Xóa đơn hàng
        $stmt = $conn->prepare("DELETE FROM donhang WHERE MaDonHang = ?");
        if($stmt->execute([$MaDonHang])) {
            echo json_encode(["success" => true, "message" => "Xóa đơn hàng thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Xóa đơn hàng thất bại"]);
        }
        break;
}
?>