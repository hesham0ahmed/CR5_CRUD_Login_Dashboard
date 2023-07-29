-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2023 at 12:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be19_cr5_animal_adoption_heshamahmed`
--
CREATE DATABASE IF NOT EXISTS `be19_cr5_animal_adoption_heshamahmed` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be19_cr5_animal_adoption_heshamahmed`;

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `petname` varchar(200) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `age` int(20) NOT NULL,
  `big_description` varchar(400) NOT NULL,
  `short_description` varchar(200) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `locations` varchar(200) NOT NULL,
  `weights` varchar(200) NOT NULL,
  `species` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `price` int(20) NOT NULL,
  `birth_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `vacc` tinyint(1) NOT NULL,
  `fk_sizeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`id`, `petname`, `picture`, `age`, `big_description`, `short_description`, `breed`, `locations`, `weights`, `species`, `gender`, `price`, `birth_date`, `status`, `vacc`, `fk_sizeId`) VALUES
(114, 'Bello', '64c3f82d81dea.jpg', 7, 'He is so protective you can say watch this guy and he will check for him and dont let him come near to you', 'This dog is very protective', 'Doberman', 'Vienna', '24', 'Dog', 'male', 123, '1212-12-12', 0, 1, 3),
(115, 'Mitzi', '64c3f49c19d1e.jpg', 2, '', 'Very Playful Kitten', 'White Mitzi', 'Linz', '4kg', 'Cat', 'Kettenbrückengasse 22', 233, '1212-12-12', 0, 1, 1),
(137, 'Frankie', '64c3f84f0eb81.jpg', 2, '', 'Dont follow your Commands but very Cute', 'Dachshund', 'upper Vienna', '', '', '', 0, '0000-00-00', 0, 0, 1),
(141, 'Marlo', '64c3f85c9a49c.jpg', 9, '', 'Chilling Chameleon', 'Furcifer pardalis', 'Singerstraße 3', '1', 'Chameleon', 'Female', 222, '1212-12-12', 0, 1, 1),
(142, 'Kilo', '64c3f8957d279.jpg', 11, '', 'Friendly Koala', 'Koala', 'Vienna', '19', 'Koala', 'Male', 1800, '1212-12-12', 0, 0, 2),
(143, 'Milli', '64c3f8b306a63.jpg', 3, '', 'Very cute Rabbit', 'White Rabbit', 'Linz', '4', 'Rabbit', 'Kettenbrückengasse 22', 99, '1212-12-12', 0, 1, 1),
(146, 'Petzi', '64c3f8c4409f4.jpg', 6, '', 'Lazy Cat from Town', 'Scottish Fold', 'Graz', '6', 'Cat', 'Male', 47, '1212-12-12', 0, 1, 1),
(147, 'Nato', '64c3f8d64d9c9.jpg', 9, '', 'Peanut Junkie', 'Western Red Squirrel', 'Vienna', '1', 'Squirrel', 'Male', 299, '1222-12-12', 0, 1, 1),
(148, 'Bazooka', '64c3f8a3ed58f.jpg', 22, '', 'Friendly Tiger', 'Bengal Tiger', 'Lower Austria', '89', 'Tiger', 'Male', 9999, '1212-12-12', 0, 1, 1),
(149, 'Gina', '64c3f8e5b082c.jpg', 9, '', 'Sleepy and Cuddle is her Favorite', 'Siamese', 'Vienna', '8', 'Cat', 'Female', 787, '1212-12-12', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pet_adopt`
--

CREATE TABLE `pet_adopt` (
  `id` int(11) NOT NULL,
  `fk_userId` int(11) NOT NULL,
  `fk_animalId` int(11) NOT NULL,
  `adopt_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `sizeId` int(11) NOT NULL,
  `sizes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`sizeId`, `sizes`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` int(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `adresse`, `password`, `date_of_birth`, `email`, `picture`, `status`) VALUES
(4, 'Mark                   ', 'Zuckerberg                  ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1313-12-13', 'hello2@hello.com', '64c040e6a8327.jpg', 'user'),
(5, 'Elon        ', 'Musk        ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'elonMusk@teslaCorp.com', '64c033d4531b2.jpg', 'user'),
(6, 'Charlie ', 'Harper ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hello4@hello.com', '64c011a487b51.jpg', 'user'),
(7, 'Bill James', 'Gates  ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hello5@hello.com', '64c011cc457d0.jpg', 'user'),
(11, 'Code', 'Factory', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hello@hello.com', '64c0e9ead6825.jpg', 'adm'),
(12, 'Heinz Christian ', 'Strache ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hallo7@hallo.com', '64c0eababc8f6.jpg', 'user'),
(15, 'Hannes', 'KleinHaus', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hallo00@hallo.com', '64c255cb499b5.jpg', 'user'),
(17, 'hellom', 'hello', 1111, '1111s', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'hello11@hello.com', '64c3ee8d5667a.jpg', 'user'),
(18, 'test ', 'test ', 0, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1212-12-12', 'test@mail.com', '64c3ef50b532d.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplierId` (`fk_sizeId`) USING BTREE;

--
-- Indexes for table `pet_adopt`
--
ALTER TABLE `pet_adopt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_animalId` (`fk_animalId`),
  ADD KEY `fk_userId` (`fk_userId`) USING BTREE;

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`sizeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `pet_adopt`
--
ALTER TABLE `pet_adopt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `sizeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`fk_sizeId`) REFERENCES `size` (`sizeId`);

--
-- Constraints for table `pet_adopt`
--
ALTER TABLE `pet_adopt`
  ADD CONSTRAINT `pet_adopt_ibfk_1` FOREIGN KEY (`fk_animalId`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `pet_adopt_ibfk_2` FOREIGN KEY (`fk_userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
