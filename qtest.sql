-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2021 at 03:06 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(512) NOT NULL,
  `access_level` varchar(16) NOT NULL,
  `access_code` text DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending,1=confirmed',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='admin and customer users';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `access_level`, `access_code`, `status`, `created`, `modified`) VALUES
(1, 'Goran', 'Stevanović', 'goranmstevanovic@gmail.com', '$2y$10$dU5nSjzt6.lehmS5yJdFB.b6pccPXXmosFnMys/4hbNv6MxXGt/PG', 'Customer', '', 1, '2019-10-11 16:47:08', '2021-08-31 08:31:33'),
(15, 'Milica', 'Jovanovic', 'milica@milica.com', '$2y$10$D.GjAybdqe9klUg6CqEJ7.rNYDU5iCnD05kDSK6QXV1Guhrtji/b2', 'Customer', NULL, 1, '2021-08-31 11:28:21', '2021-08-31 09:28:21'),
(16, 'Milica', 'Jovanovic', 'milica1@milica.com', '$2y$10$.nfzfgOg0KCfam2QHPn0Puc5/1WX13SsaIilOob./lb8Fn.yteWsa', 'Customer', NULL, 1, '2021-08-31 11:29:02', '2021-08-31 09:29:02'),
(17, 'Milan', 'jovanocivi', 'milan@milan.com', '$2y$10$XhqK5RGZHgjNojkgH.S5Xelhm2Uqd0GRoRyZHBJFOgn6U86R47UM6', 'Customer', NULL, 1, '2021-08-31 11:47:11', '2021-08-31 09:47:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
