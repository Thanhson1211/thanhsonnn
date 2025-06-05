<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh Sơn Auto</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    html, body {
      height: 100%;
      overflow: hidden;
    }

    #bg-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }

    header {
      width: 100%;
      padding: 10px 30px;
      background: transparent;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      z-index: 10;
    }

    header .left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .logo-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }

    header nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      margin-right: 20px;
      font-size: 14px;
    }

    header nav a:hover {
      text-decoration: underline;
    }

    .login-button {
      background-color: #d13639;
      padding: 8px 16px;
      border-radius: 20px;
      text-decoration: none;
      color: black;
      font-weight: bold;
      transition: background 0.3s;
      cursor: pointer;
    }

    .login-button:hover {
      background-color: #a7282b;
      color: white;
    }

    .overlay {
      width: 100%;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 20;
    }

    .form-container {
      background-color: rgba(0, 0, 0, 0.9);
      border-radius: 12px;
      width: 360px;
      max-width: 90%;
      padding: 30px 20px;
      color: white;
      text-align: center;
      position: relative;
    }

    .form-container h2 {
      margin-bottom: 15px;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      background: #1e1e1e;
      border: 1px solid #444;
      color: white;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #d13639;
      border: none;
      color: white;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #a7282b;
    }

    .message {
      margin-top: 10px;
      color: #ffff66;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      color: white;
      cursor: pointer;
    }

    .toggle-link {
      color: #ccc;
      text-decoration: underline;
      cursor: pointer;
      display: inline-block;
      margin-top: 10px;
    }

    .toggle-link:hover {
      color: #fff;
    }
  </style>
</head>
<body>

<video autoplay muted loop playsinline id="bg-video">
  <source src="IMG/video.mp4" type="video/mp4">
  Trình duyệt không hỗ trợ video.
</video>

<header>
  <div class="left">
    <img src="IMG/vjp.jpg" alt="Logo" class="logo-circle">
    <nav>
      <a href="dangky,dangnhap.php">THANH SƠN AUTO</a>
      <a href="footer.php">GIỚI THIỆU</a>
      <a href="news.php">TIN TỨC</a>
    </nav>
  </div>
  <div class="right">
    <div class="login-button" id="loginBtn">ĐĂNG NHẬP</div>
  </div>
</header>

<div class="overlay" id="loginOverlay">
  <!-- Đăng nhập -->
  <div class="form-container" id="loginForm">
    <div class="close-btn" onclick="closeOverlay()">&times;</div>
    <h2>Đăng nhập</h2>
    <form action="xuly.php" method="POST">
      <input type="text" name="username" placeholder="Tên đăng nhập" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <button type="submit" name="action" value="login">Đăng nhập</button>
    </form>
    <div class="toggle-link" onclick="switchToRegister()">Chưa có tài khoản? Đăng ký</div>
    <?php if (isset($_SESSION['message'])): ?>
      <p class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
  </div>

  <!-- Đăng ký -->
  <div class="form-container" id="registerForm" style="display:none">
    <div class="close-btn" onclick="closeOverlay()">&times;</div>
    <h2>Đăng ký</h2>
    <form action="xuly.php" method="POST">
      <input type="text" name="new_username" placeholder="Tên đăng nhập" required>
      <input type="password" name="new_password" placeholder="Mật khẩu" required>
      <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
      <button type="submit" name="action" value="register">Đăng ký</button>
    </form>
    <div class="toggle-link" onclick="switchToLogin()">Đã có tài khoản? Đăng nhập</div>
  </div>
</div>

<script>
  const loginBtn = document.getElementById('loginBtn');
  const loginOverlay = document.getElementById('loginOverlay');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  loginBtn.addEventListener('click', () => {
    loginOverlay.style.display = 'flex';
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
  });

  function switchToRegister() {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
  }

  function switchToLogin() {
    registerForm.style.display = 'none';
    loginForm.style.display = 'block';
  }

  function closeOverlay() {
    loginOverlay.style.display = 'none';
  }

  // Ẩn overlay khi click ra ngoài form
  loginOverlay.addEventListener('click', (e) => {
    if (e.target === loginOverlay) {
      loginOverlay.style.display = 'none';
    }
  });
</script>

</body>
	<?php if (isset($_SESSION['show_login'])): ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    loginOverlay.style.display = 'flex';
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
  });
</script>
<?php unset($_SESSION['show_login']); endif; ?>

<?php if (isset($_SESSION['show_register'])): ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    loginOverlay.style.display = 'flex';
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
  });
</script>
<?php unset($_SESSION['show_register']); endif; ?>

</html>
