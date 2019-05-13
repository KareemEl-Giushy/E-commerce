-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2019 at 07:39 AM
-- Server version: 10.3.14-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id8527086_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cID` int(11) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `allow-comments` tinyint(1) NOT NULL DEFAULT 1,
  `allow-ads` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cID`, `cname`, `description`, `parent`, `ordering`, `visibility`, `allow-comments`, `allow-ads`) VALUES
(1, 'Uncategorized', 'That contains uncategorized items and this is an update content', 0, 0, 1, 1, 1),
(2, 'Gaming', 'This category about PlayStation and its need.', 0, 0, 1, 1, 1),
(3, 'Mobile And Tablets', 'This category about mobile devices.', 0, 2, 1, 1, 1),
(4, 'Music And Movies', 'This contains all the movies and the music for sell', 0, 0, 0, 1, 1),
(5, 'Cameras', 'This contains cameras to sell', 0, 3, 1, 1, 1),
(6, 'Supermarket', 'This contains many things to eat like (food-groceries-oil-vegetable-fruits).', 0, 0, 1, 1, 1),
(7, 'Electronics', 'This contains electronics and computer', 0, 4, 1, 1, 1),
(8, 'LifeStyle', 'This contains clothes and fashion and all things like that', 0, 5, 0, 1, 1),
(9, 'Graphics cards', 'Many Graphics cards', 2, 2, 1, 1, 1),
(11, 'hammers', '', 6, 0, 1, 1, 1),
(12, 'nokia', '', 3, 0, 1, 1, 1),
(13, 'samsung', '', 3, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `added_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `added_date`, `status`, `item_id`, `user_id`) VALUES
(1, 'This is a good product best value for the money', '2018-11-30 17:01:09', 1, 3, 3),
(2, 'this is a good deal with a good item i recommend to buy it', '2018-11-30 15:31:55', 1, 3, 7),
(3, 'this is amazing', '2018-11-07 07:15:20', 1, 1, 7),
(4, 'This is awesome', '2018-12-06 21:25:31', 1, 9, 1),
(5, 'nice !!!', '2019-01-19 19:39:52', 1, 3, 1),
(6, 'This amazing producte this is a great servse', '2019-01-20 16:01:18', 1, 9, 2),
(7, 'this is an amazing deal with a good price', '2019-01-20 19:41:30', 1, 17, 2),
(8, 'oooh, i am ganna buy this', '2019-01-21 01:01:31', 1, 10, 10),
(9, 'hello every one :)))))', '2019-03-13 19:14:03', 1, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(11) NOT NULL,
  `uDate` date NOT NULL,
  `madeIn` varchar(255) NOT NULL,
  `item-img` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0,
  `rating` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL DEFAULT 0,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemName`, `description`, `price`, `uDate`, `madeIn`, `item-img`, `status`, `approve`, `rating`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(1, 'Play station 3 for free (black friday) for 1 hour', 'This is a ps3 for free to enjoy the black friday this is an amazing offer for just 1 hour', '0$', '2018-11-24', 'EG', 'dims.jpg', 'like-new', 1, 0, 2, 1, 'blackfriday,free,friday'),
(3, 'samsung galexy note 8', 'This is a good mobile with good features and a good design', '500$', '2018-11-20', 'US', 's-l1000.jpg', 'new', 1, 0, 3, 2, ''),
(8, 'a good used mobile iphone X for sell', 'this is an iPhone x used for 2 months you can buy it', '200$', '2018-11-30', 'US', 'Apple-iPhoneX-SpaceGray-1-3x.jpg', 'used', 1, 0, 3, 3, ''),
(9, 'Gaming PC for sell', 'This is a high-end gaming pc to play with it is awesome', '50$', '2018-12-03', 'AR', 'Element_Main_1200-gaming-pcs.png', 'new', 1, 0, 2, 7, ''),
(10, 'Samsung mobile phone to sell', 'A good mobile with good performance to sell', '1000$', '2018-12-04', 'FR', 'Samsung-Galaxy-S9-Lilac-Purple-2-3x.jpg', 'new', 1, 0, 3, 6, ''),
(12, 'this is a tested item', 'this item is just for test nothing more than that i love to type on my keyboard it is really awsome how can i describe this feeling hello everyone i am kareem El-giushy salem test test test test test test test', '300$', '2019-01-15', 'AG', '', 'new', 0, 0, 2, 1, ''),
(13, 'blackbarry hammer', 'this is a beautiful hammer with good wood hand made', '100$', '2019-01-19', 'BE', '', 'new', 0, 0, 11, 1, 'hammer,home,equipment,tools,blackfriday'),
(17, 'Ps4 For sale', 'this is a brand new ps4 for sell it is good with a good extra game', '300$', '2019-01-20', 'BN', '5850905cv13d.jpg', 'new', 1, 0, 2, 1, 'gamming,sales,friday,ps4'),
(18, 'sumasung smart tv the newest version', 'This is a wonderful TV', '1000$', '2019-01-20', 'CN', '125944_20190120_193439[1].jpg', 'new', 1, 0, 7, 2, 'tv,smart'),
(19, 'usb adaptor from micro usb to the normal usb', 'This is a cheap small adaptor you can take it anywhere', '1.5$', '2019-01-21', 'BE', 'B8174011_TD01.jpg', 'new', 1, 0, 7, 1, 'cheap,good,quality,dollaritem');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `Truststatus` int(11) NOT NULL DEFAULT 0,
  `Regstatus` int(11) NOT NULL DEFAULT 0,
  `profile-img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `Date`, `GroupID`, `Truststatus`, `Regstatus`, `profile-img`) VALUES
(1, 'kareem', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kemoo.64123@gmail.com', 'Kareem Salem', '2002-07-12', 1, 0, 1, '92985_20180909_165206.jpg'),
(2, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed@gmail.com', 'Ahmed Salem', '2018-10-02', 1, 0, 1, '63646_20180724_150834.jpg'),
(3, 'dina1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dina.tahone@appssquare.com', 'Dina Tahone', '2018-09-11', 0, 0, 0, ''),
(4, 'eman', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eman.abdelnamby@gmail.com', 'Eman El-Sanbouk', '2018-11-01', 0, 0, 0, ''),
(6, 'mohammed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohamed@gmail.com', 'Mohammed El-Sanbouk', '2018-10-18', 0, 0, 0, ''),
(7, 'ibraheem', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ibraheem@gmail.com', 'Ibraheem Mamdoh', '2018-10-24', 0, 0, 0, ''),
(8, 'ihab', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ihab@gmail.com', 'Ihab Abde El-Gauad', '2018-11-30', 0, 0, 0, ''),
(9, 'hamada_medo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hamada@gmail.com', 'hamada el-sied', '2018-12-07', 0, 0, 0, ''),
(10, 'yaseen.kareem', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'yaseen.64123@gmail.com', 'yaseen kareem', '2019-01-21', 0, 0, 1, ''),
(11, 'sasa', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'gsgsg@rhr.com', 'تبتبننب النقملنبن', '2019-01-22', 0, 0, 0, ''),
(12, 'JohnHamza', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'john.hamza@gmail.com', 'John Hamza', '2019-01-22', 0, 0, 1, '810446_AirBrush_20181228142219.jpg'),
(13, 'Emanel', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'eman.64@gmail.com', 'Eman El-sanbouk', '2019-01-22', 0, 0, 0, ''),
(14, 'IbraheemMamdooh_3', 'c703af3a56b840535df6eb680ab519abb83766fe', 'mamdooh.hema@yahoo.com', 'Ibraheem Mamdooh', '2019-01-23', 0, 0, 0, ''),
(15, 'Farag', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'farag@gmail.com', 'Farag Mohammed', '2019-01-31', 0, 0, 1, '710798_1548960458281-410853638.jpg'),
(16, 'kemoo.64', '77e57a0282afdb65409d0a602d5701c6945fc19d', 'kemoo@kemoo.com', 'kareem salem', '2019-03-11', 0, 0, 0, '156686_art-deco-clipart-1.jpg'),
(17, 'dinaTahoun', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'dinatahoun992@gmail.com', 'dina tahoun', '2019-03-11', 0, 0, 1, '861310_pexels-photo-905163.jpeg'),
(18, 'hema', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'hema@gmail.com', 'Ibraheem Qoush', '2019-03-13', 0, 0, 0, '708372_FB_IMG_1535102002686.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cID`),
  ADD UNIQUE KEY `cname` (`cname`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_ibfk_2` (`user_id`),
  ADD KEY `comments_ibfk_1` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`cID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
