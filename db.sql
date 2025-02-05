-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 09:26 AM
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
-- Database: `student_marks_db`
--
DROP DATABASE IF EXISTS happy_db;
CREATE DATABASE happy_db;
USE happy_db;
-- --------------------------------------------------------

--
-- Table structure for table `happy__tbladmins`
--

CREATE TABLE `happy__tbladmins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `happy__tbladmins`
--

INSERT INTO `happy__tbladmins` (`id`, `username`, `password`) VALUES
(5, 'shyakangango77@gmail.com', '$2y$10$w6nwDBB9inxAW6vYNj3EAeOc8GKYqAFk67ePI3pfWFCxvShiV/OGq'),
(9, 'admin', '$2y$10$j6w.uGXj5sfFA.Ru2onnMe6FH.nXIetVfVY9teqB9vARvweaLFVWO');

-- --------------------------------------------------------

--
-- Table structure for table `happy__tblmarks`
--

CREATE TABLE `happy__tblmarks` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `marks` decimal(5,2) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `happy__tblmarks`
--

INSERT INTO `happy__tblmarks` (`id`, `student_id`, `subject`, `marks`, `entry_date`, `teacher_id`) VALUES
(10, '123JC', 'Dart', 31.00, '2025-02-04 09:52:51', 14),
(12, '312830420253', 'DevOps', 90.00, '2025-02-04 12:10:29', 10);

-- --------------------------------------------------------

--
-- Table structure for table `happy__tblmodules`
--

CREATE TABLE `happy__tblmodules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_module_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `other_details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `happy__tblmodules`
--

INSERT INTO `happy__tblmodules` (`id`, `module_name`, `description`, `parent_module_id`, `is_active`, `other_details`) VALUES
(1, 'User Management', 'xwxwxwxwxwxw', 0, 0, NULL),
(2, 'Marks Management', 'Enter and view student marks', 0, 0, NULL),
(3, 'Module Management', 'Manage system modules and permissions', NULL, 1, NULL),
(4, 'DevOps', 'Developers operations', 0, 1, NULL),
(6, 'math', 'algebra', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `happy__tblstudents`
--

CREATE TABLE `happy__tblstudents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `class` varchar(50) NOT NULL,
  `other_details` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `happy__tblstudents`
--

INSERT INTO `happy__tblstudents` (`id`, `name`, `student_id`, `class`, `other_details`, `password`) VALUES
(8, 'JC', '123JC', 'L5NIT', 'this is jean claude', '$2y$10$JnlK5hBZpIxD22t0szLO3eQK/MSUh//0jR0CyrQeNMfJl91KAOKv6'),
(14, 'Carrick', 'C123', 'L5SOD', 'No', '$2y$10$gcl/tArSgiIHliviP8VANeYe4/vFbjKL5MI0VewJqdgpFdNR5pVwi'),
(15, 'Bruno', '312830420253', 'L5SOD', 'Very intelligent', '$2y$10$hqXDc.y6np9OhKkVJTfjDuikS..5ln8VPOsr5AUOG7yyyV.fatDJW');

-- --------------------------------------------------------

--
-- Table structure for table `happy__tblteachers`
--

CREATE TABLE `happy__tblteachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `happy__tblteachers`
--

INSERT INTO `happy__tblteachers` (`id`, `name`, `subject`, `username`, `password`) VALUES
(10, 'other', 'DevOps', 'other', '$2y$10$MxoXUScogFvZCK5v6zPBm.vZPqYARUenkMc8DbCppSgKslQg2rolK'),
(14, 'Phineas', 'Dart', 'Phineas', '$2y$10$zulMgCkf9XSZNVWuPnMA2u.bRFGuKKotfj2g0/6SfJ/n6c5IuioVW');

-- --------------------------------------------------------

--
-- Table structure for table `happy__tbluser_modules`
--

CREATE TABLE `happy__tbluser_modules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `happy__tbladmins`
--
ALTER TABLE `happy__tbladmins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `happy__tblmarks`
--
ALTER TABLE `happy__tblmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_marks` (`student_id`),
  ADD KEY `marks_ibfk_2` (`teacher_id`);

--
-- Indexes for table `happy__tblmodules`
--
ALTER TABLE `happy__tblmodules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `happy__tblstudents`
--
ALTER TABLE `happy__tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `happy__tblteachers`
--
ALTER TABLE `happy__tblteachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `happy__tbluser_modules`
--
ALTER TABLE `happy__tbluser_modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `happy__tbladmins`
--
ALTER TABLE `happy__tbladmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `happy__tblmarks`
--
ALTER TABLE `happy__tblmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `happy__tblmodules`
--
ALTER TABLE `happy__tblmodules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `happy__tblstudents`
--
ALTER TABLE `happy__tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `happy__tblteachers`
--
ALTER TABLE `happy__tblteachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `happy__tbluser_modules`
--
ALTER TABLE `happy__tbluser_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `happy__tblmarks`
--
ALTER TABLE `happy__tblmarks`
  ADD CONSTRAINT `fk_student_marks` FOREIGN KEY (`student_id`) REFERENCES `happy__tblstudents` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `happy__tblteachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
