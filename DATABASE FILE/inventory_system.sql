-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2024 at 08:16 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

CREATE TABLE `expenditures` (
  `id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issuances`
--

CREATE TABLE `issuances` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `issued_to` varchar(255) NOT NULL,
  `date_issued` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issuances`
--

INSERT INTO `issuances` (`id`, `item_id`, `quantity`, `issued_to`, `date_issued`) VALUES
(1, 4, 12, 'ICT', '2024-08-08 11:39:00'),
(4, 4, 5, 'Brian', '0000-00-00 00:00:00'),
(5, 4, 12, 'Ann', '2024-08-08 12:59:00'),
(6, 4, 5, 'Brian', '0000-00-00 00:00:00'),
(7, 4, 20, 'Ann', '2024-08-08 13:15:53'),
(8, 4, 12, 'Ann', '2024-08-08 13:16:21'),
(10, 7, 12, 'Sim', '2024-08-13 11:14:58'),
(11, 7, 23, 'Ann', '2024-08-13 14:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `issued_to` varchar(255) NOT NULL,
  `date_issued` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `min_stock_level` int(11) DEFAULT NULL,
  `supplier_contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `receipt_number`, `quantity`, `price`, `cost`, `supplier`, `date_added`, `min_stock_level`, `supplier_contact`) VALUES
(4, 'Stapple pins', '34ndq2023', 75, 25.00, 1875.00, 'Kevin\'s', '2024-08-13 00:00:00', 25, '793847607'),
(7, 'Books', 'WER23433', 165, 100.00, 20000.00, 'Calvins Klein', '2024-08-13 11:07:00', 20, '79384'),
(8, 'Desktop Computers', 'WER23433', 234, 200.00, 46800.00, 'Calvins Klein', '2024-08-13 14:17:00', 10, '793847607');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_records`
--

CREATE TABLE `maintenance_records` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `actual_date` date NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_records`
--

INSERT INTO `maintenance_records` (`id`, `schedule_id`, `actual_date`, `notes`, `created_at`) VALUES
(1, 1, '2024-08-09', 'daf', '2024-08-09 09:27:48'),
(2, 1, '2024-08-09', 'Date submitted', '2024-08-09 09:28:01'),
(3, 1, '2024-08-09', 'Dates maintained ', '2024-08-09 09:40:22'),
(4, 1, '2024-08-11', 'dfff', '2024-08-11 12:32:26'),
(5, 1, '2024-08-13', 'Maintained', '2024-08-13 09:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_schedule`
--

CREATE TABLE `maintenance_schedule` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `scheduled_date` datetime NOT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_schedules`
--

CREATE TABLE `maintenance_schedules` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_schedules`
--

INSERT INTO `maintenance_schedules` (`id`, `item_id`, `scheduled_date`, `details`, `created_at`) VALUES
(1, 6, '2024-08-13', 'Returned for Maintenance', '2024-08-13 09:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expiry`) VALUES
(1, 'mpuyuksamwel@gmail.com', '209d4c4ca0127b628a8a21258fa4ce2e81240101908e84379c243e4899804f492f709473e27a1b349ad0632761605ec8bed7', '2024-08-13 13:15:23'),
(2, 'mpuyuksamwel@gmail.com', '11d24002e48388687e426b29dbe3bcd58adb2732cab329b8f3ffc4264de0892857ff127951635e90185eb813b3bb43a76462', '2024-08-13 15:23:16'),
(3, 'mpuyuksamwel@gmail.com', 'f7bbf324bb93468b843e81f4a06f45a0a4720902b1986d35aebaecad0b9026fd3a767bcc92bc90a77a511b4b4d85bebc5797', '2024-08-13 15:23:18'),
(4, 'mamwel@gmail.com', 'a20a7fd9af625f43703c057122036e057c9e333b59ca9c5433fedc753647f519420aff130f3e4b786dd49499db8039145102', '2024-08-13 15:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `return`
--

CREATE TABLE `return` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `returned_by` varchar(255) NOT NULL,
  `return_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `returned_by` varchar(255) NOT NULL,
  `return_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `item_id`, `quantity`, `returned_by`, `return_date`) VALUES
(1, 4, 2, 'Sim', '2024-08-13 11:18:15'),
(2, 7, 2, 'Brian', '2024-08-13 14:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Sams', 'Sams', 'samuel.musyoka@outlook.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2024-08-13 15:02:28'),
(5, 'Kevin', 'kevin', '', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, '2021-04-04 19:54:29'),
(6, 'Bevan', 'Bevan', '', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'oly62ce6.jpg', 1, '2024-08-13 14:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1),
(3, 'User', 3, 1),
(4, 'ICT Team', 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenditures`
--
ALTER TABLE `expenditures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issuances`
--
ALTER TABLE `issuances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email_token` (`email`,`token`);

--
-- Indexes for table `return`
--
ALTER TABLE `return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenditures`
--
ALTER TABLE `expenditures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issuances`
--
ALTER TABLE `issuances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `return`
--
ALTER TABLE `return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issuances`
--
ALTER TABLE `issuances`
  ADD CONSTRAINT `issuances_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD CONSTRAINT `maintenance_records_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `maintenance_schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD CONSTRAINT `maintenance_schedule_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `return`
--
ALTER TABLE `return`
  ADD CONSTRAINT `return_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
