-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2019 at 08:41 PM
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
-- Database: `testing2`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order`
--

CREATE TABLE `inventory_order` (
  `inventory_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_order_total` double(10,2) NOT NULL,
  `inventory_order_date` date NOT NULL,
  `inventory_order_name` varchar(255) NOT NULL,
  `inventory_order_address` text NOT NULL,
  `payment_status` enum('cash','credit') NOT NULL,
  `inventory_order_status` varchar(100) NOT NULL,
  `inventory_order_created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_order`
--

INSERT INTO `inventory_order` (`inventory_order_id`, `user_id`, `inventory_order_total`, `inventory_order_date`, `inventory_order_name`, `inventory_order_address`, `payment_status`, `inventory_order_status`, `inventory_order_created_date`) VALUES
(1, 7, 4939.20, '2017-11-08', 'David Harper', '3188 Straford Park\r\nHarold, KY 41635', 'credit', 'active', '2017-11-08'),
(2, 7, 1310.40, '2017-11-08', 'Trevor Webster', '4275 Indiana Avenue\r\nHonolulu, HI 96816', 'cash', 'active', '2017-11-08'),
(3, 6, 265.65, '2017-11-08', 'Russell Barrett', '4687 Powder House Road\r\nJupiter, FL 33478', 'cash', 'active', '2017-11-08'),
(4, 6, 1546.80, '2017-11-08', 'Doloris Turner', '3057 Collins Avenue\r\nWesterville, OH 43081', 'credit', 'active', '2017-11-08'),
(5, 5, 1409.00, '2017-11-08', 'Georgette Blevins', '863 Simpson Avenue\r\nSteelton, PA 17113', 'cash', 'active', '2017-11-08'),
(6, 5, 558.90, '2017-11-08', 'Nancy Brook', '3460 Viking Drive\r\nBarnesville, OH 43713', 'credit', 'active', '2017-11-08'),
(7, 4, 1286.25, '2017-11-08', 'Joseph Smith', '190 Metz Lane\r\nCharlestown, MA 02129', 'cash', 'active', '2017-11-08'),
(8, 4, 1520.00, '2017-11-08', 'Maria Lafleur', '3878 Elkview Drive\r\nPort St Lucie, FL 33452', 'credit', 'active', '2017-11-08'),
(9, 4, 1604.00, '2017-11-08', 'David Smith', '4757 Little Acres Lane\r\nLoraine, IL 62349', 'cash', 'active', '2017-11-08'),
(10, 3, 1724.80, '2017-11-08', 'Michelle Hayes', '1140 C Street\r\nWorcester, MA 01609', 'cash', 'active', '2017-11-08'),
(11, 3, 1859.40, '2017-11-08', 'Brenna Hamilton', '2845 Davis Avenue\r\nPetaluma, CA 94952', 'cash', 'active', '2017-11-08'),
(12, 3, 2038.40, '2017-11-08', 'Robbie McKenzie', '3016 Horizon Circle\r\nEatonville, WA 98328', 'credit', 'active', '2017-11-08'),
(13, 2, 573.00, '2017-11-08', 'Jonathan Allen', '2426 Evergreen Lane\r\nAlhambra, CA 91801', 'cash', 'active', '2017-11-08'),
(14, 2, 1196.35, '2017-11-08', 'Mildred Paige', '3167 Oakway Lane\r\nReseda, CA 91335', 'cash', 'active', '2017-11-08'),
(15, 2, 1960.00, '2017-11-08', 'Elva Lott', '4032 Aaron Smith Drive\r\nHarrisburg, PA 17111', 'credit', 'active', '2017-11-08'),
(16, 2, 2700.00, '2017-11-08', 'Eric Johnson', '616 Devils Hill Road\r\nJackson, MS 39213', 'cash', 'active', '2017-11-08'),
(17, 1, 5615.20, '2017-11-09', 'Doris Oliver', '2992 Sycamore Fork Road Hopkins, MN 55343', 'cash', 'active', '2017-11-09'),
(26, 1, 2278.50, '2017-11-27', 'Janet Richardsons', '4799 Ryder Avenue Everett, WA 98210', 'credit', 'inactive', '2017-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `product_description` text NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_base_price` double(10,2) NOT NULL,
  `product_enter_by` int(6) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `product_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_quantity`, `product_base_price`, `product_enter_by`, `product_status`, `product_date`) VALUES
(24, 'Power Washer', 'Coleman Power Washer (2-Stroke)', 5, 890.98, 11, 'active', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(6) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_type`, `user_status`) VALUES
(11, 'admin@gmail.com', '$2y$10$sMVh.x6QWJNzjU9/9PAU2.WzGViZtAWO53Jm3Wm3Nf6S/PEeSxbNC', 'admin', 'master', 'Active'),
(101000, 'connor.baileyyy@gmail.com', '$2y$10$A9E.Onj55powFeILeTDTxO3l59MHQdkGcwNZAd1PHA2Rd3zPA/fDe', 'Connor Bailey', 'user', 'Active'),
(101001, 'tk@gmu.edu', '$2y$10$wYlMMMwTZXmNzPNlJPFqQukaxVMZ8EDHU45c58ZkvPu/imNL3Nkw6', 'Taylor Kim', 'user', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_order`
--
ALTER TABLE `inventory_order`
  ADD PRIMARY KEY (`inventory_order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory_order`
--
ALTER TABLE `inventory_order`
  MODIFY `inventory_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101008;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
