<?php
session_start();
// Hủy tất cả session để đăng xuất người dùng
session_unset();
session_destroy();

// Chuyển hướng về trang chủ hoặc trang đăng nhập
header('Location: dangky,dangnhap.php'); 
exit;
?>
