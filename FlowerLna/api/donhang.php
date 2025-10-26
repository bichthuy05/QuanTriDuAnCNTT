<?php
include 'config.php';
$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    // GET: lấy đơn hàng (kèm info khách hàng)
    case 'GET':
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            $sql = "SELECT d.*, k.TenKhachHang, k.SoDienThoai 
                    FROM donhang d
                    JOIN khachhang k ON d.MaKhachHang=k.MaKhachHang
                    WHERE d.MaDonHang=$id";
        }else{
            $sql = "SELECT d.*, k.TenKhachHang, k.SoDienThoai 
                    FROM donhang d
                    JOIN khachhang k ON d.MaKhachHang=k.MaKhachHang
                    ORDER BY d.MaDonHang DESC";
        }
        $result = $conn->query($sql);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // POST: thêm đơn hàng
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $MaKhachHang = $input['MaKhachHang'];
        $NgayDat = $input['NgayDat'];
        $NgayGiao = $input['NgayGiao'];
        $TongTien = $input['TongTien'];
        $TrangThai = $input['TrangThai'];

        $sql = "INSERT INTO donhang (MaKhachHang, NgayDat, NgayGiao, TongTien, TrangThai)
                VALUES ('$MaKhachHang', '$NgayDat', '$NgayGiao', '$TongTien', '$TrangThai')";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Thêm đơn hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;

    // PUT: sửa đơn hàng
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['MaDonHang']);
        $MaKhachHang = $input['MaKhachHang'];
        $NgayDat = $input['NgayDat'];
        $NgayGiao = $input['NgayGiao'];
        $TongTien = $input['TongTien'];
        $TrangThai = $input['TrangThai'];

        $sql = "UPDATE donhang SET MaKhachHang='$MaKhachHang', NgayDat='$NgayDat', 
                NgayGiao='$NgayGiao', TongTien='$TongTien', TrangThai='$TrangThai'
                WHERE MaDonHang=$id";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Cập nhật đơn hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;

    // DELETE: xóa đơn hàng
    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['MaDonHang']);
        $sql = "DELETE FROM donhang WHERE MaDonHang=$id";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Xóa đơn hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;
}
$conn->close();
?>
