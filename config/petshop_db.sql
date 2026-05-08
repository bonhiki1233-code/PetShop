-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2026 at 06:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price_old` decimal(12,2) DEFAULT NULL,
  `price_new` decimal(12,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `image_url` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_pet` tinyint(1) DEFAULT 0,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`product_id`, `product_name`, `price_old`, `price_new`, `stock_quantity`, `image_url`, `description`, `is_pet`, `slug`, `category_id`) VALUES
(1, 'Chó Poodle Tiny', NULL, 5000000.00, 10, 'poodle-tiny.jpg', '', 1, 'ch-poodle-tiny', 1),
(2, 'Mèo Anh lông ngắn', NULL, 4000000.00, 5, 'meo_anh.jpg', '', 1, 'm-o-anh-l-ng-ng-n', 2),
(3, 'Chó Husky', NULL, 8000000.00, 3, 'husky.jpg', NULL, 1, 'cho-husky', 1),
(4, 'Mèo Ba Tư Trắng', NULL, 6500000.00, 4, 'meo-ba-tu-trang.jpg', NULL, 1, 'meo-ba-tu-trang', 2),
(5, 'Sữa tắm cho chó Poodle', NULL, 150000.00, 50, 'sua-tam-cho-poodle.jpg', NULL, 0, 'sua-tam-cho-poodle', 3),
(6, 'Golden Retriever', NULL, 5000000.00, 5, 'golden-retriever.jpg', '', 0, 'golden', 1),
(7, 'Chó Poodle Teacup Trắng', 6500000.00, 6000000.00, 5, NULL, 'Chó Poodle size siêu nhỏ màu trắng tuyết.', 1, 'cho-poodle-teacup-trang', 1),
(8, 'Chó Poodle Toy Nâu Đỏ', NULL, 5000000.00, 10, NULL, 'Chó Poodle Toy lông xoăn tít màu nâu đỏ.', 1, 'cho-poodle-toy-nau-do', 1),
(9, 'Chó Poodle Standard Đen', 8500000.00, 8000000.00, 3, NULL, 'Chó Poodle size lớn màu đen, cực kỳ thông minh.', 1, 'cho-poodle-standard-den', 1),
(10, 'Chó Poodle Tiny Xám', 7000000.00, 6500000.00, 4, NULL, 'Chó Poodle Tiny màu xám hiếm.', 1, 'cho-poodle-tiny-xam', 1),
(11, 'Chó Poodle Teacup Bò Sữa', NULL, 7500000.00, 2, NULL, 'Chó Poodle Teacup màu bò sữa ngộ nghĩnh.', 1, 'cho-poodle-teacup-bo-sua', 1),
(12, 'Chó Poodle Toy Vàng Mơ', 5000000.00, 4500000.00, 8, NULL, 'Chó Poodle Toy màu vàng mơ óng ả.', 1, 'cho-poodle-toy-vang-mo', 1),
(13, 'Chó Poodle Tiny Socola', NULL, 5500000.00, 6, NULL, 'Chó Poodle Tiny màu socola đậm.', 1, 'cho-poodle-tiny-socola', 1),
(14, 'Chó Poodle Standard Nâu', 9000000.00, 8500000.00, 2, NULL, 'Chó Poodle Standard màu nâu, form dáng chuẩn.', 1, 'cho-poodle-standard-nau', 1),
(15, 'Chó Poodle Toy Đen', NULL, 4000000.00, 12, NULL, 'Chó Poodle Toy màu đen bóng.', 1, 'cho-poodle-toy-den', 1),
(16, 'Chó Poodle Tiny Trắng', 6000000.00, 5500000.00, 7, NULL, 'Chó Poodle Tiny trắng xinh như cục bông.', 1, 'cho-poodle-tiny-trang', 1),
(17, 'Chó Corgi Tricolor', 12000000.00, 11000000.00, 5, NULL, 'Corgi 3 màu mông to chân cực ngắn.', 1, 'cho-corgi-tricolor', 1),
(18, 'Chó Corgi Vàng Trắng', NULL, 10000000.00, 6, NULL, 'Corgi màu vàng trắng truyền thống.', 1, 'cho-corgi-vang-trang', 1),
(19, 'Chó Golden Retriever', 8000000.00, 7500000.00, 8, NULL, 'Golden thân thiện, thích hợp nuôi gia đình.', 1, 'cho-golden-retriever', 1),
(20, 'Chó Husky Đại Ngáo', NULL, 6500000.00, 4, NULL, 'Husky mắt xanh, năng động.', 1, 'cho-husky-dai-ngao', 1),
(21, 'Chó Alaska Malamute', 10000000.00, 9500000.00, 3, NULL, 'Alaska xám trắng form to.', 1, 'cho-alaska-malamute', 1),
(22, 'Chó Pug Mặt Xệ', NULL, 4500000.00, 7, NULL, 'Pug thuần chủng mặt xệ đáng yêu.', 1, 'cho-pug-mat-xe', 1),
(23, 'Chó Phốc Sóc Pomeranian', 7500000.00, 7000000.00, 5, NULL, 'Phốc sóc mini lông xù.', 1, 'cho-phoc-soc-pomeranian', 1),
(24, 'Chó Shiba Inu', 15000000.00, 14000000.00, 2, NULL, 'Shiba thuần chủng mặt cười.', 1, 'cho-shiba-inu', 1),
(25, 'Chó Samoyed Trắng', NULL, 9000000.00, 3, NULL, 'Samoyed lông trắng muốt như tuyết.', 1, 'cho-samoyed-trang', 1),
(26, 'Chó Beagle', 5500000.00, 5000000.00, 4, NULL, 'Beagle săn thỏ cực kỳ lanh lợi.', 1, 'cho-beagle', 1),
(27, 'Mèo Anh Lông Ngắn Xám Xanh', 4500000.00, 4000000.00, 10, NULL, 'Mèo ALN xám xanh mặt nọng.', 1, 'meo-aln-xam-xanh', 2),
(28, 'Mèo Anh Lông Ngắn Bicolor', NULL, 5000000.00, 8, NULL, 'Mèo ALN Bicolor hồng hào.', 1, 'meo-aln-bicolor', 2),
(29, 'Mèo Anh Lông Ngắn Golden', 8000000.00, 7500000.00, 5, NULL, 'Mèo ALN Golden ny11 siêu đẹp.', 1, 'meo-aln-golden', 2),
(30, 'Mèo Anh Lông Dài Trắng', NULL, 4500000.00, 7, NULL, 'Mèo ALD lông dài thướt tha.', 1, 'meo-ald-trang', 2),
(31, 'Mèo Ba Tư Mặt Tịt', 6500000.00, 6000000.00, 4, NULL, 'Mèo Ba Tư mặt tịt quý tộc.', 1, 'meo-ba-tu-mat-tit', 2),
(32, 'Mèo Scottish Fold Xám', NULL, 5500000.00, 6, NULL, 'Scottish tai cụp đáng yêu.', 1, 'meo-scottish-fold-xam', 2),
(33, 'Mèo Bengal', 15000000.00, 14000000.00, 2, NULL, 'Mèo Bengal vằn báo hoang dã.', 1, 'meo-bengal', 2),
(34, 'Mèo Xiêm Thái', 3500000.00, 3000000.00, 8, NULL, 'Mèo Xiêm thông minh quấn chủ.', 1, 'meo-xiem-thai', 2),
(35, 'Mèo Sphynx Không Lông', NULL, 12000000.00, 3, NULL, 'Mèo Ai Cập không lông độc lạ.', 1, 'meo-sphynx-khong-long', 2),
(36, 'Mèo Ragdoll Mắt Xanh', 18000000.00, 17000000.00, 2, NULL, 'Ragdoll bế lên là mềm nhũn.', 1, 'meo-ragdoll-mat-xanh', 2),
(37, 'Mèo Munchkin Chân Ngắn', NULL, 10000000.00, 5, NULL, 'Munchkin chân cực ngắn.', 1, 'meo-munchkin-chan-ngan', 2),
(38, 'Mèo ALN Silver', 7000000.00, 6500000.00, 4, NULL, 'Mèo ALN màu Silver Tabby.', 1, 'meo-aln-silver', 2),
(39, 'Mèo Exotic Lông Ngắn', NULL, 8000000.00, 3, NULL, 'Phiên bản lông ngắn của mèo Ba Tư.', 1, 'meo-exotic-long-ngan', 2),
(40, 'Mèo Maine Coon', 20000000.00, 19000000.00, 2, NULL, 'Mèo Maine Coon khổng lồ.', 1, 'meo-maine-coon', 2),
(41, 'Mèo Anh Lông Ngắn Chinchilla', 9000000.00, 8500000.00, 3, NULL, 'Màu Chinchilla cực sang chảnh.', 1, 'meo-aln-chinchilla', 2),
(42, 'Hạt Royal Canin Poodle Adult 1.5kg', 450000.00, 420000.00, 50, NULL, 'Thức ăn hạt chuyên biệt cho Poodle trưởng thành.', 0, 'hat-royal-canin-poodle-adult-15kg', 3),
(43, 'Hạt Royal Canin Poodle Puppy 1.5kg', NULL, 430000.00, 45, NULL, 'Thức ăn hạt cho Poodle con giúp phát triển lông.', 0, 'hat-royal-canin-poodle-puppy-15kg', 3),
(44, 'Sữa Tắm Khử Mùi Cho Poodle', 180000.00, 150000.00, 100, NULL, 'Sữa tắm giữ nếp lông xoăn và tạo mùi thơm lâu.', 0, 'sua-tam-khu-mui-cho-poodle', 3),
(45, 'Lược Chải Lông Xù Chống Rối Poodle', NULL, 85000.00, 80, NULL, 'Chuyên dụng chải lông xoăn không bị đau.', 0, 'luoc-chai-long-xu-chong-roi-poodle', 3),
(46, 'Xịt Dưỡng Lông Xoăn Poodle', 220000.00, 195000.00, 40, NULL, 'Giúp lông xốp, mềm mượt và dễ chải.', 0, 'xit-duong-long-xoan-poodle', 3),
(47, 'Áo Len Mùa Đông Cho Poodle Size M', NULL, 120000.00, 60, NULL, 'Giữ ấm cơ thể vào mùa đông.', 0, 'ao-len-mua-dong-cho-poodle-size-m', 3),
(48, 'Áo Váy Công Chúa Cho Poodle Size S', 150000.00, 130000.00, 50, NULL, 'Váy ren tiểu thư cho các bé gái.', 0, 'ao-vay-cong-chua-cho-poodle-size-s', 3),
(49, 'Kéo Tỉa Lông Chó Chuyên Nghiệp', NULL, 350000.00, 20, NULL, 'Bộ kéo cong, thẳng và kéo tỉa mỏng.', 0, 'keo-tia-long-cho-chuyen-nghiep', 3),
(50, 'Balo Phi Hành Gia Cho Poodle', 300000.00, 250000.00, 40, NULL, 'Balo vận chuyển có lỗ thoáng khí.', 0, 'balo-phi-hanh-gia-cho-poodle', 3),
(51, 'Xương Gặm Sạch Răng Cho Chó Nhỏ', NULL, 65000.00, 150, NULL, 'Giúp lấy đi mảng bám trên răng cún.', 0, 'xuong-gam-sach-rang-cho-cho-nho', 3),
(52, 'Dây Dắt Ngực Cho Chó Dưới 5kg', 120000.00, 95000.00, 70, NULL, 'Dây dắt êm ái không siết cổ.', 0, 'day-dat-nguc-cho-cho-duoi-5kg', 3),
(53, 'Khay Vệ Sinh Chó Có Cọc', NULL, 150000.00, 45, NULL, 'Huấn luyện cún đi vệ sinh đúng chỗ.', 0, 'khay-ve-sinh-cho-co-coc', 3),
(54, 'Tã Lót Khay Vệ Sinh Chó (Bịch 100 tờ)', 200000.00, 180000.00, 80, NULL, 'Thấm hút tốt, khử mùi amoniac.', 0, 'ta-lot-khay-ve-sinh-cho', 3),
(55, 'Bát Ăn Chống Nghẹn Cho Chó', NULL, 85000.00, 60, NULL, 'Giúp cún ăn chậm lại, tốt cho tiêu hóa.', 0, 'bat-an-chong-nghen-cho-cho', 3),
(56, 'Sữa Bột Bio Milk Cho Chó Con', 130000.00, 115000.00, 90, NULL, 'Bổ sung dinh dưỡng thay thế sữa mẹ.', 0, 'sua-bot-bio-milk-cho-cho-con', 3),
(57, 'Thuốc Trị Ve Rận Nexgard', NULL, 320000.00, 50, NULL, 'Viên nhai trị ve rận dạng thịt bò cực nhạy.', 0, 'thuoc-tri-ve-ran-nexgard', 3),
(58, 'Vòng Cổ Chuông Da Thật', 75000.00, 60000.00, 120, NULL, 'Vòng cổ gắn chuông chống lạc.', 0, 'vong-co-chuong-da-that', 3),
(59, 'Đồ Chơi Thừng Cắn Răng', NULL, 45000.00, 200, NULL, 'Giúp cún xả stress, ngứa răng.', 0, 'do-choi-thung-can-rang', 3),
(60, 'Đồ Chơi Gà La Hét', 35000.00, 25000.00, 150, NULL, 'Tạo tiếng kêu vui nhộn khi cắn.', 0, 'do-choi-ga-la-het', 3),
(61, 'Nệm Ngủ Tròn Khổ 50cm', NULL, 250000.00, 40, NULL, 'Êm ái, có thể giặt máy.', 0, 'nem-ngu-tron-kho-50cm', 3),
(62, 'Nước Hoa Thú Cưng Khử Mùi', 150000.00, 120000.00, 60, NULL, 'Giữ hương thơm mát suốt cả tuần.', 0, 'nuoc-hoa-thu-cung-khu-mui', 3),
(63, 'Kìm Cắt Móng Có Đèn LED', NULL, 180000.00, 35, NULL, 'Tránh cắt vào tủy máu của cún.', 0, 'kim-cat-mong-co-den-led', 3),
(64, 'Giũa Móng Tự Động Cho Chó', 250000.00, 220000.00, 25, NULL, 'Mài móng an toàn không gây tiếng ồn lớn.', 0, 'giua-mong-tu-dong-cho-cho', 3),
(65, 'Khăn Tắm Siêu Thấm Hút', NULL, 65000.00, 100, NULL, 'Vắt kiệt nước và lau khô nhanh chóng.', 0, 'khan-tam-sieu-tham-hut', 3),
(66, 'Xịt Khử Mùi Nước Tiểu Chó', 120000.00, 95000.00, 75, NULL, 'Phân hủy sinh học mùi hôi.', 0, 'xit-khu-mui-nuoc-tieu-cho', 3),
(67, 'Bánh Thưởng Huấn Luyện Vị Bò', NULL, 55000.00, 130, NULL, 'Khen thưởng khi dạy lệnh.', 0, 'banh-thuong-huan-luyen-vi-bo', 3),
(68, 'Pate Cún Con SmartHeart', 25000.00, 22000.00, 300, NULL, 'Gói pate mềm thơm ngon.', 0, 'pate-cun-con-smartheart', 3),
(69, 'Pate Bò Rau Củ Vissan', NULL, 35000.00, 200, NULL, 'Bổ sung chất xơ và protein.', 0, 'pate-bo-rau-cu-vissan', 3),
(70, 'Chuồng Ghép Sắt Tĩnh Điện', 350000.00, 300000.00, 30, NULL, '6 tấm ghép dễ dàng lắp ráp.', 0, 'chuong-ghep-sat-tinh-dien', 3),
(71, 'Bình Nước Gắn Chuồng Chó', NULL, 75000.00, 80, NULL, 'Dạng bi lăn chống sặc.', 0, 'binh-nuoc-gan-chuong-cho', 3),
(72, 'Hạt Royal Canin Kitten 2kg', 480000.00, 450000.00, 60, NULL, 'Thức ăn hạt cho mèo con.', 0, 'hat-royal-canin-kitten-2kg', 3),
(73, 'Hạt Catsrang 5kg', NULL, 350000.00, 40, NULL, 'Hạt bình dân cho mèo trưởng thành.', 0, 'hat-catsrang-5kg', 3),
(74, 'Cát Đậu Nành Tofu', 120000.00, 100000.00, 150, NULL, 'Xả được bồn cầu, mùi trà xanh.', 0, 'cat-dau-nanh-tofu', 3),
(75, 'Cát Đất Sét Khử Mùi', NULL, 65000.00, 200, NULL, 'Vón cục tốt, giá tiết kiệm.', 0, 'cat-dat-set-khu-mui', 3),
(76, 'Khay Vệ Sinh Mèo Thành Cao', 180000.00, 150000.00, 50, NULL, 'Chống văng cát ra nhà.', 0, 'khay-ve-sinh-meo-thanh-cao', 3),
(77, 'Nhà Vệ Sinh Mèo Kín', NULL, 350000.00, 30, NULL, 'Khử mùi tuyệt đối, có cửa lật.', 0, 'nha-ve-sinh-meo-kin', 3),
(78, 'Cần Câu Mèo Gắn Lông Vũ', 35000.00, 25000.00, 120, NULL, 'Kích thích bản năng săn mồi.', 0, 'can-cau-meo-gan-long-vu', 3),
(79, 'Bàn Cào Móng Xơ Mướp', NULL, 85000.00, 90, NULL, 'Bảo vệ sofa khỏi móng mèo.', 0, 'ban-cao-mong-xo-muop', 3),
(80, 'Súp Thưởng Ciao Churu (Bịch 4 thanh)', 50000.00, 45000.00, 500, NULL, 'Mèo nào cũng ghiền.', 0, 'sup-thuong-ciao-churu', 3),
(81, 'Pate Whiskas Vị Cá Ngừ', NULL, 15000.00, 400, NULL, 'Pate gói tiện lợi.', 0, 'pate-whiskas-vi-ca-ngu', 3),
(82, 'Pate Snappy Tom Lon 400g', 45000.00, 40000.00, 150, NULL, 'Thịt cá thật 100%.', 0, 'pate-snappy-tom-lon-400g', 3),
(83, 'Vòng Cổ Định Vị GPS', NULL, 450000.00, 15, NULL, 'Theo dõi vị trí qua điện thoại.', 0, 'vong-co-dinh-vi-gps', 3),
(84, 'Máy Dọn Phân Mèo Tự Động', 8500000.00, 8000000.00, 5, NULL, 'Giải phóng sức lao động cho Sen.', 0, 'may-don-phan-meo-tu-dong', 3),
(85, 'Bát Ăn Đôi Cho Mèo Góc Nghiêng 15 độ', NULL, 120000.00, 60, NULL, 'Bảo vệ đốt sống cổ cho mèo.', 0, 'bat-an-doi-cho-meo-goc-nghieng', 3),
(86, 'Lược Chải Rụng Lông Mèo Furminator', 250000.00, 200000.00, 45, NULL, 'Lấy đi 90% lông rụng.', 0, 'luoc-chai-rung-long-meo-furminator', 3),
(87, 'Sữa Tắm Khô Cho Mèo', NULL, 130000.00, 70, NULL, 'Tắm không cần dùng nước.', 0, 'sua-tam-kho-cho-meo', 3),
(88, 'Cỏ Bạc Hà Catnip Hữu Cơ', 45000.00, 35000.00, 200, NULL, 'Giúp mèo thư giãn, phê pha.', 0, 'co-bac-ha-catnip-huu-co', 3),
(89, 'Đồ Chơi Chuột Lật Đật', NULL, 55000.00, 100, NULL, 'Mèo tự chơi khi Sen đi vắng.', 0, 'do-choi-chuot-lat-dat', 3),
(90, 'Xịt Khử Mùi Khay Vệ Sinh Mèo', 95000.00, 80000.00, 80, NULL, 'Diệt khuẩn và mùi hôi.', 0, 'xit-khu-mui-khay-ve-sinh-meo', 3),
(91, 'Giường Ngủ Gắn Cửa Sổ Cho Mèo', NULL, 220000.00, 35, NULL, 'Hút chân không chắc chắn lên kính.', 0, 'giuong-ngu-gan-cua-so-cho-meo', 3),
(92, 'Cây Cào Móng Cat Tree 3 Tầng', 850000.00, 750000.00, 20, NULL, 'Khu vui chơi liên hoàn cho mèo.', 0, 'cay-cao-mong-cat-tree-3-tang', 3),
(93, 'Thuốc Tẩy Giun Sán Drontal', NULL, 65000.00, 100, NULL, 'Tẩy giun định kỳ an toàn.', 0, 'thuoc-tay-giun-san-drontal', 3),
(94, 'Nhỏ Gáy Trị Rận Mèo Broadline', 250000.00, 230000.00, 40, NULL, 'Phòng và trị rận, nội ngoại ký sinh trùng.', 0, 'nho-gay-tri-ran-meo-broadline', 3),
(95, 'Thức Ăn Ướt Nekko Jelly', NULL, 20000.00, 300, NULL, 'Thức ăn ướt cao cấp từ Nhật.', 0, 'thuc-an-uot-nekko-jelly', 3),
(96, 'Sữa Bột KMR Cho Mèo Con Sơ Sinh', 450000.00, 420000.00, 25, NULL, 'Sữa công thức số 1 cho mèo con.', 0, 'sua-bot-kmr-cho-meo-con-so-sinh', 3),
(97, 'Bát Gốm Sứ Chống Trượt', NULL, 150000.00, 50, NULL, 'Nặng, khó lật, dễ rửa sạch.', 0, 'bat-gom-su-chong-truot', 3),
(98, 'Cửa Lật Gắn Cửa Nhôm Chó Mèo', 220000.00, 190000.00, 30, NULL, 'Pet tự ra vào phòng không cần mở cửa chính.', 0, 'cua-lat-gan-cua-nhom-cho-meo', 3),
(99, 'Máy Cho Ăn Tự Động Có Camera', NULL, 1500000.00, 10, NULL, 'Cho ăn từ xa và nói chuyện qua app.', 0, 'may-cho-an-tu-dong-co-camera', 3),
(100, 'Bình Lọc Nước Tự Động Hình Hoa', 350000.00, 290000.00, 40, NULL, 'Kích thích pet uống nhiều nước hơn.', 0, 'binh-loc-nuoc-tu-dong-hinh-hoa', 3),
(101, 'Khăn Ướt Lau Mắt Mũi Chuyên Dụng', NULL, 45000.00, 150, NULL, 'An toàn, không gây kích ứng.', 0, 'khan-uot-lau-mat-mui-chuyen-dung', 3),
(102, 'Nước Súc Miệng Lấy Cao Răng', 180000.00, 150000.00, 50, NULL, 'Pha vào nước uống hằng ngày.', 0, 'nuoc-suc-mieng-lay-cao-rang', 3),
(103, 'Viên Nhai Bổ Sung Canxi Xương Khớp', NULL, 220000.00, 60, NULL, 'Ngừa hạ bàn, chắc xương.', 0, 'vien-nhai-bo-sung-canxi-xuong-khop', 3),
(104, 'Gel Dinh Dưỡng Nutri-plus Virbac', 250000.00, 230000.00, 80, NULL, 'Bồi bổ cho pet ốm hoặc kén ăn.', 0, 'gel-dinh-duong-nutri-plus-virbac', 3),
(105, 'Bàn Chải Đánh Răng Thú Cưng', NULL, 35000.00, 100, NULL, 'Đeo ngón tay tiện lợi.', 0, 'ban-chai-danh-rang-thu-cung', 3),
(106, 'Găng Tay Chải Lông Lấy Lông Rụng', 65000.00, 50000.00, 120, NULL, 'Vừa vuốt ve vừa lấy đi lông chết.', 0, 'gang-tay-chai-long-lay-long-rung', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `slug_UNIQUE` (`slug`),
  ADD KEY `fk_products_categories` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `fk_products_categories` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
