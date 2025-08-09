/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: musicLibraryDB
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `compositions`
--

DROP TABLE IF EXISTS `compositions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compositions`
--

LOCK TABLES `compositions` WRITE;
/*!40000 ALTER TABLE `compositions` DISABLE KEYS */;
INSERT INTO `compositions` VALUES ('C001','William Tell Overture','Famous overture by Rossini, arranged for concert band.','Gioachino Rossini','Various','','Public Domain','T','CB',5.0,'2023-12-15',720,NULL,'One of the most recognizable classical pieces, featuring the famous finale theme known as the Lone Ranger theme.','Very challenging piece requiring excellent technical skills from all sections. Take time with the famous gallop section.','Cabinet B, Shelf 2','P','2023-06-10',0.00,'https://www.youtube.com/watch?v=example3','','L','images/C001_score.jpg','https://www.windrep.org/William_Tell_Overture','2023-12-15','2025-08-09 15:32:05',1);
INSERT INTO `compositions` VALUES ('H001','A Christmas Festival','Medley of popular Christmas carols arranged by Leroy Anderson.','Traditional','Leroy Anderson',NULL,'Mills Music','H','CB',3.0,'2023-12-20',420,NULL,'Beautiful medley featuring Joy to the World, Deck the Halls, Good King Wenceslas, Hark! The Herald Angels Sing, The First Noel, Silent Night, and Jingle Bells.','Balance is crucial in this arrangement. Each carol should be clearly heard and well-articulated.','Cabinet D, Shelf 1','P','2023-10-12',65.00,'https://www.youtube.com/watch?v=example5','','L','images/H001_score.jpg','','2023-12-20','2024-07-20 10:50:00',1);
INSERT INTO `compositions` VALUES ('J001','In the Mood','Popular swing era hit arranged for concert band.','Joe Garland','Various',NULL,'Various Publishers','J','CB',3.5,'2024-03-20',180,NULL,'Glenn Miller\'s signature tune from the swing era, perfectly arranged for concert band.','Emphasize the swing feel and saxophone soli sections. Don\'t rush the tempo.','Cabinet C, Shelf 1','P','2023-09-05',45.00,'https://www.youtube.com/watch?v=example4','','L','images/J001_score.jpg','','2024-03-20','2024-07-20 10:45:00',1);
INSERT INTO `compositions` VALUES ('M001','El Capitan','Famous march by John Philip Sousa, composed in 1896. One of the most popular American marches.','John Philip Sousa',NULL,NULL,'Public Domain','M','CB',3.0,'2024-07-04',240,NULL,'El Capitan is a march composed by John Philip Sousa in 1896. The march takes its title from the comic opera of the same name. It is one of Sousa\'s most famous marches and has become a standard in the wind band repertoire.','Pay attention to the syncopated rhythms in the trio section. Keep the tempo steady and marcato throughout.','Cabinet A, Shelf 1','P','2024-01-15',0.00,'https://www.youtube.com/watch?v=example','','L','images/M001_score.jpg','https://www.windrep.org/El_Capitan','2024-07-04','2024-07-20 10:30:00',1);
INSERT INTO `compositions` VALUES ('M002','Stars and Stripes Forever','The official march of the United States, composed by John Philip Sousa in 1896.','John Philip Sousa',NULL,NULL,'Public Domain','M','CB',4.0,'2024-07-04',210,NULL,'Written in 1896, this is Sousa\'s most famous march and was designated as the official march of the United States in 1987.','Famous piccolo solo in the trio. Ensure piccolo is prominent and well-supported by the band.','Cabinet A, Shelf 1','P','2024-01-15',0.00,'https://www.youtube.com/watch?v=example2','','L','images/M002_score.jpg','https://www.windrep.org/Stars_and_Stripes_Forever','2024-07-04','2024-07-20 10:35:00',1);
/*!40000 ALTER TABLE `compositions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `concerts`
--

DROP TABLE IF EXISTS `concerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concerts`
--

LOCK TABLES `concerts` WRITE;
/*!40000 ALTER TABLE `concerts` DISABLE KEYS */;
INSERT INTO `concerts` VALUES (1,1,'2024-07-04','Community Center','John Smith','Independence Day celebration concert');
INSERT INTO `concerts` VALUES (2,3,'2023-12-20','First Methodist Church','Mary Johnson','Annual Christmas concert with special guests');
INSERT INTO `concerts` VALUES (3,2,'2024-03-15','High School Auditorium','John Smith','Spring classical concert');
INSERT INTO `concerts` VALUES (4,4,'2024-02-14','Jazz Club','Mike Davis','Valentine\'s Day jazz night');
INSERT INTO `concerts` VALUES (5,5,'2024-06-15','City Park Bandstand','John Smith','Summer march concert in the park');
/*!40000 ALTER TABLE `concerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ensembles`
--

DROP TABLE IF EXISTS `ensembles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ensembles` (
  `id_ensemble` varchar(4) NOT NULL COMMENT 'The unique ID of this ensemble (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'The name of the ensemble',
  `description` varchar(512) DEFAULT NULL COMMENT 'A description of the ensemble',
  `link` varchar(512) DEFAULT NULL COMMENT 'Hypertext link to more about this ensemble',
  `enabled` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the ensemble to be used',
  PRIMARY KEY (`id_ensemble`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps ensembles (performing groups).';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ensembles`
--

LOCK TABLES `ensembles` WRITE;
/*!40000 ALTER TABLE `ensembles` DISABLE KEYS */;
INSERT INTO `ensembles` VALUES ('BO','Brass Orchestra','Brass instruments only','',1);
INSERT INTO `ensembles` VALUES ('BQ','Brass Quintet','Traditional brass quintet','',1);
INSERT INTO `ensembles` VALUES ('CB','Concert Band','Full concert band with woodwinds, brass, and percussion','',1);
INSERT INTO `ensembles` VALUES ('MB','Marching Band','Marching band formation','',1);
INSERT INTO `ensembles` VALUES ('O','Orchestra','Full symphony orchestra with strings','',1);
INSERT INTO `ensembles` VALUES ('PQ','Percussion Quartet','Four percussion players','',1);
INSERT INTO `ensembles` VALUES ('S','String Orchestra','String instruments only','',1);
INSERT INTO `ensembles` VALUES ('WE','Wind Ensemble','Smaller wind ensemble with one player per part','',1);
INSERT INTO `ensembles` VALUES ('WO','Woodwind Orchestra','Woodwind instruments only','',1);
INSERT INTO `ensembles` VALUES ('WQ','Woodwind Quintet','Traditional woodwind quintet','',1);
/*!40000 ALTER TABLE `ensembles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `genres` (
  `id_genre` varchar(4) NOT NULL COMMENT 'The unique ID of this genre (1-4 letters)',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the genre, for example March',
  `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular genre',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set non-zero to enable the genre to be used',
  PRIMARY KEY (`id_genre`),
  UNIQUE KEY `id_genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps genres (March, Jazz, Transcription, etc.).';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES ('B','Original works for Band','Includes pieces that are not symphonic transcriptions or operatic settings. Includes Suites, Overtures, Chorales, and Fugues.',1);
INSERT INTO `genres` VALUES ('C','Ceremonial music','Materials specifically designed for functions. Includes fanfares, processionals, national anthems and patriotic medleys, hymns and chorales for memorials.',1);
INSERT INTO `genres` VALUES ('CM','Circus march','Fast tempo marches',1);
INSERT INTO `genres` VALUES ('H','Holiday','Holiday and seasonal music',1);
INSERT INTO `genres` VALUES ('J','Jazz and swing','Jazz arrangements and original jazz compositions',1);
INSERT INTO `genres` VALUES ('M','Military march','Traditional military and ceremonial marches',1);
INSERT INTO `genres` VALUES ('O','Other','Something that doesn\'t fit another genre',1);
INSERT INTO `genres` VALUES ('P','Pop and rock','Arrangements of popular music (Beatles, Queen, ABBA, Disney medleys)',1);
INSERT INTO `genres` VALUES ('R','Programmatic music','Descriptive music that depicts historical events, landscapes and nature, folk song arrangements, or story-based works.',1);
INSERT INTO `genres` VALUES ('S','Solo with band accompaniment','Piece for solo instrument with band accompaniment',1);
INSERT INTO `genres` VALUES ('T','Transcription',' 	Transcriptions of classic and contemporary symphonic works for band',1);
INSERT INTO `genres` VALUES ('U','Unknown','Use for compositions that have not been cataloged',1);
INSERT INTO `genres` VALUES ('W','Show tunes','Music from plays or Broadway shows',1);
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruments` (
  `id_instrument` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The ID of this instrument.',
  `collation` int(10) unsigned NOT NULL COMMENT 'Orchestra score order',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The name of the instrument, for example Trumpet',
  `description` varchar(2048) DEFAULT NULL COMMENT 'Longer description of the instrument',
  `family` varchar(128) NOT NULL COMMENT 'Woodwind, brass, percussion, strings, etc.',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set to 1 to enable this instrument',
  PRIMARY KEY (`id_instrument`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds names of instruments to use in parts.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,10,'Piccolo','Small flute pitched an octave higher','Woodwind',1);
INSERT INTO `instruments` VALUES (2,20,'Flute','Standard concert flute','Woodwind',1);
INSERT INTO `instruments` VALUES (3,30,'Oboe','Double reed woodwind instrument','Woodwind',1);
INSERT INTO `instruments` VALUES (4,35,'English Horn','Alto oboe','Woodwind',1);
INSERT INTO `instruments` VALUES (5,40,'Bassoon','Large double reed instrument','Woodwind',1);
INSERT INTO `instruments` VALUES (6,50,'Eb Clarinet','Small high-pitched clarinet','Woodwind',1);
INSERT INTO `instruments` VALUES (7,60,'Bb Clarinet','Standard clarinet','Woodwind',1);
INSERT INTO `instruments` VALUES (8,70,'Bass Clarinet','Large low clarinet','Woodwind',1);
INSERT INTO `instruments` VALUES (9,80,'Alto Saxophone','Alto saxophone in Eb','Woodwind',1);
INSERT INTO `instruments` VALUES (10,90,'Tenor Saxophone','Tenor saxophone in Bb','Woodwind',1);
INSERT INTO `instruments` VALUES (11,100,'Baritone Saxophone','Baritone saxophone in Eb','Woodwind',1);
INSERT INTO `instruments` VALUES (12,110,'Trumpet','Standard Bb trumpet','Brass',1);
INSERT INTO `instruments` VALUES (13,115,'Cornet','Bb cornet','Brass',1);
INSERT INTO `instruments` VALUES (14,120,'Flugelhorn','Bb flugelhorn','Brass',1);
INSERT INTO `instruments` VALUES (15,130,'French Horn','F/Bb French horn','Brass',1);
INSERT INTO `instruments` VALUES (16,140,'Trombone','Tenor trombone','Brass',1);
INSERT INTO `instruments` VALUES (17,150,'Bass Trombone','Large bass trombone','Brass',1);
INSERT INTO `instruments` VALUES (18,160,'Euphonium','Baritone horn/euphonium','Brass',1);
INSERT INTO `instruments` VALUES (19,170,'Tuba','Bass tuba','Brass',1);
INSERT INTO `instruments` VALUES (20,180,'Timpani','Kettle drums','Percussion',1);
INSERT INTO `instruments` VALUES (21,190,'Snare Drum','Side drum','Percussion',1);
INSERT INTO `instruments` VALUES (22,200,'Bass Drum','Large bass drum','Percussion',1);
INSERT INTO `instruments` VALUES (23,210,'Crash Cymbals','Orchestral crash cymbals','Percussion',1);
INSERT INTO `instruments` VALUES (24,220,'Suspended Cymbal','Single suspended cymbal','Percussion',1);
INSERT INTO `instruments` VALUES (25,230,'Triangle','Metal triangle','Percussion',1);
INSERT INTO `instruments` VALUES (26,240,'Tambourine','Frame drum with jingles','Percussion',1);
INSERT INTO `instruments` VALUES (27,250,'Glockenspiel','Orchestral bells','Percussion',1);
INSERT INTO `instruments` VALUES (28,260,'Xylophone','Wooden keyboard percussion','Percussion',1);
INSERT INTO `instruments` VALUES (29,270,'Vibraphone','Metal keyboard with motor','Percussion',1);
INSERT INTO `instruments` VALUES (30,280,'Marimba','Large wooden keyboard percussion','Percussion',1);
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paper_sizes`
--

DROP TABLE IF EXISTS `paper_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `paper_sizes` (
  `id_paper_size` varchar(4) NOT NULL COMMENT 'Paper size ID (one letter)',
  `name` varchar(255) NOT NULL COMMENT 'Size, for example Legal, Letter, Folio',
  `description` varchar(255) DEFAULT NULL COMMENT 'Use to list other examples',
  `vertical` decimal(7,2) unsigned DEFAULT NULL COMMENT 'Vertical size in inches',
  `horizontal` decimal(7,2) unsigned DEFAULT NULL COMMENT 'Horizontal size in inches',
  `enabled` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if this size is used',
  PRIMARY KEY (`id_paper_size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps paper sizes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paper_sizes`
--

LOCK TABLES `paper_sizes` WRITE;
/*!40000 ALTER TABLE `paper_sizes` DISABLE KEYS */;
INSERT INTO `paper_sizes` VALUES ('A','A4','International A4 size',11.69,8.27,1);
INSERT INTO `paper_sizes` VALUES ('B','Book','Standard book size',10.00,7.00,1);
INSERT INTO `paper_sizes` VALUES ('F','Folio','Large folio size',17.00,11.00,1);
INSERT INTO `paper_sizes` VALUES ('G','Legal','8.5 x 14 inches',14.00,8.50,1);
INSERT INTO `paper_sizes` VALUES ('L','Letter','8.5 x 11 inches',11.00,8.50,1);
INSERT INTO `paper_sizes` VALUES ('M','March','Small march card size',9.00,6.00,1);
INSERT INTO `paper_sizes` VALUES ('T','Tabloid','11 x 17 inches',17.00,11.00,1);
/*!40000 ALTER TABLE `paper_sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part_collections`
--

DROP TABLE IF EXISTS `part_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part_collections`
--

LOCK TABLES `part_collections` WRITE;
/*!40000 ALTER TABLE `part_collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `part_collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part_types`
--

DROP TABLE IF EXISTS `part_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part_types`
--

LOCK TABLES `part_types` WRITE;
/*!40000 ALTER TABLE `part_types` DISABLE KEYS */;
INSERT INTO `part_types` VALUES (1,10,'Piccolo','Solo piccolo part','Woodwind',1,NULL,1);
INSERT INTO `part_types` VALUES (2,20,'Flute 1','First flute part','Woodwind',2,NULL,1);
INSERT INTO `part_types` VALUES (3,25,'Flute 2','Second flute part','Woodwind',2,NULL,1);
INSERT INTO `part_types` VALUES (4,30,'Oboe 1','First oboe part','Woodwind',3,NULL,1);
INSERT INTO `part_types` VALUES (5,35,'Oboe 2','Second oboe part','Woodwind',3,NULL,1);
INSERT INTO `part_types` VALUES (6,40,'English Horn','English horn part','Woodwind',4,NULL,1);
INSERT INTO `part_types` VALUES (7,50,'Bassoon 1','First bassoon part','Woodwind',5,NULL,1);
INSERT INTO `part_types` VALUES (8,55,'Bassoon 2','Second bassoon part','Woodwind',5,NULL,1);
INSERT INTO `part_types` VALUES (9,60,'Eb Clarinet','Eb clarinet part','Woodwind',6,NULL,1);
INSERT INTO `part_types` VALUES (10,70,'Bb Clarinet 1','First Bb clarinet part','Woodwind',7,NULL,1);
INSERT INTO `part_types` VALUES (11,75,'Bb Clarinet 2','Second Bb clarinet part','Woodwind',7,NULL,1);
INSERT INTO `part_types` VALUES (12,80,'Bb Clarinet 3','Third Bb clarinet part','Woodwind',7,NULL,1);
INSERT INTO `part_types` VALUES (13,90,'Bass Clarinet','Bass clarinet part','Woodwind',8,NULL,1);
INSERT INTO `part_types` VALUES (14,100,'Alto Saxophone 1','First alto saxophone part','Woodwind',9,NULL,1);
INSERT INTO `part_types` VALUES (15,105,'Alto Saxophone 2','Second alto saxophone part','Woodwind',9,NULL,1);
INSERT INTO `part_types` VALUES (16,110,'Tenor Saxophone','Tenor saxophone part','Woodwind',10,NULL,1);
INSERT INTO `part_types` VALUES (17,120,'Baritone Saxophone','Baritone saxophone part','Woodwind',11,NULL,1);
INSERT INTO `part_types` VALUES (18,130,'Trumpet 1','First trumpet part','Brass',12,NULL,1);
INSERT INTO `part_types` VALUES (19,135,'Trumpet 2','Second trumpet part','Brass',12,NULL,1);
INSERT INTO `part_types` VALUES (20,140,'Trumpet 3','Third trumpet part','Brass',12,NULL,1);
INSERT INTO `part_types` VALUES (21,150,'French Horn 1','First French horn part','Brass',15,NULL,1);
INSERT INTO `part_types` VALUES (22,155,'French Horn 2','Second French horn part','Brass',15,NULL,1);
INSERT INTO `part_types` VALUES (23,160,'French Horn 3','Third French horn part','Brass',15,NULL,1);
INSERT INTO `part_types` VALUES (24,165,'French Horn 4','Fourth French horn part','Brass',15,NULL,1);
INSERT INTO `part_types` VALUES (25,170,'Trombone 1','First trombone part','Brass',16,NULL,1);
INSERT INTO `part_types` VALUES (26,175,'Trombone 2','Second trombone part','Brass',16,NULL,1);
INSERT INTO `part_types` VALUES (27,180,'Trombone 3','Third trombone part','Brass',16,NULL,1);
INSERT INTO `part_types` VALUES (28,185,'Bass Trombone','Bass trombone part','Brass',17,NULL,1);
INSERT INTO `part_types` VALUES (29,190,'Euphonium','Euphonium/baritone part','Brass',18,NULL,1);
INSERT INTO `part_types` VALUES (30,200,'Tuba','Tuba part','Brass',19,NULL,1);
INSERT INTO `part_types` VALUES (31,210,'Timpani','Timpani part','Percussion',20,NULL,1);
INSERT INTO `part_types` VALUES (32,220,'Percussion 1','First percussion part','Percussion',21,NULL,1);
INSERT INTO `part_types` VALUES (33,225,'Percussion 2','Second percussion part','Percussion',22,NULL,1);
INSERT INTO `part_types` VALUES (34,230,'Percussion 3','Third percussion part','Percussion',23,NULL,1);
INSERT INTO `part_types` VALUES (35,235,'Percussion 4','Fourth percussion part','Percussion',24,NULL,1);
/*!40000 ALTER TABLE `part_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts`
--

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` VALUES ('C001',2,'Flute 1','Technical passages',2,'L',3,NULL,2,3,'2024-07-20 10:40:00');
INSERT INTO `parts` VALUES ('C001',10,'Bb Clarinet 1',NULL,NULL,'L',3,'',3,5,'2024-07-20 10:40:00');
INSERT INTO `parts` VALUES ('C001',18,'Trumpet 1','Famous gallop section',2,'L',3,NULL,2,3,'2024-07-20 10:40:00');
INSERT INTO `parts` VALUES ('C001',25,'Trombone 1',NULL,NULL,'L',3,'',1,2,'2024-07-20 10:40:00');
INSERT INTO `parts` VALUES ('C001',31,'Timpani','Important role throughout',2,'L',3,NULL,1,1,'2024-07-20 10:40:00');
INSERT INTO `parts` VALUES ('H001',2,'Flute 1','Melodic lines in carols',2,'L',2,NULL,2,4,'2024-07-20 10:50:00');
INSERT INTO `parts` VALUES ('H001',10,'Bb Clarinet 1',NULL,NULL,'L',2,NULL,3,6,'2024-07-20 10:50:00');
INSERT INTO `parts` VALUES ('H001',18,'Trumpet 1','Fanfare sections',2,'L',2,NULL,2,4,'2024-07-20 10:50:00');
INSERT INTO `parts` VALUES ('H001',21,'French Horn 1','Important harmonic role',2,'L',2,NULL,1,2,'2024-07-20 10:50:00');
INSERT INTO `parts` VALUES ('H001',31,'Timpani',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:50:00');
INSERT INTO `parts` VALUES ('J001',1,'Piccolo','Featured in the opening section',2,'L',2,NULL,1,2,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',2,'Flute 1','Melodic lines in the intro',2,'L',2,NULL,2,3,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',10,'Bb Clarinet 1','Swing style',2,'L',2,NULL,3,5,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',14,'Alto Saxophone 1','Featured soli section',2,'L',2,NULL,1,2,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',18,'Trumpet 1','Swing style',2,'L',2,NULL,2,3,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',25,'Trombone 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('J001',32,'Percussion 1','Swing drums',2,'L',2,NULL,1,1,'2024-07-20 10:45:00');
INSERT INTO `parts` VALUES ('M001',1,'Piccolo',NULL,NULL,'L',2,NULL,1,3,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',2,'Flute 1',NULL,NULL,'L',2,NULL,2,4,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',3,'Flute 2',NULL,NULL,'L',2,NULL,1,3,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',4,'Oboe 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',5,'Oboe 2',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',9,'Eb Clarinet',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',10,'Bb Clarinet 1',NULL,NULL,'L',2,NULL,3,6,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',11,'Bb Clarinet 2',NULL,NULL,'L',2,NULL,2,8,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',12,'Bb Clarinet 3',NULL,NULL,'L',2,NULL,2,6,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',13,'Bass Clarinet',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',14,'Alto Saxophone 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',15,'Alto Saxophone 2',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',16,'Tenor Saxophone',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',17,'Baritone Saxophone',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',18,'Trumpet 1',NULL,NULL,'L',2,NULL,2,4,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',19,'Trumpet 2',NULL,NULL,'L',2,NULL,2,3,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',20,'Trumpet 3',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',21,'French Horn 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',22,'French Horn 2',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',25,'Trombone 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',26,'Trombone 2',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',27,'Trombone 3',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',29,'Euphonium',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',30,'Tuba',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',31,'Timpani',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',32,'Percussion 1','Snare Drum, Bass Drum',2,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M001',33,'Percussion 2','Cymbals, Triangle',2,'L',2,NULL,1,1,'2024-07-20 10:30:00');
INSERT INTO `parts` VALUES ('M002',1,'Piccolo','Famous solo in trio',2,'L',2,NULL,1,2,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',2,'Flute 1',NULL,NULL,'L',2,NULL,2,4,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',10,'Bb Clarinet 1',NULL,NULL,'L',2,NULL,3,6,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',18,'Trumpet 1',NULL,NULL,'L',2,NULL,2,4,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',25,'Trombone 1',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',30,'Tuba',NULL,NULL,'L',2,NULL,1,2,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',31,'Timpani',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:35:00');
INSERT INTO `parts` VALUES ('M002',32,'Percussion 1',NULL,NULL,'L',2,NULL,1,1,'2024-07-20 10:35:00');
/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playgram_items`
--

DROP TABLE IF EXISTS `playgram_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playgram_items`
--

LOCK TABLES `playgram_items` WRITE;
/*!40000 ALTER TABLE `playgram_items` DISABLE KEYS */;
INSERT INTO `playgram_items` VALUES (1,1,'M001',1);
INSERT INTO `playgram_items` VALUES (2,1,'M002',2);
INSERT INTO `playgram_items` VALUES (3,2,'C001',1);
INSERT INTO `playgram_items` VALUES (4,3,'H001',1);
INSERT INTO `playgram_items` VALUES (5,4,'J001',1);
INSERT INTO `playgram_items` VALUES (6,5,'M001',1);
INSERT INTO `playgram_items` VALUES (7,5,'M002',2);
/*!40000 ALTER TABLE `playgram_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playgrams`
--

DROP TABLE IF EXISTS `playgrams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `playgrams` (
  `id_playgram` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier, incremented number',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT 'Title of the playgram (concert program series); must be unique.',
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Complete description of the program, with concert performance notes.',
  `enabled` int(11) DEFAULT NULL COMMENT 'Set to 1 if enabled, otherwise 0',
  PRIMARY KEY (`id_playgram`),
  UNIQUE KEY `title` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playgrams`
--

LOCK TABLES `playgrams` WRITE;
/*!40000 ALTER TABLE `playgrams` DISABLE KEYS */;
INSERT INTO `playgrams` VALUES (1,'Patriotic Concert','A patriotic concert featuring American marches and favorites',1);
INSERT INTO `playgrams` VALUES (2,'Classical Showcase','An evening of classical masterworks arranged for band',1);
INSERT INTO `playgrams` VALUES (3,'Holiday Concert','Annual Christmas concert featuring seasonal favorites',1);
INSERT INTO `playgrams` VALUES (4,'Jazz Night','An evening of jazz and popular music',1);
INSERT INTO `playgrams` VALUES (5,'March Madness','Concert featuring the best American marches',1);
/*!40000 ALTER TABLE `playgrams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordings`
--

DROP TABLE IF EXISTS `recordings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordings`
--

LOCK TABLES `recordings` WRITE;
/*!40000 ALTER TABLE `recordings` DISABLE KEYS */;
INSERT INTO `recordings` VALUES (1,'M001',1,'El Capitan - Live Recording','Community Concert Band','CB','recordings/M001_20240704.mp3','Excellent performance with crisp articulation and good balance','John Philip Sousa','',1);
INSERT INTO `recordings` VALUES (2,'M002',1,'Stars and Stripes Forever - Live','Community Concert Band','CB','recordings/M002_20240704.mp3','Outstanding piccolo solo by Sarah Williams','John Philip Sousa','',1);
INSERT INTO `recordings` VALUES (3,'H001',2,'A Christmas Festival - Live','Community Concert Band','CB','recordings/H001_20231220.mp3','Beautiful holiday concert with full choir accompaniment','Traditional','Leroy Anderson',1);
INSERT INTO `recordings` VALUES (4,'C001',3,'William Tell Overture - Live','Community Concert Band','CB','recordings/C001_20240315.mp3','Challenging piece performed with great skill','Gioachino Rossini','Various',1);
INSERT INTO `recordings` VALUES (5,'J001',4,'In the Mood - Live','Community Concert Band','CB','recordings/J001_20240214.mp3','Swinging performance with great saxophone section','Joe Garland','Various',1);
/*!40000 ALTER TABLE `recordings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordings_old`
--

DROP TABLE IF EXISTS `recordings_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordings_old`
--

LOCK TABLES `recordings_old` WRITE;
/*!40000 ALTER TABLE `recordings_old` DISABLE KEYS */;
INSERT INTO `recordings_old` VALUES (1,'C036','1982-05-09','Victory at Sea','Austin Civic Wind Ensemble','01VictoryatSea.mp3','Hitachi EX-c90 cassette tape from Janet Rice\r\nVictory at Sea    RR Bennett\r\nSinfonia Nobilissima Jager\r\nFiddler on the Roof\r\nRaiders of the Lost Ark\r\nSuperman','Shopping mall in Austin, Texas',NULL,NULL,1);
INSERT INTO `recordings_old` VALUES (2,'C043','1982-05-09','Sinfonia Noblissima','Austin Civic Wind Ensemble','02Jager-SinfoniaNobilissima.mp3','Hitachi EX-c90 cassette tape from Janet Rice Victory at Sea? ? RR Bennett Sinfonia Nobilissima Jager Fiddler on the Roof Raiders of the Lost Ark Superman','Shopping mall in Austin, Texas',NULL,NULL,1);
INSERT INTO `recordings_old` VALUES (3,'C155','1982-05-09','Could be C155 C082 or C254 (all are \"Fiddler on the Roof\")','Austin Civic Wind Ensemble','03FidlerontheRoof.mp3','Hitachi EX-c90 cassette tape from Janet Rice Victory at Sea? ? RR Bennett Sinfonia Nobilissima Jager Fiddler on the Roof Raiders of the Lost Ark Superman','Shopping mall in Austin, Texas',NULL,NULL,1);
INSERT INTO `recordings_old` VALUES (4,'C218','1982-05-09','Raiders of the Lost Ark Medley','Austin Civic Wind Ensemble','04RaidersoftheLostArk.mp3','Hitachi EX-c90 cassette tape from Janet Rice Victory at Sea? ? RR Bennett Sinfonia Nobilissima Jager Fiddler on the Roof Raiders of the Lost Ark Superman','Shopping mall in Austin, Texas',NULL,NULL,1);
INSERT INTO `recordings_old` VALUES (5,'C181','1982-05-09','Superman Suite for Concert Band','Austin Civic Wind Ensemble','05Superman.mp3','Hitachi EX-c90 cassette tape from Janet Rice Victory at Sea? ? RR Bennett Sinfonia Nobilissima Jager Fiddler on the Roof Raiders of the Lost Ark Superman','Shopping mall in Austin, Texas',NULL,NULL,1);
INSERT INTO `recordings_old` VALUES (6,'E000','1982-07-02','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (7,'E000','1982-07-02','American Overture by Joseph Wilcox Jenkins','Austin Civic Wind Ensemble','02AmericanOverture.mp3 ','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (8,'E000','1982-07-02','Music Man Highlights','Austin Civic Wind Ensemble','03MusicManHighlights.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (9,'E000','1982-07-02','Klaxon March','Austin Civic Wind Ensemble','04Klaxon.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (10,'E001','1982-07-02','Brass Quintet?','Brass Quintet','05BrassQuintet.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (11,'E000','1982-07-02','Cohen Star Spangled Spectacular','Austin Civic Wind Ensemble','06StarSpangledSpectacular.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (12,'E000','1982-07-02','On the Mall by Goldman','Austin Civic Wind Ensemble','07OntheMall.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (13,'M040','1982-07-02','1776 Selections','Austin Civic Wind Ensemble','08-1776.mp3','','Unknown location','Edwards','',0);
INSERT INTO `recordings_old` VALUES (14,'C227','1982-07-02','American Salute Gould','Austin Civic Wind Ensemble','09AmericanSalute.mp3','','Unknown location','','Gould, Morton',1);
INSERT INTO `recordings_old` VALUES (15,'E000','1982-07-02','America the Beautiful','Austin Civic Wind Ensemble','10AmericantheBeautiful.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (16,'E000','1982-07-02','Stars and Stripes Forever','Austin Civic Wind Ensemble','11StarsandStripes.mp3','','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (17,'E000','1983-08-10','Shield of Freedom','Austin Civic Wind Ensemble','01ShieldofFreedom.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (18,'E000','1983-08-10','First Suite in Eb Holst','Austin Civic Wind Ensemble','02Holst1stSuiteEb.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (19,'E000','1983-08-10','Instant Concert','Austin Civic Wind Ensemble','03InstantConcert.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (20,'E000','1983-08-10','Corcoran Cadets','Austin Civic Wind Ensemble','04CorcoranCadets.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (21,'E000','1983-08-10','Raiders of the Lost Ark','Austin Civic Wind Ensemble','05RaidersoftheLostArk.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (22,'E000','1983-08-10','The Sinfonians','Austin Civic Wind Ensemble','06Sinfonians.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (23,'E000','1983-08-10','Superman','Austin Civic Wind Ensemble','07Superman.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (24,'E000','1983-08-10','Shepherd\'s Hey','Austin Civic Wind Ensemble','08ShepherdsHey.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (25,'E000','1983-08-10','American Civil War Fantasy','Austin Civic Wind Ensemble','09AmericanCivilWarFantasy.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (26,'E000','1983-08-10','Pas Redouble','Austin Civic Wind Ensemble','10PasRedouble.mp3','Bill Whitworth conductor','Austin Aqua Fest','','',0);
INSERT INTO `recordings_old` VALUES (27,'E000','1987-07-14','Shoutin\' Liza','Austin Civic Wind Ensemble','01ShoutinLiza.mp3','','Symphony Square','Fillmore','',0);
INSERT INTO `recordings_old` VALUES (28,'E000','1987-07-14','Music Man Highlights','Austin Civic Wind Ensemble','02MusicMan.mp3','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (29,'E000','1987-07-14','Ode for Trumpet','Austin Civic Wind Ensemble','03OdeforTrumpet.mp3','Bob Zirpoli trumpet','Symphony Square','Alfred Red','',0);
INSERT INTO `recordings_old` VALUES (30,'E000','1987-07-14','Suite of Old American Dances','Austin Civic Wind Ensemble','04OldAmericanDances.mp3','Cakewalk, Schottische, Western One Step ','Symphony Square','RR Bennett','',0);
INSERT INTO `recordings_old` VALUES (31,'E000','1987-07-14','Cole Porter Spectacular','Austin Civic Wind Ensemble','05ColePorter.mp3','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (32,'E000','1987-07-14','Chester','Austin Civic Wind Ensemble','06Chester.mp3','with guest conductor?    Shlecta says he goes around front to listen','Symphony Square','Schuman','',0);
INSERT INTO `recordings_old` VALUES (33,'E000','1987-07-14','Muppets Greatest Hits','Austin Civic Wind Ensemble','07Muppets.mp3','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (34,'E000','1987-07-14','Rondo from Mozart Horn Concerto No. 3      ','Austin Civic Wind Ensemble','08MozartHornCto.mp3','Not sure on soloist. Jonathan? Maybe?','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (35,'E000','1987-07-14','Broadway Spectacular','Austin Civic Wind Ensemble','09BroadwaySpectacular.mp3','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (36,'E000','1987-07-14','Washington Post March','Austin Civic Wind Ensemble','10WashingtonPost.mp3','','Symphony Square','Sousa','',0);
INSERT INTO `recordings_old` VALUES (37,'E000','1988-07-01','Washington Post','Austin Civic Wind Ensemble','01WashingtonPost.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (38,'E000','1988-07-01','English Folk Song Suite','Austin Civic Wind Ensemble','02EnglishFolkSongSuite.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (39,'E000','1988-07-01','Opus 99','Austin Civic Wind Ensemble','03Opus99.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (40,'E000','1988-07-01','La Gaza','Austin Civic Wind Ensemble','04LaGaza.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (41,'E000','1988-07-01','Engulfed Cathedral','Austin Civic Wind Ensemble','05EngulfedCathedral.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (42,'E000','1988-07-01','March from Symphonic Metamorphosis','Austin Civic Wind Ensemble','06March-SymphMetamorphosis.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (43,'E000','1988-07-01','Moorside March','Austin Civic Wind Ensemble','07MoorsideMarch.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (44,'E000','1988-07-01','Heard it Through the Grapevine','Austin Civic Wind Ensemble','08HearditThroughtheGrapevine.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (45,'E000','1988-07-01','The Sinfonians','Austin Civic Wind Ensemble','09Sinfonians.aif','','Symphony Square','','',0);
INSERT INTO `recordings_old` VALUES (46,'E000','1992-11-10','Neddermeyer Triumphal March','Austin Civic Wind Ensemble','01NeddermeyerTriumphalMarch.mp3','Stan Beard, conductor','Texas School for the Blind','K. L. King','',0);
INSERT INTO `recordings_old` VALUES (47,'E000','1992-11-10','Salvation is Created','Austin Civic Wind Ensemble','02SalvationisCreated.mp3','Stan Beard, conductor','Texas School for the Blind','Pavel Chesnokov','',0);
INSERT INTO `recordings_old` VALUES (48,'E000','1992-11-10','Valdres','Austin Civic Wind Ensemble','03Valdres.mp3','Stan Beard, conductor','Texas School for the Blind','Johannes Hanssen','',0);
INSERT INTO `recordings_old` VALUES (49,'E000','1992-11-10','Theme from Lawrence of Arabia','Austin Civic Wind Ensemble','04LawrenceofArabia.mp3','Bob Zirpoli, guest conductor','Texas School for the Blind','Maurice Jarre','',0);
INSERT INTO `recordings_old` VALUES (50,'E000','1992-11-10','March Opus 99','Austin Civic Wind Ensemble','05MarchOpus99.mp3','Diane Gray, guest conductor','Texas School for the Blind','Sergei Prokofieff','',0);
INSERT INTO `recordings_old` VALUES (51,'E000','1992-11-10','Marche Slave','Austin Civic Wind Ensemble','06MarcheSlave.mp3','Stan Beard, conductor','Texas School for the Blind','P. Tschaikovsky','',0);
INSERT INTO `recordings_old` VALUES (52,'E000','1992-11-10','Gallito','Austin Civic Wind Ensemble','07Gallito.mp3','Stan Beard, conductor','Texas School for the Blind','Santiago Lope','',0);
INSERT INTO `recordings_old` VALUES (53,'E000','1992-11-10','Vom Egerland zum Moldaustrand','Austin Civic Wind Ensemble','08VomEgerlandzumMoldaustrand.mp3','Stan Beard, conductor','Texas School for the Blind','Siegfried Rundel','',0);
INSERT INTO `recordings_old` VALUES (54,'E000','1992-11-10','Marche Hongroise','Austin Civic Wind Ensemble','09MarchHongroise.mp3','Stan Beard, conductor','Texas School for the Blind','Hector Berlioz','',0);
INSERT INTO `recordings_old` VALUES (55,'E000','1992-11-10','America the Beautiful','Austin Civic Wind Ensemble','10AmericatheBeautiful.mp3','Stan Beard, conductor','Texas School for the Blind','Samuel Augustus Ward','',0);
INSERT INTO `recordings_old` VALUES (56,'E000','1998-03-10','Nobles of the Mystic Shrine','Austin Civic Wind Ensemble','01NoblesoftheMysticShrine.mp3','Rick Glascock, conductor','Unknown location','Sousa','',0);
INSERT INTO `recordings_old` VALUES (57,'E000','1998-03-10','Eternal Father, Strong to Save','Austin Civic Wind Ensemble','02EternalFather.mp3','Rick Glascock, conductor','Unknown location','Claude T Smith','',0);
INSERT INTO `recordings_old` VALUES (58,'E000','1998-03-10','Mulange','Austin Civic Wind Ensemble','03Mulange.mp3','Rick Glascock, conductor','Unknown location','Rick Glascock','',0);
INSERT INTO `recordings_old` VALUES (59,'E000','1998-03-10','William Byrd Suite (Nos. 1&2)','Austin Civic Wind Ensemble','04WilliamByrdSuite1&2.mp3','Rick Glascock, conductor','Unknown location','Gordon Jacob','',0);
INSERT INTO `recordings_old` VALUES (60,'E000','1998-03-10','Incantation and Dance','Austin Civic Wind Ensemble','05Incantation+Dance.mp3','Rick Glascock, conductor','Unknown location','John Barnes Chance','',0);
INSERT INTO `recordings_old` VALUES (61,'E000','1998-03-10','Clear Track','Austin Civic Wind Ensemble','06ClearTrack.mp3','Rick Glascock, conductor','Unknown location','Eduard Strauss','',0);
INSERT INTO `recordings_old` VALUES (62,'E000','1998-10-27','Von Grrrhart\'s 613th Regimental March','Austin Civic Wind Ensemble','01VonGrrrharts613Regimental.mp3','Rick Glascock, conductor','Texas School for the Blind','Holsinger','',0);
INSERT INTO `recordings_old` VALUES (63,'E000','1998-10-27','Independence Day (the movie?)','Austin Civic Wind Ensemble','02IndependenceDay.mp3','Rick Glascock, conductor','Texas School for the Blind','Arnold','Clark',0);
INSERT INTO `recordings_old` VALUES (64,'E000','1998-10-27','Die Nacht','Austin Civic Wind Ensemble','03DieNacht.mp3','Rick Glascock, conductor','Texas School for the Blind','Richard Strauss','Davis',0);
INSERT INTO `recordings_old` VALUES (65,'C198','1998-10-27','Four Scottish Dances','Austin Civic Wind Ensemble','04FourScottishDances.mp3','Rick Glascock, conductor','Texas School for the Blind','Arnold, Malcolm','Paynter, John P',1);
INSERT INTO `recordings_old` VALUES (66,'E000','1998-10-27','Tres Pasitos','Austin Civic Wind Ensemble','05TresPastitos.mp3','Rick Glascock, conductor','Texas School for the Blind','Rick Glascock','',0);
INSERT INTO `recordings_old` VALUES (67,'C325','1998-10-27','Cousins','Austin Civic Wind Ensemble','06Cousins.mp3','Michael Williamson, trumpet, Ted Rachofsky, trombone','Texas School for the Blind','Clarke, Herbert L.','Cramer, Ray E',1);
INSERT INTO `recordings_old` VALUES (68,'C139','1998-10-27','Toccata Marziale','Austin Civic Wind Ensemble','07ToccataMarziale.mp3','Rick Glascock, conductor','Texas School for the Blind','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (69,'M035','1998-10-27','Florentiner March','Austin Civic Wind Ensemble','08Florentiner.mp3','Rick Glascock, conductor','Texas School for the Blind','Fucik','',1);
INSERT INTO `recordings_old` VALUES (70,'E000','1999-11-02','Flight of the Eagles','Austin Civic Wind Ensemble','01FlightoftheEagles.mp3','Rick Glascock, conductor','Covington Middle School','Elliot De Borgo','',0);
INSERT INTO `recordings_old` VALUES (71,'E000','1999-11-02','Rondo from Prelude, Sciliano and Rondo','Austin Civic Wind Ensemble','02Rondo-Arnold.mp3','Rick Glascock, conductor','Covington Middle School','Malcom Arnold','Paynter',0);
INSERT INTO `recordings_old` VALUES (72,'E000','1999-11-02','Salvation is Created','Austin Civic Wind Ensemble','03SalvationisCreated.mp3','Rick Glascock, conductor','Covington Middle School','Frank Erickson','',0);
INSERT INTO `recordings_old` VALUES (73,'E001','1999-11-02','William Tell Overture','Frontier Brass Quintet','04WilliamTell.mp3','Frontier Brass Quintet','Covington Middle School','Rossini','Matern',0);
INSERT INTO `recordings_old` VALUES (74,'E001','1999-11-02','Frere Jaques','Frontier Brass Quintet','05FrereJaques.mp3','Frontier Brass Quintet','Covington Middle School','','Iveson',0);
INSERT INTO `recordings_old` VALUES (75,'E000','1999-11-02','Sunbird','Austin Civic Wind Ensemble','06Sunbird.mp3','Rick Glascock, conductor','Covington Middle School','Claude T. Smith','',0);
INSERT INTO `recordings_old` VALUES (76,'E000','1999-11-02','Erica\'s Theme','Austin Civic Wind Ensemble','07EricasTheme.mp3','Rick Glascock, conductor','Covington Middle School','Dan Parsons','',0);
INSERT INTO `recordings_old` VALUES (77,'E000','1999-11-02','Armenian Dances Part 1','Austin Civic Wind Ensemble','08ArmenianDances1.mp3','Rick Glascock, conductor','Covington Middle School','Alfred Reed','',0);
INSERT INTO `recordings_old` VALUES (78,'E000','1999-11-02','Barnum and Bailey\'s Favorite','Austin Civic Wind Ensemble','09BarnumandBaileysFavorite.mp3','Rick Glascock, conductor','Covington Middle School','Karl King','',0);
INSERT INTO `recordings_old` VALUES (79,'E000','2000-04-04','Overture to Candide','Austin Civic Wind Ensemble','01CandideOverture.mp3','Rick Glascock, conductor','Covington Middle School','Bernstein','Beeler',0);
INSERT INTO `recordings_old` VALUES (80,'E000','2000-04-04','Prelude Op. 34, no 14','Austin Civic Wind Ensemble','02PreludeOp34Shost.mp3','Rick Glascock, conductor','Covington Middle School','Shostakovich','H Robert Reynolds',0);
INSERT INTO `recordings_old` VALUES (81,'E001','2000-04-04','Swipesy Cake Walk Rag','Brass Ensemble','03Swipesy Cake Walk Rag.mp3','Brass ensemble','Covington Middle School','','',0);
INSERT INTO `recordings_old` VALUES (82,'E001','2000-04-04','Nocturne','Brass Ensemble','04NocturneMendelssohn.mp3','Brass ensemble','Covington Middle School','Mendelssohn','',0);
INSERT INTO `recordings_old` VALUES (83,'E001','2000-04-04','Washington Post March','Brass Ensemble','05WashingtonPost.mp3','Brass ensemble','Covington Middle School','Sousa','',0);
INSERT INTO `recordings_old` VALUES (84,'E000','2000-04-04','Cantebury Chorale','Austin Civic Wind Ensemble','06CanteburyChorale.mp3','Rick Glascock, conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (85,'E000','2000-04-04','Blue Shades','Austin Civic Wind Ensemble','07BlueShades.mp3','Rick Glascock, conductor','Covington Middle School','Frank Ticheli','',0);
INSERT INTO `recordings_old` VALUES (86,'E000','2000-04-04','Puszta I – Andante Moderato','Austin Civic Wind Ensemble','08Puszta-1.mp3','David Stern, guest conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (87,'E000','2000-04-04','Puszta II – Tranquillo','Austin Civic Wind Ensemble','09Puszta-2.mp3','David Stern, guest conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (88,'E000','2000-04-04','Puszta III – Allegro Molto','Austin Civic Wind Ensemble','10Puszta-3.mp3','David Stern, guest conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (89,'E000','2000-04-04','Puszta IV – Mercato','Austin Civic Wind Ensemble','11Puszta-4.mp3','David Stern, guest conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (90,'E000','2000-04-04','Cyrus the Great','Austin Civic Wind Ensemble','12CyrustheGreat.mp3','Rick Glascock, conductor','Covington Middle School','Karl King','',0);
INSERT INTO `recordings_old` VALUES (91,'E000','2000-04-04','Looney Tunes Overture','Austin Civic Wind Ensemble','13LooneyTunesOverture.mp3','Rick Glascock, conductor','Covington Middle School','','Bill Holcombe',0);
INSERT INTO `recordings_old` VALUES (92,'E000','2001-06-05','Fanfare for the Common Man','Austin Civic Wind Ensemble','01FanfareforCommonMan.mp3','Rick Glascock, conductor','Covington Middle School','Copland','',0);
INSERT INTO `recordings_old` VALUES (93,'C044','2001-06-05','Elsa\'s Procession to the Cathedral','Austin Civic Wind Ensemble','02ElsasProcession.mp3','Robert Laguna, guest conductor','Covington Middle School','Wagner','',1);
INSERT INTO `recordings_old` VALUES (94,'E000','2001-06-05','Variations on a Theme of Robert Schumann','Austin Civic Wind Ensemble','03VariationsonRbtSchumann.mp3','Jennifer Glass, bassoon','Covington Middle School','William Davis','',0);
INSERT INTO `recordings_old` VALUES (95,'E000','2001-06-05','March from \"1941”','Austin Civic Wind Ensemble','04March1941.mp3','Cliff Maloney, conductor','Covington Middle School','John Williams','',0);
INSERT INTO `recordings_old` VALUES (96,'E001','2001-06-05','Dezidme, Fuent Clara','Frontier Brass Quintet','05DezidmeFuentClara.mp3','Frontier Brass Quintet','Covington Middle School','Anonymous','',0);
INSERT INTO `recordings_old` VALUES (97,'E001','2001-06-05','Ain\'t Misbehavin\'','Frontier Brass Quintet','06AintMisbehavin.mp3','Frontier Brass Quintet','Covington Middle School','Fats Waller','',0);
INSERT INTO `recordings_old` VALUES (98,'E000','2001-06-05','Terpsichore I','Austin Civic Wind Ensemble','07Terpischore-1.mp3','Rick Glascock, conductor','Covington Middle School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (99,'E000','2001-06-05','Terpsichore III','Austin Civic Wind Ensemble','08Terpischore-2.mp3','Rick Glascock, conductor','Covington Middle School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (100,'E000','2001-06-05','Terpsichore III','Austin Civic Wind Ensemble','09Terpischore-3.mp3','Rick Glascock, conductor','Covington Middle School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (101,'E000','2001-06-05','Shenandoah','Austin Civic Wind Ensemble','10Shenandoah-Ticheli.mp3','Rick Glascock, conductor','Covington Middle School','Frank Ticheli','',0);
INSERT INTO `recordings_old` VALUES (102,'E000','2001-06-05','Molly on the Shore','Austin Civic Wind Ensemble','11MollyontheShore.mp3','Rick Glascock, conductor','Covington Middle School','Grainger','',0);
INSERT INTO `recordings_old` VALUES (103,'E000','2001-06-05','Hands Across the Sea','Austin Civic Wind Ensemble','12HandsacrosstheSea.mp3','Rick Glascock, conductor','Covington Middle School','Sousa','',0);
INSERT INTO `recordings_old` VALUES (104,'E001','2001-10-30','Amazing Grace','Soloist','01AmazingGrace.mp3','Cliff Maloney, euphonium, Mark Laine, piano','Anderson High School','','',0);
INSERT INTO `recordings_old` VALUES (105,'E000','2001-10-30','America the Beautiful','Austin Civic Wind Ensemble','02AmericatheBeautiful.mp3','Rick Glascock, conductor','Anderson High School','Ward','',0);
INSERT INTO `recordings_old` VALUES (106,'E000','2001-10-30','Terpsichore I','Austin Civic Wind Ensemble','03Terpsichore-1.mp3','Rick Glascock, conductor','Anderson High School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (107,'E000','2001-10-30','Terpsichore III','Austin Civic Wind Ensemble','04Terpsichore-2.mp3','Rick Glascock, conductor','Anderson High School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (108,'E000','2001-10-30','Terpsichore III','Austin Civic Wind Ensemble','05Terpsichore-3.mp3','Rick Glascock, conductor','Anderson High School','Bob Margolis','',0);
INSERT INTO `recordings_old` VALUES (109,'E000','2001-10-30','Colonial Song','Austin Civic Wind Ensemble','06ColonialSong.mp3','Rick Glascock, conductor','Anderson High School','Grainger','',0);
INSERT INTO `recordings_old` VALUES (110,'E000','2001-10-30','Flower Duet','Austin Civic Wind Ensemble','07FlowerDuet.mp3','Robert Laguna, trumpet and Alan Rogers, trumpets','Anderson High School','Delibes','',0);
INSERT INTO `recordings_old` VALUES (111,'E000','2001-10-30','Suite of Old American Dances – I Cake Walk','Austin Civic Wind Ensemble','08StAmerDances-CakeWalk.mp3','Rick Glascock, conductor','Anderson High School','Robert Russell Bennett','',0);
INSERT INTO `recordings_old` VALUES (112,'E000','2001-10-30','Suite of Old American Dances – II Schottische','Austin Civic Wind Ensemble','09StAmerDances-Schottische.mp3','Rick Glascock, conductor','Anderson High School','Robert Russell Bennett','',0);
INSERT INTO `recordings_old` VALUES (113,'E000','2001-10-30','Suite of Old American Dances – III Rag','Austin Civic Wind Ensemble','10StAmerDances-Rag.mp3','Rick Glascock, conductor','Anderson High School','Robert Russell Bennett','',0);
INSERT INTO `recordings_old` VALUES (114,'E000','2001-10-30','Suite of Old American Dances – IV Western One-Step','Austin Civic Wind Ensemble','11StAmerDances-WesternOneStep.mp3','Rick Glascock, conductor','Anderson High School','Robert Russell Bennett','',0);
INSERT INTO `recordings_old` VALUES (115,'E000','2001-10-30','Music from Robin Hood','Austin Civic Wind Ensemble','12RobinHood.mp3','Rick Glascock, conductor','Anderson High School','Kamen','',0);
INSERT INTO `recordings_old` VALUES (116,'E000','2001-10-30','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','13EasterMondayWhiteHouseLawn.mp3','Rick Glascock, conductor','Anderson High School','Sousa','',0);
INSERT INTO `recordings_old` VALUES (117,'E001','2002-04-16','Partita in A minor for Flute','Soloist','01Partitainaflute.mp3','Michael Severino, flute','Covington Middle School','Bach','',0);
INSERT INTO `recordings_old` VALUES (118,'E000','2002-04-16','The “Gum-Suckers” March','Austin Civic Wind Ensemble','02GumsuckersMarch.mp3','Rick Glascock, conductor','Covington Middle School','Grainger','',0);
INSERT INTO `recordings_old` VALUES (119,'E000','2002-04-16','The Pines of Rome - The Pines of the Villa Borghese','Austin Civic Wind Ensemble','03PinesofRome1.mp3','Robert Laguna, guest conductor','Covington Middle School','Ottorino Respighi','Duker',0);
INSERT INTO `recordings_old` VALUES (120,'E000','2002-04-16','The Pines of Rome – The Pines Near a Catacomb','Austin Civic Wind Ensemble','04PinesofRome2.mp3','Robert Laguna, guest conductor','Covington Middle School','Ottorino Respighi','Duker',0);
INSERT INTO `recordings_old` VALUES (121,'E000','2002-04-16','The Pines of Rome - The Pines of the Janiculum','Austin Civic Wind Ensemble','05PinesofRome3.mp3','Robert Laguna, guest conductor','Covington Middle School','Ottorino Respighi','Duker',0);
INSERT INTO `recordings_old` VALUES (122,'E000','2002-04-16','The Pines of Rome – The Pines of the Appian Way','Austin Civic Wind Ensemble','06PinesofRome4.mp3','Robert Laguna, guest conductor','Covington Middle School','Ottorino Respighi','Duker',0);
INSERT INTO `recordings_old` VALUES (123,'E000','2002-04-16','Rhapsody for Euphonium','Austin Civic Wind Ensemble','07RhapsodyforEuph.mp3','Ted Rachofsky, Euphonium','Covington Middle School','James Curnow','',0);
INSERT INTO `recordings_old` VALUES (124,'E000','2002-04-16','Cantebury Chorale','Austin Civic Wind Ensemble','08CanterburyChorale.mp3','Rick Glascock, conductor','Covington Middle School','Jan Van der Roost','',0);
INSERT INTO `recordings_old` VALUES (125,'E000','2002-04-16','Second Suite for Military Band in F Major – March','Austin Civic Wind Ensemble','09Holst2ndSt1.mp3','Rick Glascock, conductor','Covington Middle School','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (126,'E000','2002-04-16','Second Suite for Military Band in F Major – Song Without Words','Austin Civic Wind Ensemble','10Holst2ndSt2.mp3','Rick Glascock, conductor','Covington Middle School','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (127,'E000','2002-04-16','Second Suite for Military Band in F Major – Song of the Blacksmith','Austin Civic Wind Ensemble','11Holst2ndSt3.mp3','Rick Glascock, conductor','Covington Middle School','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (128,'E000','2002-04-16','Second Suite for Military Band in F Major – Fantasia on the Dargason','Austin Civic Wind Ensemble','12Holst2ndSt4.mp3','Rick Glascock, conductor','Covington Middle School','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (129,'E000','2003-11-04','First Suite for Band – March','Austin Civic Wind Ensemble','01ReedFirstSuite-1.mp3','Paul Crockett, conductor','Covington Middle School','Alfred Reed','',0);
INSERT INTO `recordings_old` VALUES (130,'E000','2003-11-04','First Suite for Band – Melody','Austin Civic Wind Ensemble','02ReedFirstSuite-2.mp3','Paul Crockett, conductor','Covington Middle School','Alfred Reed','',0);
INSERT INTO `recordings_old` VALUES (131,'E000','2003-11-04','First Suite for Band – Rag','Austin Civic Wind Ensemble','03ReedFirstSuite-3.mp3','Paul Crockett, conductor','Covington Middle School','Alfred Reed','',0);
INSERT INTO `recordings_old` VALUES (132,'E000','2003-11-04','Ye Banks and Braes O’Bonnie Doon','Austin Civic Wind Ensemble','04YeBanksandBraesOBonnieDoon.mp3','Paul Crockett, conductor','Covington Middle School','Grainger','',0);
INSERT INTO `recordings_old` VALUES (133,'E001','2003-11-04','Divertimento','Waterloo Winds','05Divertimento.mp3','Kari O’brien, flute; Carolyn Moore, clarinet; Carol Boeck, french horn; Lydia Olsen, oboe; Dara E. Smith, bassoon','Covington Middle School','Haydn','',0);
INSERT INTO `recordings_old` VALUES (134,'E001','2003-11-04','La Cheminée du Roi René, Op. 205 Mvt IV La Maousinglade','Waterloo Winds','06LaChamineeduRoiRene.mp3','Kari O’brien, flute; Carolyn Moore, clarinet; Carol Boeck, french horn; Lydia Olsen, oboe; Dara E. Smith, bassoon','Covington Middle School','D. Milhaud','',0);
INSERT INTO `recordings_old` VALUES (135,'E001','2003-11-04','La Comparsa','Waterloo Winds','07LaComparsa.mp3','Kari O’brien, flute; Carolyn Moore, clarinet; Carol Boeck, french horn; Lydia Olsen, oboe; Dara E. Smith, bassoon','Covington Middle School','','',0);
INSERT INTO `recordings_old` VALUES (136,'E000','2003-11-04','The Thunderer','Austin Civic Wind Ensemble','08TheThunderer.mp3','Robert Laguna, guest conductor','Covington Middle School','Sousa','',0);
INSERT INTO `recordings_old` VALUES (137,'E000','2003-11-04','October','Austin Civic Wind Ensemble','09October.mp3','Paul Crockett, conductor','Covington Middle School','Eric Whitacre','',0);
INSERT INTO `recordings_old` VALUES (138,'E000','2003-11-04','A Copland Tribute','Austin Civic Wind Ensemble','10CoplandTribute.mp3','Paul Crockett, conductor','Covington Middle School','Grundman','',0);
INSERT INTO `recordings_old` VALUES (139,'E000','2003-11-04','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','11EasterSundayontheWhiteHouseLawn.mp3','Paul Crockett, conductor','Covington Middle School','Sousa','',0);
INSERT INTO `recordings_old` VALUES (140,'E000','2003-11-04','First Suite for Band – Gallop','Austin Civic Wind Ensemble','12 Track12.mp3','Paul Crockett, conductor','Covington Middle School','Alfred Reed','',0);
INSERT INTO `recordings_old` VALUES (141,'E000','2005-11-10','Excerpts from Die Walkure','Austin Civic Wind Ensemble','01DieWalkure.mp3','David Whitwell, conductor','Covington Middle School','Wagner','',0);
INSERT INTO `recordings_old` VALUES (142,'E000','2005-11-10','Sinfonia da Requiem','Austin Civic Wind Ensemble','02SinfoniadaRequiem1.mp3','David Whitwell, conductor','Covington Middle School','David Whitwell','',0);
INSERT INTO `recordings_old` VALUES (143,'E000','2005-11-10','Sinfonia da Requiem','Austin Civic Wind Ensemble','03SinfoniadaRequiem2.mp3','David Whitwell, conductor','Covington Middle School','David Whitwell','',0);
INSERT INTO `recordings_old` VALUES (144,'E000','2005-11-10','Sinfonia da Requiem','Austin Civic Wind Ensemble','04SinfoniadaRequiem3.mp3','David Whitwell, conductor','Covington Middle School','David Whitwell','',0);
INSERT INTO `recordings_old` VALUES (145,'E000','2005-11-10','Sinfonia da Requiem','Austin Civic Wind Ensemble','05SinfoniadaRequiem4.mp3','David Whitwell, conductor','Covington Middle School','David Whitwell','',0);
INSERT INTO `recordings_old` VALUES (146,'E000','2005-11-10','Sinfonia da Requiem','Austin Civic Wind Ensemble','06SinfoniadaRequiem5.mp3','David Whitwell, conductor','Covington Middle School','David Whitwell','',0);
INSERT INTO `recordings_old` VALUES (147,'E000','2005-11-10','Symphonie Funebre et Triomphale','Austin Civic Wind Ensemble','07FunebreetTriomphale1.mp3','David Whitwell, conductor','Covington Middle School','Hector Berlioz','Whitwell',0);
INSERT INTO `recordings_old` VALUES (148,'E000','2005-11-10','Symphonie Funebre et Triomphale','Austin Civic Wind Ensemble','08FunebreetTriomphale2.mp3','David Whitwell, conductor','Covington Middle School','Hector Berlioz','Whitwell',0);
INSERT INTO `recordings_old` VALUES (149,'E000','2005-11-10','Symphonie Funebre et Triomphale','Austin Civic Wind Ensemble','09FunebreetTriomphale3.mp3','David Whitwell, conductor','Covington Middle School','Hector Berlioz','Whitwell',0);
INSERT INTO `recordings_old` VALUES (150,'E000','2006-10-30','Carmina Burana – Fortuna Imperatrix Mundi','Austin Civic Wind Ensemble','01CarminaBurana1.mp3','Robert Laguna, conductor','Crockett High School','Carl Orff','Krance',0);
INSERT INTO `recordings_old` VALUES (151,'E000','2006-10-30','Carmina Burana – Fortune plango vulnera','Austin Civic Wind Ensemble','02CarminaBurana2.mp3','Robert Laguna, conductor','Crockett High School','Carl Orff','Krance',0);
INSERT INTO `recordings_old` VALUES (152,'E000','2006-10-30','Carmina Burana – In taberna quando sumus','Austin Civic Wind Ensemble','03CarminaBurana3.mp3','Robert Laguna, conductor','Crockett High School','Carl Orff','Krance',0);
INSERT INTO `recordings_old` VALUES (153,'E000','2006-10-30','Der Traum des Oenhus','Austin Civic Wind Ensemble','04DerTraumdesOenghus.mp3','Derek Stoughton, conductor','Crockett High School','Rolf Rudin','',0);
INSERT INTO `recordings_old` VALUES (154,'E000','2006-10-30','Mars from “The Planets”','Austin Civic Wind Ensemble','05Mars.mp3','Robert Laguna, conductor','Crockett High School','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (155,'E000','2006-10-30','Excerpts from Die Walkure','Austin Civic Wind Ensemble','06DieWalkureExcerpts.mp3','Robert Laguna, conductor','Crockett High School','Richard Wagner','Whitwell',0);
INSERT INTO `recordings_old` VALUES (156,'E000','2006-10-30','Greensleeves','Austin Civic Wind Ensemble','07Greensleeves.mp3','Cindy Chang, Theramin','Crockett High School','Traditional','',0);
INSERT INTO `recordings_old` VALUES (157,'E001','2006-10-30','Mephistopheles','Austin Wonder Brass','08Mephistopholes-AWB.mp3','Austin Wonder Brass','Crockett High School','Shipley Douglas','',0);
INSERT INTO `recordings_old` VALUES (158,'E001','2006-10-30','Toccata in D Minor','Austin Wonder Brass','09BachToccataind-AWB.mp3','Austin Wonder Brass','Crockett High School','J.S. Bach','Farr',0);
INSERT INTO `recordings_old` VALUES (159,'E000','2006-10-30','Fingal’s Cave','Austin Civic Wind Ensemble','10FingalsCave.mp3','Robert Laguna, conductor','Crockett High School','Mendelssohn','',0);
INSERT INTO `recordings_old` VALUES (160,'E000','2006-10-30','Main Title from “Jaws”','Austin Civic Wind Ensemble','11Jaws.mp3','Robert Laguna, conductor','Crockett High School','John Williams','Cavacas',0);
INSERT INTO `recordings_old` VALUES (161,'E000','2006-10-30','Night on Bald Mountain','Austin Civic Wind Ensemble','12NightonBaldMountain.mp3','Robert Laguna, conductor','Crockett High School','Modeste Moussorgsky','Schaefer',0);
INSERT INTO `recordings_old` VALUES (162,'E000','2006-10-30','Invocation of Alberich from “Rheingold”','Austin Civic Wind Ensemble','13InvocationofAlberich.mp3','Robert Laguna, conductor','Crockett High School','Wagner','Calliet',0);
INSERT INTO `recordings_old` VALUES (163,'X026','2008-12-01','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','Unknown conductor, unknown exact date','Unknown location','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (164,'E000','2008-12-01','White Christmas','Austin Civic Wind Ensemble','02WhiteChristmas.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (165,'E000','2008-12-01','Train Ride','Austin Civic Wind Ensemble','03TrainRide.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (166,'E000','2008-12-01','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','04Grinch.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (167,'E000','2008-12-01','Magnum Mysterium','Austin Civic Wind Ensemble','05OMagnumMysterium.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (168,'E000','2008-12-01','Sleigh Ride','Austin Civic Wind Ensemble','06SleighRide.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (169,'E000','2008-12-01','Do You Hear What I Hear?','Austin Civic Wind Ensemble','07DoYouHear.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (170,'E000','2008-12-01','Cantique de Noel','Austin Civic Wind Ensemble','08CantiquedeNoel.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (171,'E000','2008-12-01','Carol of the Bells','Austin Civic Wind Ensemble','09CaroloftheBells.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (172,'E000','2008-12-01','Carol of the Drum','Austin Civic Wind Ensemble','10CaroloftheDrum.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (173,'E000','2008-12-01','Jingle Bells Forever','Austin Civic Wind Ensemble','11JingleBellsForever.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (174,'E000','2008-12-01','I Saw Three Ships','Austin Civic Wind Ensemble','12IsawThreeShips.mp3','Unknown conductor, unknown exact date','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (175,'E000','2009-06-27','Fanfare for the Common Man','Austin Civic Wind Ensemble','01FanfarefortheCommonMan.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (176,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','02LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (177,'E000','2009-06-27','Star Spangled Banner','Austin Civic Wind Ensemble','03StarSpangledBanner-Williams.mp3','Robert Laguna, conductor','Carver Museum?','','John Williams',0);
INSERT INTO `recordings_old` VALUES (178,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','04LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (179,'E000','2009-06-27','The Klaxon','Austin Civic Wind Ensemble','05TheKlaxon.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (180,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','06LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (181,'C335','2009-06-27','1812 Overture','Austin Civic Wind Ensemble','07-1812.mp3','Robert Laguna, conductor','Carver Museum?','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (182,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','08LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (183,'E000','2009-06-27','El Capitan','Austin Civic Wind Ensemble','09ElCapitan.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (184,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','10LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (185,'E000','2009-06-27','American the Beautiful','Austin Civic Wind Ensemble','11AmericantheBeautiful.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (186,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','12LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (187,'E000','2009-06-27','Semper Fidelis','Austin Civic Wind Ensemble','13SempterFidelis.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (188,'E000','2009-06-27','Robert Laguna commentary and introduction','Austin Civic Wind Ensemble','14LagunaComments.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (189,'E000','2009-06-27','Stars and Stripes Forever','Austin Civic Wind Ensemble','15StarsandStripesForever.mp3','Robert Laguna, conductor','Carver Museum?','','',0);
INSERT INTO `recordings_old` VALUES (190,'E000','2009-10-30','Manzoni Requiem','Austin Civic Wind Ensemble','01VerdiRequiem.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Giuseppe Verdi','Emil Mollenhauer',0);
INSERT INTO `recordings_old` VALUES (191,'E000','2009-10-30','Adagio (Adagio for Strings)','Austin Civic Wind Ensemble','02BarberAdagio.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Samuel Barber','Calvin Custer',0);
INSERT INTO `recordings_old` VALUES (192,'E000','2009-10-30','Theme from Lawrence of Arabia','Austin Civic Wind Ensemble','03LawrenceofArabia.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Maurice Jarre','Alfred Reed',0);
INSERT INTO `recordings_old` VALUES (193,'E000','2009-10-30','Der Traum des Oenhus','Austin Civic Wind Ensemble','04DerTraumdesOengus.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Rolf Rudin','',0);
INSERT INTO `recordings_old` VALUES (194,'E000','2009-10-30','Elsa\'s Procession to the Cathedral','Austin Civic Wind Ensemble','05ElsasProcession.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Richard Wagner','Lucien Caillet',0);
INSERT INTO `recordings_old` VALUES (195,'E000','2009-10-30','Amparito Roca','Austin Civic Wind Ensemble','06AmparitoRoca.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Jaime Texidor','',0);
INSERT INTO `recordings_old` VALUES (196,'E000','2010-04-20','In Storm and Sunshine','Austin Civic Wind Ensemble','01StormandSunshine.mp3','Robert Laguna, conductor','Covenant United Methodist Church','J.C. Heed','',0);
INSERT INTO `recordings_old` VALUES (197,'E000','2010-04-20','The Inferno (from The Devine Comedy)','Austin Civic Wind Ensemble','02Inferno.mp3','Douglas Henderson, guest conductor','Covenant United Methodist Church','Robert W. Smith','',0);
INSERT INTO `recordings_old` VALUES (198,'E000','2010-04-20','Overture to Colas Breugnon','Austin Civic Wind Ensemble','03Colas.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Dmitri Kabalevsky','Donald Hunsberger',0);
INSERT INTO `recordings_old` VALUES (199,'E000','2010-04-20','Abram’s Pursuit','Austin Civic Wind Ensemble','04Abram\'s Pursuit.mp3','Robert Laguna, conductor','Covenant United Methodist Church','David R. Holsinger','',0);
INSERT INTO `recordings_old` VALUES (200,'E000','2010-04-20','The Illiad from The Odyssey (Symphony No. 2)','Austin Civic Wind Ensemble','05Iliad.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Robert W. Smith','',0);
INSERT INTO `recordings_old` VALUES (201,'E000','2010-04-20','Of Sailors and Whales – I Ishmael, II Queequeg, III Father Mapple, IV Ahab, V The White Whale','Austin Civic Wind Ensemble','06Sailors.mp3','Robert Laguna, conductor','Covenant United Methodist Church','W. Francis McBeth','',0);
INSERT INTO `recordings_old` VALUES (202,'E000','2010-07-04','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangled.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (203,'E000','2010-07-04','Unknown Circus March','Austin Civic Wind Ensemble','02KingCircus.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (204,'E000','2010-07-04','America the Beautiful','Austin Civic Wind Ensemble','03AmericaBeautiful.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (205,'C335','2010-07-04','1812 Overture','Austin Civic Wind Ensemble','04-1812.mp3','Unknown conductor, unknown exact location','Unknown location','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (206,'E000','2010-07-04','General Mixup','Austin Civic Wind Ensemble','05GeneralMixupEdit.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (207,'E000','2010-07-04','An American in Paris','Austin Civic Wind Ensemble','06AmericaninParis.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (208,'E000','2010-07-04','Monkey Business','Austin Civic Wind Ensemble','07MonkeyBusiness.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (209,'E000','2010-07-04','Stars and Stripes Forever','Austin Civic Wind Ensemble','08StarsandStripes.mp3','Unknown conductor, unknown exact location','Unknown location','','',0);
INSERT INTO `recordings_old` VALUES (210,'E000','2010-10-29','March Hongroise','Austin Civic Wind Ensemble','01HungarianMarch.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Hector Berlioz','Yo Gotoh',0);
INSERT INTO `recordings_old` VALUES (211,'E000','2010-10-29','Twilight Dance','Austin Civic Wind Ensemble','02TwilightDance.mp3','Robert Laguna, conductor','Covenant United Methodist Church','William L. Ballenger','',0);
INSERT INTO `recordings_old` VALUES (212,'E000','2010-10-29','Symphonie Fantastique, Op. 14','Austin Civic Wind Ensemble','03WitchesSabbath.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Hector Berlioz','R. Mark Rogers',0);
INSERT INTO `recordings_old` VALUES (213,'E000','2010-10-29','The Planets – I Mars, the Bringer of War','Austin Civic Wind Ensemble','04Mars.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (214,'E000','2010-10-29','La Tregenda','Austin Civic Wind Ensemble','05Tregenda.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Giacomo Puccini','',0);
INSERT INTO `recordings_old` VALUES (215,'E000','2010-10-29','The Planets – II Jupiter, the Bringer of Jolly','Austin Civic Wind Ensemble','06Jupiter.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Gustav Holst','',0);
INSERT INTO `recordings_old` VALUES (216,'X026','2010-12-18','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (217,'E000','2010-12-18','Do You Hear What I Hear?','Austin Civic Wind Ensemble','02DoYouHear.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','John Cacavas','',0);
INSERT INTO `recordings_old` VALUES (218,'E000','2010-12-18','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','03Grinch.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Albert Hague','',0);
INSERT INTO `recordings_old` VALUES (219,'E000','2010-12-18','Cantique de Noel','Austin Civic Wind Ensemble','04CantiqueNoel.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Adolphe Adam','',0);
INSERT INTO `recordings_old` VALUES (220,'E000','2010-12-18','Up on a Housetop','Austin Civic Wind Ensemble','05UponaHousetop.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Benjamin Russel Hanby','Jeff Simmons',0);
INSERT INTO `recordings_old` VALUES (221,'E000','2010-12-18','Sleigh Ride','Austin Civic Wind Ensemble','06SleighRide.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Leroy Anderson','',0);
INSERT INTO `recordings_old` VALUES (222,'E000','2010-12-18','Carol of the Drum','Austin Civic Wind Ensemble','07CaroloftheDrum.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Katherine K. Davis','',0);
INSERT INTO `recordings_old` VALUES (223,'E000','2010-12-18','Fum, Fum, Fum','Austin Civic Wind Ensemble','08FumFumFum.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Traditional','',0);
INSERT INTO `recordings_old` VALUES (224,'E000','2010-12-18','Train Ride','Austin Civic Wind Ensemble','09TrainRide.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Sergei Prokofieff','Howard Cable',0);
INSERT INTO `recordings_old` VALUES (225,'E000','2010-12-18','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','10FantasyonaBellCarol.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Edward J. Madden','',0);
INSERT INTO `recordings_old` VALUES (226,'E000','2010-12-18','March of the Toys','Austin Civic Wind Ensemble','11MarchoftheToys.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Victor Clarke','',0);
INSERT INTO `recordings_old` VALUES (227,'E000','2010-12-18','Jingle Bells Forever','Austin Civic Wind Ensemble','12JingleBellsForever.mp3','Robert Laguna, conductor','St. Andrew\'s Presbyterian Church','Robert W. Smith','',0);
INSERT INTO `recordings_old` VALUES (228,'E000','2011-05-13','The Cowboys','Austin Civic Wind Ensemble','01Cowboys.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (229,'E000','2011-05-13','La Fiesta Mexicana: Prelude','Austin Civic Wind Ensemble','02Mexicana1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (230,'E000','2011-05-13','La Fiesta Mexicana: Mass','Austin Civic Wind Ensemble','03Mexicana2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (231,'E000','2011-05-13','Symphony of Souls','Austin Civic Wind Ensemble','04SymphonyofSouls.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (232,'E000','2011-05-13','On the Grand Prairie Texas','Austin Civic Wind Ensemble','05GrandPrairie.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (233,'E000','2011-05-13','Stephen Foster Medley','Austin Civic Wind Ensemble','06Foster.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (234,'E000','2011-05-13','Equus','Austin Civic Wind Ensemble','07Equus.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (235,'E000','2011-05-13','Daughters of Texas','Austin Civic Wind Ensemble','DaughtersTx.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (236,'E000','2011-07-03','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (237,'E000','2011-07-03','Liberty Fanfare','Austin Civic Wind Ensemble','02LibertyFanfare.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (238,'E000','2011-07-03','God Bless America','Austin Civic Wind Ensemble','03GodBlessAmerica.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (239,'E000','2011-07-03','Clear Track','Austin Civic Wind Ensemble','04ClearTrack.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (240,'E000','2011-07-03','America the Beautiful','Austin Civic Wind Ensemble','05AmericatheBeautiful.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (241,'E000','2011-07-03','Victory at Sea','Austin Civic Wind Ensemble','06VictoryatSea.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (242,'E000','2011-07-03','Red’s White and Blue March','Austin Civic Wind Ensemble','07RedsWhite+Blue.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (243,'C335','2011-07-03','1812 Overture','Austin Civic Wind Ensemble','08-1812.mp3','','Covenant United Methodist Church','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (244,'E000','2011-07-03','Stars and Stripes Forever','Austin Civic Wind Ensemble','09Stars+Stripes.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (245,'E000','2011-10-28','Overture to Dancer in the Dark','Austin Civic Wind Ensemble','01OvertureDancerintheDark.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (246,'E000','2011-10-28','Night on Bald Mountain','Austin Civic Wind Ensemble','02NightonBaldMtn.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (247,'E000','2011-10-28','People Who Live in Glass Houses - Champaignes','Austin Civic Wind Ensemble','03Champaignes.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (248,'E000','2011-10-28','Allerseelen','Austin Civic Wind Ensemble','04Allerseelen.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (249,'E000','2011-10-28','People Who Live in Glass Houses - Rhine Wines','Austin Civic Wind Ensemble','05RhineWines.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (250,'E000','2011-10-28','Silverado','Austin Civic Wind Ensemble','06Silverado.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (251,'E000','2011-10-28','People Who Live in Glass Houses - Whiskies','Austin Civic Wind Ensemble','07Whiskies.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (252,'E000','2011-10-28','Carmina Burana Part 1','Austin Civic Wind Ensemble','08CarminaBurana1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (253,'E000','2011-10-28','Carmina Burana Part 2','Austin Civic Wind Ensemble','09CarminaBurana2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (254,'E000','2011-10-28','Carmina Burana Part 3','Austin Civic Wind Ensemble','10CarminaBurana3.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (255,'E000','2011-10-28','People Who Live in Glass Houses - Cordials','Austin Civic Wind Ensemble','11Cordials.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (256,'E000','2011-10-28','Colonel Bogey','Austin Civic Wind Ensemble','12ColonelBogey.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (257,'E000','2011-12-17','Christmas Festival','Austin Civic Wind Ensemble','01XmasFestival.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (258,'E000','2011-12-17','Do You Hear What I Hear?','Austin Civic Wind Ensemble','02DoyouHear.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (259,'E000','2011-12-17','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','03Grinch.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (260,'E000','2011-12-17','Cantique de Noel','Austin Civic Wind Ensemble','04Cantique.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (261,'E000','2011-12-17','Holst 2nd Suite in F','Austin Civic Wind Ensemble','05-2ndSuite.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (262,'E000','2011-12-17','Train Ride','Austin Civic Wind Ensemble','06TrainRide.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (263,'E000','2011-12-17','Carol of the Drum','Austin Civic Wind Ensemble','07CaroloftheDrum.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (264,'E000','2011-12-17','Sleigh Ride','Austin Civic Wind Ensemble','08SleighRide.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (265,'E000','2011-12-17','Fum Fum Fum','Austin Civic Wind Ensemble','09FumFumFum.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (266,'E000','2011-12-17','Jingle Bells Forever','Austin Civic Wind Ensemble','10JingleBellsForever.mp3','','St. Andrew\'s Presbyterian Church','','',0);
INSERT INTO `recordings_old` VALUES (267,'E000','2012-04-28','Circus Days','Austin Civic Wind Ensemble','01CircusDays.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (268,'E000','2012-04-28','Lt. Kijé Suite: Kijé\'s Birth','Austin Civic Wind Ensemble','02LtKije1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (269,'E000','2012-04-28','Lt. Kijé Suite: Song (Romance)','Austin Civic Wind Ensemble','03LtKije2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (270,'C486','2012-04-28','Lt. Kijé Suite: Kijé\'s Wedding','Austin Civic Wind Ensemble','04LtKije3.mp3','','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (271,'E000','2012-04-28','Lt. Kijé Suite: Troika','Austin Civic Wind Ensemble','05LtKije4.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (272,'C486','2012-04-28','Lt. Kijé Suite: Kijé\'s Death','Austin Civic Wind Ensemble','06LtKije5.mp3','','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (273,'E000','2012-04-28','Monkey Business','Austin Civic Wind Ensemble','07MonkeyBusiness.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (274,'E000','2012-04-28','Send in the Clowns','Austin Civic Wind Ensemble','08SendintheClowns.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (275,'E000','2012-04-28','Olympia Hippodrome','Austin Civic Wind Ensemble','09OlympiaHippodrome.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (276,'E000','2012-04-28','English Waltz','Austin Civic Wind Ensemble','10EnglishWaltz.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (277,'E000','2012-04-28','Walking Frog','Austin Civic Wind Ensemble','11WalkingFrog.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (278,'E000','2012-04-28','Smile','Austin Civic Wind Ensemble','12Smile.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (279,'E000','2012-04-28','The Liberty Bell March','Austin Civic Wind Ensemble','13LibertyBell.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (280,'E000','2012-07-03','Fanfare for the Common Man','Austin Civic Wind Ensemble','01FanfarefortheCommonMan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (281,'E000','2012-07-03','Star Spangled Banner','Austin Civic Wind Ensemble','02StarSpangledBanner.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (282,'E000','2012-07-03','Pineapple Poll - I','Austin Civic Wind Ensemble','03PineapplePoll-1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (283,'E000','2012-07-03','Cora is Gone','Austin Civic Wind Ensemble','04CoraisGone.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (284,'E000','2012-07-03','Eternal Father, Strong to Save','Austin Civic Wind Ensemble','05EternalFather.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (285,'E000','2012-07-03','Pineapple Poll - II','Austin Civic Wind Ensemble','06PineapplePoll-2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (286,'E000','2012-07-03','America the Beautiful','Austin Civic Wind Ensemble','07AmericatheBeautiful.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (287,'E000','2012-07-03','The Girl I Left Behind','Austin Civic Wind Ensemble','08GirlILeftBehindMe.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (288,'E000','2012-07-03','Pineapple Poll - III &amp','Austin Civic Wind Ensemble','09PineapplePoll-3+4.mp3','','Covenant United Methodist Church',' IV','',0);
INSERT INTO `recordings_old` VALUES (289,'E000','2012-07-03','Overture 1812','Austin Civic Wind Ensemble','10-1812.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (290,'E000','2012-07-03','The Stars and Stripes Forever','Austin Civic Wind Ensemble','11StarsandStripesForever.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (291,'E000','2012-10-26','Fifth Trumpeter','Austin Civic Wind Ensemble','01FifthTrumpeter.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (292,'C044','2012-10-26','Elsa\'s Procession','Austin Civic Wind Ensemble','02ElsasProcession.aif.mp3','','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (293,'E000','2012-10-26','Foundry','Austin Civic Wind Ensemble','03Foundry.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (294,'E000','2012-10-26','Peer Gynt','Austin Civic Wind Ensemble','04PeerGynt.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (295,'E000','2012-10-26','Eine Heldenleben - Courtship','Austin Civic Wind Ensemble','05Heldenleben-Courtship.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (296,'E000','2012-10-26','Robin Hood','Austin Civic Wind Ensemble','06RobinHood.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (297,'E000','2012-10-26','Cyrus the Great','Austin Civic Wind Ensemble','07CyrustheGreat.aif.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (298,'E000','2012-11-11','Fifth Trumpeter','Austin Civic Wind Ensemble','01FifthTrumpeter.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (299,'C044','2012-11-11','Elsa\'s Procession','Austin Civic Wind Ensemble','02ElsasProcession.mp3','','Episcopal Church of the Resurrection','','',1);
INSERT INTO `recordings_old` VALUES (300,'E000','2012-11-11','Foundry','Austin Civic Wind Ensemble','03Foundry.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (301,'E000','2012-11-11','Peer Gynt','Austin Civic Wind Ensemble','04PeerGynt.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (302,'E000','2012-11-11','Ein Heldenleben','Austin Civic Wind Ensemble','05Heldenleben.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (303,'E000','2012-11-11','Robin Hood','Austin Civic Wind Ensemble','06RobinHood.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (304,'E000','2012-11-11','Cyrus the Great','Austin Civic Wind Ensemble','07Cyrus.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (305,'E000','2012-12-14','Russian Christmas Music','Austin Civic Wind Ensemble','RussianChristmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (306,'X026','2012-12-16','Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','','Unity Church of the Hills','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (307,'E000','2012-12-16','Russian Christmas Music','Austin Civic Wind Ensemble','02RussianChristmas.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (308,'E000','2012-12-16','Do You Hear What I Hear?','Austin Civic Wind Ensemble','03DoYouHear.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (309,'E000','2012-12-16','The Grinch Who Stole Christmas','Austin Civic Wind Ensemble','04Grinch.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (310,'E000','2012-12-16','Cantique de Noel','Austin Civic Wind Ensemble','05CantiquedeNoel.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (311,'E000','2012-12-16','Sleigh Ride','Austin Civic Wind Ensemble','06SleighRide.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (312,'E000','2012-12-16','Carol of the Drum','Austin Civic Wind Ensemble','07CaroloftheDrum.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (313,'E000','2012-12-16','Fum Fum Fum','Austin Civic Wind Ensemble','08FumFumFum.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (314,'E000','2012-12-16','Train Ride','Austin Civic Wind Ensemble','09TrainRide.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (315,'E000','2012-12-16','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','10FantasyonBellCarol.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (316,'E000','2012-12-16','Jingle Bells Forever','Austin Civic Wind Ensemble','11JingleBellsForever.mp3','','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (317,'E000','2013-04-21','La Oregja de Oro','Austin Civic Wind Ensemble','01LaOregjadeOro.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (318,'E000','2013-04-21','La Bamba de Vera Cruz','Austin Civic Wind Ensemble','02LaBambadeVeraCruz.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (319,'E000','2013-04-21','Vientos y Tangos','Austin Civic Wind Ensemble','03VientosyTangos.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (320,'E000','2013-04-21','Cielito Lindo','Austin Civic Wind Ensemble','04CielitoLindo.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (321,'E000','2013-04-21','Batuque','Austin Civic Wind Ensemble','05Batuque.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (322,'E000','2013-04-21','Zacatecas','Austin Civic Wind Ensemble','06Zacatecas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (323,'E000','2013-07-03','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (324,'E000','2013-07-03','American Overture for Band','Austin Civic Wind Ensemble','02AmericanOvertureforBand.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (325,'E000','2013-07-03','El Capitan','Austin Civic Wind Ensemble','03ElCapitan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (326,'E000','2013-07-03','American Riversongs','Austin Civic Wind Ensemble','04AmericanRiversongs.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (327,'E000','2013-07-03','Southern Harmony Movements 1&amp','Austin Civic Wind Ensemble','05SouthernHarmony.mp3','','Covenant United Methodist Church','3','',0);
INSERT INTO `recordings_old` VALUES (328,'E000','2013-07-03','Shoutin\' Liza','Austin Civic Wind Ensemble','06ShoutinLiza.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (329,'E000','2013-07-03','Suite of Old American Dances','Austin Civic Wind Ensemble','07SuiteofOldAmericanDances.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (330,'E000','2013-07-03','America the Beautiful','Austin Civic Wind Ensemble','08AmericatheBeautiful.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (331,'E000','2013-07-03','Lassus Trombone','Austin Civic Wind Ensemble','09LassusTrombone.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (332,'E000','2013-07-03','Washington Post','Austin Civic Wind Ensemble','10WashingtonPost.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (333,'E000','2013-07-03','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','11EasterMondayonthWHLawn.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (334,'E000','2013-07-03','Stars and Stripes Forever','Austin Civic Wind Ensemble','12Stars+StripesForever.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (335,'E000','2013-10-25','Fingal\'s Cave Overture','Austin Civic Wind Ensemble','01FingalsCave.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (336,'E000','2013-10-25','You Raise Me Up','Austin Civic Wind Ensemble','02YouRaiseMeUp.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (337,'E000','2013-10-25','Terpsichore Mvt 3','Austin Civic Wind Ensemble','03Terpsichore3.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (338,'E000','2013-10-25','Terpsichore Mvt 1','Austin Civic Wind Ensemble','04Terpsichore1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (339,'E000','2013-10-25','Variations on a Theme by Robert Schumann','Austin Civic Wind Ensemble','05SchumannVariations.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (340,'E000','2013-10-25','Reiche Fanfare and Mr. Mayfield speaks','Austin Civic Wind Ensemble','06BaroqueTpt.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (341,'E000','2013-10-25','Three Wishes','Austin Civic Wind Ensemble','07ThreeWishes.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (342,'E000','2013-10-25','Forest of the King Mvmt. 1','Austin Civic Wind Ensemble','08ForestoftheKing1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (343,'E000','2013-10-25','Forest of the King Mvmt. 2','Austin Civic Wind Ensemble','09ForestoftheKing2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (344,'E000','2013-10-25','Forest of the King Mvmt. 3','Austin Civic Wind Ensemble','10ForestoftheKing3.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (345,'E000','2013-10-25','Contre Qui Rose','Austin Civic Wind Ensemble','11ContreQuiRose.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (346,'E000','2013-10-25','Finale from Symphony No. 3 “Organ” by Saint-Saens','Austin Civic Wind Ensemble','12OrganSymphony.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (347,'E000','2013-11-01','Fingal\'s Cave Overture','Austin Civic Wind Ensemble','01FingalsCave.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (348,'E000','2013-11-01','Tersichore 3 & 1','Austin Civic Wind Ensemble','02Terpsichore3+1.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (349,'E000','2013-11-01','Variations on a Theme by Robert Schumann','Austin Civic Wind Ensemble','03SchumannVariations.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (350,'E000','2013-11-01','Harlequin','Austin Civic Wind Ensemble','04Harlequin.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (351,'E000','2013-11-01','Forest of the King Mvmt. 1','Austin Civic Wind Ensemble','05ForestoftheKing1.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (352,'E000','2013-11-01','Forest of the King Mvmt. 2','Austin Civic Wind Ensemble','06ForestoftheKing2.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (353,'E000','2013-11-01','Forest of the King Mvmt. 3','Austin Civic Wind Ensemble','07ForrestoftheKing3.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (354,'E000','2013-11-01','Contre Qui Rose','Austin Civic Wind Ensemble','08ContreQuiRose.mp3','','George Washington Carver Museum and Cultural Center','','',0);
INSERT INTO `recordings_old` VALUES (355,'E000','2013-11-01','Finale from Symphony No. 3 &quot','Austin Civic Wind Ensemble','09OrganSymphony.mp3','','George Washington Carver Museum and Cultural Center','Organ&quot',' by Saint-Saens',0);
INSERT INTO `recordings_old` VALUES (356,'E000','2013-12-13','Fanfare on a French Carol','Austin Civic Wind Ensemble','01FanfareonFrenchCarol.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (357,'E000','2013-12-13','Variations on a French Carol','Austin Civic Wind Ensemble','02VariationsonaFrenchCarol.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (358,'E000','2013-12-13','Cantique de Noel','Austin Civic Wind Ensemble','03CantiqueduNoel.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (359,'E000','2013-12-13','A Winter\'s Carol','Austin Civic Wind Ensemble','04WintersCarol.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (360,'E000','2013-12-13','It\'s the Most Wonderful Time of the Year','Austin Civic Wind Ensemble','05MostWonderfulTime.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (361,'X026','2013-12-13','Christmas Festival','Austin Civic Wind Ensemble','06ChristmasFestival.mp3','','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (362,'E000','2013-12-13','Have Yourself a Merry Little Christmas','Austin Civic Wind Ensemble','07HaveYourselfMerryLittleXmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (363,'E000','2013-12-13','Pat a Pan','Austin Civic Wind Ensemble','08PataPan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (364,'E000','2013-12-13','Carol of the Drum','Austin Civic Wind Ensemble','09CarolofDrum.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (365,'E000','2013-12-13','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','10Grinch.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (366,'E000','2013-12-13','Stars and Stripes for Christmas','Austin Civic Wind Ensemble','11Stars+StripesforXmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (367,'E001','2013-12-13','Flute Choir','Violet Crown Flute Choir','12FluteChoir.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (368,'E001','2013-12-13','Nutcracker','Violet Crown Flute Choir','13FluteNutcracker.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (369,'E000','2013-12-14','Finale from Symphony No. 3 \'Organ\' by Saint-Saens','Austin Civic Wind Ensemble','OrganSymphony.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (370,'E000','2014-05-11','French National Defile','Austin Civic Wind Ensemble','01RegimentdeSambreetMeuse.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (371,'E000','2014-05-11','Symphonie funebre et triomphale – March','Austin Civic Wind Ensemble','02GrandeSymphonie-1.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (372,'E000','2014-05-11','Symphonie funebre et triomphale – March','Austin Civic Wind Ensemble','03GrandSymphonie-2.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (373,'E000','2014-05-11','Symphonie funebre et triomphale – March','Austin Civic Wind Ensemble','04GrandeSymphonie-3.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (374,'E000','2014-05-11','Les Chansons des Roses, 2: Conre qui','Austin Civic Wind Ensemble','05ContrequiRose.aif','','Episcopal Church of the Resurrection','','H Robert Reynolds',0);
INSERT INTO `recordings_old` VALUES (375,'E000','2014-05-11','Cajun Folk Songs','Austin Civic Wind Ensemble','06CajunFolkSongs.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (376,'E000','2014-05-11','Ballet Parisien','Austin Civic Wind Ensemble','07BalletParisien.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (377,'E000','2014-05-11','Concertino for Flute. Op 107','Austin Civic Wind Ensemble','08ConcertinoforFlute.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (378,'E000','2014-05-11','Suite Francaise (4 movements)','Austin Civic Wind Ensemble','09SuiteFrancaise.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (379,'E000','2014-05-11','Les Chasseresse','Austin Civic Wind Ensemble','10Chasseresses.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (380,'E000','2014-05-11','Chant du Part','Austin Civic Wind Ensemble','11ChantduDepart.aif','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (381,'E000','2014-07-01','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (382,'E001','2014-07-01','America the Beautiful','Violet Crown Flute Choir','02FC-America.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (383,'E001','2014-07-01','Yankee Doodle','Violet Crown Flute Choir','03FC-YankeeDoodle.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (384,'E001','2014-07-01','When Johnny Comes Marching Home','Violet Crown Flute Choir','04FC-JohnnyComesMarchingHome.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (385,'E001','2014-07-01','You’re a Grand Old Flag','Violet Crown Flute Choir','05FC-GrandOldFlag.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (386,'E000','2014-07-01','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','06EasterMonday.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (387,'E000','2014-07-01','Washington Post','Austin Civic Wind Ensemble','07WashingtonPost.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (388,'E000','2014-07-01','Semper Fidelis','Austin Civic Wind Ensemble','08SemperFi.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (389,'E000','2014-07-01','Cora is Gone','Austin Civic Wind Ensemble','09CoraisGone.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (390,'E000','2014-07-01','El Capitan','Austin Civic Wind Ensemble','10ElCapitan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (391,'E000','2014-07-01','The Girl I Left Behind','Austin Civic Wind Ensemble','11GirlILeftBehindMe.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (392,'C335','2014-07-01','1812 Overture','Austin Civic Wind Ensemble','12-1812.mp3','','Covenant United Methodist Church','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (393,'E000','2014-07-01','Stars and Stripes Forever','Austin Civic Wind Ensemble','13Stars+Stripes.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (394,'E000','2014-11-09','Colas Breugnon','Austin Civic Wind Ensemble','01ColasBreugnon.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (395,'E000','2014-11-09','William Byrd Suite','Austin Civic Wind Ensemble','02WilliamByrdSuite.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (396,'E000','2014-11-09','Crown Imperial March','Austin Civic Wind Ensemble','03CrownImperial.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (397,'E000','2014-11-09','Danzon','Austin Civic Wind Ensemble','04Danzon.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (398,'E000','2014-11-09','Four Scottish Dances','Austin Civic Wind Ensemble','05FourScottishDances.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (399,'E000','2014-11-09','Kalinnikov Symphony No 1 (4th movement)','Austin Civic Wind Ensemble','06KalinnikovSymph1-Mvt4.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (400,'X026','2014-12-19','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (401,'E000','2014-12-19','Cantique de Noel','Austin Civic Wind Ensemble','02CantiqueNoel.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (402,'E000','2014-12-19','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','03FantasyonBellCarol.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (403,'E000','2014-12-19','Up on a Housetop','Austin Civic Wind Ensemble','04UponaHousetop.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (404,'E000','2014-12-19','Fum Fum Fum','Austin Civic Wind Ensemble','06FumFumFum.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (405,'E000','2014-12-19','Carol of the Drum','Austin Civic Wind Ensemble','07CaroloftheDrum.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (406,'E000','2014-12-19','Train Ride','Austin Civic Wind Ensemble','08TrainRide.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (407,'E000','2014-12-19','Twas the Nigh Before Christmas','Austin Civic Wind Ensemble','09NightBeforeChristmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (408,'E000','2014-12-19','Sleigh Ride','Austin Civic Wind Ensemble','10SleighRide.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (409,'E000','2014-12-19','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','11Grinch.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (410,'E000','2014-12-19','Jingle Bells Forever','Austin Civic Wind Ensemble','12JingleBellsForever.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (411,'E000','2014-12-19','Joy to the World','Austin Civic Wind Ensemble','13JoytotheWorld.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (412,'E000','2014-12-19','Good King Winceslas','Austin Civic Wind Ensemble','14GoodKingWenceslas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (413,'E000','2014-12-19','Lo, How a Rose','Austin Civic Wind Ensemble','15LoHowaRose.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (414,'E000','2014-12-19','Patapan','Austin Civic Wind Ensemble','16PataPan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (415,'E000','2014-12-19','What Child is This','Austin Civic Wind Ensemble','17WhatChildisThis.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (416,'C310','2015-05-10','Festive Overture','Austin Civic Wind Ensemble','01FestiveOverture.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Shostakovich, Dimitri','Hunsberger, Donald',1);
INSERT INTO `recordings_old` VALUES (417,'E000','2015-05-10','Divertimento for Band','Austin Civic Wind Ensemble','02Divertimento.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Persichetti','',0);
INSERT INTO `recordings_old` VALUES (418,'E000','2015-05-10','Rocky Point Holiday','Austin Civic Wind Ensemble','03RockyPointHoliday.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Ron Nelson','',0);
INSERT INTO `recordings_old` VALUES (419,'E000','2015-05-10','An American in Paris','Austin Civic Wind Ensemble','04AmericaninParis.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Gershwin','',0);
INSERT INTO `recordings_old` VALUES (420,'E000','2015-05-10','Finale from Symphony No. 5','Austin Civic Wind Ensemble','05Shostakovich5-4.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Shostakovich','',0);
INSERT INTO `recordings_old` VALUES (421,'E000','2015-05-10','Melody Shop','Austin Civic Wind Ensemble','06MelodyShop.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','Karl King','',0);
INSERT INTO `recordings_old` VALUES (422,'E000','2015-07-03','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (423,'E000','2015-07-03','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','02EasterMondayontheWhiteHouseLawn.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (424,'E000','2015-07-03','America the Beautiful','Austin Civic Wind Ensemble','03America.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (425,'E000','2015-07-03','Brookes Chicago Marine Band March','Austin Civic Wind Ensemble','04BrooksMarineBandMarch.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (426,'E000','2015-07-03','Cora is Gone','Austin Civic Wind Ensemble','05CoraisGone.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (427,'E000','2015-07-03','American Riversongs','Austin Civic Wind Ensemble','06AmericanRiverSong.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (428,'E000','2015-07-03','The Girl I Left Behind','Austin Civic Wind Ensemble','07GirlILeftBehindMe.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (429,'E000','2015-07-03','Washington Post','Austin Civic Wind Ensemble','08WashingtonPost.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (430,'E000','2015-07-03','El Capitan','Austin Civic Wind Ensemble','09ElCapitan.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (431,'E000','2015-07-03','National Emblem','Austin Civic Wind Ensemble','10NationalEmblem.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (432,'C335','2015-07-03','1812 Overture','Austin Civic Wind Ensemble','11-1812.mp3','','St. Louis King of France Catholic Church','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (433,'E000','2015-07-03','Stars and Stripes Forever','Austin Civic Wind Ensemble','12Stars+Stripes.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (434,'E000','2015-11-08','Verdi Requiem','Austin Civic Wind Ensemble','01VerdiRequiem.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (435,'E000','2015-11-08','Anthems - 1','Austin Civic Wind Ensemble','02Anthems1.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (436,'E000','2015-11-08','Anthems - 2','Austin Civic Wind Ensemble','03Anthems2.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (437,'E000','2015-11-08','Anthems - 3','Austin Civic Wind Ensemble','04Anthems3.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (438,'E000','2015-11-08','Dance Macabre','Austin Civic Wind Ensemble','05DanceMacabre.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (439,'E000','2015-11-08','Aurora Borealis','Austin Civic Wind Ensemble','06AuroraBorealis.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (440,'E000','2015-11-08','Parody','Austin Civic Wind Ensemble','07Parody.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (441,'E000','2015-11-08','El Relicario','Austin Civic Wind Ensemble','08ElRelicario.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (442,'X026','2015-12-13','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (443,'E000','2015-12-13','Patapan','Austin Civic Wind Ensemble','02PataPan.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (444,'E000','2015-12-13','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','03Grinch.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (445,'E000','2015-12-13','Have Yourself a Merry Little Christmas','Austin Civic Wind Ensemble','04HaveYourselfaMerryLittleXmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (446,'E000','2015-12-13','Cantique de Noel','Austin Civic Wind Ensemble','05CantiqueduNoel.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (447,'E000','2015-12-13','Greensleeves','Austin Civic Wind Ensemble','06Greensleeves.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (448,'E000','2015-12-13','Carol of the Drum','Austin Civic Wind Ensemble','07CaroloftheDrum.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (449,'E000','2015-12-13','Minor Alterations','Austin Civic Wind Ensemble','08MinorAlterations.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (450,'E000','2015-12-13','Stars and Stripes for Christmas','Austin Civic Wind Ensemble','09Stars+StripesforChristmas.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (451,'E000','2016-05-06','La Procession du Rocio','Austin Civic Wind Ensemble','01LaProcessionduRocio.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (452,'E000','2016-05-06','Don Quixote - 1 The Quest','Austin Civic Wind Ensemble','02DonQuixote-1TheQuest.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (453,'E000','2016-05-06','Don Quixote - 2 Dulcinea','Austin Civic Wind Ensemble','03DonQuixote-2Dulcinea.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (454,'E000','2016-05-06','Don Quixote - 3 Sancho & the Windmills','Austin Civic Wind Ensemble','04DonQuixote-3Sancho_Windmills.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (455,'E000','2016-05-06','Don Quixote - 4 The Illumination','Austin Civic Wind Ensemble','05DonQuixote-4TheIllumination.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (456,'E000','2016-05-06','Ritual Fire Dance','Austin Civic Wind Ensemble','06RitualFireDance.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (457,'E000','2016-05-06','Adagio para Orquestra de Insturmentos de Viento','Austin Civic Wind Ensemble','07AdagioparaOrquestradeInsturmentosdeViento.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (458,'E000','2016-05-06','Flashing Eyes of Andalusia','Austin Civic Wind Ensemble','08FlashingEyesofAndalusia.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (459,'E000','2016-05-06','Adagio from Cto de Aranjuez','Austin Civic Wind Ensemble','09Aranjuez.mp3','','Dougherty Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (460,'E000','2016-07-01','The Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (461,'E000','2016-07-01','Pineapple Poll mvt. 1','Austin Civic Wind Ensemble','02PineapplePoll-1.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (462,'E000','2016-07-01','Joyce\'s 71st Regimental March','Austin Civic Wind Ensemble','03Joyces71stRegimentalMarch.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (463,'E000','2016-07-01','Eternal Father','Austin Civic Wind Ensemble','04EternalFather.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (464,'E000','2016-07-01','Pineapple Poll mvts. 2,3','Austin Civic Wind Ensemble','05PineapplePoll-2_3.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (465,'E000','2016-07-01','Brookes Chicago Marine Band March','Austin Civic Wind Ensemble','06BrookesChicagoMarineBandMarch.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (466,'E000','2016-07-01','Bravura','Austin Civic Wind Ensemble','07Bravura.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (467,'E000','2016-07-01','The Girl I Left Behind Me','Austin Civic Wind Ensemble','08GirlILeftBehindMe.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (468,'E000','2016-07-01','Pineapple Poll mvt. 4','Austin Civic Wind Ensemble','09PineapplePoll-4.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (469,'E000','2016-07-01','America the Beautiful','Austin Civic Wind Ensemble','10AmericatheBeautiful.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (470,'C335','2016-07-01','1812 Overture','Austin Civic Wind Ensemble','1812-StLouis.mp3','','St. Louis King of France Catholic Church','Tchaikovsky, Peter','Lake, Mayhew L.',0);
INSERT INTO `recordings_old` VALUES (471,'E000','2016-07-01','Stars and Stripes Forever','Austin Civic Wind Ensemble','12Stars_Stripes.mp3','','St. Louis King of France Catholic Church','John Philip Sousa','',0);
INSERT INTO `recordings_old` VALUES (472,'E000','2016-10-28','Mars from The Planets','Austin Civic Wind Ensemble','01Mars.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (473,'E000','2016-10-28','Death by Tango','Austin Civic Wind Ensemble','02DeathbyTango.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (474,'E000','2016-10-28','Rhapsody in Blue','Austin Civic Wind Ensemble','03RhapsodyinBlue.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (475,'E000','2016-10-28','Grand Seranade for an Awful Lot of Winds and Percussion','Austin Civic Wind Ensemble','04GrandSeranade.mp3','','St. Louis King of France Catholic Church','','',0);
INSERT INTO `recordings_old` VALUES (476,'E000','2016-10-28','The Klaxon','Austin Civic Wind Ensemble','05Klaxon.mp3','','St. Louis King of France Catholic Church','Henry Fillmore','',0);
INSERT INTO `recordings_old` VALUES (477,'E000','2016-10-29','Mars','Austin Civic Wind Ensemble','01Mars_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (478,'E000','2016-10-29','Death by Tango','Austin Civic Wind Ensemble','02DeathbyTango_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (479,'E000','2016-10-29','Original Dixieland Concerto','Austin Civic Wind Ensemble','03OriginalDixielandConcerto.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (480,'E000','2016-10-29','Rhapsody in Blue','Austin Civic Wind Ensemble','04RhapsodyinBlue_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (481,'E000','2016-10-29','Grand Serenade for an Awful Lot of Winds and Percussion','Austin Civic Wind Ensemble','05GrandSerenade.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (482,'E000','2016-10-29','The Klaxon','Austin Civic Wind Ensemble','06Klaxon.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (483,'X026','2016-12-11','Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival_1.mp3','','Episcopal Church of the Resurrection','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (484,'E000','2016-12-11','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','02FantasyonaBellCarol.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (485,'E000','2016-12-11','Carol of the Drum','Austin Civic Wind Ensemble','03CaroloftheDrum.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (486,'E000','2016-12-11','Christmas Song','Austin Civic Wind Ensemble','04ChristmasSong.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (487,'E000','2016-12-11','Cantique du Noel','Austin Civic Wind Ensemble','05CantiqueduNoel.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (488,'E000','2016-12-11','The Grinch Who Stole Christmas','Austin Civic Wind Ensemble','06Grinch.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (489,'E000','2016-12-11','Have Yourself a Merry Little Christmas','Austin Civic Wind Ensemble','07HaveYourselfaMerryXmas.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (490,'E000','2016-12-11','Minor Alterations','Austin Civic Wind Ensemble','08MinorAlterations.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (491,'E000','2016-12-11','Pat a Pan','Austin Civic Wind Ensemble','09PataPan.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (492,'E000','2016-12-11','Baby it\'s Cold Outside','Austin Civic Wind Ensemble','10BabyitsColdOutside.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (493,'E000','2016-12-11','Russian Christmas Music','Austin Civic Wind Ensemble','11RussianChristmas.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (494,'E000','2016-12-11','Sleigh Ride','Austin Civic Wind Ensemble','12SleighRide_1.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (495,'E000','2016-12-11','Jingle Bells Forever','Austin Civic Wind Ensemble','13JingleBellsForever.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (496,'E000','2016-12-11','Joy to the World','Austin Civic Wind Ensemble','14JoytotheWorld.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (497,'E000','2017-05-12','Molly on the Shore','Austin Civic Wind Ensemble','01Molly_on_the_Shore_-_incomplete.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (498,'E000','2017-05-12','Sea Chanteys - Salts and Sails','Austin Civic Wind Ensemble','02Sea_Chanteys_-_Salts_and_Sails.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (499,'E000','2017-05-12','Sea Chanteys – Buccaneers\' Regatta','Austin Civic Wind Ensemble','03Sea_Chanteys_-Buccaneers_Regatta.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (500,'E000','2017-05-12','Fontane di Roma','Austin Civic Wind Ensemble','04Fontane_di_Roma.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (501,'E000','2017-05-12','Water Fanfare','Austin Civic Wind Ensemble','05Water_Fanfare.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (502,'E000','2017-05-12','Dancing on Water','Austin Civic Wind Ensemble','06Dancing_on_Water.mp3','','The PAC at AISD','Frank Ticheli','',0);
INSERT INTO `recordings_old` VALUES (503,'E000','2017-05-12','In Storm and Sunshine','Austin Civic Wind Ensemble','07In_Storm_and_Sunshine.mp3','','The PAC at AISD','','',0);
INSERT INTO `recordings_old` VALUES (504,'E000','2017-05-12','The Klaxon','Austin Civic Wind Ensemble','08The_Klaxon.mp3','','The PAC at AISD','Henry Fillmore','',0);
INSERT INTO `recordings_old` VALUES (505,'E000','2017-07-02','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner_1.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (506,'E000','2017-07-02','Poet and the Peasant Overture','Austin Civic Wind Ensemble','02Poet_Peasant.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (507,'E000','2017-07-02','Circus Days','Austin Civic Wind Ensemble','03CircusDays.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (508,'E000','2017-07-02','Liberty Fanfare','Austin Civic Wind Ensemble','04LibertyFanfare.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (509,'E000','2017-07-02','America the Beautiful','Austin Civic Wind Ensemble','05AmericatheBeautiful.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (510,'E000','2017-07-02','The Girl I Left Behind Me','Austin Civic Wind Ensemble','06GirlILeftBehindMe.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (511,'E000','2017-07-02','Monkey Business','Austin Civic Wind Ensemble','07MonkeyBusiness.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (512,'E000','2017-07-02','Shenandoah','Austin Civic Wind Ensemble','08Shenandoah.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (513,'E000','2017-07-02','Clear Track','Austin Civic Wind Ensemble','09ClearTrack.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (514,'E000','2017-07-02','Barnum and Bailey\'s Favorite','Austin Civic Wind Ensemble','10BarnumsFavorite.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (515,'E000','2017-07-02','Stars and Stripes Forever','Austin Civic Wind Ensemble','11Stars_Stripes.mp3','','Westminster','','',0);
INSERT INTO `recordings_old` VALUES (516,'E000','2017-10-20','March of the Pan Americans','Austin Civic Wind Ensemble','01MarchofthePanAmericans.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (517,'E000','2017-10-20','Cuban Overture','Austin Civic Wind Ensemble','02CubanOverture.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (518,'E000','2017-10-20','Aquatica','Austin Civic Wind Ensemble','03Aquatica.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (519,'E000','2017-10-20','Danzas Cubanas','Austin Civic Wind Ensemble','04DanzasCubanas.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (520,'E000','2017-10-20','Seis Manuel','Austin Civic Wind Ensemble','05SeisManuel.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (521,'E000','2017-10-20','Latin American Dances 2','Austin Civic Wind Ensemble','06LatinAmericanDances2.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (522,'E000','2017-10-20','Pan American March','Austin Civic Wind Ensemble','07PanAmericanMarch.mp3','','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (523,'E000','2017-10-29','March of the Pan Americans','Austin Civic Wind Ensemble','01MarchofthePanAmericans_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (524,'E000','2017-10-29','Cuban Overture','Austin Civic Wind Ensemble','02CubanOverture_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (525,'E000','2017-10-29','Aquatica','Austin Civic Wind Ensemble','03Aquatica_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (526,'E000','2017-10-29','Danzas Cubanas','Austin Civic Wind Ensemble','04DanzasCubanas_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (527,'E000','2017-10-29','Seis Manuel','Austin Civic Wind Ensemble','05SeisManuel_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (528,'E000','2017-10-29','Latin American Dances 2','Austin Civic Wind Ensemble','06LatinAmericanDances2_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (529,'E000','2017-10-29','Pan American March','Austin Civic Wind Ensemble','07PanAmericanMarch_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (530,'E001','2017-12-10','Somewhere in my Memory','Cosmic Clarinets','01SomewhereinmyMemory.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (531,'E001','2017-12-10','Echo Carol – Once in David\'s Royal City','ACWE Trombone Choir','02EchoCarol-OnceinDavidsRoyalCity.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (532,'E001','2017-12-10','The Grinch Who Stole Christmas','Cosmic Clarinets','03Grinch.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (533,'E001','2017-12-10','Trombone Jingle Bells','ACWE Trombone Choir','04TromboneJingleBells.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (534,'X026','2017-12-10','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','','Episcopal Church of the Resurrection','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (535,'E000','2017-12-10','Karina Kantosky 1','Austin Civic Wind Ensemble','02KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (536,'E000','2017-12-10','The Most Wonderful Time of the Year','Austin Civic Wind Ensemble','03MostWonderfulTime.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (537,'E000','2017-12-10','Karina Kantosky 2','Austin Civic Wind Ensemble','04KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (538,'E000','2017-12-10','Carol of the Drum','Austin Civic Wind Ensemble','05CaroloftheDrum.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (539,'E000','2017-12-10','Karina Kantosky 3','Austin Civic Wind Ensemble','06KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (540,'E000','2017-12-10','The Grinch Who Stole Christmas','Austin Civic Wind Ensemble','07Grinch.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (541,'E000','2017-12-10','Karina Kantosky 4','Austin Civic Wind Ensemble','08KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (542,'E000','2017-12-10','Sleigh Ride','Austin Civic Wind Ensemble','09SleighRide.mp3','','Episcopal Church of the Resurrection','Leroy Anderson','',0);
INSERT INTO `recordings_old` VALUES (543,'E000','2017-12-10','Karina Kantosky 5','Austin Civic Wind Ensemble','10KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (544,'E000','2017-12-10','Fum Fum Fum','Austin Civic Wind Ensemble','11FumFumFum.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (545,'E000','2017-12-10','Karina Kantosky 6','Austin Civic Wind Ensemble','12KarinaTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (546,'E000','2017-12-10','Up on a Housetop','Austin Civic Wind Ensemble','13UponaHousetop.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (547,'E000','2017-12-10','Thomas Stowers','Austin Civic Wind Ensemble','14ThomasTalk.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (548,'E000','2017-12-10','Joy to the World','Austin Civic Wind Ensemble','15JoytotheWorld.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (549,'E000','2017-12-10','Stars and Stripes for Christmas','Austin Civic Wind Ensemble','16StarsandStripesforXmas.mp3','','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (550,'E001','2017-12-17','Dance of the Sugar Plum Fairies','Violet Crown Flute Choir','01DanceoftheSugarPlumFairies.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (551,'E001','2017-12-17','O Come, Emmanuel','ACWE Horn Choir','02OComeEmmanuel.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (552,'E001','2017-12-17','Trepak','Violet Crown Flute Choir','03Trepak.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (553,'E001','2017-12-17','Carol of the Bells','ACWE Horn Choir','04CaroloftheBells.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (554,'E000','2018-05-13','Rising Dragons','Austin Civic Wind Ensemble','01RisingDragons.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (555,'E000','2018-05-13','Prayer for Asia','Austin Civic Wind Ensemble','02PrayerforAsia.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (556,'E000','2018-05-13','Suite from China West Mvmts 2&4','Austin Civic Wind Ensemble','04SuitefromChinaWest.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (557,'E000','2018-05-13','Nessun Dorma','Austin Civic Wind Ensemble','05NessunDorma.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (558,'E000','2018-05-13','Come Drink One More Cup','Austin Civic Wind Ensemble','06ComeDrinkOneMoreCup.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (559,'E000','2018-05-13','Fantasy on a Japanese FolkSong','Austin Civic Wind Ensemble','07FantasyonaJapaneseFolkSong.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (560,'E000','2018-05-13','Dragon Boat Festival','Austin Civic Wind Ensemble','08DragonBoatFestival.mp3','Robert Laguna, conductor','Episcopal Church of the Resurrection','','',0);
INSERT INTO `recordings_old` VALUES (561,'E000','2018-05-18','Rising Dragons','Austin Civic Wind Ensemble','01RisingDragons_1.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (562,'E000','2018-05-18','Prayer for Asia','Austin Civic Wind Ensemble','02PrayerforAsia_1.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (563,'E000','2018-05-18','Variations on a Korean Folk Song','Austin Civic Wind Ensemble','03VariationsonaKoreanFolkSong.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (564,'E000','2018-05-18','Suite from China West Mvmts 2&4','Austin Civic Wind Ensemble','04SuitefromChinaWest_1.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (565,'E000','2018-05-18','Nessun Dorma','Austin Civic Wind Ensemble','05NessunDorma_1.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (566,'E000','2018-05-18','Come Drink One More Cup','Austin Civic Wind Ensemble','06ComeDrinkOneMoreCup_1.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (567,'E000','2018-05-18','Sensei is Riding on the Cherry Blossom Express','Austin Civic Wind Ensemble','07SenseisRideontheCherryBlossomExpress.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (568,'E000','2018-05-18','Fantasy on a Japanese FolkSong','Austin Civic Wind Ensemble','08FantasyonaJapaneseFolkSong.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (569,'E000','2018-05-18','Dragon Boat Festival','Austin Civic Wind Ensemble','09DragonBoatFestival.mp3','Robert Laguna, conductor','Austin ISD Performing Arts Center','','',0);
INSERT INTO `recordings_old` VALUES (570,'E000','2018-10-20','Imperial March from Star Wars','Austin Civic Wind Ensemble','01ImperialMarch.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (571,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','02RobertTalk1.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (572,'E000','2018-10-20','Ta ra ra Boomdeay','Austin Civic Wind Ensemble','03TaRaRaBoomdeay.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (573,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','04RobertTalk2.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (574,'E000','2018-10-20','La gaza Ladra','Austin Civic Wind Ensemble','05LaGazaLadra.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (575,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','06RobertTalk3.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (576,'E000','2018-10-20','Baby Elephant Walk','Austin Civic Wind Ensemble','07BabyElephantWalk.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (577,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','08RobertTalk4.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (578,'E000','2018-10-20','Jaws','Austin Civic Wind Ensemble','09Jaws.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (579,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','10RobertTalk5.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (580,'E000','2018-10-20','Powerhouse','Austin Civic Wind Ensemble','11Powerhouse.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (581,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','12RobertTalk6.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (582,'E000','2018-10-20','Excerpts from Die Walkure','Austin Civic Wind Ensemble','13DieWalkure.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (583,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','14RobertTalk7.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (584,'E000','2018-10-20','Thunder and Blazes','Austin Civic Wind Ensemble','15Thunder_Blazes.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (585,'E000','2018-10-20','Robert Laguna introductions','Austin Civic Wind Ensemble','16RobertTalk8.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (586,'E000','2018-10-20','Colonel Bogey','Austin Civic Wind Ensemble','17ColoneBogey.mp3','Robert Laguna, conductor','Westlake Auditorium at Westlake High School','','',0);
INSERT INTO `recordings_old` VALUES (587,'E000','2018-10-27','Baby Elephant Walk','Austin Civic Wind Ensemble','01BabyElephantWalk.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (588,'E000','2018-10-27','RobertTalk1','Austin Civic Wind Ensemble','02RobertTalk1_1.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (589,'E000','2018-10-27','Jaws','Austin Civic Wind Ensemble','03Jaws.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (590,'E000','2018-10-27','Powerhouse','Austin Civic Wind Ensemble','04Powerhouse.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (591,'E000','2018-10-27','RobertTalk2','Austin Civic Wind Ensemble','05RobertTalk2.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (592,'E000','2018-10-27','Die Walkure','Austin Civic Wind Ensemble','06DieWalkure.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (593,'E000','2018-10-27','RobertTalk3','Austin Civic Wind Ensemble','07RobertTalk3.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (594,'E000','2018-10-27','Thunder and Blazes','Austin Civic Wind Ensemble','08Thunder_Blazes.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (595,'E000','2018-10-27','RobertTalk4','Austin Civic Wind Ensemble','09RobertTalk4.mp3','','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (596,'E000','2018-10-27','Colonel Bogey','Austin Civic Wind Ensemble','10ColonelBogey.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (597,'X026','2018-12-16','Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival_3.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (598,'E000','2018-12-16','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','02FantasyonaBellCarol_1.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (599,'E000','2018-12-16','Pat-A-Pan','Austin Civic Wind Ensemble','03Pat-A-Pan.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (600,'E000','2018-12-16','Do You Hear What I Hear','Austin Civic Wind Ensemble','04DoYouHearWhatIHear.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (601,'E000','2018-12-16','Christmas Song','Austin Civic Wind Ensemble','05ChristmasSong.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (602,'E000','2018-12-16','Cantique du Noel','Austin Civic Wind Ensemble','06CantiqueduNoel.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (603,'E000','2018-12-16','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','07Grinch_1.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (604,'E000','2018-12-16','Have Yourself a Merry Little Christmas','Austin Civic Wind Ensemble','08HaveYourselfaMerryXmas.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (605,'E000','2018-12-16','Sleigh Ride','Austin Civic Wind Ensemble','09SleighRide_1.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (606,'E000','2018-12-16','Train Ride','Austin Civic Wind Ensemble','10TrainRide.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (607,'E000','2018-12-16','Minor Alterations','Austin Civic Wind Ensemble','11MinorAlterations.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (608,'E000','2018-12-16','Jingle Bells Forever','Austin Civic Wind Ensemble','12JingleBellsForever.mp3','Robert Laguna, conductor, Thomas Stowers, Guest conductor, JJ Carter guest conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (609,'E000','2019-05-11','Walking Frog','Austin Civic Wind Ensemble','01WalkingFrog.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (610,'E000','2019-05-11','Nalukataq','Austin Civic Wind Ensemble','02Nalukataq.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (611,'E000','2019-05-11','Carnival of the Animals','Austin Civic Wind Ensemble','03CarnivaloftheAnimals.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (612,'E000','2019-05-11','When the Great Owl Sings','Austin Civic Wind Ensemble','04WhentheGreatOwlSings.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (613,'E000','2019-05-11','Grimm\'s Fairytale Forest','Austin Civic Wind Ensemble','05GrimmsFairytaleForest.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (614,'E000','2019-05-11','Furioso','Austin Civic Wind Ensemble','06Furioso.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (615,'E000','2019-05-11','Our Cast Aways','Austin Civic Wind Ensemble','07OurCastAways.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (616,'E000','2019-05-11','Gallito','Austin Civic Wind Ensemble','08Gallito.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (617,'E000','2019-05-18','Walking Frog','Austin Civic Wind Ensemble','01WalkingFrog_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (618,'E000','2019-05-18','Nalukataq','Austin Civic Wind Ensemble','02Nalukataq_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (619,'E000','2019-05-18','Carnival of the Animals','Austin Civic Wind Ensemble','03CarnivaloftheAnimals_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (620,'E000','2019-05-18','When the Great Owl Sings','Austin Civic Wind Ensemble','04WhentheGreatOwlSings_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (621,'E000','2019-05-18','Grimm\'s Fairytale Forest','Austin Civic Wind Ensemble','05GrimmsFairytaleForest_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (622,'E000','2019-05-18','Furioso','Austin Civic Wind Ensemble','06Furioso_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (623,'E000','2019-05-18','Our Cast Aways','Austin Civic Wind Ensemble','07OurCastAways_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (624,'E000','2019-05-18','Gallito','Austin Civic Wind Ensemble','08Gallito_1.mp3','Robert Laguna, conductor','Rollins Theater at the Long Center','','',0);
INSERT INTO `recordings_old` VALUES (625,'E000','2019-07-07','Fanfare for the Common Man','Austin Civic Wind Ensemble','01FanfarefortheCommonMan.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (626,'C101','2019-07-07','The Star Spangled Banner','Austin Civic Wind Ensemble','02StarSpangledBanner.mp3','Robert Laguna, conductor','Unity Church of the Hills','','Williams, John',0);
INSERT INTO `recordings_old` VALUES (627,'C188','2019-07-07','American Civil War Fantasy','Austin Civic Wind Ensemble','03AmericanCivilWarFantasy.mp3','Robert Laguna, conductor','Unity Church of the Hills','Bilik, Jerry H.','',0);
INSERT INTO `recordings_old` VALUES (628,'M407','2019-07-07','Melody Shop','Austin Civic Wind Ensemble','04MelodyShop.mp3','Robert Laguna, conductor','Unity Church of the Hills','King','Glover',0);
INSERT INTO `recordings_old` VALUES (629,'E000','2019-07-07','Shoutin Liza Trombone','Austin Civic Wind Ensemble','05ShoutinLiza.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (630,'E000','2019-07-07','Poet and Peasant Overture','Austin Civic Wind Ensemble','06PoetandPeasantOverture.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (631,'E000','2019-07-07','Buglers Holiday','Austin Civic Wind Ensemble','07BuglersHoliday.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (632,'M001','2019-07-07','In Storm and Sunshine','Austin Civic Wind Ensemble','08StormandSunshine.mp3','Robert Laguna, conductor','Unity Church of the Hills','Heed, J.C.','',1);
INSERT INTO `recordings_old` VALUES (633,'E000','2019-07-07','Battle Hymn of the Republic','Austin Civic Wind Ensemble','09BattleHymnoftheRepublic.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (634,'E000','2019-07-07','King Cotton','Austin Civic Wind Ensemble','10KingCotton.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (635,'E000','2019-07-07','America the Beautiful','Austin Civic Wind Ensemble','11AmericatheBeautiful.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (636,'E000','2019-07-07','The Stars and Stripes Forever','Austin Civic Wind Ensemble','12StarsandStripesForever.mp3','Robert Laguna, conductor','Unity Church of the Hills','','',0);
INSERT INTO `recordings_old` VALUES (637,'C039','2019-10-26','Peter and the Wolf Triumphal March','Austin Civic Wind Ensemble','01PeterandtheWolfMarch.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Prokofieff, Sergei','Goldman, Richard Franko',0);
INSERT INTO `recordings_old` VALUES (638,'C607','2019-10-26','A Boy\'s Dream','Austin Civic Wind Ensemble','02ABoysDream.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Bocook, Jay','',0);
INSERT INTO `recordings_old` VALUES (639,'C225','2019-10-26','Syncopated Clock','Austin Civic Wind Ensemble','03SyncopatedClock.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Anderson, Leroy','',0);
INSERT INTO `recordings_old` VALUES (640,'C608','2019-10-26','Sleep My Child','Austin Civic Wind Ensemble','04SleepMyChild.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Whitacre, Eric','Gershman, Jeffrey',0);
INSERT INTO `recordings_old` VALUES (641,'C500','2019-10-26','La Tragenda','Austin Civic Wind Ensemble','05LaTragenda.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Puccini','Foster',0);
INSERT INTO `recordings_old` VALUES (642,'C609','2019-10-26','The Monster Under the Bed','Austin Civic Wind Ensemble','06MonsterUndertheBed.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Robert Sheldon','',0);
INSERT INTO `recordings_old` VALUES (643,'C044','2019-10-26','Elsa\'s Procession to the Cathedral','Austin Civic Wind Ensemble','07ElsasProcession.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Wagner, Richard','Cailliet, Lucien',0);
INSERT INTO `recordings_old` VALUES (644,'C479','2019-10-26','Der Traum des Oenghus','Austin Civic Wind Ensemble','08TraumdesOenghus.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Rudin','',0);
INSERT INTO `recordings_old` VALUES (645,'C128','2019-10-26','Children\'s March','Austin Civic Wind Ensemble','09ChildrensMarch.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Grainger, Percy Aldridge','Erickson, Frank',1);
INSERT INTO `recordings_old` VALUES (646,'X026','2019-12-15','Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (647,'X049','2019-12-15','Greensleeves','Austin Civic Wind Ensemble','02Greensleeves.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Traditional','Reed, Alfred',1);
INSERT INTO `recordings_old` VALUES (648,'E000','2019-12-15','The Most Wonderful Time of the Year','Austin Civic Wind Ensemble','03MostWonderfulTimeoftheYear.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (649,'E000','2019-12-15','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','04HowtheGrinchStoleChristmas.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (650,'E000','2019-12-15','Patapan','Austin Civic Wind Ensemble','05Patapan.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (651,'E000','2019-12-15','Carol of the Drum','Austin Civic Wind Ensemble','06CaroloftheDrum.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (652,'X009','2019-12-15','Sleigh Ride','Austin Civic Wind Ensemble','07SleighRide.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Anderson, Leroy','',0);
INSERT INTO `recordings_old` VALUES (653,'C504','2019-12-15','Fum Fum Fum','Austin Civic Wind Ensemble','08FumFumFum.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','Davis, Chip',0);
INSERT INTO `recordings_old` VALUES (654,'X050','2019-12-15','Up On a Housestop','Austin Civic Wind Ensemble','09UpOnaHousetop.mp3','Robert Laguna, conductor','Covenant United Methodist Church','Traditional','J. Simmons',0);
INSERT INTO `recordings_old` VALUES (655,'E000','2019-12-15','Stars and Stripes for Christmas','Austin Civic Wind Ensemble','10StarsandStripesforChristmas.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (656,'E000','2019-12-15','Variations on a French Carol','Austin Civic Wind Ensemble','11VariationsonaFrenchCarol.mp3','Robert Laguna, conductor','Covenant United Methodist Church','','',0);
INSERT INTO `recordings_old` VALUES (657,'C643','2022-06-28','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner-Bell.mp3','Thomas Stowers, conductor','Westminster Manor Hall','','',1);
INSERT INTO `recordings_old` VALUES (658,'C489','2022-06-28','The Inferno (from The Devine Comedy)','Austin Civic Wind Ensemble','02Inferno-Ascension.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','','',1);
INSERT INTO `recordings_old` VALUES (659,'M029','2022-06-28','Barnum and Bailey\'s Favorite','Austin Civic Wind Ensemble','03Barnum+BaileysFavorite.mp3','','Westminster Manor Bates Hall','King, Karl','',1);
INSERT INTO `recordings_old` VALUES (660,'M082','2022-06-28','The Crosley March','Austin Civic Wind Ensemble','04Crosley.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','Fillmore, Henry 	','',1);
INSERT INTO `recordings_old` VALUES (661,'M058','2022-06-28','The Klaxon','Austin Civic Wind Ensemble','06Klaxon.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (662,'M002','2022-06-28','Man of the Hour','Austin Civic Wind Ensemble','07ManofHonor.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (663,'C410','2022-06-28','Hosts of Freedom','Austin Civic Wind Ensemble','08HostsofFreedom.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','King, Karl L.','',1);
INSERT INTO `recordings_old` VALUES (664,'M089','2022-06-28','King Cotton','Austin Civic Wind Ensemble','09KingCotton.mp3','Thomas Stowers, conductor','Westminster Manor Bates Hall','Sousa, John Philip','',1);
INSERT INTO `recordings_old` VALUES (665,'M422','2022-06-28','Official West Point March','Austin Civic Wind Ensemble','10OfficialWestPointMarch.mp3','Conducted by Thomas Stowers','Westminster Manor Bates Hall','Egner, Philip','',1);
INSERT INTO `recordings_old` VALUES (666,'C398','2022-06-28','National Emblem','Austin Civic Wind Ensemble','11NationalEmblem.mp3','Conducted by Thomas Stowers','Westminster Manor Bates Hall','Bagley, E. E.','',1);
INSERT INTO `recordings_old` VALUES (667,'M088','2022-06-28','Stars and Stripes Forever','Austin Civic Wind Ensemble','13Stars+Stripes.mp3','Conducted by Thomas Stowers','Westminster Manor Bates Hall','Sousa, John Philip','',1);
INSERT INTO `recordings_old` VALUES (668,'C647','2022-10-30','Lodestar Fanfare','Austin Civic Wind Ensemble','01LodestarFanfare.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Saucedo, Richard L.','',1);
INSERT INTO `recordings_old` VALUES (669,'C003','2022-10-30','Incantation and Dance - John Barnes Chance','Austin Civic Wind Ensemble','02IncantationandDance.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Chance, John Barnes','',1);
INSERT INTO `recordings_old` VALUES (670,'C644','2022-10-30','Arabesque','Austin Civic Wind Ensemble','03Arabesque.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Hazo, Samuel R.','',1);
INSERT INTO `recordings_old` VALUES (671,'C476','2022-10-30','The Witch and the Saint','Austin Civic Wind Ensemble','04WitchandtheSaint.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Reineke, S','',1);
INSERT INTO `recordings_old` VALUES (672,'C646','2022-10-30','Music for a Darkened Theater','Austin Civic Wind Ensemble','05MusicforaDarkenedTheatre.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Elfman, Danny','Brown, Michael',1);
INSERT INTO `recordings_old` VALUES (673,'C648','2022-10-30','Inspector Clouseau Theme','Austin Civic Wind Ensemble','06InspectorClouseauTheme.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Mancini, Henri','Kazik, James',1);
INSERT INTO `recordings_old` VALUES (674,'C649','2022-10-30','Songs of Earth, Water, Fire, and Sky','Austin Civic Wind Ensemble','07SongsofEarthWaterFire+Sky.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Smith, Robert W.','',1);
INSERT INTO `recordings_old` VALUES (675,'C645','2022-10-30','LOL','Austin Civic Wind Ensemble','08LOL.flac','Recorded at Covenant United Methodist Church, Robert Laguna, conductor.','Unknown location','Buckley, Robert','',1);
INSERT INTO `recordings_old` VALUES (676,'X026','2022-12-18','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.flac','Thomas Stowers, conductor','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (677,'X017','2022-12-18','White Christmas','Austin Civic Wind Ensemble','03WhiteChristmas.flac','Thomas Stowers, conductor','Covenant United Methodist Church','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (678,'X012','2022-12-18','I\'ll be home for Christmas','Austin Civic Wind Ensemble','04IllBeHomeForChristmas.flac','Thomas Stowers, conductor','Covenant United Methodist Church','Gannon, Kim','Kent, Walter',1);
INSERT INTO `recordings_old` VALUES (679,'X011','2022-12-18','The Christmas Song','Austin Civic Wind Ensemble','05ChristmasSong.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Mel Torme and Robert Wells','Cacavas, John',1);
INSERT INTO `recordings_old` VALUES (680,'Z001','2022-12-18','Comments 1','Austin Civic Wind Ensemble','01Comments1.flac','Kalyn Cordova, ACWE Board President','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (681,'Z001','2022-12-18','Comments 2','Austin Civic Wind Ensemble','06Comments2.flac',' Kalyn Cordova, ACWE Board President','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (682,'Z001','2022-12-18','Concertino, Op. 26','Austin Civic Wind Ensemble','07WeberConcertino.flac','Devin Hillery, clarinet','Covenant United Methodist Church','Maria von Weber, Caril','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (683,'X019','2022-12-18','Russian Christmas Music','Austin Civic Wind Ensemble','09RussianChristmasMusic.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Reed, Alfred','',1);
INSERT INTO `recordings_old` VALUES (684,'Z001','2022-12-18','Comments 3','Austin Civic Wind Ensemble','08Comments3.flac','Kalyn Cordova, ACWE Board President','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (685,'Z001','2022-12-18','Comments 4','Austin Civic Wind Ensemble','10Comments4.flac','President - Kalyn Cordova','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (686,'X033','2022-12-18','Canadian Brass Christmas','Austin Civic Wind Ensemble','11CanadianBrassChristmas.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Various','Luther Henderson and Howard Cable',1);
INSERT INTO `recordings_old` VALUES (687,'X002','2022-12-18','Christmas Recollections','Austin Civic Wind Ensemble','12ChristmasRecollections.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Various','Edmondson, John',1);
INSERT INTO `recordings_old` VALUES (688,'Z001','2022-12-18','Comments 5','Austin Civic Wind Ensemble','13Comments5.flac','President - Kalyn Cordova','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (689,'X038','2022-12-18','The Grinch','Austin Civic Wind Ensemble','14Grinch.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Haugue, Albert','Clark, Larry',1);
INSERT INTO `recordings_old` VALUES (690,'X030','2022-12-18','Joyful Christmas','Austin Civic Wind Ensemble','15JoyfulChristmas.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Various','Swearingen, James',1);
INSERT INTO `recordings_old` VALUES (691,'Z001','2022-12-18','Comments 6','Austin Civic Wind Ensemble','16Comments6.flac','Kayln Cordova, ACWE Board President','Covenant United Methodist Church','Anonymous','',1);
INSERT INTO `recordings_old` VALUES (692,'X009','2022-12-18','Sleigh Ride','Austin Civic Wind Ensemble','17SleighRide.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (693,'X060','2022-12-18','Joy to the World','Austin Civic Wind Ensemble','18JoytotheWorld.flac','Thomas Stowers, Conductor','Covenant United Methodist Church','Traditional','Bell, Michael',1);
INSERT INTO `recordings_old` VALUES (694,'C246','2023-05-20','Fanfare for the Common Man','Austin Civic Wind Ensemble','01FanfarefortheCommonMan_1.mp3',' Robert Laguna conductor, concert May 20, 2023 at Dougherty Arts Center','Dougherty Arts Center','Copland, Aaron','',1);
INSERT INTO `recordings_old` VALUES (695,'C202','2023-05-20','Overture to Candide','Austin Civic Wind Ensemble','02CandideOverture.mp3',' Robert Laguna conductor, concert May 20, 2023 at Dougherty Arts Center','Dougherty Arts Center','Bernstein, Leonard','Grundman, Clare',1);
INSERT INTO `recordings_old` VALUES (696,'X026','2023-12-17','A Christmas Festival','Austin Civic Wind Ensemble','01ChristmasFestival.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (697,'E000','2023-12-17','Minor Alterations Part 2','Austin Civic Wind Ensemble','02MinorAlterations2.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Lovrien, David','',1);
INSERT INTO `recordings_old` VALUES (698,'X001','2023-12-17','Themes from the Nutcracker Suite','Austin Civic Wind Ensemble','03NutcrackerThemes.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Tschaikowsky, P I','Johnson, Clair W.',1);
INSERT INTO `recordings_old` VALUES (699,'C502','2023-12-17','March of the Toys','Austin Civic Wind Ensemble','04MarchoftheToys.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Herbert, V','Clarke, Langey',1);
INSERT INTO `recordings_old` VALUES (700,'X007','2023-12-17','Do You Hear What I Hear?','Austin Civic Wind Ensemble','05DoYouHearWhatIHear.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Regney, Shayne, Towne, Kent and Jones','Cacavas, John',1);
INSERT INTO `recordings_old` VALUES (701,'X004','2023-12-17','Carol of the Drum','Austin Civic Wind Ensemble','06CaroloftheDrum.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Davis, Katherine K','Werle, Floyd E.',1);
INSERT INTO `recordings_old` VALUES (702,'X007','2023-12-17','A Fireside Christmas','Austin Civic Wind Ensemble','07FiresideChristmas.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Various','Nestico, Sammy',1);
INSERT INTO `recordings_old` VALUES (703,'X038','2023-12-17','How the Grinch Stole Christmas','Austin Civic Wind Ensemble','08GrinchWhoStoleChristmas.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Haugue, Albert','Clark, Larry',1);
INSERT INTO `recordings_old` VALUES (704,'X015','2023-12-17','Twas the night before Christmas','Austin Civic Wind Ensemble','09NightBeforeChristmas.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Moore, Clement C','Long, Newell H',1);
INSERT INTO `recordings_old` VALUES (705,'C455','2023-12-17','Train Ride from Winter Holiday','Austin Civic Wind Ensemble','10TrainRide.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Prokofeiff, Sergei','Cable, Howard',1);
INSERT INTO `recordings_old` VALUES (706,'X009','2023-12-17','Sleigh Ride','Austin Civic Wind Ensemble','11SleighRide.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (707,'X029','2023-12-17','Jingle Bells Forever','Austin Civic Wind Ensemble','12JingleBellsForever.mp3','Austin Civic Wind Ensemble, Thomas Stowers, conductor. Concert December 17, 2023 at Covenant United Methodist Church','Covenant United Methodist Church','J Pierpont, J P Sousa','Smith, Robert W ',1);
INSERT INTO `recordings_old` VALUES (708,'C397','2023-12-17','O Magnum Mysterium','ACWE Horn Choir','HornChoir-OMagnumMysterium.mp3','','Covenant United Methodist Church','Lauridsen, Morten','Reynolds, Robert H.',1);
INSERT INTO `recordings_old` VALUES (709,'X023','2023-12-10','Hallelujah Chorus','ACWE Trombone Choir','TboneChoir-HallelujahChorus.mp3','','Unity Church of the Hills','Handel, George Frederick','Chiffarelli, A.',1);
INSERT INTO `recordings_old` VALUES (710,'E001','2023-12-10','Jingle Bells','ACWE Trombone Choir','TboneChoir-JingleBells.mp3','Contains things like the Dredle Song and Stars and Stripes Forever','Unity Church of the Hills','Unknown','',1);
INSERT INTO `recordings_old` VALUES (711,'EC013','2023-12-10','Carol of the Bells','Violet Crown Flute Choir','VioletCrown-CaroloftheBells.mp3','','Unity Church of the Hills','Traditional','Pentatonix',0);
INSERT INTO `recordings_old` VALUES (712,'EF045','2023-12-10','Jingle Bell Rock','Violet Crown Flute Choir','VioletCrown-JingleBellRock.mp3','','Unity Church of the Hills','Beal, Joe  Boothe, Jim','Lombardo, Ricky',1);
INSERT INTO `recordings_old` VALUES (713,'M021','2024-05-11','El Capitan','Austin Civic Wind Ensemble','07ElCapitan.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','Sousa','',1);
INSERT INTO `recordings_old` VALUES (714,'E000','2024-05-11','Smetana Fanfare','Austin Civic Wind Ensemble','01SmetanaFanfare.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','Husel, Karel','',1);
INSERT INTO `recordings_old` VALUES (715,'C623','2024-05-11','Symphony No. 1, Lord of the Rings, Mvt 1. Gandolf (The Wizard)','Austin Civic Wind Ensemble','02LoR-1Gandolf.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (716,'C624','2024-05-11','Symphony No. 1, Lord of the Rings, Mvt 2. Lothlorien (The Elvenwood)','Austin Civic Wind Ensemble','03LoR-2Lothlorien.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (717,'C625','2024-05-11','Symphony No. 1, Lord of the Rings, Mvt 3. Gollum (SmÃ©agol)','Austin Civic Wind Ensemble','04LoR-3Gollum.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (718,'C626','2024-05-11','Symphony No. 1, Lord of the Rings, Mvt 4. Journey in the Dark','Austin Civic Wind Ensemble','05LoR-4JourneyintheDark.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (719,'C627','2024-05-11','Symphony No. 1, Lord of the Rings, Mvt 5. Hobbits','Austin Civic Wind Ensemble','06LoR-5Hobbits.flac','From a live recording in the Draylen Mason Studios at KMFA radio. Directed by Robert Laguna on May 11, 2024.','Draylen Mason Studios, KMFA','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (720,'E000','2024-05-19','Smetana Fanfare','Austin Civic Wind Ensemble','01SmetenaFanfare.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','Husa, Karel','',1);
INSERT INTO `recordings_old` VALUES (721,'C623','2024-05-19','Movement 1: Gandolf','Austin Civic Wind Ensemble','02LoR-1Gandolf.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (722,'C624','2024-05-19','Movement 2: Lothlorien','Austin Civic Wind Ensemble','03LoR-2Lothlorien.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (723,'C625','2024-05-19','Movement 3: Gollum','Austin Civic Wind Ensemble','04LoR-3Gollum.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (724,'C626','2024-05-19','Movement 4: Journey in the Dark','Austin Civic Wind Ensemble','05LoR-4JourneyinthDark.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (725,'C627','2024-05-19','Movement 5: Hobbits','Austin Civic Wind Ensemble','06LoR-5Hobbits.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','de Meij, Johan','',1);
INSERT INTO `recordings_old` VALUES (726,'M021','2024-05-19','El Capitan','Austin Civic Wind Ensemble','07ElCapitan.flac','Austin Civic Wind Ensemble, Robert Laguna conductor, concert May 19, 2024 at Bates Recital Hall','Bates Recital Hall','Sousa','',1);
INSERT INTO `recordings_old` VALUES (727,'E000','2024-11-01','España Cañí','Austin Civic Wind Ensemble','01EspanaCani.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Marquina Narro, Pascual','',1);
INSERT INTO `recordings_old` VALUES (728,'C471','2024-11-01','Tam O\'Shanter','Austin Civic Wind Ensemble','02TamOShanter.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Arnold, Malcom','Paynter, John P.',1);
INSERT INTO `recordings_old` VALUES (729,'E000','2024-11-01','The Clapping Song','Austin Civic Wind Ensemble','03ClappingSong.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Standridge','',1);
INSERT INTO `recordings_old` VALUES (730,'C600','2024-11-01','Come, Drink One More Cup','Austin Civic Wind Ensemble','04ComeDrinkOneMoreCup.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Chen Qian','',1);
INSERT INTO `recordings_old` VALUES (731,'C475','2024-11-01','People Who Live in Glass Houses','Austin Civic Wind Ensemble','05PeopleWhoLiveinGlasshouses.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Sousa, John Phillip','Kreines',1);
INSERT INTO `recordings_old` VALUES (732,'E000','2024-11-01','El Poncho Empapado ','Austin Civic Wind Ensemble','06PonchoEmpapado.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.\r\n','Anderson High School','Brotherton, Kathleen','',1);
INSERT INTO `recordings_old` VALUES (733,'E000','2024-11-01','Berceuse and Finale from The Firebird','Austin Civic Wind Ensemble','07Firebird.mp3','Fall 2024 Concert, November 1, 2024 at Anderson High School, conducted by Robert Laguna, musical director.','Anderson High School','Stravinsky, Igor','',1);
INSERT INTO `recordings_old` VALUES (734,'E000','2024-11-03','España Cañí','Austin Civic Wind Ensemble','01EspanaCani.mp3','Fall 2024 Concert, November 3, 2024 at Huston Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.','King-Seabrook Chapel','Marquina Narro, Pascual','',1);
INSERT INTO `recordings_old` VALUES (735,'C471','2024-11-03','Tam O\'Shanter','Austin Civic Wind Ensemble','02TamOShanter.mp3','Fall 2024 Concert, November 3, 2024 at Huston-Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.','King-Seabrook Chapel','Arnold, Malcom','Paynter, John P.',1);
INSERT INTO `recordings_old` VALUES (736,'E000','2024-11-03','The Clapping Song','Austin Civic Wind Ensemble','03ClappingSong.mp3','Fall 2024 Concert, November 3, 2024 at Huston Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.\r\n','King-Seabrook Chapel','Standridge','',1);
INSERT INTO `recordings_old` VALUES (737,'C600','2024-11-03','Come, Drink One More Cup','Austin Civic Wind Ensemble','04ComeDrinkOneMoreCup.mp3','Fall 2024 Concert, November 3, 2024 at Huston-Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.','King-Seabrook Chapel','Chen Qian','',1);
INSERT INTO `recordings_old` VALUES (738,'C475','2024-11-03','People Who Live in Glass Houses','Austin Civic Wind Ensemble','05PeopleWhoLiveinGlassHouses.mp3','Fall 2024 Concert, November 3, 2024 at Huston-Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.','King-Seabrook Chapel','Sousa, John Phillip','Kreines',1);
INSERT INTO `recordings_old` VALUES (739,'E000','2024-11-03','El Poncho Empapado','Austin Civic Wind Ensemble','06PonchoEmpapado.mp3','Fall 2024 Concert, November 3, 2024 at Huston-Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.\r\n','King-Seabrook Chapel','Brotherton, Kathleen','',1);
INSERT INTO `recordings_old` VALUES (740,'E000','2024-11-03','Berceuse and Finale from The Firebird','Austin Civic Wind Ensemble','07Firebird.mp3','Fall 2024 Concert, November 3, 2024 at Huston-Tillotson University King-Seabrook Chapel, conducted by Robert Laguna, musical director.\r\n','King-Seabrook Chapel','Stravinsky, Igor','',1);
INSERT INTO `recordings_old` VALUES (741,'X063','2024-12-15','Festival Fanfare for Christmas','Austin Civic Wind Ensemble','01FestivalFanfareforChristmas.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road\r\n','Covenant United Methodist Church','Wasson, John','',1);
INSERT INTO `recordings_old` VALUES (742,'X002','2024-12-15','Christmas Recollections','Austin Civic Wind Ensemble','02ChristmasRecollections.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road\r\n','Covenant United Methodist Church','Various','Edmondson, John',1);
INSERT INTO `recordings_old` VALUES (743,'X039','2024-12-15','An Old-Fashioned Christmas','Austin Civic Wind Ensemble','03OldFashionedChristmas.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road\r\n','Covenant United Methodist Church','Olivadoti, J.','',1);
INSERT INTO `recordings_old` VALUES (744,'X027','2024-12-15','The Christmas Suite','Austin Civic Wind Ensemble','04ChristmasSuite.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Various','Walters, Harold L',1);
INSERT INTO `recordings_old` VALUES (745,'X012','2024-12-15','I\'ll Be Home for Christmas','Austin Civic Wind Ensemble','05IllBeHomeforChristmas.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Gannon, Kim','Kent, Walter',1);
INSERT INTO `recordings_old` VALUES (746,'X017','2024-12-15','White Christmas','Austin Civic Wind Ensemble','06WhiteChristmas.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road\r\n','Covenant United Methodist Church','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (747,'X011','2024-12-15','The Christmas Song (Chestnuts Roasting on an Open Fire)','Austin Civic Wind Ensemble','07ChristmasSong.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Mel Torme and Robert Wells','Cacavas, John',1);
INSERT INTO `recordings_old` VALUES (748,'X040','2024-12-15','Christmas Time','Austin Civic Wind Ensemble','08ChristmasTime.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Van der Roost, Jan','',1);
INSERT INTO `recordings_old` VALUES (749,'X015','2024-12-15','ʹTwas the Night Before Christmas','Austin Civic Wind Ensemble','09NightBeforeChristmas.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Moore, Clement C','Long, Newell H',1);
INSERT INTO `recordings_old` VALUES (750,'X009','2024-12-15','Sleigh Ride','Austin Civic Wind Ensemble','10SleighRide.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (751,'X060','2024-12-15','Joy to the World','Austin Civic Wind Ensemble','11JoytotheWorld.mp3','Austin Civic Wind Ensemble Thomas Stowers, Assistant Conductor presents 2024 Holiday Concert Series Sunday, December 15 5:00PM Covenant United Methodist Church 4410 Duval Road','Covenant United Methodist Church','Traditional','',1);
INSERT INTO `recordings_old` VALUES (752,'C205','1981-10-28','Moorside March','Austin Civic Wind Ensemble','01MoorsideStMarch.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Holst, Gustav','Jacobs, Gordon',1);
INSERT INTO `recordings_old` VALUES (753,'C165','1981-10-28','Folk Song Suite','Austin Civic Wind Ensemble','02RVWFolkSongSuite.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (754,'E000','1981-10-28','Ewald Quintet in B Minor ','Austin Civic Wind Ensemble','03EwaldQuintetinb.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Ewald','',1);
INSERT INTO `recordings_old` VALUES (755,'E000','1981-10-28','British Eighth March','Austin Civic Wind Ensemble','04BritishEigth.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Elliot, Zo','',1);
INSERT INTO `recordings_old` VALUES (756,'C180','1981-10-28','Sea Songs','Austin Civic Wind Ensemble','05RVWSeaSongs.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (757,'C243','1981-10-28','First Suite in Eb','Austin Civic Wind Ensemble','06Holst1stSuiteEb.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (758,'C253','1981-10-28','Shepherds Hey','Austin Civic Wind Ensemble','07ShepherdsHey.mp3','Concert at Texas School for the Blind and Visually Impaired, October 28, 1981','Texas School for the Blind','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (759,'C105','2000-10-25','Marche Des Parachutistes Belges','Austin Civic Wind Ensemble','01MarchoftheBelgianParatroopers.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Leemans, Pierre','Wiley, Charles A.',1);
INSERT INTO `recordings_old` VALUES (760,'EF004','2000-10-25','Water Music - Minuet','The Flute Loops','07WaterMusic-Minuet.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Handel, George Frederic','Lombardo, Ricky',1);
INSERT INTO `recordings_old` VALUES (761,'EF004','2000-10-25','Water Music - Allegro','The Flute Loops','08WaterMusic-Allegro.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Handel, George Frederic','Lombardo, Ricky',1);
INSERT INTO `recordings_old` VALUES (762,'C258','2000-10-25','Lincolnshire Posy - I','Austin Civic Wind Ensemble','03LincolnshirePosy-1.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (763,'C258','2000-10-25','Lincolnshire Posy - II','Austin Civic Wind Ensemble','04LincolnshirePosy-2.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (764,'C258','2000-10-25','Lincolnshire Posy - III','Austin Civic Wind Ensemble','05LincolnshirePosy-3.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (765,'C258','2000-10-25','Lincolnshire Posy - IV','Austin Civic Wind Ensemble','06LincolnshirePosy-4.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (766,'C166','2000-10-25','America the Beautiful','Austin Civic Wind Ensemble','02AmericatheBeautiful.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Ward, Samuel A.','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (767,'C390','2000-10-25','Southern Harmony - Midnight Cry','Austin Civic Wind Ensemble','09SouthernHarmony-MidnightCry.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grantham, Donald','',1);
INSERT INTO `recordings_old` VALUES (768,'C390','2000-10-25','Southern Harmony - Wondrous Love','Austin Civic Wind Ensemble','10SouthernHarmony-WondrousLove.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grantham, Donald','',1);
INSERT INTO `recordings_old` VALUES (769,'C390','2000-10-25','Southern Harmony - Exhiliration','Austin Civic Wind Ensemble','11SouthernHarmony-Exhiliration.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grantham, Donald','',1);
INSERT INTO `recordings_old` VALUES (770,'C390','2000-10-25','Southern Harmony - Soldiers Return','Austin Civic Wind Ensemble','12SouthernHarmony-SoldiersReturn.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Covington Middle School','Grantham, Donald','',1);
INSERT INTO `recordings_old` VALUES (771,'E000','2000-10-25','Improvisation and Caprice for Saxophone - Improvisation','Austin Civic Wind Ensemble','13ImprovforSax-Bozza.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nNick Farrell, bass saxophone','Covington Middle School','Bozza, Eugene','',1);
INSERT INTO `recordings_old` VALUES (772,'E000','2000-10-25','Improvisation and Caprice for Saxophone - Caprice','Austin Civic Wind Ensemble','14CapriceforSax-Bozza.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nNick Farrell, bass saxophone','Covington Middle School','Bozza, Eugene','',1);
INSERT INTO `recordings_old` VALUES (773,'C276','2000-10-25','Carmina Burana - 1','Austin Civic Wind Ensemble','15CarminaBurana-1.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nRobert Laguna, Conductor','Covington Middle School','Orff, Carl','Krance, John',1);
INSERT INTO `recordings_old` VALUES (774,'C276','2000-10-25','Carmina Burana - 2','Austin Civic Wind Ensemble','16CarminaBurana-2.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nRobert Laguna, Conductor','Covington Middle School','Orff, Carl','Krance, John',1);
INSERT INTO `recordings_old` VALUES (775,'C276','2000-10-25','Carmina Burana - 3','Austin Civic Wind Ensemble','17CarminaBurna-3.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nRobert Laguna, Conductor','Covington Middle School','Orff, Carl','Krance, John',1);
INSERT INTO `recordings_old` VALUES (776,'C276','2000-10-25','Carmina Burana - 4','Austin Civic Wind Ensemble','18CarminaBurana-4.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\nRobert Laguna, Conductor','Covington Middle School','Orff, Carl','Krance, John',1);
INSERT INTO `recordings_old` VALUES (777,'C330','2000-10-25','Rite of Tamburo','Austin Civic Wind Ensemble','19RitesofTamburo.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice\r\n-- with members of the Covington MS Gold Band','Covington Middle School','Smith, Robert W','',1);
INSERT INTO `recordings_old` VALUES (778,'C406','2000-10-25','Clear Track','Austin Civic Wind Ensemble','20ClearTrack.mp3','ACWE Fall Concert 25 October 2000 Covington Middle School Rick Glascock, conductor\r\nOriginal Recording by Michael Severino copied from CD provided by Janet Rice','Texas School for the Blind','Strauss','Nelson, Robert E.',1);
INSERT INTO `recordings_old` VALUES (779,'C248','2007-03-23','Jupiter with Painting','Austin Civic Wind Ensemble','04Jupiter-J-Painting.webm','\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater','St. Andrew\'s Presbyterian Church','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (780,'C314','2007-03-24','Variations on a Theme (video)','Austin Civic Wind Ensemble','02VariationsSchumannBassoonDara.webm','Dara A. Smith, Bassoon\r\n\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater\r\n','Carver Museum Theater','Schumann, Robert','Davis, William',1);
INSERT INTO `recordings_old` VALUES (781,'C281','2007-03-24','Adagio and Tarantella (video)','Austin Civic Wind Ensemble','03AdagioTarantellaClarinetChris.webm','Chris Pawling, Clarinet\r\n\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater','Carver Museum Theater','Cavallini, Ernesto','Reed, Thomas',1);
INSERT INTO `recordings_old` VALUES (782,'E000','2007-03-24','Robert and Jason comment (video)','Austin Civic Wind Ensemble','04J-Comments.webm','\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater','Carver Museum Theater','','',1);
INSERT INTO `recordings_old` VALUES (783,'E000','2007-03-24','ACWE President Jason (video)','Austin Civic Wind Ensemble','05JasonACWEComments.webm','\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater','Carver Museum Theater','','',1);
INSERT INTO `recordings_old` VALUES (784,'C248','2007-03-24','Painting to Jupiter (video)','Austin Civic Wind Ensemble','06J-PaintingtoJupiter.webm','J Muzacz, Artist paints a mural while ACWE plays \"Jupiter\"\r\n\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater\r\n','Carver Museum Theater','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (785,'E000','2007-03-24','Concerto for Tuba, pt 1 (video)','Austin Civic Wind Ensemble','08ConcertoTuba1.webm','Brian Edwards, Tuba\r\n\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater\r\n','Carver Museum Theater','Ewazen, Eric','Paynter',1);
INSERT INTO `recordings_old` VALUES (786,'E000','2007-03-24','Concerto for Tuba, pt 2 (video)','Austin Civic Wind Ensemble','09ConcertoTuba2.webm','Brian Edwards, Tuba\r\n\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater\r\n','Carver Museum Theater','Ewazen, Eric','Paynter',1);
INSERT INTO `recordings_old` VALUES (787,'C044','2007-03-24','Esla\'s Procession to the Cathedral (video)','Austin Civic Wind Ensemble','10ElsasProcession.webm','\"It\'s a Spring Thing\" 2007 Spring Concert Series\r\nConducted by Robert Laguna\r\nFriday March 23, 2007, St. Andrew\'s Presbyterian Church\r\nSaturday, March 24, 2007, Carver Museum Theater\r\n','Carver Museum Theater','Wagner, Richard','Cailliet, Lucien',1);
INSERT INTO `recordings_old` VALUES (788,'M421','2018-07-01','Trooper Salute','Austin Civic Wind Ensemble','01_TrooperSalute.mp3','Robert Laguna, music director. Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','(n/a)','Bocook, Jay and Reese, Barry',1);
INSERT INTO `recordings_old` VALUES (789,'C643','2018-07-01','Star Spangled Banner','Austin Civic Wind Ensemble','02_StarSpangledBanner.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Smith, John Stafford','Bell, Michael',1);
INSERT INTO `recordings_old` VALUES (790,'M423','2018-07-01','His Honor March','Austin Civic Wind Ensemble','03_HisHonor.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (791,'C418','2018-07-01','Pineapple Poll','Austin Civic Wind Ensemble','04_PineapplePoll.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Sullivan','Mackerras',1);
INSERT INTO `recordings_old` VALUES (792,'M041','2018-07-01','Bravura','Austin Civic Wind Ensemble','05_Bravura.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Duble','',1);
INSERT INTO `recordings_old` VALUES (793,'M420','2018-07-01','Rolling Thunder','Austin Civic Wind Ensemble','06_RollingThunder.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (794,'M419','2018-07-01','The Black Horse Troop','Austin Civic Wind Ensemble','07_BlackHorseTroop.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Sousa, John Philip','',1);
INSERT INTO `recordings_old` VALUES (795,'M412','2018-07-01','Brooke\'s Chicago Marine Band March','Austin Civic Wind Ensemble','08_BrooksChicagoMarineBandMarch.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Seitz, Roland F.','',1);
INSERT INTO `recordings_old` VALUES (796,'C166','2018-07-01','America, The Beautiful','Austin Civic Wind Ensemble','09_AmericatheBeautiful.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Ward, Samuel A.','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (797,'M422','2018-07-01','The Official West Point March','Austin Civic Wind Ensemble','10_OfficialWestPointMarch.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Egner, Philip','',1);
INSERT INTO `recordings_old` VALUES (798,'M017','2018-07-01','Stars and Stripes Forever','Austin Civic Wind Ensemble','11_Stars+Stripes.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Sousa','',1);
INSERT INTO `recordings_old` VALUES (799,'C335','2018-07-01','1812 Overture','Austin Civic Wind Ensemble','12_1812.mp3','Concert July 1, 2018 at Unity Church of the Hills, conducted by Thomas Stowers.','Unity Church of the Hills','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (800,'C398','2021-07-03','National Emblem','Austin Civic Wind Ensemble','01NationalEmblem.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Bagley, E. E.','Fennell, Frederick',1);
INSERT INTO `recordings_old` VALUES (801,'C355','2021-07-03','The Star Spangled Banner','Austin Civic Wind Ensemble','02StarSpangledBanner.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (802,'M002','2021-07-03','Man of the Hour','Austin Civic Wind Ensemble','03ManoftheHour.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Fillmore','',1);
INSERT INTO `recordings_old` VALUES (803,'M006','2021-07-03','Lassus Trombone','Austin Civic Wind Ensemble','04LassusTrombone.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Filmore','',1);
INSERT INTO `recordings_old` VALUES (804,'M041','2021-07-03','Bravura','Austin Civic Wind Ensemble','05Bravura.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Duble','',1);
INSERT INTO `recordings_old` VALUES (805,'EF076','2021-07-03','Shenandoah','Austin Civic Wind Ensemble','06Shenandoah.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Traditional','Louke, Phyllis Avidan',1);
INSERT INTO `recordings_old` VALUES (806,'C243','2021-07-03','Holst First Suite Movements 1 and 3','Austin Civic Wind Ensemble','07HolstFirstSuite-I&III.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (807,'C199','2021-07-03','Battle Hymn of the Republic','Austin Civic Wind Ensemble','08BattleHymn.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Wilhousky, Peter','Neilson, James',1);
INSERT INTO `recordings_old` VALUES (808,'C524','2021-07-03','The Girl I Left Behind Me','Austin Civic Wind Ensemble','09GirlIleftBehindMe.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Traditional','Anderson, Leroy',1);
INSERT INTO `recordings_old` VALUES (809,'C402','2021-07-03','The Yellow Rose of Texas','Austin Civic Wind Ensemble','10YellowRoseofTX.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','','Bass, R.',1);
INSERT INTO `recordings_old` VALUES (810,'M058','2021-07-03','The Klaxon','Austin Civic Wind Ensemble','11Klaxon.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (811,'C166','2021-07-03','America the Beautiful','Austin Civic Wind Ensemble','12America.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Ward, Samuel A.','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (812,'C613','2021-07-03','Armed Forces Salute','Austin Civic Wind Ensemble','13ArmedForcesSalute.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Various','Lowden, Bob',1);
INSERT INTO `recordings_old` VALUES (813,'M421','2021-07-03','Trooper Salute','Austin Civic Wind Ensemble','14TrooperSalute.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Unknown location','(n/a)','Bocook, Jay and Reese, Barry',1);
INSERT INTO `recordings_old` VALUES (814,'M017','2021-07-03','Stars and Stripes Forever','Austin Civic Wind Ensemble','15Stars+Stripes.mp3','Austin Civic Wind Ensemble, Robert Laguna, music director. Concert July 3, 2021 at Covenant United Methodist Church, conducted by Thomas Stowers.','Covenant United Methodist Church','Sousa','',1);
INSERT INTO `recordings_old` VALUES (815,'E001','2021-12-10','Three Christmas Carols','ACWE Brass Quintet','01-BrassQuintet-Scheidt3XmasChorales.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nWoodwind trio\r\nBrass quintet','Unity Church of the Hills','Scheidt','',1);
INSERT INTO `recordings_old` VALUES (816,'E001','2021-12-10','Greensleeves','Clarinet Trio','01-ClarinetTrio-Greensleeves.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nWoodwind trio\r\nBrass quintet','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (817,'E001','2021-12-10','Weihnachtslieder','ACWE Brass Quintet','02-BrassQuintet-Weihnachtslieder.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nWoodwind trio\r\nBrass quintet','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (818,'E001','2021-12-10','Minuet in G','Clarinet Trio','02-ClarinetTrio-TelemannMinuetinG.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nClarinet trio\r\nBrass quintet','Unity Church of the Hills','Telemann','',1);
INSERT INTO `recordings_old` VALUES (819,'E001','2021-12-10','It\'s Beginning to Look a Lot Like Christmas','ACWE Brass Quintet','03-BrassQuintet-BeginningtoLookaLotLikeXmas.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nClarinet trio\r\nBrass quintet','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (820,'E001','2021-12-10','Pavane from Capriol Suite','Clarinet Trio','03-ClarinetTrio-PavanefromCapriolSuite.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\nClarinet trio\r\nBrass quintet','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (821,'E001','2021-12-10','Four Christmas Carols','ACWE Brass Quintet','04-BrassQuintet-Praetorius4XmasCarols.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\n','Unity Church of the Hills','Praetorius','',1);
INSERT INTO `recordings_old` VALUES (822,'E001','2021-12-10','Christmas Concerto','Clarinet Trio','04-ClarinetTrio-CorelliXmasCto.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\n','Unity Church of the Hills','Corelli','',1);
INSERT INTO `recordings_old` VALUES (823,'E001','2021-12-10','Greensleeves','ACWE Brass Quintet','05-BrassQuintet-Greensleeves.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\n','Unity Church of the Hills','Unknown','',0);
INSERT INTO `recordings_old` VALUES (824,'E001','2021-12-10','Silent Night','ACWE Brass Quintet','06-BrassQuintet-SilentNight.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\n','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (825,'E001','2021-12-10','Hallelujah Chorus','ACWE Brass Quintet','07-BrassQuintet-HallelujahChorus.mp3','Concert at Unity Church of the Hills on Friday, December 10, 2021. Small ensembles performed:\r\n','Unity Church of the Hills','','',1);
INSERT INTO `recordings_old` VALUES (826,'E001','2021-12-12','Four Christmas Carols','ACWE Brass Quintet','01-BrassQuintet-Praetorius4XmasChorales.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Praetorius','',1);
INSERT INTO `recordings_old` VALUES (827,'E001','2021-12-12','Joy to the World','Clarinet Quartet','01-ClarinetQuartet-JoytotheWorld.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (828,'E001','2021-12-12','Adeste Fidelis','Low Brass Ensemble','01-LowBrass-AdesteFidelis.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (829,'E001','2021-12-12','We Need a Little Christmas','Violet Crown Flute Choir','01-VioletCrownFluteChoir-WeNeedaLittleChristmas.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (830,'E001','2021-12-12','Dance of the Sugar Plum Fairy','Woodwind Trio','01-WoodwindTrio-DanceofSugarPlumFairy.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (831,'E001','2021-12-12','Weihnachtlieder','ACWE Brass Quintet','02-BrassQuintet-Weihnachtlieder.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (832,'E001','2021-12-12','Mary Did You Know','Clarinet Quartet','02-ClarinetQuartet-MaryDidYouKnow.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (833,'E001','2021-12-12','Jingle Bells','Low Brass Ensemble','02-LowBrass-JingleBells.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (834,'E001','2021-12-12','Winter\'s Journey','Violet Crown Flute Choir','02-VioletCrownFluteChoir-WintersJourney.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (835,'E001','2021-12-12','Son of Mary','Woodwind Trio','02-WoodwindTrio-SonofMary.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (836,'E001','2021-12-12','It\'s the Most Wonderful Time of the Year','Low Brass Ensemble','03-BrassQuintet-MostWonderfulTime.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (837,'E001','2021-12-12','Halleujah','Clarinet Quartet','03-ClarinetQuartet-Hallelujah.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (838,'E001','2021-12-12','Noel','Low Brass Ensemble','03-LowBrass-Noel.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (839,'E001','2021-12-12','Nutcracker','Violet Crown Flute Choir','03-VioletCrownFluteChoir-Nutcracker.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (840,'E001','2021-12-12','In Dolce Jubilio','Woodwind Trio','03-WoodwindTrio-InDolceJubilio.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (841,'E001','2021-12-12','Sleigh Ride','ACWE Brass Quintet','04-BrassQuintet-SleighRide.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (842,'E001','2021-12-12','You\'re a Mean One, Mister Grinch','Clarinet Quartet','04-ClarinetQuartet-Grinch.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (843,'E001','2021-12-12','Deck the Halls','Low Brass Ensemble','04-LowBrass-DecktheHalls.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (844,'EF103','2021-12-12','Carol of the Bells','Violet Crown Flute Choir','04-VioletCrownFluteChoir-CaroloftheBells.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Traditional','Swallows, Dalton',1);
INSERT INTO `recordings_old` VALUES (845,'EC013','2021-12-12','Carol of the Bells','Woodwind Trio','04-WoodwindTrio-CaroloftheBells.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Traditional','Pentatonix',1);
INSERT INTO `recordings_old` VALUES (846,'E001','2021-12-12','Jingle Bells','ACWE Brass Quintet','05-BrassQuintet-JingleBells.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (847,'E001','2021-12-12','Have Yourself a Merry Little Christmas','Clarinet Quartet','05-ClarinetQuartet-HaveYourselfaMerryLittleXmas.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (848,'E001','2021-12-12','Rudolph, the Red Nosed Reindeer','Low Brass Ensemble','05-LowBrass-Rudolph.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (849,'E001','2021-12-12','Sleigh Ride','Violet Crown Flute Choir','05-VioletCrownFluteChoir-SleighRide.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (850,'E001','2021-12-12','Pachelbel Canon','Woodwind Trio','05-WoodwindTrio-PachelbelCanon.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (851,'E001','2021-12-12','Greensleeves','ACWE Brass Quintet','06-BrassQuintet-Greensleeves.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (852,'E001','2021-12-12','Angels Silent Night','Low Brass Ensemble','06-LowBrass-AngelsSilentNight.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (853,'E001','2021-12-12','O Tannenbaum','Woodwind Trio','06-WoodwindTrio-OTannenbaum.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (854,'E001','2021-12-12','The Holly and the Ivy','ACWE Brass Quintet','07-BrassQuintet-HollyandtheIvy.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Unknown','',1);
INSERT INTO `recordings_old` VALUES (855,'E001','2021-12-12','Russian Christmas Music','Low Brass Ensemble','07-LowBrass-RussianChristmasMusic.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','Reed, Alfred','',1);
INSERT INTO `recordings_old` VALUES (856,'E001','2021-12-12','O Come, Emmanuel','ACWE Brass Quintet','08-BrassQuintet-Emmanuel.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (857,'E001','2021-12-12','We Wish You a Merry Christmas','Low Brass Ensemble','08-LowBrass-WeWishYouaMerryXmas.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (858,'E001','2021-12-12','Hallelujah Chorus','ACWE Brass Quintet','09-BrassQuintet-HallelujahChorus.mp3','Concert at Covenant United Methodist on Sunday, December 12, 2021. Small ensembles performed:\r\n','Covenant United Methodist Church','','',1);
INSERT INTO `recordings_old` VALUES (859,'C110','2022-05-22','Duke of Cambridge','Austin Civic Wind Ensemble','01DukeofCambridge.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm. ','Anderson Theatre at Anderson High School','Arnold, Malcolm','',1);
INSERT INTO `recordings_old` VALUES (860,'C165','2022-05-22','English Folk Song Suite','Austin Civic Wind Ensemble','02FolkSongSuite.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (861,'C357','2022-05-22','Canterbury Chorale','Austin Civic Wind Ensemble','03CanterburyChorale.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Van der Roost','',1);
INSERT INTO `recordings_old` VALUES (862,'C373','2022-05-22','Molly on the Shore','Austin Civic Wind Ensemble','04MollyontheShore.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (863,'C394','2022-05-22','Shenandoah','Austin Civic Wind Ensemble','05Shenandoah.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Ticheli, Frank','',1);
INSERT INTO `recordings_old` VALUES (864,'M393','2022-05-22','Circus Days','Austin Civic Wind Ensemble','06CircusDays.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','King','',1);
INSERT INTO `recordings_old` VALUES (865,'C005','2022-05-22','Suite of Old American Dances','Austin Civic Wind Ensemble','07SuiteofOldAmericanDances.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Bennett, Robert Russell','',1);
INSERT INTO `recordings_old` VALUES (866,'C374','2022-05-22','The Cowboys','Austin Civic Wind Ensemble','08Cowboys.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Williams, John','Curnow, James',1);
INSERT INTO `recordings_old` VALUES (867,'M017','2022-05-22','Stars and Stripes Forever','Austin Civic Wind Ensemble','09Stars+Stripes.mp3','ACWE performs at the Anderson Theatre at Anderson High School on May 22, 2022. Start time 3:30pm.','Anderson Theatre at Anderson High School','Sousa','',1);
INSERT INTO `recordings_old` VALUES (868,'C523','2014-07-03','Cora is Gone','Austin Civic Wind Ensemble','CoraisGone.mp3','Concert at St. Louis King of France Catholic Church','St. Louis King of France Catholic Church','Traditional','Aldridge, Ben with Mitchell, Anna Mae',1);
INSERT INTO `recordings_old` VALUES (869,'C335','2014-07-03','1812 Overture','Austin Civic Wind Ensemble','1812.mp3','Concert at St. Louis King of France Catholic Church','St. Louis King of France Catholic Church','Tchaikovsky, Peter','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (870,'M390','2014-07-03','Easter Monday on the White House Lawn','Austin Civic Wind Ensemble','EasterMonday.mp3','Concert at St. Louis King of France Catholic Church','St. Louis King of France Catholic Church','Sousa, John Phillip','Rogers',1);
INSERT INTO `recordings_old` VALUES (871,'C524','2014-07-03','The Girl I Left Behind Me','Austin Civic Wind Ensemble','GirlILeftBehindMe.mp3','Concert at St. Louis King of France Catholic Church','St. Louis King of France Catholic Church','Traditional','Anderson, Leroy',1);
INSERT INTO `recordings_old` VALUES (872,'M088','2014-07-03','Stars and Stripes Forever','Austin Civic Wind Ensemble','Stars+Stripes.mp3','Concert at St. Louis King of France Catholic Church','St. Louis King of France Catholic Church','Sousa, John Philip','',1);
INSERT INTO `recordings_old` VALUES (873,'C162','1981-08-19','Festival Prelude','Austin Civic Wind Ensemble','01FestivalPrelude.mp3','August 19, 1981 at Texas School for the Blind','Texas School for the Blind','Reed, Alfred','',1);
INSERT INTO `recordings_old` VALUES (874,'C158','1981-08-19','Purple Carnival','Austin Civic Wind Ensemble','02PurpleCarnival.mp3','ACWE concert August 19, 1981 at Texas School for the Blind','Texas School for the Blind','Alford, Harry L','Erickson, Frank',1);
INSERT INTO `recordings_old` VALUES (875,'C032','1981-08-19','How the West Was Won','Austin Civic Wind Ensemble','03HowtheWestwasWon.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCasette tape from Janet Rice','Texas School for the Blind','Various','Hawkins, Robert',1);
INSERT INTO `recordings_old` VALUES (876,'C187','1981-08-19','Strategic Air Command','Austin Civic Wind Ensemble','04StrategicAirCommand.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCasette tape from Janet Rice','Texas School for the Blind','Williams, Clifton','',1);
INSERT INTO `recordings_old` VALUES (877,'C023','1981-08-19','Star Spangled Spectacular','Austin Civic Wind Ensemble','05StarSpangledSpectacular.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCasette tape from Janet Rice','Texas School for the Blind','Cohan, George M','Cavacas, John',1);
INSERT INTO `recordings_old` VALUES (878,'M064','1981-08-19','King Cotton','Austin Civic Wind Ensemble','06KingCotton.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCassette tape from Janet Rice','Texas School for the Blind','Sousa','',1);
INSERT INTO `recordings_old` VALUES (879,'C166','1981-08-19','America the Beautiful','Austin Civic Wind Ensemble','07AmericatheBeautiful.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCassette tape from Janet Rice','Texas School for the Blind','Ward, Samuel A.','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (880,'M017','1981-08-19','Stars and Stripes Forever','Austin Civic Wind Ensemble','08StarsandStripes.mp3','ACWE concert August 19, 1981 at Texas School for the Blind\r\nCassette tape from Janet Rice','Unknown location','Sousa','',1);
INSERT INTO `recordings_old` VALUES (881,'C089','1996-10-26','Red\'s White and Blue March','Austin Civic Wind Ensemble','01RedsWhiteandBlue.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Skelton , Red','Erickson, Frank',1);
INSERT INTO `recordings_old` VALUES (882,'C243','1996-10-26','Holst\'s First Stuide for Band in Eb','Austin Civic Wind Ensemble','02Holst1stSuite.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (883,'C144','1996-10-26','Boys of the Old Brigade','Austin Civic Wind Ensemble','03BoysoftheOPldBrigade.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.','Texas School for the Blind and Visually Impaired','Chambers, W. Paris','Smith, Claude T.',1);
INSERT INTO `recordings_old` VALUES (884,'C009','1996-10-26','Psalm for Band','Austin Civic Wind Ensemble','04PsalmforBand.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Persichetti','',1);
INSERT INTO `recordings_old` VALUES (885,'C287','1996-10-26','Irving Berlin\'s Songs for America','Austin Civic Wind Ensemble','05IrvingBerlinSongsforAmerica.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Berlin, Irving','Swearingen, James',1);
INSERT INTO `recordings_old` VALUES (886,'M062','1996-10-26','Battle Royal March','Austin Civic Wind Ensemble','06BattleRoyalMarch.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Jewell','',1);
INSERT INTO `recordings_old` VALUES (887,'C165','1996-10-26','English Folk Song Suite','Austin Civic Wind Ensemble','07EnglishFolkSongSuite.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (888,'C090','1996-10-26','March of the Cute Little Wood Sprites','Austin Civic Wind Ensemble','08MarchoftheCuteLittleWoodSprites.mp3','Austin Civic Wind Ensemble October 26, 1996 Texas School for the Blind and Visually Impaired\r\nStan Beard conducting. At the end of Psalm for Band, Stan Beard says \'We got through it!\'\r\nRecorded by Michael Severino, cassette tape from Ron Reed.\r\n','Texas School for the Blind and Visually Impaired','PDQ Bach','Schickle, Prof. Peter',1);
INSERT INTO `recordings_old` VALUES (889,'C063','1981-04-23','Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Smith, John Stafford','',1);
INSERT INTO `recordings_old` VALUES (890,'M019','1981-04-23','Saints in Concert','Austin Civic Wind Ensemble','02SaintsinConcert.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Moffit','',1);
INSERT INTO `recordings_old` VALUES (891,'M032','1981-04-23','British Eighth March','Austin Civic Wind Ensemble','03BritishEighth.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Elliot','',1);
INSERT INTO `recordings_old` VALUES (892,'C314','1981-04-23','Variations on a Theme of Robert Schumann','Austin Civic Wind Ensemble','04VariationsonThemeofRobtSchumann.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Schumann, Robert','Davis, William',1);
INSERT INTO `recordings_old` VALUES (893,'C042','1981-04-23','March from Symphonic Metamorphosis','Austin Civic Wind Ensemble','05SymphonicMetamorphosis.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Hindemith, Paul','Wilson, Kieth',1);
INSERT INTO `recordings_old` VALUES (894,'C109','1981-04-23','Instant Concert','Austin Civic Wind Ensemble','06InstantConcert.mp3','Austin Civic Wind Ensemble and Texas School for the Blind Jazz Ensemble Combined concert \r\nApril 23, 1981\r\nTexas School for the Blind\r\nBill Whitworth conducting\r\n','Texas School for the Blind','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (895,'M409','1979-06-23','Valdres Marsj','Austin Civic Wind Ensemble','01Valdres.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting','Zilker Hillside Theater','Hanssen','Schissel',1);
INSERT INTO `recordings_old` VALUES (896,'E000','1979-06-23','Concertino for Clarinet ','Austin Civic Wind Ensemble','02WeberConcertinoforClarinet.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting\r\nBob Grimmer, clarinet\r\n','Zilker Hillside Theater','','',1);
INSERT INTO `recordings_old` VALUES (897,'C566','1979-06-23','Slaughter on 10th Avenue','Austin Civic Wind Ensemble','03Slaughteron10thAve.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting','Zilker Hillside Theater','Rodgers, Richard','Lang, Philip J.',1);
INSERT INTO `recordings_old` VALUES (898,'C133','1979-06-23','Rondo from Concerto for Horn','Austin Civic Wind Ensemble','04MozartHornConcerto3-Rondo.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting\r\nRondo from Concerto for Horn - Mozart, Dave Parker, horn\r\n','Zilker Hillside Theater','Mozart, W. A.','Bardeen, Robert J.',1);
INSERT INTO `recordings_old` VALUES (899,'C106','1979-06-23','Symphony No. 9 \'From the New World\' Finale','Austin Civic Wind Ensemble','05DvorakSymph9-Finale.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting','Zilker Hillside Theater','Dvorak, Antonin','Leidzen, Erik W. G.',1);
INSERT INTO `recordings_old` VALUES (900,'C249','1979-06-23','Tribute to Glenn Miller','Austin Civic Wind Ensemble','06GlennMillerMedley.mp3','Austin Civic Wind Ensemble June 23, 1979 Zilker Hillside Theater\r\nBill Whitworth conducting\r\nLast concert before \'The Big Split\' started.\r\n','Zilker Hillside Theater','Varoius','Gass, Henry',1);
INSERT INTO `recordings_old` VALUES (901,'X024','1980-12-11','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','01FantasyonaBellCarol.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','Madden, Edward J.','',1);
INSERT INTO `recordings_old` VALUES (902,'X013','1980-12-11','Jingle Bells Rhapsody','Austin Civic Wind Ensemble','02JingleBellsRhapsody.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','Pierpont, J','Walters, Harold L',1);
INSERT INTO `recordings_old` VALUES (903,'X017','1980-12-11','White Christmas','Austin Civic Wind Ensemble','03WhiteChristmas.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (904,'X020','1980-12-11','Deck the Halls','Austin Civic Wind Ensemble','04DecktheHalls.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','Kay, Hershy','Grundman, Clare',1);
INSERT INTO `recordings_old` VALUES (905,'X026','1980-12-11','A Christmas Festival','Austin Civic Wind Ensemble','05ChristmasFestival.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (906,'X006','1980-12-11','We Wish You A Merry Christmas','Austin Civic Wind Ensemble','06WeWishYouaMerryChristmas.mp3','Austin Civic Wind Ensemble December 11, 1980 Highland Mall\r\nBill Whitworth conducting\r\nCassette from the personal collection of Bill Whitworth, provided by his daughter, Christine Whitworth Mendez\r\n','Highland Mall','unknown','Lawshe, Wilford',1);
INSERT INTO `recordings_old` VALUES (907,'C116','1980-11-13','Dam Buster\'s March','Austin Civic Wind Ensemble','01DamBusters.mp3','Austin Civic Wind Ensemble November 13, 1980 Northwest Austin Mediplex\r\nBill Whitworth conducting\r\n','Northwest Austin Mediplex','Coates, Eric','Duthoit, W. S.',1);
INSERT INTO `recordings_old` VALUES (908,'C243','1980-11-13','First Suite in Eb','Austin Civic Wind Ensemble','02Holst1stSuite.mp3','Austin Civic Wind Ensemble November 13, 1980 Northwest Austin Mediplex\r\nBill Whitworth conducting','Northwest Austin Mediplex','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (909,'C253','1980-11-13','Shepherd\'s Hey','Austin Civic Wind Ensemble','03ShepherdsHey.mp3','Austin Civic Wind Ensemble November 13, 1980 Northwest Austin Mediplex\r\nBill Whitworth conducting\r\n','Northwest Austin Mediplex','Grainger, Percy Aldridge','',1);
INSERT INTO `recordings_old` VALUES (910,'C165','1980-11-13','English Folk Song Suite','Austin Civic Wind Ensemble','04EnglishFolkSongSuite.mp3','Austin Civic Wind Ensemble November 13, 1980 Northwest Austin Mediplex\r\nBill Whitworth conducting\r\n','Northwest Austin Mediplex','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (911,'X026','1980-11-13','A Christmas Festival','Austin Civic Wind Ensemble','05ChristmasFestival.mp3','Austin Civic Wind Ensemble November 13, 1980 Northwest Austin Mediplex\r\nBill Whitworth conducting\r\n','Northwest Austin Mediplex','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (912,'C123','1980-07-05','Yankee Doodle','Austin Civic Wind Ensemble','01YankeeDoodle-Gould.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting\r\n','Elizabet Ney Museum','Gould, Morton','',1);
INSERT INTO `recordings_old` VALUES (913,'C116','1980-07-05','Dam Buster\'s March','Austin Civic Wind Ensemble','02DamBusters.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Coates, Eric','Duthoit, W. S.',1);
INSERT INTO `recordings_old` VALUES (914,'C249','1980-07-05','Tribute to Glenn Miller','Austin Civic Wind Ensemble','03TributetoGlennMiller.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Varoius','Gass, Henry',1);
INSERT INTO `recordings_old` VALUES (915,'C035','1980-07-05','Gallito','Austin Civic Wind Ensemble','04Gallito.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Lope, Santiago','Walters, Harold L.',1);
INSERT INTO `recordings_old` VALUES (916,'C221','1980-07-05','Muppet Show Theme','Austin Civic Wind Ensemble','05MuppetShowTheme.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Hensen, Jim and Sam Pottle','Cofield, Frank D.',1);
INSERT INTO `recordings_old` VALUES (917,'C166','1980-07-05','America the Beautiful','Austin Civic Wind Ensemble','07AmericatheBeautiful.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Ward, Samuel A.','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (918,'C089','1980-07-05','Red\'s White and Blue March','Austin Civic Wind Ensemble','06RedsWhiteandBlue.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Skelton , Red','Erickson, Frank',1);
INSERT INTO `recordings_old` VALUES (919,'C109','1980-07-05','Instant Concert','Austin Civic Wind Ensemble','08InstantConcert.mp3','Austin Civic Wind Ensemble July 5, 1980 Elizabet Ney Museum Bill Whitworth conducting','Elizabet Ney Museum','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (920,'X017','1979-12-02','White Christmas','Austin Civic Wind Ensemble','01WhiteChristmas.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (921,'X013','1979-12-02','Jingle Bells Rhapsody','Austin Civic Wind Ensemble','02JingleBellsRhapsody.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','Pierpont, J','Walters, Harold L',1);
INSERT INTO `recordings_old` VALUES (922,'X060','1979-12-02','Joy to the World','Austin Civic Wind Ensemble','03JoytotheWorld.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','Traditional','',1);
INSERT INTO `recordings_old` VALUES (923,'X006','1979-12-02','We Wish You A Merry Christmas','Austin Civic Wind Ensemble','04WeWishYouaMerryChristmas.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','unknown','Lawshe, Wilford',1);
INSERT INTO `recordings_old` VALUES (924,'X026','1979-12-02','A Christmas Festival','Austin Civic Wind Ensemble','05ChristmasFestival.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (925,'X024','1979-12-02','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','06FantasyonaBellCarol.mp3','Austin Civic Wind Ensemble December 2, 1979 Zilker Tree Lighting Bill Whitworth conducting (probably)\r\nEarliest evidence of ACWE at Zilker Tree Lighting.  \r\n','Zilker Holiday Tree','Madden, Edward J.','',1);
INSERT INTO `recordings_old` VALUES (926,'C222','1979-04-08','Valdres Marsj','Austin Civic Wind Ensemble','01Valdres.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Hanssen, Johannes','Bainum, Glen C',1);
INSERT INTO `recordings_old` VALUES (927,'C043','1979-04-08','Sinfonia Nobilissima','Austin Civic Wind Ensemble','02SinfoniaNobilissima.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Jager, Robert','',1);
INSERT INTO `recordings_old` VALUES (928,'M036','1979-04-08','Colonel Bogey March','Austin Civic Wind Ensemble','03ColonelBogey.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Alford','',1);
INSERT INTO `recordings_old` VALUES (929,'C259','1979-04-08','Fantasia on Dixie','Austin Civic Wind Ensemble','04FantasiaonDixie.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Emmett, Dan','Dragon, Carmen',1);
INSERT INTO `recordings_old` VALUES (930,'M006','1979-04-08','Lassus Trombone','Austin Civic Wind Ensemble','05LassusTrombone.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Filmore','',1);
INSERT INTO `recordings_old` VALUES (931,'C243','1979-04-08','First Suite in Eb','Austin Civic Wind Ensemble','06Holst1stSuite.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Holst, Gustav','',1);
INSERT INTO `recordings_old` VALUES (932,'C116','1979-04-08','Dam Buster\'s March','Austin Civic Wind Ensemble','07DamBusters.mp3','Austin Civic Wind Ensemble April 8, 1979 Waterloo Festival at Waterloo Park Bill Whitworth conducting \r\nPart of benefit event for the Austin Symphony\r\n','Waterloo Park','Coates, Eric','Duthoit, W. S.',1);
INSERT INTO `recordings_old` VALUES (933,'C110','1978-07-08','Duke of Cambridge','Austin Civic Wind Ensemble','01DukeofCambridge.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Arnold, Malcolm','',1);
INSERT INTO `recordings_old` VALUES (934,'C216','1978-07-08','Peer Gynt Suite Mvt IV','Austin Civic Wind Ensemble','02HalloftheMountainKing.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Greing, Edvard','Lake, Mayhew L.',1);
INSERT INTO `recordings_old` VALUES (935,'C138','1978-07-08','American Overture for Band','Austin Civic Wind Ensemble','03AmericanOvertureforBand.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Jenkins, Joseph Wilcox','',1);
INSERT INTO `recordings_old` VALUES (936,'C021','1978-07-08','Short Ballet for Awkward Dancers','Austin Civic Wind Ensemble','04ShortBalletforAwkwardDancers.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Hazelman, Herbert','',1);
INSERT INTO `recordings_old` VALUES (937,'C105','1978-07-08','March of the Belgian Paratroopers','Austin Civic Wind Ensemble','05MarchofBelgianParatroopers.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Leemans, Pierre','Wiley, Charles A.',1);
INSERT INTO `recordings_old` VALUES (938,'E000','1978-07-08','March of the Student Nurses','Austin Civic Wind Ensemble','06MarchoftheStudentNurses.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements. (no intro announcement on this one)\r\n','Zilker Hillside Theater','Unknown','',1);
INSERT INTO `recordings_old` VALUES (939,'C237','1978-07-08','Polka and Fugue from Schwanda','Austin Civic Wind Ensemble','07Polka+Fugue.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Weinberger','',1);
INSERT INTO `recordings_old` VALUES (940,'M017','1978-07-08','Stars and Stripes Forever','Austin Civic Wind Ensemble','08Stars+Stripes.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Sousa','',1);
INSERT INTO `recordings_old` VALUES (941,'C109','1978-07-08','Instant Concert','Austin Civic Wind Ensemble','09InstantConcert.mp3','Austin Civic Wind Ensemble July 8, 1978 Zilker Hillside Theater Bill Whitworth conducting\r\nA woman, Cynthia makes most of the announcements.\r\n','Zilker Hillside Theater','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (942,'X024','1978-12-12','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','01FantasyonaBellCarol.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.  Someone else making announcements.\r\n','Texas School for the Blind','Madden, Edward J.','',1);
INSERT INTO `recordings_old` VALUES (943,'X004','1978-12-12','Carol of the Drum','Austin Civic Wind Ensemble','02CarolfotheDrum.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.  Someone else making announcements.\r\n','Texas School for the Blind','Davis, Katherine K','Werle, Floyd E.',1);
INSERT INTO `recordings_old` VALUES (944,'X017','1978-12-12','White Christmas','Austin Civic Wind Ensemble','03WhiteChristmas.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.\r\nGuest conductor, Walt Shaw, Texas School for the Blind\r\nSomeone else making announcements.\r\n','Texas School for the Blind','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (945,'X021','1978-12-12','Yuletide Christmas','Austin Civic Wind Ensemble','04YuletideChristmas.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.  Someone else making announcements.\r\n','Texas School for the Blind','Lang, Philip J.','',1);
INSERT INTO `recordings_old` VALUES (946,'X026','1978-12-12','A Christmas Festival','Austin Civic Wind Ensemble','05ChristmasFestival.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.  Someone else making announcements.\r\n','Texas School for the Blind','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (947,'X006','1978-12-12','We Wish You A Merry Christmas','Austin Civic Wind Ensemble','06WeWishYouaMerryChristmas.mp3','Austin Civic Wind Ensemble December 12, 1978 TX School for the Blind - Bill Whitworth conducting.  Someone else making announcements.\r\n','Texas School for the Blind','unknown','Lawshe, Wilford',1);
INSERT INTO `recordings_old` VALUES (948,'M025','1977-11-20','The Star Spangled Banner','Austin Civic Wind Ensemble','01StarSpangledBanner.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nIn collaboration with the Hubbard High School Jaguar Band','Hubbard High School Gym','Moffit','',1);
INSERT INTO `recordings_old` VALUES (949,'C110','1977-11-20','Duke of Cambridge','Austin Civic Wind Ensemble','02Duke of Cambridge.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nIn collaboration with the Hubbard High School Jaguar Band','Hubbard High School Gym','Arnold, Malcolm','',1);
INSERT INTO `recordings_old` VALUES (950,'C128','1977-11-20','Children\'s March','Austin Civic Wind Ensemble','03ChildrensMarch.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nIn collaboration with the Hubbard High School Jaguar Band','Hubbard High School Gym','Grainger, Percy Aldridge','Erickson, Frank',1);
INSERT INTO `recordings_old` VALUES (951,'C105','1977-11-20','March of the Belgian Paratroopers','Austin Civic Wind Ensemble','04MarchofBelgianParatroopers.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nIn collaboration with the Hubbard High School Jaguar Band','Hubbard High School Gym','Leemans, Pierre','Wiley, Charles A.',1);
INSERT INTO `recordings_old` VALUES (952,'E001','1977-11-20','Sailors Hornpipe','ACWE woodwind quintet','05SailorsHornpipe-windquintet.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nWoodwind Quintet:  David Parker, horn; Pat Grimmer, flute; Bob Grimmer, clarinet, Cathy Grimmer, oboe, Gary Praterfield, bassoon. ','Hubbard High School Gym','Unknown','',1);
INSERT INTO `recordings_old` VALUES (953,'E001','1977-11-20','The Entertainer','ACWE woodwind quintet','06TheEntertainer-windquintet.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nWoodwind Quintet:  David Parker, horn; Pat Grimmer, flute; Bob Grimmer, clarinet, Cathy Grimmer, oboe, Gary Praterfield, bassoon. ','Hubbard High School Gym','Unknown','',1);
INSERT INTO `recordings_old` VALUES (954,'E000','1977-11-20','Star Wars','Austin Civic Wind Ensemble','07StarWars.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nArrangement by ACWE member, David Parker (horn)','Hubbard High School Gym','Unknown','Parker, David',1);
INSERT INTO `recordings_old` VALUES (955,'E000','1977-11-20','Mr. Quarterback','Hubbard High School Jaguars Band','08MrQuarterback-HubbardHSBand.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\nIn collaboration with the Hubbard High School Jaguars Band','Hubbard High School Gym','','',1);
INSERT INTO `recordings_old` VALUES (956,'E000','1977-11-20','Fight song','Hubbard High School Jaguars Band','09Unknown-HubbardHSBand.mp3','Hubbard High School Jaguars Band performs\r\nAustin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\n','Hubbard High School Gym','','',1);
INSERT INTO `recordings_old` VALUES (957,'C215','1977-11-20','Night Flight to Madrid','Austin Civic Wind Ensemble with Hubbard HS','10NightFlighttoMadrid-ACWE+HubbardHSBand.mp3','Hubbard High School Jaguars Band members perform with the Austin Civic Wind Ensemble,  November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting','Hubbard High School Gym','Leslie, Kermit and Walter','Leslie, Kermit',1);
INSERT INTO `recordings_old` VALUES (958,'C028','1977-11-20','la Gazza Ladra','Austin Civic Wind Ensemble','11LaGazaLadraOverture.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\n','Hubbard High School Gym','Rossini, G','Cailliet, Lucien',1);
INSERT INTO `recordings_old` VALUES (959,'C225','1977-11-20','Syncopated Clock','Austin Civic Wind Ensemble','12SynchopatedClock.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\n','Hubbard High School Gym','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (960,'C109','1977-11-20','Instant Concert','Austin Civic Wind Ensemble','13InstantConcert.mp3','Austin Civic Wind Ensemble, November 20, 1977, Hubbard High School Gym, Hubbard, TX - Bill Whitworth conducting\r\n','Hubbard High School Gym','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (961,'E001','1977-12-17','Christmas Package','ACWE Brass','01ChristmasPackage.mp3','Austin Civic Wind Ensemble December 17, 1977 Highland Mall Bill Whitworth conducting\r\nSounds like Christmas Package is just brass.\r\n','Highland Mall','Unknown','',1);
INSERT INTO `recordings_old` VALUES (962,'X024','1977-12-17','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','02FantasyonaBellCarol.mp3','Austin Civic Wind Ensemble, December 17, 1977, Highland Mall. Bill Whitworth conducting\r\n','Highland Mall','Madden, Edward J.','',1);
INSERT INTO `recordings_old` VALUES (963,'X017','1977-12-17','White Christmas','Austin Civic Wind Ensemble','03WhiteChristmas.mp3','Austin Civic Wind Ensemble, December 17, 1977, Highland Mall. Bill Whitworth conducting\r\n','Highland Mall','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (964,'E000','1977-12-17','Rudolph, the Red Nosed Reindeer','Austin Civic Wind Ensemble','04Rudolph.mp3','Austin Civic Wind Ensemble, December 17, 1977, Highland Mall. Bill Whitworth conducting\r\nQuirky arrangement of Rudolph','Highland Mall','Unknown','',1);
INSERT INTO `recordings_old` VALUES (965,'X026','1977-12-17','A Christmas Festival','Austin Civic Wind Ensemble','05ChristmasFestival.mp3','Austin Civic Wind Ensemble, December 17, 1977, Highland Mall. Bill Whitworth conducting\r\n','Highland Mall','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (966,'E000','1976-12-19','Christmas Package','Austin Civic Wind Ensemble','01ChristmasPackage.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','','',1);
INSERT INTO `recordings_old` VALUES (967,'E000','1976-12-19','Lo, How a Rose','Austin Civic Wind Ensemble','02LoHowaRose.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Unknown','',1);
INSERT INTO `recordings_old` VALUES (968,'X024','1976-12-19','Fantasy on a Bell Carol','Austin Civic Wind Ensemble','03FantasyonaBellCarol.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Madden, Edward J.','',1);
INSERT INTO `recordings_old` VALUES (969,'X025','1976-12-19','Slavonic Folk Suite','Austin Civic Wind Ensemble','04SlavonicFolkSuite.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Reed, Alfred','',1);
INSERT INTO `recordings_old` VALUES (970,'E000','1976-12-19','Rudolph, the Red Nosed Reindeer','Austin Civic Wind Ensemble','05Rudolph.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','','',1);
INSERT INTO `recordings_old` VALUES (971,'X017','1976-12-19','White Christmas','Austin Civic Wind Ensemble','06WhiteChristmas.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Berlin, Irving','Bennett, Robert Russell',1);
INSERT INTO `recordings_old` VALUES (972,'X026','1976-12-19','A Christmas Festival','Austin Civic Wind Ensemble','07ChristmasFestival.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Anderson, Leroy','',1);
INSERT INTO `recordings_old` VALUES (973,'X008','1976-12-19','Christmas Sing-a-Long','Austin Civic Wind Ensemble','08ChristmasSingalong.mp3','Austin Civic Wind Ensemble, December 19, 1976, Travis State School, Bill Whitworth conducting\r\n','Travis State School','Various','Ployhar, James',1);
INSERT INTO `recordings_old` VALUES (974,'M015','1975-05-25','Muskrat Ramble','Austin Civic Wind Ensemble','01MuskratRamble.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Ory','',1);
INSERT INTO `recordings_old` VALUES (975,'C025','1975-05-25','The Kaddidlehopper March','Austin Civic Wind Ensemble','02Kaddidlehoper.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (976,'E000','1975-05-25','Flourish for Wind Band','Austin Civic Wind Ensemble','03FlourishforWindBand.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Vaughn Williams, R.','',1);
INSERT INTO `recordings_old` VALUES (977,'C098','1975-05-25','March Lamar','Austin Civic Wind Ensemble','04MarchLamar.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Williams, Clifton','',1);
INSERT INTO `recordings_old` VALUES (978,'C127','1975-05-25','Liturgical Music for Band','Austin Civic Wind Ensemble','05LiturgicalMusicforBand.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Mailman, Martin','',1);
INSERT INTO `recordings_old` VALUES (979,'M040','1975-05-25','March, from 1776','Austin Civic Wind Ensemble','06Marchfrom1776.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Edwards','',1);
INSERT INTO `recordings_old` VALUES (980,'C109','1975-05-25','Instant Concert','Austin Civic Wind Ensemble','07InstantConcert.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (981,'C088','1975-05-25','Grand Marshal','Austin Civic Wind Ensemble','08GrandMarshalMarch.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (982,'E000','1975-05-25','The Budweiser Song','Austin Civic Wind Ensemble','09BudweiserSong.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','','',1);
INSERT INTO `recordings_old` VALUES (983,'M058','1975-05-25','The Klaxon','Austin Civic Wind Ensemble','10Klaxon.mp3','Austin Civic Wind Ensemble, May 25, 1975, Wooldridge Park.  Bill Whitworth conducting\r\nFrom the first known recording of the Austin Civic Wind Ensemble, and probably its first performance.','Wooldridge Square Park','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (984,'E000','2014-05-04','Le Regiment de Sambre et Meuse','Austin Civic Wind Ensemble','01RegimentdeSambreetMeuse.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\n','Covenant United Methodist Church','Planquette','',1);
INSERT INTO `recordings_old` VALUES (985,'C056','2014-05-04','Grande Symphonie funebre et triomphale (Mvt 1)','Austin Civic Wind Ensemble','02GrandSymphonie-1.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\n','Covenant United Methodist Church','Berlioz, Hector','Whitwell, David',1);
INSERT INTO `recordings_old` VALUES (986,'C056','2014-05-04','Grande Symphonie funebre et triomphale (Mvt 2)','Austin Civic Wind Ensemble','03GrandeSymphonie-2.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\n','Covenant United Methodist Church','Berlioz, Hector','Whitwell, David',1);
INSERT INTO `recordings_old` VALUES (987,'C056','2014-05-04','Grande Symphonie funebre et triomphale (Mvt 3)','Austin Civic Wind Ensemble','04GrandeSymphonie-3.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\n','Covenant United Methodist Church','Berlioz, Hector','Whitwell, David',1);
INSERT INTO `recordings_old` VALUES (988,'E000','2014-05-04','Lauridsen Contre qui rose','Austin Civic Wind Ensemble','05ContrequiRose.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\nLauridsen Contre qui rose','Covenant United Methodist Church','Lauridsen','',0);
INSERT INTO `recordings_old` VALUES (989,'EF068','2014-05-04','Boismorier Flute Concerto','Violet Crown Flute Choir','06BoismortierFluteCto.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\nFlute choir conducted by Christina Ryan','Covenant United Methodist Church','Boismortier, Joseph Bodin de','',1);
INSERT INTO `recordings_old` VALUES (990,'C333','2014-05-04','Cajun Folk Songs','Austin Civic Wind Ensemble','07CajunFolksongs.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\nConducted by Gary Sapp','Covenant United Methodist Church','Tichelli, Frank','',1);
INSERT INTO `recordings_old` VALUES (991,'C126','2014-05-04','Concertino for Flute and Band','Austin Civic Wind Ensemble','08ConcertinoforFlute.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\nChristina Ryan, Flute soloist','Covenant United Methodist Church','Chaminade, Cecile','Wilson, Clayton',1);
INSERT INTO `recordings_old` VALUES (992,'E000','2014-05-04','Milhaud, Suite Francaise ','Austin Civic Wind Ensemble','09SuiteFrancaise.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\nGary Sapp, conductor','Covenant United Methodist Church','Milhaud','',1);
INSERT INTO `recordings_old` VALUES (993,'E000','2014-05-04','Delibes Les Chasseresses from Sylvia','Austin Civic Wind Ensemble','10Chasseresses.mp3','Austin Civic Wind Ensemble Robert Laguna, conductor May 4, 2014 Covenant United Methodist Church, Austin, TX\r\n','Covenant United Methodist Church','Delibes','',1);
INSERT INTO `recordings_old` VALUES (994,'E000','2025-05-17','Flourish for Wind Band','Austin Civic Wind Ensemble','01FlourishforWindBand.mp3','Flourish for Wind Band is a short overture composed by Ralph Vaughan Williams for a 1939 pageant at the Royal Albert Hall. Originally scored for military band, the piece was lost for decades before being rediscovered in 1971. Notable for its accessibility','Bates Recital Hall','Williams, R. Vaughn','',1);
INSERT INTO `recordings_old` VALUES (995,'M015','2025-05-17','Muskrat Ramble','Austin Civic Wind Ensemble','02MuskratRamble.mp3','Muskrat Ramble is a seminal jazz composition by trombonist Edward “Kid” Ory, first recorded by Louis Armstrong and His Hot Five in Chicago in 1926. It quickly became a staple of the New Orleans jazz repertoire, and later became a jazz standard.','Bates Recital Hall','Ory','',1);
INSERT INTO `recordings_old` VALUES (996,'C025','2025-05-17','The Kadiddlehopper March','Austin Civic Wind Ensemble','03Kadiddlehopper.mp3','The Kadiddlehopper March is a distinctive short selection composed by Red Skelton. Skelton performed for eight U.S. presidents and three Roman Catholic Popes, composed more than 8,000 songs, 64 symphonies','Bates Recital Hall','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (997,'C098','2025-05-17','March Lamar','Austin Civic Wind Ensemble','04MarchLamar.mp3','March Lamar was written in 1964 for the band at Lamar Middle School in Austin, where Williams’ children were students.','Bates Recital Hall','Williams, Clifton','',1);
INSERT INTO `recordings_old` VALUES (998,'C127','2025-05-17','Liturgical Music for Band','Austin Civic Wind Ensemble','05LiturgicalMusic.mp3','Composed in 1963 and commissioned by the Greenville County High School Band in Virginia, Liturgical Music for Band is a work in four movements inspired by sections of the Catholic Mass','Bates Recital Hall','Mailman, Martin','',1);
INSERT INTO `recordings_old` VALUES (999,'M040','2025-05-17','1776 The Lees of Old Virginia','Austin Civic Wind Ensemble','06-1776.mp3','1776 is a musical based on the events surrounding the signing of the Declaration of Independence. It premiered on Broadway in 1969, and won three Tony Awards, including Best Musical. ','Bates Recital Hall','Edwards','',1);
INSERT INTO `recordings_old` VALUES (1000,'C109','2025-05-17','Instant Concert','Austin Civic Wind Ensemble','07InstantConcert.mp3','Instant Concert by Harold L. Walters has become a staple in band literature. Composed in 1965, this novelty medley features 30 well-known melodies from various genres, including classical themes, folk songs, and popular tunes.','Bates Recital Hall','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (1001,'C088','2025-05-17','The Grand Marshal','Austin Civic Wind Ensemble','08GrandMarshal.mp3','The Grand Marshal march, composed by Red Skelton, is a ceremonial piece dedicated to the Honorable Everett McKinley Dirksen, the U.S. Senator from Illinois. ','Bates Recital Hall','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (1002,'E000','2025-05-17','When do You Say Budweiser?','Austin Civic Wind Ensemble','09Budweiser.mp3','The Budweiser song played at ACWE\'s first concert was arranged by UT graduate and Texas band director Steve Curl. It is the only piece that was never played by ACWE again, until now.','Bates Recital Hall','Karmen, Steve','',1);
INSERT INTO `recordings_old` VALUES (1003,'M058','2025-05-17','The Klaxon','Austin Civic Wind Ensemble','10Klaxon.mp3','Composed in 1929 for the Cincinnati Automobile Show, The Klaxon by Henry Fillmore is a lively concert march celebrating the iconic Klaxon automobile horns of the early 20th century.','Bates Recital Hall','Fillmore, Henry','10Klaxon.mp3',1);
INSERT INTO `recordings_old` VALUES (1004,'C224','2025-05-17','Castle Gap March','Austin Civic Wind Ensemble','11CastleGap.mp3','Castle Gap by Clifton Williams is a concert march composed in 1964, commissioned by the Rankin High School Band in Rankin, Texas. ','Bates Recital Hall','Williams, J Clifton','',1);
INSERT INTO `recordings_old` VALUES (1005,'C183','2025-05-17','Tara\'s Theme','Austin Civic Wind Ensemble','12TarasTheme.mp3','Arranged for concert band by Ross Hastings, this version of \"Tara\'s Theme\" captures the essence of the original composition while adapting it for wind ensemble performance.','Bates Recital Hall','Steiner, Max','Hastings, Ross',1);
INSERT INTO `recordings_old` VALUES (1006,'C044','2025-05-17','Elsa\'s Procession to the Cathedral','Austin Civic Wind Ensemble','13ElsasProcession.mp3','Rick Glascock, guest conductor; Scout Goldsmith, harp\r\n\"Elsa\'s Procession to the Cathedral\" is one of the most revered excerpts from Richard Wagner’s 1850 opera Lohengrin/','Bates Recital Hall','Wagner, Richard','Cailliet, Lucien',1);
INSERT INTO `recordings_old` VALUES (1007,'E000','2025-05-17','Disco Inferno','Austin Civic Wind Ensemble','14DiscoInferno.mp3','This arrangement of The Trammps\' 1976 disco classic, Disco Inferno, originally featured in the Saturday Night Fever soundtrack, captures the song\'s infectious energy and rhythmic drive.','Bates Recital Hall','Green, Leroy and Ron Kersey','Higgins, John',1);
INSERT INTO `recordings_old` VALUES (1008,'E000','2025-05-18','Flourish for Wind Band','Austin Civic Wind Ensemble','01Flourish.mp3','Conducted by Robert Laguna, Flourish for Wind Band is a short overture composed by Ralph Vaughan Williams for a 1939 pageant at the Royal Albert Hall. Originally scored for military band, the piece was lost for decades before being rediscovered in 1971.','Covenant United Methodist Church','Williams, R. Vaughn','',1);
INSERT INTO `recordings_old` VALUES (1009,'M015','2025-05-18','Muskrat Ramble','Austin Civic Wind Ensemble','02MuskratRamble.mp3','Conducted by Robert Laguna, Muskrat Ramble is a seminal jazz composition by trombonist Edward “Kid” Ory, first recorded by Louis Armstrong and His Hot Five in Chicago in 1926','Covenant United Methodist Church','Ory','',1);
INSERT INTO `recordings_old` VALUES (1010,'C025','2025-05-18','The Kadiddlehopper March','Austin Civic Wind Ensemble','03Kadiddlehopper.mp3','Conducted by Robert Laguna, The Kadiddlehopper March is a distinctive short selection composed by Red Skelton. ','Covenant United Methodist Church','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (1011,'C098','2025-05-18','March Lamar','Austin Civic Wind Ensemble','04MarchLamar.mp3','Conducted by Robert Laguna March Lamar was written in 1964 for the band at Lamar Middle School in Austin, where Williams’ children were students.','Covenant United Methodist Church','Williams, Clifton','',1);
INSERT INTO `recordings_old` VALUES (1012,'C127','2025-05-18','Liturgical Music for Band','Austin Civic Wind Ensemble','05LiturgicalMusicforBand.mp3','Conducted by Robert Laguna, Composed in 1963 and commissioned by the Greenville County High School Band in Virginia, Liturgical Music for Band is a work in four movements inspired by sections of the Catholic Mass','Covenant United Methodist Church','Mailman, Martin','',1);
INSERT INTO `recordings_old` VALUES (1013,'M040','2025-05-18','1776 \"The Lees of Old Virginia\"','Austin Civic Wind Ensemble','06-1776.mp3','Conducted by Robert Laguna, 1776 is a musical based on the events surrounding the signing of the Declaration of Independence','Covenant United Methodist Church','Edwards','',1);
INSERT INTO `recordings_old` VALUES (1014,'C109','2025-05-18','Instant Concert','Austin Civic Wind Ensemble','07InstantConcert.mp3','Conducted by Robert Laguna. Composed in 1965, this novelty medley features 30 well-known melodies from various genres, including classical themes, folk songs, and popular tunes.','Covenant United Methodist Church','Walters, Harold L.','',1);
INSERT INTO `recordings_old` VALUES (1015,'C088','2025-05-18','The Grand Marshal','Austin Civic Wind Ensemble','08GrandMarshal.mp3','Conducted by Robert Laguna, The Grand Marshal march, composed by Red Skelton, is a ceremonial piece dedicated to the Honorable Everett McKinley Dirksen, the U.S. Senator from Illinois.','Covenant United Methodist Church','Skelton , Red','Rouiller, Ron',1);
INSERT INTO `recordings_old` VALUES (1016,'E000','2025-05-18','When Do You Say Budweiser?','Austin Civic Wind Ensemble','09Budweiser.mp3','Conducted by Robert Laguna, When You Say Budweiser, You’ve Said It All is a memorable advertising jingle composed by Steve Karmen in 1970 for Anheuser-Busch’s Budweiser beer.','Covenant United Methodist Church','Karmen, Steve','',1);
INSERT INTO `recordings_old` VALUES (1017,'M058','2025-05-18','The Klaxon','Austin Civic Wind Ensemble','10Klaxon.mp3','Conducted by Robert Laguna. Composed in 1929 for the Cincinnati Automobile Show, The Klaxon by Henry Fillmore is a lively concert march celebrating the iconic Klaxon automobile horns of the early 20th century.','Covenant United Methodist Church','Fillmore, Henry','',1);
INSERT INTO `recordings_old` VALUES (1018,'C224','2025-05-18','Castle Gap','Austin Civic Wind Ensemble','11CastleGap.mp3','Conducted by Robert Laguna, Castle Gap by Clifton Williams is a concert march composed in 1964 commissioned by the Rankin High School Band in Rankin, Texas. The piece is named after Castle Gap, a historic pass through the Castle Mountains.','Covenant United Methodist Church','Williams, J Clifton','',1);
INSERT INTO `recordings_old` VALUES (1019,'C183','2025-05-18','Tara\'s Theme','Austin Civic Wind Ensemble','12TarasTheme.mp3','Conducted by Robert Laguna, \"Tara\'s Theme\" from Gone with the Wind is a poignant and iconic melody composed by Max Steiner, serving as a musical leitmotif for the O\'Hara family\'s plantation, Tara.','Covenant United Methodist Church','Steiner, Max','Hastings, Ross',1);
INSERT INTO `recordings_old` VALUES (1020,'C044','2025-05-18','Elsa\'s Procession to the Cathedral','Austin Civic Wind Ensemble','13ElsasProcession.mp3','Rick Glascock, guest conductor; Scout Goldsmith, harp\r\n\"Elsa\'s Procession to the Cathedral\" is one of the most revered excerpts from Richard Wagner’s 1850 opera Lohengrin, showcasing his mastery of orchestration and emotional drama','Covenant United Methodist Church','Wagner, Richard','Cailliet, Lucien',1);
INSERT INTO `recordings_old` VALUES (1021,'E000','2025-05-18','Disco Inferno','Austin Civic Wind Ensemble','14DiscoInferno.mp3','Conducted by Robert Laguna, This arrangement of The Trammps\' 1976 disco classic, Disco Inferno, originally featured in the Saturday Night Fever soundtrack','Covenant United Methodist Church','Green, Leroy and Ron Kersey','John Higgins',1);
INSERT INTO `recordings_old` VALUES (1022,'E000','2025-05-18','ABBA Medley','Cosmic Clarinets','CosmicClarinets2025May18-Covenant.mp3','Pre-concert clarinet ensemble','Covenant United Methodist Church','','',1);
/*!40000 ALTER TABLE `recordings_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section_part_types`
--

DROP TABLE IF EXISTS `section_part_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_part_types` (
  `id_section` int(10) unsigned NOT NULL COMMENT 'Section ID',
  `id_part_type` int(10) unsigned NOT NULL COMMENT 'Part type ID',
  PRIMARY KEY (`id_section`,`id_part_type`),
  KEY `fk_part_type` (`id_part_type`),
  CONSTRAINT `fk_part_type` FOREIGN KEY (`id_part_type`) REFERENCES `part_types` (`id_part_type`) ON DELETE CASCADE,
  CONSTRAINT `fk_section` FOREIGN KEY (`id_section`) REFERENCES `sections` (`id_section`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Links sections to part types (many-to-many)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_part_types`
--

LOCK TABLES `section_part_types` WRITE;
/*!40000 ALTER TABLE `section_part_types` DISABLE KEYS */;
INSERT INTO `section_part_types` VALUES (1,1);
INSERT INTO `section_part_types` VALUES (1,2);
INSERT INTO `section_part_types` VALUES (1,3);
INSERT INTO `section_part_types` VALUES (1,4);
INSERT INTO `section_part_types` VALUES (1,5);
INSERT INTO `section_part_types` VALUES (1,6);
INSERT INTO `section_part_types` VALUES (1,7);
INSERT INTO `section_part_types` VALUES (1,8);
INSERT INTO `section_part_types` VALUES (1,9);
INSERT INTO `section_part_types` VALUES (1,10);
INSERT INTO `section_part_types` VALUES (1,11);
INSERT INTO `section_part_types` VALUES (1,12);
INSERT INTO `section_part_types` VALUES (1,13);
INSERT INTO `section_part_types` VALUES (1,14);
INSERT INTO `section_part_types` VALUES (1,15);
INSERT INTO `section_part_types` VALUES (1,16);
INSERT INTO `section_part_types` VALUES (1,17);
INSERT INTO `section_part_types` VALUES (2,18);
INSERT INTO `section_part_types` VALUES (2,19);
INSERT INTO `section_part_types` VALUES (2,20);
INSERT INTO `section_part_types` VALUES (2,21);
INSERT INTO `section_part_types` VALUES (2,22);
INSERT INTO `section_part_types` VALUES (2,23);
INSERT INTO `section_part_types` VALUES (2,24);
INSERT INTO `section_part_types` VALUES (2,25);
INSERT INTO `section_part_types` VALUES (2,26);
INSERT INTO `section_part_types` VALUES (2,27);
INSERT INTO `section_part_types` VALUES (2,28);
INSERT INTO `section_part_types` VALUES (2,29);
INSERT INTO `section_part_types` VALUES (2,30);
INSERT INTO `section_part_types` VALUES (3,31);
INSERT INTO `section_part_types` VALUES (3,32);
INSERT INTO `section_part_types` VALUES (3,33);
INSERT INTO `section_part_types` VALUES (3,34);
INSERT INTO `section_part_types` VALUES (3,35);
/*!40000 ALTER TABLE `section_part_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'Woodwinds','Flutes, oboes, clarinets, saxophones, bassoons',1,NULL);
INSERT INTO `sections` VALUES (2,'Brass','Trumpets, horns, trombones, euphoniums, tubas',1,NULL);
INSERT INTO `sections` VALUES (3,'Percussion','Timpani, drums, mallet instruments, accessories',1,NULL);
INSERT INTO `sections` VALUES (4,'Strings','Violins, violas, cellos, double basses',1,NULL);
INSERT INTO `sections` VALUES (5,'Other','Special instruments and soloists',1,NULL);
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_users` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the user',
  `username` varchar(128) NOT NULL COMMENT 'The user name',
  `password` varchar(128) NOT NULL COMMENT 'User password',
  `name` varchar(255) DEFAULT NULL COMMENT 'Real name',
  `address` varchar(255) DEFAULT NULL COMMENT 'Users e-mail address',
  `roles` varchar(255) DEFAULT NULL COMMENT 'Text field containing roles',
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps users.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$1K2PKUCxjWpxsSuLqsb/o.Qx3pRf2eThDAjf.C7jiVXTFXa/xg/Q6','System Administrator','admin@musiclibrary.org','administrator');
INSERT INTO `users` VALUES (2,'librarian','$2y$10$s.ZoclJFRAKIsHZuSX3GG.Lr3aSNwjK39AXb6naaYNzmcfysmfXq6','Music Librarian','librarian@musiclibrary.org','librarian');
INSERT INTO `users` VALUES (3,'conductor','$2y$10$FdEob9VsvTjnTsxv4ySnEOvn/14OOrEjnVE2QHqW.k729vsTZFcpq','John Smith','conductor@musiclibrary.org','user');
INSERT INTO `users` VALUES (4,'user','$2y$10$uEjJG/pxxt6kPu5ad32D6uVyNtBzFJIqSaVrtjbtAYAJPQ.ABiujq','General User','user@musiclibrary.org','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-09 10:32:50
