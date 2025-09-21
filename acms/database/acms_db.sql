-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 07:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `cargo_allocation`
--

CREATE TABLE `cargo_allocation` (
  `id` int(30) NOT NULL,
  `cargo_id` int(30) NOT NULL,
  `storage_unit_id` int(30) NOT NULL,
  `allocated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `released_at` datetime DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'allocated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo_allocation`
--

INSERT INTO `cargo_allocation` (`id`, `cargo_id`, `storage_unit_id`, `allocated_at`, `released_at`, `status`) VALUES
(1, 4, 3, '2025-09-07 23:02:26', '2025-09-08 21:07:03', 'released'),
(2, 5, 3, '2025-09-08 22:21:11', NULL, 'allocated'),
(3, 6, 3, '2025-09-08 23:30:42', NULL, 'allocated'),
(4, 7, 1, '2025-09-10 21:22:47', NULL, 'allocated'),
(5, 8, 1, '2025-09-11 20:51:20', NULL, 'allocated');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo_items`
--

INSERT INTO `cargo_items` (`cargo_id`, `cargo_type_id`, `price`, `weight`, `total`) VALUES
(3, 2, 450, 2, 900),
(1, 1, 550, 3, 1650),
(1, 2, 450, 10, 4500),
(1, 3, 800, 5, 4000),
(4, 3, 800, 5, 4000),
(5, 2, 100, 1200, 120000),
(6, 2, 100, 750, 75000),
(7, 2, 100, 200, 20000),
(8, 2, 100, 250, 25000);

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
  `compliance_status` enum('pending','compliant','non_compliant','requires_approval') NOT NULL DEFAULT 'pending',
  `is_hazardous` tinyint(1) NOT NULL DEFAULT 0,
  `is_perishable` tinyint(1) NOT NULL DEFAULT 0,
  `storage_start_time` datetime DEFAULT NULL,
  `max_storage_hours` int(11) DEFAULT NULL,
  `weight_kg` decimal(10,2) DEFAULT NULL,
  `length_cm` int(11) DEFAULT NULL,
  `width_cm` int(11) DEFAULT NULL,
  `height_cm` int(11) DEFAULT NULL,
  `special_handling_required` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo_list`
--

INSERT INTO `cargo_list` (`id`, `ref_code`, `shipping_type`, `total_amount`, `status`, `compliance_status`, `is_hazardous`, `is_perishable`, `storage_start_time`, `max_storage_hours`, `weight_kg`, `length_cm`, `width_cm`, `height_cm`, `special_handling_required`, `date_created`, `date_updated`) VALUES
(1, '20220200001', 3, 10150, 4, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2022-02-22 13:12:50', '2025-09-07 00:10:21'),
(3, '20250900001', 3, 900, 4, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-04 01:11:51', '2025-09-04 01:53:55'),
(4, '20250900002', 3, 4000, 4, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-07 23:02:25', '2025-09-08 21:07:03'),
(5, '20250900003', 1, 120000, 2, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-08 22:21:10', '2025-09-08 22:26:03'),
(6, '20250900004', 1, 75000, 0, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-08 23:30:42', NULL),
(7, '20250900005', 1, 20000, 0, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-10 21:22:46', NULL),
(8, '20250900006', 1, 25000, 1, 'pending', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-11 20:51:19', '2025-09-11 20:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_meta`
--

CREATE TABLE `cargo_meta` (
  `cargo_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo_meta`
--

INSERT INTO `cargo_meta` (`cargo_id`, `meta_field`, `meta_value`) VALUES
(3, 'sender_name', 'Muthunayakage Gayan Lakshitha Muthukumara'),
(3, 'sender_contact', '0713442101'),
(3, 'sender_email', 'mglmuthukumara@gmail.com'),
(3, 'sender_address', 'Kurunegala'),
(3, 'sender_provided_id_type', 'NIC'),
(3, 'sender_provided_id', '972860360V'),
(3, 'receiver_name', 'Nimmi Jayamali'),
(3, 'receiver_contact', '0713442101'),
(3, 'receiver_email', 'nimmi.jayamali@gmail.com'),
(3, 'receiver_address', 'Kandy'),
(3, 'from_location', 'Melbourn, Australlia'),
(3, 'to_location', 'Kadawatha , Kurunegala'),
(1, 'sender_name', 'Mark Cooper'),
(1, 'sender_contact', '09123456789'),
(1, 'sender_email', 'mark@gamil.com'),
(1, 'sender_address', 'Sample Address Only'),
(1, 'sender_provided_id_type', 'TIN'),
(1, 'sender_provided_id', '456789954'),
(1, 'receiver_name', 'Samantha Jane Miller'),
(1, 'receiver_contact', '096547892213'),
(1, 'receiver_email', 'muthukumaragayan@gmail.com'),
(1, 'receiver_address', 'This a sample address only'),
(1, 'from_location', 'This is a sample From Location'),
(1, 'to_location', 'This is a sample of Cargo\s Destination.'),
(4, 'sender_name', 'Nimal Perera'),
(4, 'sender_contact', '0713223456'),
(4, 'sender_email', 'jayamali.nimmi@gmail.com'),
(4, 'sender_address', 'Auckland , New Zeeland.'),
(4, 'sender_provided_id_type', 'NIC'),
(4, 'sender_provided_id', '972860334V'),
(4, 'receiver_name', 'Amali Perera'),
(4, 'receiver_contact', '0713442189'),
(4, 'receiver_email', 'nimmi.jayamali@gmail.com'),
(4, 'receiver_address', 'Kurunegala, Sri Lanka'),
(4, 'from_location', 'No 89, Auckland , New Zeeland.'),
(4, 'to_location', 'Kudahirimulla , Kowana, Hindagolla , Kurunegala'),
(5, 'sender_name', 'Nimal Perera'),
(5, 'sender_contact', '+94 77 456 7890'),
(5, 'sender_email', 'jayamali.nimmi@gmail.com'),
(5, 'sender_address', 'No. 25, Galle Road, Colombo 03'),
(5, 'sender_provided_id_type', 'NIC'),
(5, 'sender_provided_id', '852365478V'),
(5, 'receiver_name', 'Kavindu Silva'),
(5, 'receiver_contact', '+94 71 234 5678'),
(5, 'receiver_email', 'nimmi.jayamali@gmail.com'),
(5, 'receiver_address', 'No. 12, Peradeniya Road, Kandy'),
(5, 'from_location', 'Colombo'),
(5, 'to_location', 'Kandy'),
(6, 'sender_name', 'Nimal Perera'),
(6, 'sender_contact', '+94 77 456 7890'),
(6, 'sender_email', 'jayamali.nimmi@gmail.com'),
(6, 'sender_address', 'No. 25, Galle Road, Colombo 03'),
(6, 'sender_provided_id_type', 'NIC'),
(6, 'sender_provided_id', '852365478V'),
(6, 'receiver_name', 'Kavindu Silva'),
(6, 'receiver_contact', '+94 71 234 5678'),
(6, 'receiver_email', 'nimmi.jayamali@gmail.com'),
(6, 'receiver_address', 'No. 25, Galle Road, Colombo 03'),
(6, 'from_location', 'Colombo'),
(6, 'to_location', 'Kandy'),
(7, 'sender_name', 'Jone Silva'),
(7, 'sender_contact', '0713442134'),
(7, 'sender_email', 'jayamali.nimmi@gmail.com'),
(7, 'sender_address', 'No. 12, Peradeniya Road, Kandy'),
(7, 'sender_provided_id_type', 'NIC'),
(7, 'sender_provided_id', '852365478V'),
(7, 'receiver_name', 'Kamidu Mendis'),
(7, 'receiver_contact', '+94 71 234 5667'),
(7, 'receiver_email', 'nimmi.jayamali@gmail.com'),
(7, 'receiver_address', 'No. 12, Peradeniya Road, Kandy'),
(7, 'from_location', 'Colombo'),
(7, 'to_location', 'Kandy'),
(7, 'weight_kg', '200'),
(7, 'length_cm', '30'),
(7, 'width_cm', '20'),
(7, 'height_cm', '10'),
(7, 'is_perishable', '1'),
(7, 'max_storage_hours', '48'),
(8, 'sender_name', 'Jone Silva'),
(8, 'sender_contact', '0713442134'),
(8, 'sender_email', 'jayamali.nimmi@gmail.com'),
(8, 'sender_address', 'Kurunegala'),
(8, 'sender_provided_id_type', 'NIC'),
(8, 'sender_provided_id', '852365478V'),
(8, 'receiver_name', 'Kamidu Mendis'),
(8, 'receiver_contact', '+94 71 234 5667'),
(8, 'receiver_email', 'mglmuthukumara@gmail.com'),
(8, 'receiver_address', 'Kurunegala'),
(8, 'from_location', 'Colombo'),
(8, 'to_location', 'Jaffna'),
(8, 'weight_kg', '250'),
(8, 'length_cm', '30'),
(8, 'width_cm', '20'),
(8, 'height_cm', '10'),
(8, 'is_perishable', '1'),
(8, 'max_storage_hours', '48');

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
  `is_perishable` tinyint(1) NOT NULL DEFAULT 0,
  `is_hazardous` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinytext NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo_type_list`
--

INSERT INTO `cargo_type_list` (`id`, `name`, `description`, `city_price`, `state_price`, `country_price`, `is_perishable`, `is_hazardous`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Electronic Devices', 'Mobile/Smartphones, Tv, Computer/Laptop, etc.', 150, 250, 550, 0, 0, 1, '0', '2022-02-22 10:15:41', NULL),
(2, 'Dry Foods', 'Dry Foods', 100, 200, 450, 1, 0, 1, '0', '2022-02-22 10:16:17', '2025-09-09 22:37:23'),
(3, 'Fragile', 'Easy to break such as glasses.', 200, 400, 800, 1, 0, 1, '0', '2022-02-22 10:18:55', '2025-09-09 22:37:23'),
(4, 'test', 'test', 1, 2, 3, 0, 0, 0, '1', '2022-02-22 10:19:07', '2022-02-22 10:19:11'),
(5, 'Wood', 'Wood items', 3500, 20000, 500000, 0, 0, 1, '0', '2025-09-07 00:08:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compliance_checks`
--

CREATE TABLE `compliance_checks` (
  `id` int(30) NOT NULL,
  `cargo_id` int(30) NOT NULL,
  `check_type` varchar(50) NOT NULL,
  `check_status` enum('passed','failed','warning') NOT NULL,
  `check_details` text DEFAULT NULL,
  `checked_at` datetime NOT NULL DEFAULT current_timestamp(),
  `checked_by` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_rules`
--

CREATE TABLE `compliance_rules` (
  `id` int(30) NOT NULL,
  `rule_type` varchar(50) NOT NULL,
  `rule_name` varchar(255) NOT NULL,
  `rule_description` text DEFAULT NULL,
  `rule_value` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compliance_rules`
--

INSERT INTO `compliance_rules` (`id`, `rule_type`, `rule_name`, `rule_description`, `rule_value`, `is_active`, `created_by`, `date_created`, `date_updated`) VALUES
(1, 'perishable_time', 'Perishable Goods Storage Limit', 'Maximum storage time for perishable goods in warehouse', '{\"max_hours\": 48, \"alert_hours\": 36}', 1, 1, '2025-09-09 22:27:51', NULL),
(2, 'hazardous_approval', 'Hazardous Materials Approval', 'Requires safety documentation and approval for hazardous materials', '{\"required_docs\": [\"msds\", \"safety_cert\"], \"approval_required\": true}', 1, 1, '2025-09-09 22:27:51', NULL),
(3, 'weight_limit', 'Standard Weight Restrictions', 'Maximum weight limits per shipment', '{\"max_weight_kg\": 1000, \"warning_weight_kg\": 800}', 1, 1, '2025-09-09 22:27:51', NULL),
(4, 'size_limit', 'Standard Size Restrictions', 'Maximum dimensions for cargo', '{\"max_length_cm\": 300, \"max_width_cm\": 200, \"max_height_cm\": 150}', 1, 1, '2025-09-09 22:27:51', NULL),
(5, 'perishable_time', 'Perishable Goods Storage Limit', 'Maximum storage time for perishable goods in warehouse', '{\"max_hours\": 48, \"alert_hours\": 36}', 1, 1, '2025-09-09 22:31:27', NULL),
(6, 'hazardous_approval', 'Hazardous Materials Approval', 'Requires safety documentation and approval for hazardous materials', '{\"required_docs\": [\"msds\", \"safety_cert\"], \"approval_required\": true}', 1, 1, '2025-09-09 22:31:27', NULL),
(7, 'weight_limit', 'Standard Weight Restrictions', 'Maximum weight limits per shipment', '{\"max_weight_kg\": 1000, \"warning_weight_kg\": 800}', 1, 1, '2025-09-09 22:31:27', NULL),
(8, 'size_limit', 'Standard Size Restrictions', 'Maximum dimensions for cargo', '{\"max_length_cm\": 300, \"max_width_cm\": 200, \"max_height_cm\": 150}', 1, 1, '2025-09-09 22:31:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compliance_violations`
--

CREATE TABLE `compliance_violations` (
  `id` int(30) NOT NULL,
  `cargo_id` int(30) NOT NULL,
  `rule_id` int(30) NOT NULL,
  `violation_type` varchar(50) NOT NULL,
  `violation_message` text NOT NULL,
  `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `status` enum('open','acknowledged','resolved','ignored') NOT NULL DEFAULT 'open',
  `resolved_by` int(30) DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `resolution_notes` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hazardous_approvals`
--

CREATE TABLE `hazardous_approvals` (
  `id` int(30) NOT NULL,
  `cargo_id` int(30) NOT NULL,
  `approval_type` varchar(50) NOT NULL,
  `document_path` varchar(500) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` int(30) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approval_notes` text DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regulatory_limits`
--

CREATE TABLE `regulatory_limits` (
  `id` int(30) NOT NULL DEFAULT 0,
  `airline_code` varchar(10) DEFAULT NULL,
  `country_code` varchar(3) DEFAULT NULL,
  `cargo_type_id` int(30) DEFAULT NULL,
  `max_weight_kg` decimal(10,2) DEFAULT NULL,
  `max_length_cm` int(11) DEFAULT NULL,
  `max_width_cm` int(11) DEFAULT NULL,
  `max_height_cm` int(11) DEFAULT NULL,
  `max_volume_cm3` bigint(20) DEFAULT NULL,
  `special_requirements` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regulatory_limits`
--

INSERT INTO `regulatory_limits` (`id`, `airline_code`, `country_code`, `cargo_type_id`, `max_weight_kg`, `max_length_cm`, `max_width_cm`, `max_height_cm`, `max_volume_cm3`, `special_requirements`, `is_active`, `date_created`, `date_updated`) VALUES
(1, 'AA', 'US', NULL, 500.00, 300, 200, 150, NULL, 'Requires TSA approval for electronics', 1, '2025-09-09 22:34:35', '2025-09-09 22:36:19'),
(2, 'BA', 'GB', NULL, 750.00, 350, 250, 180, NULL, 'Hazardous materials require DG approval', 1, '2025-09-09 22:37:11', NULL),
(3, 'LH', 'DE', NULL, 600.00, 320, 220, 160, NULL, 'Perishables require temperature control', 1, '2025-09-09 22:37:11', NULL),
(4, NULL, 'US', 1, 200.00, 150, 100, 100, NULL, 'Electronics weight limit for US shipments', 1, '2025-09-09 22:37:11', NULL),
(5, NULL, 'GB', 2, 300.00, 200, 150, 120, NULL, 'Food items require health certificates', 1, '2025-09-09 22:37:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `storage_units`
--

CREATE TABLE `storage_units` (
  `id` int(30) NOT NULL,
  `warehouse_id` int(30) NOT NULL,
  `zone` varchar(128) NOT NULL,
  `unit_code` varchar(128) NOT NULL,
  `capacity_weight` double NOT NULL DEFAULT 0,
  `length_cm` int(11) NOT NULL DEFAULT 0,
  `width_cm` int(11) NOT NULL DEFAULT 0,
  `height_cm` int(11) NOT NULL DEFAULT 0,
  `type_allowed` varchar(64) NOT NULL DEFAULT 'general',
  `is_refrigerated` tinyint(1) NOT NULL DEFAULT 0,
  `is_hazardous_zone` tinyint(1) NOT NULL DEFAULT 0,
  `near_exit` tinyint(1) NOT NULL DEFAULT 0,
  `occupied_weight` double NOT NULL DEFAULT 0,
  `is_occupied` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage_units`
--

INSERT INTO `storage_units` (`id`, `warehouse_id`, `zone`, `unit_code`, `capacity_weight`, `length_cm`, `width_cm`, `height_cm`, `type_allowed`, `is_refrigerated`, `is_hazardous_zone`, `near_exit`, `occupied_weight`, `is_occupied`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 'Refrigerated', 'RACK-A1', 500, 0, 0, 0, 'perishable', 1, 0, 1, 450, 1, 1, '2025-09-07 22:27:20', '2025-09-11 20:51:19'),
(2, 1, 'Hazardous', 'HZ-01', 800, 0, 0, 0, 'hazardous', 0, 1, 0, 0, 0, 1, '2025-09-07 22:27:20', NULL),
(3, 1, 'General', 'G-101', 1000, 0, 0, 0, 'any', 0, 0, 1, 750, 1, 1, '2025-09-07 22:27:20', '2025-09-08 23:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'CargoSwift System'),
(6, 'short_name', 'CargoSwift'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking_list`
--

INSERT INTO `tracking_list` (`id`, `cargo_id`, `title`, `description`, `date_added`) VALUES
(1, 1, 'Pending', ' Shipment created.', '2022-02-22 14:39:09'),
(2, 1, 'In-Transit', 'Cargo has been departed.', '2022-02-22 14:42:18'),
(3, 1, 'Arrive at Station', 'Cargo has arrived at the station', '2022-02-22 14:54:43'),
(5, 1, 'Out for Delivery', 'Out for Delivery now', '2025-09-04 00:23:54'),
(6, 3, 'Pending', ' Shipment created.', '2025-09-04 01:11:52'),
(7, 1, 'Pending', ' Shipment created.', '2025-09-04 01:14:01'),
(8, 3, 'In-Transit', 'Test email', '2025-09-04 01:24:11'),
(9, 3, 'In-Transit', 'Test email', '2025-09-04 01:25:57'),
(10, 3, 'Arrive at Station', 'test email', '2025-09-04 01:44:15'),
(11, 3, 'Out for Delivery', 'test email', '2025-09-04 01:47:19'),
(12, 3, 'Delivered', 'ddfgdfgfgfdg', '2025-09-04 01:53:55'),
(13, 1, 'Pending', ' Shipment created.', '2025-09-07 00:10:06'),
(14, 1, 'Delivered', 'Item delivered', '2025-09-07 00:10:21'),
(15, 1, 'Pending', ' Shipment created.', '2025-09-07 00:11:40'),
(16, 1, 'Delivered', 'item deliverd again', '2025-09-07 00:11:52'),
(17, 4, 'Pending', ' Shipment created.', '2025-09-07 23:02:25'),
(18, 4, 'Delivered', 'Delivered to the customer', '2025-09-08 21:07:03'),
(19, 5, 'Pending', ' Shipment created.', '2025-09-08 22:21:10'),
(20, 5, 'In-Transit', 'Items in transit', '2025-09-08 22:25:32'),
(21, 5, 'Arrive at Station', 'Test', '2025-09-08 22:26:03'),
(22, 6, 'Pending', ' Shipment created.', '2025-09-08 23:30:42'),
(23, 7, 'Pending', ' Shipment created.', '2025-09-10 21:22:46'),
(24, 8, 'Pending', ' Shipment created.', '2025-09-11 20:51:19'),
(25, 8, 'In-Transit', 'Test status', '2025-09-11 20:53:13');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2021-01-20 14:02:37', '2022-02-17 10:21:45'),
(5, 'John', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', 'uploads/avatars/5.png?v=1645514943', NULL, 2, '2022-02-22 15:29:03', '2022-02-22 15:34:01'),
(7, 'Gayan', 'Muthukumara', 'GayanMuthu', '764129ddfaf0b8409851db60fc9746ab', NULL, NULL, 2, '2025-09-07 23:21:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(30) NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `code`, `description`, `date_created`, `date_updated`) VALUES
(1, 'Main Warehouse', 'MAIN', 'Primary airport warehouse', '2025-09-07 22:27:20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo_allocation`
--
ALTER TABLE `cargo_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_allocation_cargo` (`cargo_id`,`status`),
  ADD KEY `idx_allocation_unit` (`storage_unit_id`,`status`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cargo_compliance` (`compliance_status`,`is_hazardous`,`is_perishable`),
  ADD KEY `idx_cargo_storage_time` (`storage_start_time`,`max_storage_hours`);

--
-- Indexes for table `cargo_meta`
--
ALTER TABLE `cargo_meta`
  ADD KEY `cargo_id` (`cargo_id`),
  ADD KEY `idx_cargo_meta_field` (`cargo_id`,`meta_field`(50));

--
-- Indexes for table `cargo_type_list`
--
ALTER TABLE `cargo_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compliance_checks`
--
ALTER TABLE `compliance_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cargo_checks` (`cargo_id`,`check_type`),
  ADD KEY `fk_checks_checker` (`checked_by`);

--
-- Indexes for table `compliance_rules`
--
ALTER TABLE `compliance_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rule_type` (`rule_type`,`is_active`),
  ADD KEY `fk_compliance_rules_creator` (`created_by`);

--
-- Indexes for table `compliance_violations`
--
ALTER TABLE `compliance_violations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cargo_violations` (`cargo_id`,`status`),
  ADD KEY `idx_violation_type` (`violation_type`,`status`),
  ADD KEY `fk_violations_rule` (`rule_id`),
  ADD KEY `fk_violations_resolver` (`resolved_by`),
  ADD KEY `idx_violations_severity` (`severity`,`status`,`date_created`);

--
-- Indexes for table `hazardous_approvals`
--
ALTER TABLE `hazardous_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cargo_approvals` (`cargo_id`,`approval_status`),
  ADD KEY `fk_approvals_approver` (`approved_by`);

--
-- Indexes for table `regulatory_limits`
--
ALTER TABLE `regulatory_limits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_airline_country` (`airline_code`,`country_code`),
  ADD KEY `idx_cargo_type` (`cargo_type_id`);

--
-- Indexes for table `storage_units`
--
ALTER TABLE `storage_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_storage_unit_code` (`warehouse_id`,`unit_code`),
  ADD KEY `idx_storage_units_wh_status` (`warehouse_id`,`status`);

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
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_warehouses_code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo_allocation`
--
ALTER TABLE `cargo_allocation`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cargo_list`
--
ALTER TABLE `cargo_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cargo_type_list`
--
ALTER TABLE `cargo_type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `compliance_checks`
--
ALTER TABLE `compliance_checks`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_rules`
--
ALTER TABLE `compliance_rules`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `compliance_violations`
--
ALTER TABLE `compliance_violations`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hazardous_approvals`
--
ALTER TABLE `hazardous_approvals`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storage_units`
--
ALTER TABLE `storage_units`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tracking_list`
--
ALTER TABLE `tracking_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargo_allocation`
--
ALTER TABLE `cargo_allocation`
  ADD CONSTRAINT `fk_allocation_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_allocation_unit` FOREIGN KEY (`storage_unit_id`) REFERENCES `storage_units` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `compliance_checks`
--
ALTER TABLE `compliance_checks`
  ADD CONSTRAINT `fk_checks_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_checks_checker` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `compliance_rules`
--
ALTER TABLE `compliance_rules`
  ADD CONSTRAINT `fk_compliance_rules_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compliance_violations`
--
ALTER TABLE `compliance_violations`
  ADD CONSTRAINT `fk_violations_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_violations_resolver` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_violations_rule` FOREIGN KEY (`rule_id`) REFERENCES `compliance_rules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hazardous_approvals`
--
ALTER TABLE `hazardous_approvals`
  ADD CONSTRAINT `fk_approvals_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_approvals_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `regulatory_limits`
--
ALTER TABLE `regulatory_limits`
  ADD CONSTRAINT `fk_regulatory_cargo_type` FOREIGN KEY (`cargo_type_id`) REFERENCES `cargo_type_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `storage_units`
--
ALTER TABLE `storage_units`
  ADD CONSTRAINT `fk_storage_units_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracking_list`
--
ALTER TABLE `tracking_list`
  ADD CONSTRAINT `cargo_id_FK2` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
