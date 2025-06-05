<!DOCTYPE html>


<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Thanh Sơn Auto</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f8f8f8;
      border-bottom: 1px solid #ddd;
      padding: 10px 30px;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 18px;
      font-weight: bold;
    }

    .logo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
    }

    .main-nav {
      margin-left: auto;
    }

    .main-nav ul {
      display: flex;
      align-items: center;
      list-style: none;
      padding: 0;
      margin: 0;
      gap: 15px;
    }

    .main-nav a {
      text-decoration: none;
      color: #333;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    .main-nav a:hover {
      background-color: #ddd;
    }

    .account-text {
      position: relative;
      cursor: pointer;
      user-select: none;
      color: #333;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .account-text .arrow {
      font-size: 12px;
      transition: transform 0.3s;
      user-select: none;
    }

    /* Dropdown menu */
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 120%;
      right: 0;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      min-width: 140px;
      z-index: 1000;
      padding: 5px 0;
    }

    .dropdown-menu a {
      display: block;
      padding: 8px 15px;
      color: #333;
      text-decoration: none;
      font-size: 14px;
      white-space: nowrap;
    }

    .dropdown-menu a:hover {
      background-color: #eee;
    }

    /* Khi active, xoay mũi tên và hiện dropdown */
    .account-text.active .arrow {
      transform: rotate(180deg);
    }

    .account-text.active .dropdown-menu {
      display: block;
    }
  </style>
</head>
<body>
  <header class="header">
    <!-- Logo bên trái -->
    <div class="logo-container">
  <a href="index.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
    <img src="IMG/vjp.jpg" alt="Thanh Sơn Auto" class="logo" />
    <span class="logo-text">Thanh Sơn Auto</span>
  </a>
</div>


    <!-- Menu bên phải -->
    <nav class="main-nav">
      <ul>
        <li><a href="index.php">Trang chủ</a></li>
        <li><a href="#car-section">Mua xe</a></li>
        <li><a href="viewcart.php">Giỏ hàng</a></li>
        <li><a href="#news-section">Tin tức</a></li>
        <li><a href="lienhe.php">Liên hệ</a></li>
        <li class="account-text" id="accountMenu">
  👤 
  <span>Tài khoản<?php echo isset($_SESSION['username']) ? ' (' . htmlspecialchars($_SESSION['username']) . ')' : ''; ?></span>
  <span class="arrow">▼</span>
  <div class="dropdown-menu">
    <a href="dangxuat.php">Đăng xuất</a>
  </div>
</li>

      </ul>
    </nav>
  </header>

  <script>
    const accountText = document.getElementById('accountMenu');

    accountText.addEventListener('click', function(e) {
      e.stopPropagation();
      this.classList.toggle('active');
    });

    // Click ra ngoài ẩn dropdown
    document.addEventListener('click', () => {
      accountText.classList.remove('active');
    });
  </script>
</body>
</html>
