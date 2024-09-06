-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 23, 2024 lúc 06:16 AM
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
-- Cơ sở dữ liệu: `tramsac_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoptaccungchungtoi`
--

CREATE TABLE `hoptaccungchungtoi` (
  `id_hoptac` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `LoaiKH` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date_up` datetime DEFAULT current_timestamp(),
  `date_edit` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `binhluan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tramsac`
--

CREATE TABLE `tramsac` (
  `id_tramsac` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `ND` text DEFAULT NULL,
  `kinhdo_vido` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `statu` tinyint(4) DEFAULT 1,
  `web` varchar(255) DEFAULT NULL,
  `tg_thanh_lap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tuvan`
--

CREATE TABLE `tuvan` (
  `id_advise` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `type_KH` varchar(50) DEFAULT NULL,
  `Content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `statu` tinyint(4) DEFAULT 1,
  `id_tramsac` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `hoptaccungchungtoi`
--
ALTER TABLE `hoptaccungchungtoi`
  ADD PRIMARY KEY (`id_hoptac`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`);

--
-- Chỉ mục cho bảng `tramsac`
--
ALTER TABLE `tramsac`
  ADD PRIMARY KEY (`id_tramsac`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `tuvan`
--
ALTER TABLE `tuvan`
  ADD PRIMARY KEY (`id_advise`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tramsac` (`id_tramsac`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `hoptaccungchungtoi`
--
ALTER TABLE `hoptaccungchungtoi`
  MODIFY `id_hoptac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tramsac`
--
ALTER TABLE `tramsac`
  MODIFY `id_tramsac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tuvan`
--
ALTER TABLE `tuvan`
  MODIFY `id_advise` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_tramsac`) REFERENCES `tramsac` (`id_tramsac`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
