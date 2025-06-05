<?php include 'header.php'; ?>
<?php
include("dbconnect.php");
$id = isset($_GET['id_xe']) ? intval($_GET['id_xe']) : 0;
$query = "SELECT * FROM chitietsp WHERE id_xe = $id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
$xe = mysqli_fetch_assoc($result);
if (!$xe) {
    die("Không tìm thấy xe với ID này.");
}

// Xử lý ảnh
$images = [];
if (!empty($xe['hinhanh_xe'])) {
    $images[] = trim($xe['hinhanh_xe']);
}
if (!empty($xe['hinhanh_chitiet'])) {
    $details = explode(',', $xe['hinhanh_chitiet']);
    foreach ($details as $img) {
        $img = trim($img);
        if ($img !== $xe['hinhanh_xe']) {
            $images[] = $img;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($xe['ten_xe']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f1f3f6;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            padding-bottom: 40px;
        }
        .top {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }
        .product-image {
            flex: 1;
            min-width: 350px;
            max-width: 60%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .mainSwiper {
            width: 100%;
            height: 450px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .mainSwiper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .swiper-button-next,
        .swiper-button-prev {
            color: #007bff;
            background: rgba(255,255,255,0.7);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 20px;
        }
        .mySwiper {
            width: 100%;
            height: 100px;
            margin-top: 10px;
        }
        .mySwiper .swiper-slide {
            width: calc(33.333% - 10px);
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }
        .mySwiper .swiper-slide-thumb-active {
            border-color: #007bff;
        }
        .mySwiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .info {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .info h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #222;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .price {
            font-size: 28px;
            color: #e63946;
            font-weight: bold;
            margin: 10px 0 30px;
        }
        .info-line {
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-line i {
            color: #007bff;
            min-width: 22px;
            text-align: center;
        }
        .btn-call {
            padding: 14px 30px;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            width: fit-content;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-call.phone {
            background-color: #28a745;
        }
        .btn-call.phone:hover {
            background-color: #1e7e34;
        }
        .btn-call.cart {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-call.cart:hover {
            background-color: #e0a800;
        }
        .btn-group {
            margin-top: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .section {
            padding: 30px;
            border-top: 1px solid #e2e2e2;
        }
        .section h3 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #222;
            border-left: 5px solid #007bff;
            padding-left: 15px;
        }
        .table-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .table-info .item {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 16px;
        }
        .description {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            line-height: 1.6;
            white-space: pre-line;
            font-size: 16px;
        }
        .back-button {
            text-align: center;
            margin: 40px 0;
        }
        .back-button a {
            background-color: #007bff;
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .back-button a:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .top {
                flex-direction: column;
                padding: 15px;
            }
            .product-image, .info {
                max-width: 100%;
            }
            .mainSwiper {
                height: 300px;
            }
            .mySwiper .swiper-slide {
                width: calc(33.333% - 5px);
                height: 80px;
            }
            .info {
                padding: 15px 0;
            }
            .info h1 {
                font-size: 26px;
            }
            .price {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <div class="product-image">
                <div class="swiper mainSwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $img): ?>
                            <div class="swiper-slide">
                                <img src="IMG/<?php echo htmlspecialchars($img); ?>" alt="Ảnh xe">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $img): ?>
                            <div class="swiper-slide">
                                <img src="IMG/<?php echo htmlspecialchars($img); ?>" alt="Thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="info">
                <h1><i class="fas fa-car"></i> <?php echo htmlspecialchars($xe['ten_xe']); ?></h1>
                <div class="price"><?php echo number_format($xe['gia_xe'], 0, ',', '.') . ' triệu'; ?></div>
                <div class="info-line"><i class="fas fa-calendar-alt"></i> Năm sản xuất: <?php echo htmlspecialchars($xe['namsx_xe']); ?></div>
                <div class="info-line"><i class="fas fa-gas-pump"></i> Nhiên liệu: <?php echo htmlspecialchars($xe['nhienlieu_xe']); ?></div>
                <div class="info-line"><i class="fas fa-tachometer-alt"></i> Số odo: <?php echo htmlspecialchars($xe['sodo_xe']); ?></div>
                <div class="info-line"><i class="fas fa-cogs"></i> Hộp số: <?php echo htmlspecialchars($xe['hopso_xe']); ?></div>
                <div class="info-line"><i class="fas fa-map-marker-alt"></i> Địa điểm: <?php echo htmlspecialchars($xe['diadiem_xe']); ?></div>
                <div class="info-line"><i class="fas fa-store"></i> Showroom: <?php echo htmlspecialchars($xe['showroom_xe']); ?></div>
                <div class="btn-group">
                    <?php if (!empty($xe['lien_he'])): ?>
                        <a class="btn-call phone" href="tel:<?php echo htmlspecialchars($xe['lien_he']); ?>">
                            <i class="fas fa-phone"></i> Gọi ngay: <?php echo htmlspecialchars($xe['lien_he']); ?>
                        </a>
                    <?php endif; ?>
                    <form method="post" action="cart.php">
    <input type="hidden" name="id_xe" value="<?php echo $xe['id_xe']; ?>">
    <button type="submit" class="btn-call cart">
        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
    </button>
</form>

                </div>
            </div>
        </div>

        <div class="section">
            <h3><i class="fas fa-tools"></i> Thông số kỹ thuật</h3>
            <div class="table-info">
                <div class="item"><strong>Hãng xe:</strong> <?php echo htmlspecialchars($xe['hang_xe']); ?></div>
                <div class="item"><strong>Dòng xe:</strong> <?php echo htmlspecialchars($xe['dong_xe']); ?></div>
                <div class="item"><strong>Kiểu dáng:</strong> <?php echo htmlspecialchars($xe['kieu_xe']); ?></div>
            </div>
        </div>

        <div class="section">
            <h3><i class="fas fa-info-circle"></i> Mô tả</h3>
            <div class="description"><?php echo nl2br(htmlspecialchars($xe['mota_xe'])); ?></div>
        </div>

        <div class="back-button">
            <a href="index.php"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        const thumbSwiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const mainSwiper = new Swiper(".mainSwiper", {
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
        });
    </script>
</body>
</html>
