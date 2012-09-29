-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2012 at 05:05 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_status` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email_address` varchar(120) NOT NULL,
  `role_id` tinyint(5) NOT NULL,
  `last_login` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `role_id` (`role_id`),
  KEY `user_status` (`user_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_category_id` tinyint(6) NOT NULL,
  `post_type` varchar(100) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `episode_number` varchar(50) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `permalink` varchar(500) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `is_post` int(1) NOT NULL,
  `is_selected` tinyint(1) NOT NULL DEFAULT '0',
  `sticky_on_home_page` tinyint(1) NOT NULL DEFAULT '0',
  `publish_date` datetime NOT NULL,
  `viewed` int(11) NOT NULL,
  `featured_image` varchar(250) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `last_modaretion_date` datetime NOT NULL,
  `last_modarate_by` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`),
  KEY `blog_category_id` (`blog_category_id`),
  KEY `is_selected` (`is_selected`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `blog_category_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`blog_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_groups`
--

CREATE TABLE IF NOT EXISTS `blog_groups` (
  `blog_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_group_type_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `blog_group` varchar(50) NOT NULL,
  `blog_group_permalink` varchar(50) NOT NULL,
  `blog_group_is_published` tinyint(1) NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `last_moderate_by` int(11) NOT NULL,
  `last_moderate_date` datetime NOT NULL,
  PRIMARY KEY (`blog_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_group_posts`
--

CREATE TABLE IF NOT EXISTS `blog_group_posts` (
  `blog_group_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_group_id` int(11) NOT NULL,
  `blog_group_post_permalink` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `page_number` int(11) NOT NULL,
  `blog_group_post_is_published` tinyint(4) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `last_moderate_by` int(11) NOT NULL,
  `last_moderate_date` datetime NOT NULL,
  PRIMARY KEY (`blog_group_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_group_types`
--

CREATE TABLE IF NOT EXISTS `blog_group_types` (
  `blog_group_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_type` varchar(50) CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`blog_group_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `total_comments` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `comments`:
--   `blog_id`
--       `blogs` -> `blog_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE IF NOT EXISTS `discussions` (
  `discussion_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `is_open` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `valid_day` tinyint(2) NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`discussion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_comments`
--

CREATE TABLE IF NOT EXISTS `discussion_comments` (
  `discussion_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `discussion_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`discussion_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `episode_name`
--

CREATE TABLE IF NOT EXISTS `episode_name` (
  `episode_id` int(11) NOT NULL AUTO_INCREMENT,
  `episode_name` varchar(250) NOT NULL,
  `create_by` int(11) NOT NULL,
  PRIMARY KEY (`episode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `favorite_post_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `feedback` text NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `novels`
--

CREATE TABLE IF NOT EXISTS `novels` (
  `novel_id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_name_id` int(11) NOT NULL,
  `novel_post_permalink` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `page_number` int(11) NOT NULL,
  `novel_is_published` tinyint(4) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`novel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `novel_name`
--

CREATE TABLE IF NOT EXISTS `novel_name` (
  `novel_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_name` varchar(150) NOT NULL,
  `novel_name_permalink` varchar(250) NOT NULL,
  `novel_name_is_published` tinyint(1) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `last_modarate_by` int(11) NOT NULL,
  `last_modarate_date` datetime NOT NULL,
  PRIMARY KEY (`novel_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) NOT NULL,
  `permalink` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `last_moderate_by` int(11) NOT NULL,
  `last_moderate_date` datetime NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_types`
--

CREATE TABLE IF NOT EXISTS `post_types` (
  `post_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` varchar(50) NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`post_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_status`
--

CREATE TABLE IF NOT EXISTS `system_status` (
  `system_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(350) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`system_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` tinyint(2) NOT NULL,
  `auth_token` varchar(50) NOT NULL,
  `user_status` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `bio` text NOT NULL,
  `profile_picture` varchar(500) NOT NULL,
  `avater` varchar(500) NOT NULL,
  `user_panel_banner` varchar(500) NOT NULL,
  `tagline` varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `facebook_link` varchar(250) NOT NULL,
  `twitter_link` varchar(250) NOT NULL,
  `gtalk_link` varchar(250) NOT NULL,
  `linkedin_link` varchar(250) NOT NULL,
  `activation_code` varchar(50) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_statuses`
--

CREATE TABLE IF NOT EXISTS `user_statuses` (
  `user_status` varchar(25) NOT NULL,
  PRIMARY KEY (`user_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
