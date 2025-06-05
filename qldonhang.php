<?php
include 'dbconnect.php'; // Kết nối CSDL
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn hàng - Admin Thanh Sơn Auto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: top;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        select, button, input {
            padding: 5px 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            margin: 2px;
        }

        button[name="delete_order"] {
            background-color: #dc3545;
        }

        button[name="edit_order"] {
            background-color: #ffc107;
            color: #000;
        }

        button:hover {
            opacity: 0.85;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #5a6268;
        }

        .product-detail {
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #ccc;
        }

        .edit-form {
            background-color: #fffde7;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
        }
    </style>
</head>
<body>

<h3>Các đơn hàng đã đặt - Thanh Sơn Auto</h3>

<?php
// Cập nhật trạng thái đơn hàng
if (isset($_POST["update_order"])) {
    $id = $conn->real_escape_string($_POST["id"]);
    $status = $conn->real_escape_string($_POST["status"]);
    $sql = "UPDATE orders SET status='$status', updated_at=NOW() WHERE id='$id'";
    $conn->query($sql);
    
    // Thêm thông báo khi cập nhật trạng thái
    $title = "Cập nhật trạng thái đơn hàng";
    $message = "Đơn hàng #$id đã được cập nhật trạng thái thành: $status";
    $conn->query("INSERT INTO admin_notifications (type, title, message, order_id, is_read, created_at) 
                 VALUES ('order', '$title', '$message', '$id', 0, NOW())");
}

// Xóa đơn hàng
if (isset($_POST["delete_order"])) {
    $id = $conn->real_escape_string($_POST["id"]);
    $conn->query("DELETE FROM order_items WHERE order_id='$id'");
    $conn->query("DELETE FROM admin_notifications WHERE order_id='$id'");
    $conn->query("DELETE FROM orders WHERE id='$id'");
}

// Cập nhật thông tin đơn hàng và sản phẩm
if (isset($_POST["save_edit"])) {
    $order_id = $conn->real_escape_string($_POST["order_id"]);
    
    // Cập nhật thông tin khách hàng
    $customer_name = $conn->real_escape_string($_POST["customer_name"]);
    $customer_phone = $conn->real_escape_string($_POST["customer_phone"]);
    $customer_email = $conn->real_escape_string($_POST["customer_email"]);
    $customer_address = $conn->real_escape_string($_POST["customer_address"]);
    $customer_note = $conn->real_escape_string($_POST["customer_note"]);
    $payment_method = $conn->real_escape_string($_POST["payment_method"]);
    $status = $conn->real_escape_string($_POST["status"]);
    
    $sql = "UPDATE orders SET 
            customer_name='$customer_name',
            customer_phone='$customer_phone',
            customer_email='$customer_email',
            customer_address='$customer_address',
            customer_note='$customer_note',
            payment_method='$payment_method',
            status='$status',
            updated_at=NOW()
            WHERE id='$order_id'";
    $conn->query($sql);
    
    // Cập nhật sản phẩm trong đơn hàng
    if (isset($_POST["product_id"])) {
        $product_ids = $_POST["product_id"];
        $quantities = $_POST["quantity"];
        
        // Xóa các sản phẩm cũ
        $conn->query("DELETE FROM order_items WHERE order_id='$order_id'");
        
        // Thêm lại các sản phẩm với số lượng mới
        $total_amount = 0;
        foreach ($product_ids as $index => $product_id) {
            $product_id = $conn->real_escape_string($product_id);
            $quantity = $conn->real_escape_string($quantities[$index]);
            
            // Lấy thông tin sản phẩm từ database
            $product_query = $conn->query("SELECT name, price, image FROM products WHERE id='$product_id'");
            if ($product_query->num_rows > 0) {
                $product = $product_query->fetch_assoc();
                $subtotal = $product['price'] * $quantity;
                $total_amount += $subtotal;
                
                $conn->query("INSERT INTO order_items (order_id, product_id, product_name, product_price, product_image, quantity, subtotal)
                              VALUES ('$order_id', '$product_id', '{$product['name']}', '{$product['price']}', '{$product['image']}', '$quantity', '$subtotal')");
            }
        }
        
        // Cập nhật tổng tiền
        $conn->query("UPDATE orders SET total_amount='$total_amount' WHERE id='$order_id'");
        
        // Thêm thông báo khi chỉnh sửa đơn hàng
        $title = "Chỉnh sửa đơn hàng";
        $message = "Đơn hàng #$order_id đã được chỉnh sửa thông tin";
        $conn->query("INSERT INTO admin_notifications (type, title, message, order_id, is_read, created_at) 
                     VALUES ('order', '$title', '$message', '$order_id', 0, NOW())");
    }
}

// Lấy danh sách đơn hàng
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

// Lấy danh sách sản phẩm để hiển thị khi chỉnh sửa
$products = $conn->query("SELECT id_xe, ma_xe, ten_xe, gia_xe, anh_xe, hang_xe FROM sanpham");

echo "<div style='overflow-x:auto;'>";
echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Khách hàng</th>
        <th>SĐT</th>
        <th>Email</th>
        <th>Địa chỉ</th>
        <th>Ghi chú</th>
        <th>PT Thanh toán</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th>Chi tiết sản phẩm</th>
        <th>Ngày tạo</th>
        <th>Ngày cập nhật</th>
        <th>Hành động</th>
      </tr>";

while ($order = $orders->fetch_assoc()) {
    // Kiểm tra nếu đang ở chế độ chỉnh sửa cho đơn hàng này
    $is_editing = isset($_GET['edit']) && $_GET['edit'] == $order['id'];
    
    echo "<tr" . ($is_editing ? " class='edit-form'" : "") . ">";
    
    if ($is_editing) {
        // Hiển thị form chỉnh sửa
        echo "<form method='post'>";
        echo "<td>{$order['id']}<input type='hidden' name='order_id' value='{$order['id']}'></td>";
        
        // Thông tin khách hàng có thể chỉnh sửa
        echo "<td><input type='text' name='customer_name' value='{$order['customer_name']}' required></td>";
        echo "<td><input type='text' name='customer_phone' value='{$order['customer_phone']}' required></td>";
        echo "<td><input type='email' name='customer_email' value='{$order['customer_email']}'></td>";
        echo "<td><input type='text' name='customer_address' value='{$order['customer_address']}' required></td>";
        echo "<td><textarea name='customer_note'>{$order['customer_note']}</textarea></td>";
        
        // Phương thức thanh toán
        echo "<td>
                <select name='payment_method'>
                    <option value='cod'" . ($order['payment_method'] == 'cod' ? ' selected' : '') . ">COD</option>
                    <option value='banking'" . ($order['payment_method'] == 'banking' ? ' selected' : '') . ">Chuyển khoản</option>
                </select>
              </td>";
        
        echo "<td>" . number_format($order['total_amount']) . "₫</td>";
        
        // Trạng thái
        echo "<td>
                <select name='status'>
                    <option value='pending' " . ($order['status'] == 'pending' ? 'selected' : '') . ">Chờ xử lý</option>
                    <option value='processing' " . ($order['status'] == 'processing' ? 'selected' : '') . ">Đang xử lý</option>
                    <option value='completed' " . ($order['status'] == 'completed' ? 'selected' : '') . ">Hoàn tất</option>
                    <option value='cancelled' " . ($order['status'] == 'cancelled' ? 'selected' : '') . ">Đã hủy</option>
                </select>
              </td>";
        
        // Chi tiết sản phẩm có thể chỉnh sửa
        $order_id = $order['id'];
        $items = $conn->query("SELECT * FROM order_items WHERE order_id='$order_id'");
        echo "<td>";
        
        // Hiển thị các sản phẩm hiện tại với option chỉnh sửa số lượng
        while ($item = $items->fetch_assoc()) {
            echo "<div class='product-detail'>";
            echo "<strong>{$item['product_name']}</strong><br>";
            echo "<img src='IMG/{$item['product_image']}' width='70'><br>";
            echo "Giá: " . number_format($item['product_price']) . "₫<br>";
            echo "Số lượng: <input type='number' class='quantity-input' name='quantity[]' value='{$item['quantity']}' min='1'><br>";
            echo "Tạm tính: " . number_format($item['subtotal']) . "₫";
            echo "<input type='hidden' name='product_id[]' value='{$item['product_id']}'>";
            echo "</div>";
        }
        
        // Option để thêm sản phẩm mới
        echo "<div style='margin-top: 10px;'>";
        echo "<strong>Thêm sản phẩm:</strong><br>";
        echo "<select name='new_product_id'>";
        echo "<option value=''>-- Chọn sản phẩm --</option>";
        $products->data_seek(0); // Reset con trỏ kết quả
        while ($product = $products->fetch_assoc()) {
            echo "<option value='{$product['id']}'>{$product['name']} - " . number_format($product['price']) . "₫</option>";
        }
        echo "</select><br>";
        echo "Số lượng: <input type='number' class='quantity-input' name='new_quantity' value='1' min='1'>";
        echo "</div>";
        
        echo "</td>";
        
        echo "<td>{$order['created_at']}</td>";
        echo "<td>{$order['updated_at']}</td>";
        
        // Hành động khi đang chỉnh sửa
        echo "<td>
                <button type='submit' name='save_edit'>Lưu</button><br><br>
                <a href='orders.php'><button type='button'>Hủy</button></a>
              </td>";
        echo "</form>";
    } else {
        // Hiển thị thông tin bình thường
        echo "<form method='post'>";
        echo "<td>{$order['id']}<input type='hidden' name='id' value='{$order['id']}'></td>";
        echo "<td>{$order['customer_name']}</td>";
        echo "<td>{$order['customer_phone']}</td>";
        echo "<td>{$order['customer_email']}</td>";
        echo "<td>{$order['customer_address']}</td>";
        echo "<td>{$order['customer_note']}</td>";
        echo "<td>{$order['payment_method']}</td>";
        echo "<td>" . number_format($order['total_amount']) . "₫</td>";
        
        // Trạng thái dropdown
        echo "<td>
                <select name='status'>
                    <option value='pending' " . ($order['status'] == 'pending' ? 'selected' : '') . ">Chờ xử lý</option>
                    <option value='processing' " . ($order['status'] == 'processing' ? 'selected' : '') . ">Đang xử lý</option>
                    <option value='completed' " . ($order['status'] == 'completed' ? 'selected' : '') . ">Hoàn tất</option>
                    <option value='cancelled' " . ($order['status'] == 'cancelled' ? 'selected' : '') . ">Đã hủy</option>
                </select>
              </td>";
        
        // Chi tiết sản phẩm
        $order_id = $order['id'];
        $items = $conn->query("SELECT * FROM order_items WHERE order_id='$order_id'");
        echo "<td>";
        while ($item = $items->fetch_assoc()) {
            echo "<div class='product-detail'>";
            echo "<strong>{$item['product_name']}</strong><br>";
            echo "<img src='IMG/{$item['product_image']}' width='70'><br>";
            echo "Giá: " . number_format($item['product_price']) . "₫<br>";
            echo "Số lượng: {$item['quantity']}<br>";
            echo "Tạm tính: " . number_format($item['subtotal']) . "₫";
            echo "</div>";
        }
        echo "</td>";
        
        echo "<td>{$order['created_at']}</td>";
        echo "<td>{$order['updated_at']}</td>";
        
        // Hành động
        echo "<td>
                <button type='submit' name='update_order'>Cập nhật</button><br><br>
                <a href='orders.php?edit={$order['id']}'><button type='button' name='edit_order'>Sửa</button></a><br><br>
                <button type='submit' name='delete_order' onclick=\"return confirm('Xác nhận xóa đơn hàng?')\">Xóa</button>
              </td>";
        echo "</form>";
    }
    
    echo "</tr>";
}

echo "</table>";
echo "</div>";
?>

<a href="admin.php">⬅ Quay về trang Admin</a>
<script>
function loadOrders() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "qldonhang.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("order-container").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>
</body>
</html>
