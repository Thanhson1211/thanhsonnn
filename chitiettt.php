<?php include 'header.php'; ?>
<?php
include("dbconnect.php");
$id = isset($_GET['id_tt']) ? intval($_GET['id_tt']) : 0;

// Lấy dữ liệu từ bảng chitiettt và tintuc
$query = "SELECT ct.*, tt.tt_tt, tt.ngaydang_tt, tt.luotxem_tt, tt.tomtat_tt 
          FROM chitiettt ct 
          JOIN tintuc tt ON ct.id_tt = tt.id_tt 
          WHERE ct.id_tt = $id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
$tintuc = mysqli_fetch_assoc($result);
if (!$tintuc) {
    die("Không tìm thấy tin tức với ID này.");
}

// Tăng lượt xem
mysqli_query($conn, "UPDATE tintuc SET luotxem_tt = luotxem_tt + 1 WHERE id_tt = $id");

// Xử lý ảnh - lấy tất cả ảnh từ cả anh_tt và xemthem_tt
$images = [];
if (!empty($tintuc['anh_tt'])) {
    $imageList = explode(',', $tintuc['anh_tt']);
    foreach ($imageList as $img) {
        $img = trim($img);
        if (!empty($img)) {
            $images[] = $img;
        }
    }
}
if (!empty($tintuc['xemthem_tt'])) {
    $details = explode(',', $tintuc['xemthem_tt']);
    foreach ($details as $img) {
        $img = trim($img);
        if (!empty($img) && !in_array($img, $images)) {
            $images[] = $img;
        }
    }
}
$images = array_slice($images, 0, 5);

// Format ngày đăng
$ngaydang = date('d/m/Y', strtotime($tintuc['ngaydang_tt']));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($tintuc['tt_tt']); ?> - Đánh giá chi tiết</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($tintuc['tomtat_tt']); ?>">
    <!-- Font Awesome + Swiper -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        :root {
            --primary-color: #e10c00;
            --secondary-color: #333;
            --light-gray: #f5f5f5;
            --dark-gray: #666;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .breadcrumb {
            padding: 10px 0;
            font-size: 14px;
            color: var(--dark-gray);
        }
        
        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .article-header {
            margin-bottom: 20px;
        }
        
        .article-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .article-meta {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }
        
        .article-meta span {
            margin-right: 15px;
        }
        
        .article-meta i {
            margin-right: 5px;
            color: var(--primary-color);
        }
        
        .article-gallery {
            margin-bottom: 30px;
        }
        
        .main-gallery {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        
        .main-gallery img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .thumbnail-gallery img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border: 1px solid #ddd;
            cursor: pointer;
            border-radius: 3px;
            transition: transform 0.3s;
        }
        
        .thumbnail-gallery img:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }
        
        .article-summary {
            background: var(--light-gray);
            padding: 15px;
            border-left: 3px solid var(--primary-color);
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .article-content {
            margin-bottom: 30px;
        }
        
        .article-content p {
            margin-bottom: 15px;
            text-align: justify;
        }
        
        .article-content img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
            display: block;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .inline-images {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }
        
        .inline-images img {
            width: 50%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .article-content h2, 
        .article-content h3 {
            color: var(--primary-color);
            margin: 20px 0 15px;
        }
        
        .article-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .tag {
            background: var(--light-gray);
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 14px;
        }
        
        .back-button {
            margin-top: 30px;
        }
        
        .back-button a {
            display: inline-block;
            padding: 10px 15px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        .back-button a:hover {
            background: #c00;
        }
        
        @media (max-width: 768px) {
            .article-title {
                font-size: 22px;
            }
            
            .thumbnail-gallery {
                overflow-x: auto;
                padding-bottom: 10px;
                flex-wrap: nowrap;
            }
            
            .thumbnail-gallery img {
                width: 80px;
                height: 60px;
            }
            
            .inline-images {
                flex-direction: column;
            }
            
            .inline-images img {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a> &raquo; 
            <a href="index.php?page=news">Tin tức</a> &raquo; 
            <span><?php echo htmlspecialchars($tintuc['tt_tt']); ?></span>
        </div>
        
        <div class="article-header">
            <h1 class="article-title"><?php echo htmlspecialchars($tintuc['tt_tt']); ?></h1>
            <div class="article-meta">
                <span><i class="far fa-calendar-alt"></i> <?php echo $ngaydang; ?></span>
                <span><i class="far fa-eye"></i> <?php echo number_format($tintuc['luotxem_tt']); ?> lượt xem</span>
            </div>
        </div>
        
        <?php if (!empty($images)): ?>
        <div class="article-gallery">
            <div class="main-gallery">
                <img src="IMG/<?php echo htmlspecialchars($images[0]); ?>" alt="<?php echo htmlspecialchars($tintuc['tt_tt']); ?>">
            </div>
            <?php if (count($images) > 1): ?>
            <div class="thumbnail-gallery">
                <?php foreach ($images as $index => $img): ?>
                    <img src="IMG/<?php echo htmlspecialchars($img); ?>" 
                         alt="Ảnh <?php echo $index + 1; ?>" 
                         onclick="document.querySelector('.main-gallery img').src = this.src">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($tintuc['tomtat_tt'])): ?>
        <div class="article-summary">
            <?php echo htmlspecialchars($tintuc['tomtat_tt']); ?>
        </div>
        <?php endif; ?>
        
        <div class="article-content">
            <?php
            // Tách nội dung thành các đoạn
            $paragraphs = explode("\n", $tintuc['noidung_tt']);
            
            // Hiển thị đoạn đầu tiên
            if (!empty($paragraphs[0])) {
                echo '<p>' . htmlspecialchars(trim($paragraphs[0])) . '</p>';
            }
            
            // Hiển thị 2 ảnh đầu tiên sau đoạn đầu (nếu có)
            if (count($images) >= 3) {
                echo '<div class="inline-images">';
                echo '<img src="IMG/' . htmlspecialchars($images[1]) . '" alt="' . htmlspecialchars($tintuc['tt_tt']) . ' - Ảnh 1">';
                echo '<img src="IMG/' . htmlspecialchars($images[2]) . '" alt="' . htmlspecialchars($tintuc['tt_tt']) . ' - Ảnh 2">';
                echo '</div>';
            }
            
            // Hiển thị các đoạn còn lại
            for ($i = 1; $i < count($paragraphs); $i++) {
                if (!empty(trim($paragraphs[$i]))) {
                    echo '<p>' . htmlspecialchars(trim($paragraphs[$i])) . '</p>';
                    
                    // Chèn ảnh thứ 3 sau đoạn thứ 2 (nếu có)
                    if ($i == 2 && isset($images[3])) {
                        echo '<img src="IMG/' . htmlspecialchars($images[3]) . '" alt="' . htmlspecialchars($tintuc['tt_tt']) . ' - Ảnh 3">';
                    }
                }
            }
            ?>
        </div>
        
        <div class="article-tags">
            <span class="tag">Đánh giá xe</span>
            <span class="tag">Tin tức ô tô</span>
        </div>
        
        <div class="back-button">
	            <a href="<?php echo $_SERVER['PHP_SELF'] == 'index.php' ? '#news-section' : 'index.php#news-section'; ?>" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại danh sách tin tức</a>
            
        </div>
    </div>
</body>
</html>