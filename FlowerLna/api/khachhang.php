<?php
// api/khachhang.php
include_once '../connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Lấy danh sách khách hàng hoặc tìm kiếm
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
            $sql = "SELECT * FROM khachhang 
                    WHERE TenKhachHang LIKE ? OR SoDienThoai LIKE ? OR Email LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%$search%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            $khachhang_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($khachhang_list);
        }
        break;
        
    case 'POST':
        // Thêm khách hàng mới
        $data = json_decode(file_get_contents("php://input"), true);
        $TenKhachHang = $data['TenKhachHang'];
        $SoDienThoai = $data['SoDienThoai'] ?? '';
        $Email = $data['Email'] ?? '';
        $DiaChi = $data['DiaChi'] ?? '';
        
        $stmt = $conn->prepare("INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$TenKhachHang, $SoDienThoai, $Email, $DiaChi])) {
            echo json_encode([
                "success" => true, 
                "message" => "Thêm khách hàng thành công", 
                "MaKhachHang" => $conn->lastInsertId()
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Thêm khách hàng thất bại"]);
        }
        break;
        
    case 'PUT':
        // Cập nhật khách hàng
        $data = json_decode(file_get_contents("php://input"), true);
        $MaKhachHang = $data['MaKhachHang'];
        $TenKhachHang = $data['TenKhachHang'];
        $SoDienThoai = $data['SoDienThoai'] ?? '';
        $Email = $data['Email'] ?? '';
        $DiaChi = $data['DiaChi'] ?? '';
        
        $stmt = $conn->prepare("UPDATE khachhang SET TenKhachHang=?, SoDienThoai=?, Email=?, DiaChi=? WHERE MaKhachHang=?");
        if($stmt->execute([$TenKhachHang, $SoDienThoai, $Email, $DiaChi, $MaKhachHang])) {
            echo json_encode(["success" => true, "message" => "Cập nhật khách hàng thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Cập nhật khách hàng thất bại"]);
        }
        break;
        
    case 'DELETE':
        // Xóa khách hàng
        $data = json_decode(file_get_contents("php://input"), true);
        $MaKhachHang = $data['MaKhachHang'];
        
        // Kiểm tra xem khách hàng có đơn hàng không
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM donhang WHERE MaKhachHang = ?");
        $check_stmt->execute([$MaKhachHang]);
        $order_count = $check_stmt->fetchColumn();
        
        if($order_count > 0) {
            echo json_encode([
                "success" => false, 
                "message" => "Không thể xóa khách hàng vì có đơn hàng liên quan"
            ]);
        } else {
            $stmt = $conn->prepare("DELETE FROM khachhang WHERE MaKhachHang = ?");
            if($stmt->execute([$MaKhachHang])) {
                echo json_encode(["success" => true, "message" => "Xóa khách hàng thành công"]);
            } else {
                echo json_encode(["success" => false, "message" => "Xóa khách hàng thất bại"]);
            }
        }
        break;
}
?>