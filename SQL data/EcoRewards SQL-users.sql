-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 09:22 PM
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
(1, 'Lorente', '$2y$10$hU6pZioLS35.OAa0OelnQ.p4HqLjveZP69inp4g7VckZNbKiAEWL.', 'student_boy.png', 'lorente@gmail.com', '012-3456234', 'student', 1649, '3/18/2025'),
(2, 'Bowley', '$2y$10$TVeUG8UsnImnu4Dp3nDLG.wyo/eYuxMA7fbdkesIaum92ny67wpS6', 'student_boy.png', 'bowley@gmail.com', '821-566-7372', 'student', 515, '6/28/2025'),
(3, 'Jane', '$2y$10$CYPtgzy2zUwsoGaNnIeuDO4XHdfH4DKBluRIB3shtn0Fd95QG4VBC', 'staff_girl.png', 'jane@gmail.com', '235-408-2442', 'staff', 959, '11/29/2025'),
(4, 'Byran', '$2y$10$iIlgdxEyq1yy.q0XyAhB..gpHFqXaRRGHvo67UCJ40UHlkQXBx5Ty', 'staff_boy.png', 'byran@gmail.com', '585-383-4578', 'staff', 0, '5/3/2025'),
(5, 'Lara', ' $2y$10$BBfHuRFe.hB3mtz/5iAa5uuka59QA2JUHlk3zBBL5VcjewiLWLUCW', 'student_girl.png', 'lara@gmail.com', '923-773-6721', 'student', 192, '9/27/2025');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
