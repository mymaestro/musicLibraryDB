--
-- Current Database: `musicLibraryDB`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `musicLibraryDB` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `musicLibraryDB`;

--
-- Table structure for table `compositions`
--

DROP TABLE IF EXISTS `compositions`;

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
  `grade` decimal(2,1) unsigned DEFAULT NULL COMMENT 'Grade of difficulty',
  `last_performance_date` date DEFAULT NULL COMMENT 'When the composition was last performed',
  `duration` bigint(20) DEFAULT NULL COMMENT 'Performance duration in seconds',
  `duration_end` datetime DEFAULT NULL COMMENT 'The time the piece ends - to calculate duration',
  `comments` varchar(4096) DEFAULT NULL COMMENT 'Comments about the piece, liner notes',
  `performance_notes` varchar(4096) DEFAULT NULL COMMENT 'Performance notes (how to rehearse it, for example)',
  `storage_location` varchar(255) DEFAULT NULL COMMENT 'Where it is kept (which drawer)',
  `provenance` varchar(255) DEFAULT NULL COMMENT 'How the piece was acquired (P)urchased (R)ented (B)orrowed (D)onated',
  `date_acquired` date DEFAULT NULL COMMENT 'When the piece was acquired',
  `cost` decimal(8,2) DEFAULT NULL COMMENT 'How much did it cost, in dollars and cents',
  `listening_example_link` varchar(255) DEFAULT NULL COMMENT 'A link to a listening example, maybe on YouTube',
  `checked_out` varchar(255) DEFAULT NULL COMMENT 'To whom was this piece lended',
  `paper_size` varchar(4) NOT NULL DEFAULT 'L' COMMENT 'Physical size, from the paper_sizes table',
  `image_path` varchar(2048) DEFAULT NULL COMMENT 'Where a picture (image) of the score resides',
  `windrep_link` text DEFAULT NULL COMMENT 'Where can you this arrangement on the Wind Repertory site windrep.org?',
  `last_inventory_date` date DEFAULT NULL COMMENT 'When was the last time somebody touched this music',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When this record in the database was last updated.',
  `enabled` int(11) unsigned NOT NULL DEFAULT 1 COMMENT 'Set greater than 0 if this composition can be played',
  PRIMARY KEY (`catalog_number`),
  KEY `genre` (`genre`),
  KEY `ensemble` (`ensemble`),
  KEY `paper_size` (`paper_size`),
  FULLTEXT KEY `name` (`name`,`description`,`composer`,`arranger`,`comments`),
  CONSTRAINT `compositions_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `genres` (`id_genre`),
  CONSTRAINT `compositions_ibfk_2` FOREIGN KEY (`ensemble`) REFERENCES `ensembles` (`id_ensemble`),
  CONSTRAINT `compositions_ibfk_3` FOREIGN KEY (`paper_size`) REFERENCES `paper_sizes` (`id_paper_size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps compositions.';

--
-- Table structure for table `concerts`
--

DROP TABLE IF EXISTS `concerts`;
CREATE TABLE `concerts` (
  `id_concert` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremented unique number for concert ID',
  `id_playgram` int(11) NOT NULL COMMENT 'Which playgram will be performed',
  `performance_date` date NOT NULL COMMENT 'Date of the concert performance',
  `venue` varchar(255) NOT NULL COMMENT 'Where the concert is held.',
  `conductor` varchar(255) NOT NULL COMMENT 'Optional name of the conductor.',
  `notes` text NOT NULL COMMENT 'Optional performance-specific notes.',
  PRIMARY KEY (`id_concert`),
  UNIQUE KEY `id_playgram` (`id_playgram`,`performance_date`,`venue`),
  CONSTRAINT `concerts_ibfk_1` FOREIGN KEY (`id_playgram`) REFERENCES `playgrams` (`id_playgram`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps concerts performance data.';

--
-- Table structure for table `ensembles`
--

DROP TABLE IF EXISTS `ensembles`;
CREATE TABLE `ensembles` (
  `id_ensemble` varchar(4) NOT NULL COMMENT 'The unique ID of this ensemble (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'The name of the ensemble',
  `description` varchar(512) DEFAULT NULL COMMENT 'A description of the ensemble',
  `link` varchar(512) DEFAULT NULL COMMENT 'Hypertext link to more about this ensemble',
  `enabled` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the ensemble to be used',
  PRIMARY KEY (`id_ensemble`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps ensembles (performing groups).';


--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id_genre` varchar(4) NOT NULL COMMENT 'The unique ID of this genre (1-4 letters)',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the genre, for example March',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular genre',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the genre to be used',
  PRIMARY KEY (`id_genre`),
  UNIQUE KEY `id_genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps genres (March, Jazz, Transcription, etc.).';

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
CREATE TABLE `instruments` (
  `id_instrument` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The ID of this instrument.',
  `collation` int(10) unsigned NOT NULL COMMENT 'Orchestra score order',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The name of the instrument, for example Trumpet',
  `description` varchar(2048) DEFAULT NULL COMMENT 'Longer description of the instrument',
  `family` varchar(128) NOT NULL COMMENT 'Woodwind, brass, percussion, strings, etc.',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set to 1 to enable this instrument',
  PRIMARY KEY (`id_instrument`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds names of instruments to use in parts.';

--
-- Table structure for table `paper_sizes`
--

DROP TABLE IF EXISTS `paper_sizes`;
CREATE TABLE `paper_sizes` (
  `id_paper_size` varchar(4) NOT NULL COMMENT 'Paper size ID (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'Size, for example Legal, Letter, Folio',
  `description` varchar(255) DEFAULT NULL COMMENT 'Use to list other examples',
  `vertical` decimal(7,2) unsigned DEFAULT NULL COMMENT 'Vertical size in inches',
  `horizontal` decimal(7,2) unsigned DEFAULT NULL COMMENT 'Horizontal size in inches',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if this size is used',
  PRIMARY KEY (`id_paper_size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps paper sizes.';

--
-- Table structure for table `part_collections`
--

DROP TABLE IF EXISTS `part_collections`;


CREATE TABLE `part_collections` (
  `catalog_number_key` varchar(255) NOT NULL COMMENT 'Catalog number of the part ID',
  `id_part_type_key` int(10) unsigned NOT NULL COMMENT 'Part ID that this collection belongs to',
  `id_instrument_key` int(10) unsigned NOT NULL COMMENT 'Which instrument type is part of this collection',
  `name` varchar(255) DEFAULT NULL COMMENT 'The name of the type of part, for example Percussion 1',
  `description` varchar(255) DEFAULT NULL COMMENT 'Complete description of this part collection',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When this record in the database was last updated.',
  KEY `catalog_number_key` (`catalog_number_key`),
  KEY `id_part_type_key` (`id_part_type_key`),
  KEY `id_instrument_key` (`id_instrument_key`) USING BTREE,
  KEY `fk_parts` (`catalog_number_key`,`id_part_type_key`),
  CONSTRAINT `fk_instruments_parts` FOREIGN KEY (`id_instrument_key`) REFERENCES `instruments` (`id_instrument`),
  CONSTRAINT `fk_parts` FOREIGN KEY (`catalog_number_key`, `id_part_type_key`) REFERENCES `parts` (`catalog_number`, `id_part_type`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds part collections.';


--
-- Table structure for table `part_types`
--

DROP TABLE IF EXISTS `part_types`;


CREATE TABLE `part_types` (
  `id_part_type` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The ID of this part type.',
  `collation` int(10) unsigned NOT NULL COMMENT 'Orchestra score order',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The name of the type of part, for example Trumpet 1',
  `description` varchar(2048) DEFAULT NULL COMMENT 'Longer description of the type of part',
  `family` varchar(128) NOT NULL COMMENT 'Woodwind, brass, percussion, strings, etc.',
  `default_instrument` int(10) unsigned DEFAULT NULL COMMENT 'The default instrument for this part, from the instruments table',
  `is_part_collection` int(10) unsigned DEFAULT NULL COMMENT 'If this part is more than one instrument this is the ID of the collection',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set to 1 to enable this part type',
  PRIMARY KEY (`id_part_type`),
  KEY `fk_instruments` (`default_instrument`),
  CONSTRAINT `fk_instruments` FOREIGN KEY (`default_instrument`) REFERENCES `instruments` (`id_instrument`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds kinds/types of parts for parts and part collections.';


--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;


CREATE TABLE `parts` (
  `catalog_number` varchar(255) NOT NULL DEFAULT '' COMMENT 'Library catalog number of the composition to which this part belongs',
  `id_part_type` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Which type of part, from the part_types table',
  `name` varchar(255) DEFAULT '' COMMENT 'Name of the part, if different from the part type',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular part',
  `is_part_collection` int(11) DEFAULT NULL COMMENT 'This is a part collection of other parts',
  `paper_size` varchar(4) DEFAULT NULL COMMENT 'Physical size, from the paper_sizes table',
  `page_count` int(11) DEFAULT NULL COMMENT 'How many pages does this part contain?',
  `image_path` text DEFAULT NULL COMMENT 'Where an image of this part is stored.',
  `originals_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if originals of this part exist',
  `copies_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if copies of this part exist',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When this record in the database was last updated.',
  PRIMARY KEY (`catalog_number`,`id_part_type`),
  KEY `id_part_type` (`id_part_type`),
  KEY `paper_size` (`paper_size`),
  KEY `catalog_number` (`catalog_number`),
  CONSTRAINT `parts_ibfk_1` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`),
  CONSTRAINT `parts_ibfk_2` FOREIGN KEY (`paper_size`) REFERENCES `paper_sizes` (`id_paper_size`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `parts_ibfk_3` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds parts.';


--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;


CREATE TABLE `password_reset` (
  `password_reset_id` int(11) NOT NULL AUTO_INCREMENT,
  `password_reset_email` text NOT NULL,
  `password_reset_selector` text NOT NULL,
  `password_reset_token` longtext NOT NULL,
  `password_reset_expires` text NOT NULL,
  `username` varchar(128) DEFAULT NULL COMMENT 'Username for email verification requests',
  `name` varchar(255) DEFAULT NULL COMMENT 'Full name for email verification requests',
  `password_hash` varchar(128) DEFAULT NULL COMMENT 'Hashed password for email verification requests',
  `request_type` enum('password_reset','email_verification') DEFAULT 'password_reset' COMMENT 'Type of request: password reset or email verification',
  PRIMARY KEY (`password_reset_id`),
  KEY `idx_request_type` (`request_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


--
-- Table structure for table `playgram_items`
--

DROP TABLE IF EXISTS `playgram_items`;


CREATE TABLE `playgram_items` (
  `id_playgram_item` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique playgram item ID',
  `id_playgram` int(11) NOT NULL COMMENT 'Reference to the playgram parent',
  `catalog_number` varchar(20) NOT NULL COMMENT 'Which piece from the Compositions is on this playgram',
  `comp_order` int(11) NOT NULL COMMENT 'Order of this piece in the performance',
  PRIMARY KEY (`id_playgram_item`),
  UNIQUE KEY `id_playgram_item` (`id_playgram_item`,`comp_order`),
  KEY `fk_playgram_items_idfk_1` (`id_playgram`),
  KEY `fk_playgram_items_idfk_2` (`catalog_number`),
  CONSTRAINT `fk_playgram_items_idfk_1` FOREIGN KEY (`id_playgram`) REFERENCES `playgrams` (`id_playgram`) ON DELETE CASCADE,
  CONSTRAINT `fk_playgram_items_idfk_2` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1045 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps the list of playgram items.';


--
-- Table structure for table `playgrams`
--

DROP TABLE IF EXISTS `playgrams`;


CREATE TABLE `playgrams` (
  `id_playgram` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier, incremented number',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT 'Title of the playgram (concert program series); must be unique.',
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Complete description of the program, with concert performance notes.',
  `enabled` int(11) DEFAULT NULL COMMENT 'Set to 1 if enabled, otherwise 0',
  PRIMARY KEY (`id_playgram`),
  UNIQUE KEY `title` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table `recordings`
--

DROP TABLE IF EXISTS `recordings`;


CREATE TABLE `recordings` (
  `id_recording` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this recording',
  `catalog_number` varchar(5) NOT NULL COMMENT 'Catalog number of the composition',
  `id_concert` int(11) NOT NULL COMMENT 'Which concert this recording is from',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name of the piece or excerpt on the recording',
  `ensemble` varchar(2048) DEFAULT NULL COMMENT 'Ensemble or performer name',
  `id_ensemble` varchar(4) DEFAULT NULL COMMENT 'Ensemble or performer from the ensembles table',
  `link` varchar(512) DEFAULT NULL COMMENT 'URL or path to the audio or video recording',
  `notes` text NOT NULL COMMENT 'Notes about this recording for the concert',
  `composer` varchar(255) DEFAULT NULL COMMENT 'Composer for labeling purposes',
  `arranger` varchar(255) DEFAULT NULL COMMENT 'Arranger for labeling purposes',
  `enabled` int(11) NOT NULL DEFAULT 0 COMMENT 'Enable flag for display or availability',
  PRIMARY KEY (`id_recording`),
  KEY `catalog_number` (`catalog_number`),
  KEY `id_concert` (`id_concert`),
  KEY `audio_files_ibfk_3` (`id_ensemble`),
  CONSTRAINT `recordings_ibfk_1` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`),
  CONSTRAINT `recordings_ibfk_2` FOREIGN KEY (`id_concert`) REFERENCES `concerts` (`id_concert`),
  CONSTRAINT `recordings_ibfk_3` FOREIGN KEY (`id_ensemble`) REFERENCES `ensembles` (`id_ensemble`)
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps track of recordings.';


--
-- Table structure for table `recordings_old`
--

DROP TABLE IF EXISTS `recordings_old`;


CREATE TABLE `recordings_old` (
  `id_recording` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this recording',
  `catalog_number` varchar(5) NOT NULL DEFAULT 'C123' COMMENT 'The catalog number of the composition',
  `date` date DEFAULT NULL COMMENT 'Date when the recording was created',
  `name` varchar(255) DEFAULT NULL COMMENT 'The name of the music or sound on the recording',
  `ensemble` varchar(2048) DEFAULT NULL COMMENT 'Artist or ensemble performing the piece in the recording',
  `link` varchar(512) DEFAULT NULL COMMENT 'Link to the file',
  `concert` varchar(255) DEFAULT NULL COMMENT 'Link to the concert event',
  `venue` varchar(255) DEFAULT NULL COMMENT 'Link to the concert venue',
  `composer` varchar(255) DEFAULT NULL COMMENT 'The composer of the piece in the recording',
  `arranger` varchar(255) DEFAULT NULL COMMENT 'The arranger of the piece in the recording',
  `enabled` int(11) NOT NULL DEFAULT 0 COMMENT 'Enabled is a flag to help selection',
  PRIMARY KEY (`id_recording`),
  KEY `catalog_number` (`catalog_number`) USING BTREE,
  CONSTRAINT `recordings_old_ibfk_1` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`)
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps recordings.';


--
-- Table structure for table `section_part_types`
--

DROP TABLE IF EXISTS `section_part_types`;


CREATE TABLE `section_part_types` (
  `id_section` int(10) unsigned NOT NULL COMMENT 'Section ID',
  `id_part_type` int(10) unsigned NOT NULL COMMENT 'Part type ID',
  PRIMARY KEY (`id_section`,`id_part_type`),
  KEY `fk_part_type` (`id_part_type`),
  CONSTRAINT `fk_part_type` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`) ON DELETE CASCADE,
  CONSTRAINT `fk_section` FOREIGN KEY (`id_section`) REFERENCES `sections` (`id_section`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Links sections to part types (many-to-many)';


--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;


CREATE TABLE `sections` (
  `id_section` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the section',
  `name` varchar(255) NOT NULL COMMENT 'Section name, e.g. Brass, Woodwinds, Percussion',
  `description` varchar(1024) DEFAULT NULL COMMENT 'Description of the section',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT 1 COMMENT 'Set to 1 to enable this section',
  `section_leader` int(10) unsigned DEFAULT NULL COMMENT 'User ID of the section leader',
  PRIMARY KEY (`id_section`),
  KEY `fk_section_leader` (`section_leader`),
  CONSTRAINT `fk_section_leader` FOREIGN KEY (`section_leader`) REFERENCES `users` (`id_users`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Groups of part types (sections, e.g. Brass, Woodwinds)';


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users` (
  `id_users` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the user',
  `username` varchar(128) NOT NULL COMMENT 'The user name',
  `password` varchar(128) NOT NULL COMMENT 'User password',
  `name` varchar(255) DEFAULT NULL COMMENT 'Real name',
  `address` varchar(255) DEFAULT NULL COMMENT 'Users e-mail address',
  `roles` varchar(255) DEFAULT NULL COMMENT 'Text field containing roles',
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps users.';

