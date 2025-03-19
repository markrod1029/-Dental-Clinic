-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2022 at 04:33 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doctor_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`id`, `email`, `password`, `admin_name`, `address`, `phone`, `photo`, `chat_status`) VALUES
(1, 'admin@gmail.com', '$2y$10$teAFII70aESLjw89PQsks.Y/lwtXaC7I.Q7B5EEQSmgiuU/jYsZZe', 'Cristian Bio', 'Lilimasan', '7657657567', '../images/10872.jpg', 'Offline now');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_table`
--

CREATE TABLE `appointment_table` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_schedule_id` int(11) NOT NULL,
  `appointment_number` int(11) NOT NULL,
  `reason_for_appointment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `appointment_time` time NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_come_into_hospital` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
  `doctor_comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `disease` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `doctor_id`, `patient_id`, `doctor_schedule_id`, `appointment_number`, `reason_for_appointment`, `appointment_time`, `status`, `patient_come_into_hospital`, `doctor_comment`, `disease`, `date`) VALUES
(17, 7, 10, 36, 1000, 'adsds', '22:14:00', 'Completed', 'Yes', '3x biogesic', 'dengue', '2022-10-19'),
(18, 7, 5, 36, 1001, 'ssdsad', '35:46:44', 'Completed', 'Yes', 'sadsadsa', 'Asthma', '2022-10-23'),
(34, 7, 5, 40, 1002, 'sadasdasd', '01:01:00', 'Booked', 'No', '', '', '2022-11-30'),
(35, 7, 10, 41, 1003, 'sadasdas', '02:28:00', 'Completed', 'Yes', 'done\r\n', 'Asthma', '2022-11-30'),
(38, 7, 5, 43, 1004, 'dsadas', '12:23:00', 'Cancel', 'No', '', '', '2022-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule_table`
--

CREATE TABLE `doctor_schedule_table` (
  `doctor_schedule_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `doctor_schedule_date` date NOT NULL,
  `doctor_schedule_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') COLLATE utf8_unicode_ci NOT NULL,
  `doctor_schedule_start_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_schedule_end_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `average_consulting_time` int(5) NOT NULL,
  `doctor_schedule_status` enum('Available','Unavailable') COLLATE utf8_unicode_ci NOT NULL,
  `schedule_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_schedule_table`
--

INSERT INTO `doctor_schedule_table` (`doctor_schedule_id`, `doctor_id`, `doctor_schedule_date`, `doctor_schedule_day`, `doctor_schedule_start_time`, `doctor_schedule_end_time`, `average_consulting_time`, `doctor_schedule_status`, `schedule_date`) VALUES
(40, 7, '2022-12-25', 'Thursday', '01:01', '13:03', 35, 'Available', '0000-00-00'),
(41, 7, '2022-12-30', 'Tuesday', '02:28', '14:28', 45, 'Available', '2022-11-28'),
(43, 7, '2022-12-09', 'Friday', '12:23', '21:27', 55, 'Unavailable', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_table`
--

CREATE TABLE `doctor_table` (
  `id` int(11) NOT NULL,
  `doctor_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_profile_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `doctor_date_of_birth` date NOT NULL,
  `doctor_degree` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_expert_in` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_status` enum('Available','Unavailable') COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `doctor_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_table`
--

INSERT INTO `doctor_table` (`id`, `doctor_id`, `doctor_email_address`, `doctor_password`, `doctor_name`, `doctor_profile_image`, `doctor_phone_no`, `doctor_address`, `doctor_date_of_birth`, `doctor_degree`, `doctor_expert_in`, `doctor_status`, `chat_status`, `doctor_added_on`) VALUES
(7, '732454543', 'christian@gmail.com', '$2y$10$z1wCi567fTck0BIQkWaIZeRAuXBlc.oatTP24.Vq43Ne6AatYmH1.', 'Dr Christian Bio', '../images/1599085978.jpg', '090909', 'Urbiz', '2022-10-18', 'IT', 'Sergen', 'Available', 'Active now', '2022-10-08 21:31:47'),
(8, '5345435454', 'jm@gmail.com', '$2y$10$BD/AmxL7c3kHO0kYJr4iSuDgbnE99B0FmDjKD9tab4fUvhoQmo4gK', 'John Michael', '../images/2378020-u1.jpg', '0989889890', 'Urbix', '2022-10-28', '', 'cardiologist', 'Available', 'Offline now', '2022-10-09 11:40:13'),
(14, '410679253', 'cb@gmail.com', '$2y$10$8xXooass0eBKhU01pfp4Me00RZWl8npY8mK6o.Ndj4EIcFG/fFTBO', 'cocoy', '../images/user1.png', '09342423', 'SC', '2022-11-30', '', 'IT', 'Available', 'Offline now', '2022-11-29 11:00:34'),
(15, '032698475', 'mark@gmail', '$2y$10$xLx/yhjdWUhpJl8X.knzOOzWq2N2fWxAt4CYpHkhTw2orG60jjRmO', 'mark', '../images/Admin-icon.png', '09809809', 'SC', '2022-10-11', '', 'IT', 'Unavailable', 'Offline now', '2022-11-29 11:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `message_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `message_status`) VALUES
(46, 234564345, 732454543, 'sadassd', ''),
(47, 234564345, 732454543, 'sdsadsadd', ''),
(48, 9342342, 732454543, 'asddasds', ''),
(49, 234564345, 732454543, 'mark', ''),
(50, 9342342, 732454543, 'rod', ''),
(51, 732454543, 9342342, 'sdasdsd', ''),
(52, 32698475, 9342342, 'asdsadsds', ''),
(53, 732454543, 9342342, 'asdasdsa', ''),
(54, 732454543, 9342342, 'asdasdas', ''),
(55, 9342342, 732454543, 'dsa', ''),
(56, 9342342, 732454543, 'sdadsd', ''),
(57, 9342342, 732454543, 'sadasdasd', ''),
(58, 9342342, 732454543, 'sdadsd', '');

-- --------------------------------------------------------

--
-- Table structure for table `patient_table`
--

CREATE TABLE `patient_table` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `patient_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `patient_photo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_date_of_birth` date NOT NULL,
  `patient_gender` enum('Male','Female','Other') COLLATE utf8_unicode_ci NOT NULL,
  `patient_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `patient_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_maritial_status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `patient_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `added_on` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patient_table`
--

INSERT INTO `patient_table` (`id`, `patient_id`, `patient_email_address`, `patient_photo`, `patient_password`, `patient_first_name`, `patient_last_name`, `patient_date_of_birth`, `patient_gender`, `patient_address`, `patient_phone_no`, `patient_maritial_status`, `patient_status`, `chat_status`, `added_on`) VALUES
(5, '09342342', 'cocoy@gmail.com', '../images/1883783455.png', '$2y$10$GJnz6UcVR1aFFjO.GKJthOmYzfne.NSzFv9f7uFJ5mhzoz2qFENgK', 'Cocoy', 'Babi', '1995-07-25', 'Male', 'San Carlos', '75394511442', 'Single', 'Active', 'Active now', ''),
(10, '234564345', 'adasda@gmail.com', '../images/8XO5RlIKSKsy8of8W3ZLmS4Lgyg.jpg', '$2y$10$PI.8vij/LPJrGyDJAgerK.YfAJABo7.qODTdGxVaTHOk.jDRVt6RS', 'asdas', 'sadsa', '2022-09-26', 'Male', 'ffdsfds', '54353', 'Single', 'Active', 'Offline now', '2022-10-10 00:48:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `doctor_schedule_table`
--
ALTER TABLE `doctor_schedule_table`
  ADD PRIMARY KEY (`doctor_schedule_id`);

--
-- Indexes for table `doctor_table`
--
ALTER TABLE `doctor_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `patient_table`
--
ALTER TABLE `patient_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointment_table`
--
ALTER TABLE `appointment_table`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `doctor_schedule_table`
--
ALTER TABLE `doctor_schedule_table`
  MODIFY `doctor_schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `doctor_table`
--
ALTER TABLE `doctor_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `patient_table`
--
ALTER TABLE `patient_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
