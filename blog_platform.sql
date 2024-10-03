-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 07:18 PM
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
-- Database: `blog_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `tags`, `status`, `created_at`, `updated_at`) VALUES
(6, 2, 'Animal', '<span style=\"text-decoration: underline;\">hello</span>', '#saveanimale', 'published', '2024-10-02 08:16:20', '2024-10-02 14:31:51'),
(9, 3, 'Movies', '<strong>The moving images of a film are created b</strong>y photographing actual scenes with a motion-picture camera, by photographing drawings or miniature models using traditional animation techniques, by means of CGI and computer animation, or by a combination of some or all of these techniques, and other visual effects.\\r\\n\\r\\nBefore the introduction of digital production, a series of still images were recorded on a strip of chemically sensitized celluloid (photographic film stock), usually at a rate of 24 frames per second. The images are transmitted through a movie projector at the same rate as they were recorded, with a Geneva drive ensuring that each frame remains still during its short projection time. A rotating shutter causes stroboscopic intervals of darkness, but the viewer does not notice the interruptions due to flicker fusion. The apparent motion on the screen is the result of the fact that the visual sense cannot discern the individual images at high speeds, so the impressions of the images blend with the dark intervals and are thus linked together to produce the illusion of one moving image. An analogous optical soundtrack (a graphic recording of the spoken words, music, and other sounds) runs along a portion of the film exclusively reserved for it, and was not projected.\\r\\n\\r\\nContemporary films are usually fully digital through the entire process of production, distribution, and exhibition.', '#Movies', 'published', '2024-10-02 17:42:15', '2024-10-02 17:42:31'),
(21, 1, 'Css( for styling)', 'The Blog layout consists of a header, navigation menu, main content area, and footer. The header contains the website logo, name, and its tagline. The navigation menu is used to allow users to easily navigate through the different sections of the blog. The main content area contains the list of blog posts with title, author name, published date, and content. Also, there is an archive section, that contains recently published articles list. The footer section contains additional information such as links to the blog&rsquo;s social media profiles and a copyright notice.', 'Css', 'published', '2024-10-03 08:39:43', '2024-10-03 09:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'radhe5886', 'abc@gmail.com', '$2y$10$tjKOwRIRYfx6pYDa31OjdO5XPjaXV3l60mnSaWy8GeVzqZRakkxL6', '2024-09-30 09:08:03'),
(2, 'Hardik', 'ambhoreradheshyam@gmail.com', '$2y$10$j2DCn5GbQaPOHORHtu9BxetgTzGgCm0ActOk4mFDnvIr5HSRPyOMO', '2024-10-01 15:46:38'),
(3, 'venu', 'venu@gmail.com', '$2y$10$278In1Ff7prh6.lk1ovH1OIQaMFynkzFt.OVgx/44c2MHd6tq..fy', '2024-10-01 16:19:53'),
(5, 'shree', 'shree@gamil.com', '$2y$10$dyXSgg0Pc6rTsf0U0jzUFOW473Iog4Had3Ap4OElrB8AU6947vX4y', '2024-10-03 10:51:07'),
(6, 'om', 'om@gmail.com', '$2y$10$e00knvbn0r3eIjxPOiWMiOw3DteUg8RtZh3Rr/21.4drD2aF33S1K', '2024-10-03 17:14:37'),
(7, 'yash', 'yash@gmail.com', '$2y$10$Rp2k..MT/XYjE3OAy5agKebynBYMwa9XXeTllqPF2tLoMB.IzqmLi', '2024-10-03 17:16:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
