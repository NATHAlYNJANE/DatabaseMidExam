-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Generation Time: Nov 10, 2024 at 05:14 AM
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
-- Database: `nat`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lipstick_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `lipstick_id`) VALUES
(1, 1, 2),
(2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lipsticks`
--

CREATE TABLE `lipsticks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lipsticks`
--

INSERT INTO `lipsticks` (`id`, `name`, `description`, `image_url`, `price`) VALUES
(1, 'MAC Ruby Woo', 'A classic red lipstick loved by many.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQX_vGd9VTxwQbYusqJ75qkF4gbcZebH5dafw&s', 19.99),
(2, 'Maybelline SuperStay', 'Long-lasting liquid lipstick.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQnQX4wwFIDXr7Ba68_YpdXzGTDU-9CkL9FA&s', 10.99),
(3, 'NARS Orgasm', 'Popular shade with a touch of shimmer.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS53zq_8l0zfghi4YJSwB4sT3EHc4YjG8dhmg&s', 25.00),
(4, 'Fenty Beauty Stunna', 'Rihanna\'s iconic red lip.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcmYuuchiOLifGtarJh2xGza-eZ1iy_8aVVA&s', 24.00),
(5, 'Charlotte Tilbury Pillow Talk', 'Nude pink loved worldwide.', 'https://img.lazcdn.com/g/p/1df0a50a48149edfa9f2b12251a922a5.png_720x720q80.png', 34.00),
(6, 'YSL Rouge Pur Couture', 'High-end luxury lipstick.', 'https://i.ebayimg.com/00/s/MTYwMFgxNjAw/z/UfUAAOSwaLZifHpk/$_57.JPG?set_id=880000500F', 38.00),
(7, 'Revlon Super Lustrous', 'Affordable and creamy lipstick.', 'https://dynamic.zacdn.com/xuMjKKmka7xnkobn3vkj0pOkAYc=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/revlon-9839-5503702-1.jpg', 8.99),
(8, 'Dior Addict Lip Glow', 'Moisturizing balm with color.', 'https://static.sweetcare.pt/img/prd/488/v-638200521133392690/dior-014890di-1.webp', 35.00),
(9, 'L\'Oréal Paris Colour Riche', 'Rich color in classic shades.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_-E4VhoijLXR2coVlcj41RaCpJYRGlSG3nA&s', 9.99),
(10, 'Clinique Almost Lipstick', 'Sheer lipstick with a glossy finish.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6F1FKUTmQNG96sKZdqhdxYvYZ1uvfmEXIhw&s', 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `first_login` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `first_login`) VALUES
(1, 'nathalyn', '$2y$10$tg.dlB2RpxOx5gLx/312S.pitrXE/fpw2x7dhPqFFqx7333HQzkye', '2024-11-06 19:08:55', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lipstick_id` (`lipstick_id`);

--
-- Indexes for table `lipsticks`
--
ALTER TABLE `lipsticks`
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
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lipsticks`
--
ALTER TABLE `lipsticks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`lipstick_id`) REFERENCES `lipsticks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
