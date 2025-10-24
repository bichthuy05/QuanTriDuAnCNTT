<?php
// frontend/main/payment.php - Trang chọn hình thức thanh toán
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Hình Thức Thanh Toán - Flower'Lna</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assets/css/order.css">
    <style>
        /* CSS cho trang thanh toán */
        .payment-page-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .payment-method-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .payment-option:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }
        
        .payment-option.active {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.08);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.15);
        }
        
        .payment-icon {
            font-size: 24px;
            margin-right: 15px;
            width: 40px;
            text-align: center;
        }
        
        .payment-method-title {
            font-weight: 600;
            font-size: 17px;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .payment-method-desc {
            color: #718096;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .payment-method-benefit {
            color: #38a169;
            font-size: 13px;
            font-weight: 500;
        }
        
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: sticky;
            top: 100px;
        }
        
        @media (max-width: 991.98px) {
            .payment-method-card,
            .summary-card {
                padding: 1.5rem;
                border-radius: 15px;
            }
            
            .summary-card {
                position: static;
                margin-top: 1rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .payment-method-card,
            .summary-card {
                padding: 1.25rem;
                margin-left: 0;
                margin-right: 0;
            }
            
            .payment-option {
                padding: 15px;
            }
            
            .payment-method-title {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="bg-white shadow-sm sticky-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center py-3">
                <button class="btn p-2 me-3" onclick="history.back()">
                    <i class="fas fa-arrow-left" style="font-size: 18px; color: #667eea;"></i>
                </button>
                <h5 class="mb-0 fw-bold text-gradient">Chọn Hình Thức Thanh Toán</h5>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="payment-page-container">
        <div class="container-fluid px-3">
            <div class="row g-4 justify-content-center">
                <!-- PAYMENT METHODS -->
                <div class="col-12 col-lg-8">
                    <div class="payment-method-card">
                        <h3 class="mb-4 fw-bold text-primary">Lựa Chọn Phương Thức Thanh Toán</h3>

                        <div class="payment-options-container">
                            <!-- COD -->
                            <label class="payment-option active" onclick="selectPayment('cod')">
                                <input type="radio" name="payment" value="cod" checked style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="cod" checked class="form-check-input" style="width: 18px; height: 18px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">💵</span>
                                            <h6 class="payment-method-title mb-0">Thanh Toán Khi Nhận Hàng (COD)</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán trực tiếp khi nhân viên giao hàng</p>
                                        <p class="payment-method-benefit">✓ Không phí giao dịch</p>
                                    </div>
                                </div>
                            </label>

                            <!-- MOMO -->
                            <label class="payment-option" onclick="selectPayment('momo')">
                                <input type="radio" name="payment" value="momo" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="momo" class="form-check-input" style="width: 18px; height: 18px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">📱</span>
                                            <h6 class="payment-method-title mb-0">Ví Momo</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán qua ứng dụng Momo</p>
                                        <p class="payment-method-benefit" style="color: #d53f8c;">✓ Nhanh chóng và an toàn</p>
                                    </div>
                                </div>
                            </label>

                            <!-- ZALOPAY -->
                            <label class="payment-option" onclick="selectPayment('zalopay')">
                                <input type="radio" name="payment" value="zalopay" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="zalopay" class="form-check-input" style="width: 18px; height: 18px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">📲</span>
                                            <h6 class="payment-method-title mb-0">ZaloPay</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán qua ứng dụng ZaloPay</p>
                                        <p class="payment-method-benefit" style="color: #3182ce;">✓ Hỗ trợ từ Super App Zalo</p>
                                    </div>
                                </div>
                            </label>

                            <!-- VNPAY -->
                            <label class="payment-option" onclick="selectPayment('vnpay')">
                                <input type="radio" name="payment" value="vnpay" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="vnpay" class="form-check-input" style="width: 18px; height: 18px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">💳</span>
                                            <h6 class="payment-method-title mb-0">VNPay</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán bằng thẻ credit/debit hoặc tài khoản ngân hàng</p>
                                        <p class="payment-method-benefit" style="color: #e53e3e;">✓ Hỗ trợ nhiều ngân hàng</p>
                                    </div>
                                </div>
                            </label>

                            <!-- BANK TRANSFER -->
                            <label class="payment-option" onclick="selectPayment('transfer')">
                                <input type="radio" name="payment" value="transfer" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="transfer" class="form-check-input" style="width: 18px; height: 18px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">🏦</span>
                                            <h6 class="payment-method-title mb-0">Chuyển Khoản Ngân Hàng</h6>
                                        </div>
                                        <p class="payment-method-desc">Chuyển tiền trực tiếp vào tài khoản của shop</p>
                                        <p class="payment-method-benefit">✓ Chi phí rẻ nhất</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- INFO BOX -->
                        <div class="alert alert-info mt-4 border-0" style="background: rgba(102, 126, 234, 0.1); color: #2d3748; border-radius: 12px;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle me-3 mt-1" style="color: #667eea;"></i>
                                <div>
                                    <strong class="d-block mb-1">Lưu ý quan trọng</strong>
                                    <p class="mb-0 small">Sau khi xác nhận, bạn sẽ được chuyển hướng đến trang thanh toán an toàn. Tất cả giao dịch được bảo mật tuyệt đối theo tiêu chuẩn PCI DSS.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDER SUMMARY -->
                <div class="col-12 col-lg-4">
                    <div class="summary-card">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-3">Tóm Tắt Đơn Hàng</h5>

                        <div id="paymentSummary" class="mb-4 pb-3 border-bottom">
                            <!-- Sản phẩm sẽ được load bằng JavaScript -->
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-spinner fa-spin me-2"></i>Đang tải...
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">Tạm tính:</span>
                                <span class="small fw-semibold" id="paySubtotal">0 ₫</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small">VAT (10%):</span>
                                <span class="small fw-semibold" id="payVAT">0 ₫</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 fw-bold fs-5">
                            <span>Tổng cộng:</span>
                            <span class="text-primary" id="payTotal">0 ₫</span>
                        </div>

                        <div class="alert alert-warning small mb-4 border-0" style="background: rgba(246, 173, 85, 0.1);">
                            <strong class="d-block mb-2">Phương thức thanh toán:</strong>
                            <p class="mb-0 fw-semibold" id="selectedPaymentDisplay">💵 Thanh toán khi nhận hàng</p>
                        </div>

                        <button type="button" class="btn btn-primary w-100 py-3 fw-bold fs-6" id="submitBtn" onclick="submitPayment()" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-check-circle me-2"></i> Xác Nhận Đặt Hàng
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>Giao dịch được bảo mật
                            </small>
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
        displayPaymentSummary();
        // Kích hoạt phương thức COD mặc định
        selectPayment('cod');
    });

    function selectPayment(method) {
        // Bỏ chọn tất cả
        $('.payment-option').removeClass('active');
        $('input[name="payment"][value="' + method + '"]').prop('checked', true);
        
        // Chọn phương thức được click
        $(`input[value="${method}"]`).closest('.payment-option').addClass('active');

        // Cập nhật hiển thị phương thức đã chọn
        const displayText = {
            'cod': '💵 Thanh toán khi nhận hàng',
            'momo': '📱 Ví Momo',
            'zalopay': '📲 ZaloPay',
            'vnpay': '💳 VNPay',
            'transfer': '🏦 Chuyển khoản ngân hàng'
        };

        $('#selectedPaymentDisplay').text(displayText[method]);
    }

    function displayPaymentSummary() {
        const cart = JSON.parse(localStorage.getItem('flower_cart') || '[]');
        let html = '';
        let total = 0;

        if (cart.length === 0) {
            html = '<div class="text-center text-muted py-3">Giỏ hàng trống</div>';
        } else {
            cart.forEach(item => {
                const subtotal = item.gia * item.so_luong;
                total += subtotal;
                html += `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-flower text-primary"></i>
                            </div>
                            <div>
                                <div class="small fw-semibold">${item.ten_hoa}</div>
                                <div class="text-muted small">Số lượng: x${item.so_luong}</div>
                            </div>
                        </div>
                        <span class="fw-semibold">${formatCurrency(subtotal)}</span>
                    </div>
                `;
            });
        }

        $('#paymentSummary').html(html);
        
        const vat = Math.round(total * 0.1);
        const totalWithVAT = total + vat;

        $('#paySubtotal').text(formatCurrency(total));
        $('#payVAT').text(formatCurrency(vat));
        $('#payTotal').text(formatCurrency(totalWithVAT));
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
    }

    function submitPayment() {
    const paymentMethod = $('input[name="payment"]:checked').val();
    
    if (!paymentMethod) {
        alert('Vui lòng chọn hình thức thanh toán');
        return;
    }

    const formData = JSON.parse(localStorage.getItem('checkout_form') || '{}');
    
    if (!formData.fullName || !formData.phone || !formData.address) {
        alert('Vui lòng nhập đầy đủ thông tin khách hàng trước');
        window.location.href = 'checkout.php';
        return;
    }

    const cart = JSON.parse(localStorage.getItem('flower_cart') || '[]');
    
    if (cart.length === 0) {
        alert('Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng.');
        window.location.href = '../products/';
        return;
    }

    // Tính tổng tiền
    let total = 0;
    cart.forEach(item => {
        total += item.gia * item.so_luong;
    });
    const vat = Math.round(total * 0.1);
    const totalWithVAT = total + vat;

    const orderData = {
        ten_khach: formData.fullName,
        email: formData.email || '',
        sdt: formData.phone,
        dia_chi: formData.address,
        ngay_giao: formData.deliveryDate || '',
        ghi_chu: formData.note || '',
        hinh_thuc_thanh_toan: paymentMethod,
        cart: cart,
        tong_tien: totalWithVAT
    };

    // PHÂN LOẠI PHƯƠNG THỨC THANH TOÁN
    if (paymentMethod === 'cod') {
        // COD: Tạo đơn hàng ngay lập tức
        const btn = $('#submitBtn');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...');

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
                        totalAmount: totalWithVAT,
                        paymentMethod: paymentMethod,
                        customerName: formData.fullName,
                        customerPhone: formData.phone,
                        deliveryAddress: formData.address
                    }));

                    // Xóa giỏ hàng và form
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
    } else {
        // Các phương thức QR: Lưu tạm và chuyển đến trang QR
        localStorage.setItem('pending_order', JSON.stringify(orderData));
        window.location.href = 'qr_payment.php?method=' + paymentMethod;
    }
}
    // Xử lý phím Enter
    $(document).on('keypress', function(e) {
        if (e.which === 13) {
            submitPayment();
        }
    });
    </script>
</body>
</html>