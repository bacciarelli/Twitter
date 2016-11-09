-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2016 at 11:57 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE `Comment` (
  `id` int(11) NOT NULL,
  `tweetId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `commentText` varchar(60) NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`id`, `tweetId`, `userId`, `commentText`, `creationDate`) VALUES
(4, 3, 29, 'Justyna komentuje tweeta ani.', '2016-11-06 18:46:48'),
(5, 3, 29, 'Justyna dodaje drugi komentarz:)', '2016-11-06 19:05:13'),
(6, 3, 29, 'dodaje trzeci', '2016-11-06 19:05:48'),
(7, 3, 29, 'dodaje czwarty koment', '2016-11-06 19:10:58'),
(8, 7, 5, 'ania skompentuje najnowszy tweet', '2016-11-07 00:37:27'),
(9, 3, 25, 'Komentarz od Bartka', '2016-11-07 14:09:02'),
(10, 7, 25, 'Komentarz od Bartka', '2016-11-07 14:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE `Message` (
  `id` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `reciverId` int(11) NOT NULL,
  `messageText` text NOT NULL,
  `creationDate` datetime NOT NULL,
  `readedStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Message`
--

INSERT INTO `Message` (`id`, `senderId`, `reciverId`, `messageText`, `creationDate`, `readedStatus`) VALUES
(1, 29, 5, 'Wysyłam wiadomość do Ani od Justyny', '2016-11-06 23:13:47', 1),
(2, 29, 29, 'Justyna wysyła wiadomość sama do siebie; cośtam', '2016-11-06 23:14:36', 1),
(3, 5, 29, 'Hej:) cześć od Ani do justyny', '2016-11-07 00:37:14', 1),
(4, 25, 5, 'Wiadomość od Bartka do Ani', '2016-11-07 14:08:26', 0),
(5, 25, 29, 'Wiadomość od Bartka do Justyny', '2016-11-07 14:08:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Tweet`
--

CREATE TABLE `Tweet` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `tweetText` varchar(140) NOT NULL,
  `creationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Tweet`
--

INSERT INTO `Tweet` (`id`, `userId`, `tweetText`, `creationDate`) VALUES
(1, 25, 'tweetuje', '2016-11-02 23:08:37'),
(2, 25, 'tweetuje po raz drugi ', '2016-11-02 23:10:46'),
(3, 5, 'tweetuje ania', '2016-11-02 23:44:46'),
(4, 29, 'text Tweeta', '2016-11-06 16:51:57'),
(5, 29, 'dobry tweet Justyny.', '2016-11-06 16:56:17'),
(6, 29, 'Krótki tweet\r\n', '2016-11-06 16:56:47'),
(7, 29, 'najnowszy post', '2016-11-06 21:18:33'),
(8, 5, 'nowy tweet twit', '2016-11-09 11:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hashedPassword` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `hashedPassword`, `email`) VALUES
(5, 'ania', '$2y$10$b2TuZXK4UOZvzYqQ9MnCNezY7mEipe6SXTmnrnpjE2IgwTIos7MXy', ''),
(25, 'Bartek', '$2y$10$SpvRkBXBtsMOss.E2YmgDOSNVXWg6Ko7ZfxuEuwU1uuK1VFoUlfIm', 'email'),
(29, 'Justyna', '$2y$10$KubMpE/ti50NIqtenVqfheyo/ElptoLkQfkpWVsagcU32Afy/ch9S', 'justyna@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweetId` (`tweetId`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `reciverId` (`reciverId`);

--
-- Indexes for table `Tweet`
--
ALTER TABLE `Tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`userId`);

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
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Tweet`
--
ALTER TABLE `Tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`tweetId`) REFERENCES `Tweet` (`id`);

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`reciverId`) REFERENCES `users` (`id`);

--
-- Constraints for table `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
