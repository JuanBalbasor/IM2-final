-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 09:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBook` ()  SQL SECURITY INVOKER BEGIN
  SELECT
    *
  FROM inventory;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRequestBook` (IN `_book_id` INT(11))  SQL SECURITY INVOKER BEGIN
  SELECT
    *
  FROM inventory
  WHERE book_id = _book_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudents` ()  SQL SECURITY INVOKER BEGIN
  SELECT
    *
  FROM student;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser` ()  SQL SECURITY INVOKER BEGIN
  SELECT
    *
  FROM user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertBook` (IN `name` VARCHAR(200), IN `stock` INT(50), IN `rr_date` DATE)  SQL SECURITY INVOKER BEGIN
  INSERT INTO library.inventory (Name
  , Qty_stock
  , Qty_issued
  , Total
  , r_date)
    VALUES (name, stock, 0, stock, rr_date);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertBookRequest` (IN `_student_id` INT(11), IN `_book_id` INT(11), IN `requestedBy` VARCHAR(100), IN `requestedFor` VARCHAR(100), IN `qty_requested` INT(50), IN `requeststatus` VARCHAR(100), IN `updatedby` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  INSERT INTO library.request (Student_id
  , book_id
  , Requestdttm
  , RequestedBy
  , RequestedFor
  , Qty_requested
  , Requeststatus
  , Updatedby
  , Updatedttm)
    VALUES (_student_id, _book_id, NOW(), requestedBy, requestedFor, qty_requested, requeststatus, updatedby, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertStudent` (IN `first_name` VARCHAR(100), IN `last_name` VARCHAR(100), IN `birthday` DATE, IN `gender` VARCHAR(10), IN `contact_number` VARCHAR(100), IN `email` VARCHAR(100), IN `course` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  INSERT INTO student (First_name
  , Last_name
  , Birthday
  , Gender
  , Contact_number
  , Email
  , Course
  , Active_ind)
    VALUES (first_name, last_name, birthday, gender, contact_number, email, course, 1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `username` VARCHAR(100), IN `password` VARCHAR(100), IN `_role` VARCHAR(100), IN `first_name` VARCHAR(10), IN `last_name` VARCHAR(10), IN `email` VARCHAR(100), IN `contact_number` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  INSERT INTO library.user (Username
  , Password
  , role
  , First_name
  , Last_name
  , Email
  , Contact_number
  , Active_ind)
    VALUES (username, password, _role, first_name, last_name, email, contact_number, 1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `resetPassword` (IN `_user_id` INT(11), IN `password` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  UPDATE library.user
  SET Password = password
  WHERE User_id = _user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBook` (IN `_book_id` INT(11), IN `name` VARCHAR(200), IN `qty_stock` INT(50), IN `rr_date` DATE)  SQL SECURITY INVOKER BEGIN
  UPDATE library.inventory
  SET Name = name,
      Qty_stock = qty_stock,
      Total = qty_stock,
      r_date = rr_date
  WHERE book_id = _book_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBookRequest` (IN `_request_id` INT(11), IN `requeststatus` VARCHAR(100), IN `updatedby` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  UPDATE library.request
  SET Requeststatus = requeststatus,
      Updatedby = updatedby,
      Updatedttm = NOW()
  WHERE Request_id = _request_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBookStock` (IN `_book_id` INT(11), IN `qty_stock` INT(50), IN `qty_issued` INT(50))  SQL SECURITY INVOKER BEGIN
  UPDATE inventory
  SET Qty_stock = qty_stock,
      Qty_issued = qty_issued
  WHERE book_id = _book_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStudent` (IN `_student_id` INT(11), IN `first_name` VARCHAR(100), IN `last_name` VARCHAR(100), IN `birthday` DATE, IN `gender` VARCHAR(10), IN `contact_number` VARCHAR(100), IN `email` VARCHAR(100), IN `course` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  UPDATE student
  SET First_name = first_name,
      Last_name = last_name,
      Birthday = birthday,
      Gender = gender,
      Contact_number = contact_number,
      Email = email,
      Course = course
  WHERE Student_id = _student_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStudentStatus` (IN `_student_id` INT(11), IN `active_ind` INT(1))  SQL SECURITY INVOKER BEGIN
  UPDATE student
  SET Active_ind = active_ind
  WHERE Student_id = _student_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `_user_id` VARCHAR(100), IN `_role` VARCHAR(100), IN `first_name` VARCHAR(10), IN `last_name` VARCHAR(10), IN `email` VARCHAR(100), IN `contact_number` VARCHAR(100))  SQL SECURITY INVOKER BEGIN
  UPDATE library.user
  SET role = _role,
      First_name = first_name,
      Last_name = last_name,
      Email = email,
      Contact_number = contact_number
  WHERE User_id = _user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserStatus` (IN `_user_id` INT(11), IN `active_ind` INT(1))  SQL SECURITY INVOKER BEGIN
  UPDATE user
  SET Active_ind = active_ind
  WHERE User_id = _user_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `book_id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Qty_stock` int(50) NOT NULL,
  `Qty_issued` int(50) NOT NULL,
  `Total` int(50) NOT NULL,
  `r_date` date NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`book_id`, `Name`, `Qty_stock`, `Qty_issued`, `Total`, `r_date`) VALUES
(4, 'Test', 5, 27, 10, '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `Request_id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `Requestdttm` datetime NOT NULL,
  `RequestedBy` varchar(100) NOT NULL,
  `RequestedFor` varchar(100) NOT NULL,
  `Qty_requested` int(50) NOT NULL,
  `Requeststatus` varchar(100) NOT NULL,
  `Updatedby` varchar(100) NOT NULL,
  `Updatedttm` datetime NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=1092 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`Request_id`, `Student_id`, `book_id`, `Requestdttm`, `RequestedBy`, `RequestedFor`, `Qty_requested`, `Requeststatus`, `Updatedby`, `Updatedttm`) VALUES
(16, 7, 4, '2023-12-24 16:54:06', 'Bertta Diminahal', 'Berto Batungbakal', 2, 'Approved', 'Juan Dela Cruz', '2023-12-24 16:55:57'),
(17, 9, 4, '2023-12-24 16:55:07', 'Bertta Diminahal', 'Berna Kulangsalambing', 6, 'Approved', 'Juan Dela Cruz', '2023-12-24 16:55:55'),
(18, 8, 4, '2023-12-24 17:46:22', 'Juan Dela Cruz', 'Basilya Dimaculangan', 1, 'Approved', 'Juan Dela Cruz', '2023-12-24 17:46:22'),
(19, 9, 4, '2023-12-24 17:55:51', 'Bertta Diminahal', 'Berna Kulangsalambing', 12, 'Approved', 'Juan Dela Cruz', '2023-12-24 17:56:08'),
(20, 9, 4, '2023-12-24 17:58:27', 'Juan Dela Cruz', 'Berna Kulangsalambing', 1, 'Approved', 'Juan Dela Cruz', '2023-12-24 17:58:27'),
(21, 7, 4, '2023-12-24 22:59:55', 'Juan Dela Cruz', 'Berto Batungbakal', 5, 'Approved', 'Juan Dela Cruz', '2023-12-24 22:59:55'),
(22, 8, 4, '2023-12-24 23:00:24', 'Bertta Diminahal', 'Basilya Dimaculangan', 2, 'Pending For Approval', 'Bertta Diminahal', '2023-12-24 23:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_id` int(11) NOT NULL,
  `First_name` varchar(100) NOT NULL,
  `Last_name` varchar(100) NOT NULL,
  `Birthday` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Contact_number` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Course` varchar(100) NOT NULL,
  `Active_ind` int(1) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=682 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `First_name`, `Last_name`, `Birthday`, `Gender`, `Contact_number`, `Email`, `Course`, `Active_ind`) VALUES
(7, 'Berto', 'Batungbakal', '2023-12-07', 'Male', '923456781', 'berto@test', 'BSHM', 1),
(8, 'Basilya', 'Dimaculangan', '2023-05-01', 'Female', '1111111', 'basilya@test', 'BSHM', 1),
(9, 'Berna', 'Kulangsalambing', '2023-12-14', 'Female', '76768484', 'berna@test', 'BSIT', 1),
(10, 'Agapito', 'Bulalaksahardin', '2023-12-05', 'Male', '12389115', 'aga7@test', 'BSED', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_id` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `First_name` varchar(100) NOT NULL,
  `Last_name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contact_number` varchar(100) NOT NULL,
  `Active_ind` int(1) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=1489 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_id`, `Username`, `Password`, `role`, `First_name`, `Last_name`, `Email`, `Contact_number`, `Active_ind`) VALUES
(3, 'ADMIN', '393dc846e3defd361be8e70653b30b3e', 'Admin', 'Juan', 'Dela Cruz', 'juan@test', '67892345671', 1),
(4, 'BERTA', '393dc846e3defd361be8e70653b30b3e', 'Staff', 'Bertta', 'Diminahal', 'berta@test', '95467474746', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`Request_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `Request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
