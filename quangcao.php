<?php
// Include file kết nối database
require_once 'dbconnect.php';

// Truy vấn dữ liệu từ bảng quangcao
$query = "SELECT * FROM quangcao WHERE trang_thai = 1 ORDER BY ngay_tao DESC";
$result = mysqli_query($conn, $query);

// Kiểm tra kết nối và truy vấn
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sale - Thanh Sơn Auto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2; /* vẫn giữ màu nền tổng thể nhẹ */
            margin: 0;
            padding: 0;
        }

        .promo-container {
            background: #2d3f50; /* ✅ nền xanh than phủ toàn bộ */
            padding-bottom: 50px;
        }

        .promo-banner {
            color: #ffae00;
            padding: 40px 20px;
            text-align: center;
        }

        .promo-banner h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .promo-banner p {
            font-size: 20px;
        }

        .promo-banner p1 {
            font-size: 20px;
            display: block;
            margin-top: 10px;
        }

        .promo-section {
            max-width: 1200px;
            margin: 30px auto 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .promo-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            overflow: hidden;
            width: 360px;
            transition: transform 0.3s ease;
        }

        .promo-card:hover {
            transform: scale(1.02);
        }

        .promo-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .promo-content {
            padding: 20px;
        }

        .promo-content h2 {
            font-size: 24px;
            color: #d40000;
            margin-bottom: 10px;
        }

        .promo-content ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
        }

        .promo-content ul li {
            margin-bottom: 6px;
            font-size: 16px;
        }

        .promo-content .price {
            font-size: 20px;
            font-weight: bold;
            color: #009900;
        }

        .promo-footer {
            text-align: center;
            margin: 40px 0;
            font-size: 18px;
        }

        .promo-footer a {
            background: #d40000;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .promo-footer a:hover {
            background: #a80000;
        }

        .no-data {
            text-align: center;
            color: #ffae00;
            font-size: 18px;
            padding: 40px;
        }
    </style>
</head>
<body>

<div class="promo-container">
    <div class="promo-banner">
        <h1>🔥 SIÊU ƯU ĐÃI MÙA HÈ – MUA Ô TÔ, NHẬN NGAY QUÀ LỚN! 🔥</h1>
        <p1>Hệ thống Thanh Sơn Auto - Giá rẻ số 1 - Săn ngay kẻo lỡ!!</p1>
    </div>

    <div class="promo-section">
        <?php
        // Kiểm tra có dữ liệu không
        if (mysqli_num_rows($result) > 0) {
            // Lặp qua từng dòng dữ liệu
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="promo-card">';
                echo '<img src="IMG/' . htmlspecialchars($row['hinh_anh']) . '" alt="' . htmlspecialchars($row['ten_xe']) . '">';
                echo '<div class="promo-content">';
                echo '<h2>' . htmlspecialchars($row['ten_xe']) . '</h2>';
                echo '<ul>';
                
                // Tách các tính năng bằng dấu |
                $features = explode('|', $row['tinh_nang']);
                foreach ($features as $feature) {
                    if (!empty(trim($feature))) {
                        echo '<li>✔️ ' . htmlspecialchars(trim($feature)) . '</li>';
                    }
                }
                
                echo '</ul>';
                echo '<p class="price">Giá chỉ: ' . htmlspecialchars($row['gia']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-data">Hiện tại chưa có khuyến mãi nào!</div>';
        }
        
        // Đóng kết nối database
        mysqli_close($conn);
        ?>
    </div>

    <div class="promo-footer">
        <a href="lienhe.php">📞 LIÊN HỆ NGAY ĐỂ NHẬN ƯU ĐÃI</a>
    </div>
</div>

</body>
</html>