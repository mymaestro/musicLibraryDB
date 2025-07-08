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
  `provenance` varchar(255) DEFAULT NULL COMMENT 'Where did this piece come from? (P)urchased (R)ented (B)orrowed (D)onated',
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
-- No data for table `compositions`
--

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
INSERT INTO `ensembles` VALUES
('B5Q','Brass quintet','A brass quintet is a five-piece musical ensemble composed of brass instruments. The instrumentation for a brass quintet typically includes two trumpets or cornets, one French horn, one trombone or euphonium/baritone horn, and one tuba or bass trombone.','',1),
('BK','Brass choir','A small ensemble consisting mainly of instruments in the brass family, sometimes adding percussion.','',1),
('C','Four Winds Wind Ensemble','Nestled on the blustery plains of Rock Bluff, South Dakota, the Four Winds Wind Ensemble takes its name from the ceaseless breezes that sweep across the prairie in every season. Founded in 2009 by a handful of local musicians and music educators, Four Winds has grown into a vibrant, all-volunteer community ensemble composed of woodwind, brass, and percussion players of all ages and backgrounds.','https://4winds.org/about',1),
('CC','Clarinet choir','The Clarinet choir plays music for clarinets','',1),
('HC','Horn Choir','An indeterminate number of horn (Horn in F) players','',1),
('JB','Jazz band','Full 17-piece jazz band','',0),
('LBK','Low brass choir','A small ensemble consisting mainly of instruments in the low brass family (trombone, euphonium, and tuba), sometimes adding percussion.','',1),
('PER','Percussion Ensemble','','',1),
('SX','Saxophone ensemble','A group of saxophones','',1),
('TC','Trombone Choir','An indeterminate-numbered-sized group of trombonists','',1),
('VC','Flute Choir','The flute ensemble includes piccolo, C flute, alto flute, and bass flute.','',1),
('W5Q','Woodwind Quintet','A woodwind quintet is a chamber music ensemble made up of five distinct wind instruments, typically flute, oboe, clarinet, bassoon, and horn. Woodwind quintets blend instruments from different sections of the wind ensemble, creating a colorful and versatile sound.','',1),
('WDE','Woodwind ensemble','A small ensemble consisting mainly of instruments in the woodwind family, sometimes adding percussion.','',1);
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
INSERT INTO `genres` VALUES
('C','Christmas','Christmas music comprises a variety of genres of music normally performed or heard around the Christmas season.',1),
('Ch','Brass choir','Brass choir music',1),
('J','Jazz','Jazz composition or arrangement for band',1),
('M','March','A march, as a musical genre, is a piece of music with a strong regular rhythm which in origin was expressly written for marching to and most frequently performed by a military band.',1),
('O','Other','Something other than one of the genres',1),
('P','Pop','Arrangements of popular music',1),
('SH','Show tunes','Music from plays or Broadway shows',1),
('Solo','Solo with band accompaniment','Piece for solo instrument with band accompaniment',1),
('T','Symphonic transcription','Transcriptions of classic and contemporary symphonic works for band',1),
('W','Wind ensemble','A piece composed specifically for wind ensemble or concert band.',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds names of instruments to use in parts.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES
(1,10,'Piccolo in C','The piccolo is a half-size flute, and a member of the woodwind family of musical instruments.','Woodwind',1),
(2,20,'Piccolo in Db','Pitched in C or D♭, the piccolo is the smallest member of the flute family serving as an extension to the flute range, sounding an octave higher than written.','Woodwind',1),
(3,30,'Flute','A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ','Woodwind',1),
(4,40,'Oboe','The oboe is a type of double reed woodwind instrument.  The most common oboe plays in the treble or soprano range. The oboe has a conical bore and a flared bell. ','Woodwind',1),
(5,50,'English Horn','English horn, French cor anglais, German Englischhorn, orchestral woodwind instrument, a large oboe pitched a fifth below the ordinary oboe, with a bulbous bell and, at the top end, a bent metal crook on which the double reed is placed. It is pitched in F, being written a fifth higher than it sounds.','Woodwind',1),
(6,60,'Clarinet in Eb','The E-flat (E♭) clarinet is a member of the clarinet family, smaller than the more common Bb clarinet and pitched a perfect fourth higher.','Woodwind',1),
(7,70,'Clarinet in Bb','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',1),
(8,80,'Alto Clarinet','The alto clarinet is a woodwind instrument of the clarinet family. It is a transposing instrument pitched in the key of E♭, though instruments in F have been made. In size it lies between the soprano clarinet and the bass clarinet.','Woodwind',1),
(9,90,'Bass Clarinet','Bass clarinet is usually pitched in B♭ (meaning it is a transposing instrument on which a written C sounds as B♭), but it plays notes an octave below the soprano B♭ clarinet.','Woodwind',1),
(10,100,'Contralto Clarinet/Contrabass Clarinet in Eb','The contra-alto clarinet, E♭ contrabass clarinet, or great bass clarinet is a large clarinet pitched a perfect fifth below the B♭ bass clarinet. It is a transposing instrument in E♭ sounding an octave and a major sixth below its written pitch. As it is pitched between the bass clarinet and the B♭ contrabass clarinet, the contra-alto clarinet is the great bass member of the clarinet family.','Woodwind',1),
(11,110,'Contrabass Clarinet in Bb','The contrabass clarinet is pitched in the key of Bb, and parts for it are universally written transposed in treble clef, as if it were a Bb soprano clarinet. Thus, the pitch played will sound two octaves and one whole step lower than written. ','Woodwind',1),
(12,120,'Bassoon','The bassoon is a woodwind instrument in the double reed family, which has a tenor and bass sound.','Woodwind',1),
(13,130,'Contrabassoon','The contrabassoon, also known as the double bassoon, is a larger version of the bassoon, sounding an octave lower.','Woodwind',1),
(14,140,'Sopranino Saxophone','The sopranino saxophone is the second-smallest member of the saxophone family. It is tuned in the key of Eâ™­, and sounds an octave higher than the alto saxophone.','Woodwind',1),
(15,150,'Soprano Saxophone','The soprano saxophone is a higher-register variety of the saxophone.','Woodwind',1),
(16,160,'Alto Saxophone','The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',1),
(17,170,'Tenor Saxophone','The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',1),
(18,180,'Baritone Saxophone','The baritone saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',1),
(19,190,'Bass Saxophone','The bass saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',1),
(20,200,'Cornet','The cornet is a brass instrument commonly used in classical and jazz ensembles.','Brass',1),
(21,210,'Cornet in Eb','A cornet keyed in Eb.','Brass',1),
(22,220,'Bugle','The bugle is one of the simplest brass instruments, having no valves or other pitch-altering devices. All pitch control is done by varying the player\'s embouchure. Consequently, the bugle is limited to notes within the harmonic series.','Brass',1),
(23,230,'Trumpet in Bb','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',1),
(24,240,'Fluegelhorn','The flugelhorn also spelled fluegelhorn, flugel horn, or flÃ¼gelhorn, is a brass instrument that resembles the trumpet and cornet but has a wider, more conical bore. Like trumpets and cornets, most flugelhorns are pitched in Bâ™­.','Brass',1),
(25,250,'Horn in F','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',1),
(26,260,'Tenor Horn in Eb','The tenor horn (British English; alto horn in American English, Althorn in Germany; occasionally referred to as E♭ horn) is a brass instrument in the saxhorn family and is usually pitched in E♭. It has a bore that is mostly conical, like the flugelhorn and euphonium, and normally uses a deep, cornet-like mouthpiece.','Brass',1),
(27,270,'Trombone','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',1),
(28,280,'Bass Trombone','A variation of the trombone family, considered the lower member of the trombone family.','Brass',1),
(29,290,'Tenor Horn in Bb','This is the correct horn for playing the solo in Mahler\'s Symphony No 7.  It is a lovely playing instrument with distinctive tone.','Brass',0),
(30,300,'Baritone','The baritone horn, or sometimes just called baritone, is a valved, low-pitched brass instrument.','Brass',1),
(31,310,'Euphonium','Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.','Brass',1),
(32,320,'Tuba in Bb','The tuba is the lowest-pitched musical instrument in the brass family.','Brass',1),
(33,330,'Tuba in Eb','It\'s a tuba, just in Eb.','Brass',1),
(34,340,'Violoncello','The violoncello or cello is a bowed (sometimes plucked and occasionally hit) string instrument of the violin family. Its four strings are usually tuned in perfect fifths: from low to high, C2, G2, D3 and A3.','Strings',1),
(35,350,'String Bass',' The double bass, also known simply as the bass, is the largest and lowest-pitched bowed (or plucked) string instrument.','Strings',1),
(36,360,'Timpani','Timpani or kettledrums are musical instruments in the percussion family.','Percussion',1),
(37,370,'Snare drum','The snare drum or side drum is a percussion instrument that produces a sharp staccato sound when the head is struck with a drum stick.','Percussion',1),
(38,380,'Field Drum','A field drum is a snare drum. Also known as snare drums or side drums, field drums belong to the family of membranophones, which are instruments that produce sound when a player strikes a membrane (called a drum head) pulled tight over a metal or wood drum shell.','Percussion',1),
(39,390,'Tenor drum','A tenor drum is a low-pitched drum. A little bigger than a snare drum, it has no snares and is played with soft mallets or hard sticks. Under various names, the drum has been used by composers since the mid-19th century.','Percussion',1),
(40,400,'Bass drum','The bass drum, or kick drum, is a large drum that produces a note of low definite or indefinite pitch.','Percussion',1),
(41,410,'Cymbals, crash','A cymbal is a common percussion instrument. Often used in pairs, cymbals consist of thin, normally round plates of various alloys.','Percussion',1),
(42,420,'Cymbal, suspended','A cymbal, suspended on a stand','Percussion',1),
(43,430,'Tambourine','The tambourine is a musical instrument in the percussion family consisting of a frame, often of wood or plastic, with pairs of small metal jingles, called \"zills\".','Percussion',1),
(44,440,'Triangle','The triangle is an idiophone type of musical instrument in the percussion family.','Percussion',1),
(45,450,'Temple blocks','Temple blocks are carved hollow wooden instruments with large slits. The shape is somewhat bulbous, but modern instruments are often rectangular in shape. They are generally played in sets of four or more to give a variety of pitches.','Percussion',1),
(46,460,'Bell tree','A bell tree, also known as tree bells or Chinese bell tree (often confused with the mark tree), is a percussion instrument, consisting of vertically nested inverted metal bowls.','Percussion',1),
(47,470,'Clapper (slapstick)','In music, a whip or slapstick is a clapper (percussion instrument) consisting of two wooden boards joined by a hinge at one end. When the boards are brought together rapidly, the sound produces a sound reminiscent of the crack of a whip.','Percussion',1),
(48,480,'Brake Drum','The brake drum is a percussion vessel idiophone, probably originating in North America in the 20th century. They are repurposed motor vehicle parts used primarily in contemporary American and European percussion ensemble compositions.','Percussion',1),
(49,490,'Slide Whistle','A slide whistle (variously known as a swanee or swannee whistle, lotos flute piston flute, or jazz flute) is a wind instrument consisting of a fipple like a recorder\'s and a tube with a piston in it. Thus it has an air reed like some woodwinds, but varies the pitch with a slide. Because the slide whistle most commonly appears on percussion parts, it is classified here in the percussion family.','Percussion',1),
(50,500,'Cowbell','The cowbell is a percussion instrument used in both pop and Latin genres in contemporary music. The instrument is played by being struck on the exterior of the bell, often by a drumstick. The cowbell is capable of creating only one note, although the timbre varies.','Percussion',1),
(51,510,'Tam-Tam','A gong of indefinite pitch. The Tam-Tam is a huge metal percussion instrument which makes an unforgettable booming sound. It is a type of gong, but it is made of thinner metal than most gongs and has no raised boss in the center. When you strike the tam-tam, the sound gets louder and louder, building up to a shimmering climax before fading away.','Percussion',1),
(52,520,'Gong','A gong is a percussion instrument formed from a circular metal disc. Gongs are played with mallets, a type of percussion beater with a large, felted head. Gongs are a key instrument in the traditional music of China, Burma, and Indonesia, and they have been a part of Western musical culture since at least the 1700s.','Percussion',1),
(53,530,'Jing','The jing is a gong used in traditional Korean music.','Percussion',0),
(55,550,'Taiko drum','A Taiko drum is any of various Japanese forms of barrel-shaped drums with lashed or tacked heads, usually played with sticks (bachi).','Percussion',1),
(56,560,'Maracas','Maracas are rattles, often made from gourds (a kind of squash), filled with dried seeds, beads or even tiny ball bearings that make them rattle. ','Percussion',1),
(57,570,'Castanets','Castanets are wooden instruments from Spain, and are used to punctuate the music with a distinctive clickety-clack. Castanets are made of two pieces of wood tied together.','Percussion',1),
(58,580,'Sand blocks','The sandpaper block is a friction idiophone of American or European origin. A pair of blocks is called for occasionally in orchestra, concert band and percussion ensemble music to produce a special-effects sound (e.g., the imitation of a locomotive). No specialization is necessary to play the instrument.','Percussion',1),
(59,590,'Cabasa','The cabasa, similar to the shekere, is a percussion instrument that is constructed with loops of steel ball chain wrapped around a wide cylinder.','Percussion',1),
(60,600,'Ratchet','A ratchet or rattle, more specifically, cog rattle, is a musical instrument of the percussion family. It operates on the principle of the ratchet device, using a gearwheel and a stiff board mounted on a handle, which rotates freely.','Percussion',0),
(61,610,'Drum set','The drum set is sometimes used in rock and jazz arrangements','Percussion',1),
(62,620,'Wind chimes','Wind chimes are a type of percussion instrument constructed from suspended tubes, rods, bells or other objects that are often made of metal.','Percussion',1),
(63,630,'Glockenspiel/Bells','The glockenspiel or bells is a percussion instrument. It consists of pitched aluminum or steel bars arranged in a keyboard layout. This makes the glockenspiel a type of metallophone, similar to the vibraphone.','Percussion',1),
(64,640,'Marimba','A percussion instrument consisting of a set of wooden bars struck with yarn or rubber mallets to produce musical tones.','Percussion',1),
(65,650,'Vibraphone','A percussion instrument that has tuned metal bars.','Percussion',1),
(66,660,'Xylophone','A percussion instrument consisting of a set of graduated, tuned wooden bars supported at nodal (nonvibrating) points and struck with sticks or padded mallets.','Percussion',1),
(67,670,'Chimes','Also called tubular bells, chimes produce a sound that resembles church bells, or a carillon.','Percussion',1),
(68,680,'Agogo bells','An agogô (Yoruba: agogo, meaning bell) is a single or a multiple bell','Percussion',1),
(69,690,'Piano','The piano is an acoustic, stringed musical instrument in which the strings are struck by wooden hammers and is played using a keyboard.','Percussion',1),
(70,700,'Organ','A keyboard instrument, operated by the playerâ€™s hands and feet, in which pressurized air produces notes through a series of pipes organized in scalelike rows. The term organ encompasses reed organs and electronic organs but, unless otherwise specified, is usually understood to refer to pipe organs. ','Other',1),
(71,710,'Synthesizer','Music synthesizer, also called electronic sound synthesizer, machine that electronically generates and modifies sounds, frequently with the use of a digital computer. Synthesizers are used for the composition of electronic music and in live performance.','Other',1),
(72,720,'Harp','The harp is a stringed musical instrument that has a number of individual strings running at an angle to its soundboard; the strings are plucked with the fingers.','Percussion',1),
(73,730,'Guitar','The guitar is classified as a chordophone. This means the sound is produced by a vibrating string stretched between two fixed points. Historically, a guitar was constructed from wood with its strings made of catgut.','Strings',1),
(74,740,'Electric Guitar','The electric guitar is sometimes used in rock and jazz arrangements.','Strings',1),
(75,750,'Electric Bass','The electric bass is used in rock and jazz bands, and sometimes in concert band and wind ensemble arrangements.','Strings',1),
(76,760,'Narrator','The narrator is a specific person or unspecified literary voice, developed by the creator of the story, to deliver information to the audience, particularly about the plot.','Voice',1),
(234,425,'Cymbal, Hi-Hat','A hi-hat (hihat, high-hat, etc.) is a combination of two cymbals and a pedal, all mounted on a metal stand. It is a part of the standard drum kit. Hi-hats consist of a matching pair of small to medium-sized cymbals mounted on a stand, with the two cymbals facing each other. The bottom cymbal is fixed and the top is mounted on a rod which moves the top cymbal toward the bottom one when the pedal is depressed (a hi-hat that is in this position is said to be \"closed\" or \"closed hi-hats\"). ','Percussion',1),
(235,85,'Basset Horn','Like the clarinet, the instrument is a wind instrument with a single reed and a cylindrical bore. However, the basset horn is larger and has a bend or a kink between the mouthpiece and the upper joint (older instruments are typically curved or bent in the middle), and while the clarinet is typically a transposing instrument in B♭ or A (meaning a written C sounds as a B♭ or A), the basset horn is typically in F (less often in G). ','Woodwind',1),
(236,32,'Alto Flute','The alto flute is the second-highest member below the standard C flute after the uncommon flûte d\'amour. It is characterized by its rich, mellow tone in the lower portion of its range. It is a transposing instrument in G (a perfect fourth below written C), and uses the same fingerings as the C flute.\r\n\r\nThe bore of the alto flute is considerably larger in diameter and longer than a C flute and requires more breath from the player.[1] This gives it a greater dynamic presence in the bottom octave and a half of its range. ','Woodwind',1),
(237,35,'Bass Flute','The bass flute is a member of the flute family. It is in the key of C, pitched one octave below the concert flute. Despite its name, its playing range makes it the tenor member of the flute family. Because of the length of its tube (approximately 146 cm (57 in)), it is usually made with a J-shaped head joint, which brings the embouchure hole within reach of the player. It is usually only used in flute choirs, as it is easily drowned out by other instruments of comparable register, such as the clarinet. ','Woodwind',1),
(238,37,'Contralto Flute','The contra-alto flute is a large member of the flute family, pitched between the bass flute and the contrabass flute. It is a transposing instrument either in G (a perfect fourth below the bass flute, one octave below the alto flute) or in F (a perfect fifth below the bass flute, major ninth below the alto flute). The instrument\'s body is held vertically with an adjustable floor peg similar to that of the bass clarinet. ','Woodwind',1),
(239,39,'Contrabass Flute','The contrabass flute is one of the rarer members of the flute family. Typically seen in flute ensembles, it is sometimes also used in solo and chamber music situations. Its range is similar to that of the regular concert flute, except that it is pitched two octaves lower; the lowest performable note is two octaves below middle C (the lowest C on the cello). Many contrabass flutes in C are also equipped with a low B, (in the same manner as many modern standard sized flutes are.) Contrabass flutes are only available from select flute makers. ','Woodwind',1),
(240,544,'Conga drums','The conga, also known as tumbadora, is a tall, narrow, single-headed drum from Cuba. ','Percussion',1),
(241,542,'Bongo drums','Bongos are an Afro-Cuban percussion instrument consisting of a pair of small open bottomed hand drums of different sizes.','Percussion',1),
(242,543,'Timbales','Timbales or pailas are shallow single-headed drums with metal casing. They are shallower than single-headed tom-toms and usually tuned much higher, especially for their size. Timbales are struck with wooden sticks on the heads and shells, although bare hands are sometimes used. ','Percussion',1),
(243,554,'Guiro (gourd)','The güiro is a Latin American percussion instrument consisting of an open-ended, hollow gourd with parallel notches cut in one side. It is played by rubbing a stick or tines (see photo) along the notches to produce a ratchet sound. ','Percussion',1),
(244,555,'Claves','Claves are a percussion instrument consisting of a pair of short, wooden sticks about 20–25 centimeters (8–10 inches) long and about 2.5 centimeters (1 inch) in diameter.','Percussion',1),
(245,556,'Shekere','The shekere is a West African percussion instrument consisting of a dried gourd with beads or cowries woven into a net covering the gourd.','Percussion',1),
(246,455,'Woodblock','A wood block (also spelled as a single word, woodblock) is a small slit drum made from a single piece of wood. ','Percussion',1),
(247,385,'Tom-toms','A tom drum is a cylindrical drum with no snares, named from the Anglo-Indian and Sinhala language. It was added to the drum kit in the early part of the 20th century. Most toms range in size between 6 and 20 inches (15 and 51 cm) in diameter, though floor toms can go as large as 24 inches (61 cm).','Percussion',1),
(248,358,'String Bass or Contrabassoon','','Strings',1);
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
INSERT INTO `paper_sizes` VALUES
('B','Broadsheet','Many broadsheets measure roughly 29+1â„2 by 23+1â„2 in',23.50,29.50,0),
('F','Folio','Folio size, used for parts and some scores, is roughly equivalent to EU C4, which is 9 x 12.9',12.00,9.00,1),
('G','Legal','Legal size is taller than letter. Should be 8.5 x 14',14.00,8.50,1),
('L','Letter','Letter, roughly equivalent to A4, is used for choral scores and parts. Should be 8.5\" x 11\"',11.00,8.50,1),
('M','Marching band part','The standard for marching band flip folder parts is 6.75\"w x 5.25\"h',5.25,6.75,1),
('T','Tabloid','Tabloid, sometimes called ledger, is similar to A3.',17.00,11.00,1),
('V','Octavo','About an eighth the size of an unfolded newspaper, or 7 x 10.75',10.75,7.00,0);
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
-- No data for table `part_collections`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table holds kinds/types of parts for parts and part collections.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part_types`
--

LOCK TABLES `part_types` WRITE;
/*!40000 ALTER TABLE `part_types` DISABLE KEYS */;
INSERT INTO `part_types` VALUES
(1,40,'Piccolo in C','The piccolo is a half-size flute, and a member of the woodwind family of musical instruments.','Woodwind',1,NULL,1),
(2,60,'Flute','A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ','Woodwind',3,NULL,1),
(4,130,'Oboe','The oboe is a type of double reed woodwind instrument.','Woodwind',4,NULL,1),
(5,170,'English Horn','The English horn','Woodwind',5,NULL,1),
(6,320,'Bassoon','The bassoon is a woodwind instrument in the double reed family, which has a tenor and bass sound.','Woodwind',12,NULL,1),
(7,360,'Contrabassoon','The contrabassoon, also known as the double bassoon, is a larger version of the bassoon, sounding an octave lower.','Woodwind',13,NULL,1),
(8,180,'Clarinet in Eb','The E-flat (E♭) clarinet is a member of the clarinet family, smaller than the more common B♭ clarinet and pitched a perfect fourth higher.','Woodwind',6,NULL,1),
(9,190,'Clarinet in Bb','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',7,NULL,1),
(10,290,'Bass Clarinet','Bass clarinet is usually pitched in B♭ (meaning it is a transposing instrument on which a written C sounds as B♭), but it plays notes an octave below the soprano B♭ clarinet.','Woodwind',9,NULL,1),
(11,370,'Soprano Saxophone','The soprano saxophone is a higher-register variety of the saxophone.','Woodwind',15,NULL,1),
(12,380,'Alto Saxophone','The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',16,NULL,1),
(13,420,'Tenor Saxophone','The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',17,NULL,1),
(14,450,'Baritone Saxophone','The baritone saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',18,NULL,1),
(15,460,'Bass Saxophone','The bass saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',19,NULL,1),
(16,630,'Horn in F','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',25,NULL,1),
(17,550,'Trumpet in Bb','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(18,770,'Trombone','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',27,NULL,1),
(19,820,'Bass Trombone','A variation of the trombone family, considered the lower member of the trombone family.','Brass',28,NULL,1),
(20,850,'Baritone TC','The baritone horn, or sometimes just called baritone, is a valved, low-pitched brass instrument.','Brass',30,NULL,1),
(21,870,'Euphonium TC','Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.','Brass',31,NULL,1),
(22,890,'Tuba','The tuba is the lowest-pitched musical instrument in the brass family.','Brass',32,NULL,1),
(23,935,'Timpani','Timpani or kettledrums are musical instruments in the percussion family.','Percussion',36,NULL,1),
(24,1070,'Cymbals, crash','A cymbal is a common percussion instrument. Often used in pairs, cymbals consist of thin, normally round plates of various alloys.','Percussion',41,NULL,1),
(25,1200,'Agogo bells','An agogô (Yoruba: agogo, meaning bell) is a single or a multiple bell','Percussion',68,NULL,1),
(26,1100,'Triangle','The triangle is an idiophone type of musical instrument in the percussion family.','Percussion',44,NULL,1),
(27,1110,'Tam-Tam','A gong of indefinite pitch.','Percussion',51,NULL,1),
(28,1090,'Tambourine','The tambourine is a musical instrument in the percussion family consisting of a frame, often of wood or plastic, with pairs of small metal jingles, called \"zills\".','Percussion',43,NULL,1),
(29,1010,'Snare drum','The snare drum or side drum is a percussion instrument that produces a sharp staccato sound when the head is struck with a drum stick.','Percussion',37,NULL,1),
(30,1040,'Bass drum','The bass drum, or kick drum, is a large drum that produces a note of low definite or indefinite pitch.','Percussion',40,NULL,1),
(31,1160,'Marimba','A percussion instrument consisting of a set of wooden bars struck with yarn or rubber mallets to produce musical tones.','Percussion',64,NULL,1),
(32,1170,'Vibraphone','A percussion instrument that has tuned metal bars.','Percussion',65,NULL,1),
(33,1180,'Xylophone','A percussion instrument consisting of a set of graduated, tuned wooden bars supported at nodal (nonvibrating) points and struck with sticks or padded mallets.','Percussion',66,NULL,1),
(34,1190,'Chimes','Also called tubular bells, chimes produce a sound that resembles church bells, or a carillon.','Percussion',67,NULL,1),
(35,1220,'Harp','The harp is a stringed musical instrument that has a number of individual strings running at an angle to its soundboard; the strings are plucked with the fingers.','Percussion',72,NULL,1),
(36,1210,'Piano','The piano is an acoustic, stringed musical instrument in which the strings are struck by wooden hammers and is played using a keyboard.','Percussion',69,NULL,1),
(37,930,'String Bass',' The double bass, also known simply as the bass, is the largest and lowest-pitched bowed (or plucked) string instrument.','Strings',35,NULL,1),
(40,10,'Full score','The full conductor score contains all of the instrument parts','Other',NULL,0,1),
(41,20,'Condensed score','The condensed conductor score shows only the most relevant parts','Other',NULL,0,1),
(42,70,'Flute 1','A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ','Woodwind',3,NULL,1),
(43,80,'Flute 2','A flute is an aerophone or reedless wind instrument that produces its sound from the flow of air across an opening. ','Woodwind',3,NULL,1),
(44,210,'Clarinet in Bb 1','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',7,NULL,1),
(45,220,'Clarinet in Bb 2','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',7,NULL,1),
(46,230,'Clarinet in Bb 3','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',7,NULL,1),
(47,200,'Solo Clarinet in Bb','The clarinet has a single-reed mouthpiece, a straight, cylindrical tube with an almost cylindrical bore, and a flared bell.','Woodwind',7,NULL,1),
(48,390,'Alto Saxophone 1','The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',16,NULL,1),
(49,400,'Alto Saxophone 2','The saxophone is a type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',16,NULL,1),
(50,430,'Tenor Saxophone 1','The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',17,NULL,1),
(51,440,'Tenor Saxophone 2','The tenor saxophone is a medium-sized type of single-reed woodwind instrument with a conical body, usually made of brass.','Woodwind',17,NULL,1),
(52,640,'Horn in F 1','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',25,NULL,1),
(53,650,'Horn in F 2','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',25,NULL,1),
(54,660,'Horn in F 3','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',25,NULL,1),
(55,670,'Horn in F 4','The French horn (since the 1930s known simply as the \"horn\" in professional music circles) is a brass instrument made of tubing wrapped into a coil with a flared bell.','Brass',25,NULL,1),
(56,480,'Cornet 1','The cornet is a brass instrument commonly used in classical and jazz ensembles.','Brass',20,NULL,1),
(57,490,'Cornet 2','The cornet is a brass instrument commonly used in classical and jazz ensembles.','Brass',20,NULL,1),
(58,560,'Solo Trumpet in Bb','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(59,570,'Trumpet in Bb 1','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(60,580,'Trumpet in Bb 2','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(61,590,'Trumpet in Bb 3','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(62,600,'Trumpet in Bb 4','The trumpet is a brass instrument commonly used in classical and jazz ensembles.','Brass',23,NULL,1),
(63,780,'Trombone 1','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',27,NULL,1),
(64,790,'Trombone 2','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',27,NULL,1),
(65,800,'Trombone 3','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',27,NULL,1),
(66,810,'Trombone 4','Trombone is a brass instrument an extendable slide that can increase the length of the instruments tubing.','Brass',27,NULL,1),
(67,950,'Percussion 1','Is a part collection, but to what?','Percussion',37,2,1),
(68,960,'Percussion 2','','Percussion',37,2,1),
(69,970,'Percussion 3','','Percussion',37,3,1),
(70,980,'Percussion 4','','Percussion',37,2,1),
(71,1140,'Mallet Percussion','Combinations of pitched percussion instruments','Percussion',66,1,1),
(72,310,'Contrabass Clarinet in Bb','Bb Contrabass Clarinet','Woodwind',11,NULL,1),
(73,30,'C Instruments','Presumable for flutes and oboes','Woodwind',3,1,0),
(74,500,'Cornet 3','The cornet is a brass instrument commonly used in classical and jazz ensembles.','Brass',20,NULL,1),
(75,720,'Horn in Eb','Eb horn, Alto horn, \"peck horn\"','Brass',26,NULL,1),
(76,530,'Eb Cornet','A cornet keyed in Eb','Brass',21,NULL,1),
(77,1250,'Electric Bass','The electric bass is used in rock and jazz bands, and sometimes in concert band and wind ensemble arrangements.','Strings',75,NULL,1),
(78,1240,'Electric Guitar','The electric guitar is sometimes used in rock and jazz arrangements.','Strings',74,NULL,1),
(79,1130,'Drum set','The drum set is sometimes used in rock and jazz arrangements','Percussion',61,NULL,1),
(80,300,'Contralto Clarinet/Contrabass Clarinet in Eb','','Woodwind',10,NULL,1),
(81,280,'Alto Clarinet','','Woodwind',8,NULL,1),
(82,50,'Piccolo in Db','','Woodwind',2,NULL,1),
(83,860,'Baritone BC','','Brass',30,NULL,1),
(84,880,'Euphonium BC','Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.','Brass',31,NULL,1),
(85,795,'Trombone 1 & 2','Both Trombone 1 and Trombone 2 on one part.','Brass',27,1,1),
(86,940,'Percussion','','Percussion',37,1,1),
(87,140,'Oboe 1','','Woodwind',4,NULL,1),
(88,150,'Oboe 2','','Woodwind',4,NULL,1),
(89,160,'Oboe 1 & 2','','Woodwind',4,1,1),
(90,350,'Bassoon 1 & 2','','Woodwind',12,1,1),
(91,330,'Bassoon 1','','Woodwind',12,NULL,1),
(92,340,'Bassoon 2','','Woodwind',12,NULL,1),
(93,240,'Clarinet in Bb 4','','Woodwind',7,NULL,1),
(94,645,'Horn in F 1 & 2','','Brass',25,1,1),
(95,710,'Horn in F 3 & 4','','Brass',25,1,1),
(96,585,'Trumpet in Bb 1 & 2','','Brass',23,1,1),
(97,1080,'Cymbal, suspended','','Percussion',42,NULL,1),
(98,470,'Solo Cornet','','Brass',20,NULL,1),
(99,520,'Cornet 2 and 3','','Brass',20,1,1),
(100,540,'Bugles','','Brass',22,NULL,1),
(101,1030,'Snare Drum/Field Drum','','Percussion',37,NULL,1),
(102,1050,'Bass Drum/Cymbals','','Percussion',40,1,1),
(103,920,'Basses','','Brass',32,NULL,1),
(104,1150,'Bells','','Percussion',63,NULL,1),
(105,85,'Flute 1 & 2','','Woodwind',3,1,1),
(106,270,'Clarinet in Bb 3 & 4','','Woodwind',7,1,1),
(107,75,'Flute 1/Piccolo','','Woodwind',3,NULL,1),
(108,410,'Alto Saxophone 1 & 2','','Woodwind',16,1,1),
(109,90,'Flute 3','','Woodwind',3,NULL,1),
(110,120,'Flute 3 & Piccolo','','Woodwind',3,1,1),
(111,225,'Clarinet in Bb 1 & 2','','Woodwind',7,NULL,1),
(112,235,'Clarinet in Bb 2 & 3','','Woodwind',7,1,1),
(113,495,'Cornet 1 & 2','','Brass',20,1,1),
(114,595,'Trumpet in Bb 2 & 3','','Brass',23,1,1),
(115,645,'Horn in F 1 & 3','','Brass',25,1,1),
(116,655,'Horn in F 2 & 4','','Brass',25,1,1),
(117,730,'Horn in Eb 1','','Brass',26,NULL,1),
(118,740,'Horn in Eb 2','','Brass',26,NULL,1),
(119,750,'Horn in Eb 3','','Brass',26,NULL,1),
(120,760,'Horn in Eb 4','','Brass',26,NULL,1),
(121,805,'Trombone 2 & 3','','Brass',27,1,1),
(122,900,'Tuba 1','','Brass',32,NULL,1),
(123,910,'Tuba 2','','Brass',32,NULL,1),
(124,990,'Percussion 5','','Percussion',37,1,1),
(125,1020,'Field Drum','','Percussion',37,NULL,1),
(126,1060,'Cymbals','','Percussion',41,NULL,1),
(127,1120,'Gong','','Percussion',52,NULL,0),
(128,1085,'Auxiliary Percussion','','Percussion',50,NULL,1),
(129,1230,'Guitar','','Strings',73,NULL,1),
(130,55,'Piccolo and Flute','','Woodwind',1,1,1),
(131,745,'Horn in Eb 1 & 2','','Brass',26,1,1),
(132,765,'Horn in Eb 3 & 4','','Brass',26,2,1),
(133,822,'Tenor Horn in Bb','','Brass',30,NULL,0),
(134,823,'Tenor Horn in Bb 1','','Brass',30,NULL,1),
(135,824,'Tenor Horn in Bb 2','','Brass',30,NULL,0),
(136,825,'Tenor Horn in Bb 1 & 2','','Brass',30,1,1),
(137,826,'Tenor Horn in Bb 3','','Brass',30,NULL,1),
(138,995,'Drums','','Percussion',37,1,1),
(139,295,'Bass Clarinet & Contrabass Clarinet','','Woodwind',9,1,1),
(140,10,'Full Score [OVERSIZED]','','Other',NULL,NULL,1),
(141,525,'Cornet 4','','Brass',20,NULL,1),
(142,185,'Eb Clarinet and Sopranino Saxophone','','Woodwind',6,1,1),
(143,1155,'Glockenspiel','','Percussion',63,NULL,1),
(144,465,'Bass Saxophone and Contrabass Clarinet','','Woodwind',19,1,1),
(145,165,'Oboe 2 and English Horn','','Woodwind',4,1,1),
(146,291,'Bass Clarinet 1','','Woodwind',9,NULL,1),
(147,292,'Bass Clarinet 2','','Woodwind',9,NULL,1),
(150,881,'Euphonium BC 1','Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.','Brass',31,NULL,1),
(151,882,'Euphonium BC 2','Euphonium, a brass wind instrument with valves, is the leading instrument in the tenor-bass range in military bands.','Brass',31,NULL,1),
(152,86,'Flute 2 and Piccolo','','Woodwind',3,1,1),
(153,610,'Fluegelhorn','','Brass',24,NULL,1),
(154,611,'Fluegelhorn 1 and 2','','Brass',24,1,1),
(155,1215,'Organ','','Other',70,NULL,1),
(156,821,'Bb Trombone 1 (Treble Clef)','','Brass',27,NULL,1),
(157,822,'Bb Trombone 2 (Treble Clef)','','Brass',27,NULL,1),
(158,823,'Bb Trombone 3 (Treble Clef)','','Brass',27,NULL,1),
(161,921,'Bass 1','','Brass',32,NULL,1),
(162,922,'Bass 2','','Brass',32,NULL,1),
(163,923,'Eb Bass','','Brass',33,NULL,1),
(164,924,'Bb Bass','','Brass',32,NULL,1),
(165,931,'Double Bass','','Strings',35,NULL,1),
(166,961,'Percussion 2, 3','','Percussion',37,1,0),
(167,1141,'Mallet Percussion 1','','Percussion',66,NULL,1),
(168,1142,'Mallet Percussion 2','','Percussion',66,NULL,1),
(169,1152,'Orchestra Bells and Chimes','','Percussion',63,1,1),
(170,1171,'Vibraphone 1 and 2','','Percussion',65,1,1),
(171,936,'Timpani and Chimes','','Percussion',36,1,1),
(172,1153,'Bells and Marimba','','Percussion',63,1,1),
(173,125,'Flute 4','','Woodwind',3,NULL,1),
(174,991,'Percussion 6','','Percussion',37,1,1),
(175,992,'Percussion 7','','Percussion',37,1,1),
(176,42,'Piccolo 1 and 2','','Woodwind',1,1,1),
(177,202,'Solo Clarinet 1 and 2','','Woodwind',7,1,1),
(178,602,'Trumpet in Bb 3 & 4','','Brass',23,1,1),
(179,915,'Tuba in Bb','','Brass',32,NULL,1),
(180,915,'Tuba in Bb (Treble Clef)','','Brass',32,NULL,1),
(181,929,'Cello','','Strings',34,NULL,1),
(183,1101,'Brake Drum','','Percussion',48,NULL,1),
(184,1102,'Slide Whistle','','Other',49,NULL,1),
(185,1103,'Cowbell','','Percussion',50,NULL,1),
(186,526,'Cornet 3 and 4','','Brass',20,1,1),
(187,815,'Trombone 3 & 4','','Brass',27,1,1),
(188,571,'Trumpet 1 and Fluegelhorn','','Brass',23,1,1),
(189,851,'Baritone TC 1','','Brass',30,NULL,1),
(190,852,'Baritone TC 2','','Brass',30,NULL,1),
(191,861,'Baritone BC 1','','Brass',30,NULL,1),
(192,862,'Baritone BC 2','','Brass',30,NULL,1),
(193,923,'Basses 1 and 2','','Brass',32,NULL,1),
(194,654,'Horn in F 2 & 3','','Brass',25,1,1),
(195,1260,'Synthesizer','','Other',71,NULL,1),
(196,145,'Oboe 1 & English Horn','','Woodwind',4,1,1),
(197,1300,'Narrator','','Other',76,NULL,1),
(198,823,'Bb Trombone 1 (BC)','','Brass',27,NULL,1),
(199,823,'Bb Trombone 2 (BC)','','Brass',27,NULL,1),
(200,823,'Bb Trombone 3 (BC)','','Brass',27,NULL,1),
(201,863,'Bb Baritone (BC)','','Brass',30,NULL,1),
(203,201,'Solo Clarinet in Bb 1','','Woodwind',7,NULL,1),
(204,201,'Solo Clarinet in Bb 2','','Woodwind',7,NULL,1),
(205,1031,'Snare Drum and Tam-Tam','','Percussion',37,1,1),
(206,41,'Piccolo 1','','Woodwind',1,NULL,1),
(207,41,'Piccolo 2','','Woodwind',1,NULL,1),
(208,999,'Drums and Bells','','Percussion',37,1,1),
(209,1081,'Suspended Cymbal, Large Tom','','Percussion',42,1,1),
(210,285,'Basset Horn','','Woodwind',235,NULL,1),
(211,127,'Alto Flute','','Woodwind',236,NULL,1),
(212,129,'Bass Flute','','Woodwind',237,NULL,1),
(213,932,'String Bass or Bassoon','','Strings',35,NULL,1),
(214,126,'Flute 5','','Woodwind',3,NULL,1),
(215,126,'Flute 6','','Woodwind',3,NULL,1),
(216,129,'Contralto Flute','','Woodwind',238,NULL,1),
(217,129,'Contrabass Flute','','Woodwind',239,NULL,1),
(218,355,'Bassoon or Bass Clarinet','','Woodwind',12,NULL,1),
(219,271,'Clarinet in Bb 5','','Woodwind',7,NULL,1),
(220,933,'String Bass or Contrabassoon','','Strings',1,NULL,1);
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
-- No data for table `parts`
--

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
  PRIMARY KEY (`password_reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordings`
--

DROP TABLE IF EXISTS `recordings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recordings` (
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
  CONSTRAINT `recordings_ibfk_1` FOREIGN KEY (`catalog_number`) REFERENCES `compositions` (`catalog_number`)
) ENGINE=InnoDB AUTO_INCREMENT=1025 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps recordings.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- No data for table `recordings`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='This table keeps users.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin','$2y$10$fhhvTweAEHU224hcrpwEzunmBn5oOn6tFvc727Y7k2q66uSrU4kOu','Music Library Administrator','admin@musiclibrarydb.com','administrator'),
(2,'librarian','$2y$10$fhhvTweAEHU224hcrpwEzunmBn5oOn6tFvc727Y7k2q66uSrU4kOu','My Librarian','librarian@musiclibrarydb.com','user librarian administrator'),
(3,'user','$2y$10$fhhvTweAEHU224hcrpwEzunmBn5oOn6tFvc727Y7k2q66uSrU4kOu','Wind Player','user@musiclibrarydb.com','user');
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

-- Dump completed on 2025-06-08 10:46:24
