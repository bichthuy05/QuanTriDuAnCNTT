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
            --primary: #d6a4f3;
            --primary-light: #e8c5ff;
            --primary-dark: #c18be0;
            --accent: #f3ccff;
            --light: #faf5ff;
            --dark: #4a2c5f;
            --success: #b983f5;
            --danger: #f28baf;
            --text: #5a3d6e;
            --border: #e9d5ff;
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
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .brand-logo-beautiful {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
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
            box-shadow: 0 4px 12px rgba(214, 164, 243, 0.3);
        }
        
        .cart-icon-beautiful:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(214, 164, 243, 0.4);
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
            border: 1px solid var(--primary-light);
        }
        
        /* HERO SECTION */
        .hero-section-beautiful {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section-beautiful::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: cover;
        }
        
        .page-title-beautiful {
            font-size: 3.2rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .page-subtitle-beautiful {
            font-size: 1.3rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            font-weight: 300;
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
            box-shadow: 0 15px 30px rgba(214, 164, 243, 0.2);
        }
        
        .product-image-beautiful {
            height: 240px;
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
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
        
        .product-image-beautiful::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background: linear-gradient(to top, rgba(255,255,255,0.7), transparent);
        }
        
        .product-image-placeholder {
            font-size: 4.5rem;
            color: var(--primary);
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
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
            color: var(--dark);
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
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 164, 243, 0.4);
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
            color: var(--dark);
            border-bottom: none;
            padding: 1.8rem;
        }
        
        .cart-modal-beautiful .modal-title {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .cart-modal-beautiful .btn-close {
            filter: brightness(0) invert(0.2);
            opacity: 0.8;
        }
        
        .cart-modal-beautiful .btn-close:hover {
            opacity: 1;
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
        
        .cart-empty-beautiful i {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: #ddd;
        }
        
        .cart-item-beautiful {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            border-bottom: 1px solid var(--border);
            transition: background-color 0.2s;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #fcfaf8;
        }
        
        .cart-item-beautiful:hover {
            background-color: #f8f5f2;
        }
        
        .cart-item-image-beautiful {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.2rem;
            overflow: hidden;
        }
        
        .cart-item-image-beautiful img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        
        .cart-item-meta-beautiful {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
            color: #666;
        }
        
        .cart-summary-beautiful {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
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
            font-size: 1.2rem;
        }
        
        .summary-row-beautiful {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.9rem;
            font-size: 1rem;
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
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        
        .btn-clear-cart-beautiful {
            background-color: transparent;
            color: var(--danger);
            border: 2px solid var(--danger);
            border-radius: 8px;
            padding: 0.9rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-clear-cart-beautiful:hover {
            background-color: var(--danger);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-checkout-beautiful {
            background: linear-gradient(135deg, var(--success) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.9rem 1.8rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }
        
        .btn-checkout-beautiful:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(185, 131, 245, 0.4);
        }
        
        .btn-checkout-beautiful:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .page-title-beautiful {
                font-size: 2.5rem;
            }
            
            .page-subtitle-beautiful {
                font-size: 1.1rem;
            }
            
            .cart-modal-beautiful .modal-footer {
                flex-direction: column;
            }
            
            .btn-clear-cart-beautiful,
            .btn-checkout-beautiful {
                width: 100%;
                justify-content: center;
            }
            
            .hero-section-beautiful {
                padding: 80px 0 60px;
            }
            
            .products-grid-beautiful {
                padding: 60px 0;
            }
        }
        
        /* Animation for cart badge */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .cart-badge-beautiful.pulse {
            animation: pulse 0.5s ease-in-out;
        }
        
        /* Custom scrollbar */
        .cart-modal-beautiful .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-modal-beautiful .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .cart-modal-beautiful .modal-body::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }
        
        .cart-modal-beautiful .modal-body::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body class="order-online-body">
    <!-- HEADER MỚI -->
    <header class="order-header sticky-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="brand-logo-beautiful">
                    <i class="fas fa-spa"></i> Flower'Lna
                </div>
                
                <!-- Cart Icon -->
                <button class="cart-icon-beautiful" id="cartBtn" onclick="openCartModal()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge-beautiful" id="cartBadge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION MỚI -->
    <section class="hero-section-beautiful">
        <div class="container">
            <h1 class="page-title-beautiful">Đặt Hoa Online</h1>
            <p class="page-subtitle-beautiful">Chọn bó hoa yêu thích - Trao gửi yêu thương</p>
        </div>
    </section>

    <!-- PRODUCTS GRID MỚI -->
    <section class="products-grid-beautiful">
        <div class="container">
            <div class="row g-4" id="productContainer">
                <!-- Products will load here from JS -->
            </div>
        </div>
    </section>

    <!-- CART MODAL MỚI -->
    <div class="modal fade cart-modal-beautiful" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng Của Bạn</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
    // Dữ liệu mẫu cho sản phẩm với hình ảnh
    const sampleFlowers = [
        {
            MaHoa: 1,
            TenHoa: "Hoa Hồng Đỏ",
            Gia: 250000,
            MoTa: "Hoa hồng đỏ tượng trưng cho tình yêu nồng cháy và lãng mạn. Món quà hoàn hảo cho các dịp đặc biệt.",
            HinhAnh: "../../assets/images/hong_do.jpg",
            TenLoai: "Hoa Hồng"
        },
        {
            MaHoa: 2,
            TenHoa: "Hoa Cúc Trắng",
            Gia: 180000,
            MoTa: "Hoa cúc trắng tượng trưng cho sự thuần khiết và thanh cao. Thích hợp để trang trí hoặc làm quà tặng.",
            HinhAnh: "../../assets/images/cuc_trang.jpg",
            TenLoai: "Hoa Cúc"
        },
        {
            MaHoa: 3,
            TenHoa: "Hoa Tulip Hồng",
            Gia: 220000,
            MoTa: "Hoa tulip hồng mang ý nghĩa của sự dịu dàng và hạnh phúc. Tỏa sáng trong mọi không gian.",
            HinhAnh: "../../assets/images/hoa-tulip-hong.jpg",
            TenLoai: "Hoa Tulip"
        },
        {
            MaHoa: 4,
            TenHoa: "Hoa Lan Tím",
            Gia: 350000,
            MoTa: "Hoa lan tím tượng trưng cho sự sang trọng và quý phái. Lựa chọn hoàn hảo cho những dịp trang trọng.",
            HinhAnh: "../../assets/images/hoa-lan-tim.jpg",
            TenLoai: "Hoa Lan"
        },
        {
            MaHoa: 5,
            TenHoa: "Hoa Hướng Dương",
            Gia: 200000,
            MoTa: "Hoa hướng dương tượng trưng cho sự lạc quan và niềm tin vào tương lai. Mang đến năng lượng tích cực.",
            HinhAnh: "../../assets/images/hoa-huong-duong.jpg",
            TenLoai: "Hoa Hướng Dương"
        },
        {
            MaHoa: 6,
            TenHoa: "Hoa Ly Trắng",
            Gia: 280000,
            MoTa: "Hoa ly trắng tượng trưng cho sự trong trắng và thuần khiết. Hương thơm nhẹ nhàng, quyến rũ.",
            HinhAnh: "../../assets/images/hoa-ly-trang.jpg",
            TenLoai: "Hoa Ly"
        }
    ];

    // Giỏ hàng
    let cart = [];

    $(document).ready(function() {
        loadProducts();
        loadCartFromStorage();
    });

    function loadProducts() {
        const container = $('#productContainer');
        let html = '';

        sampleFlowers.forEach(flower => {
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="product-card-beautiful">
                        <div class="product-image-beautiful">
                            ${flower.HinhAnh ? 
                                `<img src="${flower.HinhAnh}" alt="${flower.TenHoa}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">` : 
                                ''
                            }
                            <div class="product-image-placeholder" style="${flower.HinhAnh ? 'display:none;' : ''}">
                                <i class="fas fa-flower"></i>
                            </div>
                        </div>
                        <div class="product-info-beautiful">
                            <div class="product-category-beautiful">${flower.TenLoai}</div>
                            <h3 class="product-name-beautiful">${flower.TenHoa}</h3>
                            <p class="product-description-beautiful">${flower.MoTa}</p>
                            <div class="product-price-beautiful">${formatCurrency(flower.Gia)}₫</div>
                            <button class="btn-add-to-cart-beautiful" onclick="addToCart(${flower.MaHoa}, '${flower.TenHoa}', ${flower.Gia}, '${flower.HinhAnh}')">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        container.html(html);
    }

    function addToCart(maHoa, tenHoa, gia, hinhAnh) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
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
        
        // Hiển thị thông báo
        showNotification(`Đã thêm "${tenHoa}" vào giỏ hàng`);
        
        // Hiệu ứng pulse cho badge
        const badge = $('#cartBadge');
        badge.addClass('pulse');
        setTimeout(() => {
            badge.removeClass('pulse');
        }, 500);
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
            showNotification('Đã xóa giỏ hàng');
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

            html += `
                <div class="cart-item-beautiful">
                    <div class="cart-item-image-beautiful">
                        ${item.hinh_anh ? 
                            `<img src="${item.hinh_anh}" alt="${item.ten_hoa}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">` : 
                            ''
                        }
                        <div class="cart-item-image-placeholder" style="${item.hinh_anh ? 'display:none;' : ''}">
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
                    <button class="btn btn-sm ms-2" onclick="removeFromCart(${index})" style="background: rgba(242, 139, 175, 0.1); color: #f28baf; border: none; border-radius: 6px; width: 30px; height: 30px;">
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
                    <div class="toast-header" style="background-color: var(--success); color: white;">
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
        // Chuyển hướng đến trang checkout.php
        window.location.href = 'checkout.php';
    }
    </script>
</body>
</html>