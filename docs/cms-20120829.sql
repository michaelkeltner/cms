-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2012 at 12:13 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE IF NOT EXISTS `asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`id`, `name`, `display_name`, `type`, `size`, `modify_date`, `create_date`) VALUES
(46, 'waiverDatabaseModel.pdf', 'waiver DB Model', 'doc', 63173, '2012-06-29 16:17:26', '2012-06-29 21:17:26'),
(49, 'benefits.jpg', 'Benifits', 'image', 10389, '2012-07-05 10:06:45', '2012-07-05 15:06:45'),
(50, 'enrollment.jpg', 'Enrollment', 'image', 14325, '2012-07-05 10:06:53', '2012-07-05 15:06:53'),
(51, 'claims.jpg', 'Claims', 'image', 6747, '2012-07-05 10:07:03', '2012-07-05 15:07:03'),
(52, 'main.jpg', 'Main', 'image', 18480, '2012-07-05 10:07:11', '2012-07-05 15:07:11'),
(56, 'testStyle.css', 'Test CSS', 'doc', 1566, '2012-08-24 15:46:50', '2012-08-24 20:46:50'),
(57, 'oc-logo.png', 'Logo OC', 'image', 3956, '2012-08-28 14:57:15', '2012-08-28 19:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_field_owner_id` int(11) NOT NULL,
  `module_item_owner_id` int(11) NOT NULL,
  `module_field_requester_id` int(11) NOT NULL,
  `module_item_requester_id` int(11) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_field_owner_id` (`module_field_owner_id`,`module_field_requester_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`id`, `module_field_owner_id`, `module_item_owner_id`, `module_field_requester_id`, `module_item_requester_id`, `modify_date`, `create_date`) VALUES
(2, 17, 2, 50, 2, '2012-08-23 21:27:17', '2012-08-23 16:27:17'),
(13, 17, 1, 50, 4, '2012-08-24 19:03:50', '2012-08-24 14:03:50'),
(14, 17, 2, 50, 5, '2012-08-24 19:10:41', '2012-08-24 14:10:41'),
(15, 17, 7, 50, 5, '2012-08-24 19:10:41', '2012-08-24 14:10:41'),
(16, 17, 2, 50, 3, '2012-08-24 19:10:49', '2012-08-24 14:10:49'),
(17, 17, 1, 50, 3, '2012-08-24 19:10:49', '2012-08-24 14:10:49'),
(18, 17, 7, 50, 3, '2012-08-24 19:10:49', '2012-08-24 14:10:49'),
(26, 17, 2, 50, 1, '2012-08-24 19:14:54', '2012-08-24 14:14:54'),
(27, 17, 7, 50, 1, '2012-08-24 19:14:54', '2012-08-24 14:14:54'),
(49, 16, 7, 87, 1, '2012-08-28 16:31:57', '2012-08-28 11:31:57'),
(55, 17, 0, 87, 2, '2012-08-28 16:34:26', '2012-08-28 11:34:26'),
(56, 64, 2, 88, 2, '2012-08-28 16:34:26', '2012-08-28 11:34:26'),
(59, 17, 1, 87, 3, '2012-08-28 16:34:44', '2012-08-28 11:34:44'),
(60, 17, 7, 87, 3, '2012-08-28 16:34:44', '2012-08-28 11:34:44'),
(61, 64, 1, 88, 3, '2012-08-28 16:34:44', '2012-08-28 11:34:44'),
(72, 64, 0, 94, 55, '2012-08-28 17:03:41', '2012-08-28 12:03:41'),
(125, 91, 2, 126, 2, '2012-08-29 15:03:24', '2012-08-29 10:03:24'),
(126, 112, 5, 127, 2, '2012-08-29 15:03:24', '2012-08-29 10:03:24'),
(127, 118, 5, 128, 2, '2012-08-29 15:03:24', '2012-08-29 10:03:24'),
(134, 118, 3, 128, 3, '2012-08-29 15:21:57', '2012-08-29 10:21:57'),
(135, 91, 75, 126, 1, '2012-08-29 15:22:56', '2012-08-29 10:22:56'),
(136, 112, 5, 127, 1, '2012-08-29 15:22:56', '2012-08-29 10:22:56'),
(137, 118, 1, 128, 1, '2012-08-29 15:22:56', '2012-08-29 10:22:56'),
(140, 64, 2, 94, 75, '2012-08-29 15:43:21', '2012-08-29 10:43:21'),
(141, 17, 2, 50, 6, '2012-08-29 18:20:55', '2012-08-29 13:20:55'),
(142, 17, 7, 50, 6, '2012-08-29 18:20:55', '2012-08-29 13:20:55'),
(150, 91, 1, 126, 3, '2012-08-29 19:51:33', '2012-08-29 14:51:33'),
(151, 112, 5, 127, 3, '2012-08-29 19:51:33', '2012-08-29 14:51:33'),
(152, 91, 2, 126, 4, '2012-08-29 19:51:47', '2012-08-29 14:51:47'),
(153, 112, 10, 127, 4, '2012-08-29 19:51:47', '2012-08-29 14:51:47'),
(154, 17, 2, 50, 7, '2012-08-29 21:02:46', '2012-08-29 16:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `carrier`
--

CREATE TABLE IF NOT EXISTS `carrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` text,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `toll_free` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `carrier`
--

INSERT INTO `carrier` (`id`, `notes`, `name`, `address`, `address2`, `city`, `state`, `zip`, `phone`, `toll_free`, `fax`, `website`, `email`, `modify_date`, `create_date`) VALUES
(1, 's:4:"test";', 'ACE American Insurance Company', '', '', '', '', '', '', '', '', '', '', '2012-08-29 18:26:10', '0000-00-00 00:00:00'),
(2, NULL, 'Combined Insurance Company of America', '', '', '', '', '', '', '', '', '', '', '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(3, NULL, 'Monumental Life Insurance Company', '', '', '', '', '', '', '', '', '', '', '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(4, NULL, 'Peoples Benefit Life Insurance Company', '', '', '', '', '', '', '', '', '', '', '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(5, NULL, 'ARM', '', '', '', '', '', '', '', '', '', '', '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(6, NULL, 'AIG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(7, NULL, 'HARTFORD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(8, NULL, 'Nationwide Life Insurance Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(9, NULL, 'AHP Demo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(10, NULL, 'Virginia Surety Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(11, NULL, 'UniCare', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(12, NULL, 'Chubb & Sons', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(13, NULL, 'Assist America', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(14, NULL, 'ACE American Insurance Company - Study Abroad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(15, NULL, 'AETNA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(16, NULL, 'Fidelity Security Life Insurance Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(17, NULL, 'Humana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(18, NULL, 'CIGNA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(19, NULL, 'Blue Cross Blue Shield of Texas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(20, NULL, 'United Healthcare', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(21, NULL, 'CDPHP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(22, NULL, 'US Fire', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(23, NULL, 'Axis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(24, NULL, 'Chartis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(25, NULL, 'Markel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(26, NULL, 'Independence Administrators', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(27, NULL, 'AES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(28, NULL, 'Arch Insurance Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(29, NULL, 'ACE P and C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(30, NULL, 'Blue Cross Blue Shield of Oklahoma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00'),
(31, NULL, 'Blue Cross Blue Shield of Illinois', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-08-28 18:32:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`id`, `name`, `type`, `sort_order`, `description`) VALUES
(1, 'Text', 'text', 2, ''),
(2, 'Association', 'association', 3, 'Allows an entry to be linked to another modules entry'),
(3, 'Date', 'date', 9, ''),
(4, 'Number', 'number', 6, ''),
(5, 'Header', 'header', 1, 'allows to have a banner on the module entry form'),
(6, 'Active', 'active', 5, 'allows a module entry to be flagged as active or inactive'),
(7, 'Sort Order', 'sortorder', 4, 'Determines the order in which the item is to be listed'),
(8, 'Time', 'time', 10, ''),
(9, 'Date and Time', 'datetime', 8, 'combines both date and time into one field'),
(10, 'File', 'file', 11, 'Allows a module to have a file associated with it'),
(11, 'Image', 'image', 12, ''),
(12, 'WYSIWYG', 'wysiwyg', 13, '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `module_id`, `name`, `sort_order`, `icon`, `modify_date`, `create_date`) VALUES
(1, 1, 'Assets', 3, 'menu-asset.png', '2012-08-29 18:16:18', '2012-08-16 16:55:47'),
(10, 6, 'Theme', 7, 'menu-theme.png', '2012-08-29 18:16:18', '2012-08-17 14:46:43'),
(11, 7, 'User', 9, 'menu-user.png', '2012-08-29 18:16:18', '2012-08-17 14:46:43'),
(12, 10, 'Role', 10, 'menu-role.png', '2012-08-29 18:16:18', '2012-08-17 14:46:43'),
(13, 9, 'Module', 11, 'menu-role.png', '2012-08-29 18:16:18', '2012-08-17 14:46:43'),
(17, 21, 'staff', 6, 'menu-user.png', '2012-08-29 18:16:18', '2012-08-17 15:41:31'),
(18, 30, 'test', 8, 'menu-contact.png', '2012-08-29 18:16:18', '2012-08-20 16:46:27'),
(21, 46, 'School', 1, 'menu-school.png', '2012-08-29 18:16:18', '2012-08-28 11:40:10'),
(22, 47, 'carrier', 2, 'menu-carrier.png', '2012-08-29 18:16:18', '2012-08-28 13:29:01'),
(23, 48, 'period', 4, 'menu-period.png', '2012-08-29 18:16:18', '2012-08-28 13:48:35'),
(24, 49, 'section', 5, 'menu-section.png', '2012-08-29 18:16:18', '2012-08-28 15:17:23'),
(26, 50, 'School Content', 0, 'menu-content.png', '2012-08-29 18:16:18', '2012-08-29 13:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `display_name`, `description`, `type`, `active`, `modify_date`, `create_date`) VALUES
(1, 'asset', 'asset', '', 'static', 1, '2012-07-09 15:05:09', '2012-07-09 10:05:09'),
(6, 'theme', 'theme', 'CSS files can be loaded here', 'generic', 1, '2012-07-09 15:07:40', '2012-07-09 10:07:40'),
(7, 'user', 'user', '', 'system', 1, '2012-07-09 15:07:40', '2012-07-09 10:07:40'),
(9, 'module', 'module', '', 'system', 1, '2012-07-09 15:08:31', '2012-07-09 10:08:31'),
(10, 'role', 'role', '', 'system', 1, '2012-07-09 16:32:59', '2012-07-09 11:32:59'),
(21, 'staff', 'Staff', 'AHP Staff', 'generic', 1, '2012-08-13 17:51:16', '2012-08-13 12:51:16'),
(30, 'test', 'More Test', 'TEST', 'generic', 1, '2012-08-20 21:43:24', '2012-08-20 16:43:24'),
(46, 'school', 'School', '', 'generic', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(47, 'carrier', 'Carrier', '', 'generic', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(48, 'period', 'Period', '', 'generic', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(49, 'section', 'Section', '', 'generic', 1, '2012-08-28 20:15:54', '2012-08-28 15:15:54'),
(50, 'school_content', 'School Webpage Content', 'Enter content for a single section of a schools webpage', 'generic', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `module_field`
--

CREATE TABLE IF NOT EXISTS `module_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`,`field_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `module_field`
--

INSERT INTO `module_field` (`id`, `module_id`, `field_id`, `sort_order`, `name`, `display_name`, `description`, `options`, `active`, `modify_date`, `create_date`) VALUES
(13, 21, 5, 0, 'header', 'General Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-13 19:59:20', '0000-00-00 00:00:00'),
(16, 21, 1, 1, 'first_name', 'first name', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-15 14:23:54', '2012-08-15 09:23:54'),
(17, 21, 1, 2, 'last_name', 'last name', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:25:54', '2012-08-16 15:25:54'),
(18, 21, 1, 3, 'title', 'Title', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:30:11', '2012-08-16 15:30:11'),
(19, 21, 5, 4, 'header', 'Contact Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:30:11', '2012-08-16 15:30:11'),
(20, 21, 1, 5, 'email', 'Email', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:30:11', '2012-08-16 15:30:11'),
(21, 21, 1, 6, 'phone', 'Phone Number', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:30:11', '2012-08-16 15:30:11'),
(22, 21, 5, 7, 'header', 'Details', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 20:30:11', '2012-08-16 15:30:11'),
(35, 21, 5, 10, 'header', 'Office Hours', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 21:05:01', '2012-08-16 16:05:01'),
(39, 21, 6, 8, 'active', 'is Active', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-16 21:07:21', '2012-08-16 16:07:21'),
(40, 30, 5, 0, 'header', 'Testing', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-20 21:45:22', '2012-08-20 16:45:22'),
(42, 30, 6, 1, 'active', 'Is Active', 'allows a module entry to be flagged as active or inactive', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:37:28', '2012-08-21 08:37:28'),
(43, 21, 9, 9, 'birthday', 'Birthday', 'combines both date and time into one field', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:51:36', '2012-08-21 08:51:36'),
(44, 21, 8, 11, 'start_office', 'Start of the day', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:51:36', '2012-08-21 08:51:36'),
(45, 21, 8, 12, 'end_office', 'Gone for the day', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:51:36', '2012-08-21 08:51:36'),
(46, 21, 3, 13, 'vacation_start', 'Vacation start', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:51:36', '2012-08-21 08:51:36'),
(47, 21, 9, 14, 'vacation_end', 'Vacation end', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-21 13:53:12', '2012-08-21 08:53:12'),
(50, 30, 2, 2, 'staff', 'Staff', 'Select the staff member', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:2:"21";s:8:"field_id";s:2:"17";s:8:"multiple";s:1:"1";}', 1, '2012-08-21 20:07:30', '2012-08-21 15:07:30'),
(55, 30, 1, 3, 'another_entry_changed', 'Something New', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 20:04:44', '2012-08-24 15:04:44'),
(56, 30, 1, 4, 'add_me', 'add me', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 20:05:26', '2012-08-24 15:05:26'),
(59, 30, 10, 5, 'theme', 'theme file', 'Allows a module to have a file associated with it', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 20:09:46', '2012-08-24 15:09:46'),
(60, 30, 11, 6, 'logo', 'Logo', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 20:09:46', '2012-08-24 15:09:46'),
(64, 6, 1, 0, 'name', 'name', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 21:52:55', '2012-08-24 16:52:55'),
(65, 6, 10, 1, 'css_file', 'File', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-24 21:52:55', '2012-08-24 16:52:55'),
(66, 30, 1, 7, 'asdf', 'asdf', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-27 21:26:07', '2012-08-27 16:26:07'),
(90, 46, 5, 0, 'header', 'General Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(91, 46, 1, 1, 'name', 'Name', 'Name of the school', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(92, 46, 5, 3, 'header', 'Website Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(93, 46, 1, 4, 'slug', 'Slug', 'school website id (oc for www.oc.edu; niu for www.niu.edu ...)', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(94, 46, 2, 5, 'theme_id', 'Theme', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"6";s:8:"field_id";s:2:"64";s:8:"multiple";s:1:"1";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(95, 46, 5, 6, 'header', 'Details', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(96, 46, 6, 7, 'active', 'Is Active', 'Is this school an active client', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(97, 46, 7, 8, 'sort_order', 'Sort Order', 'Default listing order for the school', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 16:39:29', '2012-08-28 11:39:29'),
(98, 47, 5, 0, 'header', 'General Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(99, 47, 1, 1, 'name', 'Name', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(100, 47, 5, 2, 'header', 'Contact Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(101, 47, 1, 3, 'address', 'Address', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(102, 47, 1, 4, 'address2', 'Address 2', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(103, 47, 1, 5, 'city', 'City', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(104, 47, 1, 6, 'state', 'State', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(105, 47, 1, 7, 'zip', 'Zip', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(106, 47, 1, 8, 'phone', 'Phone', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(107, 47, 1, 9, 'toll_free', 'Toll Free Number', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(108, 47, 1, 10, 'fax', 'Fax', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(109, 47, 1, 11, 'website', 'Website', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(110, 47, 1, 12, 'email', 'Email', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:27:53', '2012-08-28 13:27:53'),
(111, 48, 5, 0, 'header', 'General Information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(112, 48, 1, 1, 'name', 'Name', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(113, 48, 1, 2, 'slug', 'Slug', 'The part that identifies the period in the url (ex. the 2012-2013 school year for oc could be named 2012-2013 so it will be used as www.academichealthplans.com/oc/2012-2013/)', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(114, 48, 6, 3, 'active', 'Is Active', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(115, 48, 7, 4, 'sort_order', 'Sort Order', 'Determines the order in which the item is to be listed', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 18:45:30', '2012-08-28 13:45:30'),
(117, 46, 11, 2, 'logo', 'logo', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 19:27:53', '2012-08-28 14:27:53'),
(118, 49, 1, 0, 'name', 'Name', '', 'a:4:{s:4:"list";s:1:"1";s:8:"multiple";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";}', 1, '2012-08-28 20:15:54', '2012-08-28 15:15:54'),
(119, 49, 6, 1, 'active', 'Is Active', '', 'a:4:{s:4:"list";s:1:"1";s:8:"multiple";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";}', 1, '2012-08-28 20:15:54', '2012-08-28 15:15:54'),
(120, 49, 7, 2, 'sort_order', 'Sort Order', 'Determines the order in which the item is to be listed', 'a:4:{s:4:"list";s:1:"1";s:8:"multiple";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";}', 1, '2012-08-28 20:15:54', '2012-08-28 15:15:54'),
(123, 30, 12, 8, 'content', 'Content', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-28 21:28:11', '2012-08-28 16:28:11'),
(124, 50, 5, 0, 'header', 'General information', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(125, 50, 1, 1, 'name', 'Name', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(126, 50, 2, 2, 'school', 'School', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:2:"46";s:8:"field_id";s:2:"91";s:8:"multiple";s:1:"1";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(127, 50, 2, 3, 'period', 'Period', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:2:"48";s:8:"field_id";s:3:"112";s:8:"multiple";s:1:"1";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(129, 50, 12, 4, 'content', 'Page Content', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(130, 50, 5, 5, 'header', 'Scheduling', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(131, 50, 9, 6, 'active_date', 'Active Date', 'When does this section become active?', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(132, 50, 9, 7, 'inactive_date', 'Inactive Date', 'When does this section become inactive?', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(133, 50, 5, 8, 'header', 'Details', '', 'a:4:{s:4:"list";s:1:"0";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(134, 50, 7, 9, 'sort_order', 'Sort Order', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(135, 50, 6, 10, 'active', 'Is Active', '', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 14:54:31', '2012-08-29 09:54:31'),
(136, 30, 9, 9, 'show_date', 'Active Show Date', 'when is this active', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 15:16:58', '2012-08-29 10:16:58'),
(137, 30, 9, 10, 'hide_date', 'asdfasdf', 'combisdfasf', 'a:4:{s:4:"list";s:1:"1";s:9:"module_id";s:1:"0";s:8:"field_id";s:1:"0";s:8:"multiple";s:1:"0";}', 1, '2012-08-29 15:16:58', '2012-08-29 10:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE IF NOT EXISTS `period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `name`, `slug`, `active`, `sort_order`, `modify_date`, `create_date`) VALUES
(1, 'Spring 2012', '2013-2014', 1, 1, '2012-08-28 18:48:45', '0000-00-00 00:00:00'),
(4, 'Summer 2012', 'Summer2012', 1, 2, '2012-08-28 18:48:47', '0000-00-00 00:00:00'),
(5, 'Fall 2012', 'Fall2012', 1, 3, '2012-08-28 18:48:58', '0000-00-00 00:00:00'),
(10, 'Spring 2014', '2014-2015', 1, 4, '2012-08-28 18:48:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `modify_date`, `create_date`) VALUES
(1, 'create', '2012-07-09 15:29:31', '2012-07-09 10:29:31'),
(2, 'read', '2012-07-09 15:29:31', '2012-07-09 10:29:31'),
(3, 'update', '2012-07-09 15:29:31', '2012-07-09 10:29:31'),
(4, 'delete', '2012-07-09 15:29:31', '2012-07-09 10:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role_module`
--

CREATE TABLE IF NOT EXISTS `permission_role_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `module_id` (`module_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=890 ;

--
-- Dumping data for table `permission_role_module`
--

INSERT INTO `permission_role_module` (`id`, `role_id`, `permission_id`, `module_id`, `modify_date`, `create_date`) VALUES
(367, 11, 1, 1, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(368, 11, 4, 1, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(369, 11, 2, 1, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(370, 11, 3, 1, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(387, 11, 1, 6, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(388, 11, 4, 6, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(389, 11, 2, 6, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(390, 11, 3, 6, '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(406, 6, 2, 1, '2012-07-19 20:21:56', '2012-07-19 15:21:56'),
(412, 6, 2, 6, '2012-07-19 20:21:56', '2012-07-19 15:21:56'),
(419, 5, 1, 1, '2012-07-20 15:31:08', '2012-07-20 10:31:08'),
(425, 5, 1, 6, '2012-07-20 15:31:08', '2012-07-20 10:31:08'),
(426, 8, 4, 1, '2012-07-20 15:31:23', '2012-07-20 10:31:23'),
(432, 8, 4, 6, '2012-07-20 15:31:23', '2012-07-20 10:31:23'),
(433, 7, 3, 1, '2012-07-20 15:31:49', '2012-07-20 10:31:49'),
(439, 7, 3, 6, '2012-07-20 15:31:49', '2012-07-20 10:31:49'),
(443, 14, 4, 1, '2012-07-20 15:57:36', '2012-07-20 10:57:36'),
(445, 14, 2, 7, '2012-07-20 15:57:36', '2012-07-20 10:57:36'),
(842, 1, 1, 1, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(843, 1, 4, 1, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(844, 1, 2, 1, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(845, 1, 3, 1, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(846, 1, 1, 47, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(847, 1, 4, 47, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(848, 1, 2, 47, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(849, 1, 3, 47, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(850, 1, 1, 9, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(851, 1, 4, 9, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(852, 1, 2, 9, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(853, 1, 3, 9, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(854, 1, 1, 48, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(855, 1, 4, 48, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(856, 1, 2, 48, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(857, 1, 3, 48, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(858, 1, 1, 10, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(859, 1, 4, 10, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(860, 1, 2, 10, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(861, 1, 3, 10, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(862, 1, 1, 46, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(863, 1, 4, 46, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(864, 1, 2, 46, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(865, 1, 3, 46, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(866, 1, 1, 50, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(867, 1, 4, 50, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(868, 1, 2, 50, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(869, 1, 3, 50, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(870, 1, 1, 49, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(871, 1, 4, 49, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(872, 1, 2, 49, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(873, 1, 3, 49, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(874, 1, 1, 21, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(875, 1, 4, 21, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(876, 1, 2, 21, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(877, 1, 3, 21, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(878, 1, 1, 30, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(879, 1, 4, 30, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(880, 1, 2, 30, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(881, 1, 3, 30, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(882, 1, 1, 6, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(883, 1, 4, 6, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(884, 1, 2, 6, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(885, 1, 3, 6, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(886, 1, 1, 7, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(887, 1, 4, 7, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(888, 1, 2, 7, '2012-08-29 14:55:36', '2012-08-29 09:55:36'),
(889, 1, 3, 7, '2012-08-29 14:55:36', '2012-08-29 09:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `modify_date`, `create_date`) VALUES
(1, 'Admin', '2012-08-29 14:55:36', '2012-07-19 13:27:55'),
(5, 'Create', '2012-07-20 15:31:08', '2012-07-19 14:06:19'),
(6, 'Read', '2012-07-19 20:21:56', '2012-07-19 14:07:47'),
(7, 'Update', '2012-07-20 15:31:49', '2012-07-19 14:08:41'),
(8, 'Delete', '2012-07-20 15:31:23', '2012-07-19 14:10:06'),
(9, 'School Create', '2012-07-19 19:11:11', '2012-07-19 14:11:11'),
(10, 'School Admin', '2012-07-19 22:29:13', '2012-07-19 14:11:46'),
(11, 'Website', '2012-07-19 19:13:57', '2012-07-19 14:13:57'),
(12, 'Carrier Admin', '2012-07-19 19:14:21', '2012-07-19 14:14:21'),
(13, 'Carrier Create', '2012-07-19 19:14:43', '2012-07-19 14:14:43'),
(14, 'Test', '2012-07-20 15:57:36', '2012-07-20 10:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `logo`, `name`, `slug`, `active`, `sort_order`, `modify_date`, `create_date`) VALUES
(1, NULL, 'Alamo Colleges', 'alamo', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(2, NULL, '  Albany College of Pharmacy', 'acphs', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(3, NULL, 'Alfred University', 'alfred', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(4, NULL, 'Angelo State University', 'angelo', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(5, NULL, 'Austin College', 'austincollege', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(6, NULL, 'Austin College Study Abroad', 'austincollegesa', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(7, NULL, 'Baylor University', 'baylor', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(8, NULL, 'Baylor University Study Abroad', 'baylortravelabroad', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(9, NULL, 'Cameron University', 'cameron', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(10, NULL, 'Cardozo School of Law', 'cardozo', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(11, NULL, 'Central Washington University', 'cwu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(12, NULL, 'Colorado College', 'coloradocollege', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(13, NULL, 'Corcoran College of Art + Design', 'corcoran', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(14, NULL, 'Dallas Baptist University', 'dbu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(15, NULL, 'Dallas Theological Seminary', 'dts', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(16, NULL, 'Davidson College', 'davidson', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(17, NULL, 'East Central University', 'ecu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(18, NULL, 'East Texas Baptist University', 'etbu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(19, NULL, 'Eastern Kentucky University', 'eku', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(20, NULL, 'Hood College', 'hood', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(21, NULL, 'James Madison University', 'jmu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(22, NULL, 'John Brown University', 'jbu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(23, NULL, 'Lamar University', 'lamar', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(24, NULL, 'LeTourneau University', 'letu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(25, NULL, 'Lonestar College System', 'lonestar', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(26, NULL, 'Lonestar College System - Intern', 'lscsinternship', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(27, NULL, 'Loyola University', 'luc', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(28, NULL, 'Mary Washington University', 'umw', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(29, NULL, 'McMurry University', 'mcm', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(30, NULL, 'Midwestern State University', 'mwsu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(31, NULL, 'Missouri State University', 'missouristate', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(32, NULL, 'Northern Illinois University', 'niu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(33, NULL, 'Northeastern State University', 'nsuok', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(34, NULL, 'Oberlin College', 'oberlin', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(35, NULL, 'Odessa College', 'odessa', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(36, NULL, 'Oklahoma Baptist University', 'obu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(37, NULL, 'Oklahoma City University', 'okcu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(38, NULL, 'Oklahoma State University', 'okstate', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(39, NULL, 'Pacific University', 'pacificu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(40, NULL, 'Philadelphia University', 'philau', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(41, NULL, 'Philadelphia University - Needle Stick', 'philau-ns', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(42, NULL, 'Radford University', 'radford', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(43, NULL, 'Sam Houston State University', 'shsu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(44, NULL, 'Schreiner University', 'schreiner', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(45, NULL, 'Southern Illinois University - Edwardsville', 'siue', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(46, NULL, 'Southern Methodist University', 'smu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(47, NULL, 'Southern Nazarene University', 'snu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(48, NULL, 'Southwestern Assemblies of God University', 'sagu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(49, NULL, 'Southwestern Oklahoma State', 'swosu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(50, NULL, 'St. Edwards University', 'stedwards', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(51, NULL, 'St. Mary''s University', 'stmarytx', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(52, NULL, 'SUNY Brockport', 'brockport', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(53, NULL, 'SUNY Plattsburgh State University', 'plattsburgh', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(54, NULL, 'Texas State University', 'txstate', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(55, NULL, 'Texas Tech University', 'ttu', 1, NULL, '2012-08-28 17:03:41', '0000-00-00 00:00:00'),
(56, NULL, 'Texas Wesleyan University', 'txwes', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(57, NULL, 'Texas Woman''s University', 'twu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(58, NULL, 'The University of the Arts', 'uarts', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(59, NULL, 'Trinity University', 'trinity', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(60, NULL, 'Tougaloo College', 'tougaloo', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(61, NULL, 'University of Arkansas', 'uark', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(62, NULL, 'University of Arkansas - Little Rock', 'ular', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(63, NULL, 'University of Arkansas - Medical Sciences', 'uams', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(64, NULL, 'University of Central Oklahoma', 'uco', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(65, NULL, 'University of Kentucky', 'uky', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(66, NULL, 'University of Louisville', 'louisville', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(67, NULL, 'University of Northern Colorado', 'unco', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(68, NULL, 'University of Northern Colorado - Study Abroad', 'uncosa', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(69, NULL, 'University of Texas', 'uttexas', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(70, NULL, 'Virginia Commonwealth University', 'vcu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(71, NULL, 'Western Kentucky University', 'wku', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(72, NULL, 'Western Kentucky University - Study Aborad', 'wkustudyaborad', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(73, NULL, 'Yeshiva University', 'yu', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(74, NULL, 'University of Southern Indiana', 'usi', 1, NULL, '2012-08-28 16:46:41', '0000-00-00 00:00:00'),
(75, 'a:1:{i:0;s:2:"57";}', 'Oklahoma Christian University', 'oc', 0, NULL, '2012-08-29 15:43:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `school_content`
--

CREATE TABLE IF NOT EXISTS `school_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `active_date` datetime DEFAULT NULL,
  `inactive_date` datetime DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `school_content`
--

INSERT INTO `school_content` (`id`, `name`, `content`, `active_date`, `inactive_date`, `sort_order`, `active`, `modify_date`, `create_date`) VALUES
(1, 'OC Main', 's:16:"<h1>testing</h1>";', '2012-08-28 00:00:00', '2012-08-31 00:00:00', NULL, 1, '2012-08-29 15:22:56', '2012-08-29 10:00:04'),
(3, 'Alamo Ben', 's:103:"dfgdfgd\r\ndfg\r\n<h4>dsfg</h4>\r\n<h6>dg</h6>\r\nsdgsd\r\nfg\r\n<a href="http://www.google.com">done</a>\r\nsdfsdfvv";', '1970-01-01 01:00:00', '1970-01-01 01:00:00', NULL, 1, '2012-08-29 19:51:33', '2012-08-29 10:21:49'),
(4, 'test', 's:22:"<h6>ewtwet</h6>\r\nwetwt";', '1970-01-01 01:00:00', '1970-01-01 01:00:00', NULL, 0, '2012-08-29 19:51:47', '2012-08-29 14:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vacation_end` datetime DEFAULT NULL,
  `vacation_start` date DEFAULT NULL,
  `end_office` time DEFAULT NULL,
  `start_office` time DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `vacation_end`, `vacation_start`, `end_office`, `start_office`, `birthday`, `active`, `phone`, `email`, `title`, `last_name`, `first_name`, `modify_date`, `create_date`) VALUES
(1, '1970-01-01 01:00:00', '1970-01-01', '17:00:00', '08:00:00', '1980-02-24 14:00:00', 1, '555-555-5555', 'test@test.com', 'Software Architect', 'Keltner', 'Michael', '2012-08-21 14:27:16', '2012-08-20 10:32:55'),
(2, '1970-01-01 01:00:00', '1970-01-01', '01:00:00', '01:00:00', '1970-01-01 01:00:00', 1, '555-555-1239', 'test@testtest.com', 'Developer', 'Guy', 'Some', '2012-08-21 14:58:17', '0000-00-00 00:00:00'),
(7, '2012-09-04 00:00:00', '2012-09-03', '17:00:00', '08:00:00', '2005-08-27 00:00:00', 1, '', '', 'somethin', 'Smith', 'John', '2012-08-29 14:07:40', '2012-08-23 15:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hide_date` datetime DEFAULT NULL,
  `show_date` datetime DEFAULT NULL,
  `content` text,
  `asdf` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `add_me` varchar(255) DEFAULT NULL,
  `another_entry_changed` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `hide_date`, `show_date`, `content`, `asdf`, `logo`, `theme`, `add_me`, `another_entry_changed`, `active`, `modify_date`, `create_date`) VALUES
(6, '1970-01-01 01:00:00', '1970-01-01 01:00:00', 's:48:"<strong>dfgsdfg</strong>\r\ndfgdfgd\r\n<ol>\r\n</ol>\r\n";', '', 'a:1:{i:0;s:2:"57";}', 'a:1:{i:0;s:2:"46";}', '', '', 1, '2012-08-29 18:20:55', '2012-08-24 14:11:17'),
(7, '1970-01-01 01:00:00', '1970-01-01 01:00:00', 's:4:"test";', '', 'a:1:{i:0;s:2:"49";}', 'a:1:{i:0;s:2:"56";}', 'test', 'test', 1, '2012-08-29 21:02:46', '2012-08-29 13:21:18');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `css_file` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `name`, `css_file`, `create_date`, `modify_date`) VALUES
(1, 'Default', 'a:1:{i:0;s:2:"46";}', '2012-06-08 20:14:52', '2012-08-24 16:23:37'),
(2, 'AHP2', 'a:1:{i:0;s:2:"56";}', '2012-06-26 18:22:06', '2012-08-24 16:25:15'),
(3, 'test', 'a:1:{i:0;s:2:"46";}', '2012-08-24 20:58:41', '2012-08-24 16:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_password` varchar(255) DEFAULT NULL,
  `modify_date` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `temp_password`, `modify_date`, `create_date`) VALUES
(1, 'Admin', 'michael.keltner@ahpcare.com', '842d31f23e38ce6a0f60a806d0640117', 'c715f39fa154471605574a7b6603bf1e', '2012-07-19 14:50:06', '2012-06-25 16:09:13'),
(6, 'Read', 'test2@ahpcare.com', 'ecae13117d6f0584c25a9da6c8f8415e', NULL, '2012-07-20 10:56:39', '2012-07-19 19:16:20'),
(7, 'Create', 'test1@ahpcare.com', '76ea0bebb3c22822b4f0dd9c9fd021c5', NULL, '2012-08-29 16:18:21', '2012-07-19 19:17:02'),
(8, 'School Admin', 'test3@ahpcare.com', '098f6bcd4621d373cade4e832627b4f6', NULL, '2012-07-20 10:39:37', '2012-07-19 19:17:42'),
(9, 'Testing', 'test', '098f6bcd4621d373cade4e832627b4f6', NULL, '2012-08-29 16:08:05', '2012-07-20 16:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `modify_date`, `create_date`) VALUES
(4, 1, 1, '2012-07-19 19:50:25', '2012-07-19 14:50:25'),
(15, 8, 10, '2012-07-20 15:39:37', '2012-07-20 10:39:37'),
(27, 6, 6, '2012-07-20 15:56:39', '2012-07-20 10:56:39'),
(28, 6, 14, '2012-07-20 15:56:39', '2012-07-20 10:56:39'),
(29, 6, 7, '2012-07-20 15:56:39', '2012-07-20 10:56:39'),
(40, 9, 5, '2012-08-29 21:08:05', '2012-08-29 16:08:05'),
(41, 9, 6, '2012-08-29 21:08:05', '2012-08-29 16:08:05'),
(42, 9, 7, '2012-08-29 21:08:05', '2012-08-29 16:08:05'),
(46, 7, 5, '2012-08-29 21:18:21', '2012-08-29 16:18:21'),
(47, 7, 6, '2012-08-29 21:18:21', '2012-08-29 16:18:21'),
(48, 7, 7, '2012-08-29 21:18:21', '2012-08-29 16:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_stats`
--

CREATE TABLE IF NOT EXISTS `user_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `current_login` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `login_count` int(11) NOT NULL,
  `last_duration` int(11) NOT NULL,
  `average_duration` int(11) NOT NULL,
  `last_pages_viewed` int(11) NOT NULL,
  `total_pages_viewd` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `user_stats`
--

INSERT INTO `user_stats` (`id`, `user_id`, `current_login`, `last_login`, `login_count`, `last_duration`, `average_duration`, `last_pages_viewed`, `total_pages_viewd`, `create_date`, `modify_date`) VALUES
(1, 1, '2012-08-29 16:35:00', '2012-08-29 15:19:53', 54, 0, 0, 0, 0, '2012-07-06 16:56:59', '2012-07-06 21:56:59'),
(6, 8, '2012-07-20 17:34:16', '2012-07-20 10:49:37', 13, 0, 0, 0, 0, '2012-07-19 14:19:20', '2012-07-19 19:19:20'),
(19, 6, '2012-07-20 10:57:44', '2012-07-20 10:56:47', 7, 0, 0, 0, 0, '2012-07-19 15:34:37', '2012-07-19 20:34:37'),
(39, 9, '2012-07-20 11:10:18', '0000-00-00 00:00:00', 1, 0, 0, 0, 0, '2012-07-20 11:10:18', '2012-07-20 16:10:18');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_field`
--
ALTER TABLE `module_field`
  ADD CONSTRAINT `module_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_field_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role_module`
--
ALTER TABLE `permission_role_module`
  ADD CONSTRAINT `permission_role_module_ibfk_5` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_module_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_module_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
