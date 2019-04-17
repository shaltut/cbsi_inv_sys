-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2019 at 05:27 AM
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
  `is_broken` enum('yes','no') NOT NULL DEFAULT 'no',
  `broken_desc` varchar(250) DEFAULT NULL,
  `equip_cost` double(10,2) DEFAULT NULL,
  `equip_entered_by` int(6) NOT NULL,
  `equip_status` enum('active','inactive') NOT NULL,
  `date_added` date NOT NULL,
  `is_available` enum('available','unavailable') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equip_id`, `equip_name`, `equip_serial`, `equip_desc`, `is_maintenance_required`, `maintain_every`, `last_maintained`, `is_broken`, `broken_desc`, `equip_cost`, `equip_entered_by`, `equip_status`, `date_added`, `is_available`) VALUES
(202000, 'Power Washer', NULL, 'Blue Power Washer', 'no', NULL, NULL, 'no', NULL, 234.00, 101008, 'active', '2019-03-23', 'available'),
(202001, 'Jack Hammer', '', 'Red Jack Hammer', 'yes', 6, '2018-10-25', 'no', NULL, 321.00, 11, 'active', '2019-03-23', 'unavailable'),
(202004, 'DEWALT 20-Volt Cordless Drill', '', 'DEWALT 20-Volt MAX XR Lithium-Ion Cordless\r\nColor: Yellow', 'no', NULL, NULL, 'no', NULL, 5000.00, 11, 'active', '2019-04-02', 'unavailable'),
(202005, '2017 Ford F-150 Platinum 4WD (LM4-DSTN)', '', 'Truck with flat bed and trailer.\r\nLicense Plate #: LM4-DSTN\r\nRegistration: 142j3h3iuhb42k (Jack Mencia)\r\nMax Towing Capacity: 14,500 - 16,000 lb\r\nBed measurements: 88.6 in (between wheel hubs)\r\n4WD', 'yes', 6, '2019-04-16', 'no', NULL, 44125.88, 11, 'active', '2018-05-10', 'available'),
(202006, '2018 Toyota Tacoma 4WD (R4U-0C33)', '', 'Truck with flat bed \r\nMax Towing Capacity: 6,500 - 8,500 lb\r\nTrailer hitch but no trailer\r\nBed measurements: 50.6 in (between wheel hubs)\r\n4WD', 'yes', 6, '2019-04-17', 'no', NULL, 28677.22, 11, 'active', '2019-04-02', 'available'),
(202007, 'Table Saw (DEWALT) (Lumber/Wood)', NULL, '15-Amp Corded 10 in. Compact Job Site Table Saw with Site-Pro Modular Guarding System with Stand\r\nHardwood, Pressure treated lumber, etc.\r\nLightweight', 'yes', 24, '2019-01-25', 'no', NULL, 299.00, 11, 'active', '2019-04-02', 'available'),
(202014, 'Dodge Van (E3D-E34G)', '', '2WD\r\nNo towing capacity\r\nLarge space for moving equipment', 'yes', 6, '2019-04-17', 'no', NULL, 12322.22, 11, 'active', '2019-04-11', 'available'),
(202019, 'Ladder (18 Foot)', NULL, '18 Foot. Wide base. ', 'no', NULL, NULL, 'no', NULL, 45.89, 11, 'active', '2019-04-12', 'available'),
(202020, 'Ladder (24 Foot)', NULL, '24 Foot Tall Ladder.\r\nCovered in paint... Someone clean this thing...', 'no', NULL, NULL, 'no', NULL, 67.32, 11, 'active', '2019-04-12', 'available'),
(202021, 'Husky 50 pc. Drill Bit Case', NULL, 'Case of 50 Drill bits ranging from 3/64\" - 5/16\"', 'no', NULL, NULL, 'no', NULL, 117.23, 11, 'active', '2019-04-12', 'available'),
(202022, '1-1/8\" Hex 35# Breaker Hammer ', '123456', '35 lb. demolition hammer', 'no', NULL, NULL, 'yes', 'asdf', 1289.47, 11, 'active', '2019-04-12', 'available'),
(202023, 'Bosch Sds-max Demolition Hammer', '', '14 Amp Hand Held Breaker Hammer', 'yes', 6, '2018-09-07', 'no', NULL, 999.99, 11, 'active', '2019-04-12', 'available'),
(202024, 'FH350 Portable Concrete Mixer', '', 'Diesel/Gasoline Concrete Mixer', 'yes', 18, '2018-05-10', 'yes', 'asdffdsa', 850.00, 11, 'active', '2019-04-12', 'available'),
(202025, 'Ladder Hoist (28ft)', NULL, 'TranzSporter TP250 - 250lb. 28ft (Lifan Motor)', 'no', NULL, NULL, 'no', NULL, 1556.56, 11, 'active', '2019-04-12', 'available'),
(202026, 'Skeleton Loader w/ Teeth Skid Steer ', NULL, '72\" Rock Bucket \r\nTeeth Skid \r\nBobcat', 'yes', 12, '2019-04-17', 'no', NULL, 945.22, 11, 'active', '2019-04-12', 'available'),
(202032, 'Zfortesting', NULL, '', 'no', NULL, NULL, 'no', NULL, 0.00, 11, 'active', '2019-04-13', 'available'),
(202033, 'Afortesting', '', '', 'yes', 6, '2019-04-12', 'no', NULL, 0.00, 11, 'active', '2019-04-13', 'available'),
(202039, 'NEW Test', '123', 'Hello ', 'yes', 6, '2019-04-17', 'no', NULL, 666.00, 11, 'active', '2019-04-13', 'available'),
(202046, 'Test 1', '123', 'A test for broken equipment', 'no', NULL, NULL, 'no', NULL, 666.00, 11, 'active', '2019-04-17', 'available'),
(202048, 'testest', NULL, '', 'no', NULL, NULL, 'no', NULL, 0.00, 11, 'active', '2019-04-17', 'available'),
(202049, 'asdfasdfasdfa', '', '', 'no', NULL, NULL, 'no', NULL, 0.00, 11, 'active', '2019-04-17', 'available');

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

--
-- Dumping data for table `equipment_checkout`
--

INSERT INTO `equipment_checkout` (`chk_id`, `equip_id`, `empl_id`, `site_id`, `chk_date_time`, `returned`) VALUES
(404227, 202022, 101008, 303002, '2019-04-15', 'true'),
(404228, 202020, 101008, 303002, '2019-04-15', 'true'),
(404229, 202014, 101008, 303001, '2019-04-15', 'true'),
(404230, 202006, 101008, 303001, '2019-04-15', 'true'),
(404231, 202033, 101008, 303002, '2019-04-15', 'true'),
(404232, 202032, 101008, 303000, '2019-04-15', 'true'),
(404233, 202000, 11, 303001, '2019-04-17', 'true'),
(404234, 202000, 11, 303001, '2019-04-17', 'true');

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
(101008, 'user@gmail.com', '$2y$10$xohoOYrrQox32OyVRKMJCuqafIy3S0Y55zUOIJ33P0P7JFWi5GD.K', 'John Smith', 'Project Manager', 'user', 'Active', NULL),
(101019, 'tk@gmu.edu', '$2y$10$v2QBiC4f65HMlzcT0eDht.HIKbmC9RBInM6LDkpzV0MM/ZdC0V7lK', 'Taylor Kim', 'Laborer', 'master', 'Active', NULL);

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
  MODIFY `equip_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202050;

--
-- AUTO_INCREMENT for table `equipment_checkout`
--
ALTER TABLE `equipment_checkout`
  MODIFY `chk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404235;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303006;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101020;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
