<link rel="stylesheet" href="styleadmin.css">
<title>Admin Thanh Sơn Auto</title>
<?php
session_start();
include "dbconnect.php";

// Xử lý đăng ký
if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Đăng ký thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Xử lý đăng nhập
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user"] = $username;
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Người dùng không tồn tại!";
    }
}

// Đăng xuất
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION["user"])) {
?>
    <h2>Đăng nhập / Đăng ký</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit" name="login">Đăng nhập</button>
        <button type="submit" name="register">Đăng ký</button>
    </form>
<?php
    exit();
}
?>

<!-- Giao diện admin sau khi đăng nhập -->
<h2>Admin Thanh Sơn Auto</h2>
<form method="post">
    <button type="submit" name="logout">Đăng xuất</button>
</form>

<!-- Nút điều hướng các phần quản lý -->
<div class="admin-menu">
    <button class="admin-toggle active" onclick="toggleSection('sanpham')">Quản lý Sản phẩm</button>
    <button class="admin-toggle" onclick="toggleSection('chitietsp')">Quản lý Chi tiết Sản phẩm</button>
    <button class="admin-toggle" onclick="toggleSection('tintuc')">Quản lý Tin tức</button>
    <button class="admin-toggle" onclick="toggleSection('chitiet_tintuc')">Quản lý Chi tiết Tin tức</button>
    <button class="admin-toggle" onclick="toggleSection('quangcao')">Quản lý Quảng cáo</button>
    <button class="admin-toggle" onclick="window.location.href='qldonhang.php'">Quản lý Đơn Hàng</button>
<div id="order-container"></div>
</div>

<hr>

<!-- ================== BẮT ĐẦU: Quản lý Sản phẩm ================== -->
<div class="admin-section" id="sanpham" style="display: block;">
    <h3>Quản lý Sản phẩm</h3>
    <?php
    // Xử lý thêm sản phẩm
    if (isset($_POST["add_product"])) {
        $id_xe = $_POST["id_xe"];
        $ma_xe = $_POST["ma_xe"];
        $ten_xe = $_POST["ten_xe"];
        $gia_xe = $_POST["gia_xe"];
        $anh_xe = $_POST["anh_xe"];
        $hang_xe = $_POST["hang_xe"];
        $sql = "INSERT INTO sanpham (id_xe, ma_xe, ten_xe, gia_xe, anh_xe, hang_xe) 
                VALUES ('$id_xe', '$ma_xe', '$ten_xe', '$gia_xe', '$anh_xe', '$hang_xe')";
        $conn->query($sql);
    }

    // Xử lý xóa sản phẩm
    if (isset($_POST["delete_product"])) {
        $id_xe = $_POST["id_xe"];
        $sql = "DELETE FROM sanpham WHERE id_xe='$id_xe'";
        $conn->query($sql);
    }

    // Xử lý cập nhật sản phẩm
    if (isset($_POST["update_product"])) {
        $id_xe = $_POST["id_xe"];
        $ten_xe = $_POST["ten_xe"];
        $gia_xe = $_POST["gia_xe"];
        $anh_xe = $_POST["anh_xe"];
        $hang_xe = $_POST["hang_xe"];
        $sql = "UPDATE sanpham SET ten_xe='$ten_xe', gia_xe='$gia_xe', anh_xe='$anh_xe', hang_xe='$hang_xe' WHERE id_xe='$id_xe'";
        $conn->query($sql);
    }

    // Hiển thị danh sách sản phẩm
    $result = $conn->query("SELECT * FROM sanpham");
    echo "<table border='1'>";
    echo "<tr><th>ID xe</th><th>Mã xe</th><th>Tên xe</th><th>Giá xe</th><th>Ảnh</th><th>Tình trạng xe</th><th>Hành động</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_xe']}</td>";
        echo "<td>{$row['ma_xe']}</td>";
        echo "<td>{$row['ten_xe']}</td>";
        echo "<td>{$row['gia_xe']}</td>";
        echo "<td><img src='IMG/{$row['anh_xe']}' width='100'></td>";
        echo "<td>{$row['hang_xe']}</td>";
        echo "<td>";
        echo "<form method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id_xe' value='{$row['id_xe']}'>";
        echo "<button type='submit' name='delete_product'>Xóa</button>";
        echo "</form>";
        echo "<form method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id_xe' value='{$row['id_xe']}'>";
        echo "<input type='text' name='ten_xe' value='{$row['ten_xe']}' required>";
        echo "<input type='number' name='gia_xe' value='{$row['gia_xe']}' required>";
        echo "<input type='text' name='anh_xe' value='{$row['anh_xe']}' required>";
        echo "<input type='text' name='hang_xe' value='{$row['hang_xe']}' required>";
        echo "<button type='submit' name='update_product'>Cập nhật</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <!-- Form thêm sản phẩm -->
    <form method="post">
        <input type="number" name="id_xe" placeholder="ID xe" required>
        <input type="text" name="ma_xe" placeholder="Mã xe" required>
        <input type="text" name="ten_xe" placeholder="Tên xe" required>
        <input type="number" name="gia_xe" placeholder="Giá xe" required>
        <input type="text" name="anh_xe" placeholder="Link ảnh xe" required>
        <input type="text" name="hang_xe" placeholder="Tình trạng xe" required>
        <button type="submit" name="add_product">Thêm sản phẩm</button>
    </form>
</div>
<!-- ================== KẾT THÚC: Quản lý Sản phẩm ================== -->

<!-- ================== BẮT ĐẦU: Quản lý Chi tiết Sản phẩm ================== -->
<div class="admin-section" id="chitietsp" style="display: none;">
    <h3>Quản lý Chi Tiết Sản Phẩm</h3>

    <?php
    // Xử lý thêm chi tiết sản phẩm
    if (isset($_POST["add_detail"])) {
        $id_xe = $conn->real_escape_string($_POST["id_xe"]);
        $ten_xe = $conn->real_escape_string($_POST["ten_xe"]);
        $gia_xe = $conn->real_escape_string($_POST["gia_xe"]);
        $namsx_xe = $conn->real_escape_string($_POST["namsx_xe"]);
        $nhienlieu_xe = $conn->real_escape_string($_POST["nhienlieu_xe"]);
        $sodo_xe = $conn->real_escape_string($_POST["sodo_xe"]);
        $hopso_xe = $conn->real_escape_string($_POST["hopso_xe"]);
        $hang_xe = $conn->real_escape_string($_POST["hang_xe"]);
        $dong_xe = $conn->real_escape_string($_POST["dong_xe"]);
        $kieu_xe = $conn->real_escape_string($_POST["kieu_xe"]);
        $diadiem_xe = $conn->real_escape_string($_POST["diadiem_xe"]);
        $showroom_xe = $conn->real_escape_string($_POST["showroom_xe"]);
        $mota_xe = $conn->real_escape_string($_POST["mota_xe"]);
        $hinhanh_xe = $conn->real_escape_string($_POST["hinhanh_xe"]);
        $lien_he = $conn->real_escape_string($_POST["lien_he"]);
        $hinhanh_chitiet = $conn->real_escape_string($_POST["hinhanh_chitiet"]);
        
        $sql = "INSERT INTO chitietsp (id_xe, ten_xe, gia_xe, namsx_xe, nhienlieu_xe, sodo_xe, hopso_xe, hang_xe, dong_xe, kieu_xe, diadiem_xe, showroom_xe, mota_xe, hinhanh_xe, lien_he, hinhanh_chitiet)
                VALUES ('$id_xe', '$ten_xe', '$gia_xe', '$namsx_xe', '$nhienlieu_xe', '$sodo_xe', '$hopso_xe', '$hang_xe', '$dong_xe', '$kieu_xe', '$diadiem_xe', '$showroom_xe', '$mota_xe', '$hinhanh_xe', '$lien_he', '$hinhanh_chitiet')";
        $conn->query($sql);
    }

    // Xử lý xóa chi tiết sản phẩm
    if (isset($_POST["delete_detail"])) {
        $id_xe = $_POST["id_xe"];
        $sql = "DELETE FROM chitietsp WHERE id_xe='$id_xe'";
        $conn->query($sql);
    }

    // Xử lý cập nhật chi tiết sản phẩm
    if (isset($_POST["update_detail"])) {
        $id_xe = $_POST["id_xe"];
        $ten_xe = $conn->real_escape_string($_POST["ten_xe"]);
        $gia_xe = $conn->real_escape_string($_POST["gia_xe"]);
        $namsx_xe = $conn->real_escape_string($_POST["namsx_xe"]);
        $nhienlieu_xe = $conn->real_escape_string($_POST["nhienlieu_xe"]);
        $sodo_xe = $conn->real_escape_string($_POST["sodo_xe"]);
        $hopso_xe = $conn->real_escape_string($_POST["hopso_xe"]);
        $hang_xe = $conn->real_escape_string($_POST["hang_xe"]);
        $dong_xe = $conn->real_escape_string($_POST["dong_xe"]);
        $kieu_xe = $conn->real_escape_string($_POST["kieu_xe"]);
        $diadiem_xe = $conn->real_escape_string($_POST["diadiem_xe"]);
        $showroom_xe = $conn->real_escape_string($_POST["showroom_xe"]);
        $mota_xe = $conn->real_escape_string($_POST["mota_xe"]);
        $hinhanh_xe = $conn->real_escape_string($_POST["hinhanh_xe"]);
        $lien_he = $conn->real_escape_string($_POST["lien_he"]);
        $hinhanh_chitiet = $conn->real_escape_string($_POST["hinhanh_chitiet"]);
        
        $sql = "UPDATE chitietsp SET 
                id_xe='$id_xe', 
                ten_xe='$ten_xe', 
                gia_xe='$gia_xe', 
                namsx_xe='$namsx_xe', 
                nhienlieu_xe='$nhienlieu_xe', 
                sodo_xe='$sodo_xe', 
                hopso_xe='$hopso_xe', 
                hang_xe='$hang_xe', 
                dong_xe='$dong_xe', 
                kieu_xe='$kieu_xe', 
                diadiem_xe='$diadiem_xe', 
                showroom_xe='$showroom_xe', 
                mota_xe='$mota_xe', 
                hinhanh_xe='$hinhanh_xe', 
                lien_he='$lien_he', 
                hinhanh_chitiet='$hinhanh_chitiet' 
                WHERE id_xe='$id_xe'";
        $conn->query($sql);
    }

    // Hiển thị danh sách chi tiết sản phẩm
    $result = $conn->query("SELECT * FROM chitietsp");
    echo "<div style='overflow-x:auto;'>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>STT</th>
            <th>Tên xe</th>
            <th>Giá</th>
            <th>Năm SX</th>
            <th>Nhiên liệu</th>
            <th>Số odo</th>
            <th>Hộp số</th>
            <th>Hãng</th>
            <th>Dòng xe</th>
            <th>Kiểu xe</th>
            <th>Địa điểm</th>
            <th>Showroom</th>
            <th>Mô tả</th>
            <th>Ảnh đại diện</th>
            <th>Liên hệ</th>
            <th>Ảnh chi tiết</th>
            <th>Hành động</th>
          </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<form method='post'>";
        echo "<td>{$row['id_xe']}</td>";
        echo "<td><input type='number' name='id_xe' value='{$row['id_xe']}'></td>";
        echo "<td><input type='text' name='ten_xe' value='{$row['ten_xe']}'></td>";
        echo "<td><input type='text' name='gia_xe' value='{$row['gia_xe']}'></td>";
        echo "<td><input type='text' name='namsx_xe' value='{$row['namsx_xe']}'></td>";
        echo "<td><input type='text' name='nhienlieu_xe' value='{$row['nhienlieu_xe']}'></td>";
        echo "<td><input type='text' name='sodo_xe' value='{$row['sodo_xe']}'></td>";
        echo "<td><input type='text' name='hopso_xe' value='{$row['hopso_xe']}'></td>";
        echo "<td><input type='text' name='hang_xe' value='{$row['hang_xe']}'></td>";
        echo "<td><input type='text' name='dong_xe' value='{$row['dong_xe']}'></td>";
        echo "<td><input type='text' name='kieu_xe' value='{$row['kieu_xe']}'></td>";
        echo "<td><input type='text' name='diadiem_xe' value='{$row['diadiem_xe']}'></td>";
        echo "<td><input type='text' name='showroom_xe' value='{$row['showroom_xe']}'></td>";
        echo "<td><textarea name='mota_xe'>{$row['mota_xe']}</textarea></td>";
        echo "<td><input type='text' name='hinhanh_xe' value='{$row['hinhanh_xe']}'><br><img src='IMG/{$row['hinhanh_xe']}' width='100'></td>";
        echo "<td><input type='text' name='lien_he' value='{$row['lien_he']}'></td>"; 
		echo "<td><input type='text' name='hinhanh_chitiet' value='{$row['hinhanh_chitiet']}'>";
        $images = explode(",", $row['hinhanh_chitiet']);
        echo "<div style='white-space: nowrap;'>";
        foreach ($images as $img) {
        $img = trim($img); // loại bỏ khoảng trắng
        echo "<img src='IMG/{$img}' width='100' style='margin-right: 5px; display: inline-block;'>";
        }
        echo "</div></td>";

        
		echo "<td>
                <input type='hidden' name='id_xe' value='{$row['id_xe']}'>
                <button type='submit' name='update_detail'>Cập nhật</button>
                <button type='submit' name='delete_detail' onclick=\"return confirm('Xóa chi tiết sản phẩm này?')\">Xóa</button>
              </td>";
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    ?>

    <h4>Thêm chi tiết sản phẩm mới</h4>
    <form method="post">
        <div class="form-row">
            <input type="text" name="id_xe" placeholder="ID xe" required>
            <input type="text" name="id_xe" placeholder="STT" required>
            <input type="text" name="ten_xe" placeholder="Tên xe" required>
            <input type="text" name="gia_xe" placeholder="Giá xe" required>
            <input type="text" name="namsx_xe" placeholder="Năm sản xuất" required>
        </div>
        
        <div class="form-row">
            <input type="text" name="nhienlieu_xe" placeholder="Nhiên liệu" required>
            <input type="text" name="sodo_xe" placeholder="Số odo" required>
            <input type="text" name="hopso_xe" placeholder="Hộp số" required>
        </div>
        
        <div class="form-row">
            <input type="text" name="hang_xe" placeholder="Hãng xe" required>
            <input type="text" name="dong_xe" placeholder="Dòng xe" required>
            <input type="text" name="kieu_xe" placeholder="Kiểu xe" required>
        </div>
        
        <div class="form-row">
            <input type="text" name="diadiem_xe" placeholder="Địa điểm" required>
            <input type="text" name="showroom_xe" placeholder="Showroom" required>
            <input type="text" name="lien_he" placeholder="Liên hệ" required>
        </div>
        
        <div class="form-row">
            <input type="text" name="hinhanh_xe" placeholder="Link ảnh đại diện" required>
            <input type="text" name="hinhanh_chitiet" placeholder="Link ảnh chi tiết" required>
        </div>
        
        <div class="form-row">
            <textarea name="mota_xe" placeholder="Mô tả chi tiết" required></textarea>
        </div>
        
        <button type="submit" name="add_detail">Thêm chi tiết sản phẩm</button>
    </form>
</div>

<!-- ================== BẮT ĐẦU: Quản lý Tin tức ================== -->
<div class="admin-section" id="tintuc" style="display: none;">
    <h3>Quản lý Tin tức</h3>

    <?php
    // Xử lý thêm tin tức
    if (isset($_POST["add_news"])) {
        $id_tt = $conn->real_escape_string($_POST["id_tt"]);
        $anh_tt = $conn->real_escape_string($_POST["anh_tt"]);
        $tt_tt = $conn->real_escape_string($_POST["tt_tt"]);
        $xemthem_tt = $conn->real_escape_string($_POST["xemthem_tt"]);
        $ngaydang_tt = date("Y-m-d H:i:s");
        $luotxem_tt = 0; 
        $tomtat_tt = $conn->real_escape_string($_POST["tomtat_tt"]);

        $sql = "INSERT INTO tintuc (id_tt, anh_tt, tt_tt, xemthem_tt, ngaydang_tt, luotxem_tt, tomtat_tt) VALUES ('$id_tt', '$anh_tt', '$tt_tt', '$xemthem_tt', '$ngaydang_tt', '$luotxem_tt', '$tomtat_tt')";
        $conn->query($sql);
    }

    // Xử lý xóa tin tức
    if (isset($_POST["delete_news"])) {
        $id_tt = $conn->real_escape_string($_POST["id_tt"]);
        $sql = "DELETE FROM tintuc WHERE id_tt='$id_tt'";
        $conn->query($sql);
    }

    // Xử lý cập nhật tin tức
    if (isset($_POST["update_news"])) {
        $id_tt = $conn->real_escape_string($_POST["id_tt"]);
        $anh_tt = $conn->real_escape_string($_POST["anh_tt"]);
        $tt_tt = $conn->real_escape_string($_POST["tt_tt"]);
        $xemthem_tt = $conn->real_escape_string($_POST["xemthem_tt"]);
        $tomtat_tt = $conn->real_escape_string($_POST["tomtat_tt"]);

        $sql = "UPDATE tintuc SET id_tt='$id_tt', anh_tt='$anh_tt', tt_tt='$tt_tt', xemthem_tt='$xemthem_tt', tomtat_tt='$tomtat_tt' WHERE id_tt='$id_tt'";
        $conn->query($sql);
    }

    // Hiển thị danh sách tin tức
    $result = $conn->query("SELECT * FROM tintuc");
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID tin tức</th><th>Ảnh</th><th>Tiêu đề / Nội dung</th><th>Xem thêm</th><th>Ngày đăng</th><th>Lượt xem</th><th>Tóm tắt</th><th>Hành động</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<form method='post'>";
        echo "<td><textarea name='id_tt'>{$row['id_tt']}</textarea></td>";
        echo "<td><input type='text' name='anh_tt' value='{$row['anh_tt']}'><br><img src='IMG/{$row['anh_tt']}' width='100'></td>";
        echo "<td><textarea name='tt_tt'>{$row['tt_tt']}</textarea></td>";
        echo "<td><textarea name='xemthem_tt'>{$row['xemthem_tt']}</textarea></td>";
        echo "<td>{$row['ngaydang_tt']}</td>";
        echo "<td>{$row['luotxem_tt']}</td>";
        echo "<td><textarea name='tomtat_tt'>{$row['tomtat_tt']}</textarea></td>";
        echo "<td>
                <input type='hidden' name='id_tt' value='{$row['id_tt']}'>
                <button type='submit' name='update_news'>Cập nhật</button>
              </form>
              <form method='post' style='display:inline'>
                <input type='hidden' name='id_tt' value='{$row['id_tt']}'>
                <button type='submit' name='delete_news' onclick=\"return confirm('Xóa tin tức này?')\">Xóa</button>
              </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <h4>Thêm tin tức mới</h4>
    <form method="post">
        <textarea name="id_tt" placeholder="ID tin tức" required></textarea>
        <input type="text" name="anh_tt" placeholder="Link ảnh tin tức" required>
        <textarea name="tt_tt" placeholder="Tiêu đề / Nội dung tin tức" required></textarea>
        <textarea name="xemthem_tt" placeholder="Nội dung xem thêm" required></textarea>
        <textarea name="tomtat_tt" placeholder="Tóm tắt tin tức" required></textarea>
        <button type="submit" name="add_news">Thêm tin tức</button>
    </form>
</div>

<!-- ================== BẮT ĐẦU: Quản lý Chi tiết Tin tức ================== -->
<div class="admin-section" id="chitiet_tintuc" style="display: none;">
    <h3>Quản lý Chi tiết Tin tức</h3>
    <?php
    // Xử lý thêm chi tiết tin tức
    if (isset($_POST["add_detail_tt"])) {
        $id_tt = $conn->real_escape_string($_POST["id_tt"]);
        $anh_tt = $conn->real_escape_string($_POST["anh_tt"]);
        $xemthem_tt = $conn->real_escape_string($_POST["xemthem_tt"]);
        $noidung_tt = $conn->real_escape_string($_POST["noidung_tt"]);

        $sql = "INSERT INTO chitiettt (id_tt, anh_tt, xemthem_tt, noidung_tt) 
                VALUES ('$id_tt', '$anh_tt', '$xemthem_tt', '$noidung_tt')";
        $conn->query($sql);
    }

    // Xử lý xóa chi tiết tin tức
    if (isset($_POST["delete_detail_tt"])) {
        $id_tt = $_POST["id_tt"];
        $sql = "DELETE FROM chitiettt WHERE id_tt='$id_tt'";
        $conn->query($sql);
    }

    // Xử lý cập nhật chi tiết tin tức
    if (isset($_POST["update_detail_tt"])) {
        $id_tt = $conn->real_escape_string($_POST["id_tt"]);
        $anh_tt = $conn->real_escape_string($_POST["anh_tt"]);
        $xemthem_tt = $conn->real_escape_string($_POST["xemthem_tt"]);
        $noidung_tt = $conn->real_escape_string($_POST["noidung_tt"]);

        $sql = "UPDATE chitiettt SET 
                id_tt='$id_tt',
                anh_tt='$anh_tt',
                xemthem_tt='$xemthem_tt',
                noidung_tt='$noidung_tt'
                WHERE id_tt='$id_tt'";
        $conn->query($sql);
    }

    // Hiển thị danh sách chi tiết tin tức
    $result = $conn->query("SELECT * FROM chitiettt");
    echo "<div style='overflow-x:auto;'>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID Tin Tức</th>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Xem thêm</th>
            <th>Nội dung</th>
            <th>Hành động</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<form method='post'>";
        echo "<td>{$row['id_tt']}</td>";
        echo "<td><input type='text' name='id_tt' value='{$row['id_tt']}'></td>";
        echo "<td><input type='text' name='anh_tt' value='{$row['anh_tt']}'>";
$images = explode(",", $row['anh_tt']);
echo "<div style='white-space: nowrap;'>";
foreach ($images as $img) {
    $img = trim($img); // loại bỏ khoảng trắng
    echo "<img src='IMG/{$img}' width='100' style='margin-right: 5px; display: inline-block;'>";
}
echo "</div></td>";

        echo "<td><input type='text' name='xemthem_tt' value='{$row['xemthem_tt']}'></td>";
        echo "<td><textarea name='noidung_tt'>{$row['noidung_tt']}</textarea></td>";
        echo "<td>
                <input type='hidden' name='id_tt' value='{$row['id_tt']}'>
                <button type='submit' name='update_detail_tt'>Cập nhật</button>
                <button type='submit' name='delete_detail_tt' onclick=\"return confirm('Xóa chi tiết tin tức này?')\">Xóa</button>
              </td>";
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    ?>

    <h4>Thêm Chi Tiết Tin Tức Mới</h4>
    <form method="post">
        <div class="form-row">
            <input type="text" name="id_tt" placeholder="ID Tin Tức" required>
            <input type="text" name="id_tt" placeholder="STT" required>
        </div>

        <div class="form-row">
            <input type="text" name="anh_tt" placeholder="Link ảnh" required>
            <input type="text" name="xemthem_tt" placeholder="Xem thêm" required>
        </div>

        <div class="form-row">
            <textarea name="noidung_tt" placeholder="Nội dung chi tiết" required></textarea>
        </div>

        <button type="submit" name="add_detail_tt">Thêm chi tiết tin tức</button>
    </form>
</div>

<!-- ================== BẮT ĐẦU: Quản lý Quảng cáo ================== -->
<div class="admin-section" id="quangcao" style="display: none;">
    <h3>Quản lý Quảng cáo</h3>

    <?php
    // Xử lý thêm quảng cáo
    if (isset($_POST["add_ad"])) {
        $ten_xe = $conn->real_escape_string($_POST["ten_xe"]);
        $hinh_anh = $conn->real_escape_string($_POST["hinh_anh"]);
        $gia = $conn->real_escape_string($_POST["gia"]);
        $tinh_nang = $conn->real_escape_string($_POST["tinh_nang"]);
        $trang_thai = $conn->real_escape_string($_POST["trang_thai"]);
        $ngay_tao = date("Y-m-d H:i:s");
        $ngay_cap_nhat = date("Y-m-d H:i:s");

        $sql = "INSERT INTO quangcao (ten_xe, hinh_anh, gia, tinh_nang, trang_thai, ngay_tao, ngay_cap_nhat) 
                VALUES ('$ten_xe', '$hinh_anh', '$gia', '$tinh_nang', '$trang_thai', '$ngay_tao', '$ngay_cap_nhat')";
        $conn->query($sql);
    }

    // Xử lý xóa quảng cáo
    if (isset($_POST["delete_ad"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM quangcao WHERE id='$id'";
        $conn->query($sql);
    }

    // Xử lý cập nhật quảng cáo
    if (isset($_POST["update_ad"])) {
        $id = $conn->real_escape_string($_POST["id"]);
        $ten_xe = $conn->real_escape_string($_POST["ten_xe"]);
        $hinh_anh = $conn->real_escape_string($_POST["hinh_anh"]);
        $gia = $conn->real_escape_string($_POST["gia"]);
        $tinh_nang = $conn->real_escape_string($_POST["tinh_nang"]);
        $trang_thai = $conn->real_escape_string($_POST["trang_thai"]);
        $ngay_cap_nhat = date("Y-m-d H:i:s");

        $sql = "UPDATE quangcao SET 
                ten_xe='$ten_xe', 
                hinh_anh='$hinh_anh', 
                gia='$gia', 
                tinh_nang='$tinh_nang', 
                trang_thai='$trang_thai', 
                ngay_cap_nhat='$ngay_cap_nhat' 
                WHERE id='$id'";
        $conn->query($sql);
    }

    // Hiển thị danh sách quảng cáo
    $result = $conn->query("SELECT * FROM quangcao");
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Tên xe</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Tính năng</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Ngày cập nhật</th>
            <th>Hành động</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<form method='post'>";
        echo "<td>{$row['id']}</td>";
        echo "<td><input type='text' name='ten_xe' value='{$row['ten_xe']}' required></td>";
        echo "<td>
                <input type='text' name='hinh_anh' value='{$row['hinh_anh']}' required><br>
                <img src='IMG/{$row['hinh_anh']}' alt='Hình xe' width='100'>
              </td>";
        echo "<td><input type='text' name='gia' value='{$row['gia']}' required></td>";
        echo "<td><input type='text' name='tinh_nang' value='{$row['tinh_nang']}' required></td>";
        echo "<td><input type='text' name='trang_thai' value='{$row['trang_thai']}' required></td>";
        echo "<td>{$row['ngay_tao']}</td>";
        echo "<td>{$row['ngay_cap_nhat']}</td>";
        echo "<td>
                <input type='hidden' name='id' value='{$row['id']}'>
                <button type='submit' name='update_ad'>Cập nhật</button>
                <button type='submit' name='delete_ad' onclick=\"return confirm('Bạn có chắc muốn xóa quảng cáo này?');\">Xóa</button>
              </td>";
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

 <h4>Thêm Quảng cáo mới</h4>
<form method="post" style="width: 400px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td>Tên xe:</td>
            <td><input type="text" name="ten_xe" style="width: 100%;" required></td>
        </tr>
        <tr>
            <td>Hình ảnh (URL):</td>
            <td><input type="text" name="hinh_anh" style="width: 100%;" required></td>
        </tr>
        <tr>
            <td>Giá:</td>
            <td><input type="text" name="gia" style="width: 100%;" required></td>
        </tr>
        <tr>
            <td>Tính năng:</td>
            <td><input type="text" name="tinh_nang" style="width: 100%;" required></td>
        </tr>
        <tr>
            <td>Trạng thái:</td>
            <td><input type="text" name="trang_thai" style="width: 100%;" required></td>
        </tr>
    </table>
    <button type="submit" name="add_ad" style="margin-top: 10px; padding: 5px 10px; background-color: green; color: white; border: none;">Thêm Quảng cáo</button>
</form>
<script>
function toggleSection(sectionId) {
    const sections = ['sanpham', 'chitietsp', 'tintuc', 'chitiet_tintuc', 'quangcao'];
    sections.forEach(id => {
        const section = document.getElementById(id);
        if (section) {
            section.style.display = (id === sectionId) ? 'block' : 'none';
        }
    });

    // Cập nhật class active cho nút đang chọn
    const buttons = document.querySelectorAll('.admin-toggle');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}
</script>




