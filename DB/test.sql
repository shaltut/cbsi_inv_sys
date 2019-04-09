-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2019 at 08:52 PM
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

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equip_id`, `equip_name`, `equip_desc`, `is_maintenance_required`, `maintain_every`, `last_maintained`, `equip_cost`, `equip_entered_by`, `equip_status`, `date_added`, `is_available`) VALUES
(202000, 'Power Washer', 'Blue Power Washer', 'no', 6, '1970-01-01', 234.00, 11, 'active', '2019-03-23', 'unavailable'),
(202001, 'Jack Hammer', 'Red Jack Hammer', 'yes', 18, '2018-12-06', 321.00, 11, 'active', '2019-03-23', 'unavailable'),
(202003, 'Test Item', 'This is a test description for the test item. ', 'yes', 6, '2018-05-03', 682.00, 11, 'active', '2019-03-26', 'available'),
(202004, 'DEWALT 20-Volt Cordless Drill', 'DEWALT 20-Volt MAX XR Lithium-Ion Cordless\r\nColor: Yellow', 'no', 6, '1970-01-01', 5000.00, 11, 'active', '2019-04-02', 'unavailable'),
(202005, '2017 Ford F-150 Platinum 4WD (LM4-DSTN)', 'Truck with flat bed and trailer.\r\nLicense Plate #: LM4-DSTN\r\nRegistration: 142j3h3iuhb42k (Jack Mencia)\r\nMax Towing Capacity: 14,500 - 16,000 lb\r\nBed measurements: 88.6 in (between wheel hubs)\r\n4WD', 'yes', 6, '2018-11-07', 44125.88, 11, 'active', '2018-05-10', 'available'),
(202006, '2018 Toyota Tacoma 4WD (R4U-0C33)', 'Truck with flat bed \r\nMax Towing Capacity: 6,500 - 8,500 lb\r\nTrailer hitch but no trailer\r\nBed measurements: 50.6 in (between wheel hubs)\r\n4WD', 'yes', 6, '2019-04-04', 28677.22, 11, 'active', '2019-04-02', 'available'),
(202007, 'Table Saw (DEWALT) (Lumber/Wood)', '15-Amp Corded 10 in. Compact Job Site Table Saw with Site-Pro Modular Guarding System with Stand\r\nHardwood, Pressure treated lumber, etc.\r\nLightweight', 'yes', 24, '2019-01-25', 299.00, 11, 'active', '2019-04-02', 'available'),
(202008, 'test name', '', 'no', 6, '1970-01-01', 5000.00, 11, 'active', '2019-04-02', 'available'),
(202009, 'Another Test', '', 'no', 6, '1970-01-01', 56.78, 11, 'active', '2019-04-02', 'available'),
(202011, 'NO COST', '', 'no', 6, '1970-01-01', 0.00, 11, 'active', '2019-04-07', 'available');

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
(404135, 202000, 11, 303001, '2018-03-14', 'true'),
(404136, 202001, 11, 303000, '2018-05-08', 'true'),
(404137, 202003, 11, 303001, '2018-10-18', 'true'),
(404138, 202000, 11, 303001, '2018-09-04', 'true'),
(404139, 202000, 11, 303001, '2018-12-20', 'true'),
(404140, 202000, 11, 303000, '2019-03-13', 'true'),
(404141, 202001, 11, 303001, '2019-03-15', 'true'),
(404142, 202003, 11, 303002, '2018-09-05', 'true'),
(404143, 202001, 101008, 303000, '2019-04-01', 'true'),
(404144, 202001, 11, 303002, '2019-03-15', 'true'),
(404145, 202001, 11, 303002, '2019-04-02', 'true'),
(404146, 202003, 11, 303000, '2018-11-14', 'true'),
(404147, 202000, 11, 303002, '2019-02-15', 'true'),
(404148, 202003, 11, 303001, '2019-02-21', 'true'),
(404149, 202000, 11, 303000, '2019-03-15', 'true'),
(404150, 202006, 11, 303003, '2019-04-03', 'true'),
(404151, 202008, 11, 303005, '2019-04-03', 'true'),
(404152, 202009, 11, 303004, '2019-04-03', 'true'),
(404153, 202000, 11, 303002, '2019-04-03', 'true'),
(404154, 202001, 11, 303001, '2019-04-03', 'true'),
(404155, 202003, 11, 303002, '2019-04-03', 'true'),
(404156, 202004, 11, 303004, '2019-04-03', 'true'),
(404157, 202005, 11, 303000, '2019-04-03', 'true'),
(404158, 202000, 11, 303001, '2019-04-07', 'true'),
(404159, 202000, 11, 303001, '2019-04-07', 'true'),
(404160, 202000, 11, 303001, '2019-04-07', 'true'),
(404161, 202000, 11, 303001, '2019-04-07', 'true'),
(404162, 202000, 11, 303003, '2019-04-07', 'true'),
(404163, 202000, 11, 303000, '2019-04-07', 'true'),
(404164, 202001, 11, 303003, '2019-04-07', 'true'),
(404165, 202006, 11, 303002, '2019-04-07', 'true'),
(404166, 202012, 11, 303003, '2019-04-07', 'true'),
(404167, 202000, 11, 303001, '2019-04-07', 'true'),
(404168, 202001, 11, 303003, '2019-04-07', 'false'),
(404169, 202004, 11, 303003, '2019-04-07', 'false'),
(404170, 202000, 11, 303002, '2019-04-09', 'false');

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
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_job`, `user_type`, `user_status`) VALUES
(11, 'admin@gmail.com', '$2y$10$sMVh.x6QWJNzjU9/9PAU2.WzGViZtAWO53Jm3Wm3Nf6S/PEeSxbNC', 'Admin', 'administrator', 'master', 'Active'),
(101008, 'user@gmail.com', '$2y$10$aBM18Xc8lFd.wBXHIJCPM.hAVGjyg6y2SepGUxBm9GG6SUEc06eQ2', 'Standard User', 'Supervisor', 'user', 'Active'),
(101010, 'test@test.com', '$2y$10$w3jB2gBpDPD0pW0JTESMvOXZFNxnWF0FcyUWVNYN3dMxAPzb3R8T.', 'Test User', 'Skilled Laborer', 'user', 'Active');

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
  MODIFY `equip_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202014;

--
-- AUTO_INCREMENT for table `equipment_checkout`
--
ALTER TABLE `equipment_checkout`
  MODIFY `chk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404171;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `site_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303006;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101012;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
