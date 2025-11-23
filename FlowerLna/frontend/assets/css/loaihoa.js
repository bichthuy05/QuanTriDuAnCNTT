// ===== CONFIGURATION =====
const API_BASE_URL = '/FlowerLna/api';

// ===== MAIN DOCUMENT READY =====
$(document).ready(function() {
    console.log('🚀 Trang loaihoa.php đã sẵn sàng');
    initializePage();
});

// ===== INITIALIZATION FUNCTIONS =====
function initializePage() {
    loadLoaiHoa();
    setupEventListeners();
    setupScrollEffects();
}

function setupEventListeners() {
    // Xử lý lưu loại hoa
    $('#btnSaveLoaiHoa').click(function() {
        saveLoaiHoa();
    });

    // Reset form khi modal đóng
    $('#modalLoaiHoa').on('hidden.bs.modal', function() {
        resetFormLoaiHoa();
    });

    // Tìm kiếm real-time
    $('#searchLoaiHoa').on('input', function() {
        searchLoaiHoa($(this).val());
    });

    // Enter key trong form
    $('#formLoaiHoa').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            saveLoaiHoa();
        }
    });
}

function setupScrollEffects() {
    // Hiệu ứng khi scroll
    $(window).scroll(function() {
        const scrolled = $(this).scrollTop();
        $('.fade-in-up').css('opacity', 1 - scrolled / 300);
    });
}

// ===== DATA MANAGEMENT FUNCTIONS =====
function loadLoaiHoa() {
    console.log('🔄 Đang tải danh sách loại hoa...');
    
    showLoadingState();
    
    $.ajax({
        url: `${API_BASE_URL}/loaihoa.php`,
        type: 'GET',
        success: function(data) {
            console.log('✅ Tải danh sách thành công:', data);
            const loaiHoaList = Array.isArray(data) ? data : [data];
            renderLoaiHoaTable(loaiHoaList);
            updateStats(loaiHoaList);
        },
        error: function(xhr, status, error) {
            console.error('❌ Lỗi tải danh sách:', error);
            showError('Lỗi tải danh sách loại hoa: ' + error);
            showEmptyState();
        }
    });
}

function showLoadingState() {
    $('#tbodyLoaiHoa').html(`
        <tr>
            <td colspan="5" class="text-center py-5">
                <div class="loading-spinner mx-auto mb-3"></div>
                <p class="text-muted">Đang tải dữ liệu...</p>
            </td>
        </tr>
    `);
}

function showEmptyState() {
    $('#tbodyLoaiHoa').html(`
        <tr>
            <td colspan="5" class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Không thể tải dữ liệu</p>
                <button class="btn btn-modern mt-2" onclick="loadLoaiHoa()">
                    <i class="fas fa-redo me-2"></i>Thử lại
                </button>
            </td>
        </tr>
    `);
}

function renderLoaiHoaTable(loaiHoaList) {
    const tbody = $('#tbodyLoaiHoa');
    tbody.empty();

    if (loaiHoaList.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="5" class="text-center py-5">
                    <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có loại hoa nào</p>
                    <button class="btn btn-modern mt-2" data-bs-toggle="modal" data-bs-target="#modalLoaiHoa">
                        <i class="fas fa-plus me-2"></i>Thêm loại hoa đầu tiên
                    </button>
                </td>
            </tr>
        `);
        return;
    }

    loaiHoaList.forEach((loai, index) => {
        const tr = `
            <tr class="fade-in-up" style="animation-delay: ${index * 0.1}s">
                <td>
                    <span class="badge badge-modern gradient-bg text-white">#${loai.MaLoai}</span>
                </td>
                <td>
                    <strong class="text-dark">${escapeHtml(loai.TenLoai)}</strong>
                </td>
                <td>
                    ${loai.MoTa ? 
                        `<span class="text-muted text-truncate-2">${escapeHtml(loai.MoTa)}</span>` : 
                        '<span class="text-muted fst-italic">Không có mô tả</span>'
                    }
                </td>
                <td>
                    <small class="text-muted">${formatDate(loai.CreatedAt)}</small>
                </td>
                <td class="text-center action-buttons">
                    <button class="btn btn-sm btn-warning text-white" onclick="editLoaiHoa(${loai.MaLoai})" 
                            title="Sửa loại hoa" data-bs-toggle="tooltip">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteLoaiHoa(${loai.MaLoai})" 
                            title="Xóa loại hoa" data-bs-toggle="tooltip">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.append(tr);
    });

    // Khởi tạo tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
}

function updateStats(loaiHoaList) {
    $('#totalLoaiHoa').text(loaiHoaList.length.toLocaleString());
}

// ===== CRUD OPERATIONS =====
function saveLoaiHoa() {
    const tenLoai = $('#TenLoai').val().trim();
    if (!tenLoai) {
        showError('Vui lòng nhập tên loại hoa');
        $('#TenLoai').focus();
        return;
    }

    const formData = {
        TenLoai: tenLoai,
        MoTa: $('#MoTa').val().trim()
    };

    const maLoai = $('#MaLoai').val();
    const url = `${API_BASE_URL}/loaihoa.php`;
    const method = maLoai ? 'PUT' : 'POST';

    if (maLoai) {
        formData.MaLoai = maLoai;
    }

    setButtonLoadingState('#btnSaveLoaiHoa', true);

    $.ajax({
        url: url,
        type: method,
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            $('#modalLoaiHoa').modal('hide');
            loadLoaiHoa();
            showSuccess(method === 'POST' ? 'Thêm loại hoa thành công!' : 'Cập nhật loại hoa thành công!');
        },
        error: function(xhr, status, error) {
            const errorMsg = parseErrorMessage(xhr);
            showError('Lỗi: ' + errorMsg);
        },
        complete: function() {
            setButtonLoadingState('#btnSaveLoaiHoa', false);
        }
    });
}

function editLoaiHoa(maLoai) {
    showLoadingState();
    
    $.ajax({
        url: `${API_BASE_URL}/loaihoa.php?MaLoai=${maLoai}`,
        type: 'GET',
        success: function(loai) {
            $('#MaLoai').val(loai.MaLoai);
            $('#TenLoai').val(loai.TenLoai);
            $('#MoTa').val(loai.MoTa);
            $('#modalLoaiHoaTitle').html('<i class="fas fa-edit me-2"></i>Sửa Thông Tin Loại Hoa');
            $('#modalLoaiHoa').modal('show');
        },
        error: function(xhr, status, error) {
            showError('Lỗi tải thông tin loại hoa: ' + error);
        }
    });
}

function deleteLoaiHoa(maLoai) {
    if (!confirm('Bạn có chắc chắn muốn xóa loại hoa này?\n\nLưu ý: Không thể xóa nếu có hoa thuộc loại này.')) {
        return;
    }

    $.ajax({
        url: `${API_BASE_URL}/loaihoa.php?MaLoai=${maLoai}`,
        type: 'DELETE',
        success: function(response) {
            showSuccess('Xóa loại hoa thành công!');
            loadLoaiHoa();
        },
        error: function(xhr, status, error) {
            const errorMsg = parseErrorMessage(xhr);
            showError('Lỗi: ' + errorMsg);
        }
    });
}

// ===== UTILITY FUNCTIONS =====
function searchLoaiHoa(keyword) {
    const rows = $('#tbodyLoaiHoa tr');
    const searchTerm = keyword.toLowerCase().trim();
    
    if (searchTerm === '') {
        rows.show();
        return;
    }
    
    let found = false;
    rows.each(function() {
        const text = $(this).text().toLowerCase();
        const isMatch = text.includes(searchTerm);
        $(this).toggle(isMatch);
        if (isMatch) found = true;
    });

    if (!found) {
        $('#tbodyLoaiHoa').append(`
            <tr id="no-results">
                <td colspan="5" class="text-center py-4">
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Không tìm thấy kết quả phù hợp</p>
                </td>
            </tr>
        `);
    } else {
        $('#no-results').remove();
    }
}

function resetFormLoaiHoa() {
    $('#formLoaiHoa')[0].reset();
    $('#MaLoai').val('');
    $('#modalLoaiHoaTitle').html('<i class="fas fa-plus me-2"></i>Thêm Loại Hoa Mới');
    $('#TenLoai').focus();
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    } catch (e) {
        return 'N/A';
    }
}

function setButtonLoadingState(selector, isLoading) {
    const btn = $(selector);
    if (isLoading) {
        btn.prop('disabled', true).html('<div class="loading-spinner"></div> Đang xử lý...');
    } else {
        btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Lưu');
    }
}

function parseErrorMessage(xhr) {
    try {
        const errorResponse = JSON.parse(xhr.responseText);
        return errorResponse.error || errorResponse.message || xhr.responseText;
    } catch (e) {
        return xhr.responseText || 'Lỗi không xác định';
    }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// ===== NOTIFICATION SYSTEM =====
function showSuccess(message) {
    showToast(message, 'success');
}

function showError(message) {
    showToast(message, 'error');
}

function showToast(message, type = 'info') {
    const toastClass = type === 'success' ? 'toast-success' : 'toast-error';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    const toast = $(`
        <div class="toast toast-modern ${toastClass} align-items-center text-white border-0 position-fixed top-0 end-0 m-3" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${icon} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `);
    
    $('body').append(toast);
    const bsToast = new bootstrap.Toast(toast[0], {
        autohide: true,
        delay: 3000
    });
    bsToast.show();
    
    // Tự động xóa sau khi ẩn
    toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}

// ===== GLOBAL EXPORTS =====
// Export functions để sử dụng trong HTML
window.loadLoaiHoa = loadLoaiHoa;
window.saveLoaiHoa = saveLoaiHoa;
window.editLoaiHoa = editLoaiHoa;
window.deleteLoaiHoa = deleteLoaiHoa;
window.searchLoaiHoa = searchLoaiHoa;
window.resetFormLoaiHoa = resetFormLoaiHoa;