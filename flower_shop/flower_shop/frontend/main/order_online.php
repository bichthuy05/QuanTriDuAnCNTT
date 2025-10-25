<?php
// frontend/main/order_online.php - Trang danh sách sản phẩm
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hoa Online - Flower'Lna</title>
    
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        /* HEADER */
        .order-header {
            background-color: white;
            box-shadow: 0 2px 20px rgba(176, 140, 58, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .brand-logo-beautiful {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #b08c3a; /* Giữ nguyên màu logo */
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-icon-beautiful {
            background-color: white;
            border: 2px solid var(--primary);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(176, 140, 58, 0.3);
        }
        
        .cart-icon-beautiful:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(176, 140, 58, 0.4);
        }
        
        .cart-icon-beautiful:hover i {
            color: white;
        }
        
        .cart-icon-beautiful i {
            color: var(--primary);
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        
        .cart-badge-beautiful {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent);
            color: var(--dark);
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        /* MENU - THÊM MỚI */
        .navbar-custom {
            background-color: #fff8f0 !important;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 0.5rem 0;
        }

        .navbar-nav .nav-link-custom {
            color: #3b2d1f !important;
            font-weight: 500;
            font-size: 16px;
            margin: 0 10px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.8rem 1rem;
        }

        .navbar-nav .nav-link-custom:hover {
            color: #b08c3a !important;
        }
        
        /* HERO SECTION - ĐÃ CẬP NHẬT */
        .hero-section-beautiful {
            position: relative;
            background: url('https://plus.unsplash.com/premium_photo-1675712535056-fc6fa6aee8ec?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1169') center/cover no-repeat;
            height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-section-beautiful::after {
            content: "";
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }
        
        .banner-content-beautiful {
            position: relative;
            z-index: 2;
        }
        
        .page-title-beautiful {
            font-size: 3.2rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .page-subtitle-beautiful {
            font-size: 1.3rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            font-weight: 300;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }
        
        /* PRODUCTS GRID */
        .products-grid-beautiful {
            padding: 80px 0;
        }
        
        .product-card-beautiful {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border);
        }
        
        .product-card-beautiful:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(176, 140, 58, 0.2);
        }
        
        .product-image-beautiful {
            height: 240px;
            background: linear-gradient(135deg, var(--light) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        .product-image-beautiful img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card-beautiful:hover .product-image-beautiful img {
            transform: scale(1.05);
        }
        
        .product-image-placeholder {
            font-size: 4.5rem;
            color: var(--primary);
        }
        
        .product-info-beautiful {
            padding: 1.8rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-category-beautiful {
            font-size: 0.85rem;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }
        
        .product-name-beautiful {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: var(--dark);
            line-height: 1.3;
        }
        
        .product-description-beautiful {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            line-height: 1.5;
        }
        
        .product-price-beautiful {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }
        
        .btn-add-to-cart-beautiful {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1rem;
        }
        
        .btn-add-to-cart-beautiful:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(176, 140, 58, 0.4);
        }
        
        /* CART MODAL */
        .cart-modal-beautiful .modal-content {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        .cart-modal-beautiful .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-bottom: none;
            padding: 1.8rem;
        }
        
        .cart-modal-beautiful .modal-body {
            padding: 1.8rem;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .cart-empty-beautiful {
            text-align: center;
            padding: 3rem 1rem;
            color: #888;
        }
        
        .cart-item-beautiful {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            border-bottom: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #fcfaf8;
        }
        
        .cart-item-image-beautiful {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--light) 0%, var(--accent) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.2rem;
            overflow: hidden;
        }
        
        .cart-item-image-placeholder {
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .cart-item-details-beautiful {
            flex-grow: 1;
        }
        
        .cart-item-name-beautiful {
            font-weight: 600;
            margin-bottom: 0.4rem;
            font-size: 1.1rem;
            color: var(--dark);
        }
        
        .cart-summary-beautiful {
            background: linear-gradient(135deg, var(--light) 0%, var(--accent) 100%);
            border-radius: 12px;
            padding: 1.8rem;
            margin-top: 1.8rem;
            border: 1px solid var(--border);
        }
        
        .summary-title-beautiful {
            font-weight: 600;
            margin-bottom: 1.2rem;
            color: var(--dark);
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.8rem;
        }
        
        .summary-row-beautiful {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.9rem;
        }
        
        .summary-total-beautiful {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-dark);
            border-top: 1px solid var(--border);
            padding-top: 0.9rem;
            margin-top: 0.7rem;
        }
        
        .cart-modal-beautiful .modal-footer {
            border-top: 1px solid var(--border);
            padding: 1.8rem;
        }
        
        .btn-clear-cart-beautiful {
            background-color: transparent;
            color: #8b4513;
            border: 2px solid #8b4513;
            border-radius: 8px;
            padding: 0.9rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-clear-cart-beautiful:hover {
            background-color: #8b4513;
            color: white;
        }
        
        .btn-checkout-beautiful {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.8rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-checkout-beautiful:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(176, 140, 58, 0.4);
        }

        @media (max-width: 768px) {
            .page-title-beautiful {
                font-size: 2.5rem;
            }
            
            .page-subtitle-beautiful {
                font-size: 1.1rem;
            }
            
            .hero-section-beautiful {
                height: 400px;
                padding: 60px 0;
            }
            
            .products-grid-beautiful {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="order-header sticky-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="brand-logo-beautiful">
                    🌸 Flower'Lna
                </div>
           
                <!-- Cart Icon -->
                <button class="cart-icon-beautiful" id="cartBtn" onclick="openCartModal()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge-beautiful" id="cartBadge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- MENU - THÊM MỚI -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="../../index.html">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom active" href="order_online.php">Bộ sưu tập</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="contact.php">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="../../about.html">Giới Thiệu</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION - ĐÃ CẬP NHẬT -->
    <section class="hero-section-beautiful">
        <div class="banner-content-beautiful">
            <h1 class="page-title-beautiful">Đặt Hoa Online</h1>
            <p class="page-subtitle-beautiful">Chọn bó hoa yêu thích - Trao gửi yêu thương</p>
        </div>
    </section>

    <!-- PRODUCTS GRID -->
    <section class="products-grid-beautiful">
        <div class="container">
            <div class="row g-4" id="productContainer">
                <!-- Products will load here from JS -->
            </div>
        </div>
    </section>

    <!-- CART MODAL -->
    <div class="modal fade cart-modal-beautiful" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng Của Bạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div id="cartList">
                        <div class="cart-empty-beautiful">
                            <i class="fas fa-shopping-cart"></i>
                            <p class="mt-3">Giỏ hàng của bạn đang trống</p>
                        </div>
                    </div>

                    <div id="cartSummary" style="display: none;">
                        <div class="cart-summary-beautiful">
                            <h6 class="summary-title-beautiful">Tổng Thanh Toán</h6>
                            <div class="summary-row-beautiful">
                                <span>Tạm tính:</span>
                                <span id="subtotal">0₫</span>
                            </div>
                            <div class="summary-row-beautiful">
                                <span>VAT (10%):</span>
                                <span id="vat">0₫</span>
                            </div>
                            <div class="summary-row-beautiful summary-total-beautiful">
                                <span>Tổng cộng:</span>
                                <span id="totalPrice">0₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-clear-cart-beautiful" onclick="clearCart()">
                        <i class="fas fa-trash me-2"></i> Xóa Giỏ
                    </button>
                    <button type="button" class="btn-checkout-beautiful" id="checkoutBtn" onclick="goToCheckout()" disabled>
                        <i class="fas fa-lock me-2"></i> Thanh Toán
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Giỏ hàng
    let cart = [];

    $(document).ready(function() {
        loadProducts();
        loadCartFromStorage();
    });

    function loadProducts() {
        const container = $('#productContainer');
        
        // Hiển thị loading
        container.html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Đang tải sản phẩm...</p>
            </div>
        `);

        // Gọi API để lấy dữ liệu từ database
        $.ajax({
            url: '../../api/order.php?action=get_hoa',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    displayProducts(response.data);
                } else {
                    container.html(`
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                            <p class="text-muted">${response.message || 'Có lỗi xảy ra khi tải sản phẩm'}</p>
                            <button class="btn btn-primary" onclick="loadProducts()">Thử lại</button>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi gọi API:', error);
                container.html(`
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                        <p class="text-muted">Không thể kết nối đến server</p>
                        <button class="btn btn-primary" onclick="loadProducts()">Thử lại</button>
                    </div>
                `);
            }
        });
    }

    function displayProducts(products) {
    const container = $('#productContainer');
    let html = '';

    if (products.length === 0) {
        html = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-flower fa-3x text-muted mb-3"></i>
                <p class="text-muted">Không có sản phẩm nào</p>
            </div>
        `;
    } else {
        products.forEach(flower => {
            const imagePath = flower.HinhAnh ? 
                `../../assets/img/${flower.HinhAnh}` : 
                '';
            
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="product-card-beautiful">
                        <div class="product-image-beautiful">
                            ${imagePath ? 
                                `<img src="${imagePath}" alt="${flower.TenHoa}" onerror="handleImageError(this)">` : 
                                ''
                            }
                            <div class="product-image-placeholder" style="${imagePath ? 'display:none;' : ''}">
                                <i class="fas fa-flower"></i>
                            </div>
                        </div>
                        <div class="product-info-beautiful">
                            <div class="product-category-beautiful">${flower.TenLoai || 'Hoa'}</div>
                            <h3 class="product-name-beautiful">${flower.TenHoa}</h3>
                            <p class="product-description-beautiful">${flower.MoTa || 'Sản phẩm chất lượng cao'}</p>
                            <div class="product-price-beautiful">${formatCurrency(flower.Gia)}₫</div>
                            <button class="btn-add-to-cart-beautiful" onclick="addToCart(${flower.MaHoa}, '${flower.TenHoa.replace(/'/g, "\\'")}', ${flower.Gia}, '${imagePath}')">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    container.html(html);
}

    // Thêm hàm xử lý lỗi ảnh
    function handleImageError(img) {
        console.log('Image failed to load:', img.src);
        img.style.display = 'none';
        const placeholder = document.createElement('div');
        placeholder.className = 'product-image-placeholder';
        placeholder.innerHTML = '<i class="fas fa-flower"></i>';
        img.parentNode.appendChild(placeholder);
    }


    function addToCart(maHoa, tenHoa, gia, hinhAnh) {
        const existingItem = cart.find(item => item.ma_hoa === maHoa);
        
        if (existingItem) {
            existingItem.so_luong += 1;
        } else {
            cart.push({
                ma_hoa: maHoa,
                ten_hoa: tenHoa,
                gia: gia,
                so_luong: 1,
                hinh_anh: hinhAnh
            });
        }
        
        saveCartToStorage();
        updateCartDisplay();
        showNotification(`Đã thêm "${tenHoa}" vào giỏ hàng`);
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        saveCartToStorage();
        updateCartDisplay();
    }

    function clearCart() {
        if (cart.length === 0) return;
        
        if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
            cart = [];
            saveCartToStorage();
            updateCartDisplay();
        }
    }

    function saveCartToStorage() {
        localStorage.setItem('flower_cart', JSON.stringify(cart));
    }

    function loadCartFromStorage() {
        const savedCart = localStorage.getItem('flower_cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            updateCartDisplay();
        }
    }

    function updateCartDisplay() {
        const container = $('#cartList');
        const summaryContainer = $('#cartSummary');
        const checkoutBtn = $('#checkoutBtn');

        if (cart.length === 0) {
            container.html(`
                <div class="cart-empty-beautiful">
                    <i class="fas fa-shopping-cart"></i>
                    <p class="mt-3">Giỏ hàng của bạn đang trống</p>
                </div>
            `);
            summaryContainer.hide();
            checkoutBtn.prop('disabled', true);
            updateCartBadge();
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.gia * item.so_luong;
            total += subtotal;

            // ĐƯỜNG DẪN CHO GIỎ HÀNG
            const cartImagePath = item.hinh_anh ? 
                `../../assets/img/${item.hinh_anh}` : 
                '';

            html += `
                <div class="cart-item-beautiful">
                    <div class="cart-item-image-beautiful">
                        ${cartImagePath ? 
                            `<img src="${cartImagePath}" alt="${item.ten_hoa}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">` : 
                            ''
                        }
                        <div class="cart-item-image-placeholder" style="${cartImagePath ? 'display:none;' : ''}">
                            <i class="fas fa-flower"></i>
                        </div>
                    </div>
                    <div class="cart-item-details-beautiful">
                        <div class="cart-item-name-beautiful">${item.ten_hoa}</div>
                        <div class="cart-item-meta-beautiful">
                            <span class="cart-item-quantity-beautiful">${item.so_luong} x ${formatCurrency(item.gia)}₫</span>
                            <span class="cart-item-price-beautiful">${formatCurrency(subtotal)}₫</span>
                        </div>
                    </div>
                    <button class="btn btn-sm ms-2" onclick="removeFromCart(${index})" style="background: transparent; color: #8b4513; border: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        });

        container.html(html);
        summaryContainer.show();

        const vat = Math.round(total * 0.1);
        const totalWithVAT = total + vat;

        $('#subtotal').text(formatCurrency(total) + '₫');
        $('#vat').text(formatCurrency(vat) + '₫');
        $('#totalPrice').text(formatCurrency(totalWithVAT) + '₫');

        checkoutBtn.prop('disabled', false);
        updateCartBadge();
    }

    function updateCartBadge() {
        const badge = $('#cartBadge');
        if (cart.length > 0) {
            badge.text(cart.length).show();
        } else {
            badge.hide();
        }
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount);
    }

    function openCartModal() {
        const modal = new bootstrap.Modal(document.getElementById('cartModal'));
        updateCartDisplay();
        modal.show();
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
        
        // Tự động xóa thông báo sau 3 giây
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function goToCheckout() {
        if (cart.length === 0) {
            alert('Giỏ hàng của bạn đang trống!');
            return;
        }
        window.location.href = 'checkout.php';
    }
</script>
</body>
</html>
