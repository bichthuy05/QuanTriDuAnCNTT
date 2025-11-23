<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Lna - Quản lý cửa hàng hoa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <h5 class="text-center mb-4">FLOWER LNA</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-page="hoa">
                                <i class="fas fa-flower"></i> Quản lý Hoa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-page="loaihoa">
                                <i class="fas fa-tags"></i> Quản lý Loại Hoa
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2" id="page-title">Quản lý Hoa</h1>
                </div>
                
                <!-- Content will be loaded here -->
                <div id="content-area">
                    <!-- Nội dung các trang sẽ được tải vào đây -->
                </div>
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Load trang mặc định
        $(document).ready(function() {
            loadPage('hoa');
        });

        // Xử lý click menu
        $('.nav-link').click(function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            
            const page = $(this).data('page');
            loadPage(page);
        });

        function loadPage(page) {
            $('#page-title').text(getPageTitle(page));
            $('#content-area').load(`frontend/${page}.html`);
        }

        function getPageTitle(page) {
            const titles = {
                'hoa': 'Quản lý Hoa',
                'loaihoa': 'Quản lý Loại Hoa'
            };
            return titles[page] || 'Flower Lna';
        }
    </script>
</body>
</html>