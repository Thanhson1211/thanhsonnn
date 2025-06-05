<?php
session_start();
require_once 'dbconnect.php';

// Kiểm tra quyền admin
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: admin_login.php");
//     exit();
// }

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin đơn hàng
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    die("Đơn hàng không tồn tại");
}

// Lấy chi tiết đơn hàng
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll();

// Đánh dấu thông báo liên quan đến đơn hàng này là đã đọc
$stmt = $pdo->prepare("UPDATE admin_notifications SET is_read = 1 WHERE order_id = ?");
$stmt->execute([$order_id]);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= $order_id ?></title>
    <!-- Thêm CSS của bạn -->
</head>
<body>
    <div class="container">
        <h1>Chi tiết đơn hàng #<?= $order_id ?></h1>
        
        <div class="order-info">
            <h2>Thông tin khách hàng</h2>
            <p><strong>Tên:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>SĐT:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>
            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['customer_note']) ?></p>
            <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
            <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?>₫</p>
            <p><strong>Trạng thái:</strong> <?= $order['status'] ?></p>
            <p><strong>Ngày tạo:</strong> <?= date('H:i d/m/Y', strtotime($order['created_at'])) ?></p>
        </div>
        
        <div class="order-items">
            <h2>Danh sách sản phẩm</h2>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= number_format($item['product_price'], 0, ',', '.') ?>₫</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['subtotal'], 0, ',', '.') ?>₫</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="admin.php" class="btn">Quay lại</a>
    </div>
</body>
</html>