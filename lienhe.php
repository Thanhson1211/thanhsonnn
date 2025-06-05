<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Liên hệ với tôi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 60px 20px;
            max-width: 800px;
            margin: auto;
        }
        h2 {
            color: #333;
            margin-bottom: 40px;
            font-weight: 600;
            font-size: 1.8rem;
        }
        .contact-icons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
        }
        .contact-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
        }
        .contact-icons a:hover {
            transform: translateY(-6px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }
        .contact-icons img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kết nối với tôi qua các nền tảng sau:</h2>
        <div class="contact-icons">
            <a href="https://www.facebook.com/" target="_blank" title="Facebook">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" />
            </a>
            <a href="https://www.youtube.com/" target="_blank" title="YouTube">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube" />
            </a>
            <a href="https://www.instagram.com/" target="_blank" title="Instagram">
                <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" />
            </a>
            <a href="https://zalo.me/84364180814" target="_blank" title="Zalo">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968841.png" alt="Zalo" />
            </a>
            <a href="tel:+84364180814" title="Gọi điện thoại">
                <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" alt="Số điện thoại" />
            </a>
        </div>
    </div>
</body>
</html>
