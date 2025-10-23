// API URL
const API_URL = '../../api/khachhang.php';

// Biến global
let isEditMode = false;
let allCustomers = [];

// Document Ready
$(document).ready(function() {
    loadCustomers();
    
    // Event Listeners
    $('#searchInput').on('keyup', searchCustomers);
    $('#btnSave').on('click', saveCustomer);
    
    // Reset form khi đóng modal
    $('#modalKhachHang').on('hidden.bs.modal', function() {
        resetForm();
    });
});

// Load danh sách khách hàng
function loadCustomers() {
    $.ajax({
        url: API_URL,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                allCustomers = response.data;
                displayCustomers(response.data);
                $('#totalCustomers').text(response.data.length);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            showAlert('danger', 'Lỗi kết nối API: ' + error);
            $('#customerTableBody').html(`
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Không thể tải dữ liệu
                    </td>
                </tr>
            `);
        }
    });
}

// Hiển thị danh sách khách hàng
function displayCustomers(customers) {
    const tbody = $('#customerTableBody');
    
    if(customers.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="6" class="text-center text-muted">
                    <i class="fas fa-inbox"></i> Chưa có khách hàng nào
                </td>
            </tr>
        `);
        return;
    }
    
    let html = '';
    customers.forEach(function(customer) {
        html += `
            <tr>
                <td>${customer.MaKhachHang}</td>
                <td><strong>${customer.TenKhachHang}</strong></td>
                <td>
                    <i class="fas fa-phone text-success"></i> ${customer.SoDienThoai}
                </td>
                <td>${customer.Email || '<em class="text-muted">Chưa có</em>'}</td>
                <td>${customer.DiaChi || '<em class="text-muted">Chưa có</em>'}</td>
                <td class="text-center action-btns">
                    <button class="btn btn-sm btn-info" onclick="viewCustomer(${customer.MaKhachHang})" 
                            title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" onclick="editCustomer(${customer.MaKhachHang})" 
                            title="Sửa">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteCustomer(${customer.MaKhachHang})" 
                            title="Xóa">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.html(html);
}

// Tìm kiếm khách hàng
function searchCustomers() {
    const keyword = $('#searchInput').val().toLowerCase().trim();
    
    if(keyword === '') {
        displayCustomers(allCustomers);
        $('#totalCustomers').text(allCustomers.length);
        return;
    }
    
    const filtered = allCustomers.filter(function(customer) {
        return customer.TenKhachHang.toLowerCase().includes(keyword) ||
               customer.SoDienThoai.includes(keyword) ||
               (customer.Email && customer.Email.toLowerCase().includes(keyword));
    });
    
    displayCustomers(filtered);
    $('#totalCustomers').text(filtered.length);
}

// Reset form
function resetForm() {
    $('#formKhachHang')[0].reset();
    $('#customerId').val('');
    $('#modalTitle').html('<i class="fas fa-user-plus"></i> Thêm Khách hàng');
    isEditMode = false;
}

// Xem chi tiết khách hàng
function viewCustomer(id) {
    $.ajax({
        url: API_URL + '?MaKhachHang=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                const customer = response.data;
                
                let details = `
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Mã khách hàng</th>
                            <td><strong>#${customer.MaKhachHang}</strong></td>
                        </tr>
                        <tr>
                            <th>Tên khách hàng</th>
                            <td>${customer.TenKhachHang}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td><i class="fas fa-phone text-success"></i> ${customer.SoDienThoai}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>${customer.Email || '<em class="text-muted">Chưa cập nhật</em>'}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td>${customer.DiaChi || '<em class="text-muted">Chưa cập nhật</em>'}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>${formatDateTime(customer.NgayTao)}</td>
                        </tr>
                    </table>
                `;
                
                showModal('Chi tiết Khách hàng', details);
            }
        }
    });
}

// Sửa khách hàng
function editCustomer(id) {
    $.ajax({
        url: API_URL + '?MaKhachHang=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                const customer = response.data;
                
                $('#customerId').val(customer.MaKhachHang);
                $('#tenKhachHang').val(customer.TenKhachHang);
                $('#soDienThoai').val(customer.SoDienThoai);
                $('#email').val(customer.Email);
                $('#diaChi').val(customer.DiaChi);
                $('#ghiChu').val(customer.GhiChu || '');
                
                $('#modalTitle').html('<i class="fas fa-edit"></i> Sửa Khách hàng');
                isEditMode = true;
                
                $('#modalKhachHang').modal('show');
            }
        }
    });
}

// Lưu khách hàng (Thêm hoặc Sửa)
function saveCustomer() {
    // Validate
    if(!$('#formKhachHang')[0].checkValidity()) {
        $('#formKhachHang')[0].reportValidity();
        return;
    }
    
    const customerId = $('#customerId').val();
    const formData = {
        TenKhachHang: $('#tenKhachHang').val().trim(),
        SoDienThoai: $('#soDienThoai').val().trim(),
        Email: $('#email').val().trim(),
        DiaChi: $('#diaChi').val().trim()
    };
    
    // Validate số điện thoại
    if(!/^0[0-9]{9}$/.test(formData.SoDienThoai)) {
        showAlert('warning', 'Số điện thoại không hợp lệ! Phải có 10 số và bắt đầu bằng 0');
        return;
    }
    
    // Validate email nếu có
    if(formData.Email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.Email)) {
        showAlert('warning', 'Email không hợp lệ!');
        return;
    }
    
    // Disable nút Save
    $('#btnSave').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Đang lưu...');
    
    if(isEditMode) {
        // Sửa khách hàng
        formData.MaKhachHang = customerId;
        
        $.ajax({
            url: API_URL,
            method: 'PUT',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    showAlert('success', response.message);
                    $('#modalKhachHang').modal('hide');
                    loadCustomers();
                } else {
                    showAlert('danger', response.message);
                }
                $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showAlert('danger', response ? response.message : 'Có lỗi xảy ra!');
                $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
            }
        });
    } else {
        // Thêm khách hàng mới
        $.ajax({
            url: API_URL,
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    showAlert('success', response.message);
                    $('#modalKhachHang').modal('hide');
                    loadCustomers();
                } else {
                    showAlert('danger', response.message);
                }
                $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showAlert('danger', response ? response.message : 'Có lỗi xảy ra!');
                $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
            }
        });
    }
}

// Xóa khách hàng
function deleteCustomer(id) {
    if(!confirm('Bạn có chắc chắn muốn xóa khách hàng này?\n\nLưu ý: Không thể xóa nếu có đơn hàng liên quan!')) {
        return;
    }
    
    $.ajax({
        url: API_URL,
        method: 'DELETE',
        data: JSON.stringify({ MaKhachHang: id }),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                showAlert('success', response.message);
                loadCustomers();
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showAlert('danger', response ? response.message : 'Có lỗi xảy ra!');
        }
    });
}

// Hiển thị thông báo
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 3000);
}

// Hiển thị modal tùy chỉnh
function showModal(title, content) {
    const modalHtml = `
        <div class="modal fade" id="customModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #b08c3a; color: white;">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${content}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal
    $('#customModal').remove();
    
    // Add and show new modal
    $('body').append(modalHtml);
    $('#customModal').modal('show');
    
    // Remove modal from DOM after hiding
    $('#customModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
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