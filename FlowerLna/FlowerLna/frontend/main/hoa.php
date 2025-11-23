<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hoa - Flower Lna</title>
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
                                <i class="fas fa-flower me-3"></i>Quản lý Hoa
                            </h1>
                            <p class="text-muted mb-0">Quản lý sản phẩm hoa trong cửa hàng</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control form-control-modern" placeholder="Tìm kiếm hoa..." id="searchHoa">
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
                            <h3 class="mb-0" id="totalHoa">0</h3>
                            <p class="mb-0 opacity-8">Tổng sản phẩm</p>
                        </div>
                        <i class="fas fa-flower fa-2x opacity-8"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-success" id="totalValue">0 VNĐ</h4>
                            <p class="mb-0 text-muted">Tổng giá trị</p>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
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
                                <h5 class="mb-0 text-dark"><i class="fas fa-list me-2"></i>Danh sách Hoa</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modalHoa">
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
                                        <th width="80">Ảnh</th>
                                        <th>Tên Hoa</th>
                                        <th width="120">Giá</th>
                                        <th width="100">Số lượng</th>
                                        <th width="150">Loại hoa</th>
                                        <th width="120">Trạng thái</th>
                                        <th width="150">Ngày tạo</th>
                                        <th width="120" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyHoa">
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
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
        <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modalHoa" title="Thêm hoa mới">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-modern" id="modalHoa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHoaTitle">
                        <i class="fas fa-plus me-2"></i>Thêm Hoa Mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formHoa">
                        <input type="hidden" id="MaHoa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="TenHoa" class="form-label fw-semibold">Tên Hoa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-modern" id="TenHoa" required placeholder="Nhập tên hoa...">
                                </div>
                                <div class="mb-4">
                                    <label for="Gia" class="form-label fw-semibold">Giá (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-modern" id="Gia" min="0" step="1000" required placeholder="Nhập giá...">
                                </div>
                                <div class="mb-4">
                                    <label for="SoLuongTon" class="form-label fw-semibold">Số lượng tồn</label>
                                    <input type="number" class="form-control form-control-modern" id="SoLuongTon" min="0" value="0" placeholder="Nhập số lượng...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="MaLoai" class="form-label fw-semibold">Loại hoa <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-modern" id="MaLoai" required>
                                        <option value="">Chọn loại hoa</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="HinhAnh" class="form-label fw-semibold">Hình ảnh</label>
                                    <input type="text" class="form-control form-control-modern" id="HinhAnh" placeholder="Tên file ảnh (vd: hong_do.jpg)">
                                    <small class="form-text text-muted">Nhập tên file ảnh đã upload trong thư mục assets/img/</small>
                                </div>
                                <div class="mb-4">
                                    <label for="TrangThai" class="form-label fw-semibold">Trạng thái</label>
                                    <select class="form-control form-control-modern" id="TrangThai">
                                        <option value="Còn hàng">Còn hàng</option>
                                        <option value="Hết hàng">Hết hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="MoTa" class="form-label fw-semibold">Mô tả</label>
                            <textarea class="form-control form-control-modern" id="MoTa" rows="3" placeholder="Mô tả về hoa..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-modern" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-modern" id="btnSaveHoa">
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
            loadHoa();
            loadLoaiHoaForSelect();
            $('#btnSaveHoa').click(saveHoa);
            $('#modalHoa').on('hidden.bs.modal', resetFormHoa);
            $('#searchHoa').on('input', function() { searchHoa($(this).val()); });
        });

        function loadHoa() {
            $.ajax({
                url: `${API_BASE_URL}/hoa.php`,
                type: 'GET',
                success: function(data) {
                    const hoaList = Array.isArray(data) ? data : [data];
                    renderHoaTable(hoaList);
                    updateStats(hoaList);
                },
                error: function() { showError('Lỗi tải danh sách hoa'); }
            });
        }

        function loadLoaiHoaForSelect() {
            $.ajax({
                url: `${API_BASE_URL}/loaihoa.php`,
                type: 'GET',
                success: function(data) {
                    const loaiHoaList = Array.isArray(data) ? data : [data];
                    const select = $('#MaLoai');
                    select.empty().append('<option value="">Chọn loại hoa</option>');
                    loaiHoaList.forEach(loai => {
                        select.append(`<option value="${loai.MaLoai}">${loai.TenLoai}</option>`);
                    });
                },
                error: function() { showError('Lỗi tải danh sách loại hoa'); }
            });
        }

        function renderHoaTable(hoaList) {
            const tbody = $('#tbodyHoa');
            tbody.empty();

            if (hoaList.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Không có dữ liệu hoa</p>
                            <button class="btn btn-modern mt-2" data-bs-toggle="modal" data-bs-target="#modalHoa">
                                <i class="fas fa-plus me-2"></i>Thêm hoa đầu tiên
                            </button>
                        </td>
                    </tr>
                `);
                return;
            }

            hoaList.forEach(hoa => {
                tbody.append(`
                    <tr>
                        <td>
                            ${hoa.HinhAnh ? 
                                `<img src="../assets/img/${hoa.HinhAnh}" class="product-img" alt="${hoa.TenHoa}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjhGOEY4Ii8+CjxwYXRoIGQ9Ik0zMCAzN0MzMy44NjYgMzcgMzcgMzMuODY2IDM3IDMwQzM3IDI2LjEzNCAzMy44NjYgMjMgMzAgMjNDMjYuMTM0IDIzIDIzIDI2LjEzNCAyMyAzMEMyMyAzMy44NjYgMjYuMTM0IDM3IDMwIDM3Wk0zMCA0MEMzNS41MjIgNDAgNDAgMzUuNTIyIDQwIDMwQzQwIDI0LjQ3OCAzNS41MjIgMjAgMzAgMjBDMjQuNDc4IDIwIDIwIDI0LjQ3OCAyMCAzMEMyMCAzNS41MjIgMjQuNDc4IDQwIDMwIDQwWk0xMCA1MEg1MEM1MS4xMDQgNTAgNTIgNDkuMTA0IDUyIDQ4VjEyQzUyIDEwLjg5NiA1MS4xMDQgMTAgNTAgMTBIMTBDOC44OTYgMTAgOCAxMC44OTYgOCAxMlY0OEM4IDQ5LjEwNCA4Ljg5NiA1MCAxMCA1MFoiIGZpbGw9IiNDQ0NDQ0MiLz4KPC9zdmc+''">` : 
                                `<div class="product-img bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-flower text-muted"></i>
                                </div>`
                            }
                        </td>
                        <td>
                            <strong class="text-dark">${hoa.TenHoa}</strong>
                            ${hoa.MoTa ? `<br><small class="text-muted">${hoa.MoTa}</small>` : ''}
                        </td>
                        <td><strong class="text-success">${formatCurrency(hoa.Gia)}</strong></td>
                        <td>
                            <span class="badge badge-modern ${hoa.SoLuongTon > 0 ? 'bg-info' : 'bg-warning'}">
                                ${hoa.SoLuongTon}
                            </span>
                        </td>
                        <td><span class="text-muted">${hoa.TenLoai || 'N/A'}</span></td>
                        <td>
                            <span class="badge badge-modern ${hoa.TrangThai === 'Còn hàng' ? 'bg-success' : 'bg-danger'}">
                                ${hoa.TrangThai}
                            </span>
                        </td>
                        <td><small class="text-muted">${formatDate(hoa.CreatedAt)}</small></td>
                        <td class="text-center action-buttons">
                            <button class="btn btn-sm btn-warning text-white" onclick="editHoa(${hoa.MaHoa})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteHoa(${hoa.MaHoa})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        function updateStats(hoaList) {
            $('#totalHoa').text(hoaList.length);
            const totalValue = hoaList.reduce((sum, hoa) => sum + (parseInt(hoa.Gia) || 0), 0);
            $('#totalValue').text(formatCurrency(totalValue));
        }

        function saveHoa() {
            const tenHoa = $('#TenHoa').val().trim();
            const gia = $('#Gia').val();
            const maLoai = $('#MaLoai').val();
            
            if (!tenHoa || !gia || !maLoai) {
                showError('Vui lòng điền đầy đủ thông tin bắt buộc');
                return;
            }

            const formData = {
                TenHoa: tenHoa,
                Gia: parseInt(gia),
                SoLuongTon: parseInt($('#SoLuongTon').val()) || 0,
                MoTa: $('#MoTa').val().trim(),
                HinhAnh: $('#HinhAnh').val().trim(),
                MaLoai: parseInt(maLoai),
                TrangThai: $('#TrangThai').val()
            };

            const maHoa = $('#MaHoa').val();
            const method = maHoa ? 'PUT' : 'POST';
            if (maHoa) formData.MaHoa = parseInt(maHoa);

            $('#btnSaveHoa').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

            $.ajax({
                url: `${API_BASE_URL}/hoa.php`,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function() {
                    $('#modalHoa').modal('hide');
                    loadHoa();
                    showSuccess(method === 'POST' ? 'Thêm hoa thành công!' : 'Cập nhật hoa thành công!');
                },
                error: function(xhr) {
                    let errorMsg = 'Lỗi không xác định';
                    try { errorMsg = JSON.parse(xhr.responseText).error || xhr.responseText; } catch (e) {}
                    showError('Lỗi: ' + errorMsg);
                },
                complete: function() {
                    $('#btnSaveHoa').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Lưu');
                }
            });
        }

        function editHoa(maHoa) {
            $.ajax({
                url: `${API_BASE_URL}/hoa.php?MaHoa=${maHoa}`,
                type: 'GET',
                success: function(hoa) {
                    $('#MaHoa').val(hoa.MaHoa);
                    $('#TenHoa').val(hoa.TenHoa);
                    $('#Gia').val(hoa.Gia);
                    $('#SoLuongTon').val(hoa.SoLuongTon);
                    $('#MoTa').val(hoa.MoTa);
                    $('#HinhAnh').val(hoa.HinhAnh);
                    $('#MaLoai').val(hoa.MaLoai);
                    $('#TrangThai').val(hoa.TrangThai);
                    $('#modalHoaTitle').html('<i class="fas fa-edit me-2"></i>Sửa Thông Tin Hoa');
                    $('#modalHoa').modal('show');
                },
                error: function() { showError('Lỗi tải thông tin hoa'); }
            });
        }

        function deleteHoa(maHoa) {
            if (!confirm('Bạn có chắc chắn muốn xóa hoa này?')) return;

            $.ajax({
                url: `${API_BASE_URL}/hoa.php?MaHoa=${maHoa}`,
                type: 'DELETE',
                success: function() { showSuccess('Xóa hoa thành công!'); loadHoa(); },
                error: function() { showError('Lỗi xóa hoa'); }
            });
        }

        function searchHoa(keyword) {
            const rows = $('#tbodyHoa tr');
            const searchTerm = keyword.toLowerCase().trim();
            if (searchTerm === '') { rows.show(); return; }
            rows.each(function() { $(this).toggle($(this).text().toLowerCase().includes(searchTerm)); });
        }

        function resetFormHoa() {
            $('#formHoa')[0].reset();
            $('#MaHoa').val('');
            $('#modalHoaTitle').html('<i class="fas fa-plus me-2"></i>Thêm Hoa Mới');
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
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