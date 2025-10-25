<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flower'Lna</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #faf9f7;
      font-family: 'Roboto', sans-serif;
      color: #2f2f2f;
    }

    /* HEADER */
    header {
      background: #fff;
      border-bottom: 1px solid #eee;
      padding: 15px 0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      color: #b08c3a;
      font-weight: 700;
      letter-spacing: 2px;
    }

    .contact-info {
      text-align: right;
      color: #7c7c7c;
      font-size: 14px;
    }

    /* MENU */
    .navbar {
      background-color: #fff8f0 !important;
      border-top: 1px solid #eee;
      border-bottom: 1px solid #eee;
    }

    .navbar-nav .nav-link {
      color: #3b2d1f !important;
      font-weight: 500;
      font-size: 16px;
      margin: 0 10px;
      transition: 0.3s;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .navbar-nav .nav-link:hover {
      color: #b08c3a !important;
    }

    /* BANNER */
    .banner {
      position: relative;
      background: url('https://images.unsplash.com/photo-1626576842773-576a5b58945a?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1946') center/cover no-repeat;
      height: 380px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }

    .banner::after {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4);
    }

    .banner-content {
      position: relative;
      z-index: 2;
    }

    .banner h1 {
      font-family: 'Playfair Display', serif;
      font-size: 58px;
      font-weight: 700;
      letter-spacing: 3px;
      color: #fff;
    }

    .banner p {
      font-size: 18px;
      margin-top: 15px;
      color: #f0e6d2;
      letter-spacing: 1px;
    }

    .btn-luxe {
      margin-top: 30px;
      padding: 12px 35px;
      background-color: #b08c3a;
      color: #fff;
      border: none;
      font-weight: 600;
      border-radius: 30px;
      transition: 0.3s;
    }

    .btn-luxe:hover {
      background-color: #d4af37;
      transform: translateY(-2px);
    }

    /* CONTACT SECTION */
    .contact-section {
      padding: 80px 0;
      position: relative;
    }

    .contact-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://images.unsplash.com/photo-1626576842773-576a5b58945a?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1946') center/cover no-repeat;
      z-index: -1;
    }

    .contact-bg::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }

    .contact-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-title {
      font-family: 'Playfair Display', serif;
      color: #b08c3a;
      font-size: 36px;
      margin-bottom: 10px;
      text-align: center;
    }

    .contact-subtitle {
      color: #7c7c7c;
      text-align: center;
      margin-bottom: 30px;
    }

    .contact-form .form-control {
      border: 1px solid #e8e8e8;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 20px;
      transition: all 0.3s;
    }

    .contact-form .form-control:focus {
      border-color: #b08c3a;
      box-shadow: 0 0 0 0.2rem rgba(176, 140, 58, 0.25);
    }

    .contact-form textarea.form-control {
      min-height: 150px;
      resize: vertical;
    }

    .contact-info-box {
      background: #fff8f0;
      border-radius: 10px;
      padding: 30px;
      height: 100%;
    }

    .contact-info-title {
      font-family: 'Playfair Display', serif;
      color: #b08c3a;
      margin-bottom: 20px;
      font-size: 24px;
    }

    .contact-info-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 20px;
    }

    .contact-info-icon {
      background: #b08c3a;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      flex-shrink: 0;
    }

    .contact-info-text h5 {
      font-weight: 600;
      margin-bottom: 5px;
      color: #3b2d1f;
    }

    .contact-info-text p {
      color: #7c7c7c;
      margin-bottom: 0;
    }

    /* MAP SECTION */
    .map-section {
      padding: 60px 0;
      background: #f8f6f2;
    }

    .map-title {
      font-family: 'Playfair Display', serif;
      color: #b08c3a;
      text-align: center;
      margin-bottom: 40px;
      font-size: 32px;
    }

    .map-container {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      height: 450px;
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    /* FOOTER */
    footer {
      background: #1e1a16;
      color: #d4c7a0;
      text-align: center;
      padding: 40px 0;
      margin-top: 50px;
    }

    footer h5 {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      margin-bottom: 15px;
    }

    footer p {
      font-size: 14px;
      color: #b9a97d;
    }

    footer a {
      color: #d4af37;
      text-decoration: none;
      margin: 0 10px;
      font-size: 18px;
    }

    footer a:hover {
      color: #fff;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .banner h1 {
        font-size: 36px;
      }
      
      .contact-container {
        padding: 25px;
      }
      
      .contact-title {
        font-size: 28px;
      }
      
      .map-container {
        height: 300px;
      }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="container-fluid">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">🌸 Flower'Lna</div>
      <div class="contact-info">
        Hotline: <strong>1800 88 88 88</strong><br>
        Flower'Lna.vn | contact@FlowerLna.vn
      </div>
    </div>
  </header>

    <!-- MENU -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="../../index.html">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom active" href="order_online.php">Bộ sưu tập</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="contact.php">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="../../about.html">Giới Thiệu</a></li>
                </ul>
            </div>
        </div>
    </nav>

  <!-- BANNER -->
  <section class="banner">
    <div class="banner-content">
      <h1>Vẻ Đẹp Đỉnh Cao Của Từng Cánh Hoa</h1>
      <p>“Mỗi đóa hoa, một cảm xúc – Flower'Lna đồng hành cùng trái tim bạn.”</p>
      <!-- ĐÃ XÓA NÚT "KHÁM PHÁ NGAY" Ở ĐÂY -->
    </div>
  </section>

  <!-- CONTACT SECTION -->
  <section class="contact-section" id="contact">
    <div class="contact-bg"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="contact-container">
            <h2 class="contact-title">Liên Hệ Với Chúng Tôi</h2>
            <p class="contact-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
            
            <div class="row">
              <div class="col-md-8">
                <form class="contact-form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Họ và tên" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Tiêu đề">
                  </div>
                  
                  <div class="form-group">
                    <textarea class="form-control" placeholder="Nội dung tin nhắn" required></textarea>
                  </div>
                  
                  <button type="submit" class="btn btn-luxe w-100">Gửi Tin Nhắn</button>
                </form>
              </div>
              
              <div class="col-md-4">
                <div class="contact-info-box">
                  <h3 class="contact-info-title">Thông Tin Liên Hệ</h3>
                  
                  <div class="contact-info-item">
                    <div class="contact-info-icon">
                      <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="contact-info-text">
                      <h5>Địa Chỉ</h5>
                      <p>52 Đ. Lê Lai, Phường 1, Gò Vấp, TP.HCM</p>
                    </div>
                  </div>
                  
                  <div class="contact-info-item">
                    <div class="contact-info-icon">
                      <i class="bi bi-telephone"></i>
                    </div>
                    <div class="contact-info-text">
                      <h5>Điện Thoại</h5>
                      <p>1800 88 88 88</p>
                    </div>
                  </div>
                  
                  <div class="contact-info-item">
                    <div class="contact-info-icon">
                      <i class="bi bi-envelope"></i>
                    </div>
                    <div class="contact-info-text">
                      <h5>Email</h5>
                      <p>contact@FlowerLna.vn</p>
                    </div>
                  </div>
                  
                  <div class="contact-info-item">
                    <div class="contact-info-icon">
                      <i class="bi bi-clock"></i>
                    </div>
                    <div class="contact-info-text">
                      <h5>Giờ Làm Việc</h5>
                      <p>Thứ 2 - Chủ Nhật: 8:00 - 20:00</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MAP SECTION -->
  <section class="map-section">
    <div class="container">
      <h2 class="map-title">Tìm Đường Đến Flower'Lna</h2>
      <div class="map-container">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.485332912918!2d106.6806519!3d10.8184998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e4139c22ed%3A0xd3a0a9a14da4fee4!2s52%20%C4%90.%20L%C3%AA%20Lai%2C%20Ph%C6%B0%E1%BB%9Dng%201%2C%20G%C3%B2%20V%E1%BA%A5p%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh%2C%20Vi%E1%BB%87t%20Nam!5e0!3m2!1svi!2s!4v1729830400000!5m2!1svi!2s" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <h5>Flower’Lna – Tinh tế trong từng chi tiết.</h5>
      <p>Địa chỉ: 52 Đ. Lê Lai, Phường 1, Gò Vấp, TP.HCM<br>
      Hotline: 1800 88 88 88 | Email: contact@FlowerLna.vn</p>
      <div>
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-instagram"></i></a>
        <a href="#"><i class="bi bi-twitter"></i></a>
      </div>
      <p class="mt-3">&copy; 2025 Flower'Lna. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Bootstrap JS + jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>