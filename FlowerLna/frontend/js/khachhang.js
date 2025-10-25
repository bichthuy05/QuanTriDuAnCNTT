const API_KH = '../api/khachhang.php';

function loadKhachHang() {
  $.get(API_KH, function(data) {
    renderTable(data);
  }).fail(() => {
    $('#tbodyKhachHang').html('<tr><td colspan="5" class="text-danger text-center">Lỗi tải dữ liệu</td></tr>');
  });
}

function renderTable(list) {
  const tbody = $('#tbodyKhachHang').empty();
  if (!Array.isArray(list) || list.length === 0) {
    tbody.append('<tr><td colspan="5" class="text-center text-muted py-3">Chưa có khách hàng nào</td></tr>');
    return;
  }

  list.forEach(kh => {
    tbody.append(`
      <tr>
        <td>${kh.TenKhachHang}</td>
        <td>${kh.SoDienThoai}</td>
        <td>${kh.Email || '-'}</td>
        <td>${kh.DiaChi || '-'}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-warning me-1" onclick="editKH(${kh.MaKhachHang})"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger" onclick="deleteKH(${kh.MaKhachHang})"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

function saveKH() {
  const id = $('#MaKH').val();
  const data = {
    MaKH: id,
    TenKhachHang: $('#TenKhachHang').val(),
    SoDienThoai: $('#SoDienThoai').val(),
    Email: $('#Email').val(),
    DiaChi: $('#DiaChi').val()
  };

  const method = id ? 'PUT' : 'POST';

  $.ajax({
    url: API_KH + (id ? '' : ''),
    type: method,
    data: JSON.stringify(data),
    contentType: 'application/json',
    success: function() {
      $('#modalKhachHang').modal('hide');
      loadKhachHang();
      alert(id ? 'Cập nhật thành công!' : 'Thêm mới thành công!');
    },
    error: function(xhr) {
      alert('Lỗi: ' + xhr.responseText);
    }
  });
}

function editKH(id) {
  $.get(API_KH + '?MaKH=' + id, function(kh) {
    $('#MaKH').val(kh.MaKhachHang);
    $('#TenKhachHang').val(kh.TenKhachHang);
    $('#SoDienThoai').val(kh.SoDienThoai);
    $('#Email').val(kh.Email);
    $('#DiaChi').val(kh.DiaChi);
    $('#modalTitle').text('Sửa Khách hàng');
    $('#modalKhachHang').modal('show');
  });
}

function deleteKH(id) {
  if (!confirm('Bạn có chắc muốn xóa khách hàng này?')) return;
  $.ajax({
    url: API_KH + '?MaKH=' + id,
    type: 'DELETE',
    success: function() {
      alert('Đã xóa thành công!');
      loadKhachHang();
    },
    error: function(xhr) {
      alert('Lỗi: ' + xhr.responseText);
    }
  });
}

$('#btnSaveKH').click(saveKH);

$('#searchKhachHang').on('input', function() {
  const keyword = $(this).val().toLowerCase();
  $('#tbodyKhachHang tr').filter(function() {
    $(this).toggle($(this).text().toLowerCase().includes(keyword));
  });
});

$(document).ready(loadKhachHang);
