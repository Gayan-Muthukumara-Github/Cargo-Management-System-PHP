-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2022 at 09:10 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargo_items`
--

CREATE TABLE `cargo_items` (
  `cargo_id` int(30) NOT NULL,
  `cargo_type_id` int(30) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `weight` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cargo_items`
--

INSERT INTO `cargo_items` (`cargo_id`, `cargo_type_id`, `price`, `weight`, `total`) VALUES
(1, 1, 550, 3, 1650),
(1, 2, 450, 10, 4500),
(1, 3, 800, 5, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_list`
--

CREATE TABLE `cargo_list` (
  `id` int(30) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `shipping_type` int(1) NOT NULL DEFAULT 1 COMMENT '1 = city to city,\r\n2 = state to state,\r\n3 = country to country',
  `total_amount` double NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending,\r\n1 = In-Transit,\r\n2 = Arrived at Station,\r\n3 = Out for Delivery,\r\n4 = Delivered',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cargo_list`
--

INSERT INTO `cargo_list` (`id`, `ref_code`, `shipping_type`, `total_amount`, `status`, `date_created`, `date_updated`) VALUES
(1, '20220200001', 3, 10150, 2, '2022-02-22 13:12:50', '2022-02-22 14:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_meta`
--

CREATE TABLE `cargo_meta` (
  `cargo_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cargo_meta`
--

INSERT INTO `cargo_meta` (`cargo_id`, `meta_field`, `meta_value`) VALUES
(1, 'sender_name', 'Mark Cooper'),
(1, 'sender_contact', '09123456789'),
(1, 'sender_address', 'Sample Address Only'),
(1, 'sender_provided_id_type', 'TIN'),
(1, 'sender_provided_id', '456789954'),
(1, 'receiver_name', 'Samantha Jane Miller'),
(1, 'receiver_contact', '096547892213'),
(1, 'receiver_address', 'This a sample address only'),
(1, 'from_location', 'This is a sample From Location'),
(1, 'to_location', 'This is a sample of Cargo\'s Destination.');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_type_list`
--

CREATE TABLE `cargo_type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `city_price` double NOT NULL DEFAULT 0,
  `state_price` double NOT NULL DEFAULT 0,
  `country_price` double NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinytext NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cargo_type_list`
--

INSERT INTO `cargo_type_list` (`id`, `name`, `description`, `city_price`, `state_price`, `country_price`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Electronic Devices', 'Mobile/Smartphones, Tv, Computer/Laptop, etc.', 150, 250, 550, 1, '0', '2022-02-22 10:15:41', NULL),
(2, 'Dry Foods', 'Dry Foods', 100, 200, 450, 1, '0', '2022-02-22 10:16:17', NULL),
(3, 'Fragile', 'Easy to break such as glasses.', 200, 400, 800, 1, '0', '2022-02-22 10:18:55', NULL),
(4, 'test', 'test', 1, 2, 3, 0, '1', '2022-02-22 10:19:07', '2022-02-22 10:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Mobile Comparison Website'),
(6, 'short_name', 'MCW - PHP'),
(11, 'logo', 'uploads/logo-1645494239.jpg?v=1645494239'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1645494240.jpg?v=1645494240');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_list`
--

CREATE TABLE `tracking_list` (
  `id` int(30) NOT NULL,
  `cargo_id` int(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tracking_list`
--

INSERT INTO `tracking_list` (`id`, `cargo_id`, `title`, `description`, `date_added`) VALUES
(1, 1, 'Pending', ' Shipment created.', '2022-02-22 14:39:09'),
(2, 1, 'In-Transit', 'Cargo has been departed.', '2022-02-22 14:42:18'),
(3, 1, 'Arrive at Station', 'Cargo has arrived at the station', '2022-02-22 14:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2021-01-20 14:02:37', '2022-02-17 10:21:45'),
(5, 'John', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', 'uploads/avatars/5.png?v=1645514943', NULL, 2, '2022-02-22 15:29:03', '2022-02-22 15:34:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo_items`
--
ALTER TABLE `cargo_items`
  ADD KEY `cargo_id` (`cargo_id`),
  ADD KEY `cargo_type_list` (`cargo_type_id`);

--
-- Indexes for table `cargo_list`
--
ALTER TABLE `cargo_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_meta`
--
ALTER TABLE `cargo_meta`
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `cargo_type_list`
--
ALTER TABLE `cargo_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_list`
--
ALTER TABLE `tracking_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo_list`
--
ALTER TABLE `cargo_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cargo_type_list`
--
ALTER TABLE `cargo_type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tracking_list`
--
ALTER TABLE `tracking_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargo_items`
--
ALTER TABLE `cargo_items`
  ADD CONSTRAINT `cargo_id_FK` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cargo_type_id_FK` FOREIGN KEY (`cargo_type_id`) REFERENCES `cargo_type_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cargo_meta`
--
ALTER TABLE `cargo_meta`
  ADD CONSTRAINT `cargo_meta_id_FK` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tracking_list`
--
ALTER TABLE `tracking_list`
  ADD CONSTRAINT `cargo_id_FK2` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
