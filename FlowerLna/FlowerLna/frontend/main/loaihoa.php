<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Hoa - Flower Lna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/hoa.css">
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header -->
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
                                <input type="text" class="form-control form-control-modern" placeholder="Tìm kiếm loại hoa..." id="searchLoaiHoa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4 fade-in-up">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0" id="totalLoaiHoa">0</h3>
                            <p class="mb-0 opacity-8">Tổng loại hoa</p>
                        </div>
                        <i class="fas fa-tags fa-2x opacity-8"></i>
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
                                <h5 class="mb-0 text-dark"><i class="fas fa-list me-2"></i>Danh sách Loại Hoa</h5>
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
                                            <div class="spinner-border text-primary" role="status"></div>
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
        <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modalLoaiHoa" title="Thêm loại hoa mới">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <!-- Modal -->
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
                            <input type="text" class="form-control form-control-modern" id="TenLoai" required placeholder="Nhập tên loại hoa...">
                        </div>
                        <div class="mb-3">
                            <label for="MoTa" class="form-label fw-semibold">Mô tả</label>
                            <textarea class="form-control form-control-modern" id="MoTa" rows="4" placeholder="Mô tả về loại hoa..."></textarea>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const API_BASE_URL = '/FlowerLna/api';
        
        $(document).ready(function() {
            loadLoaiHoa();
            $('#btnSaveLoaiHoa').click(saveLoaiHoa);
            $('#modalLoaiHoa').on('hidden.bs.modal', resetFormLoaiHoa);
            $('#searchLoaiHoa').on('input', function() { searchLoaiHoa($(this).val()); });
        });

        function loadLoaiHoa() {
            $.ajax({
                url: `${API_BASE_URL}/loaihoa.php`,
                type: 'GET',
                success: function(data) {
                    const loaiHoaList = Array.isArray(data) ? data : [data];
                    renderLoaiHoaTable(loaiHoaList);
                    updateStats(loaiHoaList);
                },
                error: function() { showError('Lỗi tải danh sách loại hoa'); }
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
                tbody.append(`
                    <tr>
                        <td><span class="badge badge-modern gradient-bg text-white">#${loai.MaLoai}</span></td>
                        <td><strong class="text-dark">${loai.TenLoai}</strong></td>
                        <td>${loai.MoTa ? `<span class="text-muted">${loai.MoTa}</span>` : '<span class="text-muted fst-italic">Không có mô tả</span>'}</td>
                        <td><small class="text-muted">${formatDate(loai.CreatedAt)}</small></td>
                        <td class="text-center action-buttons">
                            <button class="btn btn-sm btn-warning text-white" onclick="editLoaiHoa(${loai.MaLoai})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteLoaiHoa(${loai.MaLoai})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        function updateStats(loaiHoaList) { $('#totalLoaiHoa').text(loaiHoaList.length); }

        function saveLoaiHoa() {
            const tenLoai = $('#TenLoai').val().trim();
            if (!tenLoai) { showError('Vui lòng nhập tên loại hoa'); return; }

            const formData = { TenLoai: tenLoai, MoTa: $('#MoTa').val().trim() };
            const maLoai = $('#MaLoai').val();
            const method = maLoai ? 'PUT' : 'POST';
            if (maLoai) formData.MaLoai = maLoai;

            $('#btnSaveLoaiHoa').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

            $.ajax({
                url: `${API_BASE_URL}/loaihoa.php`,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function() {
                    $('#modalLoaiHoa').modal('hide');
                    loadLoaiHoa();
                    showSuccess(method === 'POST' ? 'Thêm loại hoa thành công!' : 'Cập nhật loại hoa thành công!');
                },
                error: function(xhr) {
                    let errorMsg = 'Lỗi không xác định';
                    try { errorMsg = JSON.parse(xhr.responseText).error || xhr.responseText; } catch (e) {}
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
                error: function() { showError('Lỗi tải thông tin loại hoa'); }
            });
        }

        function deleteLoaiHoa(maLoai) {
            if (!confirm('Bạn có chắc chắn muốn xóa loại hoa này?\n\nLưu ý: Không thể xóa nếu có hoa thuộc loại này.')) return;

            $.ajax({
                url: `${API_BASE_URL}/loaihoa.php?MaLoai=${maLoai}`,
                type: 'DELETE',
                success: function() { showSuccess('Xóa loại hoa thành công!'); loadLoaiHoa(); },
                error: function() { showError('Lỗi xóa loại hoa'); }
            });
        }

        function searchLoaiHoa(keyword) {
            const rows = $('#tbodyLoaiHoa tr');
            const searchTerm = keyword.toLowerCase().trim();
            if (searchTerm === '') { rows.show(); return; }
            rows.each(function() { $(this).toggle($(this).text().toLowerCase().includes(searchTerm)); });
        }

        function resetFormLoaiHoa() {
            $('#formLoaiHoa')[0].reset();
            $('#MaLoai').val('');
            $('#modalLoaiHoaTitle').html('<i class="fas fa-plus me-2"></i>Thêm Loại Hoa Mới');
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            try { return new Date(dateString).toLocaleDateString('vi-VN'); } catch (e) { return 'N/A'; }
        }

        function showSuccess(message) {
            const toast = $(`
                <div class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body"><i class="fas fa-check-circle me-2"></i>${message}</div>
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
                        <div class="toast-body"><i class="fas fa-exclamation-triangle me-2"></i>${message}</div>
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