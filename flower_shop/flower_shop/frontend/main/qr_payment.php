<?php
// frontend/main/qr_payment.php - Trang thanh toán QR
$method = $_GET['method'] ?? '';
$methodNames = [
    'momo' => 'Ví Momo',
    'zalopay' => 'ZaloPay', 
    'transfer' => 'Chuyển khoản ngân hàng'
];
$methodName = $methodNames[$method] ?? 'QR Payment';

// Đường dẫn ảnh QR cho từng phương thức
$qrImages = [
    'momo' => '../../assets/images/qr/momo_qr.jpg',
    'zalopay' => '../../assets/images/qr/zalopay_qr.jpg',
    'transfer' => '../../assets/images/qr/bank_transfer_qr.jpg'
];

$qrImage = $qrImages[$method] ?? '../../assets/images/qr/default_qr.jpg';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán QR - Flower'Lna</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assets/css/order.css">
    <style>
        .qr-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin: 2rem 0;
        }
        
        .qr-code-container {
            text-align: center;
            margin: 2rem 0;
        }
        
        .qr-code {
            width: 300px;
            height: 300px;
            margin: 0 auto;
            background: #f8f9fa;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 100px;
            color: #667eea;
            border: 2px dashed #dee2e6;
        }
        
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 15px;
            padding: 2rem;
            border-left: 5px solid #667eea;
            margin-bottom: 2rem;
        }
        
        .steps {
            margin: 2rem 0;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .step-number {
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
        }
        
        @media (max-width: 768px) {
            .qr-card {
                padding: 2rem 1.5rem;
                margin: 1rem 0;
            }
            
            .qr-code {
                width: 250px;
                height: 250px;
                font-size: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="bg-white shadow-sm">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center py-3">
                <button class="btn p-2 me-3" onclick="history.back()">
                    <i class="fas fa-arrow-left" style="font-size: 18px; color: #667eea;"></i>
                </button>
                <h5 class="mb-0 fw-bold text-gradient">Thanh Toán QR - <?php echo $methodName; ?></h5>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="qr-page">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="qr-card text-center">
                        <h1 class="fw-bold mb-4" style="color: #667eea;">Quét Mã QR Để Thanh Toán</h1>
                        
                        <!-- QR Code -->
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <!-- Thay bằng hình ảnh QR thực tế -->
                                <?php 
                                $qrIcons = [
                                    'momo' => '📱',
                                    'zalopay' => '📲',
                                    'transfer' => '🏦'
                                ];
                                $qrIcon = $qrIcons[$method] ?? '💳';
                                echo $qrIcon;
                                ?>
                            </div>
                            <p class="text-muted mt-3">Sử dụng ứng dụng <?php echo $methodName; ?> để quét mã</p>
                        </div>

                        <!-- Order Info -->
                        <div class="info-card text-start">
                            <h4 class="fw-bold mb-4 text-center">💳 Thông Tin Thanh Toán</h4>
                            <div id="orderInfo" class="row g-3">
                                <!-- Được fill bởi JS -->
                                <div class="col-12 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Đang tải thông tin...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Steps -->
                        <div class="steps text-start">
                            <h5 class="fw-bold mb-3">Hướng Dẫn Thanh Toán</h5>
                            <div class="step">
                                <div class="step-number">1</div>
                                <div>Mở ứng dụng <?php echo $methodName; ?> trên điện thoại</div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div>Chọn tính năng "Quét mã QR"</div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div>Quét mã QR ở trên và xác nhận thanh toán</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div>Nhấn nút "Xác Nhận Đã Thanh Toán" bên dưới</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-3 mt-4">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary w-100 py-3 fw-bold" id="confirmBtn" 
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                    <i class="fas fa-check-circle me-2"></i> Xác Nhận Đã Thanh Toán
                                </button>
                            </div>
                            <div class="col-12">
                                <a href="payment.php" class="btn btn-outline-secondary w-100 py-3">
                                    <i class="fas fa-arrow-left me-2"></i> Quay Lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        displayOrderInfo();
        
        // Xử lý sự kiện nút xác nhận
        $('#confirmBtn').click(function() {
            submitOrder();
        });
    });

    function displayOrderInfo() {
        const orderData = JSON.parse(localStorage.getItem('pending_order') || '{}');
        const cart = orderData.cart || [];
        
        if (cart.length === 0) {
            $('#orderInfo').html(`<div class="col-12 text-center text-muted">Không có thông tin đơn hàng</div>`);
            return;
        }

        let total = 0;
        cart.forEach(item => {
            total += item.gia * item.so_luong;
        });
        const vat = Math.round(total * 0.1);
        const totalWithVAT = total + vat;

        let infoHtml = `
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between">
                    <span class="fw-semibold">Tổng tiền:</span>
                    <span class="fw-bold text-primary fs-5">${formatCurrency(totalWithVAT)}</span>
                </div>
            </div>
        `;
        
        // Thêm thông tin sản phẩm
        cart.forEach(item => {
            const subtotal = item.gia * item.so_luong;
            infoHtml += `
                <div class="col-12">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <div>
                            <div class="fw-semibold">${item.ten_hoa}</div>
                            <small class="text-muted">Số lượng: ${item.so_luong}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-semibold">${formatCurrency(subtotal)}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#orderInfo').html(infoHtml);
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
    }

    function submitOrder() {
        const orderData = JSON.parse(localStorage.getItem('pending_order') || '{}');
        
        if (!orderData.ten_khach) {
            alert('Không tìm thấy thông tin đơn hàng. Vui lòng thử lại.');
            return;
        }

        const btn = $('#confirmBtn');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...');

        // Gửi request đến API
        $.ajax({
            url: '../../api/order.php?action=create_order',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(orderData),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Lưu thông tin đơn hàng thành công
                    localStorage.setItem('order_success', JSON.stringify({
                        orderId: response.ma_don_hang,
                        totalAmount: orderData.tong_tien,
                        paymentMethod: orderData.hinh_thuc_thanh_toan,
                        customerName: orderData.ten_khach,
                        customerPhone: orderData.sdt,
                        deliveryAddress: orderData.dia_chi
                    }));

                    // Xóa dữ liệu tạm
                    localStorage.removeItem('pending_order');
                    localStorage.removeItem('flower_cart');
                    localStorage.removeItem('checkout_form');

                    // Chuyển hướng đến trang thành công
                    window.location.href = 'success.php';
                } else {
                    alert('Lỗi: ' + (response.message || 'Không thể tạo đơn hàng'));
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi AJAX:', error);
                alert('Lỗi kết nối với server. Vui lòng thử lại sau.');
                btn.prop('disabled', false).html(originalText);
            }
        });
    }
    </script>
</body>
</html>