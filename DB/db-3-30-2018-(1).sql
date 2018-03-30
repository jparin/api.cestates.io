-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2018 at 09:49 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cestates`
--
CREATE DATABASE IF NOT EXISTS `cestates` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cestates`;

-- --------------------------------------------------------

--
-- Table structure for table `cet_api_list`
--

CREATE TABLE `cet_api_list` (
  `cet_api_id` int(11) UNSIGNED NOT NULL,
  `cet_api_name` varchar(255) NOT NULL,
  `cet_api_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cet_api_list`
--

INSERT INTO `cet_api_list` (`cet_api_id`, `cet_api_name`, `cet_api_key`) VALUES
(1, 'CET Marketplace', 'aTIWjdxBnLG6PxDTU3xfxSdn4Nfa8G4y');

-- --------------------------------------------------------

--
-- Table structure for table `cet_properties`
--

CREATE TABLE `cet_properties` (
  `cet_property_id` int(11) UNSIGNED NOT NULL,
  `cet_property_name` varchar(255) NOT NULL,
  `cet_property_description` varchar(255) NOT NULL,
  `cet_property_map` varchar(255) NOT NULL,
  `cet_property_price` double(10,6) NOT NULL,
  `cet_property_address` varchar(255) NOT NULL,
  `cet_property_type` enum('Condominium','Residential') NOT NULL DEFAULT 'Condominium',
  `cet_property_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cet_property_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cet_properties_images`
--

CREATE TABLE `cet_properties_images` (
  `cet_pimages_id` int(11) UNSIGNED NOT NULL,
  `cet_pimages_property_id` int(11) NOT NULL,
  `cet_pimages_link` varchar(255) NOT NULL,
  `cet_pimages_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cet_pimages_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cet_users`
--

CREATE TABLE `cet_users` (
  `cet_user_id` int(11) UNSIGNED NOT NULL,
  `cet_user_fname` varchar(100) NOT NULL,
  `cet_user_mname` varchar(100) NOT NULL,
  `cet_user_lname` varchar(100) NOT NULL,
  `cet_user_email` varchar(100) NOT NULL,
  `cet_user_password` varchar(180) NOT NULL,
  `cet_user_address` varchar(100) NOT NULL,
  `cet_user_city` varchar(100) NOT NULL,
  `cet_user_province` varchar(100) NOT NULL,
  `cet_user_first_verification` tinyint(1) NOT NULL DEFAULT '0',
  `cet_user_second_verification` tinyint(1) NOT NULL DEFAULT '0',
  `cet_user_email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `cet_user_hash` varchar(200) NOT NULL DEFAULT '0',
  `cet_user_birthday` date NOT NULL,
  `cet_user_mobile` varchar(100) NOT NULL,
  `cet_user_telephone` varchar(100) NOT NULL,
  `cet_user_nem_address` varchar(100) NOT NULL,
  `cet_user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cet_user_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cet_user_archived` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cet_api_list`
--
ALTER TABLE `cet_api_list`
  ADD KEY `cet_api_id` (`cet_api_id`);

--
-- Indexes for table `cet_properties`
--
ALTER TABLE `cet_properties`
  ADD KEY `cet_property_id` (`cet_property_id`);

--
-- Indexes for table `cet_properties_images`
--
ALTER TABLE `cet_properties_images`
  ADD KEY `cet_pimages_id` (`cet_pimages_id`);

--
-- Indexes for table `cet_users`
--
ALTER TABLE `cet_users`
  ADD KEY `cet_user_id` (`cet_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cet_api_list`
--
ALTER TABLE `cet_api_list`
  MODIFY `cet_api_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cet_properties`
--
ALTER TABLE `cet_properties`
  MODIFY `cet_property_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cet_properties_images`
--
ALTER TABLE `cet_properties_images`
  MODIFY `cet_pimages_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cet_users`
--
ALTER TABLE `cet_users`
  MODIFY `cet_user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
