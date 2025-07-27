# musicLibraryDB

A comprehensive web-based music library management system designed for concert bands, wind ensembles, orchestras, and other large musical groups. Track your sheet music collection, manage parts, organize concerts, and maintain performance recordings with this full-featured database application.

## 🎵 Overview

The musicLibraryDB is a sophisticated music library management system that helps music organizations:

- **Catalog compositions** with detailed metadata (composer, arranger, grade, genre, etc.)
- **Manage sheet music parts** for different instruments and sections
- **Organize concerts and programs** with playgrams (concert playlists)
- **Store and manage performance recordings** with audio file uploads
- **Track instrument parts** and their physical storage locations
- **Generate reports** about your music collection
- **Control access** with user roles and permissions

Whether you're managing a small community band library or a large institutional collection, musicLibraryDB scales to meet your needs.

## 🏗️ System Architecture

**Technology Stack:**
- **Backend**: PHP 7.4+ with MySQL/MariaDB
- **Frontend**: Bootstrap 5 responsive web interface
- **Audio Processing**: getID3 library for metadata extraction
- **Web Server**: Apache/Nginx (LAMP/LEMP stack)

**Key Features:**
- Role-based access control (Administrator, Librarian, User)
- Responsive design that works on desktop, tablet, and mobile
- Audio file upload with automatic metadata tagging
- Full-text search across compositions
- Part distribution tracking for concerts
- Paper size management for physical parts

## 📋 Requirements

### System Requirements
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: 7.4 or higher with extensions:
  - `mysqli` (MySQL/MariaDB connectivity)
  - `json` (JSON handling)
  - `fileinfo` (file type detection)
  - `mbstring` (multibyte string handling)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Storage**: Minimum 500MB for application + space for recordings and parts

### Browser Support
- Chrome 90+ (recommended)
- Firefox 88+
- Safari 14+
- Edge 90+

## 🚀 Installation

### Step 1: Download and Setup Files

```bash
# Clone to your web server's document root
cd /var/www/html
git clone https://github.com/yourusername/musicLibraryDB.git
cd musicLibraryDB

# Set proper permissions
chmod 755 .
chmod -R 755 includes/
chmod -R 777 files/  # For file uploads
```

### Step 2: Database Setup

Create your database and user:

```sql
CREATE DATABASE musicLibraryDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'musicLibraryDB'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON musicLibraryDB.* TO 'musicLibraryDB'@'localhost';
FLUSH PRIVILEGES;
```

Choose and import one of the SQL setup files from the `setup/` directory:

- **musicLibraryDB-core.sql** - Minimal setup with empty tables and default admin user
- **musicLibraryDB-basic.sql** - Includes basic data (instruments, genres, paper sizes)
- **musicLibraryDB-demo.sql** - Full demo with sample compositions and recordings

```sql
USE musicLibraryDB;
SOURCE setup/musicLibraryDB-basic.sql;
```

### Step 3: Configuration

Copy the example configuration file and customize it:

```bash
cd includes/
cp config.example.php config.php
```

Edit `config.php` with your settings:

```php
define('ORGNAME', 'Your Ensemble Name or acronym');
define('ORGDESC', 'Your Full Organization Name');
define('ORDLOGO', 'images/logo.png'); // Your band's logo
define('ORGMAIL', 'librarian@musiclibrarydb.com'); // Your email address
define('ORGHOME', 'https://yourdomain.com/musicLibraryDB/'); // Where this library lives on the web
// File locations
define('ORGRECORDINGS', 'https://yourdomain.com/musicLibraryDB/files/recordings/'); // Where browsers can find your MP3s
define('ORGPARTDISTRO', 'https://yourdomain.com/distributions/'); // Where the browser can download ZIP file for parts distribution
define('ORGPUBLIC', 'files/recordings/'); // Directory with public access, to download recordings
define('ORGPRIVATE','files/parts/'); // Where your parts PDF files are stored. Protect from browsing
define('ORGDIST','files/distributions/'); // Where to put ZIP files of parts for each section.
define('ORGUPLOADS','files/uploads/'); // TBD

define('DB_HOST', 'localhost');
define('DB_NAME', 'musicLibraryDB');
define('DB_USER', 'musicLibraryDB');
define('DB_PASS', 'your_secure_password');
define('DB_CHARSET','utf8mb4');

define('REGION','HOME');
define('DEBUG', 1); // Set verbose logging to error_log
```

### Step 4: File Permissions and Directories

Ensure the web server can write to upload directories:

```bash
mkdir -p files/recordings files/parts files/distributions
chmod -R 755 files/
chown -R www-data:www-data files/  # Use your web server user
```

### Step 5: First Login

1. Navigate to your installation URL: `https://yourdomain.com/musicLibraryDB/`
2. Click the login icon (🔒) in the navigation bar
3. Use the default credentials:
   - **Username**: `librarian`
   - **Password**: `superS3cretPa$$wo4d`
4. **Important**: Change the default password immediately!

## 📊 Database Schema

### Core Tables

**compositions** - The heart of your music library
- Catalog numbers, titles, composers, arrangers
- Difficulty grades, performance notes, storage locations
- Links to genres, ensembles, and paper sizes

**parts** - Individual instrument parts for each composition
- Links parts to compositions and part types
- Tracks physical copies, page counts, and storage

**concerts** - Performance events
- Links to playgrams (concert programs)
- Venue, date, conductor information

**recordings** - Audio/video recordings of performances
- Links recordings to specific concerts and compositions
- Supports file uploads with metadata extraction

**playgrams** - Concert programs/playlists
- Groups compositions into performance programs
- Supports multiple concerts per playgram

### Supporting Tables

- **part_types** - Instrument part definitions (Flute 1, Trumpet 2, etc.)
- **instruments** - Master list of all instruments
- **genres** - Music classifications (March, Jazz, Classical, etc.)
- **ensembles** - Performing groups (Wind Ensemble, Brass Quintet, etc.)
- **paper_sizes** - Physical dimensions of sheet music
- **users** - System users with role-based permissions

## 🎭 Understanding Music Library Concepts

### For Non-Musicians

If you're not familiar with large group music organization, here are key concepts:

**Composition vs. Parts**
- A **composition** is a complete musical work (like "Stars and Stripes Forever")
- **Parts** are individual sheets for each instrument (Flute 1 part, Trumpet 2 part, etc.)
- One composition might have 20-50 different parts for a full band

**Playgrams (Concert Programs)**
- A **playgram** is a playlist of compositions for a concert
- Like a setlist, it defines the order of pieces to be performed
- One playgram can be used for multiple concert performances

**Ensembles and Instrumentation**
- **Ensembles** are different sized groups (Full Band, Brass Quintet, etc.)
- Each composition specifies which ensemble can perform it
- Different ensembles require different instrumental parts

**Grading System**
- Music is graded 1-6 based on difficulty
- Grade 1: Beginner/Elementary
- Grade 6: Professional/Advanced

## 📖 User Guide

### User Roles

**Administrator**
- Full system access
- User management
- System configuration
- Can enable/disable any feature

**Librarian**
- Add/edit compositions, parts, concerts
- Manage recordings and file uploads
- Generate reports
- Most day-to-day operations

**User**
- View-only access to browse the library
- Search compositions and recordings
- Cannot modify data

### Main Functions

#### Managing Compositions
1. **Add New Composition**: Enter title, composer, catalog number, difficulty grade
2. **Set Instrumentation**: Define which parts exist for this piece
3. **Track Physical Location**: Note where sheet music is stored
4. **Performance History**: Record when and where performed

#### Working with Parts
1. **Part Types**: Define instrument parts (Clarinet 1, Horn 2, etc.)
2. **Physical Parts**: Track original vs. copies, page counts
3. **Part Collections**: Group multiple instruments on one part (Percussion 1)
4. **Storage**: Note physical location and paper size

#### Planning Concerts
1. **Create Playgram**: Build a concert program/playlist
2. **Add Compositions**: Select pieces and set performance order
3. **Schedule Concert**: Set date, venue, conductor
4. **Generate Parts List**: See which parts are needed

#### Managing Recordings
1. **Upload Audio Files**: MP3 files with automatic metadata tagging
2. **Link to Concerts**: Connect recordings to specific performances
3. **Organize by Date**: Browse recordings by performance date
4. **Audio Playback**: Built-in player for listening to recordings

### Navigation

**Main Pages:**
- **Dashboard** - Overview statistics and quick access
- **Search** - Browse and search your library
- **Enter** - Data entry and management (librarians only)
- **Reports** - Generated lists and statistics

**Data Management:**
- **Compositions** - Main music catalog
- **Parts** - Individual instrument parts
- **Concerts** - Performance events
- **Recordings** - Audio/video files
- **Playgrams** - Concert programs

## 🔧 Configuration Options

### Upload Limits
Adjust PHP settings for larger files:
```ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
```

## 🛠️ Administration

### User Management
1. Navigate to **Users** (administrators only)
2. Add new users with appropriate roles
3. Users can be: `administrator`, `librarian`, `user`, or combinations

### Backup Procedures
```bash
# Database backup
mysqldump -u musicLibraryDB -p musicLibraryDB > backup_$(date +%Y%m%d).sql

# File backup  
tar -czf files_backup_$(date +%Y%m%d).tar.gz files/
```

### Security Best Practices
1. **Change default passwords** immediately
2. **Use HTTPS** for all access
3. **Regular backups** of database and files
4. **Limit file upload types** to audio formats only
5. **Keep PHP and database updated**

## 📈 Reporting Features

The system includes several built-in reports:

- **Composition Statistics** - Counts by genre, grade, ensemble
- **Parts Inventory** - Missing parts, copy counts
- **Concert History** - Performance frequency, popular pieces
- **Recording Catalog** - Available recordings by composition
- **Custom Searches** - Filter by any combination of criteria

## 🚫 Troubleshooting

### Common Issues

**"Database connection failed"**
- Check database credentials in `config.php`
- Verify database server is running
- Confirm user permissions

**File upload errors**
- Check directory permissions (755 for directories, 644 for files)
- Verify PHP upload settings
- Ensure adequate disk space

**Audio files not playing**
- Confirm file format is supported (MP3, WAV)
- Check file path configuration
- Verify web server can serve media files

**Permission denied errors**
- Check user roles in database
- Verify session is active
- Confirm role-based access controls

### Debug Mode
Enable debug mode in `config.php`:
```php
define('DEBUG', 1);
```

This provides detailed error logging to help diagnose issues.

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the repository
2. Create a feature branch
3. Submit a pull request with clear documentation
4. Include tests for new functionality

### Development Setup
```bash
# Enable error reporting for development
define('DEBUG', 1);

# Use a separate development database
define('DB_NAME', 'musicLibraryDB_dev');
```

## 📝 License

This project is licensed under the terms specified in the source files. Please see individual file headers for copyright and licensing information.

## 🙋 Support

- **Documentation**: This README and in-app help
- **Issues**: Report bugs via GitHub issues
- **Discussions**: Community support and feature requests

## 🗺️ Roadmap

Future enhancements may include:

- **API Development** - REST API for external integrations
- **Mobile App** - Native mobile applications
- **Advanced Reporting** - More detailed analytics and exports
- **Digital Scores** - PDF storage and viewing
- **Inventory Management** - Physical music tracking with barcodes
- **Practice Room Integration** - Part checkout system

---

## Quick Start Checklist

- [ ] Install LAMP/LEMP stack
- [ ] Create database and import schema
- [ ] Configure `config.php` with your settings
- [ ] Set file permissions for uploads
- [ ] Login with default credentials
- [ ] Change default password
- [ ] Add your first composition
- [ ] Create user accounts for your organization
- [ ] Upload your logo
- [ ] Begin cataloging your music library!

---

*The musicLibraryDB system was designed by and for musicians who understand the unique challenges of managing large music libraries. Whether you're running a community band, school ensemble, or professional organization, this system provides the tools you need to keep your music organized and accessible.*
