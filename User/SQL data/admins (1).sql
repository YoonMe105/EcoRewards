-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 01:49 PM
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
  `password` varchar(100) NOT NULL DEFAULT 'admins',
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `profile_image`, `password`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 'Jame1', 'img/profile.png', 'd71f30a340bf5207f02bad96401a1275', 'jame1@gmail.com', '011457881', 'inactive', '2025-12-19'),
(2, 'Kirei', './assets/img/admin.jpg', '$2y$10$ymblMKvFZpGm2MBCY4HYWusEj.rQpprvvsDjm8W8yy.CutOPycQV6', 'kirei@gmail.com', '011f44', 'active', '2025-12-19'),
(3, 'test', '', '$2y$10$ymblMKvFZpGm2MBCY4HYWusEj.rQpprvvsDjm8W8yy.CutOPycQV6', 'kk@gmail.com', '01154786', 'active', '2026-01-13'),
(4, 'test', 'assets/img/1768273200_admin.jpg', '$2y$10$ymblMKvFZpGm2MBCY4HYWusEj.rQpprvvsDjm8W8yy.CutOPycQV6', 'test1@gmail.com', '0145632987', 'active', '2026-01-13'),
(5, 'test2', 'assets/img/admin.jpg', '$2y$10$ymblMKvFZpGm2MBCY4HYWusEj.rQpprvvsDjm8W8yy.CutOPycQV6', 'test2@gmail.com', '01123654789', 'active', '2026-01-13'),
(7, 'test', 'assets/img/default-profile.png', '$2y$10$ymblMKvFZpGm2MBCY4HYWusEj.rQpprvvsDjm8W8yy.CutOPycQV6', 'kk@gmail.com', '01154786', 'active', '2026-01-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
