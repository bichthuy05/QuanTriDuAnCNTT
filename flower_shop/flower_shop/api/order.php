<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include '../config/connect.php';

$action = $_GET['action'] ?? '';
$response = ['status' => 'error', 'message' => 'Không tìm thấy hành động'];

// 1. LẤY DANH SÁCH HOA
if ($action === 'get_hoa') {
    try {
        $sql = "SELECT h.MaHoa, h.TenHoa, h.Gia, h.MoTa, h.HinhAnh, lh.TenLoai 
                FROM hoa h 
                LEFT JOIN loaihoa lh ON h.MaLoai = lh.MaLoai 
                ORDER BY h.MaHoa DESC";
        $result = $conn->query($sql);
        
        $hoa = [];
        while ($row = $result->fetch_assoc()) {
            $hoa[] = $row;
        }
        
        $response = ['status' => 'success', 'data' => $hoa];
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 2. LẤY DANH SÁCH LOẠI HOA
else if ($action === 'get_loai') {
    try {
        $sql = "SELECT * FROM loaihoa ORDER BY MaLoai ASC";
        $result = $conn->query($sql);
        
        $loai = [];
        while ($row = $result->fetch_assoc()) {
            $loai[] = $row;
        }
        
        $response = ['status' => 'success', 'data' => $loai];
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 3. TẠO ĐƠN HÀNG MỚI
else if ($action === 'create_order') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Validate dữ liệu
        if (empty($input['ten_khach']) || empty($input['sdt']) || empty($input['dia_chi'])) {
            throw new Exception('Vui lòng điền đầy đủ thông tin khách hàng');
        }
        
        if (empty($input['cart']) || count($input['cart']) == 0) {
            throw new Exception('Giỏ hàng trống');
        }
        
        $conn->begin_transaction();
        
        // Kiểm tra hoặc tạo khách hàng
        $email = $input['email'] ?? '';
        $sql_check = "SELECT MaKhachHang FROM khachhang 
                      WHERE SoDienThoai = ? LIMIT 1";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("s", $input['sdt']);
        $stmt->execute();
        $result_check = $stmt->get_result();
        
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $ma_khach = $row['MaKhachHang'];
        } else {
            // Tạo khách hàng mới
            $sql_insert = "INSERT INTO khachhang (TenKhachHang, SoDienThoai, Email, DiaChi) 
                          VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("ssss", $input['ten_khach'], $input['sdt'], $email, $input['dia_chi']);
            if (!$stmt->execute()) {
                throw new Exception('Lỗi tạo khách hàng: ' . $stmt->error);
            }
            $ma_khach = $conn->insert_id;
        }
        
        // Tính tổng tiền
        $tong_tien = 0;
        foreach ($input['cart'] as $item) {
            $tong_tien += $item['gia'] * $item['so_luong'];
        }
        
        // Tạo đơn hàng
        $ngay_dat = date('Y-m-d');
        $ngay_giao = $input['ngay_giao'] ?? date('Y-m-d', strtotime('+3 days'));
        $trang_thai = 'Chờ xác nhận';
        
        $sql_order = "INSERT INTO donhang (MaKhachHang, NgayDat, NgayGiao, TongTien, TrangThai) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_order);
        $stmt->bind_param("issds", $ma_khach, $ngay_dat, $ngay_giao, $tong_tien, $trang_thai);
        
        if (!$stmt->execute()) {
            throw new Exception('Lỗi tạo đơn hàng: ' . $stmt->error);
        }
        
        $ma_don_hang = $conn->insert_id;
        
        // Thêm chi tiết đơn hàng
        foreach ($input['cart'] as $item) {
            $thanh_tien = $item['gia'] * $item['so_luong'];
            $sql_detail = "INSERT INTO chitietdonhang (MaDonHang, MaHoa, SoLuong, ThanhTien) 
                          VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_detail);
            $stmt->bind_param("iiid", $ma_don_hang, $item['ma_hoa'], $item['so_luong'], $thanh_tien);
            
            if (!$stmt->execute()) {
                throw new Exception('Lỗi thêm chi tiết đơn hàng: ' . $stmt->error);
            }
        }
        
        $conn->commit();
        
        $response = [
            'status' => 'success',
            'message' => 'Đặt hàng thành công!',
            'ma_don_hang' => $ma_don_hang,
            'tong_tien' => $tong_tien
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 4. LẤY CHI TIẾT ĐƠN HÀNG
else if ($action === 'get_order_detail') {
    try {
        $ma_don = $_GET['ma_don'] ?? 0;
        
        if ($ma_don <= 0) {
            throw new Exception('Mã đơn hàng không hợp lệ');
        }
        
        $sql = "SELECT d.*, k.TenKhachHang, k.SoDienThoai, k.DiaChi, k.Email
                FROM donhang d
                LEFT JOIN khachhang k ON d.MaKhachHang = k.MaKhachHang
                WHERE d.MaDonHang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ma_don);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            throw new Exception('Không tìm thấy đơn hàng');
        }
        
        $order = $result->fetch_assoc();
        
        // Lấy chi tiết sản phẩm
        $sql_detail = "SELECT cd.*, h.TenHoa, h.HinhAnh 
                       FROM chitietdonhang cd
                       LEFT JOIN hoa h ON cd.MaHoa = h.MaHoa
                       WHERE cd.MaDonHang = ?";
        $stmt = $conn->prepare($sql_detail);
        $stmt->bind_param("i", $ma_don);
        $stmt->execute();
        $result_detail = $stmt->get_result();
        
        $chi_tiet = [];
        while ($row = $result_detail->fetch_assoc()) {
            $chi_tiet[] = $row;
        }
        
        $order['chi_tiet'] = $chi_tiet;
        
        $response = ['status' => 'success', 'data' => $order];
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
$conn->close();
?>