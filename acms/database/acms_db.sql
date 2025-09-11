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

-- Warehouse smart placement flags on cargo types
ALTER TABLE `cargo_type_list`
  ADD COLUMN `is_perishable` tinyint(1) NOT NULL DEFAULT 0 AFTER `country_price`,
  ADD COLUMN `is_hazardous` tinyint(1) NOT NULL DEFAULT 0 AFTER `is_perishable`;

-- ---------------------------------------------
-- Dynamic Storage / Warehouse Management Tables
-- ---------------------------------------------

-- Warehouses master
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `code` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_warehouses_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Storage units/slots within a warehouse
CREATE TABLE IF NOT EXISTS `storage_units` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(30) NOT NULL,
  `zone` varchar(128) NOT NULL,
  `unit_code` varchar(128) NOT NULL,
  `capacity_weight` double NOT NULL DEFAULT 0, -- kg
  `length_cm` int(11) NOT NULL DEFAULT 0,
  `width_cm` int(11) NOT NULL DEFAULT 0,
  `height_cm` int(11) NOT NULL DEFAULT 0,
  `type_allowed` varchar(64) NOT NULL DEFAULT 'general', -- general|perishable|hazardous|any
  `is_refrigerated` tinyint(1) NOT NULL DEFAULT 0,
  `is_hazardous_zone` tinyint(1) NOT NULL DEFAULT 0,
  `near_exit` tinyint(1) NOT NULL DEFAULT 0,
  `occupied_weight` double NOT NULL DEFAULT 0, -- kg used
  `is_occupied` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1, -- 1=active,0=inactive
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_storage_unit_code` (`warehouse_id`,`unit_code`),
  KEY `idx_storage_units_wh_status` (`warehouse_id`,`status`),
  CONSTRAINT `fk_storage_units_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cargo allocation mapping
CREATE TABLE IF NOT EXISTS `cargo_allocation` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `cargo_id` int(30) NOT NULL,
  `storage_unit_id` int(30) NOT NULL,
  `allocated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `released_at` datetime DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'allocated', -- allocated|released
  PRIMARY KEY (`id`),
  KEY `idx_allocation_cargo` (`cargo_id`,`status`),
  KEY `idx_allocation_unit` (`storage_unit_id`,`status`),
  CONSTRAINT `fk_allocation_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_allocation_unit` FOREIGN KEY (`storage_unit_id`) REFERENCES `storage_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Helpful index for cargo_meta lookups
ALTER TABLE `cargo_meta` ADD INDEX `idx_cargo_meta_field` (`cargo_id`, `meta_field`(50));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Compliance & Validation System Schema
-- Add to existing acms_db.sql

-- Compliance rules configuration
CREATE TABLE IF NOT EXISTS `compliance_rules` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `rule_type` varchar(50) NOT NULL, -- 'perishable_time', 'hazardous_approval', 'weight_limit', 'size_limit'
  `rule_name` varchar(255) NOT NULL,
  `rule_description` text,
  `rule_value` text NOT NULL, -- JSON config for rule parameters
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_rule_type` (`rule_type`, `is_active`),
  CONSTRAINT `fk_compliance_rules_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Compliance violations and alerts
CREATE TABLE IF NOT EXISTS `compliance_violations` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `cargo_id` int(30) NOT NULL,
  `rule_id` int(30) NOT NULL,
  `violation_type` varchar(50) NOT NULL,
  `violation_message` text NOT NULL,
  `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `status` enum('open','acknowledged','resolved','ignored') NOT NULL DEFAULT 'open',
  `resolved_by` int(30) DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `resolution_notes` text,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cargo_violations` (`cargo_id`, `status`),
  KEY `idx_violation_type` (`violation_type`, `status`),
  CONSTRAINT `fk_violations_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_violations_rule` FOREIGN KEY (`rule_id`) REFERENCES `compliance_rules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_violations_resolver` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Hazardous materials approval workflow
CREATE TABLE IF NOT EXISTS `hazardous_approvals` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `cargo_id` int(30) NOT NULL,
  `approval_type` varchar(50) NOT NULL, -- 'msds', 'safety_cert', 'customs_clearance'
  `document_path` varchar(500) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` int(30) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approval_notes` text,
  `expires_at` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cargo_approvals` (`cargo_id`, `approval_status`),
  CONSTRAINT `fk_approvals_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_approvals_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Airline/country specific regulations
CREATE TABLE IF NOT EXISTS `regulatory_limits` (
  `id` int(30) NOT NULL DEFAULT 0,
  `airline_code` varchar(10) DEFAULT NULL,
  `country_code` varchar(3) DEFAULT NULL,
  `cargo_type_id` int(30) DEFAULT NULL,
  `max_weight_kg` decimal(10,2) DEFAULT NULL,
  `max_length_cm` int(11) DEFAULT NULL,
  `max_width_cm` int(11) DEFAULT NULL,
  `max_height_cm` int(11) DEFAULT NULL,
  `max_volume_cm3` bigint(20) DEFAULT NULL,
  `special_requirements` text,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_airline_country` (`airline_code`, `country_code`),
  KEY `idx_cargo_type` (`cargo_type_id`),
  CONSTRAINT `fk_regulatory_cargo_type` FOREIGN KEY (`cargo_type_id`) REFERENCES `cargo_type_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Compliance check history
CREATE TABLE IF NOT EXISTS `compliance_checks` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `cargo_id` int(30) NOT NULL,
  `check_type` varchar(50) NOT NULL,
  `check_status` enum('passed','failed','warning') NOT NULL,
  `check_details` text,
  `checked_at` datetime NOT NULL DEFAULT current_timestamp(),
  `checked_by` int(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_cargo_checks` (`cargo_id`, `check_type`),
  CONSTRAINT `fk_checks_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_checks_checker` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add compliance fields to existing cargo_list table
ALTER TABLE `cargo_list` 
ADD COLUMN `compliance_status` enum('pending','compliant','non_compliant','requires_approval') NOT NULL DEFAULT 'pending' AFTER `status`,
ADD COLUMN `is_hazardous` tinyint(1) NOT NULL DEFAULT 0 AFTER `compliance_status`,
ADD COLUMN `is_perishable` tinyint(1) NOT NULL DEFAULT 0 AFTER `is_hazardous`,
ADD COLUMN `storage_start_time` datetime DEFAULT NULL AFTER `is_perishable`,
ADD COLUMN `max_storage_hours` int(11) DEFAULT NULL AFTER `storage_start_time`,
ADD COLUMN `weight_kg` decimal(10,2) DEFAULT NULL AFTER `max_storage_hours`,
ADD COLUMN `length_cm` int(11) DEFAULT NULL AFTER `weight_kg`,
ADD COLUMN `width_cm` int(11) DEFAULT NULL AFTER `length_cm`,
ADD COLUMN `height_cm` int(11) DEFAULT NULL AFTER `width_cm`,
ADD COLUMN `special_handling_required` tinyint(1) NOT NULL DEFAULT 0 AFTER `height_cm`;

-- Add compliance fields to cargo_meta for additional data
-- (using existing cargo_meta table structure)

-- Insert default compliance rules
INSERT INTO `compliance_rules` (`rule_type`, `rule_name`, `rule_description`, `rule_value`, `created_by`) VALUES
('perishable_time', 'Perishable Goods Storage Limit', 'Maximum storage time for perishable goods in warehouse', '{"max_hours": 48, "alert_hours": 36}', 1),
('hazardous_approval', 'Hazardous Materials Approval', 'Requires safety documentation and approval for hazardous materials', '{"required_docs": ["msds", "safety_cert"], "approval_required": true}', 1),
('weight_limit', 'Standard Weight Restrictions', 'Maximum weight limits per shipment', '{"max_weight_kg": 1000, "warning_weight_kg": 800}', 1),
('size_limit', 'Standard Size Restrictions', 'Maximum dimensions for cargo', '{"max_length_cm": 300, "max_width_cm": 200, "max_height_cm": 150}', 1);

-- Insert sample regulatory limits
INSERT INTO `regulatory_limits` (`airline_code`, `country_code`, `cargo_type_id`, `max_weight_kg`, `max_length_cm`, `max_width_cm`, `max_height_cm`, `special_requirements`) VALUES
('AA', 'US', NULL, 500.00, 300, 200, 150, 'Requires TSA approval for electronics'),
('BA', 'GB', NULL, 750.00, 350, 250, 180, 'Hazardous materials require DG approval'),
('LH', 'DE', NULL, 600.00, 320, 220, 160, 'Perishables require temperature control'),
(NULL, 'US', 1, 200.00, 150, 100, 100, 'Electronics weight limit for US shipments'),
(NULL, 'GB', 2, 300.00, 200, 150, 120, 'Food items require health certificates');

-- Update existing cargo types to mark hazardous/perishable
UPDATE `cargo_type_list` SET 
  `is_perishable` = 1 
WHERE `name` IN ('Dry Foods', 'Fragile') AND `delete_flag` = '0';

UPDATE `cargo_type_list` SET 
  `is_hazardous` = 1 
WHERE `name` LIKE '%chemical%' OR `name` LIKE '%battery%' OR `name` LIKE '%explosive%';

-- Create indexes for performance
CREATE INDEX `idx_cargo_compliance` ON `cargo_list` (`compliance_status`, `is_hazardous`, `is_perishable`);
CREATE INDEX `idx_cargo_storage_time` ON `cargo_list` (`storage_start_time`, `max_storage_hours`);
CREATE INDEX `idx_violations_severity` ON `compliance_violations` (`severity`, `status`, `date_created`);

