-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2026 at 03:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbansync_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_contributions`
--

CREATE TABLE `about_contributions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `first_project` varchar(255) DEFAULT NULL,
  `second_project` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_contributions`
--

INSERT INTO `about_contributions` (`id`, `name`, `student_id`, `first_project`, `second_project`) VALUES
(1, 'MD Areen Chowdhury', '105693861', 'Developed about.html page for Project 1', 'Converted about.html to about.php and loaded member contributions from the database'),
(2, 'Reach Peng', '106382377', 'Developed index.html page for Project 1', 'Updated index page for Project 2'),
(3, 'Liron Roshain Joanic Willathgamuwa', '105987496', 'Developed apply.html page for Project 1', 'Updated apply page for Project 2'),
(4, 'Dylan Kelly', '105332711', 'Developed jobs.html page for Project 1', 'Updated jobs page for Project 2');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `completed` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `location`, `category`, `image_path`, `completed`, `created_at`) VALUES
(1, 'Smart Traffic Grid', 'AI-driven traffic light system reducing congestion by 40%.', 'Melbourne CBD', 'Transport', './images/projects/traffic-grid.jpeg', '2024-03-15', '2026-05-24 06:59:41'),
(2, 'Green Sensor Network', 'IoT air quality sensors across 200 parks and public spaces.', 'Fitzroy', 'Environment', './images/projects/sensor-net.jpeg', '2024-07-22', '2026-05-24 06:59:41'),
(3, 'Urban Transit Hub', 'Integrated bus and tram real-time tracking dashboard.', 'Southern Cross', 'Public Transit', './images/projects/transit-hub.jpeg', '2023-11-01', '2026-05-24 06:59:41'),
(4, 'Smart Waste Management', 'Bin fill-level sensors cutting collection costs by 30%.', 'Richmond', 'Infrastructure', './images/projects/waste-mgmt.jpeg', '2025-01-10', '2026-05-24 06:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_code` varchar(5) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `gender`, `email`, `phone_code`, `phone`, `password`) VALUES
(3, 'Reach', 'Peng', '2007-10-15', 'male', 'pengreach123@gmail.com', '+61', '466333119', '$2y$10$aCAc7aFC2nOP.mbINtDkDu1319.MJIgaQsqlcX2YgMuVwCXMQZC8y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_contributions`
--
ALTER TABLE `about_contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_contributions`
--
ALTER TABLE `about_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
