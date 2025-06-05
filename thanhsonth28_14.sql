-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 05, 2025 lúc 10:41 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thanhsonth28.14`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `type`, `title`, `message`, `order_id`, `is_read`, `created_at`) VALUES
(16, 'new_order', 'Đơn hàng mới #9', 'Khách hàng Trịnh Vũ Thanh Sơn vừa đặt đơn hàng mới với tổng giá trị 1.637.000.000đ', 9, 0, '2025-06-01 16:05:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietsp`
--

CREATE TABLE `chitietsp` (
  `id_xe` int(255) NOT NULL,
  `ten_xe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `gia_xe` int(100) DEFAULT NULL,
  `namsx_xe` int(50) DEFAULT NULL,
  `nhienlieu_xe` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sodo_xe` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `hopso_xe` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `hang_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dong_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `kieu_xe` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `diadiem_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `showroom_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mota_xe` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `hinhanh_xe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `lien_he` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hinhanh_chitiet` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietsp`
--

INSERT INTO `chitietsp` (`id_xe`, `ten_xe`, `gia_xe`, `namsx_xe`, `nhienlieu_xe`, `sodo_xe`, `hopso_xe`, `hang_xe`, `dong_xe`, `kieu_xe`, `diadiem_xe`, `showroom_xe`, `mota_xe`, `hinhanh_xe`, `lien_he`, `hinhanh_chitiet`) VALUES
(1, 'Toyota Vios 2023', 650000000, 2023, 'Xe xăng', 'Xe mới', 'Số tự động', 'Toyota', 'Vios', 'Sedan', 'Hà Nội', 'Thanh Sơn Auto', 'Toyota Vios 2023 là phiên bản nâng cấp đáng chú ý của mẫu sedan hạng B nổi tiếng tại Việt Nam, tiếp tục duy trì vị thế dẫn đầu phân khúc với thiết kế hiện đại, công nghệ tiên tiến và khả năng vận hành ổn định.\r\n1. Thông số kỹ thuật tổng quan\r\nKích thước tổng thể (D x R x C): 4.425 x 1.730 x 1.475 mm\r\nChiều dài cơ sở: 2.550 mm\r\nKhoảng sáng gầm: 133 mm\r\nTrọng lượng toàn tải: 1.550 kg\r\nDung tích bình nhiên liệu: 42 lít\r\nBán kính vòng quay tối thiểu: 5,1 m\r\n2. Động cơ và vận hành\r\nĐộng cơ: Xăng 1.5L 4 xy-lanh thẳng hàng, mã 2NR-FE, DOHC, Dual VVT-i\r\nCông suất cực đại: 106 mã lực tại 6.000 vòng/phút\r\nMô-men xoắn cực đại: 140 Nm tại 4.200 vòng/phút\r\nHệ dẫn động: Cầu trước (FWD)\r\nHộp số: Phiên bản E MT: số sàn 5 cấp; phiên bản E CVT và G CVT: hộp số vô cấp CVT\r\nTiêu thụ nhiên liệu kết hợp: Khoảng 5,74 – 6,02 lít/100 km\r\n3. Ngoại thất\r\nĐèn chiếu gần/xa: Bi-LED dạng bóng chiếu\r\nĐèn hậu: LED\r\nGương chiếu hậu: Gập điện, chỉnh điện, tích hợp đèn báo rẽ\r\nĂng-ten: Vây cá\r\nCốp: Mở điện, hỗ trợ mở cốp rảnh tay (phiên bản G CVT)\r\n4. Nội thất và tiện nghi\r\nGhế: Bọc da (phiên bản G CVT), chỉnh tay (E MT và E CVT)\r\nVô-lăng: Bọc da, tích hợp nút bấm điều khiển\r\nMàn hình giải trí: Màn hình cảm ứng 9 inch, hỗ trợ Apple CarPlay và Android Auto\r\nHệ thống âm thanh: 4 loa\r\nĐiều hòa: Chỉnh tay\r\nCửa gió hàng ghế sau: Có (phiên bản E CVT và G CVT)\r\nKhởi động: Nút bấm (phiên bản G CVT)\r\n5. An toàn\r\nTúi khí: 3 túi khí (phiên bản E MT); 7 túi khí (phiên bản E CVT và G CVT)\r\nHệ thống phanh: ABS, EBD, BA\r\nHệ thống cân bằng điện tử (VSC), kiểm soát lực kéo (TCS), hỗ trợ khởi hành ngang dốc (HAC)\r\nCảnh báo điểm mù (BSM), cảnh báo phương tiện cắt ngang khi lùi (RCTA)\r\nCamera lùi: Có (tất cả phiên bản)\r\nCảm biến lùi: Có (phiên bản G CVT)\r\nHệ thống Toyota Safety Sense (TSS): Trang bị trên phiên bản G CVT, bao gồm: cảnh báo tiền va chạm (PCS), phanh tự động (AEB), cảnh báo chệch làn đường (LDA), hỗ trợ giữ làn (LKA), điều khiển hành trình thích ứng (ACC), đèn pha tự động (AHB)\r\n6. Ưu điểm nổi bật\r\nThiết kế hiện đại: Lưới tản nhiệt mới, đèn chiếu sáng LED sắc nét, tạo nên diện mạo trẻ trung và năng động.\r\nTiện nghi cao cấp: Trang bị màn hình cảm ứng lớn, hỗ trợ kết nối thông minh, mang đến trải nghiệm giải trí tiện lợi.\r\nAn toàn vượt trội: Hệ thống an toàn toàn diện, đặc biệt là trên phiên bản G CVT với Toyota Safety Sense.\r\nTiết kiệm nhiên liệu: Hiệu suất tiêu thụ nhiên liệu ấn tượng, phù hợp với nhu cầu di chuyển trong đô thị và đường trường', '1.jpg', '0364180814', '18.jpg,19.jpg,20.jpg'),
(2, 'Honda City 2022', 720000000, 2022, 'Xăng', 'Xe mới', 'Số tự động', 'Honda\r\n', 'City', 'Sedan', 'Hà Nội', 'Thanh Sơn Auto', 'Honda City 2022 là mẫu sedan hạng B thế hệ thứ 5 của Honda, được thiết kế lại hoàn toàn với nhiều cải tiến về ngoại hình, công nghệ và hiệu suất. Mẫu xe này nhanh chóng chiếm lĩnh thị trường Việt Nam, trở thành lựa chọn phổ biến nhờ vào sự kết hợp giữa thiết kế hiện đại, động cơ mạnh mẽ và trang bị tiện nghi.\r\n1. Thông số kỹ thuật Honda City 2022\r\nĐộng cơ: 1.5L DOHC i-VTEC 4 xi-lanh thẳng hàng, công suất 119 mã lực tại 6.600 vòng/phút, mô-men xoắn 145 Nm tại 4.300 vòng/phút\r\nHộp số: Vô cấp CVT\r\nHệ dẫn động: Cầu trước\r\nKích thước: 4.553 x 1.748 x 1.467 mm\r\nChiều dài cơ sở: 2.600 mm\r\nKhoảng sáng gầm: 134 mm\r\nBán kính vòng quay: 5 m\r\nDung tích bình nhiên liệu: 40 lít\r\nMức tiêu thụ nhiên liệu:\r\nĐô thị: 7,29 lít/100 km\r\nNgoài đô thị: 4,73 lít/100 km\r\nKết hợp: 5,68 lít/100 km \r\n2. Ngoại thất\r\nHonda City 2022 mang đến một diện mạo mới mẻ và thể thao hơn. Phần đầu xe nổi bật với lưới tản nhiệt sơn đen bóng, cụm đèn pha LED sắc sảo và dải đèn LED ban ngày hình đôi mắt. Thân xe được thiết kế với các đường gân dập nổi, tạo cảm giác năng động. Phiên bản RS có thêm các chi tiết như cánh lướt gió sau, la-zăng hợp kim 16 inch và ống xả kép, tăng thêm phần thể thao. \r\n3. Nội thất và tiện nghi\r\nGhế ngồi: Bọc da pha nỉ (bản L và RS), chỉnh tay 6 hướng cho ghế lái\r\nVô-lăng: Bọc da, tích hợp nút điều khiển âm thanh và lẫy chuyển số (bản RS)\r\nMàn hình giải trí: Màn hình cảm ứng 8 inch, hỗ trợ Apple CarPlay và Android Auto\r\nHệ thống âm thanh: 4 loa (bản G và L), 8 loa (bản RS)\r\nĐiều hòa: Chỉnh cơ (bản G và L), tự động (bản RS)\r\nKhởi động: Nút bấm (bản L và RS)\r\n4. An toàn\r\nTúi khí: 2 túi khí (bản G), 6 túi khí (bản L và RS)\r\nHệ thống phanh: Phanh đĩa trước, phanh tang trống sau\r\nHệ thống treo: MacPherson phía trước, giằng xoắn phía sau\r\nHệ thống hỗ trợ lái: Trợ lực lái điện (EPS), ga tự động (Cruise Control), chế độ lái tiết kiệm nhiên liệu ECON Mode\r\nAn toàn chủ động: Hệ thống cân bằng điện tử (VSA), hỗ trợ lực phanh khẩn cấp (BA), phân phối lực phanh điện tử (EBD)\r\n5. Ưu điểm\r\nThiết kế hiện đại: Ngoại hình thể thao, nội thất rộng rãi và tiện nghi\r\nHiệu suất vượt trội: Động cơ mạnh mẽ, khả năng tăng tốc nhanh và tiết kiệm nhiên liệu\r\nTrang bị an toàn đầy đủ: Hệ thống an toàn tiên tiến, đạt tiêu chuẩn 5 sao ASEAN NCAP\r\nGiá trị sử dụng cao: Độ bền cao, chi phí bảo dưỡng hợp lý\r\n6.Nhược điểm\r\nChất lượng cách âm: Khoang cabin vẫn còn tiếng ồn khi di chuyển ở tốc độ cao\r\nTrang bị hạn chế: Một số phiên bản thiếu cảm biến lùi và cửa sổ trời\r\nPhanh sau: Vẫn sử dụng phanh tang trống thay vì đĩa', '2.jpg', '0364180814', '21.jpg,22.jpg,23.jpg'),
(3, 'Kia New Carnival ', 987000000, 2025, ' Xăng', '46.000 km', 'Số tự động', 'KIA', 'Carnival', 'SUV', 'Hà Nội', 'Thanh Sơn Auto', 'Kia Carnival Signature 2025 là phiên bản cao cấp của dòng MPV cỡ lớn, được thiết kế để đáp ứng nhu cầu của các gia đình và doanh nhân với không gian rộng rãi, tiện nghi hiện đại và công nghệ an toàn tiên tiến.\r\n1. Thông số kỹ thuật\r\nĐộng cơ: Diesel tăng áp 2.2L SmartStream\r\nCông suất cực đại: 199 mã lực tại 3.800 vòng/phút\r\nMô-men xoắn cực đại: 440 Nm tại 1.750–2.750 vòng/phút\r\nHộp số: Tự động 8 cấp\r\nHệ dẫn động: Cầu trước (FWD)\r\nDung tích bình nhiên liệu: 72 lít\r\nTiêu thụ nhiên liệu trung bình: Khoảng 7.0L/100 km\r\n2. Kích thước & không gian\r\nKích thước (DxRxC): 5.155 x 2.010 x 1.775 mm\r\nChiều dài cơ sở: 3.090 mm\r\nSố chỗ ngồi: 7 chỗ (2-2-3), với hàng ghế thứ hai kiểu thương gia (VIP)\r\nKhoảng sáng gầm xe: 172 mm\r\n3. Ngoại thất\r\nThiết kế: Hiện đại với lưới tản nhiệt mạ chrome, đèn pha LED và đèn hậu LED.\r\nCửa trượt điện: Hai bên, điều khiển từ xa hoặc bằng nút bấm.\r\nMàu sắc: Đa dạng, bao gồm Trắng Ngọc Trai, Đen, Xám, Đỏ Sẫm, Xanh Sẫm, Xanh Xám và Bạc.\r\n4. Nội thất & tiện nghi\r\nGhế ngồi: Bọc da cao cấp, hàng ghế thứ hai có chức năng sưởi, thông gió, chỉnh điện và nhớ vị trí.\r\nHệ thống giải trí: Màn hình cảm ứng 12.3 inch, hỗ trợ Apple CarPlay và Android Auto.\r\nHệ thống âm thanh: 12 loa Bose cao cấp.\r\nĐiều hòa: Tự động 3 vùng độc lập với cửa gió riêng cho từng hàng ghế.\r\nTiện ích khác: Sạc không dây, cửa sổ trời toàn cảnh, cốp điện thông minh và đề nổ từ xa.\r\n5. An toàn\r\nHệ thống an toàn chủ động: Gói công nghệ an toàn chủ động với các tính năng như cảnh báo điểm mù, hỗ trợ giữ làn đường, cảnh báo va chạm phía trước và sau, hỗ trợ phanh khẩn cấp.\r\nCamera 360 độ: Hiển thị hình ảnh toàn cảnh xung quanh xe trên màn hình trung tâm.\r\nTúi khí: 7 túi khí, bao gồm túi khí rèm và túi khí đầu gối cho người lái.\r\n6. Ưu điểm\r\nKhông gian rộng rãi: Phù hợp cho gia đình đông người hoặc sử dụng làm xe doanh nghiệp.\r\nTiện nghi cao cấp: Trang bị hiện đại, mang lại trải nghiệm thoải mái cho hành khách.\r\nAn toàn vượt trội: Trang bị đầy đủ các tính năng an toàn chủ động và bị động.\r\n7. Nhược điểm\r\nKích thước lớn: Có thể gặp khó khăn khi di chuyển trong đô thị đông đúc.\r\nGiá thành cao: So với một số đối thủ trong phân khúc, giá của phiên bản Signature cao hơn.\r\n\r\n', '3.jpg', '0364180814', '24.jpg,25.jpg,26.jpg'),
(4, 'Ford Ranger 2025', 979000000, 2025, ' Xăng', 'Xe mới', 'Số tự động', 'Ford', 'Ranger', 'Coupe', 'Hà Nội', 'Thanh Sơn Auto', 'Ford Ranger 2025 là thế hệ mới nhất của dòng bán tải ăn khách tại Việt Nam, nổi bật với thiết kế hiện đại, khả năng vận hành mạnh mẽ và nhiều công nghệ tiên tiến.\r\n1. Thông số kỹ thuật nổi bật\r\nKích thước & Khung gầm\r\nKích thước (DxRxC): 5.362 x 1.918 x 1.875 mm\r\nChiều dài cơ sở: 3.270 mm\r\nKhoảng sáng gầm xe: 235 mm\r\nDung tích bình nhiên liệu: 85.8 lít\r\nĐộng cơ & Truyền động\r\nFord Ranger 2025 cung cấp hai tùy chọn động cơ diesel:\r\nTurbo Diesel 2.0L I4 TDCi:\r\nCông suất: 170 mã lực tại 3.500 vòng/phút\r\nMô-men xoắn: 405 Nm tại 1.750 – 2.500 vòng/phút\r\nHộp số: Số sàn 6 cấp hoặc tự động 6 cấp\r\nHệ dẫn động: Một cầu hoặc hai cầu\r\nBi-Turbo Diesel 2.0L I4 TDCi (dành cho phiên bản Wildtrak, Stormtrak và Raptor):\r\nCông suất: 210 mã lực tại 3.750 vòng/phút\r\nMô men xoắn: 500 Nm tại 1.750 – 2.000 vòng/phút\r\nHộp số: Tự động 10 cấp\r\nHệ dẫn động: Hai cầu\r\n2. Trang bị an toàn và tiện nghi\r\nHệ thống an toàn:\r\nHệ thống phanh ABS, EBD, BA\r\nHệ thống cân bằng điện tử (ESP)\r\nHỗ trợ khởi hành ngang dốc (HLA)\r\nHỗ trợ đổ đèo (HDC)\r\nCamera lùi và cảm biến hỗ trợ đỗ xe\r\nTúi khí: từ 2 đến 6 tùy phiên bản\r\nTiện nghi nội thất:\r\nMàn hình cảm ứng từ 10 inch, hỗ trợ Apple CarPlay và Android Auto\r\nHệ thống âm thanh 6 loa\r\nĐiều hòa tự động 2 vùng độc lập\r\nGhế lái chỉnh điện 8 hướng (trên các phiên bản cao cấp)\r\nChìa khóa thông minh và khởi động bằng nút bấm\r\n\r\n\r\n', '4.jpg', '0364180814', '27.jpg,28.jpg,29.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiettt`
--

CREATE TABLE `chitiettt` (
  `id_tt` int(255) NOT NULL,
  `anh_tt` varchar(255) DEFAULT NULL,
  `xemthem_tt` text DEFAULT NULL,
  `noidung_tt` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiettt`
--

INSERT INTO `chitiettt` (`id_tt`, `anh_tt`, `xemthem_tt`, `noidung_tt`) VALUES
(1, '30.jpg,31.jpg,32.jpg,33.jpg,34.jpg', 'Đánh giá xe Lexus LX 600 2025: Khẳng định đẳng cấp xe \"Chủ tịch\"\r\nCác chuyên gia đánh giá xe Lexus LX 600 2025 sở hữu nhiều thay đổi, đặc biệt là động cơ, khả năng vận hành cũng như cung cấp một không gian trải nghiệm được nâng tầm cao mới.\r\n', 'Trải qua hơn 25 năm với 3 thế hệ đã bán ra thị trường, Lexus LX đã trở thành một trong những chiếc xe SUV hạng sang cỡ lớn rất được lòng khách hàng trên toàn thế giới. Mẫu xe này dù không bóng bảy, ngập tràn tiện nghi giống các đối thủ đến từ Đức như Mercedes-Benz GLS-Class, BMW X7,... nhưng vẫn luôn là sự lựa chọn hàng đầu của những doanh nhân thành đạt trong nhiều năm qua.\r\n\r\n\r\nKể từ khi \"người kế nhiệm\" LX 570 là Lexus LX 600 2025 trình làng đã thay đổi gần như hoàn toàn với ngoại hình góc cạnh, hiện đại hơn và ngập tràn tiện nghi ở khoang lái. All New Lexus LX 600 được dự đoán sẽ tiếp nối thành công của \"người tiền nhiệm\" LX 570 và trở thành chiếc SUV \"đắt show\" giống như những gì mà Toyota Land Cruiser đã từng thể hiện trước đó.\r\nNgoại hình vẫn giữ lại nhiều đặc trưng\r\nNhư thông lệ, Lexus LX 600 2025 cũng sẽ chia sẻ nền tảng khung gầm hoàn toàn mới của \"người anh em\" Toyota Land Cruiser. Theo hãng xe Nhật Bản, trọng lượng xe giảm đáng kể do sử dụng hệ thống khung gầm mới, gia tăng độ cững vững cho xe bởi sở hữu những vật liệu mới.\r\n\r\nThoạt nhìn phần đầu, sẽ chẳng ai có thể nhận ra đây Lexus LX 600 hoàn toàn mới mà vẫn ngỡ rằng đây là \"huyền thoại\" LX 570 được trau chuốt lại dành cho mô hình 2025 bởi thiết kế gần như được giữ nguyên. Thế nhưng đi sâu vào chi tiết, Lexus LX 600 thực sự có nhiều chi tiết khác biệt.\r\n\r\nNhững điểm mới ở đây phải kể đến như thanh nan kép và thiết kế mới dạng 3D ở khu vực lưới tản nhiệt và các hốc gió bên lớn hơn, tạo hiệu ứng như chiếc xe bệ vệ hơn so với thực tế. Ở thế hệ mới, phiên bản thể thao của Lexus LX 600 sẽ dụng tên gọi F-Sport chứ không phải Super Sport như trước. \r\n\r\nVới phiên bản F-Sport, Lexus biết cách tạo nên sự khác biệt bằng việc thiết kế lại lưới tản nhiệt với những họa tiết hình hình quả trám và sơn đen nhằm gia tăng tính thể thao cho xe, đồng thời tạo ra tính đồng nhất về thiết kế cho toàn bộ dải sản phẩm của hãng khi gắn biểu tượng F-Sport.\r\nTiếp tục nói về nét đặc trưng của Lexus LX 600, dễ dàng nhận ra hệ thống chiếu sáng của xe vẫn là dạng LED chia khoang kết hợp dải định vị ban ngày hình móc câu như đời cũ. Tuy nhiên, đây lại là chi tiết mà đội ngũ đánh giá xe chúng tôi hài lòng bởi thiết kế gọn gàng, tinh tế và sắc sảo nhất ở phần đầu của Lexus LX 600 2025.'),
(2, '35.jpg,36.jpg,37.jpg,38.jpg,39.jpg', 'Toyota Vios 2014 thuộc thế hệ thứ 3, bắt đầu mở bán tại thị trường ô tô Việt Nam vào tháng 4/2014. Tại thời điểm ra mắt, giá xe Toyota Vios 2014 bản G được đề xuất 612 triệu đồng. Sau hơn 10 năm lăn bánh, hiện những chiếc Vios cũ đời 2014 đang được chào bán với giá dao động 330-360 triệu đồng, giảm khoảng 41-46% so với giá mới.\r\nTrong khi tỷ lệ trượt giá của Honda City 1.5AT 2014 là khoảng 46,5-51,6%, từ 599 triệu đồng về 290-320 triệu đồng sau 10 năm sử dụng. Những chiếc Nissan Sunny XV 2014 cũng có độ trượt giá khá sâu khi đang được chào bán trong khoảng 250 triệu đồng, tức mất khoảng 57,5% giá trị so với giá niêm yết 588 triệu đồng ở thời điểm mở bán mới.\r\nTheo giới đánh giá xe, Toyota Vios 1.5G 2014 là lựa chọn rất đáng cân nhắc dành cho khách hàng đang tìm kiếm một mẫu sedan sở hữu khoang nội thất rộng rãi, vận hành bền bỉ, tiết kiệm nhiên liệu trong tầm giá 350 triệu đồng.', 'Toyota Vios 1.5G 2014 thuộc thế hệ thứ 8, bắt đầu lắp ráp tại Việt Nam từ năm 2006. Đến nay, sau 16 năm lăn bánh, những chiếc Civic lắp ráp đời đầu vẫn được giới đánh giá xe nhận xét có nhiều ưu điểm về cả thiết kế lẫn vận hành.\r\n\r\nTrước hết về ngoại hình, Civic 2008 thu hút bởi diện mạo có phần phá cách, thể thao và năng động hơn hẳn các mẫu xe cùng thời. Điều này khiến xe vẫn tạo được sức hút riêng dù đã trải qua 16 năm có mặt trên thị trường.\r\n\r\nCùng với đó là một không gian rộng rãi với các trang bị tiện nghi đáng chú ý như: Đèn HID, đèn sương mù trước; Gương chiếu hậu ngoài gập điện, tích hợp báo rẽ; Vô-lăng điều chỉnh 4 hướng, tích hợp nút chỉnh âm thanh và MID; Âm thanh 6 loa, AM/FM MP3/ WMA 1CD; Điều hòa tự động; Ghế da, hàng ghế trước trượt/ ngả, điều chỉnh độ cao mặt ghế...\r\nCảm giác lái cũng là điểm được đánh giá cao khi khung gầm vẫn còn đầm chắc, độ phản hồi nhạy của chân ga và tay lái khá nhanh nhẹn. Đặc biệt, giá xe Honda Civic 2008 đã qua sử dụng rất mềm, chỉ trong tầm 200 triệu đồng. Và đây là con số xứng đáng để bỏ ra cho một chiếc xe cũ được đánh giá là sở hữu chất lượng ổn.\r\n\r\n'),
(3, '40.jpg,41.jpg,42.jpg,43.jpg,44.jpg', '', 'Giới thiệu chung\r\nDo hãng xe Đức định vị thương hiệu ở \"mức tiệm cận sang\" nên giá xe Viloran tách biệt hoàn toàn so với các mẫu MPV phổ thông. Giá thành cao hơn mặt bằng chung, cộng thêm xuất xứ từ Trung Quốc, Volkswagen Viloran cần nhiều thời gian để thuyết phục khách hàng dù \"đẳng cấp\" của thương hiệu đã được công nhận.\r\n\r\nDù không hội tụ những yếu tố đáp ứng tốt thị hiếu và thu nhập của khách Việt nhưng Volkswagen Viloran vẫn có nhóm khách hàng riêng, đó có thể là những người không đủ tài chính để nhắm đến các sản phẩm sang trọng như Mercedes-Benz V-Class (giá khởi điểm 3,039 tỷ đồng) nhưng vẫn muốn trải nghiệm trọn vẹn một mẫu xe của thương hiệu Đức, cao cấp hơn hẳn những chiếc MPV hiện có tại thị trường Việt Nam.\r\nQuảng cáo\r\n\r\nVà, nếu đặt mẫu xe của Volkswagen lên \"bàn cân\" với KIA Carnival, người dùng sẽ nhận được câu trả lời thỏa đáng khi phải chi khoản tiền chênh 190 triệu đồng để sở hữu Viloran:\r\n\r\nChênh 190 triệu đồng: Volkswagen Viloran 2024 có gì để thuyết phục khách hàng “quên” KIA Carnival? 1\r\nQuảng cáo\r\n\r\nChênh 190 triệu đồng: Volkswagen Viloran 2024 có gì để thuyết phục khách hàng “quên” KIA Carnival?\r\n\r\nNguồn ảnh: Phong Quang\r\n\r\n \r\nTheo Thanh niên Việt\r\n ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` text NOT NULL,
  `customer_note` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` text NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `customer_note`, `payment_method`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Trịnh Vũ Thanh Sơn', '0364180814', 'thanhsondeptraivcc@gmail.com', 'Cẩm Phả, Quảng Ninh', 'Liên hệ ngay sau khi đặt', 'banking', '1637000000', 'pending', '2025-06-01 16:05:20', '2025-06-01 16:05:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(15,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `subtotal` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `product_image`, `product_price`, `quantity`, `subtotal`) VALUES
(14, 9, 'Toyota Vios 2023', '1.jpg', 650000000.00, 1, 650000000.00),
(15, 9, 'Kia New Carnival ', '3.jpg', 987000000.00, 1, 987000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quangcao`
--

CREATE TABLE `quangcao` (
  `id` int(11) NOT NULL,
  `ten_xe` varchar(100) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL,
  `gia` varchar(50) NOT NULL,
  `tinh_nang` text NOT NULL,
  `trang_thai` tinyint(1) DEFAULT 1,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quangcao`
--

INSERT INTO `quangcao` (`id`, `ten_xe`, `hinh_anh`, `gia`, `tinh_nang`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Mazda CX-5 2024', '15.jpg', '799.000.000₫', 'Tặng bảo hiểm thân vỏ|Dán kính cách nhiệt|Trả góp 0%', 1, '2025-05-31 14:52:56', '2025-05-31 14:53:26'),
(2, 'Toyota Vios G', '16.jpg', '589.000.000₫', 'Miễn phí đăng ký trước bạ|Tặng camera hành trình|Giảm trực tiếp 20 triệu', 1, '2025-05-31 14:52:56', '2025-05-31 14:53:34'),
(3, 'BMW Series 3 2024', '17.jpg', '1.299.000.000₫', 'Bảo hành 5 năm|Voucher nghỉ dưỡng 10 triệu|Tặng bảo hiểm vật chất', 1, '2025-05-31 14:52:56', '2025-05-31 14:53:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id_xe` int(225) NOT NULL,
  `ma_xe` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ten_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `gia_xe` decimal(10,0) NOT NULL,
  `anh_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hang_xe` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id_xe`, `ma_xe`, `ten_xe`, `gia_xe`, `anh_xe`, `hang_xe`) VALUES
(1, 'xe_1', 'Toyota Vios 2023', 650000000, '1.jpg', 'Xe mới|Sô tự động'),
(2, 'xe_2', 'Honda City 2022', 720000000, '2.jpg', 'Xe mới|Số tự động'),
(3, 'xe_3', 'KIa New Carnival', 987000000, '3.jpg', 'Xe cũ|Só tự động'),
(4, 'xe_4', 'Ford Ranger 2025', 979000000, '4.jpg', 'Xe mới|Số tự động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tintuc`
--

CREATE TABLE `tintuc` (
  `id_tt` int(100) NOT NULL,
  `anh_tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tt_tt` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `xemthem_tt` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ngaydang_tt` datetime DEFAULT current_timestamp(),
  `luotxem_tt` int(11) DEFAULT 0,
  `tomtat_tt` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tintuc`
--

INSERT INTO `tintuc` (`id_tt`, `anh_tt`, `tt_tt`, `xemthem_tt`, `ngaydang_tt`, `luotxem_tt`, `tomtat_tt`) VALUES
(1, '5.jpg', 'Đánh giá xe Lexus LX 600 2025: Khẳng định đẳng cấp xe \"Chủ tịch\"\r\nCác chuyên gia đánh giá xe Lexus LX 600 2025 sở hữu nhiều thay đổi, đặc biệt là động cơ, khả năng vận hành cũng như cung cấp một không gian trải nghiệm được nâng tầm cao mới.', 'Trải qua hơn 25 năm với 3 thế hệ đã bán ra thị trường, Lexus LX đã trở thành một trong những chiếc xe SUV hạng sang cỡ lớn rất được lòng khách hàng trên toàn thế giới. Mẫu xe này dù không bóng bảy, ngập tràn tiện nghi giống các đối thủ đến từ Đức như Mercedes-Benz GLS-Class, BMW X7,... nhưng vẫn luôn là sự lựa chọn hàng đầu của những doanh nhân thành đạt trong nhiều năm qua.\r\nKể từ khi \"người kế nhiệm\" LX 570 là Lexus LX 600 2025 trình làng đã thay đổi gần như hoàn toàn với ngoại hình góc cạnh, hiện đại hơn và ngập tràn tiện nghi ở khoang lái. All New Lexus LX 600 được dự đoán sẽ tiếp nối thành công của \"người tiền nhiệm\" LX 570 và trở thành chiếc SUV \"đắt show\" giống như những gì mà Toyota Land Cruiser đã từng thể hiện trước đó.......\r\n\r\n', '2025-05-27 18:40:51', 123, NULL),
(2, '6.jpg', 'Toyota Vios 1.5G 2014 - Đỉnh cao giữ giá tại Việt Nam\r\nKhông hổ danh là xe \"sedan quốc dân\" khi đã có hơn 1 thập niên lăn bánh nhưng những chiếc Toyota Vios 1.5G 2014 vẫn nhận được sự quan tâm lớn từ khách tìm mua xe cũ cùng độ giữ giá đỉnh cao.', 'Toyota Vios 2014 thuộc thế hệ thứ 3, bắt đầu mở bán tại thị trường ô tô Việt Nam vào tháng 4/2014. Tại thời điểm ra mắt, giá xe Toyota Vios 2014 bản G được đề xuất 612 triệu đồng. Sau hơn 10 năm lăn bánh, hiện những chiếc Vios cũ đời 2014 đang được chào bán với giá dao động 330-360 triệu đồng, giảm khoảng 41-46% so với giá mới.\r\nTrong khi tỷ lệ trượt giá của Honda City 1.5AT 2014 là khoảng 46,5-51,6%, từ 599 triệu đồng về 290-320 triệu đồng sau 10 năm sử dụng. Những chiếc Nissan Sunny XV 2014 cũng có độ trượt giá khá sâu khi đang được chào bán trong khoảng 250 triệu đồng, tức mất khoảng 57,5% giá trị so với giá niêm yết 588 triệu đồng ở thời điểm mở bán mới.......', '2025-05-27 18:40:51', 7, NULL),
(3, '7.jpg', 'So sánh xe Volkswagen Viloran 2024 và KIA Carnival 2024: \"Đẳng cấp\" xe Đức không phải lợi thế cạnh tranh\r\nSự khác biệt giữa Volkswagen Viloran và KIA Carnival không chỉ nằm ở giá thành, định vị thương hiệu mà còn thể hiện ở động cơ và trang bị nội thất. Vậy đâu là lựa chọn phù hợp với bạn?', 'Do hãng xe Đức định vị thương hiệu ở \"mức tiệm cận sang\" nên giá xe Viloran tách biệt hoàn toàn so với các mẫu MPV phổ thông. Giá thành cao hơn mặt bằng chung, cộng thêm xuất xứ từ Trung Quốc, Volkswagen Viloran cần nhiều thời gian để thuyết phục khách hàng dù \"đẳng cấp\" của thương hiệu đã được công nhận.\r\nDù không hội tụ những yếu tố đáp ứng tốt thị hiếu và thu nhập của khách Việt nhưng Volkswagen Viloran vẫn có nhóm khách hàng riêng, đó có thể là những người không đủ tài chính để nhắm đến các sản phẩm sang trọng như Mercedes-Benz V-Class (giá khởi điểm 3,039 tỷ đồng) nhưng vẫn muốn trải nghiệm trọn vẹn một mẫu xe của thương hiệu Đức, cao cấp hơn hẳn những chiếc MPV hiện có tại thị trường Việt Nam.....', '2025-05-27 18:40:51', 18, NULL),
(4, '8.jpg', 'Đánh giá xe VinFast VF 8 cũ: Mua xe \"lướt\" đời 2022 cần tránh lỗi gì?\r\nNguồn cung xe VinFast VF8 cũ khá dồi dào nhưng để chọn được chiếc xe \"ngon\" cần có sự am hiểu về xe và lưu ý những lỗi thường gặp đã được người dùng phản ánh trong thời qua.', 'VinFast VF8 là mẫu xe điện thứ 2 được hãng xe Việt tung ra thị trường sau màn chào sân của VinFast VF e34. Với người tiêu dùng Việt, ô tô điện vẫn là trải nghiệm mới mẻ bởi xe điện mới chỉ xuất hiện trên thị trường trong vài năm trở lại đây.\r\nViệc VinFast từ bỏ con đường sản xuất xe xăng truyền thống, trở thành thương hiệu tiên phong, mở ra xu hướng \"điện hóa\" là bước đi táo bạo, nhiều thử thách. Tuy nhiên, những thành tựu mà VinFast đạt được đã phần nào khẳng định đây là bước đi đúng đắn. Hai năm trở lại đây, những chiếc xe điện của VinFast ngày càng xuất hiện nhiều hơn trên mọi cung đường tại Việt Nam........\r\n\r\n', '2025-05-27 18:40:51', 1, NULL),
(5, '9.jpg', 'Đánh giá xe VinFast LUX A2.0 2019: Xe Việt, vận hành mạnh mẽ, có đáng đầu tư trong tầm giá 600 triệu đồng?\r\nChọn VinFast LUX A2.0 2019, bạn sẽ được phục vụ bởi một chiếc xe rộng rãi, tiện nghi cùng chi phí bỏ ra thấp, chỉ khoảng trên dưới 600 triệu đồng nhưng đổi lại người mua xe cũ phải chấp nhận điều gì?...\r\n\r\n', 'VinFast Lux A2.0 từng vượt qua sức hút của Toyota Camry để trở thành mẫu xe sedan đáng chọn nhất trong tầm giá 1 tỷ đồng tại Việt Nam. Thế nhưng dòng xe của VinFast có còn giữ được sức hấp dẫn sau thời gian sử dụng?\r\nHãy cùng chúng tôi tìm hiểu những ưu nhược điểm cũng như sự biến động về giá xe VinFast Lux A2.0 trong 6 năm lăn bánh để có sự đánh giá khách quan trước khi bạn đưa ra quyết định mua xe.......', '2025-05-27 18:40:51', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'thanhson', '$2y$10$0D0GZv2HB9BDoKeI.fjSHOa8c13AYhFpB7l/mXU9YTZX0tZceMJTW');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `chitietsp`
--
ALTER TABLE `chitietsp`
  ADD PRIMARY KEY (`id_xe`);

--
-- Chỉ mục cho bảng `chitiettt`
--
ALTER TABLE `chitiettt`
  ADD PRIMARY KEY (`id_tt`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
