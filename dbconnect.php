<?php
// Thông tin kết nối
$host = "localhost";
$user = "root";
$pass = "";
$db = "thanhsonth28.14";

// Kết nối bằng mysqli
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Kết nối MySQLi thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// Kết nối bằng PDO
$charset = "utf8mb4";
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // báo lỗi chi tiết
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Kết nối PDO thất bại: " . $e->getMessage());
}
?>
