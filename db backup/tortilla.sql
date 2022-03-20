-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2016 at 08:19 পূর্বাহ্ণ
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tortilla`
--

-- --------------------------------------------------------

--
-- Table structure for table `tor_productinfo`
--

CREATE TABLE `tor_productinfo` (
  `id` int(11) NOT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `unit_price` float(7,2) DEFAULT NULL,
  `selling_price` float(7,2) DEFAULT NULL,
  `status` varchar(12) DEFAULT 'active',
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tor_productinfo`
--

INSERT INTO `tor_productinfo` (`id`, `product_code`, `product_name`, `unit_price`, `selling_price`, `status`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, '1000', 'Samusa', 10.00, 10.00, 'active', 'admin', '2016-12-03 01:47:58', NULL, NULL),
(2, '1001', 'Chicken Burger', 70.00, 70.00, 'active', 'admin', '2016-12-08 11:40:37', NULL, NULL),
(3, '1002', 'Vegetable Burger', 50.00, 50.00, 'active', 'admin', '2016-12-08 11:41:49', NULL, NULL),
(4, '1003', 'Pizza', 40.00, 40.00, 'active', 'admin', '2016-12-08 11:45:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tor_productsell_details`
--

CREATE TABLE `tor_productsell_details` (
  `id` int(11) NOT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `product_name` varchar(80) DEFAULT NULL,
  `unit_price` float(7,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` float(8,3) DEFAULT NULL,
  `invoice_no` varchar(15) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tor_productsell_details`
--

INSERT INTO `tor_productsell_details` (`id`, `product_code`, `product_name`, `unit_price`, `quantity`, `total_price`, `invoice_no`, `created_by`, `created_time`, `modified_by`, `modified_time`) VALUES
(1, '1000', 'Samusa', 10.00, 6, 60.000, '201612091', 'sales', '2016-12-09 12:19:02', NULL, NULL),
(2, '1001', 'Chicken Burger', 70.00, 3, 210.000, '201612091', 'sales', '2016-12-09 12:19:02', NULL, NULL),
(3, '1002', 'Vegetable Burger', 50.00, 3, 150.000, '201612091', 'sales', '2016-12-09 12:19:02', NULL, NULL),
(4, '1003', 'Pizza', 40.00, 3, 120.000, '201612091', 'sales', '2016-12-09 12:19:02', NULL, NULL),
(5, '1000', 'Samusa', 10.00, 12, 120.000, '201612101', 'sales', '2016-12-10 01:02:43', NULL, NULL),
(6, '1003', 'Pizza', 40.00, 6, 240.000, '201612101', 'sales', '2016-12-10 01:02:43', NULL, NULL),
(7, '1001', 'Chicken Burger', 70.00, 3, 210.000, '201612102', 'sales', '2016-12-10 01:03:04', NULL, NULL),
(8, '1002', 'Vegetable Burger', 50.00, 3, 150.000, '201612102', 'sales', '2016-12-10 01:03:04', NULL, NULL),
(9, '1001', 'Chicken Burger', 70.00, 10, 700.000, '201612103', 'sales', '2016-12-10 01:03:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tor_productsell_master`
--

CREATE TABLE `tor_productsell_master` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(15) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `invoice_day` varchar(12) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `totalprice` float(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tor_productsell_master`
--

INSERT INTO `tor_productsell_master` (`id`, `invoice_no`, `invoice_date`, `customer_name`, `invoice_day`, `created_by`, `created_date`, `modified_by`, `modified_date`, `totalprice`) VALUES
(1, '201612091', '2016-12-09', NULL, 'Friday', 'sales', '2016-12-09 12:19:02', NULL, NULL, 540.000),
(2, '201612101', '2016-12-10', NULL, 'Satday', 'sales', '2016-12-10 01:02:43', NULL, NULL, 360.000),
(3, '201612102', '2016-12-10', NULL, 'Satday', 'sales', '2016-12-10 01:03:04', NULL, NULL, 360.000),
(4, '201612103', '2016-12-10', NULL, 'Satday', 'sales', '2016-12-10 01:03:15', NULL, NULL, 700.000);

-- --------------------------------------------------------

--
-- Table structure for table `tor_userinfo`
--

CREATE TABLE `tor_userinfo` (
  `id` int(11) NOT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `pword` varchar(255) DEFAULT NULL,
  `userrole` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'active',
  `created_by` varchar(50) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `privilege` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tor_userinfo`
--

INSERT INTO `tor_userinfo` (`id`, `display_name`, `username`, `pword`, `userrole`, `status`, `created_by`, `created_time`, `modified_by`, `modified_time`, `privilege`) VALUES
(1, 'Admin', 'admin', '$2y$10$VEV9.gYxuU7bcmM7.ONZde2oH1dS8eFVo9xrzgrapXhmTTsgpmKE6', 'admin', 'active', 'manager', '2016-12-10 13:43:30', NULL, NULL, 'createuser##product##addproduct##productlist'),
(2, 'Manager', 'manager', '$2y$10$VEV9.gYxuU7bcmM7.ONZde2oH1dS8eFVo9xrzgrapXhmTTsgpmKE6', 'manager', 'active', 'System', '2016-12-03 13:33:24', NULL, NULL, 'report##dailysell##overallsell'),
(3, 'Sales', 'sales', '$2y$10$VEV9.gYxuU7bcmM7.ONZde2oH1dS8eFVo9xrzgrapXhmTTsgpmKE6', 'sales', 'active', 'manager', '2016-12-03 13:45:25', NULL, NULL, 'sales##sellproduct');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tor_productinfo`
--
ALTER TABLE `tor_productinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `tor_productsell_details`
--
ALTER TABLE `tor_productsell_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tor_productsell_master`
--
ALTER TABLE `tor_productsell_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tor_userinfo`
--
ALTER TABLE `tor_userinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tor_productinfo`
--
ALTER TABLE `tor_productinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tor_productsell_details`
--
ALTER TABLE `tor_productsell_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tor_productsell_master`
--
ALTER TABLE `tor_productsell_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tor_userinfo`
--
ALTER TABLE `tor_userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
