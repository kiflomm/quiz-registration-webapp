-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 10:09 AM
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
-- Database: `quiz_app_details`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_users`
--

CREATE TABLE `all_users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `account_type` varchar(20) NOT NULL,
  `registration_time` datetime NOT NULL,
  `user_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_users`
--

INSERT INTO `all_users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `account_type`, `registration_time`, `user_name`) VALUES
(1, 'kiflom', 'berihu', 'kiflom@gmail.com', 'asdf', 'examiner', '2024-05-29 09:33:36', 'boss'),
(2, 'kapital', 'gere', 'legend@gmail.com', 'qwert', 'candidate', '2024-05-29 09:34:28', 'legend');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_text` varchar(2000) NOT NULL,
  `option_1` varchar(1000) NOT NULL,
  `option_2` varchar(1000) NOT NULL,
  `option_3` varchar(1000) NOT NULL,
  `option_4` varchar(1000) NOT NULL,
  `correct_answer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `test_id`, `question_text`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_answer`) VALUES
(63, 42, 'which programming language is the best for backend development.', 'php', 'express', 'django', 'java', 2),
(64, 42, 'what is the owner of the social media website known as  \'facebook\'', 'mark zukerberg', 'elon musk', 'bilgates', 'kiflom :)', 1),
(65, 43, 'who is the creator of the dynamo ', 'Michael  Faraday', 'Steven Hawking ', 'Albert Einstein', 'Abiy Ahmed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_title` varchar(100) NOT NULL,
  `test_desc` varchar(1000) NOT NULL,
  `test_duration` int(11) NOT NULL,
  `test_catagory` varchar(100) NOT NULL,
  `test_author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_title`, `test_desc`, `test_duration`, `test_catagory`, `test_author`) VALUES
(42, 'final exam for section one --- SWE - Department', 'This particular test is for those who are software engineering department section one.', 15, 'programming', 'kiflom'),
(43, 'General knowledge questions', 'this is test is for anyone who is interested in science like me :)', 2, 'science', 'kiflom');

-- --------------------------------------------------------

--
-- Table structure for table `tests_taken`
--

CREATE TABLE `tests_taken` (
  `test_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `correct_score` int(11) NOT NULL,
  `incorrect_score` int(11) NOT NULL,
  `exam_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests_taken`
--

INSERT INTO `tests_taken` (`test_id`, `user_name`, `correct_score`, `incorrect_score`, `exam_time`) VALUES
(43, 'legend', 0, 1, '09:50:09'),
(42, 'legend', 1, 1, '09:50:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_users`
--
ALTER TABLE `all_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_users`
--
ALTER TABLE `all_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
