# 🌸 Flower'Lna - Hệ Thống Quản Lý Cửa Hàng Hoa Tươi

## 📋 Mô Tả Dự Án

Flower'Lna là một hệ thống quản lý cửa hàng hoa tươi trực tuyến được xây dựng bằng **PHP, MySQL, Bootstrap 5, jQuery**. Cho phép khách hàng đặt hoa trực tuyến với giao diện hiện đại, an toàn và dễ sử dụng.

---

## 🏗️ Cấu Trúc Thư Mục

```
FlowerLna/
│
├── index.php                           # Trang chính
├── config/
│   └── connect.php                    # Kết nối MySQL
│
├── api/                                # Backend API
│   ├── order.php                      # API Đặt hoa (Bích Thủy)
│   ├── hoa.php                        # API Quản lý hoa (Mạnh)
│   ├── loaihoa.php                    # API Quản lý loại hoa (Mạnh)
│   ├── khachhang.php                  # API Quản lý khách hàng (Linh)
│   ├── donhang.php                    # API Quản lý đơn hàng (Linh)
│   └── response.php                   # Helper định dạng JSON
│
├── frontend/
│   ├── main/
│   │   ├── order_online.php           # Giao diện đặt hoa (Bích Thủy)
│   │   ├── thongbao.php               # Trang thông báo thành công
│   │   ├── hoa.php                    # Quản lý hoa (Mạnh)
│   │   ├── loaihoa.php                # Quản lý loại hoa (Mạnh)
│   │   ├── khachhang.php              # Quản lý khách hàng (Linh)
│   │   └── donhang.php                # Quản lý đơn hàng (Linh)
│   │
│   ├── layout/
│   │   ├── header.php
│   │   ├── menu.php
│   │   ├── footer.php
│   │   └── banner.php
│   │
│   └── assets/
│       ├── css/
│       │   ├── style.css              # CSS chung
│       │   ├── hoa.css                # CSS module Mạnh
│       │   ├── donhang.css            # CSS module Linh
│       │   └── order.css              # CSS module Thủy
│       │
│       ├── js/
│       │   ├── hoa.js                 # JS module Mạnh
│       │   ├── donhang.js             # JS module Linh
│       │   └── order.js               # JS module Thủy
│       │
│       └── img/
│           ├── hoa1.jpg
│           ├── hoa2.jpg
│           └── logo.png
│
├── database/
│   ├── db_flower.sql                  # Script tạo cơ sở dữ liệu
│   └── db_backup.sql                  # Backup dữ liệu
│
├── tests/
│   ├── postman_collection.json        # Collection test API
│   └── api_test_notes.txt             # Hướng dẫn test
│
└── README.md                           # Tài liệu này
```

---

## 🚀 Cài Đặt & Chạy Dự Án

### 1️⃣ Yêu Cầu Hệ Thống

- **PHP** >= 7.4
- **MySQL** >= 5.7
- **Web Server**: Apache hoặc Nginx
- **Trình duyệt**: Chrome, Firefox, Safari (hỗ trợ ES6+)

### 2️⃣ Các Bước Cài Đặt

#### A. Tạo Cơ Sở Dữ Liệu

```bash
# Mở phpMyAdmin hoặc MySQL CLI
mysql -u root -p

# Tạo database
CREATE DATABASE flower_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flower_shop;

# Import file SQL
SOURCE database/db_flower.sql;
```

#### B. Cấu Hình Kết Nối

Chỉnh sửa file `config/connect.php`:

```php
<?php
$servername = "localhost";
$username = "root";           // Username MySQL của bạn
$password = "thuy2005.";               // Password MySQL của bạn
$database = "flower_shop";    // Tên database

// Kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
```

#### C. Tải Lên Server

```bash
# Copy toàn bộ thư mục FlowerLna vào htdocs (Apache) hoặc www (Nginx)
cp -r FlowerLna /var/www/html/
# hoặc
cp -r FlowerLna C:\xampp\htdocs\  (Windows)
```

#### D. Truy Cập Website

```
http://localhost/FlowerLna/
http://localhost/FlowerLna/frontend/main/order_online.php  (Đặt hoa)
```

---

## 📦 Module Đặt Hoa Online (Bích Thủy)

### 🎯 Tính Năng

✅ Hiển thị danh sách hoa với hình ảnh, giá, mô tả
✅ Thêm/xóa sản phẩm vào giỏ hàng
✅ Tính toán tổng tiền tự động
✅ Lưu giỏ hàng vào localStorage
✅ Form nhập thông tin khách hàng
✅ Chọn ngày giao hàng
✅ Nhập lời nhắn cho người nhận
✅ Xác nhận đơn hàng
✅ Hiển thị mã đơn hàng thành công

### 📄 File Chính

| File | Mô Tả |
|------|-------|
| `api/order.php` | Backend xử lý đặt hàng (CRUD) |
| `frontend/main/order_online.php` | Giao diện đặt hàng |
| `frontend/main/thongbao.php` | Trang thông báo thành công |
| `assets/js/order.js` | Logic JS (load products, cart, submit) |
| `assets/css/order.css` | Styling đẹp mắt |

### 🔌 API Endpoints

#### 1. Lấy Danh Sách Hoa

```
GET /api/order.php?action=get_hoa

Response:
{
  "status": "success",
  "data": [
    {
      "MaHoa": 1,
      "TenHoa": "Hoa Hồng Đỏ Lãng Mạn",
      "Gia": 250000,
      "MoTa": "Bó hoa hồng đỏ tươi tắn...",
      "HinhAnh": "hong_do.jpg",
      "TenLoai": "Hoa Hồng"
    }
  ]
}
```

#### 2. Lấy Danh Sách Loại Hoa

```
GET /api/order.php?action=get_loai

Response:
{
  "status": "success",
  "data": [
    {
      "MaLoai": 1,
      "TenLoai": "Hoa Hồng",
      "MoTa": "Hoa hồng – biểu tượng của tình yêu."
    }
  ]
}
```

#### 3. Tạo Đơn Hàng

```
POST /api/order.php?action=create_order
Content-Type: application/json

{
  "ten_khach": "Nguyễn Văn A",
  "email": "a@example.com",
  "sdt": "0901234567",
  "dia_chi": "123 Đường ABC, TP.HCM",
  "ngay_giao": "2025-10-25",
  "ghi_chu": "Gói gói lên để tặng",
  "cart": [
    {
      "ma_hoa": 1,
      "ten_hoa": "Hoa Hồng Đỏ",
      "gia": 250000,
      "so_luong": 2
    }
  ]
}

Response:
{
  "status": "success",
  "message": "Đặt hàng thành công!",
  "ma_don_hang":