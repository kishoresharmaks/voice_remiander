-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2024 at 08:05 PM
-- Server version: 10.6.18-MariaDB
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `callshod_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_calls`
--

CREATE TABLE `scheduled_calls` (
  `id` int(11) NOT NULL,
  `user_date` date NOT NULL,
  `user_time` time NOT NULL,
  `user_text` varchar(255) DEFAULT NULL,
  `recognized_text` text DEFAULT NULL,
  `utc_datetime` datetime DEFAULT NULL,
  `call_status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `scheduled_calls`
--

INSERT INTO `scheduled_calls` (`id`, `user_date`, `user_time`, `user_text`, `recognized_text`, `utc_datetime`, `call_status`) VALUES
(184, '2024-05-18', '12:43:57', '', 'this is greatest example of voice message 43', '2024-05-18 07:13:57', 'completed'),
(185, '2024-05-18', '12:45:06', 'this is greatest example of text message 45	', '', '2024-05-18 07:15:06', 'completed'),
(186, '2024-05-18', '12:48:25', 'this is greatest example of text message 50	', '', '2024-05-18 07:18:25', 'completed'),
(187, '2024-05-18', '13:21:46', '', 'Hello.', '2024-05-18 07:51:46', 'completed'),
(188, '2024-05-18', '13:22:11', 'loki mama ', '', '2024-05-18 07:52:11', 'completed'),
(189, '2024-05-18', '13:23:54', '', 'Hello guys. How are you? Hello.', '2024-05-18 07:53:54', 'completed'),
(193, '2024-05-18', '13:27:27', '', 'Hello everyone this is about your new thing that I can.', '2024-05-18 07:57:27', 'completed'),
(194, '2024-05-18', '13:27:27', '', 'Hello everyone this is about your new thing that I can.', '2024-05-18 07:57:27', 'completed'),
(195, '2024-05-18', '13:34:49', '', 'This is the birthday thing that we can easily understand, that we can use that many more things. This is all about the new thing.', '2024-05-18 08:04:49', 'completed'),
(196, '2024-05-18', '13:32:59', '', 'Hello guys. This is Carl. About the new things that can make you love yet as more as us.', '2024-05-18 08:02:59', 'completed'),
(197, '2024-05-19', '20:40:32', 'Dei Mahesh Go and Eat eat eat man go hostel', '', '2024-05-19 15:10:32', 'completed'),
(198, '2024-05-20', '12:18:51', '', 'Arivu Mere ilakeyana', '2024-05-20 06:48:51', 'completed'),
(200, '2024-05-26', '12:15:00', 'Hello ', '', '2024-05-26 06:45:00', 'completed'),
(201, '2024-05-26', '12:18:06', '', 'hey hello how are you it\'s fine now', '2024-05-26 06:48:06', 'completed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scheduled_calls`
--
ALTER TABLE `scheduled_calls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scheduled_calls`
--
ALTER TABLE `scheduled_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
