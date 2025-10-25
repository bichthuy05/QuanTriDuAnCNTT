<?php
// frontend/main/qr_payment.php - Trang thanh toán QR
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
    
    <style>
        :root {
            --primary: #b08c3a;
            --primary-light: #d4af37;
            --primary-dark: #8a6e2f;
            --accent: #f0e6d2;
            --light: #faf9f7;
            --dark: #2f2f2f;
            --text: #3b2d1f;
            --border: #e8dfca;
        }
        
        body {
            background-color: var(--light);
            color: var(--text);
            font-family: 'Roboto', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .qr-page {
            background: var(--light);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 50px rgba(176, 140, 58, 0.1);
            border: 1px solid var(--border);
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
            background: var(--light);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 100px;
            color: var(--primary);
            border: 2px dashed var(--border);
            overflow: hidden;
        }
        
        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .info-card {
            background: linear-gradient(135deg, var(--light) 0%, var(--accent) 100%);
            border-radius: 15px;
            padding: 2rem;
            border-left: 5px solid var(--primary);
            margin-bottom: 2rem;
        }
        
        .bank-info {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
            border: 1px solid var(--border);
        }
        
        .account-details {
            font-family: monospace;
            background: var(--light);
            padding: 1rem;
            border-radius: 8px;
            margin: 0.5rem 0;
        }
        
        .copy-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            margin-left: 0.5rem;
        }
        
        .copy-btn:hover {
            background: var(--primary-dark);
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
            background: var(--primary);
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
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 10px;
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(176, 140, 58, 0.3);
        }
        
        header {
            background: white !important;
            border-bottom: 1px solid var(--border);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }

        .payment-method-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
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
                <a href="payment.php" class="btn p-2 me-3">
                    <i class="fas fa-arrow-left" style="font-size: 18px; color: var(--primary);"></i>
                </a>
                <h5 class="mb-0 fw-bold text-primary">Thanh Toán QR</h5>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="qr-page">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="qr-card text-center">
                        <h1 class="fw-bold mb-4 text-primary">Quét Mã QR Để Thanh Toán</h1>
                        
                        <!-- Payment Method Badge -->
                        <div id="paymentMethodBadge" class="payment-method-badge">
                            <!-- Will be filled by JavaScript -->
                        </div>
                        
                        <!-- QR Code -->
                        <div class="qr-code-container">
                            <div class="qr-code" id="qrDisplay">
                                <img src="" alt="QR Code" id="qrImage" style="display: none;">
                                <i class="fas fa-qrcode" id="qrPlaceholder"></i>
                            </div>
                            <p class="text-muted mt-3" id="qrInstruction">Đang tải thông tin...</p>
                        </div>

                        <!-- Bank Account Info (for bank transfer) -->
                        <div class="info-card text-start" id="bankInfo" style="display: none;">
                            <h4 class="fw-bold mb-4 text-center">🏦 Thông Tin Tài Khoản Ngân Hàng</h4>
                            <div id="bankDetails">
                                <!-- Bank details will be filled by JavaScript -->
                            </div>
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
                                <div>Mở ứng dụng thanh toán trên điện thoại</div>
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
                                <button type="button" class="btn btn-primary w-100 py-3 fw-bold" id="confirmBtn">
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
        setupQRPayment();
        
        $('#confirmBtn').click(function() {
            submitOrder();
        });
    });

    // Dữ liệu QR code và thông tin thanh toán
    const paymentMethods = {
        'momo': {
            name: 'Ví MoMo',
            qrCode: 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https://momo.vn',
            instruction: 'Sử dụng ứng dụng MoMo để quét mã'
        },
        'zalopay': {
            name: 'Ví ZaloPay',
            qrCode: 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https://zalopay.vn',
            instruction: 'Sử dụng ứng dụng ZaloPay để quét mã'
        },
        'vnpay': {
            name: 'VNPay',
            qrCode: 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https://vnpay.vn',
            instruction: 'Sử dụng ứng dụng VNPay để quét mã'
        },
        'bank': {
            name: 'Chuyển Khoản Ngân Hàng',
            qrCode: 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=BIDV',
            instruction: 'Sử dụng ứng dụng ngân hàng để quét mã',
            bankInfo: {
                bankName: 'Ngân hàng Đầu tư và Phát triển Việt Nam (BIDV)',
                accountNumber: '1234567899',
                accountHolder: 'Công ty TNHH FlowerLna',
                branch: 'Chi nhánh TP.HCM'     
            }
        }
    };

    function setupQRPayment() {
        // Lấy phương thức thanh toán từ localStorage
        const orderData = JSON.parse(localStorage.getItem('pending_order') || '{}');
        const paymentMethod = orderData.hinh_thuc_thanh_toan || 'momo';
        
        updateQRDisplay(paymentMethod);
    }

    function updateQRDisplay(paymentMethod) {
        let paymentInfo = paymentMethods[paymentMethod];
        
        if (!paymentInfo) {
            // Nếu không tìm thấy phương thức, mặc định là momo
            paymentMethod = 'momo';
            paymentInfo = paymentMethods.momo;
        }
        
        // Hiển thị tên phương thức thanh toán
        $('#paymentMethodBadge').html(`<i class="fas fa-mobile-alt me-2"></i>${paymentInfo.name}`);
        
        // Cập nhật QR code
        if (paymentInfo.qrCode) {
            $('#qrImage').attr('src', paymentInfo.qrCode).show();
            $('#qrPlaceholder').hide();
        } else {
            $('#qrImage').hide();
            $('#qrPlaceholder').show();
        }
        
        // Cập nhật hướng dẫn
        $('#qrInstruction').text(paymentInfo.instruction);
        
        // Cập nhật thông tin ngân hàng (nếu có)
        if (paymentInfo.bankInfo) {
            displayBankInfo(paymentInfo.bankInfo);
            $('#bankInfo').show();
        } else {
            $('#bankInfo').hide();
        }
    }

    function displayBankInfo(bankInfo) {
        const html = `
            <div class="bank-info">
                <div class="mb-3">
                    <strong>Ngân hàng:</strong> ${bankInfo.bankName}
                </div>
                <div class="mb-3">
                    <strong>Số tài khoản:</strong> 
                    <div class="account-details">
                        ${bankInfo.accountNumber}
                        <button class="copy-btn" onclick="copyToClipboard('${bankInfo.accountNumber}')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Chủ tài khoản:</strong> 
                    <div class="account-details">
                        ${bankInfo.accountHolder}
                        <button class="copy-btn" onclick="copyToClipboard('${bankInfo.accountHolder}')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
                <div class="mb-0">
                    <strong>Chi nhánh:</strong> ${bankInfo.branch}
                </div>
                <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded">
                    <small class="text-warning">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        <strong>Lưu ý:</strong> Vui lòng ghi nội dung chuyển khoản theo cú pháp: <code>TENKHACHHANG_SDT</code>
                    </small>
                </div>
            </div>
        `;
        
        $('#bankDetails').html(html);
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Hiển thị thông báo copy thành công
            showNotification('Đã sao chép vào clipboard!');
        }).catch(function(err) {
            console.error('Lỗi khi copy: ', err);
            alert('Không thể copy văn bản');
        });
    }

    function showNotification(message) {
        // Tạo thông báo tạm thời
        const notification = $(`
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast show" role="alert">
                    <div class="toast-header" style="background-color: var(--primary); color: white;">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong class="me-auto">Thành công</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(notification);
        
        // Tự động xóa thông báo sau 2 giây
        setTimeout(() => {
            notification.remove();
        }, 2000);
    }

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
        
        // Thêm thông tin khách hàng nếu có
        if (orderData.ten_khach) {
            infoHtml += `
                <div class="col-12 mb-2">
                    <div class="border-bottom pb-2">
                        <strong>Khách hàng:</strong> ${orderData.ten_khach}
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="border-bottom pb-2">
                        <strong>SĐT:</strong> ${orderData.sdt || 'Chưa có'}
                    </div>
                </div>
            `;
        }
        
        // Thêm thông tin sản phẩm
        cart.forEach(item => {
            const subtotal = item.gia * item.so_luong;
            infoHtml += `
                <div class="col-12">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <div>
                            <div class="fw-semibold">${item.ten_hoa}</div>
                            <small class="text-muted">Số lượng: ${item.so_luong} x ${formatCurrency(item.gia)}</small>
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
        const paymentMethod = orderData.hinh_thuc_thanh_toan || 'momo';
        
        if (!orderData.ten_khach) {
            alert('Không tìm thấy thông tin đơn hàng. Vui lòng thử lại.');
            return;
        }

        const btn = $('#confirmBtn');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...');

        // GỬI REQUEST THẬT ĐẾN API
        $.ajax({
            url: '../../api/order.php?action=create_order',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(orderData),
            dataType: 'json',
            success: function(response) {
                console.log('QR Payment API Response:', response);
                if (response.status === 'success') {
                    // Lưu thông tin đơn hàng thành công
                    localStorage.setItem('order_success', JSON.stringify({
                        orderId: response.ma_don_hang,
                        totalAmount: orderData.tong_tien,
                        paymentMethod: paymentMethod,
                        customerName: orderData.ten_khach,
                        customerPhone: orderData.sdt,
                        deliveryAddress: orderData.dia_chi,
                        paymentTime: new Date().toLocaleString('vi-VN')
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
                console.error('QR Payment AJAX Error:', error);
                console.error('Response:', xhr.responseText);
                alert('Lỗi kết nối với server. Vui lòng thử lại sau.');
                btn.prop('disabled', false).html(originalText);
            }
        });
    }
    </script>
</body>
</html>