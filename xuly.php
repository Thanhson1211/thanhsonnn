<?php
session_start();
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "thanhsonth28.14";

// Kết nối MySQLi
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu và làm sạch
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$new_username = trim($_POST['new_username'] ?? '');
$new_password = trim($_POST['new_password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');
$action = $_POST['action'] ?? '';

if ($action === 'register') {
    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Mật khẩu xác nhận không khớp!";
        $_SESSION['show_register'] = true; // Giữ lại form đăng ký nếu lỗi
        header("Location: dangky,dangnhap.php");
        exit;
    }

    // Kiểm tra tài khoản đã tồn tại
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Tên đăng nhập đã tồn tại!";
        $_SESSION['show_register'] = true;
        header("Location: dangky,dangnhap.php");
        exit;
    }
    $stmt->close();

    // Mã hóa mật khẩu và lưu
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_username, $hashed);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Đăng ký thành công!";
    $_SESSION['show_login'] = true; // Chuyển về form đăng nhập sau khi đăng ký thành công
    header("Location: dangky,dangnhap.php");
    exit;
}

if ($action === 'login') {
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message'] = "Sai mật khẩu!";
            $_SESSION['show_login'] = true;
        }
    } else {
        $_SESSION['message'] = "Tên đăng nhập không tồn tại!";
        $_SESSION['show_login'] = true;
    }

    $stmt->close();
    header("Location: dangky,dangnhap.php");
    exit;
}

$conn->close();
?>
