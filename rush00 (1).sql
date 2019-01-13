-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2019 at 10:34 AM
-- Server version: 5.7.24
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rush00`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `id` int(50) NOT NULL,
  `id_user` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `id_basket` int(11) NOT NULL,
  `code` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` varchar(16) NOT NULL,
  `image` text NOT NULL,
  `category` int(11) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `image`, `category`, `code`) VALUES
(1, 'Espresso', '1.1', 'https://globalassets.starbucks.com/assets/9a31eb8e3806479ebcba3ad39c5024ec.jpg', 1, 'd1'),
(4, 'Latte', '2.45', 'https://globalassets.starbucks.com/assets/1bfbfda9871b455d859c478f837071dc.jpg', 1, 'd2'),
(5, 'Cappuccino', '2.45', 'https://globalassets.starbucks.com/assets/43c3301d81bd4ea4a9fec5beaf43a541.jpg', 1, 'd3'),
(6, 'Americano', '2', 'https://globalassets.starbucks.com/assets/69dc4401f64d4419a8d78ca9b5200271.jpg', 1, 'd4'),
(7, 'Flat white', '2.5', 'https://globalassets.starbucks.com/assets/cc1eb44d0ca648a0805d2a3d20988a68.jpg', 1, 'd5'),
(9, 'Hot chocolate', '2.55', 'https://globalassets.starbucks.com/assets/f65d43a1205f47a4bfd3fcf6e475a117.jpg', 1, 'd6'),
(11, 'Tea', '1.8', 'https://globalassets.starbucks.com/assets/ec39ec0a7e844d0ba3ccff210c389828.jpg', 1, 'f7'),
(12, 'Iced Americano', '2', 'https://globalassets.starbucks.com/assets/c399164ad0f94aecbe0e51a72324c9bc.jpg', 2, 'f8'),
(13, 'Iced Latte', '2.45', 'https://globalassets.starbucks.com/assets/5dfa91a823d6497097e4bdc4f6396ad2.jpg', 2, 'd9'),
(15, 'Iced chocolate', '2.5', 'https://globalassets.starbucks.com/assets/799de2ef9efd4acf91a3eeb06eda66a9.jpg', 2, 'd10'),
(17, 'Lemonade', '1.8', 'https://globalassets.starbucks.com/assets/9c0c6ed288a04a229a8f51790eaa9d29.jpg', 2, 'd11'),
(21, 'Blueberry muffin', '1.80', 'https://globalassets.starbucks.com/assets/2ad62afdd611465eac457c762944045c.jpg', 3, 'd12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `secret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `secret`) VALUES
(4, 'sarune', '$2y$10$mc/XK87/ReLvTErQjg5AM.iA608OZnSnB1MUiSQNYJdWIE0tc7Uwy', '$2y$10$02QDJfU.F9xoAAiXQ4GPHO2q5MS.kAmpFeThgczmiq/vIZqH40O7m');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
