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
(1, '???@+??7???J????k???I,??.!?)??k??t?u?*Q\\??t???????L9??tD??g?<bWo??%t&?$Z?q?ZZ$??????lH?z?[Z?;???28S?jO??y??iZ??D??5I?y???6J??@???Ms??@????g????ST???Z/2?????s-k???S\n?k;????B??Q\r?0?Q?%\\?P???6Hh}??J?0P78???<@?ida????bR?n?n???|??'),
(2, 'ea452a6c2e45daed4cbc47790df87cd696fe3f190e0df4d92f6f1c122529df2a5e66b0e7b39a7f4e2092912c611bb1bf82ead247a44260c2e0bd4e89b3714a59a14cf8ffa5646d31735dd87be286a147c1dc76ee559f258519f361a1ce268f54b259d0d8c02e06d393eda3541826b68ec7622d2355815d1399c903e0e20adb49617b60b0064b64670d4cdb5ab7b4ebfb495ba94c03915ccf01fed8c1c9a39934c0b5f612264bc372a6673ef09d030a098a98d557d078ab2a25276a0dc5e7fe3c5790f8b92a9e01881da107ad417f6e5c49cb50b3b59f33f85ca207b4aac9373ac9842ed11da0512df7bffe3548bf039f0b175e6a76f2139c1eab68bb57280c'),
(4, 'a12332af71e7b2e7febc804e31bc15bef7e24698'),
(5, '99947960d9b503b51ec192f9386c26dc3c8d7bc1'),
(6, '80e889f892341684f754f9293d7781d43cb49fc1'),
(7, '78e5c5c018d6d52521cb238a6b30d8fd50f7a1ae'),
(8, '3d0466bcdbb74465e96ab86ca18380966e273d39'),
(9, '33af72b62f83a28df4496c5a9de274ae9321a1c9'),
(10, 'eb7da1edf7a6f7e97efd8af8494d9334d182ae89'),
(11, '76a7d98a3571c4403468be6c92fa225c64bf92f1'),
(12, '848779c69c356cfc3f377a6a8fe414e551d57a6e'),
(13, 'c4e32536c39cd6485b019c6b92ed751f2a431b1c'),
(14, 'a0d7ee46962e58a54c4ff637a4677c4ccdab4fa5'),
(15, '13f7c04bb0f90e95b0fe2bd35dc1dae75313bdee'),
(16, 'a92f955127413fe0b92c368f84f6800278797613'),
(17, '9b6e56cd49f8d2f3c212fb5554c8a08b5d37e2d9'),
(18, 'ed315fcd855a3df67bf23eb5908243641e754801'),
(19, '964c2c0291c0116c0258a83079acedc2d9a27a11'),
(20, '357cc6ca195700e8e6f5710ecc36ed4b4ee8fb88'),
(21, '0518ceda080f173a454d99b9ac54ee94f8367680'),
(22, '4fcc23618aea07b2ac343320c88d5242d33e6b82'),
(23, '866630639f7841302c55c88a4796363d9e79ae34'),
(24, '21389c52fce7776a44ee929ea2c827dd2d3ea311'),
(25, '59cefb2fb90d6a1aa333297971cedd9d1dfdedc7'),
(26, 'ccc63f74930f79346e729bdf262674c7a9a51732'),
(27, '8bb1ee71ac881243937e317fa9633791917c5aed'),
(28, '407b84eb8fd8f29e92146cf98ea879255d10d364'),
(29, '8c7a0afb17169eba2a3867058a0796d35804422e'),
(30, '878402554afc679156785261b57a853ac12349a8'),
(31, '19b87702a05e31d202857b8e70dc85b209e0e2f1'),
(32, 'c2baf9b293cca9a06c33c5f48d17087cad4614f5'),
(33, '8a6d03060f74c47f0c54a524da8d8cf0f5188756');

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
(1, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(2, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(3, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(4, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(5, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(6, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
(7, 'fot', 'g', 'lol@ex.com', 'fotini', '123456'),
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
