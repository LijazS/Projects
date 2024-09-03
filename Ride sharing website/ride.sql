-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 06:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ride`
--

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `reviewer_id`, `driver_id`, `rating`, `review_text`, `created_at`) VALUES
(6, 3390, 284, 5, 'mkjoiou', '2024-05-05 11:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `search_trip`
--

CREATE TABLE `search_trip` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `waypoint` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `female_only` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_trip`
--

INSERT INTO `search_trip` (`id`, `user_id`, `origin`, `destination`, `waypoint`, `created_at`, `female_only`) VALUES
(105, 3390, 'Kannur, Kerala, India', 'Thalassery, Kerala, India', 'Pass by SP Office Bus Stop (on the right), Pass by Airtel Office (on the right), Pass by the gas station (on the left), Continue straight through Caltex Jct to stay on NH 66Pass by J J Electricals (on the left), Pass by Thazhe Chovva Railway Gate (on the left), Turn right at bus stop of nadaal gate onto NH 66Toll roadPass by Colonial Kitchen,, Pass by VM BAZAAR (on the left), Turn right at State Bank Of India ATM onto Dharmadam - Melur RdPass by Sintex World (on the right), Turn left at Vibhav Aravukendram onto Panvel - Kochi - Kanyakumari HwyPass by Zafran Restaurant (on the left), Continue straight past Thalassery Muncipal Office - Stadium Jct onto MG RdPass by THALASSERY CRANE SERVICE (on the right), Turn right at Grand mother tree onto OV Rd/Thalassery - Mysore Rd', '2024-05-05 11:51:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trip_listing`
--

CREATE TABLE `trip_listing` (
  `trip_id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `waypoint` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `seats` int(20) NOT NULL,
  `seats_used` int(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip_listing`
--

INSERT INTO `trip_listing` (`trip_id`, `user_id`, `username`, `origin`, `destination`, `waypoint`, `created_at`, `seats`, `seats_used`) VALUES
(26, 284, 'raju', 'Kannur, Kerala, India', 'Kozhikode, Kerala, India', 'Pass by SP Office Bus Stop (on the right), Pass by Airtel Office (on the right), Pass by the gas station (on the left), Continue straight through Caltex Jct to stay on NH 66Pass by J J Electricals (on the left), Pass by Thazhe Chovva Railway Gate (on the left), Turn right at bus stop of nadaal gate onto NH 66Toll roadPass by Colonial Kitchen,, Continue straight to stay on NH 66Pass by Dr N P Suresh (on the left), Pass by Valluparambil (on the left), , Pass by LULU STORE (on the right), Turn leftPass by Carzio Wash Hub (on the left in 650m), Continue straight onto NH 66Pass by Madappally College Bus Stop (on the right), Pass by Siopa Automobiles LLP (Montra Electric) (on the left), Pass by Narayanan\'s tea shop (on the left), Pass by Thwayyiba Cashews (on the left), Continue straight past Vadakara Jn to stay on NH 66Pass by Vadakara bypass (on the left), Continue straight past myG Future Vadakara to stay on NH 66Pass by Three Star TRADERS (on the right), Continue onto NH 66Pass by Lava Stone Granites &amp; Marbles (on the left), Pass by Sheeba\'s Store (on the left in 8.6 km), Continue straight through Chungam Jct to stay on Kannur RdPass by Chungam Post Office(West Hill) (on the left), Pass by Comet (on the left), Turn right onto Bank Rd/PR Nambiar Rd/Wayanad RdContinue to follow Bank Rd/PR Nambiar RdPass by Meridian Mansion (on the left)', '2024-05-05 11:50:22', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `trip_requests`
--

CREATE TABLE `trip_requests` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `trip_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `adhar_no` varchar(20) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `gender` enum('MALE','FEMALE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `adhar_no`, `phone_number`, `gender`) VALUES
(147, 'rani', 'rani@1234', '1234', 'driver', '32523446', '7357189', 'FEMALE'),
(284, 'raju', 'raju@321', '1234', 'driver', '98765', '78901', 'MALE'),
(1654, 'wafa', 'wafa@123', '1234', 'regular', '5346123', '9061677', 'FEMALE'),
(1903, 'fadhil', 'fadhi@123', '1234', 'regular', '473434', '894291481', 'MALE'),
(3390, 'lijaz', 'lijaz@123', '1234', 'regular', '54321', '94952020', 'MALE'),
(9344, 'nilo', 'nilo@123', '1234', 'regular', '51364352351', '5752344421', 'FEMALE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_trip`
--
ALTER TABLE `search_trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trip_listing`
--
ALTER TABLE `trip_listing`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trip_id` (`trip_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `search_trip`
--
ALTER TABLE `search_trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `trip_listing`
--
ALTER TABLE `trip_listing`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `trip_requests`
--
ALTER TABLE `trip_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52315541;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `search_trip`
--
ALTER TABLE `search_trip`
  ADD CONSTRAINT `search_trip_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `trip_listing`
--
ALTER TABLE `trip_listing`
  ADD CONSTRAINT `trip_listing_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `trip_listing_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD CONSTRAINT `fk_trip_id` FOREIGN KEY (`trip_id`) REFERENCES `trip_listing` (`trip_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
