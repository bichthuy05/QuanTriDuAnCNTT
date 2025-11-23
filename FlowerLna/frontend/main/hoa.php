<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hoa - Flower Lna</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .status-badge {
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-primary"><i class="fas fa-flower"></i> Quản lý Hoa</h2>
                <p class="text-muted">Quản lý danh sách các loại hoa trong cửa hàng</p>
            </div>
        </div>

        <!-- Nút thêm hoa và tìm kiếm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHoa">
                    <i class="fas fa-plus"></i> Thêm Hoa Mới
                </button>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Tìm kiếm hoa..." id="searchHoa">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách hoa -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Danh sách Hoa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tableHoa">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Ảnh</th>
                                        <th>Tên Hoa</th>
                                        <th width="120">Giá</th>
                                        <th width="100">Số lượng</th>
                                        <th width="150">Loại hoa</th>
                                        <th width="120">Trạng thái</th>
                                        <th width="120" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyHoa">
                                    <!-- Dữ liệu sẽ được tải bằng AJAX -->
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            Đang tải dữ liệu...
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

    <!-- Modal Thêm/Sửa Hoa -->
    <div class="modal fade" id="modalHoa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHoaTitle">Thêm Hoa Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formHoa">
                        <input type="hidden" id="MaHoa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="TenHoa" class="form-label">Tên Hoa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="TenHoa" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Gia" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="Gia" min="0" step="1000" required>
                                </div>
                                <div class="mb-3">
                                    <label for="SoLuongTon" class="form-label">Số lượng tồn</label>
                                    <input type="number" class="form-control" id="SoLuongTon" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="MaLoai" class="form-label">Loại hoa <span class="text-danger">*</span></label>
                                    <select class="form-select" id="MaLoai" required>
                                        <option value="">Chọn loại hoa</option>
                                        <!-- Options sẽ được tải bằng AJAX -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="HinhAnh" class="form-label">Hình ảnh</label>
                                    <input type="text" class="form-control" id="HinhAnh" placeholder="Tên file ảnh (vd: hong_do.jpg)">
                                    <div class="form-text">Nhập tên file ảnh đã upload trong thư mục assets/img/</div>
                                </div>
                                <div class="mb-3">
                                    <label for="TrangThai" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="TrangThai">
                                        <option value="Còn hàng">Còn hàng</option>
                                        <option value="Hết hàng">Hết hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="MoTa" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="MoTa" rows="3" placeholder="Mô tả về loại hoa..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnSaveHoa">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            loadHoa();
            loadLoaiHoaForSelect();

            // Xử lý lưu hoa
            $('#btnSaveHoa').click(function() {
                saveHoa();
            });

            // Reset form khi modal đóng
            $('#modalHoa').on('hidden.bs.modal', function() {
                resetFormHoa();
            });

            // Tìm kiếm hoa
            $('#searchHoa').on('input', function() {
                searchHoa($(this).val());
            });
        });

        function loadHoa() {
            $.get('../api/qlhoa.php', function(data) {
                const hoaList = Array.isArray(data) ? data : [data];
                renderHoaTable(hoaList);
            }).fail(function(xhr) {
                showError('Lỗi tải danh sách hoa: ' + xhr.responseText);
            });
        }

        function loadLoaiHoaForSelect() {
            $.get('../api/loaihoa.php', function(data) {
                const loaiHoaList = Array.isArray(data) ? data : [data];
                const select = $('#MaLoai');
                select.empty().append('<option value="">Chọn loại hoa</option>');
                
                loaiHoaList.forEach(loai => {
                    select.append(`<option value="${loai.MaLoai}">${loai.TenLoai}</option>`);
                });
            });
        }

        function renderHoaTable(hoaList) {
            const tbody = $('#tbodyHoa');
            tbody.empty();

            if (hoaList.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            Không có dữ liệu hoa
                        </td>
                    </tr>
                `);
                return;
            }

            hoaList.forEach(hoa => {
                const tr = `
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
                            <strong>${hoa.TenHoa}</strong>
                            ${hoa.MoTa ? `<br><small class="text-muted">${hoa.MoTa}</small>` : ''}
                        </td>
                        <td><strong class="text-success">${formatCurrency(hoa.Gia)}</strong></td>
                        <td>
                            <span class="badge ${hoa.SoLuongTon > 0 ? 'bg-info' : 'bg-warning'}">
                                ${hoa.SoLuongTon}
                            </span>
                        </td>
                        <td>${hoa.TenLoai || 'N/A'}</td>
                        <td>
                            <span class="badge status-badge ${hoa.TrangThai === 'Còn hàng' ? 'bg-success' : 'bg-danger'}">
                                ${hoa.TrangThai}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" onclick="editHoa(${hoa.MaHoa})" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteHoa(${hoa.MaHoa})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(tr);
            });
        }

        function saveHoa() {
            // Validate form
            if (!$('#TenHoa').val() || !$('#Gia').val() || !$('#MaLoai').val()) {
                showError('Vui lòng điền đầy đủ thông tin bắt buộc');
                return;
            }

            const formData = {
                TenHoa: $('#TenHoa').val(),
                Gia: $('#Gia').val(),
                SoLuongTon: $('#SoLuongTon').val(),
                MoTa: $('#MoTa').val(),
                HinhAnh: $('#HinhAnh').val(),
                MaLoai: $('#MaLoai').val(),
                TrangThai: $('#TrangThai').val()
            };

            const maHoa = $('#MaHoa').val();
            const url = '../api/qlhoa.php';
            const method = maHoa ? 'PUT' : 'POST';

            if (maHoa) {
                formData.MaHoa = maHoa;
            }

            $('#btnSaveHoa').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

            $.ajax({
                url: url,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#modalHoa').modal('hide');
                    loadHoa();
                    showSuccess(method === 'POST' ? 'Thêm hoa thành công!' : 'Cập nhật hoa thành công!');
                    $('#btnSaveHoa').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                },
                error: function(xhr) {
                    const error = JSON.parse(xhr.responseText).error;
                    showError('Lỗi: ' + error);
                    $('#btnSaveHoa').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                }
            });
        }

        function editHoa(maHoa) {
            $.get(`../api/qlhoa.php?MaHoa=${maHoa}`, function(hoa) {
                $('#MaHoa').val(hoa.MaHoa);
                $('#TenHoa').val(hoa.TenHoa);
                $('#Gia').val(hoa.Gia);
                $('#SoLuongTon').val(hoa.SoLuongTon);
                $('#MoTa').val(hoa.MoTa);
                $('#HinhAnh').val(hoa.HinhAnh);
                $('#MaLoai').val(hoa.MaLoai);
                $('#TrangThai').val(hoa.TrangThai);
                
                $('#modalHoaTitle').text('Sửa Thông Tin Hoa');
                $('#modalHoa').modal('show');
            });
        }

        function deleteHoa(maHoa) {
            if (confirm('Bạn có chắc chắn muốn xóa hoa này?')) {
                $.ajax({
                    url: `../api/qlhoa.php?MaHoa=${maHoa}`,
                    type: 'DELETE',
                    success: function(response) {
                        showSuccess('Xóa hoa thành công!');
                        loadHoa();
                    },
                    error: function(xhr) {
                        const error = JSON.parse(xhr.responseText).error;
                        showError('Lỗi: ' + error);
                    }
                });
            }
        }

        function searchHoa(keyword) {
            const rows = $('#tbodyHoa tr');
            rows.each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(keyword.toLowerCase()));
            });
        }

        function resetFormHoa() {
            $('#formHoa')[0].reset();
            $('#MaHoa').val('');
            $('#modalHoaTitle').text('Thêm Hoa Mới');
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }

        function showSuccess(message) {
            alert('✅ ' + message);
        }

        function showError(message) {
            alert('❌ ' + message);
        }
    </script>
</body>
</html>