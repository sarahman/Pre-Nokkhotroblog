--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `name`, `user_status`, `password`, `email_address`, `role_id`, `last_login`, `create_date`, `update_date`, `create_by`, `update_by`) VALUES
(1, 'admin', 'admin', 'active', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'salayhin@gmail.com', 0, '2012-06-19 20:29:53', '2012-06-19 00:00:00', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`blog_category_id`, `category_name`) VALUES
(1, 'sports'),
(2, 'golpo'),
(3, 'natok'),
(4, 'choto_golpo');

-- --------------------------------------------------------

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `title`) VALUES
(1, 'admin'),
(2, 'user');

----------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `user_status`, `name`, `username`, `password`, `email_address`, `user_image`, `activation_code`, `last_login`, `create_date`, `update_date`) VALUES
(2, 0, 'active', 'Sirajus', 'salayhin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'salayhin@gmail.com', '', 'f87b2a80176935fba50ab75164604aeaf4d454b7', '2012-06-19 16:36:27', '2012-06-16 02:23:50', '2012-06-19 10:36:27'),

-- --------------------------------------------------------

--
-- Dumping data for table `user_statuses`
--

INSERT INTO `user_statuses` (`user_status`) VALUES
('active'),
('banned'),
('in-active');