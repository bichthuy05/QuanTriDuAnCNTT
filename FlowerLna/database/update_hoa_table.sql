-- Cập nhật bảng hoa để thêm các cột cần thiết
-- Chạy script này trong phpMyAdmin

-- Thêm cột SoLuongTon (số lượng tồn) nếu chưa có
ALTER TABLE hoa 
ADD COLUMN IF NOT EXISTS SoLuongTon INT DEFAULT 0 COMMENT 'Số lượng tồn kho';

-- Thêm cột CreatedAt (ngày tạo) nếu chưa có
ALTER TABLE hoa 
ADD COLUMN IF NOT EXISTS CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo sản phẩm';

-- Thêm cột TrangThai (trạng thái) nếu chưa có
ALTER TABLE hoa 
ADD COLUMN IF NOT EXISTS TrangThai VARCHAR(50) DEFAULT 'Còn hàng' COMMENT 'Trạng thái sản phẩm';

-- Cập nhật dữ liệu mẫu nếu cần
UPDATE hoa SET SoLuongTon = 10 WHERE SoLuongTon IS NULL;
UPDATE hoa SET TrangThai = 'Còn hàng' WHERE TrangThai IS NULL;

-- Hiển thị cấu trúc bảng sau khi cập nhật
DESCRIBE hoa;

