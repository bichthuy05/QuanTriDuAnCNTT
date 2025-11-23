<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Hoa - Flower Lna</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-color: #2d3748;
            --light-color: #f8fafc;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .gradient-bg {
            background: var(--primary-gradient);
        }

        .stats-card {
            background: var(--success-gradient);
            color: white;
            border-radius: 15px;
            border: none;
            transition: var(--transition);
        }

        .stats-card:hover {
            transform: scale(1.05);
        }

        .btn-modern {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: var(--transition);
            color: white;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-outline-modern {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 12px;
            padding: 10px 23px;
            font-weight: 600;
            transition: var(--transition);
            background: transparent;
        }

        .btn-outline-modern:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .table-modern {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-modern thead {
            background: var(--primary-gradient);
            color: white;
        }

        .table-modern th {
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85em;
        }

        .table-modern td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: var(--transition);
        }

        .table-modern tbody tr:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
            transform: scale(1.01);
        }

        .modal-modern .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .modal-modern .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }

        .form-control-modern {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            transition: var(--transition);
            font-size: 14px;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 50px;
            border: 2px solid #e2e8f0;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 2;
        }

        .badge-modern {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75em;
        }

        .action-buttons .btn {
            border-radius: 10px;
            margin: 0 2px;
            transition: var(--transition);
        }

        .action-buttons .btn:hover {
            transform: scale(1.1);
        }

        .page-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .floating-action {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .floating-action .btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            font-size: 1.2em;
        }

        /* Loading animation */
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
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .glass-card {
                margin: 10px;
            }
            
            .table-modern {
                font-size: 0.9em;
            }
            
            .floating-action {
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4 fade-in-up">
            <div class="col-12">
                <div class="glass-card p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="page-title h2 mb-2">
                                <i class="fas fa-tags me-3"></i>Quản lý Loại Hoa
                            </h1>
                            <p class="text-muted mb-0">Quản lý danh mục các loại hoa trong cửa hàng</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control form-control-modern" 
                                       placeholder="Tìm kiếm loại hoa..." id="searchLoaiHoa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4 fade-in-up">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0" id="totalLoaiHoa">0</h3>
                            <p class="mb-0 opacity-8">Tổng loại hoa</p>
                        </div>
                        <div class="icon-shape">
                            <i class="fas fa-tags fa-2x opacity-8"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-success">Quản lý</h4>
                            <p class="mb-0 text-muted">Danh mục hoa</p>
                        </div>
                        <div class="icon-shape text-success">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row fade-in-up">
            <div class="col-12">
                <div class="glass-card">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0 text-dark">
                                    <i class="fas fa-list me-2"></i>Danh sách Loại Hoa
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modalLoaiHoa">
                                    <i class="fas fa-plus me-2"></i>Thêm Mới
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="100">Mã</th>
                                        <th>Tên Loại Hoa</th>
                                        <th>Mô tả</th>
                                        <th width="150">Ngày tạo</th>
                                        <th width="120" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyLoaiHoa">
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2 text-muted">Đang tải dữ liệu...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modalLoaiHoa" 
                title="Thêm loại hoa mới">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <!-- Modal Thêm/Sửa Loại Hoa -->
    <div class="modal fade modal-modern" id="modalLoaiHoa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLoaiHoaTitle">
                        <i class="fas fa-plus me-2"></i>Thêm Loại Hoa Mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formLoaiHoa">
                        <input type="hidden" id="MaLoai">
                        <div class="mb-4">
                            <label for="TenLoai" class="form-label fw-semibold">Tên Loại Hoa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-modern" id="TenLoai" required 
                                   placeholder="Nhập tên loại hoa...">
                        </div>
                        <div class="mb-3">
                            <label for="MoTa" class="form-label fw-semibold">Mô tả</label>
                            <textarea class="form-control form-control-modern" id="MoTa" rows="4" 
                                      placeholder="Mô tả về loại hoa..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-modern" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-modern" id="btnSaveLoaiHoa">
                        <i class="fas fa-save me-2"></i>Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Biến cấu hình
        const API_BASE_URL = '/FlowerLna/api';
        
        $(document).ready(function() {
            console.log('🚀 Trang loaihoa.php đã sẵn sàng');
            loadLoaiHoa();

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

            // Hiệu ứng khi scroll
            $(window).scroll(function() {
                const scrolled = $(this).scrollTop();
                $('.fade-in-up').css('opacity', 1 - scrolled / 300);
            });
        });

        // Các hàm xử lý dữ liệu (giữ nguyên từ code trước)
        function loadLoaiHoa() {
            console.log('🔄 Đang tải danh sách loại hoa...');
            
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
                    showError('Lỗi tải danh sách loại hoa');
                }
            });
        }

        function renderLoaiHoaTable(loaiHoaList) {
            const tbody = $('#tbodyLoaiHoa');
            tbody.empty();

            if (loaiHoaList.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Không có dữ liệu loại hoa</p>
                            <button class="btn btn-modern mt-2" data-bs-toggle="modal" data-bs-target="#modalLoaiHoa">
                                <i class="fas fa-plus me-2"></i>Thêm loại hoa đầu tiên
                            </button>
                        </td>
                    </tr>
                `);
                return;
            }

            loaiHoaList.forEach(loai => {
                const tr = `
                    <tr>
                        <td>
                            <span class="badge badge-modern gradient-bg text-white">#${loai.MaLoai}</span>
                        </td>
                        <td>
                            <strong class="text-dark">${loai.TenLoai}</strong>
                        </td>
                        <td>
                            ${loai.MoTa ? 
                                `<span class="text-muted">${loai.MoTa}</span>` : 
                                '<span class="text-muted fst-italic">Không có mô tả</span>'
                            }
                        </td>
                        <td>
                            <small class="text-muted">${formatDate(loai.CreatedAt)}</small>
                        </td>
                        <td class="text-center action-buttons">
                            <button class="btn btn-sm btn-warning text-white" onclick="editLoaiHoa(${loai.MaLoai})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteLoaiHoa(${loai.MaLoai})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(tr);
            });
        }

        function updateStats(loaiHoaList) {
            $('#totalLoaiHoa').text(loaiHoaList.length);
        }

        function saveLoaiHoa() {
            const tenLoai = $('#TenLoai').val().trim();
            if (!tenLoai) {
                showError('Vui lòng nhập tên loại hoa');
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

            $('#btnSaveLoaiHoa').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

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
                    let errorMsg = 'Lỗi không xác định';
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        errorMsg = errorResponse.error || errorResponse.message || xhr.responseText;
                    } catch (e) {
                        errorMsg = xhr.responseText || error;
                    }
                    showError('Lỗi: ' + errorMsg);
                },
                complete: function() {
                    $('#btnSaveLoaiHoa').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Lưu');
                }
            });
        }

        function editLoaiHoa(maLoai) {
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
                    showError('Lỗi tải thông tin loại hoa');
                }
            });
        }

        function deleteLoaiHoa(maLoai) {
            if (!confirm('Bạn có chắc chắn muốn xóa loại hoa này?\n\nLưu ý: Không thể xóa nếu có hoa thuộc loại này.')) return;

            $.ajax({
                url: `${API_BASE_URL}/loaihoa.php?MaLoai=${maLoai}`,
                type: 'DELETE',
                success: function(response) {
                    showSuccess('Xóa loại hoa thành công!');
                    loadLoaiHoa();
                },
                error: function(xhr, status, error) {
                    showError('Lỗi xóa loại hoa');
                }
            });
        }

        function searchLoaiHoa(keyword) {
            const rows = $('#tbodyLoaiHoa tr');
            const searchTerm = keyword.toLowerCase().trim();
            
            if (searchTerm === '') {
                rows.show();
                return;
            }
            
            rows.each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(searchTerm));
            });
        }

        function resetFormLoaiHoa() {
            $('#formLoaiHoa')[0].reset();
            $('#MaLoai').val('');
            $('#modalLoaiHoaTitle').html('<i class="fas fa-plus me-2"></i>Thêm Loại Hoa Mới');
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('vi-VN');
            } catch (e) {
                return 'N/A';
            }
        }

        function showSuccess(message) {
            // Tạo toast notification
            const toast = $(`
                <div class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            $('body').append(toast);
            new bootstrap.Toast(toast[0]).show();
        }

        function showError(message) {
            const toast = $(`
                <div class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-exclamation-triangle me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            $('body').append(toast);
            new bootstrap.Toast(toast[0]).show();
        }
    </script>
</body>
</html>