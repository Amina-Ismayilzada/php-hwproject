-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2023 at 11:17 AM
-- Server version: 10.5.16-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20096670_backend_hw_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answerID` int(11) NOT NULL,
  `answer` text NOT NULL,
  `isCorrect` float NOT NULL,
  `questionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answerID`, `answer`, `isCorrect`, `questionID`) VALUES
(1, 'Hyper Text Markup Language', 100, 1),
(2, 'Hyperlinks and Text Markup Language', 0, 1),
(3, 'Homepage Text Markup Language', 0, 1),
(4, 'section', 33.3333, 2),
(5, 'aside', 33.3333, 2),
(6, 'nav', 33.3333, 2),
(7, 'div', -33.3333, 2),
(8, 'page', -33.3333, 2),
(9, 'sidebar', -33.3333, 2),
(10, 'True', 100, 3),
(11, 'False', 0, 3),
(12, 'I agree', 0, 4),
(13, 'I do not agree', 100, 4),
(14, 'Suggest a text tooltip for this image, when mouse is moving over.', 0, 5),
(15, 'Propose a text that will be displayed instead of the image if the browser does not accept them.', 100, 5),
(16, '40', 1, 6),
(17, 'bd', 100, 7);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questionID` int(11) NOT NULL,
  `question` text NOT NULL,
  `feedback` text DEFAULT NULL,
  `mark` float NOT NULL DEFAULT 1,
  `questionTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questionID`, `question`, `feedback`, `mark`, `questionTypeID`) VALUES
(1, 'What does HTML stand for?', 'HTML (HyperText Markup Language) is the code that is used to structure a web page and its content.', 1, 1),
(2, 'Which, among the following elements, is (are) new HTML5 semantic layout markup?', 'A lot of new elements are added in HTML5, mainly to organize your content.', 1, 1),
(3, 'To create a web document, we use first semantic content markup for the content, then we use semantic layout markup to organize our content.', 'Semantic HTML elements are those that clearly describe their meaning, firstly for the content, secondly for the layout, and above all in a human- and machine-readable way.', 1, 2),
(4, 'It is best to include a header and a footer only in the web page, the body element, and not in an article or section.', 'HTML5 header and footer can be include in the body, but also in the article or section elements for a better organisation of your content.', 1, 2),
(5, 'The alt attribute of an image is mainly used to :', 'For accessibility reason, to take into account, for instance, reading in Braille.', 1, 3),
(6, 'To move two elements, main and aside, side by side in a parent div container, using the CSS property display with the value inline-block, if for the main element a width of 60% is set, what should be the width, in %, for the aside element, in order to fill the whole available width?', 'The sum of the width of the main element and the aside element must be less than or equal to the width of the parent element. ', 1, 4),
(7, 'Which statements are correct?\r\n\r\nWrite the sequence of letters (in lowercase) corresponding to the correct statements in ascending alphabetical order.\r\nExample: acd or bc, but not cb!\r\n\r\nYour character string will be compared to the correct character string expected, to earn the point, or not.\r\n\r\n[a] CSS must be declared preferably in each element for easier maintenance\r\n[b] For positioning two elements side by side, inline-block for the display property can be used\r\n[c] Grid is a 1 dimensional layout\r\n[d] Units which can be used for the grid-template are px, % or fr', 'CSS are preferably declared in an external file. The CSS Grid is a 2 dimensional layout.', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE `question_types` (
  `questionTypeID` int(11) NOT NULL,
  `questionType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_types`
--

INSERT INTO `question_types` (`questionTypeID`, `questionType`) VALUES
(1, 'Multiple Choice'),
(2, 'True/False'),
(3, 'Double Choice'),
(4, 'Numerical'),
(5, 'Short Answer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answerID`),
  ADD KEY `questionID` (`questionID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questionID`),
  ADD KEY `questionTypeID` (`questionTypeID`);

--
-- Indexes for table `question_types`
--
ALTER TABLE `question_types`
  ADD PRIMARY KEY (`questionTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `questionTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
