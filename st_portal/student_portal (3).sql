-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 05:59 AM
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
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `SubjectCode` varchar(10) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `PresentCount` int(11) NOT NULL DEFAULT 0,
  `AbsentCount` int(11) NOT NULL DEFAULT 0,
  `TotalPeriods` int(11) NOT NULL DEFAULT 0,
  `attendance_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `SubjectCode`, `SubjectName`, `PresentCount`, `AbsentCount`, `TotalPeriods`, `attendance_date`) VALUES
(7, 'S001', 'CS101', 'Computer Science', 28, 2, 30, '2024-10-10'),
(8, 'S001', 'MA101', 'Mathematics', 26, 4, 30, '2024-10-10'),
(9, 'S001', 'PH101', 'Physics', 27, 3, 30, '2024-10-10'),
(10, 'S002', 'CS101', 'Computer Science', 25, 5, 30, '2024-10-10'),
(11, 'S002', 'MA101', 'Mathematics', 28, 2, 30, '2024-10-10'),
(12, 'S002', 'PH101', 'Physics', 29, 1, 30, '2024-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `student_id` varchar(20) NOT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `communication_address` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `relation_type` varchar(50) DEFAULT NULL,
  `primary_contact_name` varchar(100) DEFAULT NULL,
  `primary_contact_occupation` varchar(100) DEFAULT NULL,
  `primary_contact_email` varchar(100) DEFAULT NULL,
  `primary_contact_mobile` varchar(15) DEFAULT NULL,
  `primary_contact_permanent_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`student_id`, `personal_email`, `mobile_number`, `communication_address`, `permanent_address`, `relation_type`, `primary_contact_name`, `primary_contact_occupation`, `primary_contact_email`, `primary_contact_mobile`, `primary_contact_permanent_address`) VALUES
('S001', 'john.doe@gmail.com', '123-456-7890', '123 Elm St, New York, NY', '456 Oak St, New York, NY', 'Father', 'Michael Doe', 'Engineer', 'michael.doe@example.com', '987-654-3210', '456 Oak St, New York, NY'),
('S002', 'jane.smith@gmail.com', '234-567-8901', '789 Pine St, Los Angeles, CA', '101 Maple St, Los Angeles, CA', 'Mother', 'Sarah Smith', 'Teacher', 'sarah.smith@example.com', '876-543-2109', '101 Maple St, Los Angeles, CA'),
('S003', 'alice.brown@gmail.com', '345-678-9012', '654 Birch St, Chicago, IL', '321 Cedar St, Chicago, IL', 'Sibling', 'David Brown', 'Student', 'david.brown@example.com', '765-432-1098', '321 Cedar St, Chicago, IL');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `student_id` varchar(20) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`student_id`, `course_name`, `semester`) VALUES
('S001', 'Computer Science', 1),
('S002', 'Information Technology', 2),
('S001', 'Mathematics', 1);

-- --------------------------------------------------------

--
-- Table structure for table `internal_marks`
--

CREATE TABLE `internal_marks` (
  `student_id` varchar(20) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internal_marks`
--

INSERT INTO `internal_marks` (`student_id`, `subject_name`, `marks`) VALUES
('S001', 'Computer Science', 92),
('S001', 'Mathematics', 85),
('S001', 'Physics', 78),
('S002', 'Chemistry', 90);

-- --------------------------------------------------------

--
-- Table structure for table `leave_info`
--

CREATE TABLE `leave_info` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_info`
--

INSERT INTO `leave_info` (`id`, `student_id`, `leave_type`, `start_date`, `end_date`) VALUES
(1, 'S001', 'Sick Leave', '2024-09-01', '2024-09-05'),
(2, 'S001', 'Casual Leave', '2024-09-10', '2024-09-12'),
(3, 'S002', 'Emergency Leave', '2024-09-15', '2024-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` varchar(50) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `student_id`, `time`, `message`) VALUES
(NULL, 0, '2024-10-09 21:33:51', 'Welcome to the student portal!'),
(NULL, 0, '2024-10-09 21:33:51', 'Your assignment is due next week.'),
(NULL, 0, '2024-10-09 21:33:51', 'Don’t forget to check your grades.'),
(NULL, 0, '2024-10-09 21:50:05', 'Welcome to the student portal!'),
(NULL, 0, '2024-10-09 21:50:05', 'Your assignment is due next week.'),
(NULL, 0, '2024-10-09 21:50:05', 'Don’t forget to check your grades.');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `student_id` varchar(20) NOT NULL,
  `roll_number` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `supervisor` varchar(100) DEFAULT NULL,
  `college_email` varchar(100) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `person_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`student_id`, `roll_number`, `student_name`, `course_name`, `semester`, `date_of_joining`, `date_of_birth`, `sex`, `blood_group`, `place_of_birth`, `department`, `supervisor`, `college_email`, `branch_name`, `bank_name`, `bank_account_no`, `person_type`) VALUES
('S001', '2021001', 'John Doe', 'Computer Science', 2, '2021-08-01', '2003-05-15', 'Male', 'O+', 'New York', 'CS', 'Dr. Smith', 'john.doe@example.com', 'CS', 'Bank of America', '1234567890', NULL),
('S002', '2021002', 'Jane Smith', 'Information Technology', 3, '2021-08-01', '2003-03-20', 'Female', 'A-', 'Los Angeles', 'IT', 'Dr. Johnson', 'jane.smith@example.com', 'IT', 'Wells Fargo', '0987654321', NULL),
('S003', '2021003', 'Alice Brown', 'Computer Science', 1, '2022-01-15', '2004-11-05', 'Female', 'B+', 'Chicago', 'CS', 'Dr. White', 'alice.brown@example.com', 'CS', 'Chase Bank', '1122334455', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` varchar(20) DEFAULT NULL,
  `semester` int(11) NOT NULL,
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `grade` varchar(2) NOT NULL,
  `credits` int(11) NOT NULL,
  `result` varchar(10) NOT NULL,
  `cgpa` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`student_id`, `semester`, `subject_code`, `subject_name`, `grade`, `credits`, `result`, `cgpa`) VALUES
('S001', 1, 'CS101', 'Introduction to Computer Science', 'A', 4, 'Pass', NULL),
('S001', 1, 'MA101', 'Calculus I', 'B', 4, 'Pass', NULL),
('S001', 2, 'CS201', 'Data Structures', 'A', 4, 'Pass', NULL),
('S002', 1, 'EE101', 'Circuit Analysis', 'B', 4, 'Pass', NULL),
('S002', 1, 'MA101', 'Calculus I', 'C', 4, 'Pass', NULL),
('S002', 2, 'EE201', 'Electromagnetic Theory', 'A', 4, 'Pass', NULL),
('S003', 1, 'ME101', 'Engineering Mechanics', 'A+', 4, 'Pass', NULL),
('S003', 2, 'ME201', 'Thermodynamics', 'A', 4, 'Pass', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(50) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `student_photo` varchar(255) NOT NULL,
  `attendance_percentage` decimal(5,2) NOT NULL,
  `cgpa` decimal(3,2) DEFAULT NULL,
  `student_password` varchar(255) NOT NULL,
  `leave_taken` int(11) DEFAULT 0,
  `leave_balance` int(11) DEFAULT 0,
  `student_name` varchar(100) DEFAULT NULL,
  `student_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_email`, `student_photo`, `attendance_percentage`, `cgpa`, `student_password`, `leave_taken`, `leave_balance`, `student_name`, `student_phone`) VALUES
('S001', 'john.doe@example.com', 'photo1.jpeg', 95.00, 3.75, 'password123', 2, 81, 'John Doe', '7878787878'),
('S002', 'jane.smith@example.com', 'images/jane_smith.jpg', 88.50, 3.60, 'securepassword', 1, 9, 'GGGGGGG', '5454545454'),
('S003', 'alice.johnson@example.com', 'images/alice_johnson.jpg', 92.00, 3.80, 'mypassword', 3, 7, NULL, NULL),
('S004', 'bob.brown@example.com', 'images/bob_brown.jpg', 85.00, 3.50, 'bobpassword', 0, 10, NULL, NULL),
('S005', 'charlie.black@example.com', 'images/charlie_black.jpg', 90.00, 3.90, 'charliepass', 1, 9, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `internal_marks`
--
ALTER TABLE `internal_marks`
  ADD PRIMARY KEY (`student_id`,`subject_name`);

--
-- Indexes for table `leave_info`
--
ALTER TABLE `leave_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leave_info`
--
ALTER TABLE `leave_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `personal_info` (`student_id`);

--
-- Constraints for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD CONSTRAINT `contact_details_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `personal_info` (`student_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `personal_info` (`student_id`);

--
-- Constraints for table `internal_marks`
--
ALTER TABLE `internal_marks`
  ADD CONSTRAINT `internal_marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `personal_info` (`student_id`);

--
-- Constraints for table `leave_info`
--
ALTER TABLE `leave_info`
  ADD CONSTRAINT `leave_info_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `personal_info` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
