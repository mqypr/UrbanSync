-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2026 at 09:03 AM
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
  `second_project` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_contributions`
--

INSERT INTO `about_contributions` (`id`, `name`, `student_id`, `first_project`, `second_project`) VALUES
(1, 'MD Areen Chowdhury', '105693861', 'Developed about.html page for Project 1', 'Converted about.html to about.php and loaded member contributions from the database'),
(2, 'Reach Peng', '106382377', 'Developed index.html page for Project 1', 'Updated index page for Project 2\nBuilt the DB-driven projects carousel on the home page, loading project data dynamically from MySQL\nImplemented the project search feature on the home page using prepared statements to prevent SQL injection\nDesigned and implemented the dark/light mode toggle system persisted via cookies across all pages\nBuilt the user authentication system including login.php, signup.php, and account.php with password hashing\nImplemented the sticky search bar UI with result cards showing category, date, location, and description\nManaged and maintained the overall CSS design system including CSS variables, dark/light theming, responsive layout, and component styles\nSet up and structured the MySQL database including the projects table and users table\nWrote and maintained settings.php for centralised database connection handling\nHandled security across the site including htmlspecialchars output escaping and prepared statements throughout index.php\n'),
(3, 'Liron Roshain Joanic Willathgamuwa', '105987496', 'Developed apply.html page for Project 1', 'Updated apply page for Project 2'),
(4, 'Dylan Kelly', '105332711', 'Developed jobs.html page for Project 1', 'Updated jobs page for Project 2');

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `jobRef` varchar(5) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `suburb` varchar(40) DEFAULT NULL,
  `state` varchar(5) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `otherSkills` text DEFAULT NULL,
  `status` enum('New','Current','Final') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `jobRef`, `firstName`, `lastName`, `dob`, `gender`, `address`, `suburb`, `state`, `postcode`, `email`, `phone`, `skills`, `otherSkills`, `status`) VALUES
(1, '42461', 'Liron', 'WILLATHGAMUWA', '25/01/2007', 'Male', '43 Valley Fair Dr, Narre Warren VIC 3805', 'Narre Warren', 'VIC', '3805', 'roshainwillathgamuwa11@gmail.com', '0493857099', 'Programming', '', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `manager_users`
--

CREATE TABLE `manager_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_users`
--

INSERT INTO `manager_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$q3FfvBI.6mDnC/rOThttmeqVewO7wbDaBts4shI4DjtX079P7Cvy2');

-- --------------------------------------------------------

--
-- Table structure for table `opened_jobs`
--

CREATE TABLE `opened_jobs` (
  `reference_number` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_description` varchar(1000) NOT NULL,
  `salary` varchar(20) NOT NULL,
  `reporting_line` varchar(2000) NOT NULL,
  `responsobilities` varchar(2000) NOT NULL,
  `requirements` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opened_jobs`
--

INSERT INTO `opened_jobs` (`reference_number`, `title`, `short_description`, `salary`, `reporting_line`, `responsobilities`, `requirements`) VALUES
(1, 'Frontend Web Developer', 'Build and maintain clean, responsive interfaces for company websites.', '70,000^85,000', 'Engineering Manager^Technical Lead^Product Manager', 'Building front end interfaces^Ensuring accessible and intuitive designs are implemented into the user experience', 'Effective communication for team collaboration^High adaptability to new technologies^A methodical approach to debugging and creating responsive, accessible websites'),
(2, 'IT Support Officer', 'Provide technical support and help staff resolve hardware and software issues.', '55,000^68,000', 'IT Manager^IT Support Manager^Service Desk Manager', 'Installing, configuring, and maintaining hardware (computers, printers, routers) and software systems^Troubleshooting technical issues to minimize downtime', 'Problem-solving mindset^Excellent communication abilities^Patience'),
(3, 'Junior Data Analyst', 'Analyse infrastructure and transport data to help improve urban planning decisions.', '62000^74000', 'Analytics Manager^Senior Data Analyst^Project Coordinator', 'Clean and organise large datasets^Create reports and visualisations for internal teams^Identify trends in transport and infrastructure usage^Assist with maintaining dashboards and data tools', 'Basic knowledge of SQL and spreadsheets^Strong attention to detail^Ability to communicate findings clearly^Interest in urban planning, infrastructure, or data analytics'),
(10056, 'Junior Data Analyst', 'Analyse infrastructure and transport data to help improve urban planning decisions.', '73,000', 'Analytics Manager^Senior Data Analyst^Project Coordinator', 'Clean and organise large datasets^Create reports and visualisations for internal teams^Identify trends in transport and infrastructure usage^Assist with maintaining dashboards and data tools', 'Basic knowledge of SQL and spreadsheets^Strong attention to detail^Ability to communicate findings clearly^Interest in urban planning, infrastructure, or data analytics');

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
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `manager_users`
--
ALTER TABLE `manager_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `opened_jobs`
--
ALTER TABLE `opened_jobs`
  ADD PRIMARY KEY (`reference_number`);

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
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manager_users`
--
ALTER TABLE `manager_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opened_jobs`
--
ALTER TABLE `opened_jobs`
  MODIFY `reference_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10057;

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
