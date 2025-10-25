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
        
        .payment-page-container {
            background: var(--light);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .payment-method-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(176, 140, 58, 0.1);
            margin-bottom: 2rem;
            border: 1px solid var(--border);
        }
        
        .payment-option {
            border: 2px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 15px;
            background: white;
        }
        
        .payment-option:hover {
            border-color: var(--primary);
            background: rgba(176, 140, 58, 0.05);
        }
        
        .payment-option.active {
            border-color: var(--primary);
            background: rgba(176, 140, 58, 0.08);
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
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .payment-method-desc {
            color: #718096;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(176, 140, 58, 0.1);
            border: 1px solid var(--border);
            position: sticky;
            top: 100px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
        }
        
        header {
            background: white !important;
            border-bottom: 1px solid var(--border);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="bg-white shadow-sm sticky-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center py-3">
                <a href="checkout.php" class="btn p-2 me-3">
                    <i class="fas fa-arrow-left" style="font-size: 18px; color: var(--primary);"></i>
                </a>
                <h5 class="mb-0 fw-bold text-primary">Chọn Hình Thức Thanh Toán</h5>
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
                                        <input type="radio" name="payment" value="cod" checked class="form-check-input">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">💵</span>
                                            <h6 class="payment-method-title mb-0">Thanh Toán Khi Nhận Hàng (COD)</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán trực tiếp khi nhân viên giao hàng</p>
                                    </div>
                                </div>
                            </label>

                            <!-- MOMO -->
                            <label class="payment-option" onclick="selectPayment('momo')">
                                <input type="radio" name="payment" value="momo" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="momo" class="form-check-input">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">📱</span>
                                            <h6 class="payment-method-title mb-0">Ví Momo</h6>
                                        </div>
                                        <p class="payment-method-desc">Thanh toán qua ứng dụng Momo</p>
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
                                        <p class="payment-method-desc">Thanh toán qua ứng dụng VNPay hoặc tài khoản ngân hàng</p>
                                    </div>
                                </div>
                            </label>

                            <!-- BANK TRANSFER-->
                            <label class="payment-option" onclick="selectPayment('bank')">
                                <input type="radio" name="payment" value="bank" style="display:none;">
                                <div class="d-flex align-items-start">
                                    <div class="form-check mt-1 me-3">
                                        <input type="radio" name="payment" value="bank" class="form-check-input">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="payment-icon">🏦</span>
                                            <h6 class="payment-method-title mb-0">Chuyển Khoản Ngân Hàng</h6>
                                        </div>
                                        <p class="payment-method-desc">Chuyển tiền trực tiếp vào tài khoản của shop</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- ORDER SUMMARY -->
                <div class="col-12 col-lg-4">
                    <div class="summary-card">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-3">Tóm Tắt Đơn Hàng</h5>

                        <div id="paymentSummary" class="mb-4 pb-3 border-bottom">
                            <!-- Sản phẩm sẽ được load bằng JavaScript -->
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

                        <button type="button" class="btn btn-primary w-100 py-3 fw-bold fs-6" onclick="submitPayment()">
                            <i class="fas fa-check-circle me-2"></i> Xác Nhận Đặt Hàng
                        </button>
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
        selectPayment('cod');
    });

    function selectPayment(method) {
        $('.payment-option').removeClass('active');
        $('input[name="payment"][value="' + method + '"]').prop('checked', true);
        $(`input[value="${method}"]`).closest('.payment-option').addClass('active');
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
                            <div class="bg-light rounded p-2 me-3">
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