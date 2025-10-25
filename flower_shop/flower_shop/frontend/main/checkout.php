<?php
// frontend/main/checkout.php - Trang nhập thông tin khách hàng
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Đặt Hàng - Flower'Lna</title>
    
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
        
        .checkout-form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(176, 140, 58, 0.1);
            margin-bottom: 2rem;
            border: 1px solid var(--border);
        }
        
        .form-control-custom {
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            background: var(--light);
        }
        
        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(176, 140, 58, 0.1);
            outline: none;
        }
        
        .form-control-custom.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        
        .form-label-custom {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: block;
        }
        
        .required-field::after {
            content: " *";
            color: var(--primary-dark);
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
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="bg-white shadow-sm sticky-top">
        <div class="container">
            <div class="d-flex align-items-center py-3">
                <a href="order_online.php" class="btn p-2 me-3">
                    <i class="fas fa-arrow-left" style="font-size: 18px; color: var(--primary);"></i>
                </a>
                <h5 class="mb-0 fw-bold text-primary">Thông Tin Đặt Hàng</h5>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="container-fluid py-4" style="background: var(--light); min-height: 100vh;">
        <div class="container">
            <div class="row g-4">
                <!-- FORM -->
                <div class="col-lg-8">
                    <div class="checkout-form-container">
                        <h3 class="mb-4 fw-bold text-primary">Thông Tin Khách Hàng</h3>

                        <form id="checkoutForm">
                            <div class="mb-4">
                                <label class="form-label-custom required-field">Họ Tên</label>
                                <input type="text" id="fullName" class="form-control-custom" placeholder="Nhập họ tên đầy đủ" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">Email</label>
                                <input type="email" id="email" class="form-control-custom" placeholder="your@email.com">
                                <div class="error-message" id="emailError">
                                    <i class="fas fa-exclamation-circle me-1"></i>Email không hợp lệ. Vui lòng nhập email có chứa ký tự '@'
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom required-field">Số Điện Thoại</label>
                                <input type="tel" id="phone" class="form-control-custom" placeholder="0901234567" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom required-field">Địa Chỉ Giao Hàng</label>
                                <input type="text" id="address" class="form-control-custom" placeholder="123 Đường ABC, Quận 1, TP.HCM" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">Ngày Giao Hàng</label>
                                <input type="date" id="deliveryDate" class="form-control-custom">
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">Lời Nhắn</label>
                                <textarea id="note" class="form-control-custom" placeholder="Ghi chú thêm cho đơn hàng..." rows="4"></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SUMMARY -->
                <div class="col-lg-4">
                    <div class="bg-white rounded-3 shadow p-4 sticky-top" style="top: 100px; border: 1px solid var(--border);">
                        <h5 class="mb-4 fw-bold text-dark">Tóm Tắt Đơn</h5>

                        <div id="orderSummary" class="mb-4 pb-3 border-bottom">
                            <!-- Sản phẩm sẽ được hiển thị ở đây -->
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2 small">
                                <span>Tạm tính:</span>
                                <span id="summarySubtotal">0 ₫</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>VAT (10%):</span>
                                <span id="summaryVAT">0 ₫</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 fw-bold fs-5">
                            <span>Tổng cộng:</span>
                            <span class="text-primary" id="summaryTotal">0 ₫</span>
                        </div>

                        <button type="button" class="btn btn-primary w-100 py-3 fw-bold fs-6" onclick="continueToPayment()">
                            <i class="fas fa-check me-2"></i> Tiếp Tục Thanh Toán
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
        displayCheckoutSummary();
        setMinDeliveryDate();
        
        // Thêm sự kiện validate email khi người dùng rời khỏi trường email
        $('#email').on('blur', function() {
            validateEmail();
        });
        
        // Thêm sự kiện validate email khi người dùng nhập
        $('#email').on('input', function() {
            // Nếu đang hiển thị lỗi và người dùng bắt đầu sửa, ẩn lỗi đi
            if ($(this).hasClass('error')) {
                $(this).removeClass('error');
                $('#emailError').removeClass('show');
            }
        });
    });

    function validateEmail() {
        const email = $('#email').val().trim();
        const emailError = $('#emailError');
        
        // Nếu có nhập email nhưng không có ký tự @
        if (email && !email.includes('@')) {
            $('#email').addClass('error');
            emailError.addClass('show');
            return false;
        } else {
            $('#email').removeClass('error');
            emailError.removeClass('show');
            return true;
        }
    }

    function displayCheckoutSummary() {
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
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>${item.ten_hoa} (x${item.so_luong})</span>
                        <span class="fw-semibold">${formatCurrency(subtotal)}</span>
                    </div>
                `;
            });
        }

        $('#orderSummary').html(html);
        
        const vat = Math.round(total * 0.1);
        const totalWithVAT = total + vat;

        $('#summarySubtotal').text(formatCurrency(total));
        $('#summaryVAT').text(formatCurrency(vat));
        $('#summaryTotal').text(formatCurrency(totalWithVAT));
    }

    function continueToPayment() {
        const fullName = $('#fullName').val().trim();
        const phone = $('#phone').val().trim();
        const address = $('#address').val().trim();

        if (!fullName) {
            alert('Vui lòng nhập họ tên!');
            $('#fullName').focus();
            return;
        }

        if (!phone) {
            alert('Vui lòng nhập số điện thoại!');
            $('#phone').focus();
            return;
        }

        if (!address) {
            alert('Vui lòng nhập địa chỉ giao hàng!');
            $('#address').focus();
            return;
        }

        // Validate email trước khi tiếp tục
        if (!validateEmail()) {
            alert('Vui lòng nhập địa chỉ email hợp lệ!');
            $('#email').focus();
            return;
        }

        const formData = {
            fullName: fullName,
            email: $('#email').val().trim(),
            phone: phone,
            address: address,
            deliveryDate: $('#deliveryDate').val(),
            note: $('#note').val().trim()
        };

        localStorage.setItem('checkout_form', JSON.stringify(formData));
        window.location.href = 'payment.php';
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
    }

    function setMinDeliveryDate() {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const dateString = tomorrow.toISOString().split('T')[0];
        $('#deliveryDate').attr('min', dateString);
        
        if (!$('#deliveryDate').val()) {
            $('#deliveryDate').val(dateString);
        }
    }
    </script>
</body>
</html>