<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách xe ô tô</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #ffffff;
            color: #333;
            font-size: 18px;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        .product-container {
            max-width: 1200px;
            margin: auto;
            padding: 50px 20px;
        }

        .page-title {
            text-align: center;
            font-size: 42px;
            color: #1e1e2f;
            margin-bottom: 50px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }

        .page-title i {
            color: #007bff;
            margin-right: 10px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 40px;
        }

        .product-card-link {
            text-decoration: none;
            color: inherit;
        }

        .product-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
            position: relative;
            border: 1px solid #eee;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .ribbon {
            position: absolute;
            top: 10px;
            left: -10px;
            background: #e91e63;
            color: #fff;
            padding: 5px 20px;
            transform: rotate(-45deg);
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .product-info {
            padding: 24px;
        }

        .product-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #007bff;
        }

        .product-brand {
            font-size: 16px;
            color: #555;
        }

        .product-price {
            font-size: 20px;
            color: #e91e63;
            font-weight: bold;
            margin-top: 15px;
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 30px;
            }

            .product-name {
                font-size: 18px;
            }

            .product-price {
                font-size: 16px;
            }

            .ribbon {
                font-size: 10px;
                padding: 4px 14px;
            }
        }
    </style>
</head>
<body>

<main id="car-section">
    <div class="product-container">
        <h1 class="page-title"><i class="fas fa-car"></i> DANH SÁCH XE Ô TÔ</h1>

        <div class="product-grid">
            <?php
            include("dbconnect.php");
            $query = "SELECT * FROM sanpham";
            $kq = mysqli_query($conn, $query);

            if (!$kq) {
                die("Lỗi truy vấn: " . mysqli_error($conn));
            }

            while ($sp = mysqli_fetch_assoc($kq)) {
                $gia_xe = (int)$sp['gia_xe'];
                $label = '';
                if ($gia_xe > 2000000000) {
                    $label = 'Hot';
                } elseif ($gia_xe > 1000000000) {
                    $label = 'New';
                }
            ?>
            <a href="chitietsp.php?id_xe=<?php echo $sp['id_xe']; ?>" class="product-card-link">
                <div class="product-card">
                    <div class="product-image">
                        <img src="IMG/<?php echo $sp['anh_xe']; ?>" alt="<?php echo $sp['ten_xe']; ?>">
                        <?php if ($label != ''): ?>
                            <div class="ribbon"><?php echo $label; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?php echo $sp['ten_xe']; ?></h3>
                        <div class="product-brand"><i class="fas fa-tag"></i> <?php echo $sp['hang_xe']; ?></div>
                        <div class="product-price"><?php echo number_format($sp['gia_xe'], 0, ',', '.'); ?> VNĐ</div>
                    </div>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
</main>

</body>
</html>
