-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2018 at 02:50 PM
-- Server version: 10.3.10-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arbilewca`
--

-- --------------------------------------------------------

--
-- Table structure for table `compositions`
--

CREATE TABLE `compositions` (
  `catalog_number` varchar(5) NOT NULL COMMENT 'The catalog number is a letter and 3-digit number, for example M101',
  `name` varchar(255) NOT NULL COMMENT 'The title of the composition',
  `description` varchar(512) DEFAULT NULL COMMENT 'Description of the composition',
  `composer` varchar(255) DEFAULT NULL COMMENT 'The composer of the piece',
  `arranger` varchar(255) DEFAULT NULL COMMENT 'The arranger of the piece',
  `editor` varchar(255) DEFAULT NULL COMMENT 'The editor or lyricist',
  `publisher` varchar(255) DEFAULT NULL COMMENT 'The name of the publishing company',
  `genre` varchar(4) DEFAULT NULL COMMENT 'Which genre is the piece (from the genres table)',
  `ensemble` varchar(4) DEFAULT NULL COMMENT 'Which ensemble plays this piece ',
  `grade` decimal(1,1) UNSIGNED DEFAULT NULL COMMENT 'Grade of difficulty',
  `last_performance_date` datetime DEFAULT NULL COMMENT 'When the composition was last performed',
  `duration_start` datetime DEFAULT NULL COMMENT 'Time the piece starts - to calculate duration',
  `duration_end` datetime DEFAULT NULL COMMENT 'The time the piece ends - to calculate duration',
  `comments` varchar(4096) DEFAULT NULL COMMENT 'Comments about the piece, liner notes',
  `performance_notes` varchar(2048) DEFAULT NULL COMMENT 'Performance notes (how to rehearse it, for example)',
  `storage_location` varchar(255) DEFAULT NULL COMMENT 'Where it is kept (which drawer)',
  `date_acquired` datetime DEFAULT NULL COMMENT 'When the piece was acquired',
  `cost` decimal(4,2) DEFAULT NULL COMMENT 'How much did it cost, in dollars and cents',
  `listening_example_link` varchar(255) DEFAULT NULL COMMENT 'A link to a listening example, maybe on YouTube',
  `checked_out` varchar(255) DEFAULT NULL COMMENT 'To whom was this piece lended',
  `paper_size` varchar(4) NOT NULL COMMENT 'Physical size, from the paper_sizes table',
  `last_inventory_date` datetime DEFAULT NULL COMMENT 'When was the last time somebody touched this music',
  `enabled` int(11) UNSIGNED NOT NULL COMMENT 'Set greater than 0 if this composition can be played'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps compositions.';

-- --------------------------------------------------------

--
-- Table structure for table `ensembles`
--

CREATE TABLE `ensembles` (
  `id_ensemble` varchar(4) NOT NULL COMMENT 'The unique ID of this ensemble (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'The name of the ensemble',
  `description` varchar(512) DEFAULT NULL COMMENT 'A description of the ensemble',
  `link` varchar(512) DEFAULT NULL COMMENT 'Hypertext link to more about this ensemble',
  `enabled` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the ensemble to be used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps ensembles (performing groups).';

--
-- Dumping data for table `ensembles`
--

INSERT INTO `ensembles` (`id_ensemble`, `name`, `description`, `link`, `enabled`) VALUES
('C', 'Austin Civic Wind Ensemble', 'The Austin Civic Wind Ensemble is a gathering of adult musicians enjoying the challenge of a high-quality repertoire.  The wide range of age and skill level supports our value of inclusion and fosters our mission of using music for lifelong learning, while promoting joy in our community through live performances.', 'https://acwe.org/about', 1),
('F', 'Violent Clown Flute Choir', 'The Violent Clown Flute Choir flute ensemble does not require auditions and welcomes players of varying skill levels who desire to be part of a unique chamber group experience and celebrate the beautiful sound of the flute - including piccolo, C flute, alto flute, and bass flute. The choir plays mostly intermediate level repertoire and focuses on the fundamentals of flute playing to improve all members\' musical aptitude.', 'http://violetcrownflutechoir.org', 1);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id_genre` varchar(4) NOT NULL COMMENT 'The unique ID of this genre (1-4 letters)',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the genre, for example March',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular genre',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the genre to be used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps genres.';

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id_genre`, `name`, `description`, `enabled`) VALUES
('C', 'Christmas', 'Christmas music comprises a variety of genres of music normally performed or heard around the Christmas season.', 1),
('M', 'March', 'A march, as a musical genre, is a piece of music with a strong regular rhythm which in origin was expressly written for marching to and most frequently performed by a military band.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `paper_sizes`
--

CREATE TABLE `paper_sizes` (
  `id_paper_size` varchar(4) NOT NULL COMMENT 'Paper size ID (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'Size, for example Legal, Letter, Folio',
  `description` varchar(255) DEFAULT NULL COMMENT 'Use to list other examples',
  `vertical` int(11) UNSIGNED DEFAULT NULL COMMENT 'Vertical size in inches times 100',
  `horizontal` int(11) UNSIGNED DEFAULT NULL COMMENT 'Horizontal size in inches times 100',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if this size is used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps paper sizes.';

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id_part` int(10) UNSIGNED NOT NULL COMMENT 'The unique ID of this part',
  `catalog_number` varchar(255) NOT NULL DEFAULT '' COMMENT 'Library catalog number of the composition to which this part belongs',
  `id_part_type` int(10) UNSIGNED NOT NULL COMMENT 'Which type of part, from the part_types table',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the part, if different from the part type',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular part',
  `originals_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if originals of this part exist',
  `copies_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if copies of this part exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds parts.';

-- --------------------------------------------------------

--
-- Table structure for table `part_collections`
--

CREATE TABLE `part_collections` (
  `id_part_collection` int(10) UNSIGNED NOT NULL COMMENT 'Primary identifier of a part collection',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The name of the type of part, for example Percussion 1',
  `description` varchar(255) DEFAULT NULL COMMENT 'Complete description of this part collection',
  `id_part_type` int(10) UNSIGNED DEFAULT NULL COMMENT 'Which part type is part of this collection',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'If this part collection is enabled use 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds part collections.';

-- --------------------------------------------------------

--
-- Table structure for table `part_types`
--

CREATE TABLE `part_types` (
  `id_part_type` int(10) UNSIGNED NOT NULL COMMENT 'The ID of this part type.',
  `collation` int(10) UNSIGNED NOT NULL COMMENT 'Orchestra score order',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The name of the type of part, for example Trumpet 1',
  `description` varchar(255) DEFAULT NULL COMMENT 'Longer description of the type of part',
  `family` varchar(128) NOT NULL COMMENT 'Woodwind, brass, percussion, strings, etc.',
  `id_part_collection` int(10) UNSIGNED DEFAULT NULL COMMENT 'If this part is more than one instrument this is the ID of the collection',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set to 1 to enable this part type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds kinds/types of parts for parts and part collections.';

-- --------------------------------------------------------

--
-- Table structure for table `recordings`
--

CREATE TABLE `recordings` (
  `id_recording` int(10) UNSIGNED NOT NULL COMMENT 'Unique ID for this recording',
  `catalog_number` varchar(5) NOT NULL COMMENT 'The catalog number of the composition',
  `name` varchar(255) DEFAULT NULL COMMENT 'The name of the music or sound on the recording',
  `link` varchar(512) DEFAULT NULL COMMENT 'Link to the file',
  `concert` varchar(255) DEFAULT NULL COMMENT 'Link to the concert event',
  `venue` varchar(255) DEFAULT NULL COMMENT 'Link to the concert venue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps recordings.';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(10) UNSIGNED NOT NULL COMMENT 'Unique ID for the user',
  `username` varchar(128) NOT NULL COMMENT 'The user name',
  `password` varchar(128) NOT NULL COMMENT 'User password',
  `name` varchar(255) DEFAULT NULL COMMENT 'Real name',
  `address` varchar(255) DEFAULT NULL COMMENT 'Users e-mail address',
  `roles` varchar(255) DEFAULT NULL COMMENT 'Text field containing roles'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps users.';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `name`, `address`, `roles`) VALUES
(2, 'admin', '$2y$10$cG.C00l.2QwQF/pRm6xR6elqOVrdMVi0LmEc1zmFb05PjeOJyxB4q', NULL, 'gill@fishparts.net', 'administrator user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compositions`
--
ALTER TABLE `compositions`
  ADD PRIMARY KEY (`catalog_number`),
  ADD KEY `genre` (`genre`),
  ADD KEY `ensemble` (`ensemble`),
  ADD KEY `paper_size` (`paper_size`);

--
-- Indexes for table `ensembles`
--
ALTER TABLE `ensembles`
  ADD PRIMARY KEY (`id_ensemble`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genre`),
  ADD UNIQUE KEY `id_genre` (`id_genre`);

--
-- Indexes for table `paper_sizes`
--
ALTER TABLE `paper_sizes`
  ADD PRIMARY KEY (`id_paper_size`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id_part`),
  ADD KEY `id_part_type` (`id_part_type`);

--
-- Indexes for table `part_collections`
--
ALTER TABLE `part_collections`
  ADD KEY `id_part_type` (`id_part_type`);

--
-- Indexes for table `part_types`
--
ALTER TABLE `part_types`
  ADD PRIMARY KEY (`id_part_type`);

--
-- Indexes for table `recordings`
--
ALTER TABLE `recordings`
  ADD PRIMARY KEY (`id_recording`),
  ADD KEY `catalog_number` (`catalog_number`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id_part` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The unique ID of this part';

--
-- AUTO_INCREMENT for table `part_types`
--
ALTER TABLE `part_types`
  MODIFY `id_part_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this part type.';

--
-- AUTO_INCREMENT for table `recordings`
--
ALTER TABLE `recordings`
  MODIFY `id_recording` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this recording';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the user', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compositions`
--
ALTER TABLE `compositions`
  ADD CONSTRAINT `compositions_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `genres` (`id_genre`),
  ADD CONSTRAINT `compositions_ibfk_2` FOREIGN KEY (`ensemble`) REFERENCES `ensembles` (`id_ensemble`),
  ADD CONSTRAINT `compositions_ibfk_3` FOREIGN KEY (`paper_size`) REFERENCES `paper_sizes` (`id_paper_size`);

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_ibfk_1` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`);

--
-- Constraints for table `part_collections`
--
ALTER TABLE `part_collections`
  ADD CONSTRAINT `part_collections_ibfk_1` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`);

--
-- Constraints for table `recordings`
--
ALTER TABLE `recordings`
  ADD CONSTRAINT `recordings_ibfk_1` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
