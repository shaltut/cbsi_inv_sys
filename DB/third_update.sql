-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2019 at 03:39 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbsi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equip_id` int(6) NOT NULL,
  `equip_name` varchar(50) NOT NULL,
  `equip_desc` text NOT NULL,
  `is_maintenance_required` enum('yes','no') NOT NULL DEFAULT 'no',
  `maintain_every` int(4) DEFAULT '1',
  `last_maintained` date DEFAULT NULL,
  `equip_cost` double(10,2) DEFAULT NULL,
  `equip_entered_by` int(6) NOT NULL,
  `equip_status` enum('active','inactive') NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equip_id`, `equip_name`, `equip_desc`, `is_maintenance_required`, `maintain_every`, `last_maintained`, `equip_cost`, `equip_entered_by`, `equip_status`, `date_added`) VALUES
(24, 'Power Washer', 'Coleman Power Washer (2-Stroke)', 'no', 182, '0000-00-00', 890.98, 11, 'active', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_checkout`
--

CREATE TABLE `equipment_checkout` (
  `chk_id` int(10) NOT NULL,
  `equip_id` int(6) NOT NULL,
  `empl_id` int(6) NOT NULL,
  `site_id` int(6) NOT NULL,
  `chk_date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `site_id` int(6) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `job_desc` text NOT NULL,
  `start_date` date NOT NULL,
  `site_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_name`, `job_desc`, `start_date`, `site_status`) VALUES
(303000, 'Hilton Hotel', 'Renovation of the hotel\'s lobby and bathrooms.', '2019-02-26', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(6) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(75) NOT NULL,
  `user_job` varchar(100) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_job`, `user_type`, `user_status`) VALUES
(11, 'admin@gmail.com', '$2y$10$sMVh.x6QWJNzjU9/9PAU2.WzGViZtAWO53Jm3Wm3Nf6S/PEeSxbNC', 'admin', 'administrator', 'master', 'Active'),
(101008, 'user@gmail.com', '$2y$10$X7KUdegRapkxYHRIegXpUOBEjK9GvAX9ZGO9n3g3Ry69KIkwhp8lO', 'user', 'employee', 'user', 'Active'),
(101010, 'test@test.com', '$2y$10$h7eU4bWaEHSkwG30rc0QIemiYgoHMjFL72V4AMb2q6fzuR29QT4wa', 'test', 'test', 'user', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equip_id`);

--
-- Indexes for table `equipment_checkout`
--
ALTER TABLE `equipment_checkout`
  ADD PRIMARY KEY (`chk_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equip_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202000;

--
-- AUTO_INCREMENT for table `equipment_checkout`
--
ALTER TABLE `equipment_checkout`
  MODIFY `chk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404008;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303001;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101011;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
