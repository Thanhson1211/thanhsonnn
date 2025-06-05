<?php
session_start();
include("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_xe'])) {
    $id_xe = intval($_POST['id_xe']);

    // Truy vấn thông tin sản phẩm từ database
    $query = "SELECT id_xe, ten_xe, gia_xe, hinhanh_xe FROM chitietsp WHERE id_xe = $id_xe";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $xe = mysqli_fetch_assoc($result);

        // Nếu giỏ hàng chưa tồn tại, khởi tạo
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra nếu xe đã có trong giỏ hàng thì tăng số lượng, ngược lại thêm mới
        if (isset($_SESSION['cart'][$id_xe])) {
            $_SESSION['cart'][$id_xe]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id_xe] = [
                'id_xe' => $xe['id_xe'],
                'ten_xe' => $xe['ten_xe'],
                'gia_xe' => $xe['gia_xe'],
                'hinhanh_xe' => $xe['hinhanh_xe'],
                'quantity' => 1
            ];
        }

        // Chuyển hướng về trang chi tiết sản phẩm hoặc giỏ hàng
        header("Location: viewcart.php");
        exit;
    } else {
        echo "Xe không tồn tại.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
