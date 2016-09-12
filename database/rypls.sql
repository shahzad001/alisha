-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2016 at 01:53 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rypls`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_remove_staff`
--

CREATE TABLE IF NOT EXISTS `assign_remove_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `venue_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `event_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `staff_role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `available` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=111 ;

--
-- Dumping data for table `assign_remove_staff`
--

INSERT INTO `assign_remove_staff` (`id`, `staff_name`, `venue_name`, `event_name`, `staff_role`, `available`, `created_at`, `updated_at`) VALUES
(55, 'markpual890@gmail.com', 'party city', '15', 'Waitor', 'yes', '2015-12-22 06:24:22', '2015-12-22 06:24:22'),
(56, 'jaffmaya@gmail.com', 'social events area', '16', 'Waitor', 'no', '2015-12-22 07:00:03', '2015-12-22 07:00:03'),
(63, 'markpual890@gmail.com', 'Wedding palace', '35', 'Waitor', '', '2016-01-05 07:32:52', '2016-01-05 07:32:52'),
(109, 'brownsunny45@gmail.com', 'Burraq Marriage Hall', '33', 'dancer', '', '2016-01-12 02:26:31', '2016-01-12 02:26:31'),
(110, 'tahirrana11@gmail.com', 'jamal Hotel', '40', 'Waiter', '', '2016-01-12 04:02:23', '2016-01-12 04:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `venue_id` varchar(11) NOT NULL,
  `event_id` varchar(11) NOT NULL,
  `comments` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `venue_id`, `event_id`, `comments`, `created_at`, `updated_at`) VALUES
(1, 77, '0', '30', 'It''s a very noble cause.', '2015-12-31 06:15:27', '2015-12-31 06:15:27'),
(2, 77, '0', '30', 'Every one should participate in it.', '2015-12-31 07:20:07', '2015-12-31 07:20:07'),
(3, 77, '18', '0', 'We should appreciate this kind of things. ', '2015-12-31 08:11:57', '2015-12-31 08:11:57'),
(4, 75, '22', '0', 'try your', '2016-01-01 06:12:58', '2016-01-01 06:12:58'),
(5, 75, '0', '35', 'amazing', '2016-01-01 06:19:08', '2016-01-01 06:19:08'),
(6, 96, '22', '0', 'awsum', '2016-01-01 07:17:57', '2016-01-01 07:17:57'),
(7, 97, '22', '0', 'its going great', '2016-01-01 07:44:17', '2016-01-01 07:44:17'),
(8, 77, '22', '0', 'Awesome event! <3', '2016-01-04 03:11:32', '2016-01-04 03:11:32'),
(9, 77, '22', '0', 'it was just awesum', '2016-01-05 06:54:55', '2016-01-05 06:54:55'),
(10, 77, '22', '0', 'we were enjoy it', '2016-01-05 06:59:58', '2016-01-05 06:59:58'),
(11, 75, '22', '0', 'not about time its about memories you made', '2016-01-05 07:29:27', '2016-01-05 07:29:27'),
(12, 97, '0', '35', 'perfection level achieved', '2016-01-05 07:46:12', '2016-01-05 07:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `venue_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `event_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `dree_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `music_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age_restriction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parking` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `user_id`, `venue_id`, `event_name`, `title`, `description`, `event_type`, `dree_code`, `music_type`, `price`, `date_from`, `date_to`, `time_from`, `time_to`, `age_restriction`, `parking`, `phone`, `facebook_url`, `twitter_url`, `youtube_url`, `latitude`, `longitude`, `recurring`, `photo`, `created_at`, `updated_at`) VALUES
(33, 76, '20', 'Wedding', 'Wedding', 'Starting of new journey', 'Wedding', '', 'Jazz', '44', '31 Dec 2015', '31 Dec 2015', '09 : 13  PM', '09 : 13  PM', '+16', 'No', '54352', 'www.facebook.com', 'www.twitter.com', 'www.google.com', '', '', 'No', 'event_2015-12-311584457049.png,event_2015-12-312096866567.png,event_2015-12-31596067270.png', '2015-12-31 11:18:15', '2015-12-31 11:18:15'),
(42, 76, '20', 'Magical event ', 'Magix', 'Here is magical event happening', 'magical ', '', 'Pop', '5000', '12 Jan 2016', '13 Jan 2016', '4:35pm', '5:00pm', '20+', 'no', '042-7923277', 'http://facebook.com', 'http://twitter.com', 'http://youtube.com', '31.6224324', '74.3032045', 'no', 'event_2016-01-12890394343.jpg', '2016-01-12 06:38:08', '2016-01-12 06:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `event_ratings`
--

CREATE TABLE IF NOT EXISTS `event_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `venue_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `event_likes` int(11) NOT NULL,
  `favourites` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Dumping data for table `event_ratings`
--

INSERT INTO `event_ratings` (`id`, `user_id`, `venue_id`, `likes`, `event_likes`, `favourites`, `type`, `event_id`, `created_at`, `updated_at`) VALUES
(41, 97, '0', 0, 1, 1, 'event', '35', '2016-01-01 07:40:54', '2016-01-01 07:40:54'),
(42, 77, '0', 1, 0, 0, 'event', '33', '2016-01-06 09:04:41', '2016-01-06 09:04:41'),
(43, 77, '0', 0, 1, 0, 'event', '35', '2016-01-06 09:10:08', '2016-01-06 09:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `venue_id` varchar(11) NOT NULL,
  `event_id` varchar(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `venue_id`, `event_id`, `type`, `images`, `created_at`, `updated_at`) VALUES
(27, 97, '22', '0', 'venue', 'venue_2016-01-051547719658.png', '2016-01-05 07:44:26', '2016-01-05 07:44:26'),
(26, 97, '0', '35', 'event', 'event_2016-01-05166790172.png', '2016-01-05 07:43:49', '2016-01-05 07:43:49'),
(25, 75, '22', '0', 'venue', 'venue_2016-01-052046669789.png', '2016-01-05 07:30:31', '2016-01-05 07:30:31'),
(24, 77, '22', '0', 'venue', 'venue_2016-01-0576858199.png', '2016-01-05 06:59:51', '2016-01-05 06:59:51'),
(23, 77, '22', '0', 'venue', 'venue_2016-01-051090386151.png', '2016-01-05 06:58:44', '2016-01-05 06:58:44'),
(22, 77, '22', '0', 'venue', 'venue_2016-01-051565117072.png', '2016-01-05 06:56:58', '2016-01-05 06:56:58'),
(16, 77, '21', '0', 'venue', 'venue_2016-01-04274692362.png', '2016-01-04 07:27:01', '2016-01-04 07:27:01'),
(17, 77, '21', '0', 'venue', 'venue_2016-01-041999988138.png', '2016-01-04 07:27:01', '2016-01-04 07:27:01'),
(21, 77, '22', '0', 'venue', 'venue_2016-01-051950675234.png', '2016-01-05 06:56:58', '2016-01-05 06:56:58'),
(19, 77, '0', '33', 'event', 'event_2016-01-04651854882.png', '2016-01-04 09:30:45', '2016-01-04 09:30:45'),
(20, 77, '0', '33', 'event', 'event_2016-01-041708948816.png', '2016-01-04 09:30:45', '2016-01-04 09:30:45'),
(28, 97, '0', '35', 'event', 'event_2016-01-051090760717.png', '2016-01-05 07:45:14', '2016-01-05 07:45:14'),
(29, 97, '0', '35', 'event', 'event_2016-01-05703974982.png', '2016-01-05 07:45:34', '2016-01-05 07:45:34'),
(30, 97, '0', '35', 'event', 'event_2016-01-05857548596.png', '2016-01-05 07:46:31', '2016-01-05 07:46:31'),
(31, 97, '22', '0', 'venue', 'venue_2016-01-051403159479.png', '2016-01-05 07:47:08', '2016-01-05 07:47:08'),
(32, 97, '22', '0', 'venue', 'venue_2016-01-0596970020.png', '2016-01-05 07:47:31', '2016-01-05 07:47:31'),
(33, 75, '22', '0', 'venue', 'venue_2016-01-05403387583.png', '2016-01-05 07:49:05', '2016-01-05 07:49:05'),
(34, 75, '22', '0', 'venue', 'venue_2016-01-05827620874.png', '2016-01-05 07:51:04', '2016-01-05 07:51:04'),
(35, 75, '22', '0', 'venue', 'venue_2016-01-051648205474.png', '2016-01-05 07:52:08', '2016-01-05 07:52:08'),
(36, 75, '22', '0', 'venue', 'venue_2016-01-051298455549.png', '2016-01-05 07:52:42', '2016-01-05 07:52:42'),
(37, 75, '22', '0', 'venue', 'venue_2016-01-05478221193.png', '2016-01-05 07:52:49', '2016-01-05 07:52:49'),
(38, 75, '22', '0', 'venue', 'venue_2016-01-051732871253.png', '2016-01-05 07:53:46', '2016-01-05 07:53:46'),
(39, 75, '0', '35', 'event', 'event_2016-01-051768201633.png', '2016-01-05 07:55:27', '2016-01-05 07:55:27'),
(40, 75, '0', '35', 'event', 'event_2016-01-051566290846.png', '2016-01-05 07:55:29', '2016-01-05 07:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_11_26_111147_create_venues_table', 1),
('2015_11_26_112043_create_staff_table', 1),
('2015_11_26_112341_create_event_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE IF NOT EXISTS `rewards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `call_count` int(11) NOT NULL,
  `call_type` varchar(255) NOT NULL DEFAULT '',
  `reward_points` varchar(255) NOT NULL DEFAULT '',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `venue_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=656 ;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `user_id`, `call_count`, `call_type`, `reward_points`, `event_id`, `venue_id`, `created_at`, `updated_at`) VALUES
(510, 73, 1, 'login', '5', 0, 0, '2015-12-23 04:03:26', '0000-00-00 00:00:00'),
(511, 77, 1, 'login', '5', 0, 0, '2015-12-23 04:04:10', '0000-00-00 00:00:00'),
(512, 77, 1, 'event', '5', 0, 0, '2015-12-23 04:04:16', '0000-00-00 00:00:00'),
(513, 73, 1, 'event', '5', 0, 0, '2015-12-23 04:52:35', '0000-00-00 00:00:00'),
(514, 77, 1, 'ripple', '20', 0, 14, '2015-12-23 05:02:08', '0000-00-00 00:00:00'),
(515, 87, 1, 'login', '5', 0, 0, '2015-12-23 07:14:02', '0000-00-00 00:00:00'),
(516, 75, 1, 'invite', '20', 0, 0, '2015-12-23 07:15:47', '0000-00-00 00:00:00'),
(517, 75, 1, 'invite', '20', 0, 0, '2015-12-23 07:17:16', '0000-00-00 00:00:00'),
(518, 75, 1, 'invite', '20', 0, 0, '2015-12-23 07:17:57', '0000-00-00 00:00:00'),
(519, 75, 1, 'invite', '20', 0, 0, '2015-12-23 07:17:59', '0000-00-00 00:00:00'),
(520, 75, 1, 'invite', '20', 0, 0, '2015-12-23 07:18:02', '0000-00-00 00:00:00'),
(521, 73, 1, 'invite', '20', 0, 0, '2015-12-23 07:52:11', '0000-00-00 00:00:00'),
(522, 77, 1, 'invite', '20', 0, 0, '2015-12-23 07:54:28', '0000-00-00 00:00:00'),
(523, 77, 1, 'invite', '20', 0, 0, '2015-12-23 07:54:44', '0000-00-00 00:00:00'),
(524, 77, 1, 'invite', '20', 0, 0, '2015-12-23 07:55:19', '0000-00-00 00:00:00'),
(525, 77, 1, 'invite', '20', 0, 0, '2015-12-23 07:56:23', '0000-00-00 00:00:00'),
(526, 89, 1, 'login', '5', 0, 0, '2015-12-23 08:04:49', '0000-00-00 00:00:00'),
(527, 77, 1, 'invite', '20', 0, 0, '2015-12-23 08:07:19', '0000-00-00 00:00:00'),
(528, 76, 1, 'login', '5', 0, 0, '2015-12-23 08:53:58', '0000-00-00 00:00:00'),
(529, 89, 1, 'event', '5', 0, 0, '2015-12-23 09:31:17', '0000-00-00 00:00:00'),
(530, 90, 1, 'event', '5', 0, 0, '2015-12-23 09:32:37', '0000-00-00 00:00:00'),
(531, 91, 1, 'event', '5', 0, 0, '2015-12-23 09:51:46', '0000-00-00 00:00:00'),
(532, 91, 1, 'ripple', '20', 24, 0, '2015-12-23 09:52:45', '0000-00-00 00:00:00'),
(533, 91, 1, 'event', '5', 0, 0, '2015-12-24 09:55:39', '0000-00-00 00:00:00'),
(534, 77, 1, 'login', '5', 0, 0, '2015-12-28 04:29:00', '0000-00-00 00:00:00'),
(535, 77, 1, 'event', '5', 0, 0, '2015-12-28 04:31:01', '0000-00-00 00:00:00'),
(536, 76, 1, 'login', '5', 0, 0, '2015-12-28 04:58:46', '0000-00-00 00:00:00'),
(537, 76, 1, 'invite', '20', 0, 0, '2015-12-28 05:07:46', '0000-00-00 00:00:00'),
(538, 75, 1, 'login', '5', 0, 0, '2015-12-28 06:24:09', '0000-00-00 00:00:00'),
(539, 75, 1, 'event', '5', 0, 0, '2015-12-28 06:31:39', '0000-00-00 00:00:00'),
(540, 75, 1, 'ripple', '20', 17, 0, '2015-12-28 06:42:56', '0000-00-00 00:00:00'),
(541, 78, 1, 'event', '5', 0, 0, '2015-12-28 06:44:29', '0000-00-00 00:00:00'),
(542, 92, 1, 'login', '5', 0, 0, '2015-12-28 06:55:06', '0000-00-00 00:00:00'),
(543, 92, 1, 'event', '5', 0, 0, '2015-12-28 06:55:15', '0000-00-00 00:00:00'),
(544, 92, 1, 'ripple', '20', 0, 11, '2015-12-28 06:55:40', '0000-00-00 00:00:00'),
(545, 92, 1, 'ripple', '20', 0, 10, '2015-12-28 06:55:54', '0000-00-00 00:00:00'),
(546, 92, 1, 'ripple', '20', 0, 12, '2015-12-28 06:56:05', '0000-00-00 00:00:00'),
(547, 92, 1, 'ripple', '20', 0, 16, '2015-12-28 06:56:15', '0000-00-00 00:00:00'),
(548, 92, 1, 'invite', '20', 0, 0, '2015-12-28 06:56:41', '0000-00-00 00:00:00'),
(549, 92, 1, 'ripple', '20', 0, 13, '2015-12-28 06:57:34', '0000-00-00 00:00:00'),
(550, 92, 1, 'ripple', '20', 0, 14, '2015-12-28 06:57:42', '0000-00-00 00:00:00'),
(551, 80, 1, 'login', '5', 0, 0, '2015-12-28 07:33:57', '0000-00-00 00:00:00'),
(552, 73, 1, 'login', '5', 0, 0, '2015-12-29 00:22:01', '0000-00-00 00:00:00'),
(553, 73, 1, 'event', '5', 0, 0, '2015-12-29 00:22:09', '0000-00-00 00:00:00'),
(554, 77, 1, 'login', '5', 0, 0, '2015-12-29 08:43:21', '0000-00-00 00:00:00'),
(555, 76, 1, 'login', '5', 0, 0, '2015-12-29 08:43:45', '0000-00-00 00:00:00'),
(556, 73, 1, 'login', '5', 0, 0, '2015-12-30 00:29:48', '0000-00-00 00:00:00'),
(557, 73, 1, 'event', '5', 0, 0, '2015-12-30 00:46:18', '0000-00-00 00:00:00'),
(558, 77, 1, 'event', '5', 0, 0, '2015-12-30 03:41:43', '0000-00-00 00:00:00'),
(559, 77, 1, 'ripple', '20', 0, 17, '2015-12-30 06:27:03', '0000-00-00 00:00:00'),
(560, 77, 1, 'ripple', '20', 0, 16, '2015-12-30 06:28:34', '0000-00-00 00:00:00'),
(561, 77, 1, 'ripple', '20', 0, 14, '2015-12-30 06:28:41', '0000-00-00 00:00:00'),
(562, 77, 1, 'ripple', '20', 0, 13, '2015-12-30 06:28:50', '0000-00-00 00:00:00'),
(563, 77, 1, 'ripple', '20', 18, 0, '2015-12-30 06:29:07', '0000-00-00 00:00:00'),
(564, 75, 1, 'ripple', '20', 0, 10, '2015-12-30 06:34:43', '0000-00-00 00:00:00'),
(565, 77, 1, 'login', '5', 0, 0, '2015-12-30 08:55:48', '0000-00-00 00:00:00'),
(566, 75, 1, 'event', '5', 0, 0, '2015-12-30 09:06:20', '0000-00-00 00:00:00'),
(567, 75, 1, 'like', '20', 0, 0, '2015-12-30 09:29:17', '0000-00-00 00:00:00'),
(568, 77, 1, 'like', '20', 0, 10, '2015-12-30 09:30:46', '0000-00-00 00:00:00'),
(569, 76, 1, 'login', '5', 0, 0, '2015-12-30 10:10:20', '0000-00-00 00:00:00'),
(570, 93, 1, 'login', '5', 0, 0, '2015-12-30 10:12:13', '0000-00-00 00:00:00'),
(571, 75, 1, 'like', '20', 0, 10, '2015-12-30 10:42:00', '0000-00-00 00:00:00'),
(572, 75, 1, 'like', '20', 10, 0, '2015-12-30 10:45:29', '0000-00-00 00:00:00'),
(573, 76, 1, 'like', '20', 0, 18, '2015-12-30 11:07:56', '0000-00-00 00:00:00'),
(574, 76, 1, 'event', '5', 0, 0, '2015-12-30 11:08:43', '0000-00-00 00:00:00'),
(575, 76, 1, 'like', '20', 30, 0, '2015-12-30 11:09:38', '0000-00-00 00:00:00'),
(576, 77, 1, 'like', '20', 16, 0, '2015-12-30 11:34:07', '0000-00-00 00:00:00'),
(577, 73, 1, 'login', '5', 0, 0, '2015-12-31 00:59:13', '0000-00-00 00:00:00'),
(578, 73, 1, 'event', '5', 0, 0, '2015-12-31 00:59:18', '0000-00-00 00:00:00'),
(579, 77, 1, 'event', '5', 0, 0, '2015-12-31 06:14:14', '0000-00-00 00:00:00'),
(580, 77, 1, 'like', '20', 30, 0, '2015-12-31 07:57:02', '0000-00-00 00:00:00'),
(581, 77, 1, 'like', '20', 0, 18, '2015-12-31 09:07:12', '0000-00-00 00:00:00'),
(582, 75, 1, 'like', '20', 4, 0, '2015-12-31 09:24:07', '0000-00-00 00:00:00'),
(583, 77, 1, 'login', '5', 0, 0, '2015-12-31 09:24:13', '0000-00-00 00:00:00'),
(584, 75, 1, 'ripple', '20', 30, 0, '2015-12-31 09:33:24', '0000-00-00 00:00:00'),
(585, 75, 1, 'ripple', '20', 0, 18, '2015-12-31 09:35:40', '0000-00-00 00:00:00'),
(586, 76, 1, 'like', '20', 0, 19, '2015-12-31 09:55:29', '0000-00-00 00:00:00'),
(587, 76, 1, 'ripple', '20', 0, 20, '2015-12-31 10:05:36', '0000-00-00 00:00:00'),
(588, 76, 1, 'login', '5', 0, 0, '2015-12-31 10:23:57', '0000-00-00 00:00:00'),
(589, 76, 1, 'event', '5', 0, 0, '2015-12-31 11:18:27', '0000-00-00 00:00:00'),
(590, 89, 1, 'login', '5', 0, 0, '2015-12-31 12:03:26', '0000-00-00 00:00:00'),
(591, 91, 1, 'event', '5', 0, 0, '2015-12-31 13:37:42', '0000-00-00 00:00:00'),
(592, 73, 1, 'login', '5', 0, 0, '2016-01-01 01:00:20', '0000-00-00 00:00:00'),
(593, 73, 1, 'event', '5', 0, 0, '2016-01-01 01:15:28', '0000-00-00 00:00:00'),
(594, 94, 1, 'login', '5', 0, 0, '2016-01-01 03:06:21', '0000-00-00 00:00:00'),
(595, 75, 1, 'login', '5', 0, 0, '2016-01-01 05:05:40', '0000-00-00 00:00:00'),
(596, 75, 1, 'like', '20', 0, 22, '2016-01-01 06:12:39', '0000-00-00 00:00:00'),
(597, 75, 1, 'event', '5', 0, 0, '2016-01-01 06:18:48', '0000-00-00 00:00:00'),
(598, 95, 1, 'event', '5', 0, 0, '2016-01-01 07:11:50', '0000-00-00 00:00:00'),
(599, 96, 1, 'login', '5', 0, 0, '2016-01-01 07:15:16', '0000-00-00 00:00:00'),
(600, 96, 1, 'event', '5', 0, 0, '2016-01-01 07:15:42', '0000-00-00 00:00:00'),
(601, 96, 1, 'like', '20', 0, 22, '2016-01-01 07:17:25', '0000-00-00 00:00:00'),
(602, 97, 1, 'login', '5', 0, 0, '2016-01-01 07:40:38', '0000-00-00 00:00:00'),
(603, 97, 1, 'like', '20', 35, 0, '2016-01-01 07:41:07', '0000-00-00 00:00:00'),
(604, 77, 1, 'login', '5', 0, 0, '2016-01-01 10:51:34', '0000-00-00 00:00:00'),
(605, 77, 1, 'event', '5', 0, 0, '2016-01-01 10:54:04', '0000-00-00 00:00:00'),
(606, 76, 1, 'login', '5', 0, 0, '2016-01-04 03:03:20', '0000-00-00 00:00:00'),
(607, 76, 1, 'event', '5', 0, 0, '2016-01-04 03:03:34', '0000-00-00 00:00:00'),
(608, 77, 1, 'login', '5', 0, 0, '2016-01-04 03:03:59', '0000-00-00 00:00:00'),
(609, 77, 1, 'event', '5', 0, 0, '2016-01-04 03:04:09', '0000-00-00 00:00:00'),
(610, 77, 1, 'like', '20', 0, 22, '2016-01-04 03:14:21', '0000-00-00 00:00:00'),
(611, 98, 1, 'login', '5', 0, 0, '2016-01-04 11:51:27', '0000-00-00 00:00:00'),
(612, 77, 1, 'login', '5', 0, 0, '2016-01-05 03:05:45', '0000-00-00 00:00:00'),
(613, 77, 1, 'event', '5', 0, 0, '2016-01-05 06:25:00', '0000-00-00 00:00:00'),
(614, 75, 1, 'login', '5', 0, 0, '2016-01-05 07:19:50', '0000-00-00 00:00:00'),
(615, 78, 1, 'event', '5', 0, 0, '2016-01-05 07:32:37', '0000-00-00 00:00:00'),
(616, 75, 1, 'event', '5', 0, 0, '2016-01-05 07:32:46', '0000-00-00 00:00:00'),
(617, 97, 1, 'login', '5', 0, 0, '2016-01-05 07:39:22', '0000-00-00 00:00:00'),
(618, 98, 1, 'login', '5', 0, 0, '2016-01-05 11:53:25', '0000-00-00 00:00:00'),
(619, 77, 1, 'login', '5', 0, 0, '2016-01-06 05:32:21', '0000-00-00 00:00:00'),
(620, 77, 1, 'event', '5', 0, 0, '2016-01-06 06:36:57', '0000-00-00 00:00:00'),
(621, 77, 1, 'ripple', '20', 33, 0, '2016-01-06 09:04:41', '0000-00-00 00:00:00'),
(622, 77, 1, 'like', '20', 35, 0, '2016-01-06 09:10:08', '0000-00-00 00:00:00'),
(623, 77, 1, 'like', '20', 33, 0, '2016-01-06 09:23:38', '0000-00-00 00:00:00'),
(624, 77, 1, 'ripple', '20', 0, 20, '2016-01-06 10:52:01', '0000-00-00 00:00:00'),
(625, 98, 1, 'login', '5', 0, 0, '2016-01-06 12:20:52', '0000-00-00 00:00:00'),
(626, 98, 1, 'event', '5', 0, 0, '2016-01-07 06:14:30', '0000-00-00 00:00:00'),
(627, 99, 1, 'login', '5', 0, 0, '2016-01-07 06:16:54', '0000-00-00 00:00:00'),
(628, 99, 1, 'event', '5', 0, 0, '2016-01-07 06:17:17', '0000-00-00 00:00:00'),
(629, 100, 1, 'login', '5', 0, 0, '2016-01-07 08:27:37', '0000-00-00 00:00:00'),
(630, 100, 1, 'event', '5', 0, 0, '2016-01-07 09:55:33', '0000-00-00 00:00:00'),
(631, 100, 1, 'invite', '20', 0, 0, '2016-01-07 09:57:01', '0000-00-00 00:00:00'),
(632, 77, 1, 'login', '5', 0, 0, '2016-01-08 03:28:31', '0000-00-00 00:00:00'),
(633, 77, 1, 'event', '5', 0, 0, '2016-01-08 03:29:27', '0000-00-00 00:00:00'),
(634, 106, 1, 'login', '5', 0, 0, '2016-01-08 05:08:28', '0000-00-00 00:00:00'),
(635, 106, 1, 'event', '5', 0, 0, '2016-01-08 06:38:35', '0000-00-00 00:00:00'),
(636, 75, 1, 'login', '5', 0, 0, '2016-01-08 07:28:34', '0000-00-00 00:00:00'),
(637, 75, 1, 'event', '5', 0, 0, '2016-01-08 07:45:13', '0000-00-00 00:00:00'),
(638, 107, 1, 'login', '5', 0, 0, '2016-01-08 07:47:23', '0000-00-00 00:00:00'),
(639, 107, 1, 'event', '5', 0, 0, '2016-01-08 07:48:42', '0000-00-00 00:00:00'),
(640, 91, 1, 'event', '5', 0, 0, '2016-01-08 20:48:55', '0000-00-00 00:00:00'),
(641, 106, 1, 'login', '5', 0, 0, '2016-01-11 01:57:07', '0000-00-00 00:00:00'),
(642, 106, 1, 'event', '5', 0, 0, '2016-01-11 01:57:51', '0000-00-00 00:00:00'),
(643, 98, 1, 'login', '5', 0, 0, '2016-01-11 03:20:06', '0000-00-00 00:00:00'),
(644, 98, 1, 'event', '5', 0, 0, '2016-01-11 03:33:33', '0000-00-00 00:00:00'),
(645, 77, 1, 'login', '5', 0, 0, '2016-01-11 07:49:06', '0000-00-00 00:00:00'),
(646, 76, 1, 'login', '5', 0, 0, '2016-01-11 08:23:00', '0000-00-00 00:00:00'),
(647, 76, 1, 'event', '5', 0, 0, '2016-01-11 08:23:17', '0000-00-00 00:00:00'),
(648, 93, 1, 'login', '5', 0, 0, '2016-01-11 08:40:50', '0000-00-00 00:00:00'),
(649, 109, 1, 'event', '5', 0, 0, '2016-01-11 11:17:54', '0000-00-00 00:00:00'),
(650, 77, 1, 'event', '5', 0, 0, '2016-01-11 11:37:00', '0000-00-00 00:00:00'),
(651, 75, 1, 'event', '5', 0, 0, '2016-01-12 03:22:01', '0000-00-00 00:00:00'),
(652, 73, 1, 'event', '5', 0, 0, '2016-01-12 03:22:44', '0000-00-00 00:00:00'),
(653, 98, 1, 'login', '5', 0, 0, '2016-01-12 03:27:50', '0000-00-00 00:00:00'),
(654, 98, 1, 'event', '5', 0, 0, '2016-01-12 04:00:32', '0000-00-00 00:00:00'),
(655, 78, 1, 'event', '5', 0, 0, '2016-01-12 04:20:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_login_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `staff_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `last_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `phone_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  `email_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(10) NOT NULL DEFAULT '0',
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `radius` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('user','venue_owner','staff','admin') COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=110 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_name`, `staff_login_id`, `staff_phone`, `first_name`, `last_name`, `phone_number`, `email_address`, `password`, `created_by`, `facebook_id`, `device_id`, `radius`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(72, '', '', '', 'Umar Shahzad', '', '', '', '$2y$10$PVShxwHSKQ.9mQ6Rv.KoPOdRGyMLlPi94oDxsQp9MT1pglL6i6Lu6', 0, '555744411259707', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', '', '2015-12-22 02:47:39', '2015-12-22 02:47:39'),
(73, '', '', '', 'gdfgdfg', 'fgdfgfd', '789456', 'a@b.com', '$2y$10$5aXzNUKZy9PjWjXN1iYxhuxKWcATYwyAVr6Uij6d0qP2ew9hdfHnG', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'Mz4adqFvPSqq8B9H2DF8taQFvgltWuX9kWeDgBdbmzuZJ9f8YaAPvDSot68s', '2015-12-22 02:48:39', '2015-12-22 02:48:55'),
(74, '', '', '', 'Ahana Khan', '', '', '', '$2y$10$j7xEh0uXHV2AssC9.DPDRuyTbaVWclSPNDxeFC0UKTtnuU2.Wtwiu', 0, '1648438585407551', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', '', '2015-12-22 02:55:34', '2015-12-22 02:55:34'),
(75, '', '', '', 'jhon', 'owh', '+1236478236', 'jahonowh09@gmail.com', '$2y$10$ssBAXbepOkuhKONn5BSEnetfQqp5VBVPBxRny5IWkuMN3affWv26u', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', 'AKeLTujeOsguiwCb3KmcV7zEX9d4LtSDqD9tahfBa3sZ06M3hcdZS7Ow9n8I', '2015-12-22 03:41:59', '2015-12-22 03:43:06'),
(76, '', '', '', 'Riz', 'K', '147853962', 'bc100403317@gmail.com', '$2y$10$kfRthGZtUSKgRcLrHmkzdOWFQpFHERqep14NYQvQnm4HXHBRnuVXm', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '200', 'venue_owner', '5Sm868GdRNWkby1wvEqCLCUZEkaq6LDBPDim4gzDNW3DR3CN18gOp5B6E7bA', '2015-12-22 05:02:51', '2015-12-22 05:03:21'),
(77, '', '', '', 'R', 'K', '147852369', 'm.rizwan@curiologix.com', '$2y$10$0/aOvlrl9Yr12umshkG9quQ0YCT6lviWDV3.GK6aowFsWgT5Hdih.', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'n6oZjyKT36hPQuqJiFekxiRmleTLRO2pJfbg0hQRXMUw3IFQssnsNPmdJAwD', '2015-12-22 05:06:07', '2015-12-22 05:06:28'),
(78, 'markpual', '', '+13692587456', '', '', '', 'markpual890@gmail.com', '$2y$10$cuQNT7vIyGIWjwK68Z7y5OmrUF0Jh.13GTT9yBJ3zoU9y0Rs.zVza', 75, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2015-12-22 06:23:50', '2015-12-22 06:23:50'),
(79, 'steven', '', '+13642563222', '', '', '', 'davednill09@gmail.com', '$2y$10$MwcEcMbIvwaqfWzAeqpyzOp6uyKz/iRQgl5FHfvzFwgkAgW0S67KG', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2015-12-22 06:26:01', '2015-12-22 06:26:01'),
(80, 'jaff', '', '963852147', '', '', '', 'jaffmaya@gmail.com', '$2y$10$difnDuT41bAsUQwPtB6Dve4kuvk/Gbq29ESbvKVdjdG.qy3fkFk8G', 75, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', 'BY0GIKpeY3TLbBdZ33ly22d3KWtbKPi8c1ryrnB7jwIXh53LZ1qUBhSgSrZn', '2015-12-22 06:57:30', '2015-12-22 08:09:09'),
(81, '', '', '', 'marie', 'gill', '08523994119795', 'jaffmaya@hotmail.com', '$2y$10$KQs8e51q1jkpjGf2cdym6O0I8Ox0rPPoMWC/BmX3b0Dv1E95Q3rkO', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', 'f98pIS2oet5pUCZwWGlrhOmkbdiLg4VnpVNF8PcPccH337huUaDfmO2xl2ZF', '2015-12-22 07:00:24', '2015-12-22 07:22:58'),
(82, 'charles', '', '0852369147', '', '', '', 'bushra.khan@curiologix.com', '$2y$10$0efdIXaxCOgAo1T4xYLYLeB10r.Fb9PFa3s8axW4K/BoeKIlbxaeC', 81, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2015-12-22 07:33:01', '2015-12-22 07:33:01'),
(83, '', '', '', 'josph', 'kevin', '0852369741', 'josphkevin@hotmail.com', '$2y$10$smclv8Dvt5/Cjqy/McijqOqCdYLlX6K7RCZbi8fjBQPtKDCUzL7sC', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', '', '2015-12-22 07:36:03', '2015-12-22 07:36:03'),
(84, '', '', '', 'mark', 'paul', '082399744', 'markpaul@yahoo.com', '$2y$10$CZxnybpDhTsTJqEthK.rB.b8d7d4Q85ypQkFoyQqaviOOyJYiayS2', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', 'tkFAHlFsFs7vHYSocPo2dSjXqpesuYqVc6vE5nhn7dnGt7Iwv3x2PKhEjYIv', '2015-12-22 07:37:37', '2015-12-22 07:55:00'),
(85, '', '', '', 'ronald', 'jaff', '0826935178', 'ronald@yahoo.com', '$2y$10$CKQ/7uQHV5HMsv6ln7L7n.Ai4Euzzd8u/gd87y/VRUWi80tY9j5xK', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'ALZFIWsMRaBUTz6EPUUpfN4jVPxbstbq1PWtkrRrX0e7bPhms1v2WkU2MtQo', '2015-12-22 07:39:03', '2015-12-22 07:39:26'),
(86, '', '', '', 'marie', 'ali', '082697349496494', 'marie@hotmail.com', '$2y$10$P8qW073/kplv4SJi6Y4RLeGzXHyy6i93tvCtKl9WMlqyYKUoHAhay', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'kYYIDZCFHj2KLtdiqTjCDpG2MTPHmWS7YF7FgP43TD6RQvGVWvfPGlWpINds', '2015-12-22 08:28:53', '2015-12-22 08:29:24'),
(87, '', '', '', 'Abdul', 'Mannan', '03214991257', 'mannan@curiologix.com', '$2y$10$BddIFxkQyuIGPO3XOrtxfuOzFXZp0SaOMS7u43MwJ1VwljNX1SxOK', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'rTZDZmLdrSJeCXzeTuO2Nxfb4dOsatQuZkHrd5MqRz7udXB8jFrhp2PLeFrl', '2015-12-22 13:05:13', '2015-12-22 13:05:22'),
(88, '', '', '', 'shahzad', 'hussain', '79854222', 'shahzadshahg@hotmail.com', '$2y$10$ek6SeCzS3P/fi1WT1Z7vM.4dLq.XY/3Yy46Sq3Cpt36S9CMmWOpNK', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'Lflh0pvfLxt6rhCKpxhzDMvQOT470jzejVAVBiUDC0CsqRv5nlrXTZGGrEWN', '2015-12-23 03:54:07', '2015-12-23 03:54:34'),
(89, '', '', '', 'Abdul', 'Mannan', '03214991257', 'mannan1@curiologix.com', '$2y$10$K539sZl.4W9YTudi3nB86eadvilZlaEhYwfZV65QEGCq9VTlifIa.', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', 'DIFHUDFwconajVeFfhoMSCAGxs54mpq5w83hmXa4Dsfr45BalfwFBT1vzbMF', '2015-12-23 08:04:13', '2015-12-23 08:04:49'),
(90, 'Jack Lawrence ', '', '1222334554', '', '', '', 'jack@marquette.com', '$2y$10$6LXiN0wAJgWGy1QV44vub.4Ue0mLXcvpUGYKsVUXW42I1V8go3GO2', 89, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2015-12-23 09:31:47', '2015-12-23 09:31:47'),
(91, '', '', '', 'Cire Sonej', '', '', '', '$2y$10$12djrQ9ol3QMigEFUzi6zOJBbfJXKTVKDPUngxmPwSuOBrWTay6Si', 0, '10100810060395004', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', '', '2015-12-23 09:50:54', '2015-12-23 09:50:54'),
(92, '', '', '', 'Haris', 'Rana', '03662553690', 'haris@hotmail.com', '$2y$10$JAcVHuS6uaRR.dHnYWAKfevQgws.yr4uXLX3vgf11dggXp4/E8wLm', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'ceSBZuSWv2bgo2W6kTnQw5b2CtBAjbsy1teOu3CwXUs1CfRVV3rJOCTvTFW3', '2015-12-28 06:54:10', '2015-12-28 06:55:06'),
(93, 'John William', '', '147852369', '', '', '', 'brownsunny45@gmail.com', '$2y$10$3aYYHghvBXqoGsZeCbGSEeVO8Mb5em2uxOfIBq8Qi1jl7LV9GjGNu', 76, '0', 'APA91bHjzJ1zoEXY4FfhdknkQjJLvl1IpSUJ7Nw_12TUO1_vH211EOmuKN3XS5T7VtEzthfMeqyBfWtLkKlDx79A0v2s1d8FFCjgyRLIaboF-yngF9raj1o', '', 'staff', 'yTBcqvA1RWgJe7J4iymqm5sLH4R109NpYgjMrPVXY1BIgHqQtqfmJOGsFHar', '2015-12-30 10:10:53', '2015-12-30 10:12:13'),
(94, '', '', '', 'dfndfj', 'vdfvf', '456789', 'm@r.com', '$2y$10$4Leu0HlqqUQAzXGi42R56O5OhpCfWT96As2udNGsr8Da8UDj9ShQ2', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', 'RqSMRMrRAkNKE5CGTi9lq6y2EZqPiv0AkMeJdQDBUBIG87zSuYqDUsxhuhbB', '2016-01-01 03:06:04', '2016-01-01 03:06:21'),
(95, 'Steven', '', '741258369', '', '', '', 'stevengill930@gmail.com', '$2y$10$xtOUgsR9VLReeQxohmrpYONewIRdRclggIfuZa5fOrNRbJSK.EVG6', 75, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-01 07:02:03', '2016-01-01 07:02:03'),
(96, '', '', '', 'Marwa', 'Deward', '8523697412', 'marwa@gmail.com', '$2y$10$B4wSXIPaO0Izri7JLHa6meflpUUHZlL7b2g1hfn/X3L4kIf5BvJsi', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', '1507MQJp0ka82teZdFhkqIO2Papn86ylP09uE8tVmPXX8cp0Ycx5DyLuVfVg', '2016-01-01 07:14:49', '2016-01-01 07:15:16'),
(97, 'Steven', '', '852369742', '', '', '', 'stevengill903@gmail.com', '$2y$10$aZAOWHHWqHwujLnCJyVbHOF80O1UmFhKm1nHRn/bK.3geh51p.b8W', 75, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '4hBW6Bvs6EOIlYZI3MfdavWZAIEX2VZMdHH8db1a9T8G2nBSpn2JZaPBDNza', '2016-01-01 07:36:01', '2016-01-01 07:40:38'),
(98, '', '', '', 'gdsgdds', 'gdsgg', '123456', 'r@m.com', '$2y$10$lm9CCeJUKrRDhwbnYbOC..A83.efQ8Vlx5/bzQqvyxy1p6YvPQchi', 0, '0', '', '', 'venue_owner', 'CShHbfJQ5teNkk60F8BqKmHL1mro0uUPp9xNmNrfZe0vK2ey1DvUL2li4MD3', '2016-01-04 11:51:03', '2016-01-04 11:51:27'),
(99, '', '', '', 'mudassar', 'khalil', '0123456', 'r@q.com', '$2y$10$GQlrISzJNc539DAvgtMIW.91PizethKIFOI5yoGrewBXRf9xxwz22', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'Q18GhjI6xAY7Soy4Qh6a6Df8g5crVJwGEzwhQCvI6yFLUSTy4qigm6yXm0Jc', '2016-01-07 06:16:33', '2016-01-07 06:16:54'),
(100, '', '', '', 'rao', 'mudassar', '03454973699', 'rao.mudassar@curiologix.com', '$2y$10$gF64ye/BmNcMjhNZ1ccr0O7OL5zaZh4D6naKpG5eshKb.NpoEHmoS', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'venue_owner', '4ydyc42GfbPppcjGopBts9SQBlUheFP8DiYTp0FL2vdtdnqtWl6r23Jcg8t3', '2016-01-07 08:27:01', '2016-01-07 08:27:37'),
(101, 'Jhon dee', '', '123456', '', '', '', 'raomudassar5@gmail.com', '$2y$10$M6AAUcnOlnTaWk1cL8LbUuH8.CFSvOcz3TUB4qF.oXynD0RA4jyr.', 100, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-07 10:42:21', '2016-01-07 10:42:21'),
(102, 'Jhon dee', '', '123456', '', '', '', 'shahzad@curiologix.com', '$2y$10$gmZUV10lMaMOH8T9PTt3Gugtm9IA39eV2.6L4sLHWQyyRoEkyqX.2', 100, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-07 10:44:34', '2016-01-07 10:44:34'),
(103, 'dee', '', '123456', '', '', '', 'w@v.com', '$2y$10$51GEQvH0y2zm64mTCq/ApO.Y4zf2zawpFUxtt61WZ.Lmxsu4Rm2/q', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-08 04:52:31', '2016-01-08 04:52:31'),
(104, 'Jhon Dee', '', '123456', '', '', '', 'raomudassar@yahoo.com', '$2y$10$fc.G/7Y.bHk.XjYhGPww9ejlaGqyLFpYeTIgwMNVuE7w0YNvrurW.', 100, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-08 04:57:27', '2016-01-08 04:57:27'),
(105, 'Jhon Dee', '', '123456', '', '', '', 'mudassar52@yahoo.com', '$2y$10$Vc9Sse7PkRKsXslFRdd1FOT6EsqjGQGPmCzms.X1Bwmz80wCLcsAG', 100, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-08 05:03:35', '2016-01-08 05:03:35'),
(106, 'Jhon Dee', '', '123456', '', '', '', 'rmudassar52@yahoo.com', '$2y$10$33evleH/CnfyzkVIFNt6aOWbiJK4/FbH73afJ8AI02GpaFJVTwdM.', 100, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', 'jtmGwMwzeeUv4BkiPq8ix0WF3oInmpyGfPDXMF7jsxOUD5qTctwdvt1fZHRP', '2016-01-08 05:04:51', '2016-01-08 05:08:28'),
(107, '', '', '', 'Mari', 'Ali', '25836971', 'mari@hotmail.com', '$2y$10$Ybpc9hrb6gg5KnmjIEoB2.8rrTUKqZyExUZVT6aGmweCg71Q50UNK', 0, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'user', 'EAtLCvYD7SEGvCmcjRv64CqFyDyTOHDzHJq7b8Cur9zLlQqm4lC8mxeMes4X', '2016-01-08 07:46:52', '2016-01-08 07:47:23'),
(108, 'shahid', '', '123456', '', '', '', 'tahirrana11@gmail.com', '$2y$10$MDFdeyPgHxs7WUbhvVbqJO64q98aGGQjQlYg8QIzFdd9l1CmYd/Ty', 98, '0', 'APA91bFIkbg5PVoSiOvSZDrPM16Pp6jSH3rbjTY7AzF_tIbYTBJ2CIoE-GcDUgtQWmYV43HGiyQL0x5IPRBr1cGUpbLvVPFb10euVM-bFSqII6AJSoMBE2w', '', 'staff', '', '2016-01-11 04:58:45', '2016-01-11 04:58:45'),
(109, '', '', '', 'Ashar Hussain', '', '', '', '$2y$10$W025p1eSKxCR/q6w3p2SK.BlHm30UXs82EkguZK31iz9n5MXNCFUe', 0, '1514317645535585', '', '', 'venue_owner', '', '2016-01-11 11:17:08', '2016-01-11 11:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE IF NOT EXISTS `venues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `venue_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `venue_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `venue_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `venue_website` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `venue_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days_closed` enum('Saturday','Sunday') COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=62 ;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `user_id`, `venue_name`, `venue_address`, `description`, `city`, `state`, `postal_code`, `venue_phone`, `venue_website`, `venue_email`, `time_from`, `time_to`, `latitude`, `longitude`, `days_closed`, `photo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 76, 'Bolaan', 'Lane 2', 'This venue is only for social events.', 'Lahore', 'Punjab', '57000', '258741369', 'www.bolaan.com', 'bolaan@gmail.com', '07 : 53  PM', '11 : 53  PM', '31.550784390603557', '74.35326498001814', 'Sunday', 'venue_2015-12-311893716613.png,venue_2015-12-312141600914.png', '2015-12-31 09:54:05', '2015-12-31 09:54:05', '2016-01-11 03:22:33'),
(20, 76, 'Burraq Marriage Hall', '132 Allama Iqbal Rd', 'This hall is specified for weddings.', 'Lahore', 'Punjab', '57000', '147852369', 'www.burraq.com', 'buraaq@gmail.com', '08 : 04  PM', '11 : 04  PM', '31.554611743640006', '74.35715418308973', 'Sunday', 'venue_2015-12-311775483783.png,venue_2015-12-312118337155.png', '2015-12-31 10:05:18', '2015-12-31 10:05:18', '2016-01-11 03:22:33'),
(35, 73, 'Lahore venue', 'Lahore Main', 'This venue is for wedding', 'lahore', 'punjab', '54000', '7923277', 'www.venue.com', 'venue@hotmail.com', '7pm', '10pm', '31.6224324', '74.3032045', 'Saturday', 'venue_2016-01-061179315784.jpg', '2016-01-06 09:56:28', '2016-01-06 09:56:28', '2016-01-11 03:22:33'),
(61, 98, 'PC Hotel', 'Mall', 'dafghkjl;', 'lahore', 'punjab', '0000', '123456', 'http://www.google.com', 'r@m.com', '   3:00 PM', '   1:00 AM', '0.00000', '0.00000', '', 'venue_2016-01-12749675691.jpg', '2016-01-12 06:13:55', '2016-01-12 06:13:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `venue_ratings`
--

CREATE TABLE IF NOT EXISTS `venue_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `venue_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `venue_likes` int(11) NOT NULL,
  `favourites` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `venue_ratings`
--

INSERT INTO `venue_ratings` (`id`, `user_id`, `venue_id`, `likes`, `venue_likes`, `favourites`, `type`, `event_id`, `created_at`, `updated_at`) VALUES
(45, 76, '19', 0, 0, 1, 'venue', '0', '2015-12-31 09:55:29', '2015-12-31 09:55:29'),
(46, 76, '20', 1, 0, 0, 'venue', '0', '2015-12-31 10:05:36', '2015-12-31 10:05:36'),
(47, 75, '22', 0, 1, 1, 'venue', '0', '2016-01-01 06:12:30', '2016-01-01 06:12:30'),
(48, 96, '22', 0, 1, 1, 'venue', '0', '2016-01-01 07:17:19', '2016-01-01 07:17:19'),
(49, 97, '22', 0, 0, 0, 'venue', '0', '2016-01-01 07:41:27', '2016-01-01 07:41:27'),
(50, 77, '22', 0, 0, 1, 'venue', '0', '2016-01-04 03:14:21', '2016-01-04 03:14:21'),
(51, 77, '20', 1, 0, 0, 'venue', '0', '2016-01-06 10:52:01', '2016-01-06 10:52:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
