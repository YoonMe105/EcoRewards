-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2026 at 05:18 PM
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
-- Database: `ecorewards`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `profile_image` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `profile_image`, `password`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 'Jame', 'img/profile.png', 'jue', 'jame@gmail.com', '01145788', 'active', '2025-12-19'),
(2, 'Kirei', './profile.png', '21', 'kirei@gmail.com', '011f44', 'active', '2025-12-19');

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
(1, 'Eco Quiz Day', 'Answer 5 eco-friendly questions to earn points', 'img/Eco Quiz Day.png', '2026-01-01 00:00:00', '0000-00-00 00:00:00', 25, 1, 1, 1, 'active', '2026-01-17 21:25:12'),
(2, 'Campus Recycle Day', 'Recycle items around campus and earn double points', 'img/Campus Recycle Day.png', '2026-02-10 00:00:00', '2026-02-12 18:00:00', 50, 1, 1, 1, 'upcoming', '2026-01-17 21:25:12'),
(3, 'Tree Planting Program', 'Join tree planting activity to protect the environment', 'img/Tree Planting Program.png', '2025-11-15 08:00:00', '2025-11-15 12:00:00', 30, 1, 1, 1, 'ended', '2026-01-17 21:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `event_logs`
--

CREATE TABLE `event_logs` (
  `id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `status` enum('joined','completed','cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_logs`
--

INSERT INTO `event_logs` (`id`, `events_id`, `users_id`, `status`) VALUES
(1, 1, 1, 'joined'),
(2, 3, 1, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_image` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `contact_person` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `address` varchar(250) NOT NULL,
  `created_at` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `company_image`, `email`, `password`, `contact_person`, `phone`, `address`, `created_at`) VALUES
(1, 'Subway', 'subway.png', 'subway@example.com', '$2y$10$jTepxF7nd94pU7E5ReBfxe77vq4KWUY9lMOQWCm8dd6OjLykP7Nwy', 'John Doe', '0123456789', 'APU', 'current_timestamp()'),
(2, 'Aicha', 'aicha.png', 'adminmy@aichafood.com', '$2y$10$.5nHyRhmSJHAgpoOspFvd.0SZ3hNtNz8pQEIwdPpEkoitM9bDtB6q', 'Sara Lee', '0987654321', 'APU', '2025-12-21'),
(3, 'BilaBila', 'bilabila.png', 'bilabila@gmail.com', '$2y$10$jTepxF7nd94pU7E5ReBfxe77vq4KWUY9lMOQWCm8dd6OjLykP7Nwy', 'Emily Tan', '01125665430', 'APU', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `point_rules`
--

CREATE TABLE `point_rules` (
  `id` int(11) NOT NULL,
  `material_type` varchar(20) NOT NULL,
  `unit` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` varchar(30) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `partners_id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `description` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `points_required` int(11) NOT NULL,
  `expired_at` varchar(30) NOT NULL,
  `status` enum('available','outofstock','expired') NOT NULL DEFAULT 'available',
  `created_at` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `partners_id`, `name`, `description`, `quantity`, `points_required`, `expired_at`, `status`, `created_at`) VALUES
(1, 2, 'Discount Voucher on ', '10% discount on cold drinks on aicha', 30, 20, '2026-03-05', 'available', '2025-12-05'),
(2, 1, 'Subway 50% discount ', '50% discount of Subway on second drinks', 3, 70, '2025-12-25', 'expired', '2025-12-02'),
(3, 1, '30% discount', '30% discount of all food and beverages', 2, 80, '2026-01-24T12:00', 'available', '2026-01-23 12:55:09');

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
(1, 2, 1, '2026-12-19 15:35:30', 'used'),
(2, 2, 1, '2026-12-19 18:35:30', 'used'),
(3, 2, 1, '2026-12-19 16:37:46', 'used');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_image` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `role` enum('student','staff') NOT NULL,
  `user_points` int(11) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `password`, `profile_image`, `email`, `phone`, `role`, `user_points`, `created_at`) VALUES
(1, 'Lorente', '$2y$10$hU6pZioLS35.OAa0OelnQ.p4HqLjveZP69inp4g7VckZNbKiAEWL.', 'student_boy.png', 'lorente@gmail.com', '012-3456234', 'student', 1649, '2025-11-10 16:00:00'),
(2, 'Bowley', '$2y$10$TVeUG8UsnImnu4Dp3nDLG.wyo/eYuxMA7fbdkesIaum92ny67wpS6', 'student_boy.png', 'bowley@gmail.com', '821-566-7372', 'student', 515, '6/28/2025'),
(3, 'Jane', '$2y$10$CYPtgzy2zUwsoGaNnIeuDO4XHdfH4DKBluRIB3shtn0Fd95QG4VBC', 'staff_girl.png', 'jane@gmail.com', '235-408-2442', 'staff', 959, '11/29/2025'),
(4, 'Byran', '$2y$10$iIlgdxEyq1yy.q0XyAhB..gpHFqXaRRGHvo67UCJ40UHlkQXBx5Ty', 'staff_boy.png', 'byran@gmail.com', '585-383-4578', 'staff', 0, '5/3/2025'),
(5, 'Lara', '$2y$10$BBfHuRFe.hB3mtz/5iAa5uuka59QA2JUHlk3zBBL5VcjewiLWLUCW', 'student_girl.png', 'lara@gmail.com', '923-773-6721', 'student', 192, '9/27/2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eco_actions`
--
ALTER TABLE `eco_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_logs`
--
ALTER TABLE `event_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_rules`
--
ALTER TABLE `point_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_redemption`
--
ALTER TABLE `reward_redemption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eco_actions`
--
ALTER TABLE `eco_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_logs`
--
ALTER TABLE `event_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `point_rules`
--
ALTER TABLE `point_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reward_redemption`
--
ALTER TABLE `reward_redemption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
