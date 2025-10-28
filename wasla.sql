-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 12:33 PM
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
-- Database: `wasla`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `id_att` int(11) NOT NULL,
  `id_lsn` int(11) NOT NULL,
  `file_att` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`id_att`, `id_lsn`, `file_att`) VALUES
(1, 1, 'algebra_exercises.pdf'),
(2, 2, 'grammar_exercises.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id_exam` int(11) NOT NULL,
  `id_lvl` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `file_url` varchar(2083) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id_exam`, `id_lvl`, `id_sub`, `id_type`, `file_url`) VALUES
(1, 1, 1, 1, 'exam_seventh_math_1.pdf'),
(2, 2, 2, 2, 'test_eighth_arabic_1.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id_lsn` int(11) NOT NULL,
  `title_lsn` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `support` text NOT NULL,
  `id_teach` int(11) NOT NULL,
  `id_lvl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id_lsn`, `title_lsn`, `description`, `support`, `id_teach`, `id_lvl`) VALUES
(1, 'الجبر الأساسي', 'مقدمة عن الجبر للمرحلة السابعة', 'algebra_basics.pdf', 13, NULL),
(2, 'النحو العربي', 'أساسيات النحو والصرف', 'arabic_grammar.pdf', 2, NULL),
(3, 'مفردات اللغة الإنجليزية', 'كلمات وقواعد اللغة الإنجليزية', 'english_vocab.pdf', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_lvl` int(11) NOT NULL,
  `name_lvl` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_lvl`, `name_lvl`) VALUES
(1, 'السابع'),
(2, 'الثامن'),
(3, 'التاسع'),
(4, 'العاشر');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id_option` int(11) NOT NULL,
  `choice_text` text NOT NULL,
  `id_quiz` int(11) NOT NULL,
  `is_true` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id_option`, `choice_text`, `id_quiz`, `is_true`) VALUES
(3, 'يذهب', 2, 1),
(4, 'يذهبان', 2, 0),
(51, 'aa', 10, 1),
(52, 'bbb', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pupil`
--

CREATE TABLE `pupil` (
  `id_ppl` int(11) NOT NULL,
  `name_ppl` varchar(30) NOT NULL,
  `fname_ppl` varchar(30) NOT NULL,
  `username_ppl` varchar(100) NOT NULL,
  `pass_ppl` varchar(255) NOT NULL,
  `id_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupil`
--

INSERT INTO `pupil` (`id_ppl`, `name_ppl`, `fname_ppl`, `username_ppl`, `pass_ppl`, `id_lvl`) VALUES
(1, 'Ahmed', 'Ali', 'ahmed.ali', 'aaaa', 1),
(2, 'Fatima', 'Khaled', 'fatima.khaled', 'aaaa', 2),
(4, 'baraa', 'amoura', 'bara', '$2y$10$gLAqrWrk6zKb1qjj3mc/Y.dY4FeypuqeS', 2),
(6, 'a', 'a', 'a', '$2y$10$ZQV7PfM9iVDWIRo/PP4vQ.RTKiti06PG5', 1),
(7, 'b', 'b', 'b', '$2y$10$AZ3KQzCuhz0kR6AkQAh0x.MmJ.Ecbvnyo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `id_lsn` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `id_lsn`, `question`) VALUES
(2, 2, 'اختر الفعل الصحيح في الجملة التالية: هو ___ إلى المدرسة.'),
(10, 1, 'hhhhh');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id_sub` int(11) NOT NULL,
  `name_sub` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id_sub`, `name_sub`) VALUES
(1, 'الرياضيات'),
(2, 'اللغة العربية'),
(3, 'اللغة الانجليزية'),
(4, 'التربية الاسلامية'),
(5, 'التكنولوجيا'),
(6, 'العلوم العامة'),
(7, 'الدراسات الاجتماعية'),
(8, 'التربية المهنية'),
(9, 'الفنون'),
(10, 'التربية الحياتية');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id_teach` int(11) NOT NULL,
  `name_teach` varchar(30) NOT NULL,
  `fname_teach` varchar(30) NOT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `username_teach` varchar(100) NOT NULL,
  `pass_teach` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id_teach`, `name_teach`, `fname_teach`, `id_sub`, `username_teach`, `pass_teach`, `Email`) VALUES
(1, 'Ali', 'Hassan', 1, 'ali.hassan', 'aaaa', '0'),
(2, 'Sara', 'Mohamed', 2, 'sara.mohamed', 'aaaa', '0'),
(3, 'Omar', 'Abdel', 3, 'omar.abdel', 'aaaa', '0'),
(5, 'a', 'a', 2, 'a', '$2y$10$04n6rkM39wpnJPrw0u76VO1C8qvIjuAb3', 'a'),
(6, 'a', 'f', NULL, 'f', '$2y$10$H7l3TZprmLsC0t.9wF327eBL.bBxpWwTR', 'f'),
(7, 'ayla', 'mss', NULL, 'ayla', '$2y$10$YFt39GH2VQaK1dQb9tqP1O9gDHRo4Scp3', 'ayla@2004gmail.com'),
(8, 'z', 'z', NULL, 'z', '$2y$10$9Sw5p0uiAQekCFv9XNPdJuMnUPrQm1nyD', 'z'),
(9, 'g', 'g', NULL, 'g', '$2y$10$tD6MkmEHwt6lNET/BSdHNuKYATGCNJ3Ms', 'g'),
(10, 'moa', 'bouden', NULL, 'moaa', '$2y$10$sf3k/EWCUDMDHY3dUSy7Du4fO/7Dm5Iv1', 'moa99@gmail.com'),
(11, 'moa', 'bouden', NULL, 'moa', '$2y$10$l7XsuihRbbIYJ0U86WJ8auD0ziasZNXWe', 'moa@gmail.com'),
(12, 'moa', 'bouden', NULL, 'moaaa', 'aa', 'moaa@gmail.com'),
(13, 'IBTIHAL', 'MOUSSA', NULL, 'aa', 'aa', 'moussaibtihal855@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id_type` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id_type`, `type`) VALUES
(1, 'فرض'),
(2, 'اختبار');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id_att`),
  ADD KEY `fk0` (`id_lsn`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id_exam`),
  ADD KEY `fk` (`id_lvl`),
  ADD KEY `fk1` (`id_sub`),
  ADD KEY `fk_exams_type` (`id_type`),
  ADD KEY `ix_exams_ids` (`id_lvl`,`id_sub`,`id_type`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id_lsn`),
  ADD KEY `FKey` (`id_teach`),
  ADD KEY `ix_lesson_id_teach` (`id_teach`),
  ADD KEY `ix_lesson_id_lvl` (`id_lvl`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_lvl`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id_option`),
  ADD KEY `fk6` (`id_quiz`),
  ADD KEY `ix_options_id_quiz` (`id_quiz`);

--
-- Indexes for table `pupil`
--
ALTER TABLE `pupil`
  ADD PRIMARY KEY (`id_ppl`),
  ADD UNIQUE KEY `ux_pupil_username` (`username_ppl`),
  ADD KEY `fk2` (`id_lvl`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `fk3` (`id_lsn`),
  ADD KEY `ix_quiz_id_lsn` (`id_lsn`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id_sub`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id_teach`),
  ADD UNIQUE KEY `ux_teacher_username` (`username_teach`),
  ADD KEY `fk4` (`id_sub`),
  ADD KEY `ix_teacher_id_sub` (`id_sub`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id_att` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id_lsn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_lvl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id_option` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pupil`
--
ALTER TABLE `pupil`
  MODIFY `id_ppl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id_teach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `fk0` FOREIGN KEY (`id_lsn`) REFERENCES `lesson` (`id_lsn`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `fk` FOREIGN KEY (`id_lvl`) REFERENCES `level` (`id_lvl`),
  ADD CONSTRAINT `fk1` FOREIGN KEY (`id_sub`) REFERENCES `subject` (`id_sub`),
  ADD CONSTRAINT `fk_exams_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`) ON UPDATE CASCADE;

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FKey` FOREIGN KEY (`id_teach`) REFERENCES `teacher` (`id_teach`),
  ADD CONSTRAINT `fk_lesson_level` FOREIGN KEY (`id_lvl`) REFERENCES `level` (`id_lvl`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `fk6` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`);

--
-- Constraints for table `pupil`
--
ALTER TABLE `pupil`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`id_lvl`) REFERENCES `level` (`id_lvl`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `fk3` FOREIGN KEY (`id_lsn`) REFERENCES `lesson` (`id_lsn`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk4` FOREIGN KEY (`id_sub`) REFERENCES `subject` (`id_sub`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
