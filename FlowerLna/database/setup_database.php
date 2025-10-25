<?php
// Script để kiểm tra và cập nhật cấu trúc database
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'flower_shop';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 Cập nhật cấu trúc database...</h2>";
    
    // Kiểm tra và thêm cột SoLuongTon
    try {
        $conn->exec("ALTER TABLE hoa ADD COLUMN SoLuongTon INT DEFAULT 0 COMMENT 'Số lượng tồn kho'");
        echo "✅ Đã thêm cột SoLuongTon<br>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "ℹ️ Cột SoLuongTon đã tồn tại<br>";
        } else {
            echo "❌ Lỗi thêm cột SoLuongTon: " . $e->getMessage() . "<br>";
        }
    }
    
    // Kiểm tra và thêm cột CreatedAt
    try {
        $conn->exec("ALTER TABLE hoa ADD COLUMN CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo sản phẩm'");
        echo "✅ Đã thêm cột CreatedAt<br>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "ℹ️ Cột CreatedAt đã tồn tại<br>";
        } else {
            echo "❌ Lỗi thêm cột CreatedAt: " . $e->getMessage() . "<br>";
        }
    }
    
    // Kiểm tra và thêm cột TrangThai
    try {
        $conn->exec("ALTER TABLE hoa ADD COLUMN TrangThai VARCHAR(50) DEFAULT 'Còn hàng' COMMENT 'Trạng thái sản phẩm'");
        echo "✅ Đã thêm cột TrangThai<br>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "ℹ️ Cột TrangThai đã tồn tại<br>";
        } else {
            echo "❌ Lỗi thêm cột TrangThai: " . $e->getMessage() . "<br>";
        }
    }
    
    // Cập nhật dữ liệu mẫu
    $conn->exec("UPDATE hoa SET SoLuongTon = 10 WHERE SoLuongTon IS NULL OR SoLuongTon = 0");
    $conn->exec("UPDATE hoa SET TrangThai = 'Còn hàng' WHERE TrangThai IS NULL OR TrangThai = ''");
    
    echo "<br><h3>📋 Cấu trúc bảng hoa hiện tại:</h3>";
    
    // Hiển thị cấu trúc bảng
    $stmt = $conn->query("DESCRIBE hoa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Cột</th><th>Kiểu</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><h3>🎉 Cập nhật database hoàn tất!</h3>";
    echo "<p>Bây giờ bạn có thể sử dụng trang quản lý hoa với đầy đủ chức năng.</p>";
    
} catch(PDOException $e) {
    echo "❌ Lỗi kết nối database: " . $e->getMessage();
}
?>

