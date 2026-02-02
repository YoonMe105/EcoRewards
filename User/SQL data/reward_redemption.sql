-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 11:50 PM
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
-- Database: `ecoreward`
--

-- --------------------------------------------------------

--
-- Table structure for table `reward_redemption`
--

CREATE TABLE `reward_redemption` (
  `id` int(11) NOT NULL,
  `rewards_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `redemption_date` datetime NOT NULL,
  `status` enum('used','expired','unused') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward_redemption`
--

INSERT INTO `reward_redemption` (`id`, `rewards_id`, `users_id`, `redemption_date`, `status`) VALUES
(1, 1, 1, '2025-12-06 10:30:00', 'used'),
(2, 2, 2, '2025-12-10 14:20:00', 'used'),
(3, 1, 3, '2025-12-20 09:15:00', 'unused'),
(4, 1, 5, '2025-12-25 18:45:00', 'used'),
(5, 1, 2, '2026-01-20 22:48:37', 'unused'),
(6, 1, 2, '2026-01-20 22:48:41', 'unused'),
(16, 1, 2, '2026-01-20 22:48:45', 'unused'),
(17, 1, 2, '2026-01-20 22:48:45', 'unused'),
(18, 1, 2, '2026-01-20 22:48:45', 'used'),
(19, 1, 2, '2026-01-20 22:48:46', 'used'),
(20, 1, 2, '2026-01-20 22:48:46', 'used'),
(21, 1, 2, '2026-01-20 22:48:49', 'used'),
(22, 1, 2, '2026-01-20 22:48:51', 'used'),
(23, 1, 2, '2026-01-20 22:48:51', 'used'),
(24, 1, 2, '2026-01-20 22:48:51', 'used'),
(25, 1, 2, '2026-01-20 22:48:51', 'used'),
(26, 1, 2, '2026-01-20 22:49:11', 'used'),
(27, 1, 2, '2026-01-20 22:49:12', 'used'),
(28, 1, 2, '2026-01-20 22:49:13', 'used'),
(29, 1, 2, '2026-01-20 22:54:58', 'used');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reward_redemption`
--
ALTER TABLE `reward_redemption`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reward_redemption`
--
ALTER TABLE `reward_redemption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
