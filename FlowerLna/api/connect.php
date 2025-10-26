<?php
// ------------------------------------------
// 🧩 CẤU HÌNH KẾT NỐI CƠ SỞ DỮ LIỆU
// ------------------------------------------

// Server MySQL (thường là localhost khi dùng XAMPP)
$servername = "127.0.0.1";

// Tên người dùng MySQL mặc định trong XAMPP
$username = "root";

// Mật khẩu MySQL (nếu bạn chưa đặt thì để trống "")
$password = "";

// Tên cơ sở dữ liệu trong phpMyAdmin
$dbname = "flowerlna";

// Nếu bạn dùng cổng MySQL khác (ví dụ 3307) thì mở comment dòng này
// $port = 3307;

// ------------------------------------------
// 🔗 TẠO KẾT NỐI
// ------------------------------------------

$conn = new mysqli($servername, $username, $password, $dbname);

// Nếu bạn có cổng riêng, dùng dòng này thay vì dòng trên
// $conn = new mysqli($servername, $username, $password, $dbname, $port);

// ------------------------------------------
// 🧠 CẤU HÌNH CHUẨN UTF-8
// ------------------------------------------
$conn->set_charset("utf8");

// ------------------------------------------
// ⚠️ KIỂM TRA LỖI KẾT NỐI
// ------------------------------------------
if ($conn->connect_error) {
    die(json_encode([
        "error" => "Kết nối thất bại: " . $conn->connect_error
    ]));
}

// Nếu cần debug, bạn có thể in ra thông báo tạm thời (sau này xóa đi):
// echo json_encode(["message" => "✅ Kết nối thành công"]);

?>
