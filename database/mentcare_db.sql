-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 04:11 AM
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
(1, 'Triptans', 'đau đầu', 'sau ăn', 2, 3, 3, 10, 'caplet'),
(2, 'Etodolac', 'đau đầu', 'sau ăn', 2, 3, 3, 15, 'caplet'),
(3, 'Oxaprozin', 'đau đầu', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(4, 'Indomethacin', 'đau đầu', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(5, 'Nabumetone', 'đau đầu', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(6, 'Diclofenac', 'đau đầu', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(7, 'Berberin', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(8, 'Loperamid', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(9, 'Diphenoxylate', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(10, 'Codein', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(11, 'Diarsed', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(12, 'Racecadotril', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(13, 'Smecta', 'tiêu chảy', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(14, 'Paracetamol', 'hạ sốt', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(15, 'Aspirin', 'hạ sốt', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(16, 'Efferalgan', 'hạ sốt', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(17, 'Tiffy', 'hạ sốt', 'sau ăn', 1, 3, 2, 20, 'capsule'),
(18, 'Panadol', 'hạ sốt', 'sau ăn', 1, 3, 2, 20, 'caplet'),
(19, 'Glotadol', 'hạ sốt', 'sau ăn', 1, 2, 2, 20, 'capsule');

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
(1, '2023-02-12', 'Sốt', 'Tại Nhà', 'DT01', 1),
(2, '2023-02-12', 'Đau Đầu', 'Tại Nhà', 'DT01', 2),
(3, '2023-02-12', 'Tiêu Chảy', 'Tại Nhà', 'DT02', 1),
(4, '2023-02-12', 'Sốt', 'Tại Nhà', 'DT03', 3),
(5, '2023-02-12', 'Sốt', 'Tại Nhà', 'DT03', 4),
(6, '2023-05-12', 'Sốt', 'Tại Nhà', 'DT01', 1),
(7, '2023-02-12', 'Đau Đầu', 'Tại Nhà', 'DT01', 2),
(8, '2023-02-12', 'Tiêu Chảy', 'Tại Nhà', 'DT02', 1),
(9, '2023-02-12', 'Sốt', 'Tại Nhà', 'DT03', 3),
(10, '2023-02-12', 'Sốt', 'Tại Nhà', 'DT03', 4);

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
('DT01', 'Việt', 'Huỳnh', 'Doctor'),
('DT02', 'Việt', 'Lê', 'Doctor'),
('DT03', 'Bảo', 'Nguyễn', 'Doctor'),
('DT04', 'Hoàng', 'Nguyễn', 'Doctor'),
('DT05', 'Thiệu', 'Trương', 'Doctor'),
('NUR06', 'Hằng', 'Trần', 'Nurse');

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
(1, 1, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(2, 2, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(3, 3, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(4, 4, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(5, 5, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(6, 6, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(7, 7, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(8, 8, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(9, 9, 'không uống nước đá, không để bụng đói khi uống thuốc'),
(10, 10, 'không uống nước đá, không để bụng đói khi uống thuốc');

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
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 14, 1),
(2, 2, 6, 'Sáng 2 viên, Chiều 2 viên, sau ăn', 1, 2),
(2, 2, 12, 'Sáng 2 viên, Chiều 2 viên, sau ăn', 7, 3),
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 15, 4),
(2, 3, 18, 'Sáng 2 viên, Trưa 2 viên, Chiều 2 viên, sau ăn', 16, 5),
(2, 1, 6, 'Sáng 2 viên, sau ăn', 17, 6),
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 5, 7),
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 8, 8),
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 15, 9),
(1, 2, 6, 'Sáng 1 viên, Chiều 1 viên, sau ăn', 19, 10);

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
  MODIFY `mh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
