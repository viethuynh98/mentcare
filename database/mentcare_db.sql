-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 10:47 PM
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
-- Database: `mentcare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

CREATE TABLE `drug` (
  `drug_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `indication` varchar(50) NOT NULL,
  `dosing_guide` varchar(50) NOT NULL,
  `min_dose_per_use` int(11) NOT NULL,
  `max_dose_per_use` int(11) NOT NULL,
  `frequency_max` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `form` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug`
--

INSERT INTO `drug` (`drug_id`, `name`, `indication`, `dosing_guide`, `min_dose_per_use`, `max_dose_per_use`, `frequency_max`, `unit`, `form`) VALUES
(1, 'Citalopram', 'Depression', 'before meals', 2, 4, 3, 10, 'caplet'),
(2, 'Paroxetine', 'Depression', 'after meals', 2, 3, 3, 15, 'caplet'),
(3, 'Quetiapine', 'Depression', 'before meals', 1, 4, 2, 20, 'capsule'),
(4, 'Stimulants', 'Depression', 'after meals', 1, 3, 2, 50, 'caplet'),
(5, 'Bupropion', 'Depression', 'before meals', 1, 4, 3, 45, 'capsule'),
(6, 'Clozaril', 'Depression', 'before meals', 1, 3, 2, 20, 'capsule'),
(7, 'Venlafaxine', 'PTSD', 'after meals', 1, 3, 2, 70, 'caplet'),
(8, 'Escitalopram', 'PTSD', 'after meals', 1, 4, 3, 20, 'capsule'),
(9, 'Diphenoxylate', 'PTSD', 'after meals', 1, 3, 2, 35, 'caplet'),
(10, 'Abilify', 'Anxiety Disorders', 'before meals', 1, 3, 2, 30, 'capsule'),
(11, 'Sertraline', 'Anxiety Disorders', 'after meals', 1, 3, 2, 20, 'caplet'),
(12, 'Antidepressants', 'Anxiety Disorders', 'after meals', 1, 5, 3, 55, 'capsule'),
(13, 'Phenelzine', 'Anxiety Disorders', 'after meals', 1, 3, 2, 60, 'caplet'),
(14, 'Buspirone', 'Bipolar Disorder', 'after meals', 1, 3, 2, 65, 'capsule'),
(15, 'Zotepine', 'Bipolar Disorder', 'before meals', 1, 5, 2, 20, 'capsule'),
(16, 'Fluoxetine', 'Bipolar Disorder', 'after meals', 1, 3, 3, 75, 'caplet'),
(17, 'Benzodiazepine', 'Schizophrenia', 'after meals', 1, 3, 2, 20, 'capsule'),
(18, 'Antipsychotics', 'Schizophrenia', 'after meals', 1, 5, 2, 85, 'caplet'),
(19, 'Ativan', 'Schizophrenia', 'before meals', 1, 2, 3, 100, 'capsule');

-- --------------------------------------------------------

--
-- Table structure for table `medicalhistory`
--

CREATE TABLE `medicalhistory` (
  `mh_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `diagnose` varchar(50) NOT NULL,
  `treatment` varchar(20) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicalhistory`
--

INSERT INTO `medicalhistory` (`mh_id`, `visit_date`, `diagnose`, `treatment`, `staff_id`, `patient_id`) VALUES
(1, '2023-02-12', 'Depression', 'Home', 'DT01', 1),
(2, '2023-02-12', 'PTSD', 'Home', 'DT01', 2),
(3, '2023-02-12', 'Anxiety Disorders', 'Home', 'DT02', 1),
(4, '2023-02-12', 'Depression', 'Home', 'DT03', 3),
(5, '2023-02-12', 'Depression', 'Home', 'DT03', 4),
(6, '2023-05-12', 'Depression', 'Home', 'DT01', 1),
(7, '2023-02-12', 'PTSD', 'Home', 'DT01', 2),
(8, '2023-02-12', 'Anxiety Disorders', 'Home', 'DT02', 1),
(9, '2023-02-12', 'Depression', 'Home', 'DT03', 3),
(10, '2023-02-12', 'Depression', 'Home', 'DT03', 4),
(17, '2023-12-07', 'Depression', 'Home', 'DT01', 3),
(18, '2023-12-07', 'PTSD', 'Home', 'DT02', 2),
(19, '2023-12-07', 'Depression', 'Home', 'DT01', 4),
(20, '2023-12-07', 'Anxiety Disorders', 'Home', 'DT01', 1),
(21, '2023-12-07', 'PTSD', 'Home', 'DT01', 3),
(22, '2023-12-07', 'Depression', 'Home', 'DT01', 3),
(23, '2023-12-07', 'Depression', 'Home', 'DT01', 1),
(24, '2023-12-07', 'PTSD', 'Home', 'DT01', 3),
(25, '2023-12-07', 'PTSD', 'Home', 'DT01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `medicalstaff`
--

CREATE TABLE `medicalstaff` (
  `staff_id` varchar(20) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `specialty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicalstaff`
--

INSERT INTO `medicalstaff` (`staff_id`, `first_name`, `last_name`, `specialty`) VALUES
('DT01', 'Viet', 'Huynh', 'Doctor'),
('DT02', 'Viet', 'Lee', 'Doctor'),
('DT03', 'Bao', 'Nguyen', 'Doctor'),
('DT04', 'Hoang', 'Nguyen', 'Doctor'),
('DT05', 'Thieu', 'Truong', 'Doctor'),
('NUR06', 'Hang', 'Tran', 'Nurse');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthday` date NOT NULL,
  `city` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `first_name`, `last_name`, `gender`, `birthday`, `city`, `phone_number`, `height`, `weight`) VALUES
(1, 'Việt', 'Huỳnh', 0, '1998-01-18', 'Quảng Nam', '0998298783', 168, 64),
(2, 'Việt', 'Nguyễn', 0, '1998-11-21', 'Quảng Ngãi', '0988928764', 172, 63),
(3, 'Nữ', 'Trần', 0, '1998-12-23', 'Đà Nẵng', '0927874837', 181, 59),
(4, 'Bảo', 'Nguyễn', 0, '1998-10-01', 'Quảng Trị', '0928738764', 173, 68),
(5, 'Hằng', 'Trần', 0, '1998-09-05', 'Quảng Ninh', '0987483726', 174, 71),
(6, 'Nam', 'Nguyễn', 0, '1998-08-06', 'Quảng Trị', '0985748392', 172, 54),
(7, 'Hằng', 'Trần', 0, '1998-07-07', 'Quảng Bình', '0987657483', 170, 52),
(8, 'Học', 'Nguyễn', 0, '1998-06-10', 'Quảng Ninh', '0916738492', 178, 49),
(9, 'Dung', 'Trần', 0, '1998-05-12', 'Huế', '0918273645', 175, 42),
(10, 'Lâm', 'Nguyễn', 0, '1998-02-11', 'Thanh Hoá', '0972837465', 165, 48),
(11, 'Huyền', 'Lê', 0, '1998-01-23', 'Nghệ An', '0912345281', 166, 45),
(12, 'Thảo', 'Lê', 0, '1998-03-30', 'Nha Trang', '0918764371', 150, 51);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `prescription_id` int(11) NOT NULL,
  `mh_id` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescription_id`, `mh_id`, `note`) VALUES
(1, 1, 'Avoid going to crowded places'),
(2, 2, 'Avoid going to crowded places'),
(3, 3, 'Avoid going to crowded places'),
(4, 4, 'Avoid going to crowded places'),
(5, 5, 'Avoid going to crowded places'),
(6, 6, 'Avoid going to crowded places'),
(7, 7, 'Avoid going to crowded places'),
(8, 8, 'Avoid going to crowded places'),
(9, 9, 'Avoid going to crowded places'),
(10, 10, 'Avoid going to crowded places'),
(12, 17, 'Do not come into contact with weapons'),
(13, 18, 'Do not come into contact with weapons'),
(14, 19, 'Do not come into contact with weapons'),
(15, 20, 'Do not come into contact with weapons'),
(16, 21, 'Do not come into contact with weapons'),
(17, 22, ''),
(18, 23, ''),
(19, 24, 'Take care of yourself'),
(20, 25, '');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_detail`
--

CREATE TABLE `prescription_detail` (
  `dose` int(11) NOT NULL,
  `frequency` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `drug_id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_detail`
--

INSERT INTO `prescription_detail` (`dose`, `frequency`, `quantity`, `note`, `drug_id`, `prescription_id`) VALUES
(1, 2, 6, 'take 1 each time, twice a day, after eating', 14, 1),
(2, 2, 6, 'take 2 each time, twice a day, before meals', 1, 2),
(2, 2, 12, 'take 2 each time, twice a day, after eating', 7, 3),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 15, 4),
(2, 3, 18, 'take 2 each time, 3 times a day, after eating', 16, 5),
(2, 1, 6, 'take 2 each time, once daily, after eating', 17, 6),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 5, 7),
(1, 2, 6, 'take 1 each time, twice a day, after eating', 8, 8),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 15, 9),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 19, 10),
(3, 3, 27, 'take 3 each time, 3 times a day, before meals', 1, 12),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 15, 12),
(3, 3, 27, 'take 3 each time, 3 times a day, before meals', 1, 13),
(3, 3, 18, 'take 3 each time, 3 times a day, after eating', 2, 13),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 5, 13),
(3, 3, 27, 'take 3 each time, 3 times a day, before meals', 1, 14),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 19, 14),
(3, 2, 18, 'take 3 each time, twice a day, after eating', 2, 15),
(1, 2, 6, 'take 1 each time, twice a day, after eating', 8, 15),
(3, 2, 6, 'take 3 each time, twice a day, before meals', 1, 16),
(3, 3, 18, 'take 3 each time, 3 times a day, after eating', 2, 16),
(4, 3, 12, 'take 4 each time, 3 times a day, before meals', 1, 17),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 15, 17),
(1, 2, 6, 'take 1 each time, twice a day, after eating', 14, 18),
(2, 3, 12, 'take 2 each time, 3 times a day, before meals', 1, 19),
(3, 3, 18, 'take 3 each time, 3 times a day, after meals', 2, 19),
(4, 3, 24, 'take 4 each time, 3 times a day, before meals', 1, 20),
(3, 3, 18, 'take 3 each time, 3 times a day, after meals', 2, 20),
(1, 2, 6, 'take 1 each time, twice a day, before meals', 5, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `type` varchar(255) DEFAULT 'patient',
  `staff_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email_address`, `password`, `type`, `staff_id`) VALUES
(1, 'dt01@gmail.com', '123456', 'staff', 'DT01'),
(2, 'dt02@gmail.com', '123456', 'staff', 'DT02'),
(3, 'dt03@gmail.com', '123456', 'staff', 'DT03'),
(4, 'dt04@gmail.com', '123456', 'staff', 'DT04'),
(5, 'dt05@gmail.com', '123456', 'staff', 'DT05'),
(6, 'nur06@gmail.com', '123456', 'staff', 'NUR06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drug`
--
ALTER TABLE `drug`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `medicalhistory`
--
ALTER TABLE `medicalhistory`
  ADD PRIMARY KEY (`mh_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `medicalstaff`
--
ALTER TABLE `medicalstaff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`prescription_id`),
  ADD KEY `mh_id` (`mh_id`);

--
-- Indexes for table `prescription_detail`
--
ALTER TABLE `prescription_detail`
  ADD PRIMARY KEY (`prescription_id`,`drug_id`),
  ADD KEY `drug_id` (`drug_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drug`
--
ALTER TABLE `drug`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `medicalhistory`
--
ALTER TABLE `medicalhistory`
  MODIFY `mh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medicalhistory`
--
ALTER TABLE `medicalhistory`
  ADD CONSTRAINT `medicalhistory_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `medicalstaff` (`staff_id`),
  ADD CONSTRAINT `medicalhistory_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`mh_id`) REFERENCES `medicalhistory` (`mh_id`);

--
-- Constraints for table `prescription_detail`
--
ALTER TABLE `prescription_detail`
  ADD CONSTRAINT `prescription_detail_ibfk_1` FOREIGN KEY (`drug_id`) REFERENCES `drug` (`drug_id`),
  ADD CONSTRAINT `prescription_detail_ibfk_2` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`prescription_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `medicalstaff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
