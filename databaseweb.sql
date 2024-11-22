create database project;
use project;

CREATE TABLE categories (
  cat_id int(11) PRIMARY KEY AUTO_INCREMENT,
  cat_name varchar(50) NOT NULL,
  isDeleted tinyint(1) DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `project`.`categories` (`cat_id`, `cat_name`, `isDeleted`) VALUES ('1', 'laptop', '0');
INSERT INTO `project`.`categories` (`cat_id`, `cat_name`, `isDeleted`) VALUES ('2', 'laptop gaming', '0');

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `delivered_to` varchar(150) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 1,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE orders
  ADD KEY user_id (user_id);
  
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE products (
  prd_id int(11) PRIMARY KEY AUTO_INCREMENT,
  prd_name varchar(255) NOT NULL,
  prd_price decimal(10,2) NOT NULL,
  prd_image varchar(255) DEFAULT NULL,
  cat_id int(11) DEFAULT NULL,
  prdDeleted tinyint(1) DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE products
  ADD KEY cat_id (cat_id);

INSERT INTO products (prd_id, prd_name, prd_price, prd_image, cat_id, prdDeleted, created_at)
VALUES
(1, 'laptop_abc', 10000000, '7765_ac_m___i_99__laptop_dell_inspiron_14_5425_amd_r5_5625u_16gb_ram_14__3_.jpg', 1, 0, '2023-08-07 16:46:04'),
(2, 'laptop_abcd', 2000000, '7603_7603_3520_i3_1.jpg', 2, 0, '2023-08-07 16:52:01'),
(3, 'laptop_123', 3000000, '6731_ac_m___i_100__full_box_laptop_dell_inspiron_14_5415_r1505s_2.jpg', 1, 0, '2023-08-07 16:52:36'),
(4, 'laptop_234', 40000000, '8124_lenovo_yoga_slim_7_14acn6_82n7008vvn_1_.jpg', 1, 0, '2023-08-07 16:52:55'),
(5, 'laptop_345', 3000000, '7431_7431_ac___dell_xps_plus_9320___intel_core_i7_1260p.jpg', 2, 0, '2023-08-07 16:56:17'),
(6, 'laptop chính hãng', 400000, '7911_ac___lenovo_ideapad_5_pro_14iap7.jpg', 1, 0, '2023-08-07 16:56:41');  
  
-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `order_id` INT NOT NULL,
  `prd_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`order_id`, `prd_id`),
  FOREIGN KEY (`prd_id`) REFERENCES `products` (`prd_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE users (
  user_id int(11) PRIMARY KEY AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  user_email varchar(255) NOT NULL,
  isDeleted tinyint(1) DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE users
  ADD UNIQUE KEY email (user_email);
  
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('1', 'nguyen van a', 'nguyenVanA@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('2', 'nguyen van b', 'nguyenVanB@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('3', 'nguyen van c', 'nguyenVanC@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('4', 'nguyen van d', 'nguyenVanD@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('5', 'nguyen van e', 'nguyenVanE@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('6', 'nguyen van f', 'nguyenVanF@gmail.com', '0');
INSERT INTO `project`.`users` (`user_id`, `user_name`, `user_email`, `isDeleted`) VALUES ('7', 'nguyen van g', 'nguyenVanG@gmail.com', '0');

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE products
  ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (cat_id) REFERENCES categories (cat_id);
COMMIT;