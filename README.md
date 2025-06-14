# musicLibraryDB
Database schema and supporting documents for a music library database to track the band (or chorus) music

## To do:
- Write documentation
- Improve user experience
- Provide installation instructions
- Promote

## Notes:
- Runs on a LAMP stack (MariaDB/Mysql and PHP)
- No installer, some manual work will have to happen.

# Installation
Clone the repo into your web site's html folder.
You must create a database. Here's how I did it with MariaDB:

```sql
create database musicLibraryDB;
grant all privileges on musicLibraryDB.* to 'musicLibraryDB'@'localhost' identified by 'superS3cretPa$$wo4d';
flush privileges;
```

Then, you can load the samples (or just the basics, or just the framework). There are 3 SQL files in the setup folder:

- musicLibraryDB-core.sql - Only the tables and schema, no data except for users.
- musicLibraryDB-basic.sql - Basics to get you started: all the paper types, instruments, genre, and part types
- musicLibraryDB-demo.sql - Full demo with all the basics, plus some sample data with compositions and recordings

After you create the database, import one of the SQL files.

```sql
use musicLibraryDB;
source musicLibraryDB.sql
```

After that, go into the includes directory and copy *config.example.php* to *config.php*.
Then, edit *config.php* to match whatever settings you want.


- Open the web page.
- Login (choose the padlock icon in the nav bar).
    - User: librarian
    - Pass: superS3cretPa$$wo4d
- Have fun.

## Errata
When you delete an item from tables, it doesn't refresh the table, it just shows you "Record `n` deleted from `table`"