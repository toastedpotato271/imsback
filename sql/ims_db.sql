-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 09:45 AM
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
-- Database: `ims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','in-progress','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `user_id`, `title`, `description`, `status`, `created_at`) VALUES
(1, 2, 'Broken light in hallway', 'The light in the main hallway is broken and needs repair.', 'closed', '2024-11-29 05:00:42'),
(2, 2, 'Elevator malfunction', 'The elevator stopped working on the 3rd floor, needs immediate attention.', 'closed', '2024-11-29 05:00:42'),
(3, 2, 'Water leakage in room 102', 'There is water leaking from the ceiling in room 102, needs fixing.', 'closed', '2024-11-29 05:00:42'),
(4, 2, 'Air conditioning not working', 'The air conditioning in the conference room is not functioning.', 'open', '2024-11-29 05:00:42'),
(5, 2, 'Power outage in room 105', 'Room 105 has no power, please check the fuse.', 'in-progress', '2024-11-29 05:00:42'),
(6, 3, 'Internet connection issues', 'The internet connection in room 105 is intermittent.', 'open', '2024-11-29 05:00:42'),
(7, 3, 'Broken window in room 107', 'The window in room 107 is shattered and needs replacement.', 'in-progress', '2024-11-29 05:00:42'),
(8, 3, 'Leak in bathroom', 'There is a leak in the bathroom ceiling in room 108.', 'closed', '2024-11-29 05:00:42'),
(9, 3, 'Locked door in room 110', 'The door of room 110 is jammed and won\'t open.', 'open', '2024-11-29 05:00:42'),
(10, 3, 'No hot water in room 103', 'The hot water is not working in room 103, needs fixing.', 'closed', '2024-11-29 05:00:42'),
(11, 1, 'This is Report test 1', 'This is a sample description of the test report 1', 'open', '2024-11-29 06:25:42'),
(12, 8, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget est consequat nunc mattis molestie. Vivamus posuere pulvinar neque a sagittis.', 'open', '2024-11-29 07:55:29'),
(13, 9, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget est consequat nunc mattis molestie. Vivamus posuere pulvinar neque a sagittis.', 'open', '2024-11-29 08:03:34'),
(14, 10, 'Test New User 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla lobortis at massa nec pharetra. Quisque odio ex, luctus eget nisl id, mattis egestas massa. Duis a sollicitudin nibh', 'open', '2024-11-29 08:19:23'),
(15, 11, 'Test Title 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla lobortis at massa nec pharetra. Quisque odio ex, luctus eget nisl id, mattis egestas massa. Duis a sollicitudin nibh', 'closed', '2024-11-29 08:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `email`) VALUES
(1, 'admin', 'admin123', 'admin', '2024-11-29 04:59:37', ''),
(2, 'user1', 'user123', 'user', '2024-11-29 04:59:37', ''),
(3, 'user2', 'user456', 'user', '2024-11-29 04:59:37', ''),
(7, 'report', '$2y$10$o.JwA0BwN7DBAQQqJA12A.VyMa5o4sDokW8KDmJSvrIpvyMbkngz6', 'user', '2024-11-29 06:21:05', ''),
(8, 'admin2', 'admin123', 'admin', '2024-11-29 07:38:03', 'madmin@mail.com'),
(9, 'report4', 'report123', 'user', '2024-11-29 07:56:16', 'reporter@report.com'),
(10, 'report0', '$2y$10$ZGE7SBWubuoDT0Kk4mPbR.c9hEVJEjotyBfZ3zb3863k2.QVf5nOC', 'user', '2024-11-29 08:19:23', 'report@mail.com'),
(11, 'report1', 'report123', 'user', '2024-11-29 08:22:20', 'report1@mail.com'),
(12, 'test12', 'test123', 'user', '2024-11-29 08:39:04', 'test12@mail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
