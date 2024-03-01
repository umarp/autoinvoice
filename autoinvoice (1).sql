-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2024 at 04:12 PM
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
-- Database: `autoinvoice`
--
CREATE DATABASE IF NOT EXISTS `autoinvoice` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `autoinvoice`;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `c_id` int(11) NOT NULL,
  `c_firstName` varchar(100) NOT NULL,
  `c_lastName` varchar(100) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_phone` int(11) NOT NULL,
  `c_address` varchar(100) NOT NULL,
  `c_dob` date NOT NULL,
  `c_dateAdded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`c_id`, `c_firstName`, `c_lastName`, `c_email`, `c_phone`, `c_address`, `c_dob`, `c_dateAdded`) VALUES
(2, 'Umar', 'Panchoo', 'Lemail@gmail.com', 57705507, 'royal road, qb', '2024-02-14', '2024-02-15');

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

CREATE TABLE `customer_login` (
  `cl_id` int(11) NOT NULL,
  `cl_firstName` varchar(100) NOT NULL,
  `cl_lastName` varchar(100) NOT NULL,
  `cl_email` varchar(100) NOT NULL,
  `cl_password` varchar(200) NOT NULL,
  `cl_supplierCustomerId` int(100) NOT NULL,
  `cl_type` varchar(100) NOT NULL,
  `cl_dateAdded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_login`
--

INSERT INTO `customer_login` (`cl_id`, `cl_firstName`, `cl_lastName`, `cl_email`, `cl_password`, `cl_supplierCustomerId`, `cl_type`, `cl_dateAdded`) VALUES
(1, 'Umar', 'Panchoo', 'umar@email.com', '$2y$10$L8at5o.DMLPIlpDw8N3SouKfLXIPhLRnx3BRXbjOqWS0hbD5abcVq', 2, 'Supplier', '2021-02-24'),
(4, 'james', 'Donald', 'james@donald.com', '$2y$10$d2saL2W6MNbZ6P0ii3T9c.UeX49EyswANoB7XS2W4mKHEtynrphwa', 5, 'Supplier', '2021-02-24'),
(5, 'Sony', 'Play', 'sony@play.com', '$2y$10$1LO5wx/x4CEN9odotlOH1.qBtHoAzSjubs3rrb2/6KFNa3oufLzbi', 2, 'Client', '2021-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_note`
--

CREATE TABLE `delivery_note` (
  `d_id` int(11) NOT NULL,
  `d_refference` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_note`
--

INSERT INTO `delivery_note` (`d_id`, `d_refference`) VALUES
(1, 'ref1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `i_id` int(11) NOT NULL,
  `i_refference` varchar(20) NOT NULL,
  `i_clientId` int(11) NOT NULL,
  `i_currency` varchar(50) NOT NULL,
  `i_subTotal` float NOT NULL,
  `i_vatAmount` float NOT NULL,
  `i_total` float NOT NULL,
  `i_remarks` varchar(250) NOT NULL,
  `i_user` varchar(100) NOT NULL,
  `i_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `ip_id` int(11) NOT NULL,
  `ip_description` varchar(250) NOT NULL,
  `ip_quantity` int(11) NOT NULL,
  `ip_unitPrice` int(11) NOT NULL,
  `ip_totalPrice` varchar(250) NOT NULL,
  `ip_i_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `l_id` int(100) NOT NULL,
  `l_firstName` varchar(100) NOT NULL,
  `l_lastName` varchar(100) NOT NULL,
  `l_email` varchar(100) NOT NULL,
  `l_password` varchar(500) NOT NULL,
  `l_department` varchar(50) NOT NULL,
  `l_invoice` int(11) NOT NULL,
  `l_purchaseOrder` int(11) NOT NULL,
  `l_deliveryNote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`l_id`, `l_firstName`, `l_lastName`, `l_email`, `l_password`, `l_department`, `l_invoice`, `l_purchaseOrder`, `l_deliveryNote`) VALUES
(1, 'Umar 101', 'Panchoo', 'umar@email.com', '$2y$10$EzhLX8hkBgeWjWMIWzpKc.kZpMijNO/xNdeS/f1pRtOB12s9bP9Ry', 'hr', 1, 1, 1),
(2, 'jamesaa', 'yasakili', 'asdas@com.com', '$2y$10$3z7X7.UK9zsx0sOyaV.0y.5VzpLlV1f2fJh10cSye1zqFTd5WEVD2', 'finance', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `o_id` int(11) NOT NULL,
  `o_name` varchar(100) NOT NULL,
  `o_description` varchar(300) NOT NULL,
  `o_value` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`o_id`, `o_name`, `o_description`, `o_value`) VALUES
(1, 'Logo', 'Logo use in pdf, sidebar and login screen', 'image/logo/logo-black.png'),
(2, 'Purchase order message', 'Purchase order message than appears on the bottom', 'nice'),
(3, 'Invoice message', 'Invoice message than appears on the bottom', 'Thank you for your collaboration!'),
(4, 'Delivery note message', 'Delivery note message than appears on the bottom', 'Thank you for your collaboration!'),
(5, 'Company Name', 'Organisation name', 'AutoInvoice'),
(6, 'VAT', 'vat', '12248834'),
(7, 'BRN', 'brn', 'C37581322'),
(8, 'Address', 'Address', 'Royal Road, Quatre Bornes'),
(9, 'Phone', 'Phone Number', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `po_products`
--

CREATE TABLE `po_products` (
  `pop_id` int(11) NOT NULL,
  `pop_description` varchar(250) NOT NULL,
  `pop_quantity` int(11) NOT NULL,
  `pop_unitPrice` int(11) NOT NULL,
  `pop_totalPrice` int(11) NOT NULL,
  `pop_remarks` varchar(250) NOT NULL,
  `pop_po_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `po_products`
--

INSERT INTO `po_products` (`pop_id`, `pop_description`, `pop_quantity`, `pop_unitPrice`, `pop_totalPrice`, `pop_remarks`, `pop_po_id`) VALUES
(1, 'asd', 3, 43, 129, '', 2),
(2, 'asd2', 3, 44, 132, '', 2),
(40, 'asd', 444, 10, 4440, '', 6),
(41, 'car', 100, 2, 200, '', 6),
(42, 'boat', 1000, 4, 4000, '', 6),
(43, 'laptop', 10, 1000, 10000, '', 7),
(44, 'charger', 5, 300, 1500, '', 7),
(45, 'car', 2, 444, 888, '', 8),
(46, 'car', 12, 33, 396, '', 9);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `po_id` int(11) NOT NULL,
  `po_refference` varchar(20) NOT NULL,
  `po_supplierId` int(11) NOT NULL,
  `po_currency` varchar(50) NOT NULL,
  `po_subTotal` float NOT NULL,
  `po_vatAmount` float NOT NULL,
  `po_total` float NOT NULL,
  `po_remarks` varchar(250) NOT NULL,
  `po_supplierAttn` varchar(100) NOT NULL,
  `po_companyAttn` varchar(100) NOT NULL,
  `po_user` varchar(100) NOT NULL,
  `po_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`po_id`, `po_refference`, `po_supplierId`, `po_currency`, `po_subTotal`, `po_vatAmount`, `po_total`, `po_remarks`, `po_supplierAttn`, `po_companyAttn`, `po_user`, `po_date`) VALUES
(6, '5', 2, 'MUR', 8640, 1296, 9936, '                                                    ', 'Alfred', 'Kinsley', 'currency', '2018-02-24'),
(7, '6', 2, '1', 11500, 1725, 13225, '', '', '', 'currency', '2019-02-24'),
(8, '7', 2, 'MUR', 888, 133.2, 1021.2, 'good', '', '', 'currency', '2026-02-24'),
(9, '8', 2, 'MUR', 396, 59.4, 455.4, 'good', '', '', 'currency', '2026-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_email` varchar(100) NOT NULL,
  `s_address` varchar(100) NOT NULL,
  `s_phone` int(11) NOT NULL,
  `s_country` varchar(100) NOT NULL,
  `s_dateAdded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`s_id`, `s_name`, `s_email`, `s_address`, `s_phone`, `s_country`, `s_dateAdded`) VALUES
(1, 'alpha', 'Lemail@gmail.com', 'dsfdfsdfs', 123456, '', '2024-02-12'),
(2, 'HP', 'hp@gmail.com', 'Paris', 123456, '', '2024-02-12'),
(5, 'Microsoft', 'Microsofft@gmail.com', 'dsfdfsdfs', 123456, '', '2024-02-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD PRIMARY KEY (`cl_id`);

--
-- Indexes for table `delivery_note`
--
ALTER TABLE `delivery_note`
  ADD PRIMARY KEY (`d_id`) USING BTREE;

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`i_id`) USING BTREE;

--
-- Indexes for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`ip_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `po_products`
--
ALTER TABLE `po_products`
  ADD PRIMARY KEY (`pop_id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`po_id`) USING BTREE;

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_login`
--
ALTER TABLE `customer_login`
  MODIFY `cl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_note`
--
ALTER TABLE `delivery_note`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `po_products`
--
ALTER TABLE `po_products`
  MODIFY `pop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
