<?php
// frontend/main/success.php - Trang thông báo đặt hàng thành công
$orderData = json_decode(json_encode($_GET), true);
if (empty($orderData) && isset($_SESSION['order_data'])) {
    $orderData = $_SESSION['order_data'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công - Flower'Lna</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../assets/css/order.css">
    <style>
        .success-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin: 2rem 0;
        }
        
        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.8s ease-out;
            box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
        }
        
        .success-icon i {
            font-size: 60px;
            color: white;
        }
        
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 15px;
            padding: 2rem;
            border-left: 5px solid #667eea;
            margin-bottom: 2rem;
        }
        
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 1.5rem;
        }
        
        .step-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .step-content {
            flex-grow: 1;
            padding-top: 5px;
        }
        
        .support-card {
            background: #f2ccff !important;
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 1rem;
        }
        
        .support-card .fas.fa-headset {
            color: #9333ea !important;
            font-size: 1.5rem;
        }
        
        .support-card strong {
            color: #7e22ce;
        }
        
        .support-card small {
            color: #8b5cf6;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }
        
        @media (max-width: 768px) {
            .success-card {
                padding: 2rem 1.5rem;
                margin: 1rem 0;
                border-radius: 15px;
            }
            
            .success-icon {
                width: 100px;
                height: 100px;
            }
            
            .success-icon i {
                font-size: 50px;
            }
            
            .info-card {
                padding: 1.5rem;
            }
            
            .step-item {
                gap: 12px;
            }
            
            .step-number {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }
            
            .support-card {
                padding: 1.25rem;
            }
        }
        
        @media (max-width: 576px) {
            .success-card {
                padding: 1.5rem 1rem;
            }
            
            .success-icon {
                width: 80px;
                height: 80px;
                margin-bottom: 20px;
            }
            
            .success-icon i {
                font-size: 40px;
            }
            
            .info-card {
                padding: 1rem;
            }
            
            .support-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="bg-white shadow-sm">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center py-3">
                <a href="http://localhost:9000/flower_shop/flower_shop/frontend/main/order_online.php" class="btn p-2 me-3">
                    <i class="fas fa-home" style="font-size: 18px; color: #667eea;"></i>
                </a>
                <h5 class="mb-0 fw-bold text-gradient">Đặt Hàng Thành Công</h5>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="success-page">
        <div class="container-fluid px-3">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="success-card text-center fade-in-up">
                        <!-- Success Icon -->
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>

                        <!-- Title -->
                        <h1 class="fw-bold mb-3" style="color: #667eea; font-size: 2.5rem;">Đặt Hàng Thành Công!</h1>
                        <p class="text-muted mb-5 fs-5">
                            Cảm ơn bạn đã tin tưởng Flower'Lna.<br>
                            Chúng tôi sẽ liên hệ sớm để xác nhận đơn hàng.
                        </p>

                        <!-- Order Info -->
                        <div class="info-card text-start">
                            <h4 class="fw-bold mb-4 text-center">📦 Thông Tin Đơn Hàng</h4>
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

                        <!-- Next Steps -->
                        <div class="info-card text-start" style="background: linear-gradient(135deg, #fff9db 0%, #fff3cd 100%); border-left-color: #ffc107;">
                            <h5 class="fw-bold mb-4">⏱️ Các Bước Tiếp Theo</h5>
                            <div class="steps-container">
                                <div class="step-item">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h6 class="fw-bold mb-1">Xác nhận đơn hàng</h6>
                                        <p class="mb-0 text-muted">Chúng tôi sẽ gọi điện xác nhận đơn hàng trong 1-2 giờ tới</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h6 class="fw-bold mb-1">Chuẩn bị hoa tươi</h6>
                                        <p class="mb-0 text-muted">Bó hoa sẽ được chuẩn bị tươi và đẹp nhất theo yêu cầu của bạn</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h6 class="fw-bold mb-1">Giao hàng tận nơi</h6>
                                        <p class="mb-0 text-muted">Giao hàng tới địa chỉ của bạn trong thời gian dự kiến</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Support Info - ĐÃ ĐỔI MÀU SANG #f2ccff -->
                        <div class="support-card">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-headset me-3"></i>
                                <div class="text-start">
                                    <strong class="d-block">Cần hỗ trợ?</strong>
                                    <small>Liên hệ hotline: <strong>1900 1234</strong> hoặc email: <strong>support@flowerlna.com</strong></small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-3 mt-4">
                            <div class="col-12">
                                <a href="http://localhost:9000/flower_shop/flower_shop/frontend/main/order_online.php" class="btn btn-primary w-100 py-3 fw-bold" 
                                   style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                    <i class="fas fa-home me-2"></i> Trang Chủ
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
        displaySuccessInfo();
        
        // Auto-scroll to top để xem toàn bộ thông báo thành công
        window.scrollTo(0, 0);
    });

    function displaySuccessInfo() {
        const orderData = JSON.parse(localStorage.getItem('order_success') || '{}');
        
        if (!orderData.orderId) {
            $('#orderInfo').html(`
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Không tìm thấy thông tin đơn hàng
                    </div>
                    <a href="http://localhost:9000/flower_shop/flower_shop/frontend/main/order_online.php" class="btn btn-primary">Quay lại cửa hàng</a>
                </div>
            `);
            return;
        }

        // Order Info
        const paymentMethodNames = {
            'cod': '💵 Thanh toán khi nhận hàng',
            'momo': '📱 Ví Momo', 
            'zalopay': '📲 ZaloPay',
            'vnpay': '💳 VNPay',
            'transfer': '🏦 Chuyển khoản ngân hàng'
        };

        let infoHtml = `
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-receipt text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Mã Đơn Hàng</small>
                        <strong class="text-primary">#${orderData.orderId}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-user text-success"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Khách Hàng</small>
                        <strong>${orderData.customerName || orderData.fullName || 'N/A'}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-phone text-info"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Điện Thoại</small>
                        <strong>${orderData.customerPhone || orderData.phone || 'N/A'}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-map-marker-alt text-warning"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Địa Chỉ</small>
                        <strong class="text-truncate">${orderData.deliveryAddress || orderData.address || 'N/A'}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-secondary bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-credit-card text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Hình Thức TT</small>
                        <strong>${paymentMethodNames[orderData.paymentMethod] || orderData.paymentMethod}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-white rounded shadow-sm">
                    <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-money-bill-wave text-danger"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Tổng Tiền</small>
                        <strong class="text-danger fs-5">${formatCurrency(orderData.totalAmount)}</strong>
                    </div>
                </div>
            </div>
        `;
        $('#orderInfo').html(infoHtml);
    }

    function formatCurrency(amount) {
        if (!amount) return '0 ₫';
        return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
    }

    // Hiệu ứng confetti đơn giản
    function createConfetti() {
        const colors = ['#667eea', '#764ba2', '#4facfe', '#00f2fe', '#f093fb', '#f5576c'];
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: fixed;
                    width: 10px;
                    height: 10px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    border-radius: 50%;
                    top: -10px;
                    left: ${Math.random() * 100}vw;
                    animation: fall linear forwards;
                    z-index: 9999;
                `;
                
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes fall {
                        to {
                            transform: translateY(100vh) rotate(${Math.random() * 360}deg);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
                document.body.appendChild(confetti);
                
                setTimeout(() => confetti.remove(), 3000);
            }, i * 100);
        }
    }

    // Tự động chạy confetti khi trang load
    setTimeout(createConfetti, 1000);
    </script>
</body>
</html>