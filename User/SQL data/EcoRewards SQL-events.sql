-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 09:23 PM
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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `image` varchar(250) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `points_reward` int(11) NOT NULL,
  `admins_id` int(11) NOT NULL,
  `partners_id` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `status` enum('active','pending','upcoming','ended') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `image`, `start_date`, `end_date`, `points_reward`, `admins_id`, `partners_id`, `approved_by`, `status`, `created_at`) VALUES
(1, 'Eco Quiz Day', 'Answer 5 eco-friendly questions to earn points', 'eco_quiz.jpg', '2026-01-01 00:00:00', '2026-01-31 23:59:59', 25, 1, 1, 1, 'active', '2026-01-17 21:25:12'),
(2, 'Campus Recycle Day', 'Recycle items around campus and earn double points', 'recycle_day.jpg', '2026-02-10 08:00:00', '2026-02-12 18:00:00', 50, 1, 1, 1, 'upcoming', '2026-01-17 21:25:12'),
(3, 'Tree Planting Program', 'Join tree planting activity to protect the environment', 'tree_plant.jpg', '2025-11-15 08:00:00', '2025-11-15 12:00:00', 30, 1, 1, 1, 'ended', '2026-01-17 21:25:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
