// API URLs
const API_ORDER = '../../api/donhang.php';
const API_CUSTOMER = '../../api/khachhang.php';

// Biến global
let allOrders = [];
let allCustomers = [];

// Document Ready
$(document).ready(function() {
    loadOrders();
    loadCustomers();
    
    // Event Listeners
    $('#filterStatus').on('change', filterOrders);
    $('#searchInput').on('keyup', filterOrders);
    $('#selectKhachHang').on('change', onCustomerSelect);
    $('#btnSaveOrder').on('click', saveOrder);
    $('#btnConfirmUpdate').on('click', confirmUpdateStatus);
    
    // Reset form khi đóng modal
    $('#modalDonHang').on('hidden.bs.modal', function() {
        resetForm();
    });
});

// Load danh sách đơn hàng
function loadOrders() {
    $.ajax({
        url: API_ORDER,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Kiểm tra xem response có phải là array không (từ donhang.php)
            if(Array.isArray(response)) {
                allOrders = response;
                displayOrders(response);
                updateStatistics(response);
            } else if(response.success) {
                allOrders = response.data;
                displayOrders(response.data);
                updateStatistics(response.data);
            } else {
                showAlert('danger', response.message || 'Không thể tải dữ liệu');
            }
        },
        error: function(xhr, status, error) {
            showAlert('danger', 'Lỗi kết nối API: ' + error);
            $('#orderTableBody').html(`
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Không thể tải dữ liệu
                    </td>
                </tr>
            `);
        }
    });
}

// Load danh sách khách hàng cho select
function loadCustomers() {
    $.ajax({
        url: API_CUSTOMER,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                allCustomers = response.data;
                populateCustomerSelect(response.data);
            }
        }
    });
}

// Điền dữ liệu vào select khách hàng
function populateCustomerSelect(customers) {
    const select = $('#selectKhachHang');
    select.html('<option value="">-- Chọn khách hàng --</option>');
    
    customers.forEach(function(customer) {
        select.append(`
            <option value="${customer.MaKhachHang}" 
                    data-name="${customer.TenKhachHang}"
                    data-phone="${customer.SoDienThoai}"
                    data-address="${customer.DiaChi || ''}">
                ${customer.TenKhachHang} - ${customer.SoDienThoai}
            </option>
        `);
    });
}

// Khi chọn khách hàng từ select
function onCustomerSelect() {
    const selectedOption = $('#selectKhachHang option:selected');
    
    if(selectedOption.val()) {
        $('#tenKhachHang').val(selectedOption.data('name'));
        $('#soDienThoai').val(selectedOption.data('phone'));
        $('#diaChiGiao').val(selectedOption.data('address'));
    } else {
        $('#tenKhachHang').val('');
        $('#soDienThoai').val('');
        $('#diaChiGiao').val('');
    }
}

// Hiển thị danh sách đơn hàng - ĐÃ SỬA LỖI
function displayOrders(orders) {
    const tbody = $('#orderTableBody');
    
    if(orders.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="8" class="text-center text-muted">
                    <i class="fas fa-inbox"></i> Chưa có đơn hàng nào
                </td>
            </tr>
        `);
        $('#totalOrders').text(0);
        return;
    }
    
    let html = '';
    orders.forEach(function(order) {
        const badgeClass = getStatusBadgeClass(order.TrangThai);
        
        html += `
            <tr>
                <td><span class="order-code">#${order.MaDonHang}</span></td>
                <td><strong>${order.TenKhachHang}</strong></td>
                <td>
                    <i class="fas fa-phone text-success"></i> ${order.SoDienThoai}
                </td>
                <td>
                    <small>${truncateText(order.DiaChi, 40)}</small>
                </td>
                <td class="text-end">
                    <strong>${formatMoney(order.TongTien)}</strong>
                </td>
                <td class="text-center">
                    <span class="badge-status ${badgeClass}">
                        ${order.TrangThai}
                    </span>
                </td>
                <td><small>${formatDateTime(order.NgayDat)}</small></td>
                <td class="text-center action-btns">
                    <button class="btn btn-sm btn-info" onclick="viewOrder(${order.MaDonHang})" 
                            title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" onclick="updateStatus(${order.MaDonHang}, '${order.MaDonHang}', '${order.TrangThai}')" 
                            title="Cập nhật trạng thái">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    ${order.TrangThai === 'Chờ xử lý' || order.TrangThai === 'Đã hủy' ? 
                        `<button class="btn btn-sm btn-danger" onclick="deleteOrder(${order.MaDonHang})" title="Xóa">
                            <i class="fas fa-trash"></i>
                        </button>` : ''}
                </td>
            </tr>
        `;
    });
    
    tbody.html(html);
    $('#totalOrders').text(orders.length); // ĐÃ SỬA - đóng ngoặc đúng
}

// Update statistics
function updateStatistics(orders) {
    const stats = {
        'Chờ xử lý': 0,
        'Đang xử lý': 0,
        'Đang giao': 0,
        'Đã giao': 0,
        'Đã hủy': 0
    };
    
    orders.forEach(function(order) {
        if(stats.hasOwnProperty(order.TrangThai)) {
            stats[order.TrangThai]++;
        }
    });
    
    $('#statPending').text(stats['Chờ xử lý']);
    $('#statProcessing').text(stats['Đang xử lý']);
    $('#statShipping').text(stats['Đang giao']);
    $('#statCompleted').text(stats['Đã giao']);
    $('#statCancelled').text(stats['Đã hủy']);
}

// Filter orders
function filterOrders() {
    const status = $('#filterStatus').val();
    const keyword = $('#searchInput').val().toLowerCase().trim();
    
    let filtered = allOrders;
    
    // Filter by status
    if(status) {
        filtered = filtered.filter(order => order.TrangThai === status);
    }
    
    // Filter by keyword
    if(keyword) {
        filtered = filtered.filter(function(order) {
            return order.MaDonHang.toString().includes(keyword) ||
                   order.TenKhachHang.toLowerCase().includes(keyword) ||
                   (order.SoDienThoai && order.SoDienThoai.includes(keyword));
        });
    }
    
    displayOrders(filtered);
}

// Reset form
function resetForm() {
    $('#formDonHang')[0].reset();
    $('#orderId').val('');
    $('#selectKhachHang').val('');
    $('#modalTitle').html('<i class="fas fa-plus-circle"></i> Tạo Đơn hàng mới');
}

// Get status badge class
function getStatusBadgeClass(status) {
    const badges = {
        'Chờ xử lý': 'badge-warning',
        'Đang xử lý': 'badge-info',
        'Đang giao': 'badge-primary',
        'Đã giao': 'badge-success',
        'Đã hủy': 'badge-danger'
    };
    return badges[status] || 'badge-secondary';
}

// Format money
function formatMoney(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Truncate text
function truncateText(text, length) {
    if(!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
}

// Format DateTime
function formatDateTime(datetime) {
    if(!datetime) return '';
    
    const date = new Date(datetime);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

// Format Date
function formatDate(dateStr) {
    if(!dateStr) return '';
    
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    
    return `${day}/${month}/${year}`;
}

// View order details
function viewOrder(id) {
    $.ajax({
        url: API_ORDER + '?MaDonHang=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success || response.MaDonHang) {
                const order = response.success ? response.data : response;
                const badgeClass = getStatusBadgeClass(order.TrangThai);
                
                let details = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-invoice"></i> Thông tin Đơn hàng
                            </h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Mã đơn hàng</th>
                                    <td><strong class="order-code">#${order.MaDonHang}</strong></td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt</th>
                                    <td>${formatDate(order.NgayDat)}</td>
                                </tr>
                                <tr>
                                    <th>Ngày giao</th>
                                    <td>${order.NgayGiao ? formatDate(order.NgayGiao) : '<em class="text-muted">Chưa xác định</em>'}</td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền</th>
                                    <td><strong class="text-success">${formatMoney(order.TongTien)}</strong></td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td><span class="badge ${badgeClass}">${order.TrangThai}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-user"></i> Thông tin Khách hàng
                            </h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Tên khách hàng</th>
                                    <td>${order.TenKhachHang}</td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại</th>
                                    <td><i class="fas fa-phone text-success"></i> ${order.SoDienThoai}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>${order.Email || '<em class="text-muted">Chưa có</em>'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;
                
                showModal('Chi tiết Đơn hàng', details);
            }
        }
    });
}

// Các hàm còn lại giữ nguyên...
// (updateStatus, confirmUpdateStatus, saveOrder, deleteOrder, showAlert, showModal)