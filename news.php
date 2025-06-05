<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .news-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .page-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #0a1f44;
            text-align: center;
        }

        .news-scroll-box {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .news-item {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .news-item img {
            width: 250px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
            transition: transform 0.3s;
        }

        .news-item img:hover {
            transform: scale(1.03);
        }

        .news-content {
            flex: 1;
        }

        .news-title {
            font-size: 18px;
            font-weight: bold;
            color: #e67e22;
            margin-bottom: 8px;
            display: inline-block;
            text-decoration: none;
        }

        .news-title:hover {
            color: #d35400;
            text-decoration: underline;
        }

        .news-text, .news-more {
            font-size: 16px;
            color: #333;
            text-align: justify;
            line-height: 1.6;
        }

        .news-more {
            display: none;
            margin-top: 8px;
        }

        .toggle-btn {
            margin-top: 5px;
            color: #007BFF;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
        }

        .toggle-btn:hover {
            text-decoration: underline;
        }

        .news-meta {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }

        .news-meta i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <main id="news-section">
        <div class="news-container">
            <h1 class="page-title"><i class="fas fa-newspaper"></i> TIN TỨC NỔI BẬT</h1>

            <div class="news-scroll-box">
                <?php
                include("dbconnect.php");
                $query = "SELECT * FROM tintuc ORDER BY ngaydang_tt DESC";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Lỗi truy vấn: " . mysqli_error($conn));
                }

                while ($tin = mysqli_fetch_assoc($result)) {
                    $tieude = htmlspecialchars($tin['tt_tt']);
                    $noidung = nl2br(htmlspecialchars($tin['tomtat_tt']));
                    $xemthem = nl2br(htmlspecialchars($tin['xemthem_tt']));
                    $ngaydang = date('d/m/Y', strtotime($tin['ngaydang_tt']));
                ?>
                <div class="news-item">
                   <a href="chitiettt.php?id_tt=<?php echo $tin['id_tt']; ?>">
                        <img src="IMG/<?php echo htmlspecialchars($tin['anh_tt']); ?>" alt="Ảnh tin tức">
                    </a>
                    <div class="news-content">
                        <a class="news-title" href="chitiettt.php?id_tt=<?php echo $tin['id_tt']; ?>">
                            <?php echo $tieude; ?>
                        </a>
                        <div class="news-text"><?php echo $noidung; ?></div>
                        <div class="news-more"><?php echo $xemthem; ?></div>
                        <div class="news-meta">
                            <span><i class="far fa-calendar-alt"></i> <?php echo $ngaydang; ?></span>
                            <span style="margin-left: 15px;"><i class="far fa-eye"></i> <?php echo number_format($tin['luotxem_tt']); ?> lượt xem</span>
                        </div>
                        <button class="toggle-btn" onclick="toggleMore(this)">Xem thêm</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        function toggleMore(button) {
            const moreText = button.previousElementSibling.previousElementSibling; // Lấy phần news-more
            if (moreText.style.display === "none" || moreText.style.display === "") {
                moreText.style.display = "block";
                button.textContent = "Ẩn bớt";
            } else {
                moreText.style.display = "none";
                button.textContent = "Xem thêm";
            }
        }
    </script>
</body>
</html>