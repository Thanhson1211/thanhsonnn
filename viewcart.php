<?php
// BẮT BUỘC: Phải đặt ở đầu file, trước mọi HTML
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kết nối database (đảm bảo bạn đã có file config.php)
require_once 'dbconnect.php'; // Hoặc file kết nối database của bạn

// Xử lý thanh toán
if (isset($_POST['checkout'])) {
    try {
        // Bắt đầu transaction
        $pdo->beginTransaction();
        
        // Tính tổng tiền
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['gia_xe'];
        }
        
        // Lưu thông tin đơn hàng vào database
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_email, customer_address, customer_note, payment_method, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['customer_name'],
            $_POST['customer_phone'],
            $_POST['customer_email'],
            $_POST['customer_address'],
            $_POST['customer_note'],
            $_POST['payment_method'] ?? 'cod',
            $total
        ]);
        
        $order_id = $pdo->lastInsertId();
        
        // Lưu chi tiết đơn hàng
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_image, product_price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $stmt->execute([
                $order_id,
                $item['ten_xe'],
                $item['hinhanh_xe'],
                $item['gia_xe'],
                1,
                $item['gia_xe']
            ]);
        }
        
        // Tạo thông báo cho admin
        $notification_title = "Đơn hàng mới #" . $order_id;
        $notification_message = "Khách hàng {$_POST['customer_name']} vừa đặt đơn hàng mới với tổng giá trị " . number_format($total, 0, ',', '.') . "đ";
        
        $stmt = $pdo->prepare("INSERT INTO admin_notifications (type, title, message, order_id) VALUES (?, ?, ?, ?)");
        $stmt->execute(['new_order', $notification_title, $notification_message, $order_id]);
        
        // Commit transaction
        $pdo->commit();
        
        // Lưu thông tin khách hàng vào session để hiển thị
        $_SESSION['customer_info'] = [
            'name' => $_POST['customer_name'],
            'phone' => $_POST['customer_phone'],
            'email' => $_POST['customer_email'],
            'address' => $_POST['customer_address'],
            'note' => $_POST['customer_note']
        ];
        
        // Lưu thông báo thành công
        $_SESSION['payment_success'] = true;
        $_SESSION['order_id'] = $order_id;
        
        // Xóa toàn bộ giỏ hàng
        $_SESSION['cart'] = array();
        
        // Chuyển hướng để tránh resubmit form
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
        
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $pdo->rollback();
        $_SESSION['error_message'] = "Có lỗi xảy ra khi xử lý đơn hàng: " . $e->getMessage();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove_key'])) {
    $key = (int)$_GET['remove_key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giỏ hàng - Thanh Sơn Auto</title>
<link rel="stylesheet" href="styleviewcart.css">
<style>
  :root {
    --primary-color: #0b669d;
    --primary-light: #1a8fd8;
    --secondary-color: #38a169;
    --dark-color: #1a365d;
    --light-color: #f0f9ff;
    --text-color: #2d3748;
    --border-color: #e2e8f0;
  }
  
  /* Thêm style cho form thông tin khách hàng */
  .customer-info-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  
  .customer-info-form h4 {
    margin-top: 0;
    color: var(--primary-color);
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 10px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
  }
  
  .form-group input, 
  .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 14px;
  }
  
  .form-group textarea {
    height: 80px;
    resize: vertical;
  }
  
  .required-field::after {
    content: " *";
    color: red;
  }
  
  /* Tùy chỉnh thanh cuộn và modal */
  .checkout-container {
    max-height: 90vh;
    overflow-y: auto;
    padding: 20px;
    scroll-behavior: smooth;
  }
  
  .checkout-container::-webkit-scrollbar {
    width: 8px;
  }
  
  .checkout-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  
  .checkout-container::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 10px;
  }
  
  .checkout-container::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
  }
  
  /* Nút xác nhận thanh toán cố định khi cuộn */
  .payment-actions {
    position: sticky;
    bottom: 0;
    background: white;
    padding: 15px 0;
    display: flex;
    justify-content: space-between;
    gap: 15px;
    border-top: 1px solid var(--border-color);
    margin-top: 10px;
  }
  
  .payment-actions button {
    flex: 1;
  }
  
  /* Style cho thông báo lỗi */
  .error-message {
    background: #fed7d7;
    border: 1px solid #feb2b2;
    color: #9b2c2c;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>	
<body>

<!-- Header cố định -->
<div class="fixed-header">
  <?php include 'header.php'; ?>
</div>

<!-- Thông báo lỗi -->
<?php if (isset($_SESSION['error_message'])): ?>
  <div class="error-message">
    <i class="fas fa-exclamation-triangle"></i>
    <span><?php echo htmlspecialchars($_SESSION['error_message']); ?></span>
  </div>
  <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Thông báo thanh toán thành công -->
<?php if (isset($_SESSION['payment_success'])): ?>
  <div class="payment-success-modal" style="display: flex;">
    <div class="success-container">
      <div class="success-icon"><i class="fas fa-check-circle"></i></div>
      <h3>Đặt hàng thành công!</h3>
      <p>Cảm ơn bạn <?php echo htmlspecialchars($_SESSION['customer_info']['name'] ?? ''); ?> đã đặt hàng tại Thanh Sơn Auto. 
      Mã đơn hàng của bạn là: <strong>#<?php echo $_SESSION['order_id'] ?? ''; ?></strong><br>
      Nhân viên sale của chúng tôi sẽ liên hệ với bạn qua số điện thoại <?php echo htmlspecialchars($_SESSION['customer_info']['phone'] ?? ''); ?> trong thời gian sớm nhất.</p>
      <a href="cart.php" class="back-to-home">ĐÓNG</a>
    </div>
  </div>
  <?php unset($_SESSION['payment_success']); unset($_SESSION['customer_info']); unset($_SESSION['order_id']); ?>
<?php endif; ?>

<div class="cart-container">
  <h2>Giỏ hàng của bạn</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="empty-message">
      <i class="fas fa-shopping-cart"></i>
      <p>Giỏ hàng của bạn đang trống</p>
      <a href="<?php echo $_SERVER['PHP_SELF'] == 'index.php' ? '#car-section' : 'index.php#car-section'; ?>" class="back-link"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
    </div>
  <?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Ảnh sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Giá (VNĐ)</th>
        <th>Thành tiền (VNĐ)</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $key => $item):
        $subtotal = $item['gia_xe'];
        $total += $subtotal;
      ?>
      <tr>
        <td><img src="IMG/<?php echo htmlspecialchars($item['hinhanh_xe']); ?>" alt="<?php echo htmlspecialchars($item['ten_xe']); ?>"></td>
        <td><?php echo htmlspecialchars($item['ten_xe']); ?></td>
        <td><?php echo number_format($item['gia_xe'], 0, ',', '.'); ?>đ</td>
        <td><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
        <td><button class="btn-remove" onclick="window.location.href='?remove_key=<?php echo $key; ?>'">&times;</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" style="text-align:right;">Tổng cộng:</td>
        <td colspan="2" style="text-align:center; font-weight:bold; color:var(--primary-color);">
          <?php echo number_format($total, 0, ',', '.'); ?>đ
        </td>
      </tr>
    </tfoot>
  </table>

  <div class="action-buttons"> 
    <a href="<?php echo $_SERVER['PHP_SELF'] == 'index.php' ? '#car-section' : 'index.php#car-section'; ?>" class="back-link"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
    <button class="btn-checkout" id="openCheckout"><i class="fas fa-credit-card"></i> Đặt hàng</button>
  </div>
  <?php endif; ?>
</div>

<!-- Modal thanh toán -->
<div class="checkout-modal" id="checkoutModal">
  <div class="checkout-container">
    <span class="close-modal" id="closeModal">&times;</span>
    <h3 class="checkout-title">Đơn đặt hàng</h3>
    
    <div class="checkout-summary">
      <div class="summary-row">
        <span>Tạm tính:</span>
        <span><?php echo isset($total) ? number_format($total, 0, ',', '.') : '0'; ?>đ</span>
      </div>
      <div class="summary-row">
        <span>Phí vận chuyển:</span>
        <span>0đ</span>
      </div>
      <div class="summary-row summary-total">
        <span>Tổng cộng:</span>
        <span><?php echo isset($total) ? number_format($total, 0, ',', '.') : '0'; ?>đ</span>
      </div>
    </div>
    
    <!-- Form thông tin khách hàng -->
    <div class="customer-info-form">
      <h4><i class="fas fa-user-circle"></i> Thông tin của quý khách</h4>
      <form id="customerInfoForm" method="post">
        <div class="form-group">
          <label class="required-field">Họ và tên</label>
          <input type="text" name="customer_name" required placeholder="Nhập họ và tên">
        </div>
        <div class="form-group">
          <label class="required-field">Số điện thoại</label>
          <input type="tel" name="customer_phone" required placeholder="Nhập số điện thoại">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="customer_email" placeholder="Nhập email (nếu có)">
        </div>
        <div class="form-group">
          <label class="required-field">Địa chỉ nhận hàng</label>
          <input type="text" name="customer_address" required placeholder="Nhập địa chỉ nhận hàng">
        </div>
        <div class="form-group">
          <label>Ghi chú</label>
          <textarea name="customer_note" placeholder="Ghi chú thêm (nếu có)"></textarea>
        </div>
      </form>
    </div>
    
    <div class="payment-methods">
      <h4>Chọn phương thức thanh toán</h4>
      
      <div class="payment-method">
        <input type="radio" id="cod" name="payment_method" value="cod" checked>
        <label for="cod">
          <img src="https://cdn-icons-png.flaticon.com/512/2489/2489076.png" class="payment-icon" alt="COD">
          <div class="payment-details">
            <div class="payment-name">Thanh toán khi nhận hàng (COD)</div>
            <div class="payment-desc">Thanh toán bằng tiền mặt khi nhận xe</div>
          </div>
        </label>
      </div>
      
      <div class="payment-method">
        <input type="radio" id="banking" name="payment_method" value="banking">
        <label for="banking">
          <img src="https://cdn-icons-png.flaticon.com/512/2489/2489138.png" class="payment-icon" alt="Banking">
          <div class="payment-details">
            <div class="payment-name">Chuyển khoản ngân hàng</div>
            <div class="payment-desc">Chuyển khoản qua Internet Banking/Mobile Banking</div>
          </div>
        </label>
      </div>
      
      <div class="payment-method">
        <input type="radio" id="vnpay" name="payment_method" value="vnpay">
        <label for="vnpay">
          <img src="https://cdn-icons-png.flaticon.com/512/2489/2489197.png" class="payment-icon" alt="VNPay">
          <div class="payment-details">
            <div class="payment-name">VNPay</div>
            <div class="payment-desc">Thanh toán qua cổng VNPay</div>
          </div>
        </label>
      </div>
      
      <div class="payment-method">
        <input type="radio" id="credit" name="payment_method" value="credit">
        <label for="credit">
          <img src="https://cdn-icons-png.flaticon.com/512/2489/2489183.png" class="payment-icon" alt="Credit Card">
          <div class="payment-details">
            <div class="payment-name">Thẻ tín dụng/ghi nợ</div>
            <div class="payment-desc">Visa, Mastercard, JCB và các loại thẻ quốc tế khác</div>
          </div>
        </label>
      </div>
    </div>
    
    <div class="payment-actions">
      <button class="cancel-btn" id="cancelPayment"><i class="fas fa-times-circle"></i> Hủy </button>
      <button class="confirm-btn" id="confirmPayment"><i class="fas fa-check-circle"></i> Xác nhận đặt hàng</button>
    </div>
  </div>
</div>

<script>
  // Xử lý modal thanh toán
  const openCheckout = document.getElementById('openCheckout');
  const checkoutModal = document.getElementById('checkoutModal');
  const closeModal = document.getElementById('closeModal');
  const confirmPayment = document.getElementById('confirmPayment');
  const cancelPayment = document.getElementById('cancelPayment');
  const customerInfoForm = document.getElementById('customerInfoForm');
  const checkoutContainer = document.querySelector('.checkout-container');
  
  if (openCheckout) {
    openCheckout.addEventListener('click', () => {
      checkoutModal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  }
  
  if (closeModal) {
    closeModal.addEventListener('click', () => {
      checkoutModal.style.display = 'none';
      document.body.style.overflow = 'auto';
    });
  }
  
  if (cancelPayment) {
    cancelPayment.addEventListener('click', () => {
      checkoutModal.style.display = 'none';
      document.body.style.overflow = 'auto';
    });
  }
  
  if (confirmPayment) {
    confirmPayment.addEventListener('click', () => {
      // Kiểm tra form hợp lệ
      const requiredFields = customerInfoForm.querySelectorAll('[required]');
      let isValid = true;
      let firstInvalidField = null;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = 'red';
          
          // Lưu trường lỗi đầu tiên
          if (!firstInvalidField) {
            firstInvalidField = field;
          }
        } else {
          field.style.borderColor = '';
        }
      });
      
      if (!isValid) {
        alert('Vui lòng điền đầy đủ thông tin bắt buộc (đánh dấu *)');
        
        // Cuộn đến trường lỗi đầu tiên
        if (firstInvalidField) {
          firstInvalidField.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
          firstInvalidField.focus();
        }
        return;
      }
      
      const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
      
      // Tạo form ẩn để submit
      const form = document.createElement('form');
      form.method = 'post';
      form.action = '';
      
      // Thêm các trường thông tin khách hàng
      const formData = new FormData(customerInfoForm);
      for (const [name, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
      }
      
      // Thêm phương thức thanh toán
      const paymentInput = document.createElement('input');
      paymentInput.type = 'hidden';
      paymentInput.name = 'payment_method';
      paymentInput.value = selectedPayment;
      form.appendChild(paymentInput);
      
      // Thêm trường checkout
      const checkoutInput = document.createElement('input');
      checkoutInput.type = 'hidden';
      checkoutInput.name = 'checkout';
      checkoutInput.value = '1';
      form.appendChild(checkoutInput);
      
      document.body.appendChild(form);
      form.submit();
    });
  }
  
  // Đóng modal khi click bên ngoài
  checkoutModal.addEventListener('click', (e) => {
    if (e.target === checkoutModal) {
      checkoutModal.style.display = 'none';
      document.body.style.overflow = 'auto';
    }
  });
  
  // Đóng thông báo thành công khi click vào nút đóng
  document.querySelector('.back-to-home')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.payment-success-modal').style.display = 'none';
  });
</script>

</body>
</html>