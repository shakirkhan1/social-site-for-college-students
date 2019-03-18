-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 11:05 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mainsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `username`, `fullname`, `date`, `comment`) VALUES
(33, 173, 'tt', 'ttt', '2018-11-30 09:26:41', 'dfbxd'),
(34, 173, 'pp', 'pppr', '2018-11-30 09:32:29', 'dsff'),
(35, 173, 'pp', 'pppr', '2018-11-30 09:58:14', 'xcb'),
(36, 174, 'as', 'sayuj', '2018-11-30 10:03:29', 'as'),
(37, 176, 'pp', 'pppr', '2018-11-30 12:32:20', 'gbc');

-- --------------------------------------------------------

--
-- Table structure for table `friendrequest`
--

CREATE TABLE `friendrequest` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `seen` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendrequest`
--

INSERT INTO `friendrequest` (`id`, `sender`, `receiver`, `seen`) VALUES
(36, 'tt', 'as', 1),
(38, 'qw', 'as', 1);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `friendname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user`, `friendname`) VALUES
(1, 'as', 'rr'),
(2, 'as', 'pp'),
(3, 'pp', 'qw');

-- --------------------------------------------------------

--
-- Table structure for table `likepage`
--

CREATE TABLE `likepage` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likepage`
--

INSERT INTO `likepage` (`id`, `post_id`, `username`, `likes`) VALUES
(241, 173, 'tt', 1),
(242, 176, 'ww', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message`, `user_name`, `date`) VALUES
(1, 'sa', 'sayuj', '2018-09-27 17:17:44'),
(2, 'fasdf', 'sayuj', '2018-10-04 19:02:15'),
(3, 'fafasdfasfasdfsadf', 'as', '2018-10-07 17:46:10'),
(4, 'fasfasfsa', 'as', '2018-10-07 17:46:12'),
(5, 'fsadfasfas', 'as', '2018-10-07 17:46:14'),
(6, 'fsafd', 'as', '2018-10-07 17:47:38'),
(7, 'dss', 'varun', '2018-11-06 06:36:28'),
(8, 'adsa', 'varun', '2018-11-06 06:36:33'),
(9, 'efwae', 'varun', '2018-11-06 06:36:37'),
(10, 'defeadfcddddddddddddddddddddddddddddddddddd', 'varun', '2018-11-06 06:36:49'),
(11, 'fsd', 'as', '2018-11-07 09:30:23'),
(12, 'qw', 'qw', '2018-11-09 16:01:45'),
(13, 'sa', 'qw', '2018-11-09 16:12:30'),
(14, 'qwqwqwq', 'qw', '2018-11-09 16:12:44'),
(15, 'ff', 'qw', '2018-11-09 16:13:39'),
(16, 'hi i m sayuj', 'as', '2018-11-09 16:15:07'),
(17, 'sa', 'as', '2018-11-09 16:17:41'),
(18, 'wew', 'as', '2018-11-09 16:17:52'),
(19, 'qweqe', 'as', '2018-11-09 16:18:51'),
(20, 'sf', 'as', '2018-11-09 16:19:18'),
(21, 'w', 'qw', '2018-11-09 16:20:20'),
(22, 'fsdf', 'as', '2018-11-12 07:59:25'),
(23, 'hi', 'as', '2018-11-13 15:17:06'),
(24, 'fsafasdfsd', 'as', '2018-11-13 22:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `sender_post` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `notification_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `post_id`, `post_title`, `sender_post`, `username`, `notification_status`) VALUES
(28, 176, 'dfgv', 'as', 'tt', 1),
(29, 176, 'dfgv', 'as', 'ee', 0),
(30, 176, 'dfgv', 'as', 'qw', 0),
(31, 176, 'dfgv', 'as', 'va', 0),
(32, 176, 'dfgv', 'as', 'varun', 0),
(33, 176, 'dfgv', 'as', 'ww', 1),
(34, 176, 'dfgv', 'as', 'rr', 0),
(35, 176, 'dfgv', 'as', 'pp', 1),
(36, 176, 'dfgv', 'as', 'zz', 0);

-- --------------------------------------------------------

--
-- Table structure for table `noti_comments`
--

CREATE TABLE `noti_comments` (
  `id` int(255) NOT NULL,
  `noti_comment_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `comment_username` varchar(255) NOT NULL,
  `comment_title` varchar(255) NOT NULL,
  `comment_status` int(1) NOT NULL,
  `comment_owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noti_comments`
--

INSERT INTO `noti_comments` (`id`, `noti_comment_id`, `post_id`, `comment_username`, `comment_title`, `comment_status`, `comment_owner`) VALUES
(5, 37, 176, 'pp', 'gbc', 1, 'as');

-- --------------------------------------------------------

--
-- Table structure for table `noti_likes`
--

CREATE TABLE `noti_likes` (
  `id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `like_id` int(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noti_likes`
--

INSERT INTO `noti_likes` (`id`, `post_id`, `like_id`, `owner_name`, `username`, `status`) VALUES
(2, 176, 242, 'as', 'ww', 1);

-- --------------------------------------------------------

--
-- Table structure for table `online_users`
--

CREATE TABLE `online_users` (
  `session` varchar(100) DEFAULT '''''',
  `time` int(100) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online_users`
--

INSERT INTO `online_users` (`session`, `time`) VALUES
('qw', 1542521585);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post` text NOT NULL,
  `post_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `username`, `fullname`, `date`, `post`, `post_title`) VALUES
(176, 'as', 'sayuj', '2018-11-30 12:31:27', 'dfg', 'dfgv');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imagelink` varchar(100) NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `gender`, `username`, `email`, `password`, `imagelink`, `mobile_no`) VALUES
(61, 'ttt', 'female', 'tt', 'tt@gmail.com', 'accc9105df5383111407fd5b41255e23', 'uploads/WIN_20180205_22_50_03_Pro.jpg', ''),
(60, 'eee', 'male', 'ee', 'sayuj@gmail.com', '08a4415e9d594ff960030b921d42b91e', 'uploads/WIN_20170521_16_08_10_Pro.jpg', ''),
(55, 'sasdf', 'male', 'qw', 'sayujsehgal@gmail.com', '006d2143154327a64d86a264aea225f3', 'uploads/WIN_20170518_18_57_42_Pro.jpg', '8938939892'),
(57, 'vaa', 'male', 'va', 'varunsegh@gmail.com', '43b1cc1db7be63d899dd4280f578691a', 'uploads/WIN_20180129_19_05_40_Pro.jpg', ''),
(54, 'sayuj', 'male', 'as', 'sayujsehgal@gmail.com', 'f970e2767d0cfe75876ea857f92e319b', 'uploads/profile.jpg', '9165286996'),
(59, 'varun sehgal', 'male', 'varun', 'patdabra@gmail.com', 'dc69be89d61551797fd8516e8e10f9ff', 'uploads/WIN_20170521_16_07_59_Pro.jpg', ''),
(62, 'sayujse ', 'male', 'ww', 'sayujsehgal@iprakash.com', 'ad57484016654da87125db86f4227ea3', 'uploads/WIN_20170521_16_07_53_Pro.jpg', ''),
(63, 'qwqwq', 'male', 'rr', 'varunsegh@gmail.com', '514f1b439f404f86f77090fa9edc96ce', 'uploads/', '9165286996'),
(64, 'pppr', 'female', 'pp', 'sayujsehgal@gmail.com', 'c483f6ce851c9ecd9fb835ff7551737c', 'uploads/', ''),
(65, 'zzz', 'male', 'zz', 'zz@gmail.com', '25ed1bcb423b0b7200f485fc5ff71c8e', 'uploads/WIN_20170518_18_57_42_Pro.jpg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `friendrequest`
--
ALTER TABLE `friendrequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likepage`
--
ALTER TABLE `likepage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `noti_comments`
--
ALTER TABLE `noti_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noti_likes`
--
ALTER TABLE `noti_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `friendrequest`
--
ALTER TABLE `friendrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likepage`
--
ALTER TABLE `likepage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `noti_comments`
--
ALTER TABLE `noti_comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `noti_likes`
--
ALTER TABLE `noti_likes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
