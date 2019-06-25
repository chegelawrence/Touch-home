-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2019 at 04:12 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `touch_home`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `check_in` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `house_id`, `check_in`) VALUES
(1, 2, 9, '4 April, 2019');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `rental_location` int(11) NOT NULL,
  `house_description` varchar(1000) NOT NULL,
  `commitment_fee` double NOT NULL,
  `monthly_fee` double NOT NULL,
  `picture_location` varchar(100) DEFAULT NULL,
  `house_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `rental_location`, `house_description`, `commitment_fee`, `monthly_fee`, `picture_location`, `house_type`) VALUES
(9, 7, 'A Sticky Footer Always Stays On The Bottom Of The Page Regardless Of How Little Content Is On The Page. However, This Footer Will Be Pushed Down If There Is A Lot Of Content, So It Is Different From A Fixed Footer', 15000, 7500, '../uploads/5cab6c64dad262.19302722.jpg', '2 Bedroom'),
(10, 4, 'Material Is An Adaptable System Of Guidelines, Components, And Tools That Support The Best Practices Of User Interface Design. Backed By Open-source Code', 12000, 5000, '../uploads/5cab6cbc0f22a1.91783423.jpg', 'Bedsitter'),
(11, 6, 'Our Slider Is A Simple And Elegant Image Carousel. You Can Also Have Captions That Will Be Transitioned On Their Own Depending On Their Alignment', 7000, 4000, '../uploads/5cab6dfa5a0fa4.09484072.jpg', 'Single');

-- --------------------------------------------------------

--
-- Table structure for table `surburbs`
--

CREATE TABLE `surburbs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surburbs`
--

INSERT INTO `surburbs` (`id`, `name`) VALUES
(1, 'Rongai'),
(2, 'Kawangware'),
(3, 'Umoja'),
(4, 'Huruma'),
(5, 'Kibera'),
(6, 'Kangemi'),
(7, 'Embakasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` text NOT NULL,
  `id_number` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `phone`, `id_number`, `password`, `is_admin`) VALUES
(1, 'Eric', 'Ngari', '', 'ericngari@gmail.com', '0792444398', 33732433, '$2y$10$nU3VhEy0vIoKMAiXBcNxeu.SffHDJMNgkLABa2yzEXfXVlLgVcGuK', 1),
(2, 'Lawrence', 'Mburu', 'Lawrence', 'chegelawrence1@gmail.com', '0796545888', 33713638, '$2y$10$JdS3xePLXxbiMOCAeriHS.OmaeeewC/0rHkFVEDysfdPacZmFU14O', 0),
(3, 'Stephen', 'Karuku', 'Stivo', 'stivo@gmail.com', '0739890879', 38908734, '$2y$10$9ra7.HZ39nBP3t0l3EQRv.cDiq4fCCA2ZbwV80JoF3gHAhaIYQC5y', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_location` (`rental_location`);

--
-- Indexes for table `surburbs`
--
ALTER TABLE `surburbs`
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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `surburbs`
--
ALTER TABLE `surburbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `rentals` (`id`);

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`rental_location`) REFERENCES `surburbs` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
