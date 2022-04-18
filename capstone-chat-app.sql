-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2022 at 01:06 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone-chat-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `participant_one_id` bigint(20) UNSIGNED NOT NULL,
  `participant_two_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `participant_one_id`, `participant_two_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_body` text NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_user_id` bigint(20) UNSIGNED NOT NULL,
  `sent_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message_body`, `chat_id`, `sender_user_id`, `sent_datetime`) VALUES
(1, 'Sed volutpat feugiat molestie convallis et dapibus lectus class litora laoreet vehicula risus. Interdum ornare euismod taciti laoreet tristique, justo ut tempor molestie massa felis sollicitudin ad odio eros senectus iaculis. Adipiscing sed tincidunt nisi sollicitudin habitasse torquent inceptos rhoncus neque sem aliquet.', 1, 2, '2021-10-17 06:15:34'),
(2, 'Malesuada lobortis condimentum dui fermentum enim blandit fames.', 1, 1, '2021-10-17 06:17:03'),
(3, 'd', 1, 1, '2021-10-17 06:34:06'),
(4, 'Amet sapien justo facilisis cubilia pretium urna eu taciti potenti accumsan senectus, finibus maecenas et pretium fermentum sodales congue sem habitant fames, integer nunc nisi et posuere condimentum torquent conubia elementum dignissim habitant nisl. Elit leo mollis ultrices massa orci ultricies augue sollicitudin arcu vel aptent inceptos diam aenean.', 1, 1, '2022-01-18 18:02:38'),
(5, 'Sapien luctus nec aliquam massa nullam commodo class enim curabitur eros. Nulla maecenas sagittis pellentesque iaculis, in placerat erat nec nisi convallis platea torquent per potenti habitant cras. In proin nam morbi, eleifend tortor purus cubilia donec vehicula, elit vestibulum nisi tristique, feugiat quis consequat maximus neque fames. Nibh curae donec aenean, nunc eget consequat conubia nostra fermentum.', 1, 1, '2022-01-18 18:02:44'),
(6, 'Etiam eleifend commodo congue fames.', 1, 1, '2022-01-18 18:30:06'),
(7, 'Elit sed nibh nunc ut mollis fringilla dapibus sollicitudin sagittis fermentum donec laoreet vehicula.', 1, 2, '2022-01-18 18:30:17'),
(8, 'Dolor egestas vitae nec fusce faucibus vivamus maximus torquent sodales bibendum elementum.', 1, 2, '2022-01-18 18:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `join_datetime`) VALUES
(1, 'user01', '$2y$11$NGq55mGAxsEkdkc5Y3m1teUvZY5DnzLs9zykYvUbXLUh1ChwIKkyS', '2021-10-17 06:15:11'),
(2, 'another_user', '$2y$11$E/csChJmWJpnv5Mrdmo6TeHtDGUZjnE3t39NwmD9S0lZv4xbm0mBK', '2021-10-17 06:15:31'),
(3, 'coursera_feedback', '$2y$11$ZcYdy3lTEbICVNGoV91sweDWC68ojqtogcjhsJhQQNmfMrZn.daPm', '2021-10-17 06:16:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
