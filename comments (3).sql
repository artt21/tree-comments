-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2022 at 04:50 PM
-- Server version: 8.0.24
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comments`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `name`, `content`, `date`) VALUES
(158, NULL, 'first comment', 'first comment', '2022-02-16 20:51:40'),
(159, NULL, 'second comment', 'second comment', '2022-02-16 20:51:48'),
(213, 159, '1st child of the second comment', '1st child of the second comment', '2022-04-06 23:20:28'),
(216, NULL, 'third comment', 'third comment', '2022-04-07 19:34:40'),
(217, 213, 'second child of the second comment', 'second child of the second comment', '2022-04-07 19:35:21'),
(218, 216, 'first child of the third comment', 'first child of the third comment', '2022-04-07 19:35:41'),
(219, NULL, 'fourth comment', 'fourth comment', '2022-04-07 19:47:15'),
(251, 158, 'child of parent comment', 'child of parent comment', '2022-05-11 18:31:25'),
(252, 251, 'child of 1st child comment', 'child of 1st child comment', '2022-05-11 18:31:47'),
(253, 251, 'another child of 1st child comment', 'another child of 1st child comment', '2022-05-11 18:34:37'),
(254, 252, '2nd child', '2nd child', '2022-05-11 18:34:52'),
(273, 272, 'hey wassup', 'hey wassup', '2022-05-13 14:27:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
