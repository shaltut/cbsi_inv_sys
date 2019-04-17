-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2019 at 09:14 PM
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
  `equip_serial` varchar(50) DEFAULT NULL,
  `equip_desc` varchar(250) NOT NULL DEFAULT '(no description)',
  `is_maintenance_required` enum('yes','no') NOT NULL DEFAULT 'no',
  `maintain_every` int(4) DEFAULT '1',
  `last_maintained` date DEFAULT NULL,
  `equip_cost` double(10,2) DEFAULT NULL,
  `equip_entered_by` int(6) NOT NULL,
  `equip_status` enum('active','inactive') NOT NULL,
  `date_added` date NOT NULL,
  `is_available` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `equipment_checkout`
--

CREATE TABLE `equipment_checkout` (
  `chk_id` int(10) NOT NULL,
  `equip_id` int(6) NOT NULL,
  `empl_id` int(6) NOT NULL,
  `site_id` int(6) NOT NULL,
  `chk_date_time` date NOT NULL,
  `returned` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `site_id` int(6) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_address` varchar(100) NOT NULL,
  `job_desc` text NOT NULL,
  `start_date` date NOT NULL,
  `site_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_name`, `site_address`, `job_desc`, `start_date`, `site_status`) VALUES
(303000, 'HILTON HOTELS', '12352 3RD St. SW Washington, DC', 'Property Maintenance, Brick Paver Driveway Repairs â€“ Hilton Embassy Row â€“ Washington, D.C', '2018-07-12', 'active'),
(303001, 'WATERGATE HOTEL', '123 25th st. SW, DC', 'Exterior Cleaning â€“ Washington, D.C.', '2018-12-06', 'active'),
(303002, 'CATHOLIC UNIVERSITY', '666, Test St. Oakton, VA', 'Exterior Paint Removal  & Painting of Oâ€™Boyle Hall â€“ Washington, D.C.', '2019-03-31', 'active'),
(303003, 'THE METROPOLITAN CLUB OF WDC', '1626 NW Washington DC 22028', 'Exterior Restoration â€“ Washington, D.C.', '2018-08-02', 'active'),
(303004, 'TEXTILE MUSEUM', '88823 27th and Constitution SW Washington, DC', 'Historical Restoration Lead Paint Abatement, FaÃ§ade Cleaning and Painting of Exterior Wood Doors, Windows, Shutters, Moldings and Ironwork â€“ Washington, D.C.', '2018-10-27', 'active'),
(303005, 'MONUMENT REALTY', '7283, Destination Way. McLean VA 22033', 'Demolition, Tenant Build-out, Paintingâ€“ Tyler Building â€“ McLean, Virginia', '2019-04-04', 'active');

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
  `user_type` enum('master','user') NOT NULL DEFAULT 'user',
  `user_status` enum('Active','Inactive') NOT NULL,
  `ia_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_job`, `user_type`, `user_status`, `ia_date`) VALUES
(11, 'admin@gmail.com', '$2y$10$009LTwv4s.XEf6CMp8MHFODJzARaR3zTyMdVGteKmKytGJ.sYUGwi', 'Connor Bailey', 'Supervisor', 'master', 'Active', NULL),
(12, 'user@gmail.com', '$2y$10$1HV.spNTwEpyIDifZwVMouFXJ8lYEK2uJkZbmmYnAuyjNfVXLejsG', 'Taylor Kim', 'Project Manager', 'user', 'Active', NULL);

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
  MODIFY `chk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404000;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303000;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
