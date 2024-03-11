-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 07:45 PM
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
(2, 'Fill', 'Joseph', 'fill@gmail.com', 57705507, 'royal road, qb', '2024-02-14', '2024-02-15'),
(3, 'Alfred', 'Jonas', 'alfred.jonas@email.com', 45789612, 'Royal Road, Rose Hill', '1989-06-22', '2024-03-05'),
(6, 'Robert', 'Michael', 'robert@gmail.com', 321654789, 'Paris, France', '1995-12-05', '2024-03-10'),
(7, 'Christopher', 'Charles', 'cc@gmail.com', 654789132, 'Curepipe', '1985-09-11', '2024-03-10');

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
(1, 'Umar', 'Panchoo', 'umar@email.com', '$2y$10$sUJULc9Sva4.01Udn6VKLuJBhySYtcduM5cGLzLGU70Vmv1Emk41G', 2, 'Supplier', '2021-02-24'),
(4, 'james', 'Donald', 'james@donald.com', '$2y$10$d2saL2W6MNbZ6P0ii3T9c.UeX49EyswANoB7XS2W4mKHEtynrphwa', 5, 'Supplier', '2021-02-24'),
(5, 'Sony', 'Play', 'sony@play.com', '$2y$10$1LO5wx/x4CEN9odotlOH1.qBtHoAzSjubs3rrb2/6KFNa3oufLzbi', 2, 'Client', '2021-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_note`
--

CREATE TABLE `delivery_note` (
  `d_id` int(11) NOT NULL,
  `d_refference` varchar(20) NOT NULL,
  `d_clientId` int(11) NOT NULL,
  `d_user` int(100) NOT NULL,
  `d_date` date NOT NULL,
  `d_remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_note`
--

INSERT INTO `delivery_note` (`d_id`, `d_refference`, `d_clientId`, `d_user`, `d_date`, `d_remarks`) VALUES
(5, '2', 2, 1, '2024-03-03', '                                                                                                                                                                                    ok                                                                    '),
(6, '3', 2, 1, '2024-03-03', '                                                                                                                                                '),
(10, '4', 2, 1, '2024-03-10', ''),
(11, '5', 7, 1, '2024-03-10', ''),
(12, '6', 0, 1, '2024-03-11', ''),
(13, '7', 0, 1, '2024-03-11', ''),
(14, '8', 0, 1, '2024-03-11', ''),
(15, '9', 0, 1, '2024-03-11', ''),
(16, '10', 0, 1, '2024-03-11', ''),
(17, '10', 6, 1, '2024-03-11', ''),
(18, '10', 6, 1, '2024-03-11', '');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_products`
--

CREATE TABLE `delivery_products` (
  `dp_id` int(11) NOT NULL,
  `dp_description` varchar(250) NOT NULL,
  `dp_quantity` int(11) NOT NULL,
  `dp_remarks` varchar(250) NOT NULL,
  `dp_d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_products`
--

INSERT INTO `delivery_products` (`dp_id`, `dp_description`, `dp_quantity`, `dp_remarks`, `dp_d_id`) VALUES
(20, 'laptop', 4, '', 10),
(21, 'Charger', 2, '', 11),
(24, 'car', 33, 'red', 6),
(26, '', 0, '', 13),
(27, 'asda', 343, 'qwert', 5),
(28, 'aas', 32, '', 17),
(29, 'aas', 32, '', 18);

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
  `i_user` int(11) NOT NULL,
  `i_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`i_id`, `i_refference`, `i_clientId`, `i_currency`, `i_subTotal`, `i_vatAmount`, `i_total`, `i_remarks`, `i_user`, `i_date`) VALUES
(4, '1', 2, 'MUR', 1815, 272.25, 2087.25, '                            good                        ', 1, '2029-02-24'),
(5, '2', 2, 'MUR', 2000, 300, 2300, 'blue laptop', 2, '2003-03-24'),
(22, '10', 2, 'MUR', 14652, 2197.8, 16849.8, '                                                    ', 1, '2003-03-24'),
(23, '10', 2, 'MUR', 14652, 2197.8, 16849.8, '                                                    ', 1, '2003-03-24'),
(24, '6', 3, 'MUR', 1452, 217.8, 1669.8, '', 1, '2024-03-09'),
(25, '7', 2, 'MUR', 14212, 2131.8, 16343.8, '', 1, '2024-03-09'),
(28, '10', 2, 'MUR', 31260.9, 4689.13, 35950, '                                                                                                                                                                                                                ', 1, '2024-03-10'),
(29, '8', 6, 'MUR', 12, 1.8, 13.8, '', 1, '2024-03-11'),
(30, '9', 6, 'MUR', 12, 1.8, 13.8, '', 1, '2024-03-11'),
(31, '10', 6, 'MUR', 132, 19.8, 151.8, '', 1, '2024-03-11');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `ip_id` int(11) NOT NULL,
  `ip_description` varchar(250) NOT NULL,
  `ip_quantity` int(11) NOT NULL,
  `ip_unitPrice` int(11) NOT NULL,
  `ip_totalPrice` int(11) NOT NULL,
  `ip_remarks` varchar(250) NOT NULL,
  `ip_i_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_products`
--

INSERT INTO `invoice_products` (`ip_id`, `ip_description`, `ip_quantity`, `ip_unitPrice`, `ip_totalPrice`, `ip_remarks`, `ip_i_id`) VALUES
(12, 'laptop', 2, 1000, 2000, '', 5),
(22, '33', 2, 44, 88, '', 15),
(23, '33', 2, 44, 88, '', 16),
(24, '33', 2, 44, 88, '', 17),
(25, '33', 2, 44, 88, '', 18),
(26, '33', 2, 44, 88, '', 19),
(27, '33', 2, 44, 88, '', 20),
(31, 'aa', 33, 44, 1452, '', 24),
(32, 'aa', 323, 44, 14212, '', 25),
(35, 'laptop', 444, 33, 14652, '', 23),
(36, 'laptop', 444, 33, 14652, '', 22),
(41, 'car', 33, 33, 1089, '', 4),
(42, 'laptop', 33, 22, 726, '', 4),
(50, 'Mouse', 20, 899, 17980, '', 28),
(51, 'Keyboard', 10, 999, 9990, '', 28),
(52, 'Type c cable', 20, 399, 7980, '', 28),
(53, 'aa', 3, 4, 12, '', 29),
(54, 'a', 3, 4, 12, '', 30),
(55, 'a', 3, 44, 132, '', 31);

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
  `l_role` varchar(50) NOT NULL,
  `l_invoice` int(11) NOT NULL,
  `l_purchaseOrder` int(11) NOT NULL,
  `l_deliveryNote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`l_id`, `l_firstName`, `l_lastName`, `l_email`, `l_password`, `l_role`, `l_invoice`, `l_purchaseOrder`, `l_deliveryNote`) VALUES
(1, 'Umar ', 'Panchoo', 'umar@email.com', '$2y$10$mFCG8cHzdo/YtKLFmVnc3e3VZM7AzTgmzA/WKLYH6anDqhUU7x5DO', 'Admin', 1, 1, 1),
(2, 'James', 'yasakili', 'james@gmail.com', '$2y$10$qjmcUCECjfGW06p0C6e7s.GjeR0N/28HKI4EPKww5oI8MltPm3NMO', 'Staff', 1, 1, 1),
(4, 'Jean', 'Piere', 'jean@email.com', '$2y$10$JZeh.eHDKKhhzwX1M/PrSu7A3p/tquLD.3arNWmJFjmRiZKsw6lXm', 'Manager', 1, 1, 1),
(6, 'Admin', 'Admin', 'admin@email.com', '$2y$10$ZmLPSbdg4ixd333Uvs6laOhSISjnwQgfEtEvS520381RQtP0OydiC', 'Admin', 1, 1, 1);

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
(1, 'Logo', 'Logo use in pdf, sidebar and login screen', 'image/logo/logo-color.png'),
(2, 'Purchase order message', 'Purchase order message than appears on the bottom', 'Thank you for your collaboration!'),
(3, 'Invoice message', 'Invoice message than appears on the bottom', 'Thank you for your collaboration!'),
(4, 'Delivery note message', 'Delivery note message than appears on the bottom', 'Thank you for your collaboration!'),
(5, 'Company Name', 'Organisation name', 'AutoInvoice'),
(6, 'VAT', 'vat', '12345678'),
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
(43, 'laptop', 10, 1000, 10000, '', 7),
(44, 'charger', 5, 300, 1500, '', 7),
(48, 'laptop lenovo', 10, 36000, 360000, '', 11),
(49, 'ww', 33, 444, 14652, '', 12),
(50, 'ww', 33, 444, 14652, '', 13),
(51, '33', 22, 33, 726, '', 14),
(52, '33', 22, 33, 726, '', 15),
(53, '34', 445, 555, 246975, '', 16),
(58, 'asd', 10, 444, 4440, '', 6),
(59, 'car', 2, 100, 200, '', 6),
(60, 'boat', 4, 1000, 4000, '', 6),
(61, 'car', 444, 2, 888, '', 8),
(62, 'boat', 123, 44, 5412, '', 8),
(63, 'car', 33, 12, 396, '', 9),
(64, 'asd', 2, 3, 6, '', 9),
(65, 'a', 3, 4, 12, '', 40),
(66, 'a', 3, 4, 12, '', 41);

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
  `po_user` int(11) NOT NULL,
  `po_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`po_id`, `po_refference`, `po_supplierId`, `po_currency`, `po_subTotal`, `po_vatAmount`, `po_total`, `po_remarks`, `po_supplierAttn`, `po_companyAttn`, `po_user`, `po_date`) VALUES
(6, '5', 1, '1', 8640, 1296, 9936, '                                                                                                        ', '', '', 1, '2018-02-24'),
(7, '6', 2, '1', 11500, 1725, 13225, '', '', '', 1, '2019-02-24'),
(8, '7', 2, '1', 6300, 945, 7245, 'good                        ', '', '', 1, '2026-02-24'),
(9, '8', 1, '1', 402, 60.3, 462.3, '                            good                        ', '', '', 1, '2026-02-24'),
(28, '10', 1, '1', 4, 0.6, 4.6, '', '', '', 1, '2024-03-09'),
(29, '9', 2, '1', 8998, 1349.7, 10347.7, '', '', '', 1, '2024-03-10'),
(35, '10', 0, '1', 0, 0, 0, '', '', '', 1, '2024-03-11'),
(36, '10', 0, '1', 0, 0, 0, '', '', '', 1, '2024-03-11'),
(40, '10', 1, '1', 12, 1.8, 13.8, '', '', '', 1, '2011-03-24'),
(41, '10', 1, '1', 12, 1.8, 13.8, '', '', '', 1, '2011-03-24');

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
-- Indexes for table `delivery_products`
--
ALTER TABLE `delivery_products`
  ADD PRIMARY KEY (`dp_id`);

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
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_login`
--
ALTER TABLE `customer_login`
  MODIFY `cl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_note`
--
ALTER TABLE `delivery_note`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `delivery_products`
--
ALTER TABLE `delivery_products`
  MODIFY `dp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `l_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `po_products`
--
ALTER TABLE `po_products`
  MODIFY `pop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
