// assets/js/order.js - Logic đặt hoa online (HOÀN CHỈNH)
// Tác vụ: Load products, cart, form, checkout, thanh toán

const API_BASE = '../../api/order.php';

let allProducts = [];
let cart = [];

// ========== ĐỊNH DẠNG TIỀN TỆ ==========
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
}

// ========== KHỞI TẠO ==========
$(document).ready(function() {
  loadProducts();
  loadCartFromStorage();
});

// ========== LOAD PRODUCTS ==========
function loadProducts() {
  $.ajax({
    url: API_BASE + '?action=get_hoa',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        allProducts = response.data;
        displayProducts(allProducts);
      } else {
        showAlert('Lỗi: ' + response.message, 'error');
      }
    },
    error: function() {
      showAlert('Lỗi kết nối với server', 'error');
    }
  });
}

// ========== HIỂN THỊ DANH SÁCH SẢN PHẨM ==========
function displayProducts(products) {
  const container = $('#productContainer');
  container.empty();

  if (products.length === 0) {
    container.html('<div class="col-12"><p class="text-center text-muted">Không có sản phẩm nào</p></div>');
    return;
  }

  products.forEach(product => {
    const discount = product.Gia && product.Gia > 0 ? 
      Math.round(((product.Gia * 1.1 - product.Gia) / (product.Gia * 1.1)) * 100) : 0;

    const html = `
      <div class="col-6 col-sm-4 col-md-3 col-lg-2.4">
        <div class="product-card">
          <div class="product-image">
            <div style="font-size: 56px;">🌹</div>
            
            ${discount > 0 ? `
              <div class="discount-badge">
                <div class="minus">-</div>
                <div class="percent">${discount}%</div>
              </div>
            ` : ''}
            
            <div class="sale-badge">SALE</div>
            <div class="new-badge">NEW</div>
            <div class="freeship-badge">FREESHIP</div>
          </div>

          <div class="product-info">
            <div class="product-name">${product.TenHoa}</div>
            
            <div class="product-price">
              <div class="price-current">${formatCurrency(product.Gia)}</div>
              ${product.Gia ? `<div class="price-original">${formatCurrency(product.Gia * 1.1)}</div>` : ''}
            </div>

            <div class="quantity-control">
              <button onclick="changeQuantity(${product.MaHoa}, -1)">−</button>
              <input type="number" value="0" min="0" class="qty-input-${product.MaHoa}" readonly>
              <button onclick="changeQuantity(${product.MaHoa}, 1)">+</button>
            </div>

            <button class="btn-add-cart" onclick="addToCart(${product.MaHoa}, '${product.TenHoa.replace(/'/g, "\\'")}', ${product.Gia})">
              ĐẶT HÀNG
            </button>
          </div>
        </div>
      </div>
    `;
    container.append(html);
  });
}

// ========== THAY ĐỔI SỐ LƯỢNG ==========
function changeQuantity(productId, change) {
  const input = $(`.qty-input-${productId}`);
  let current = parseInt(input.val()) || 0;
  current = Math.max(0, current + change);
  input.val(current);
}

// ========== THÊM VÀO GIỎ HÀNG ==========
function addToCart(maHoa, tenHoa, gia) {
  const soLuong = parseInt($(`.qty-input-${maHoa}`).val()) || 0;

  if (soLuong <= 0) {
    showAlert('Vui lòng chọn số lượng', 'warning');
    return;
  }

  const existingItem = cart.find(item => item.ma_hoa == maHoa);
  
  if (existingItem) {
    existingItem.so_luong += soLuong;
  } else {
    cart.push({
      ma_hoa: maHoa,
      ten_hoa: tenHoa,
      gia: gia,
      so_luong: soLuong
    });
  }

  $(`.qty-input-${maHoa}`).val(0);
  updateCartDisplay();
  saveCartToStorage();
  showAlert(`Đã thêm ${tenHoa} vào giỏ hàng`, 'success');
}

// ========== XÓA KHỎI GIỎ HÀNG ==========
function removeFromCart(index) {
  cart.splice(index, 1);
  updateCartDisplay();
  saveCartToStorage();
}

// ========== CẬP NHẬT HIỂN THỊ GIỎ HÀNG ==========
function updateCartDisplay() {
  const container = $('#cartList');
  const totalPrice = $('#totalPrice');
  const checkoutBtn = $('#cartBtn');

  if (cart.length === 0) {
    container.html('<p class="text-muted text-center py-3">Giỏ hàng trống</p>');
    totalPrice.text('0');
    $('#cartBadge').hide();
    return;
  }

  let html = '';
  let total = 0;

  cart.forEach((item, index) => {
    const subtotal = item.gia * item.so_luong;
    total += subtotal;

    html += `
      <div class="d-flex justify-content-between align-items-start mb-3 pb-3" style="border-bottom: 1px solid #e0e0e0;">
        <div class="flex-grow-1">
          <strong style="font-size: 14px; color: #2d3748;">${item.ten_hoa}</strong>
          <div class="d-flex justify-content-between mt-2" style="font-size: 13px;">
            <small class="text-muted">${item.so_luong} x ${formatCurrency(item.gia)}</small>
            <strong style="color: #667eea;">${formatCurrency(subtotal)}</strong>
          </div>
        </div>
        <button class="btn btn-sm p-0 ms-2" onclick="removeFromCart(${index})">
          <i class="fas fa-trash text-danger"></i>
        </button>
      </div>
    `;
  });

  container.html(html);
  totalPrice.text(formatCurrency(total));
  updateCartBadge();
}

// ========== CẬP NHẬT BADGE SỐ SẢN PHẨM ==========
function updateCartBadge() {
  const badge = $('#cartBadge');
  if (cart.length > 0) {
    badge.text(cart.length).show();
  } else {
    badge.hide();
  }
}

// ========== XÓA TOÀN BỘ GIỎ HÀNG ==========
function clearCart() {
  if (confirm('Bạn chắc chắn muốn xóa tất cả sản phẩm trong giỏ?')) {
    cart = [];
    updateCartDisplay();
    saveCartToStorage();
    showAlert('Giỏ hàng đã được xóa', 'info');
  }
}

// ========== LƯU GIỎ HÀNG VÀO LOCALSTORAGE ==========
function saveCartToStorage() {
  localStorage.setItem('flower_cart', JSON.stringify(cart));
}

// ========== LOAD GIỎ HÀNG TỪ LOCALSTORAGE ==========
function loadCartFromStorage() {
  const saved = localStorage.getItem('flower_cart');
  if (saved) {
    cart = JSON.parse(saved);
    updateCartDisplay();
  }
}

// ========== ĐẶT NGÀY GIAO TỐI THIỂU ==========
function setMinDeliveryDate() {
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  const dateString = tomorrow.toISOString().split('T')[0];
  $('#deliveryDate').attr('min', dateString);
  $('#deliveryDate').val(dateString);
}

// ========== SUBMIT CHECKOUT - CHUYỂN SANG PAYMENT ==========
function submitCheckout() {
  const fullName = $('#fullName').val().trim();
  const phone = $('#phone').val().trim();
  const address = $('#address').val().trim();

  if (!fullName || !phone || !address) {
    showAlert('Vui lòng điền đầy đủ thông tin bắt buộc', 'warning');
    return;
  }

  if (cart.length === 0) {
    showAlert('Giỏ hàng trống', 'warning');
    return;
  }

  localStorage.setItem('checkout_form', JSON.stringify({
    fullName: fullName,
    email: $('#email').val().trim(),
    phone: phone,
    address: address,
    deliveryDate: $('#deliveryDate').val(),
    note: $('#note').val().trim()
  }));

  window.location.href = 'payment.php';
}

// ========== SUBMIT THANH TOÁN - TẠO ĐƠN HÀNG ==========
function submitPayment() {
  const paymentMethod = $('input[name="payment"]:checked').val();
  
  if (!paymentMethod) {
    showAlert('Vui lòng chọn hình thức thanh toán', 'warning');
    return;
  }

  const formData = JSON.parse(localStorage.getItem('checkout_form') || '{}');
  
  if (!formData.fullName) {
    showAlert('Vui lòng nhập thông tin khách hàng trước', 'warning');
    window.location.href = 'checkout.php';
    return;
  }

  const currentCart = JSON.parse(localStorage.getItem('flower_cart') || '[]');
  
  if (currentCart.length === 0) {
    showAlert('Giỏ hàng trống', 'warning');
    return;
  }

  const btn = $('#submitBtn');
  btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...');

  const orderData = {
    ten_khach: formData.fullName,
    email: formData.email,
    sdt: formData.phone,
    dia_chi: formData.address,
    ngay_giao: formData.deliveryDate,
    ghi_chu: formData.note,
    cart: currentCart
  };

  $.ajax({
    url: '../../api/order.php?action=create_order',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(orderData),
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        localStorage.setItem('order_success', JSON.stringify({
          orderId: response.ma_don_hang,
          totalAmount: response.tong_tien,
          paymentMethod: paymentMethod,
          ...formData
        }));

        localStorage.removeItem('flower_cart');
        localStorage.removeItem('checkout_form');

        window.location.href = 'success.php';
      } else {
        showAlert('Lỗi: ' + response.message, 'error');
        btn.prop('disabled', false).html('<i class="fas fa-check"></i> Xác Nhận Đặt Hàng');
      }
    },
    error: function() {
      showAlert('Lỗi kết nối với server', 'error');
      btn.prop('disabled', false).html('<i class="fas fa-check"></i> Xác Nhận Đặt Hàng');
    }
  });
}

// ========== CHUYỂN SANG PAYMENT PAGE ==========
function goToCheckout() {
  if (cart.length === 0) {
    showAlert('Giỏ hàng trống', 'warning');
    return;
  }
  window.location.href = 'checkout.php';
}

// ========== HIỂN THỊ ALERT ==========
function showAlert(message, type = 'info') {
  const alertClass = {
    'success': 'alert-success',
    'error': 'alert-danger',
    'warning': 'alert-warning',
    'info': 'alert-info'
  };

  const alertHtml = `
    <div class="alert ${alertClass[type] || 'alert-info'} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;

  $('body').append(alertHtml);

  setTimeout(() => {
    $('.alert').fadeOut(300, function() {
      $(this).remove();
    });
  }, 3000);
}