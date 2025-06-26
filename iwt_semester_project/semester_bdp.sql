-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 29, 2025 at 10:42 AM
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
-- Database: `semester_bdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` enum('academic','administrative','facilities','internet','behavior','electricity','other') NOT NULL,
  `location` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `mobile` varchar(20) NOT NULL,
  `incident_date` date DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `status` enum('pending','in_progress','resolved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `user_id`, `category`, `location`, `title`, `description`, `attachment_path`, `priority`, `mobile`, `incident_date`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'internet', 'Hostel', 'Widi not working', 'Lorem ajdhkas aklsa askdbdsa aslkad klASKNad', NULL, 'high', '097654376', '2025-04-29', 'male', 'pending', '2025-05-14 21:34:44', '2025-05-14 21:34:44'),
(2, 3, 'internet', 'asdf', 'qwrty', 'wertyuiytrewq', NULL, 'high', '2345678', NULL, 'male', 'rejected', '2025-05-14 22:07:08', '2025-05-29 08:00:53'),
(5, 3, 'electricity', 'akjshdsa', 'akdjlaksjd', 'adks aJKDHSA JLad DJSAL', NULL, 'medium', '4567890', NULL, 'male', 'in_progress', '2025-05-14 22:14:53', '2025-05-15 17:20:13'),
(6, 1, 'internet', 'Jinnah Block', 'Problem', 'Lorem kaljd and kald aio', NULL, 'medium', '03001324566', '2025-05-20', 'male', 'resolved', '2025-05-15 20:06:12', '2025-05-29 08:00:54'),
(16, 3, 'behavior', 'Hostel', 'qwrty', 'Lorem ipsum', 'uploads/1748467543_Noorani-Qaida-in-English-e-Book-thequranclasses.online-2 (1).pdf', 'low', '03145175481', '0000-00-00', 'male', 'in_progress', '2025-05-28 21:25:43', '2025-05-29 07:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','employee','admin') NOT NULL,
  `gender` enum('male','female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_type`, `gender`) VALUES
(1, 'Asad', 'asad', '$2y$10$0wzj71HqTBWlK0WC.1sHhOe/p7Fg1MvhOHehyfMRKFltceV2bnpZq', 'employee', 'male'),
(2, 'Usman', 'usman', '$2y$10$Ealeynbp9J/f0DV6dmiASO3bZvNLWhm9mpcFA2YwVje21Mb0DtiqO', 'employee', 'male'),
(3, 'Usama', 'usama', '$2y$10$YDjEbEttgyzveLu1U79lq.qCZkT/hSbok4jUE06ldiMtsX4ntCkRu', 'student', 'male'),
(7, 'Admin\r\n', 'admin', '$2y$10$Nk/6.6g7Q01xc1cVN9StMerUJC4P5j4I5qTD3DeKaVwH.aO2gD1KW', 'admin', NULL),
(8, 'Ammad', 'ammad', '$2y$10$7tTNhP8EIN3D7zXBEUkuueHaHXOs.o7sOUtFDNudQXW2pFmUq8Dqm', 'student', 'male'),
(10, 'Wajih', 'wajih', '$2y$10$2Z2aYIx4KHfUWdhKAvGY8uwWA0H.kTSCzG2irXjhC4Ds6Wkql9D0y', 'student', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
