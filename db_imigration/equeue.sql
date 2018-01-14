-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2018 at 05:37 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `equeue`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `current_queued_user_id` int(11) DEFAULT NULL,
  `current_queue_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `username`, `password`, `category`, `name`, `address`, `current_queued_user_id`, `current_queue_number`) VALUES
(1, 'antman', 'e10adc3949ba59abbe56e057f20f883e', 0, 'mki', 'gewrgiou', NULL, 0),
(2, 'antman', 'e10adc3949ba59abbe56e057f20f883e', 0, 'mki', 'gewrgiou', NULL, 0),
(3, 'antman', 'e10adc3949ba59abbe56e057f20f883e', 0, 'mki', 'gewrgiou', 8, 1),
(4, 'lop1234', 'e10adc3949ba59abbe56e057f20f883e', 0, 'MMKIGRUPPE', 'sdsds', NULL, 0),
(5, 'fotini', 'e10adc3949ba59abbe56e057f20f883e', 1, 'mars', 'tsimiski', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_companies`
--

CREATE TABLE `oauth_companies` (
  `company_id` int(11) NOT NULL,
  `token` varchar(555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_companies`
--

INSERT INTO `oauth_companies` (`company_id`, `token`) VALUES
(1, '327586da04d98c8d294110ca1aae0f9d45669ebb'),
(2, 'e28721b99dce942098a8b4298342c7a6b0125566'),
(3, '5582a24c3597e9e11a0b92b736417a83fe201ccf'),
(4, '5582a24c3597e9e11a0b92b736417a83fe201ccf');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `user_id` int(11) NOT NULL,
  `token` varchar(555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oauth_users`
--

INSERT INTO `oauth_users` (`user_id`, `token`) VALUES
(8, '3d0466bcdbb74465e96ab86ca18380966e273d39'),
(9, '33af72b62f83a28df4496c5a9de274ae9321a1c9'),
(10, 'eb7da1edf7a6f7e97efd8af8494d9334d182ae89');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`) VALUES
(8, 'fot', 'g', 'lol@ex.com', 'fotini', 'e10adc3949ba59abbe56e057f20f883e'),
(9, 'fot', 'g', 'lol@ex.com', 'fotini', 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'lolcaa', 'asddff', 'ant@ex.com', 'antman123', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `users_companies`
--

CREATE TABLE `users_companies` (
  `users_companies_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `queue_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_companies`
--

INSERT INTO `users_companies` (`users_companies_id`, `user_id`, `company_id`, `queue_number`) VALUES
(1, 8, 3, 1),
(3, 8, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `oauth_companies`
--
ALTER TABLE `oauth_companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_companies`
--
ALTER TABLE `users_companies`
  ADD PRIMARY KEY (`users_companies_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `oauth_companies`
--
ALTER TABLE `oauth_companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `oauth_users`
--
ALTER TABLE `oauth_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users_companies`
--
ALTER TABLE `users_companies`
  MODIFY `users_companies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
