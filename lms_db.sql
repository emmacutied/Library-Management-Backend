-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 09:43 AM
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
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `status` enum('available','borrowed') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `categoryid`, `status`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', 'Classics', 1, 'borrowed'),
(2, 'Pride and Prejudice', 'Jane Austen', 'Classics', 1, 'borrowed'),
(3, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 2, 'available'),
(4, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', 2, 'available'),
(5, '1984', 'George Orwell', 'Fiction', 3, 'available'),
(6, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 3, 'available'),
(7, 'Meditations', 'Marcus Aurelius', 'Philosophy', 4, 'available'),
(8, 'The Republic', 'Plato', 'Philosophy', 4, 'available'),
(9, 'The Diary of a Young Girl', 'Anne Frank', 'Biography', 5, 'available'),
(10, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'History', 6, 'available'),
(11, 'Moby-Dick', 'Herman Melville', 'Classics', 1, 'borrowed'),
(12, 'Jane Eyre', 'Charlotte Brontë', 'Classics', 1, 'available'),
(13, 'The Catcher in the Rye', 'J.D. Salinger', 'Classics', 1, 'borrowed'),
(14, 'Wuthering Heights', 'Emily Brontë', 'Classics', 1, 'borrowed'),
(15, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Classics', 1, 'available'),
(16, 'The Odyssey', 'Homer', 'Classics', 1, 'available'),
(17, 'War and Peace', 'Leo Tolstoy', 'Classics', 1, 'available'),
(18, 'The Name of the Wind', 'Patrick Rothfuss', 'Fantasy', 2, 'available'),
(19, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 2, 'available'),
(20, 'A Game of Thrones', 'George R.R. Martin', 'Fantasy', 2, 'available'),
(21, 'The Lion, the Witch, and the Wardrobe', 'C.S. Lewis', 'Fantasy', 2, 'available'),
(22, 'Mistborn', 'Brandon Sanderson', 'Fantasy', 2, 'available'),
(23, 'The Way of Kings', 'Brandon Sanderson', 'Fantasy', 2, 'available'),
(24, 'The Dark Tower', 'Stephen King', 'Fantasy', 2, 'available'),
(25, 'Brave New World', 'Aldous Huxley', 'Fiction', 3, 'available'),
(26, 'Catch-22', 'Joseph Heller', 'Fiction', 3, 'available'),
(27, 'The Road', 'Cormac McCarthy', 'Fiction', 3, 'available'),
(28, 'The Kite Runner', 'Khaled Hosseini', 'Fiction', 3, 'available'),
(29, 'Life of Pi', 'Yann Martel', 'Fiction', 3, 'available'),
(30, 'The Alchemist', 'Paulo Coelho', 'Fiction', 3, 'available'),
(31, 'Slaughterhouse-Five', 'Kurt Vonnegut', 'Fiction', 3, 'available'),
(32, 'Beyond Good and Evil', 'Friedrich Nietzsche', 'Philosophy', 4, 'available'),
(33, 'The Art of War', 'Sun Tzu', 'Philosophy', 4, 'available'),
(34, 'Critique of Pure Reason', 'Immanuel Kant', 'Philosophy', 4, 'available'),
(35, 'Nicomachean Ethics', 'Aristotle', 'Philosophy', 4, 'available'),
(36, 'Confessions', 'Saint Augustine', 'Philosophy', 4, 'available'),
(37, 'The Prince', 'Niccolò Machiavelli', 'Philosophy', 4, 'available'),
(38, 'The Tao Te Ching', 'Laozi', 'Philosophy', 4, 'available'),
(39, 'Steve Jobs', 'Walter Isaacson', 'Biography', 5, 'available'),
(40, 'The Diary of Anne Frank', 'Anne Frank', 'Biography', 5, 'available'),
(41, 'Long Walk to Freedom', 'Nelson Mandela', 'Biography', 5, 'available'),
(42, 'The Wright Brothers', 'David McCullough', 'Biography', 5, 'available'),
(43, 'Einstein: His Life and Universe', 'Walter Isaacson', 'Biography', 5, 'available'),
(44, 'I Am Malala', 'Malala Yousafzai', 'Biography', 5, 'available'),
(45, 'Alexander Hamilton', 'Ron Chernow', 'Biography', 5, 'available'),
(46, 'Moby-Dick', 'Herman Melville', 'Classics', 1, 'available'),
(47, 'Jane Eyre', 'Charlotte Brontë', 'Classics', 1, 'available'),
(48, 'The Catcher in the Rye', 'J.D. Salinger', 'Classics', 1, 'available'),
(49, 'Wuthering Heights', 'Emily Brontë', 'Classics', 1, 'available'),
(50, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Classics', 1, 'available'),
(51, 'The Odyssey', 'Homer', 'Classics', 1, 'available'),
(52, 'War and Peace', 'Leo Tolstoy', 'Classics', 1, 'available'),
(53, 'The Name of the Wind', 'Patrick Rothfuss', 'Fantasy', 2, 'available'),
(54, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 2, 'available'),
(55, 'A Game of Thrones', 'George R.R. Martin', 'Fantasy', 2, 'available'),
(56, 'The Lion, the Witch, and the Wardrobe', 'C.S. Lewis', 'Fantasy', 2, 'available'),
(57, 'Mistborn', 'Brandon Sanderson', 'Fantasy', 2, 'available'),
(58, 'The Way of Kings', 'Brandon Sanderson', 'Fantasy', 2, 'available'),
(59, 'The Dark Tower', 'Stephen King', 'Fantasy', 2, 'borrowed'),
(60, 'Brave New World', 'Aldous Huxley', 'Fiction', 3, 'available'),
(61, 'Catch-22', 'Joseph Heller', 'Fiction', 3, 'available'),
(62, 'The Road', 'Cormac McCarthy', 'Fiction', 3, 'available'),
(63, 'The Kite Runner', 'Khaled Hosseini', 'Fiction', 3, 'available'),
(64, 'Life of Pi', 'Yann Martel', 'Fiction', 3, 'available'),
(65, 'The Alchemist', 'Paulo Coelho', 'Fiction', 3, 'available'),
(66, 'Slaughterhouse-Five', 'Kurt Vonnegut', 'Fiction', 3, 'available'),
(67, 'Beyond Good and Evil', 'Friedrich Nietzsche', 'Philosophy', 4, 'available'),
(68, 'The Art of War', 'Sun Tzu', 'Philosophy', 4, 'available'),
(69, 'Critique of Pure Reason', 'Immanuel Kant', 'Philosophy', 4, 'available'),
(70, 'Nicomachean Ethics', 'Aristotle', 'Philosophy', 4, 'available'),
(71, 'Confessions', 'Saint Augustine', 'Philosophy', 4, 'available'),
(72, 'The Prince', 'Niccolò Machiavelli', 'Philosophy', 4, 'available'),
(73, 'The Tao Te Ching', 'Laozi', 'Philosophy', 4, 'available'),
(74, 'Steve Jobs', 'Walter Isaacson', 'Biography', 5, 'available'),
(75, 'The Diary of Anne Frank', 'Anne Frank', 'Biography', 5, 'available'),
(76, 'Long Walk to Freedom', 'Nelson Mandela', 'Biography', 5, 'available'),
(77, 'The Wright Brothers', 'David McCullough', 'Biography', 5, 'available'),
(78, 'Einstein: His Life and Universe', 'Walter Isaacson', 'Biography', 5, 'available'),
(79, 'I Am Malala', 'Malala Yousafzai', 'Biography', 5, 'available'),
(80, 'Alexander Hamilton', 'Ron Chernow', 'Biography', 5, 'available'),
(81, 'Guns, Germs, and Steel', 'Jared Diamond', 'History', 6, 'available'),
(82, 'A People\'s History of the United States', 'Howard Zinn', 'History', 6, 'available'),
(83, 'The History of the Ancient World', 'Susan Wise Bauer', 'History', 6, 'available'),
(84, 'The Rise and Fall of the Third Reich', 'William L. Shirer', 'History', 6, 'available'),
(85, 'Team of Rivals', 'Doris Kearns Goodwin', 'History', 6, 'available'),
(86, 'The Silk Roads', 'Peter Frankopan', 'History', 6, 'available'),
(87, '1776', 'David McCullough', 'History', 6, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `borrowedbooks`
--

CREATE TABLE `borrowedbooks` (
  `borrow_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT current_timestamp(),
  `return_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowedbooks`
--

INSERT INTO `borrowedbooks` (`borrow_id`, `userID`, `bookID`, `borrow_date`, `return_date`) VALUES
(25, 2, 12, '2024-11-06 16:22:41', '2024-11-06 16:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_requests`
--

CREATE TABLE `borrow_requests` (
  `request_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_requests`
--

INSERT INTO `borrow_requests` (`request_id`, `userID`, `bookID`, `request_date`, `status`) VALUES
(1, 2, 2, '2024-11-02 13:46:09', 'approved'),
(2, 2, 5, '2024-11-02 13:47:41', 'approved'),
(3, 2, 4, '2024-11-02 13:57:39', 'approved'),
(4, 2, 1, '2024-11-02 16:01:52', 'approved'),
(5, 2, 49, '2024-11-02 16:15:07', 'approved'),
(6, 2, 46, '2024-11-02 16:15:11', 'approved'),
(7, 2, 13, '2024-11-02 16:47:44', 'approved'),
(8, 2, 12, '2024-11-02 16:51:37', 'approved'),
(9, 2, 14, '2024-11-02 16:58:11', 'approved'),
(10, 2, 11, '2024-11-03 12:57:22', 'approved'),
(11, 2, 20, '2024-11-03 13:13:57', 'approved'),
(12, 2, 66, '2024-11-03 13:15:50', 'approved'),
(13, 2, 34, '2024-11-03 13:19:11', 'approved'),
(14, 2, 79, '2024-11-03 14:03:48', 'approved'),
(15, 2, 64, '2024-11-03 14:15:41', 'approved'),
(16, 2, 23, '2024-11-03 14:48:40', 'approved'),
(17, 2, 1, '2024-11-03 17:00:52', 'approved'),
(18, 2, 2, '2024-11-03 17:25:54', 'approved'),
(19, 2, 58, '2024-11-03 22:58:54', 'approved'),
(20, 2, 53, '2024-11-03 22:59:29', 'approved'),
(21, 2, 11, '2024-11-06 11:57:50', 'approved'),
(22, 2, 13, '2024-11-06 12:01:48', 'approved'),
(23, 2, 14, '2024-11-06 12:11:29', 'approved'),
(24, 2, 59, '2024-11-06 12:29:54', 'approved'),
(25, 2, 12, '2024-11-06 16:22:11', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `category_name`) VALUES
(1, 'Classics'),
(2, 'Fantasy'),
(3, 'Fiction'),
(4, 'Philosophy'),
(5, 'Biography'),
(6, 'History');

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE `market` (
  `market_id` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returnedbooks`
--

CREATE TABLE `returnedbooks` (
  `return_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `return_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returnedbooks`
--

INSERT INTO `returnedbooks` (`return_id`, `borrow_id`, `return_date`) VALUES
(22, 25, '2024-11-06 16:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `returned_books`
--

CREATE TABLE `returned_books` (
  `return_id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `strand_gradeLevel` varchar(50) DEFAULT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `address` text DEFAULT NULL,
  `contactNumber` varchar(15) DEFAULT NULL,
  `bookName` varchar(255) DEFAULT NULL,
  `status` enum('Returned','Available') DEFAULT 'Returned',
  `returnDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returned_books`
--

INSERT INTO `returned_books` (`return_id`, `Username`, `strand_gradeLevel`, `fullName`, `gender`, `address`, `contactNumber`, `bookName`, `status`, `returnDate`) VALUES
(66, 'danie', 'GAS Grade 12', 'Danielle Lauren Celecio', 'male', 'Umali St. Tunasan Muntinlupa City ', '09784563213', 'Jane Eyre', 'Returned', '2024-11-06 16:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `contactNumber` varchar(15) DEFAULT NULL,
  `strand_gradeLevel` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `status` enum('Active','Not Active') DEFAULT 'Not Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`, `role`, `gender`, `contactNumber`, `strand_gradeLevel`, `address`, `full_name`, `status`) VALUES
(1, 'junjell', 'junjell@gmail.com', 'junjell123', 'admin', 'male', '09123456789', 'N/A', 'Bayanan Muntinlupa City', 'Junjell Sayson ', 'Active'),
(2, 'danie', 'danie@gmail.com', 'dan123', 'student', 'male', '09784563213', 'GAS Grade 12', 'Umali St. Tunasan Muntinlupa City ', 'Danielle Lauren Celecio', 'Active'),
(3, 'monica', 'monica@gmail.com', 'monica123', 'admin', 'female', '09123456987', 'N/A', 'ParkHome Tunasan Muntinlupa City', 'Monica Masangya', 'Active'),
(4, 'Tristan', 'tristan@gmail.com', 'tristan123', 'student', 'male', '0987264783', 'HE Grade 11', 'Poblacion Muntinlupa City', 'Tristan Joed Abar', 'Active'),
(5, 'reymark', 'reymark@gmail.com', 'tristan123', 'student', 'male', '09476852314', 'HE Grade 12', 'Tunasan Muntinlupa City', 'Reymark Malabarbas', 'Active'),
(6, 'ian', 'ian@gmail.com', 'ian123', 'student', 'male', '0987538563', 'Grade 9', 'Poblacion Muntinlupa City', 'Ian Gab Magpantay', 'Not Active'),
(7, 'angel', 'angel@gmail.com', 'angel123', 'admin', 'female', '095897645231', 'N/A', 'Tunasan Muntinlupa City ', 'Angel Cuenca Cuevas', 'Not Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`market_id`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `returnedbooks`
--
ALTER TABLE `returnedbooks`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `borrow_id` (`borrow_id`);

--
-- Indexes for table `returned_books`
--
ALTER TABLE `returned_books`
  ADD PRIMARY KEY (`return_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `market_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returnedbooks`
--
ALTER TABLE `returnedbooks`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `returned_books`
--
ALTER TABLE `returned_books`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`categoryID`) ON DELETE SET NULL;

--
-- Constraints for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD CONSTRAINT `borrowedbooks_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowedbooks_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_requests_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `market`
--
ALTER TABLE `market`
  ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`bookID`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `returnedbooks`
--
ALTER TABLE `returnedbooks`
  ADD CONSTRAINT `returnedbooks_ibfk_1` FOREIGN KEY (`borrow_id`) REFERENCES `borrowedbooks` (`borrow_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
