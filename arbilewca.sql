-- phpMyAdmin SQL Dump
-- version 5.1.1-1.fc34
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2021 at 04:53 PM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `description` varchar(2048) DEFAULT NULL COMMENT 'Description of the composition',
  `composer` varchar(255) DEFAULT NULL COMMENT 'The composer of the piece',
  `arranger` varchar(255) DEFAULT NULL COMMENT 'The arranger of the piece',
  `editor` varchar(255) DEFAULT NULL COMMENT 'The editor or lyricist',
  `publisher` varchar(255) DEFAULT NULL COMMENT 'The name of the publishing company',
  `genre` varchar(4) DEFAULT NULL COMMENT 'Which genre is the piece (from the genres table)',
  `ensemble` varchar(4) DEFAULT NULL COMMENT 'Which ensemble plays this piece ',
  `grade` decimal(2,1) UNSIGNED DEFAULT NULL COMMENT 'Grade of difficulty',
  `last_performance_date` date DEFAULT NULL COMMENT 'When the composition was last performed',
  `duration_start` datetime DEFAULT NULL COMMENT 'Time the piece starts - to calculate duration',
  `duration_end` datetime DEFAULT NULL COMMENT 'The time the piece ends - to calculate duration',
  `comments` varchar(4096) DEFAULT NULL COMMENT 'Comments about the piece, liner notes',
  `performance_notes` varchar(2048) DEFAULT NULL COMMENT 'Performance notes (how to rehearse it, for example)',
  `storage_location` varchar(255) DEFAULT NULL COMMENT 'Where it is kept (which drawer)',
  `date_acquired` date DEFAULT NULL COMMENT 'When the piece was acquired',
  `cost` decimal(4,2) DEFAULT NULL COMMENT 'How much did it cost, in dollars and cents',
  `listening_example_link` varchar(255) DEFAULT NULL COMMENT 'A link to a listening example, maybe on YouTube',
  `checked_out` varchar(255) DEFAULT NULL COMMENT 'To whom was this piece lended',
  `paper_size` varchar(4) NOT NULL DEFAULT 'L' COMMENT 'Physical size, from the paper_sizes table',
  `image_path` varchar(2048) DEFAULT NULL COMMENT 'Where a picture (image) of the score resides',
  `windrep_link` text DEFAULT NULL COMMENT 'Where can you this arrangement on the Wind Repertory site windrep.org?',
  `last_inventory_date` date DEFAULT NULL COMMENT 'When was the last time somebody touched this music',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Set greater than 0 if this composition can be played'
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
('B5Q', 'Brass quintet', 'A brass quintet is a five-piece musical ensemble composed of brass instruments. The instrumentation for a brass quintet typically includes two trumpets or cornets, one French horn, one trombone or euphonium/baritone horn, and one tuba or bass trombone.', '', 1),
('C', 'Austin Civic Wind Ensemble', 'The Austin Civic Wind Ensemble is a gathering of adult musicians enjoying the challenge of a high-quality repertoire.  The wide range of age and skill level supports our value of inclusion and fosters our mission of using music for lifelong learning, while promoting joy in our community through live performances.', 'https://acwe.org/about', 1),
('F', 'Violet Crown Flute Choir', 'The Violet Crown Flute Choir flute ensemble does not require auditions and welcomes players of varying skill levels who desire to be part of a unique chamber group experience and celebrate the beautiful sound of the flute - including piccolo, C flute, alto flute, and bass flute. The choir plays mostly intermediate level repertoire and focuses on the fundamentals of flute playing to improve all members\' musical aptitude.', 'http://violetcrownflutechoir.org', 1);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id_genre` varchar(4) NOT NULL COMMENT 'The unique ID of this genre (1-4 letters)',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the genre, for example March',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular genre',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the genre to be used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps genres (March, Jazz, Transcription, etc.).';

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id_genre`, `name`, `description`, `enabled`) VALUES
('C', 'Christmas', 'Christmas music comprises a variety of genres of music normally performed or heard around the Christmas season.', 1),
('Ch', 'Ch is ch', 'Don\'t know what Ch means', 1),
('J', 'Jazz', 'Jazz composition or arrangement for band', 1),
('M', 'March', 'A march, as a musical genre, is a piece of music with a strong regular rhythm which in origin was expressly written for marching to and most frequently performed by a military band.', 1),
('O', 'Other', 'Something other than one of the genres', 1),
('P', 'Pop', 'Arrangements of popular music', 1),
('SH', 'Show tunes', 'Music from plays or Broadway shows', 1),
('Solo', 'Solo with band accompaniment', 'Piece for solo instrument with band accompaniment', 1),
('T', 'Symphonic transcription', 'Transcriptions of classic and contemporary symphonic works for band', 1),
('W', 'Wind ensemble', 'A piece composed specifically for wind ensemble or concert band.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `paper_sizes`
--

CREATE TABLE `paper_sizes` (
  `id_paper_size` varchar(4) NOT NULL COMMENT 'Paper size ID (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'Size, for example Legal, Letter, Folio',
  `description` varchar(255) DEFAULT NULL COMMENT 'Use to list other examples',
  `vertical` decimal(7,2) UNSIGNED DEFAULT NULL COMMENT 'Vertical size in inches',
  `horizontal` decimal(7,2) UNSIGNED DEFAULT NULL COMMENT 'Horizontal size in inches',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if this size is used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table keeps paper sizes.';

--
-- Dumping data for table `paper_sizes`
--

INSERT INTO `paper_sizes` (`id_paper_size`, `name`, `description`, `vertical`, `horizontal`, `enabled`) VALUES
('B', 'Broadsheet', 'Many broadsheets measure roughly 29+1â„2 by 23+1â„2 in', '23.50', '29.50', 0),
('F', 'Folio', 'Folio size, used for parts and some scores, is roughly equivalent to EU C4, which is 9 x 12.9', '12.00', '9.00', 1),
('G', 'Legal', 'Legal size is taller than letter. Should be 8.5 x 14', '14.00', '8.50', 1),
('L', 'Letter', 'Letter, roughly equivalent to A4, is used for choral scores and parts. Should be 8.5\" x 11\"', '11.00', '8.50', 1),
('M', 'Marching band part', 'The standard for marching band flip folder parts is 6.75\"w x 5.25\"h', '5.25', '6.75', 1),
('T', 'Tabloid', 'Tabloid, sometimes called ledger, is similar to A3.', '17.00', '11.00', 1),
('V', 'Octavo', 'About an eighth the size of an unfolded newspaper, or 7 x 10.75', '10.75', '7.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `catalog_number` varchar(255) NOT NULL DEFAULT '' COMMENT 'Library catalog number of the composition to which this part belongs',
  `id_part_type` int(10) UNSIGNED NOT NULL COMMENT 'Which type of part, from the part_types table',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the part, if different from the part type',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular part',
  `is_part_collection` int(11) DEFAULT NULL COMMENT 'This is a part collection of other parts',
  `paper_size` varchar(4) DEFAULT NULL COMMENT 'Physical size, from the paper_sizes table',
  `page_count` int(11) DEFAULT NULL COMMENT 'How many pages does this part contain?',
  `image_path` text DEFAULT NULL COMMENT 'Where an image of this part is stored.',
  `originals_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if originals of this part exist',
  `copies_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if copies of this part exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds parts.';

-- --------------------------------------------------------

--
-- Table structure for table `part_collections`
--

CREATE TABLE `part_collections` (
  `is_part_collection` int(10) UNSIGNED NOT NULL COMMENT 'Primary identifier of a part collection',
  `catalog_number_key` varchar(255) NOT NULL COMMENT 'Catalog number of the part ID',
  `id_part_type_key` int(10) UNSIGNED NOT NULL COMMENT 'Part ID that this collection belongs to',
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
  `description` varchar(2048) DEFAULT NULL COMMENT 'Longer description of the type of part',
  `family` varchar(128) NOT NULL COMMENT 'Woodwind, brass, percussion, strings, etc.',
  `is_part_collection` int(10) UNSIGNED DEFAULT NULL COMMENT 'If this part is more than one instrument this is the ID of the collection',
  `enabled` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set to 1 to enable this part type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds kinds/types of parts for parts and part collections.';

--
-- Dumping data for table `part_types`
--

INSERT INTO `part_types` (`id_part_type`, `collation`, `name`, `description`, `family`, `is_part_collection`, `enabled`) VALUES
(1, 10, 'Piccolo', 'The piccolo is a half-size flute, and a member of the woodwind family of musical instruments.', 'Woodwind', 0, 1),
(2, 20, 'Flute', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(4, 40, 'Oboe', 'The oboe is a type of double reed woodwind instrument.', 'Woodwind', 0, 1),
(5, 50, 'English Horn', 'The English horn', 'Woodwind', 0, 1),
(6, 60, 'Bassoon', 'The bassoon is a woodwind instrument in the double reed family, which has a tenor and bass sound.', 'Woodwind', 0, 1),
(7, 70, 'Contrabassoon', 'The contrabassoon, also known as the double bassoon, is a larger version of the bassoon, sounding an octave lower.', 'Woodwind', 0, 0),
(8, 80, 'Clarinet in Eb', 'The E-flat (E♭) clarinet is a member of the clarinet family, smaller than the more common B♭ clarinet and pitched a perfect fourth higher.', 'Woodwind', 0, 1),
(9, 90, 'Clarinet in Bb', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(10, 100, 'Bass Clarinet', 'Bass clarinet is usually pitched in B♭ (meaning it is a transposing instrument on which a written C sounds as B♭), but it plays notes an octave below the soprano B♭ clarinet.', 'Woodwind', 0, 1),
(11, 110, 'Soprano Saxophone', 'The soprano saxophone is a higher-register variety of the saxophone.', 'Woodwind', 0, 1),
(12, 120, 'Alto Saxophone', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(13, 130, 'Tenor Saxophone', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(14, 140, 'Baritone Saxophone', 'The baritone saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(15, 150, 'Bass Saxophone', 'The bass saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(16, 160, 'Horn in F', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', 0, 1),
(17, 170, 'Trumpet in Bb', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(18, 180, 'Trombone', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(19, 190, 'Bass Trombone', 'A variation of the trombone family, considered the lower member of the trombone family.', 'Brass', 0, 1),
(20, 200, 'Baritone', 'The baritone horn, or sometimes just called baritone, is a valved, low-pitched brass instrument.', 'Brass', 0, 1),
(21, 210, 'Euphonium', 'Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.', 'Brass', 0, 1),
(22, 220, 'Tuba', 'The tuba is the lowest-pitched musical instrument in the brass family.', 'Brass', 0, 1),
(23, 230, 'Timpani', 'Timpani or kettledrums are musical instruments in the percussion family.', 'Percussion', 0, 1),
(24, 240, 'Cymbals', 'A cymbal is a common percussion instrument. Often used in pairs, cymbals consist of thin, normally round plates of various alloys.', 'Percussion', 0, 1),
(25, 250, 'Agogo bells', 'An agogô (Yoruba: agogo, meaning bell) is a single or a multiple bell', 'Percussion', 0, 1),
(26, 260, 'Triangle', 'The triangle is an idiophone type of musical instrument in the percussion family.', 'Percussion', 0, 1),
(27, 270, 'Tam-Tam', 'A gong of indefinite pitch.', 'Percussion', 0, 1),
(28, 280, 'Tambourine', 'The tambourine is a musical instrument in the percussion family consisting of a frame, often of wood or plastic, with pairs of small metal jingles, called \"zills\".', 'Percussion', 0, 1),
(29, 290, 'Snare drum', 'The snare drum or side drum is a percussion instrument that produces a sharp staccato sound when the head is struck with a drum stick.', 'Percussion', 0, 1),
(30, 300, 'Bass drum', 'The bass drum, or kick drum, is a large drum that produces a note of low definite or indefinite pitch.', 'Percussion', 0, 1),
(31, 310, 'Marimba', 'A percussion instrument consisting of a set of wooden bars struck with yarn or rubber mallets to produce musical tones.', 'Percussion', 0, 1),
(32, 320, 'Vibraphone', 'A percussion instrument that has tuned metal bars.', 'Percussion', 0, 1),
(33, 330, 'Xylophone', 'A percussion instrument consisting of a set of graduated, tuned wooden bars supported at nodal (nonvibrating) points and struck with sticks or padded mallets.', 'Percussion', 0, 1),
(34, 340, 'Chimes', 'Also called tubular bells, chimes produce a sound that resembles church bells, or a carillon.', 'Percussion', 0, 1),
(35, 350, 'Harp', 'The harp is a stringed musical instrument that has a number of individual strings running at an angle to its soundboard; the strings are plucked with the fingers.', 'Percussion', 0, 1),
(36, 360, 'Piano', 'The piano is an acoustic, stringed musical instrument in which the strings are struck by wooden hammers and is played using a keyboard.', 'Percussion', 0, 1),
(37, 370, 'String Bass', ' The double bass, also known simply as the bass, is the largest and lowest-pitched bowed (or plucked) string instrument.', 'Strings', 0, 1),
(40, 1, 'Full score', 'The full conductor score contains all of the instrument parts', 'Other', 0, 1),
(41, 2, 'Condensed score', 'The condensed conductor score shows only the most relevant parts', 'Other', 0, 1),
(42, 21, 'Flute 1', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(43, 22, 'Flute 2', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(44, 92, 'Clarinet in Bb 1', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(45, 93, 'Clarinet in Bb 2', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 1, 1),
(46, 94, 'Clarinet in Bb 3', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(47, 91, 'Solo Clarinet in Bb', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 0),
(48, 121, 'Alto Saxophone 1', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(49, 122, 'Alto Saxophone 2', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(50, 131, 'Tenor Saxophone 1', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(51, 132, 'Tenor Saxophone 2', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(52, 161, 'Horn in F 1', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', 0, 1),
(53, 162, 'Horn in F 2', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Woodwind', 0, 1),
(54, 163, 'Horn in F 3', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Woodwind', 0, 1),
(55, 164, 'Horn in F 4', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Woodwind', 0, 1),
(56, 167, 'Cornet 1', 'The cornet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(57, 168, 'Cornet 2', 'The cornet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(58, 171, 'Solo Trumpet in Bb', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Woodwind', 0, 1),
(59, 172, 'Trumpet in Bb 1', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(60, 173, 'Trumpet in Bb 2', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(61, 174, 'Trumpet in Bb 3', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(62, 175, 'Trumpet in Bb 4', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(63, 181, 'Trombone 1', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(64, 182, 'Trombone 2', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(65, 183, 'Trombone 3', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(66, 184, 'Trombone 4', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1);

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
(3, 'librarian', '$2y$10$fCkrzNdYi2Krebl6aiRUFekfRGl3aJmMqqszdeuylceAo3YSynGJi', 'My Librarian', 'bandgeek@acwe.org', 'administrator'),
(6, 'acwe', '$2y$10$s7xTUGyzzpDxm/irFM0J8.lvwJPaj62HJxy6HgxzdPBdoINnAs2By', 'Austin Civic Wind Ensemble', 'acwe75@acwe.org', 'administrator user');

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
ALTER TABLE `compositions` ADD FULLTEXT KEY `name` (`name`,`description`,`composer`,`arranger`,`comments`);

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
  ADD PRIMARY KEY (`catalog_number`,`id_part_type`),
  ADD KEY `id_part_type` (`id_part_type`),
  ADD KEY `paper_size` (`paper_size`),
  ADD KEY `catalog_number` (`catalog_number`);

--
-- Indexes for table `part_collections`
--
ALTER TABLE `part_collections`
  ADD PRIMARY KEY (`is_part_collection`),
  ADD KEY `id_part_type` (`id_part_type`),
  ADD KEY `catalog_number_key` (`catalog_number_key`),
  ADD KEY `id_part_type_key` (`id_part_type_key`),
  ADD KEY `fk_parts` (`catalog_number_key`,`id_part_type_key`);

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
-- AUTO_INCREMENT for table `part_collections`
--
ALTER TABLE `part_collections`
  MODIFY `is_part_collection` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary identifier of a part collection', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `part_types`
--
ALTER TABLE `part_types`
  MODIFY `id_part_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this part type.', AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `recordings`
--
ALTER TABLE `recordings`
  MODIFY `id_recording` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this recording';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the user', AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `parts_ibfk_1` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`),
  ADD CONSTRAINT `parts_ibfk_2` FOREIGN KEY (`paper_size`) REFERENCES `paper_sizes` (`id_paper_size`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `parts_ibfk_3` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`);

--
-- Constraints for table `part_collections`
--
ALTER TABLE `part_collections`
  ADD CONSTRAINT `fk_parts` FOREIGN KEY (`catalog_number_key`,`id_part_type_key`) REFERENCES `parts` (`catalog_number`, `id_part_type`) ON UPDATE CASCADE,
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
