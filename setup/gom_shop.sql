-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 01, 2026 lúc 08:59 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `gom_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(20) DEFAULT 'ban',
  `phone` varchar(50) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Chờ xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer`, `created_at`, `type`, `phone`, `status`) VALUES
(22, 'kho bình phước', '2026-05-14 13:45:59', 'nhap', '0366306454', 'Chờ xác nhận'),
(23, 'kho bình phước', '2026-05-14 13:48:57', 'nhap', '0366306454', 'Chờ xác nhận'),
(24, 'kho bình phước', '2026-05-14 13:56:07', 'nhap', '0366306454', 'Chờ xác nhận'),
(25, 'a', '2026-05-15 14:03:18', 'nhap', '123456', 'Chờ xác nhận'),
(26, 'aa', '2026-05-25 03:08:22', 'nhap', '123456', 'Chờ xác nhận'),
(27, 'aa', '2026-05-25 03:38:17', 'nhap', '123456', 'Chờ xác nhận'),
(28, 'aa', '2026-05-25 03:41:51', 'ban', '123456', 'Chờ xác nhận'),
(32, 'a', '2026-05-25 03:50:08', 'nhap', 'aaaa', 'Chờ xác nhận'),
(33, 'a', '2026-05-25 03:50:20', 'ban', '123456', 'Chờ xác nhận'),
(34, 'ddd', '2026-05-25 08:18:14', 'nhap', 'aaaa', 'Chờ xác nhận'),
(37, 'aa', '2026-05-25 08:25:50', 'nhap', '123456', 'Chờ xác nhận'),
(38, 'ddd', '2026-05-28 13:35:54', 'nhap', '123456', 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`) VALUES
(15, 22, 13, 5),
(16, 23, 12, 10),
(17, 24, 6, 5),
(18, 25, 5, 5),
(19, 26, 12, 2),
(20, 27, 10, 20),
(21, 28, 23, 1),
(22, 28, 22, 1),
(23, 28, 21, 1),
(24, 32, 4, 20),
(25, 33, 12, 1),
(26, 34, 23, 5),
(29, 37, 16, 10),
(30, 38, 21, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `stock`, `quantity`) VALUES
(2, 'bát gốm hoa văn', 120000, '1777907195_bat.jpg', 0, 0),
(4, 'bình hoa bầu', 200000, '1777907214_binhbau.jpg', 16, 0),
(5, 'bình hoa cổ dài', 150000, '1777907226_binhcodai.jpg', 5, 0),
(6, 'bộ 3 bình hoa men rạn', 500000, '1777907388_bo3binhhoa.jpg', 5, 0),
(9, 'bình hoa họa tiết hoa mai', 500000, '1777907358_binhhoatiethoamai.jpg', 0, 0),
(10, 'chén dĩa trưng bày', 250000, 'bo-chen-dia.jpg', 20, 0),
(11, 'bộ chén dĩa ', 270000, 'bo-chen.jpg', 0, 0),
(12, 'bộ ấm trà bát tràng', 300000, 'am-tra.jpg', 11, 0),
(13, 'bộ ấm nâu', 250000, 'bo-am-tra.jpg', 5, 0),
(14, 'tượng tế công', 350000, 'te-cong.jpg', 0, 0),
(15, 'tượng lão tử', 1250000, 'lao-tu.jpg', -2, 0),
(16, 'tượng di lạc', 1100000, 'di-lac.jpg', 10, 0),
(17, 'dĩa gốm trưng bày', 150000, 'dia-son-thuy.jpg', 0, 0),
(18, 'lu gốm men xanh', 190000, 'lu-gom.jpg', 0, 0),
(19, 'lư hương bạch ngọc', 1000000, 'lu-huong-bach-ngoc.jpg', 0, 0),
(20, 'cặp lục bình trang trí phong thủy', 2000000, 'cap-luc-binh.jpg', 0, 0),
(21, 'Tượng Hưng Đạo Vương', 5000000, 'Tuong tuong Tran Hung Dao.jpg', 4, 0),
(22, 'Bình Phong Thủy Dát Vàng', 3500000, 'binh-dat-vang.jpg', -1, 0),
(23, 'Cặp Lục Bình Dát Vàng', 4000000, 'luc-binh.jpg', 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(1, 'kietnv251194', '$2y$10$.TChd548K1yKHLMJJunzk.yMbzdTaDF0WyXIKw54CDvKajzDEMoUa', '2026-05-10 14:13:27', 'admin'),
(2, 'kietnv2511945', '$2y$10$YdvSE9eAudNp4FaMn/U0MOqcLwoXm732ZR0ytISVUConuijIGn4su', '2026-05-15 12:28:57', 'user'),
(3, 'kietnv2511', '$2y$10$pJG6Has7K0gXeN3Y8RQKieYb4DYVFnhjYVGf8NYiPTqjtPxMcslYS', '2026-05-25 01:17:20', 'user'),
(4, 'kietnv25', '$2y$10$UOhe3EP9EbfU5tEpfL2sX.yh0nCNw.jeF2PDFMUHcH9Bd5LRLwlQ2', '2026-05-25 01:17:37', 'user'),
(5, 'seller1', '123456', '2026-05-28 14:24:16', 'seller'),
(6, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2026-05-29 13:30:12', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

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
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
