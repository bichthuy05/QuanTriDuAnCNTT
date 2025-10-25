<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include '../connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    if (isset($_GET['MaKH'])) {
      $id = intval($_GET['MaKH']);
      $sql = "SELECT * FROM khachhang WHERE MaKhachHang = $id";
      $result = $conn->query($sql);
      if ($row = $result->fetch_assoc()) echo json_encode($row);
      else echo json_encode(["message" => "Không tìm thấy khách hàng"]);
    } else {
      $sql = "SELECT * FROM khachhang ORDER BY MaKhachHang DESC";
      $result = $conn->query($sql);
      $data = [];
      while ($row = $result->fetch_assoc()) $data[] = $row;
      echo json_encode($data);
    }
    break;

  case 'POST':
    $input = json_decode(file_get_contents("php://input"), true);
    $TenKhachHang = $conn->real_escape_string($input['TenKhachHang']);
    $SoDienThoai = $conn->real_escape_string($input['SoDienThoai']);
    $Email = $conn->real_escape_string($input['Email']);
    $DiaChi = $conn->real_escape_string($input['DiaChi']);

    $sql = "INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi)
            VALUES ('$TenKhachHang', '$SoDienThoai', '$Email', '$DiaChi')";
    if ($conn->query($sql))
      echo json_encode(["message" => "Thêm khách hàng thành công"]);
    else
      echo json_encode(["message" => "Lỗi: " . $conn->error]);
    break;

  case 'PUT':
    $input = json_decode(file_get_contents("php://input"), true);
    $MaKH = intval($input['MaKH']);
    $TenKhachHang = $conn->real_escape_string($input['TenKhachHang']);
    $SoDienThoai = $conn->real_escape_string($input['SoDienThoai']);
    $Email = $conn->real_escape_string($input['Email']);
    $DiaChi = $conn->real_escape_string($input['DiaChi']);

    $sql = "UPDATE khachhang 
            SET TenKhachHang='$TenKhachHang', SoDienThoai='$SoDienThoai', 
                Email='$Email', DiaChi='$DiaChi' 
            WHERE MaKhachHang=$MaKH";
    if ($conn->query($sql))
      echo json_encode(["message" => "Cập nhật thành công"]);
    else
      echo json_encode(["message" => "Lỗi: " . $conn->error]);
    break;

  case 'DELETE':
    $id = intval($_GET['MaKH']);
    $sql = "DELETE FROM khachhang WHERE MaKhachHang=$id";
    if ($conn->query($sql))
      echo json_encode(["message" => "Xóa thành công"]);
    else
      echo json_encode(["message" => "Lỗi: " . $conn->error]);
    break;

  default:
    echo json_encode(["message" => "Phương thức không hợp lệ"]);
}
$conn->close();
?>
