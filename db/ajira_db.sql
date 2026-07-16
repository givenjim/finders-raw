-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2026 at 10:27 AM
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
-- Database: `ajira_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `gig_id`, `worker_id`, `cover_letter`, `created_at`) VALUES
(1, 1, 3, 'I am the best for this job wena', '2026-01-30 08:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gigs`
--

CREATE TABLE `gigs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `portfolio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gigs`
--

INSERT INTO `gigs` (`id`, `employer_id`, `title`, `description`, `budget`, `category`, `deadline`, `status`, `created_at`, `portfolio`) VALUES
(1, 6, 'House Paint', 'I am looking for a good house painter', 100.00, 'Painter', '2026-01-31', '', '2026-01-30 08:13:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 3, 3000.00, 'pending', '2026-01-30 06:35:20'),
(2, 15, 15000.00, 'pending', '2026-02-12 18:32:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 1500.00),
(2, 1, 1, 1, 1500.00),
(3, 2, 2, 1, 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `title`, `description`, `price`, `category`, `image`, `status`, `created_at`) VALUES
(1, 3, 'Plumbering', 'The best plumber around', 1500.00, 'Plumber', '1769720674_Spiderman.jpg', 'active', '2026-01-29 21:04:34'),
(2, 3, 'House Manager', 'I am a good cleaner, tidy and on it. Perfect for your house.', 15000.00, 'Remote Service', '1770920978_istockphoto-1449355220-612x612.jpg', 'active', '2026-02-12 18:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `email_verified` tinyint(4) DEFAULT 0,
  `email_code` varchar(10) DEFAULT NULL,
  `phone_verified` tinyint(4) DEFAULT 0,
  `phone_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `phone`, `password`, `created_at`, `profile_image`, `bio`, `location`, `email_verified`, `email_code`, `phone_verified`, `phone_code`) VALUES
(2, 'worker', 'Damaris Gatwiri', 'gatwiridamaris@mail.com', '0796726362', '$2y$10$bvDZJKltMaAHHhhJfkA3ouzLnvukX4ibJH55dtsvlbHBsTXzFeJri', '2026-01-29 09:35:44', NULL, NULL, NULL, 0, NULL, 0, NULL),
(3, 'worker', 'Test User', 'testuser@gmail.com', '0788888888', '$2y$10$Bi/hMb5MI1p4A538FSBzG.NhNedFZwgm6rFjWXgTLRocON.q3.S/.', '2026-01-29 19:41:15', NULL, NULL, NULL, 0, NULL, 0, NULL),
(5, 'worker', 'Given Jim', 'givenjim@gmail.com', '0783848484', '$2y$10$fBZooofaAURfjvpm8vVPcuVaclMh1n3iAWNKWKTvUFlDYI369oplO', '2026-01-30 06:58:41', NULL, NULL, NULL, 0, NULL, 0, NULL),
(6, 'employer', 'Test Employer', 'testemployer@gmail.com', '0780363737', '$2y$10$z1LEZ.BTtTRp3Chiwj.lW.q3jEY/ogxWVKNC4ny9L0ZmbIH5qYirW', '2026-01-30 07:24:45', NULL, NULL, NULL, 0, NULL, 0, NULL),
(7, 'admin', 'Purity Wamaitha', 'wamaithanj@gmail.com', '0704575630', '$2y$10$/vIORkkj04zRh47W6CdnlOJVhiD5EIdqO17ruL31xDOOytCNvC6R6', '2026-01-30 08:36:43', '1769762957_african-teenage-girl-portrait-happy-smiling-face.jpg', '', '', 0, NULL, 0, NULL),
(8, 'worker', 'Domnic Mwitani', 'mwitanidomnic@gmail.com', '0764535535', '$2y$10$MKXVYD8hCL3OE36N9PXeKubOBKXtTw/t06.lPAv9ndHfnwU89mIVi', '2026-01-30 22:11:12', NULL, NULL, NULL, 1, '984637', 0, NULL),
(9, 'employer', 'Marion Kadzo', 'marionkadzo86@gmail.com', '0722355211', '$2y$10$yb502ZStU9L5rxmAvDdiRuxGWkEyyL0c6M8zhWQMfAVXvZM.HKjfW', '2026-01-30 22:29:16', NULL, NULL, NULL, 1, '264511', 0, NULL),
(10, 'worker', 'Abel Mutua', 'abelmutua@gmail.com', '0756425252', '$2y$10$RHxwEdVrhhooRAyLFku.LeWbYsF2EP0f6NVb4A9ZHaz7CbIYoUxLO', '2026-01-31 05:28:47', NULL, NULL, NULL, 0, NULL, 1, '995852'),
(11, 'worker', 'Mark Babari', 'markbabari@gmail.com', '0755273727', '$2y$10$QfWrPJ4/xQM7mYH/kzIUJOjQ52ZCl2TR3OoanLIvubKLTa7I0CsEK', '2026-01-31 18:38:07', NULL, NULL, NULL, 0, NULL, 0, NULL),
(12, 'employer', 'Dennis Wangere', 'denniswangari@gmail.com', '0799226366', '$2y$10$M.EN8O5Z0wWQvVgvbxWM9.YFcVd1JsQc.6IvEr.u35baKh7TOoCYS', '2026-01-31 18:44:55', NULL, NULL, NULL, 0, NULL, 0, NULL),
(13, 'worker', 'David Githinji', 'davidgithinji@gmail.com', '0790363748', '$2y$10$lPJ0ArVyzQcnmongYGEkauRaZsoagJV3wlY8yPqQ8fTHkhYp8AVVq', '2026-02-07 20:32:11', NULL, NULL, NULL, 0, NULL, 0, NULL),
(14, 'employer', 'Amina', 'amin99@gmail.com', '0786435458', '$2y$10$HWKdZR8KzuDMb/Tqz5LZ7OMDl2kmEXVMk6caqOF1HSvA4BUz/vcci', '2026-02-12 18:19:23', NULL, NULL, NULL, 0, NULL, 0, NULL),
(15, 'employer', 'Precious', 'pappy89@gmail.com', '07666423189', '$2y$10$OkxAiWQIT6GNLvSx6owhe.fsY77E.u2voLpQFZl.JXkz932xqd0CO', '2026-02-12 18:31:27', NULL, NULL, NULL, 0, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gigs`
--
ALTER TABLE `gigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
