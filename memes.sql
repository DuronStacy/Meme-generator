-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2018 at 02:51 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memes`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'happy'),
(2, 'sad'),
(3, 'scared'),
(4, 'shocked'),
(5, 'angry'),
(6, 'tired'),
(7, 'desperate'),
(8, 'out'),
(9, 'loving');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`) VALUES
(1, 'schok.jpg'),
(2, 'scared_man.jpg'),
(3, 'scared_cat.jpg'),
(4, 'sad_minion.jpg'),
(5, 'sad_donkey.jpg'),
(6, 'sad_bob.jpg'),
(7, 'out_out.jpeg'),
(8, 'happy_squirrel.jpg'),
(9, 'happy_minion.jpg'),
(10, 'happy_cat.jpg'),
(11, 'angry_old-man.jpg'),
(12, 'angry_minion.jpg'),
(13, 'angry_cat.jpg'),
(14, 'angry_arnold.jpg'),
(15, 'tired_puppy.jpg'),
(16, 'tired_cat.jpg'),
(17, 'tired_baby.jpg'),
(18, 'love_squirel.jpg'),
(19, 'love_bear.jpg'),
(20, 'desesperate_rick.jpg'),
(21, 'desesperate_loki.jpg'),
(22, 'deseseprate_woman.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `images_categ`
--

CREATE TABLE `images_categ` (
  `images_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images_categ`
--

INSERT INTO `images_categ` (`images_id`, `categories_id`) VALUES
(1, 4),
(2, 3),
(3, 3),
(4, 2),
(5, 2),
(6, 2),
(7, 8),
(8, 1),
(9, 1),
(10, 1),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 6),
(16, 6),
(17, 6),
(18, 9),
(19, 9),
(20, 7),
(21, 7),
(22, 7);

-- --------------------------------------------------------

--
-- Table structure for table `memes`
--

CREATE TABLE `memes` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `images_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memes`
--

INSERT INTO `memes` (`id`, `filename`, `date`, `images_id`) VALUES
(3, 'angry_1.jpg', '2018-06-04 00:00:00', 13),
(4, 'happy_2.jpeg', '2018-06-04 12:00:00', 8),
(5, 'sad_3.jpg', '2018-06-04 17:30:00', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images_categ`
--
ALTER TABLE `images_categ`
  ADD PRIMARY KEY (`images_id`,`categories_id`),
  ADD KEY `fk_images_has_categories_categories1_idx` (`categories_id`),
  ADD KEY `fk_images_has_categories_images1_idx` (`images_id`);

--
-- Indexes for table `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_memes_images1_idx` (`images_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `memes`
--
ALTER TABLE `memes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `images_categ`
--
ALTER TABLE `images_categ`
  ADD CONSTRAINT `fk_images_has_categories_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_images_has_categories_images1` FOREIGN KEY (`images_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `memes`
--
ALTER TABLE `memes`
  ADD CONSTRAINT `fk_memes_images1` FOREIGN KEY (`images_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;