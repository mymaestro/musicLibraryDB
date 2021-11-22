-- phpMyAdmin SQL Dump
-- version 5.1.1-1.fc34
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2021 at 03:53 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.4.25

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
(1, 40, 'Piccolo', 'The piccolo is a half-size flute, and a member of the woodwind family of musical instruments.', 'Woodwind', 0, 1),
(2, 50, 'Flute', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(4, 80, 'Oboe', 'The oboe is a type of double reed woodwind instrument.', 'Woodwind', 0, 1),
(5, 90, 'English Horn', 'The English horn', 'Woodwind', 0, 1),
(6, 100, 'Bassoon', 'The bassoon is a woodwind instrument in the double reed family, which has a tenor and bass sound.', 'Woodwind', 0, 1),
(7, 110, 'Contrabassoon', 'The contrabassoon, also known as the double bassoon, is a larger version of the bassoon, sounding an octave lower.', 'Woodwind', 0, 0),
(8, 120, 'Clarinet in Eb', 'The E-flat (E♭) clarinet is a member of the clarinet family, smaller than the more common B♭ clarinet and pitched a perfect fourth higher.', 'Woodwind', 0, 1),
(9, 130, 'Clarinet in Bb', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(10, 180, 'Bass Clarinet', 'Bass clarinet is usually pitched in B♭ (meaning it is a transposing instrument on which a written C sounds as B♭), but it plays notes an octave below the soprano B♭ clarinet.', 'Woodwind', 0, 1),
(11, 200, 'Soprano Saxophone', 'The soprano saxophone is a higher-register variety of the saxophone.', 'Woodwind', 0, 1),
(12, 210, 'Alto Saxophone', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(13, 240, 'Tenor Saxophone', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(14, 270, 'Baritone Saxophone', 'The baritone saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(15, 280, 'Bass Saxophone', 'The bass saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(16, 290, 'Horn in F', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', 0, 1),
(17, 380, 'Trumpet in Bb', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(18, 440, 'Trombone', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(19, 490, 'Bass Trombone', 'A variation of the trombone family, considered the lower member of the trombone family.', 'Brass', 0, 1),
(20, 500, 'Baritone', 'The baritone horn, or sometimes just called baritone, is a valved, low-pitched brass instrument.', 'Brass', 0, 1),
(21, 510, 'Euphonium', 'Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.', 'Brass', 0, 1),
(22, 520, 'Tuba', 'The tuba is the lowest-pitched musical instrument in the brass family.', 'Brass', 0, 1),
(23, 570, 'Timpani', 'Timpani or kettledrums are musical instruments in the percussion family.', 'Percussion', 0, 1),
(24, 580, 'Cymbals', 'A cymbal is a common percussion instrument. Often used in pairs, cymbals consist of thin, normally round plates of various alloys.', 'Percussion', 0, 1),
(25, 590, 'Agogo bells', 'An agogô (Yoruba: agogo, meaning bell) is a single or a multiple bell', 'Percussion', 0, 1),
(26, 600, 'Triangle', 'The triangle is an idiophone type of musical instrument in the percussion family.', 'Percussion', 0, 1),
(27, 610, 'Tam-Tam', 'A gong of indefinite pitch.', 'Percussion', 0, 1),
(28, 620, 'Tambourine', 'The tambourine is a musical instrument in the percussion family consisting of a frame, often of wood or plastic, with pairs of small metal jingles, called \"zills\".', 'Percussion', 0, 1),
(29, 630, 'Snare drum', 'The snare drum or side drum is a percussion instrument that produces a sharp staccato sound when the head is struck with a drum stick.', 'Percussion', 0, 1),
(30, 640, 'Bass drum', 'The bass drum, or kick drum, is a large drum that produces a note of low definite or indefinite pitch.', 'Percussion', 0, 1),
(31, 670, 'Marimba', 'A percussion instrument consisting of a set of wooden bars struck with yarn or rubber mallets to produce musical tones.', 'Percussion', NULL, 1),
(32, 680, 'Vibraphone', 'A percussion instrument that has tuned metal bars.', 'Percussion', NULL, 1),
(33, 690, 'Xylophone', 'A percussion instrument consisting of a set of graduated, tuned wooden bars supported at nodal (nonvibrating) points and struck with sticks or padded mallets.', 'Percussion', NULL, 1),
(34, 700, 'Chimes', 'Also called tubular bells, chimes produce a sound that resembles church bells, or a carillon.', 'Percussion', NULL, 1),
(35, 710, 'Harp', 'The harp is a stringed musical instrument that has a number of individual strings running at an angle to its soundboard; the strings are plucked with the fingers.', 'Percussion', NULL, 1),
(36, 720, 'Piano', 'The piano is an acoustic, stringed musical instrument in which the strings are struck by wooden hammers and is played using a keyboard.', 'Percussion', NULL, 1),
(37, 740, 'String Bass', ' The double bass, also known simply as the bass, is the largest and lowest-pitched bowed (or plucked) string instrument.', 'Strings', NULL, 1),
(40, 10, 'Full score', 'The full conductor score contains all of the instrument parts', 'Other', 0, 1),
(41, 20, 'Condensed score', 'The condensed conductor score shows only the most relevant parts', 'Other', 0, 1),
(42, 60, 'Flute 1', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(43, 70, 'Flute 2', 'A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ', 'Woodwind', 0, 1),
(44, 150, 'Clarinet in Bb 1', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(45, 160, 'Clarinet in Bb 2', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(46, 170, 'Clarinet in Bb 3', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 1),
(47, 140, 'Solo Clarinet in Bb', 'The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.', 'Woodwind', 0, 0),
(48, 220, 'Alto Saxophone 1', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(49, 230, 'Alto Saxophone 2', 'The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(50, 250, 'Tenor Saxophone 1', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(51, 260, 'Tenor Saxophone 2', 'The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.', 'Woodwind', 0, 1),
(52, 300, 'Horn in F 1', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', 0, 1),
(53, 310, 'Horn in F 2', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', NULL, 1),
(54, 320, 'Horn in F 3', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', NULL, 1),
(55, 330, 'Horn in F 4', 'The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.', 'Brass', NULL, 1),
(56, 350, 'Cornet 1', 'The cornet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', NULL, 1),
(57, 360, 'Cornet 2', 'The cornet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', NULL, 1),
(58, 390, 'Solo Trumpet in Bb', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', NULL, 1),
(59, 400, 'Trumpet in Bb 1', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(60, 410, 'Trumpet in Bb 2', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(61, 420, 'Trumpet in Bb 3', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(62, 430, 'Trumpet in Bb 4', 'The trumpet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', 0, 1),
(63, 450, 'Trombone 1', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(64, 460, 'Trombone 2', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(65, 470, 'Trombone 3', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(66, 480, 'Trombone 4', 'Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.', 'Brass', 0, 1),
(67, 530, 'Percussion 1', 'Is a part collection, but to what?', 'Percussion', 2, 1),
(68, 540, 'Percussion 2', '', 'Percussion', 2, 1),
(69, 550, 'Percussion 3', '', 'Percussion', 3, 1),
(70, 560, 'Percussion 4', '', 'Percussion', 2, 1),
(71, 660, 'Mallet percussion', 'Combinations of pitched percussion instruments', 'Percussion', 2, 1),
(72, 190, 'Contrabass Clarinet', 'Bb Contrabass Clarinet', 'Woodwind', NULL, 1),
(73, 30, 'C Instruments', 'Presumable for flutes and oboes', 'Woodwind', 2, 1),
(74, 370, 'Cornet 3', 'The cornet is a brass instrument commonly used in classical and jazz ensembles.', 'Brass', NULL, 1),
(75, 340, 'Alto Horn in Eb', 'Eb horn, Alto horn, \"peck horn\"', 'Brass', NULL, 1),
(76, 375, 'Eb Cornet', 'A cornet keyed in Eb', 'Brass', NULL, 1),
(77, 750, 'Electric Bass', 'The electric bass is used in rock and jazz bands, and sometimes in concert band and wind ensemble arrangements.', 'Strings', NULL, 1),
(78, 730, 'Electric Guitar', 'The electric guitar is sometimes used in rock and jazz arrangements.', 'Strings', NULL, 1),
(79, 650, 'Drum set', 'The drum set is sometimes used in rock and jazz arrangements', 'Percussion', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `part_types`
--
ALTER TABLE `part_types`
  ADD PRIMARY KEY (`id_part_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `part_types`
--
ALTER TABLE `part_types`
  MODIFY `id_part_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this part type.', AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
