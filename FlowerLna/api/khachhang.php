<?php
include 'config.php';
$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    // GET: lấy dữ liệu khách hàng
    case 'GET':
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM khachhang WHERE MaKhachHang=$id";
        }else{
            $sql = "SELECT * FROM khachhang ORDER BY MaKhachHang DESC";
        }
        $result = $conn->query($sql);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // POST: thêm khách hàng
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $TenKhachHang = $input['TenKhachHang'];
        $SoDienThoai = $input['SoDienThoai'];
        $Email = $input['Email'];
        $DiaChi = $input['DiaChi'];

        $sql = "INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi)
                VALUES ('$TenKhachHang', '$SoDienThoai', '$Email', '$DiaChi')";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Thêm khách hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;

    // PUT: sửa khách hàng
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['MaKhachHang']);
        $TenKhachHang = $input['TenKhachHang'];
        $SoDienThoai = $input['SoDienThoai'];
        $Email = $input['Email'];
        $DiaChi = $input['DiaChi'];

        $sql = "UPDATE khachhang SET TenKhachHang='$TenKhachHang', SoDienThoai='$SoDienThoai', 
                Email='$Email', DiaChi='$DiaChi' WHERE MaKhachHang=$id";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Cập nhật khách hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;

    // DELETE: xóa khách hàng
    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['MaKhachHang']);
        $sql = "DELETE FROM khachhang WHERE MaKhachHang=$id";
        if($conn->query($sql)){
            echo json_encode(["success"=>true,"message"=>"Xóa khách hàng thành công"]);
        }else{
            echo json_encode(["success"=>false,"message"=>$conn->error]);
        }
        break;
}
$conn->close();
?>
