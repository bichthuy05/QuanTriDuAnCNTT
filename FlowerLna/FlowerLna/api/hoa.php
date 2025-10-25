<?php

include __DIR__ . '/../config/connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if(isset($_GET['MaHoa'])) {
            $MaHoa = $_GET['MaHoa'];
            $stmt = $conn->prepare("
                SELECT h.*, l.TenLoai 
                FROM hoa h 
                LEFT JOIN loaihoa l ON h.MaLoai = l.MaLoai 
                WHERE h.MaHoa = ?
            ");
            $stmt->execute([$MaHoa]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->query("
                SELECT h.*, l.TenLoai 
                FROM hoa h 
                LEFT JOIN loaihoa l ON h.MaLoai = l.MaLoai 
                ORDER BY h.MaHoa DESC
            ");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($result);
        break;

    case 'POST':
        // Thêm hoa mới
        $data = json_decode(file_get_contents("php://input"), true);
        
        $TenHoa = $data['TenHoa'];
        $Gia = $data['Gia'];
        $SoLuongTon = $data['SoLuongTon'] ?? 0;
        $MoTa = $data['MoTa'] ?? '';
        $HinhAnh = $data['HinhAnh'] ?? '';
        $MaLoai = $data['MaLoai'];
        
        $stmt = $conn->prepare("
            INSERT INTO hoa (TenHoa, Gia, SoLuongTon, MoTa, HinhAnh, MaLoai, TrangThai) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $TrangThai = $data['TrangThai'] ?? 'Còn hàng';
        
        if($stmt->execute([$TenHoa, $Gia, $SoLuongTon, $MoTa, $HinhAnh, $MaLoai, $TrangThai])) {
            echo json_encode(["success" => "Thêm hoa thành công", "MaHoa" => $conn->lastInsertId()]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Thêm hoa thất bại"]);
        }
        break;

    case 'PUT':
        // Cập nhật hoa
        $data = json_decode(file_get_contents("php://input"), true);
        
        $MaHoa = $data['MaHoa'];
        $TenHoa = $data['TenHoa'];
        $Gia = $data['Gia'];
        $SoLuongTon = $data['SoLuongTon'];
        $MoTa = $data['MoTa'] ?? '';
        $HinhAnh = $data['HinhAnh'] ?? '';
        $MaLoai = $data['MaLoai'];
        $TrangThai = $data['TrangThai'] ?? 'Còn hàng';
        
        $stmt = $conn->prepare("
            UPDATE hoa SET TenHoa = ?, Gia = ?, SoLuongTon = ?, MoTa = ?, 
            HinhAnh = ?, MaLoai = ?, TrangThai = ? WHERE MaHoa = ?
        ");
        
        if($stmt->execute([$TenHoa, $Gia, $SoLuongTon, $MoTa, $HinhAnh, $MaLoai, $TrangThai, $MaHoa])) {
            echo json_encode(["success" => "Cập nhật hoa thành công"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Cập nhật hoa thất bại"]);
        }
        break;

    case 'DELETE':
        // Xóa hoa
        $MaHoa = $_GET['MaHoa'];
        
        $stmt = $conn->prepare("DELETE FROM hoa WHERE MaHoa = ?");
        if($stmt->execute([$MaHoa])) {
            echo json_encode(["success" => "Xóa hoa thành công"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Xóa hoa thất bại"]);
        }
        break;
}
?>