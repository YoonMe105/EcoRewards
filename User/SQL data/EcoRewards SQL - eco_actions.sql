-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 09:24 PM
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
-- Table structure for table `eco_actions`
--

CREATE TABLE `eco_actions` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `material_type` varchar(20) NOT NULL,
  `image` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL,
  `status` enum('archived','cancelled') NOT NULL DEFAULT 'archived',
  `created_at` varchar(30) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eco_actions`
--

INSERT INTO `eco_actions` (`id`, `users_id`, `material_type`, `image`, `quantity`, `points_earned`, `status`, `created_at`) VALUES
(10, 1, 'Plastic Bottle', 'plastic_bottle_1.jpg', 12, 60, 'archived', '2025-03-20 10:15:00'),
(11, 1, 'Paper', 'paper_recycle_1.jpg', 8, 40, 'archived', '2025-03-22 14:40:00'),
(12, 2, 'Aluminum Can', 'aluminum_can_1.jpg', 15, 75, 'archived', '2025-06-30 09:25:00'),
(13, 2, 'Glass', 'glass_recycle_1.jpg', 6, 30, 'archived', '2025-07-02 16:10:00'),
(14, 3, 'Paper', 'paper_recycle_2.jpg', 20, 100, 'archived', '2025-11-30 11:00:00'),
(15, 3, 'Plastic Bottle', 'plastic_bottle_2.jpg', 10, 50, 'archived', '2025-12-02 15:30:00'),
(16, 4, 'Glass', 'glass_recycle_2.jpg', 5, 0, 'cancelled', '2025-05-05 13:20:00'),
(17, 5, 'Aluminum Can', 'aluminum_can_2.jpg', 18, 90, 'archived', '2025-09-29 10:45:00'),
(18, 5, 'Paper', 'paper_recycle_3.jpg', 7, 35, 'archived', '2025-10-01 17:10:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eco_actions`
--
ALTER TABLE `eco_actions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eco_actions`
--
ALTER TABLE `eco_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
