# musicLibraryDB
Database schema and supporting documents for a music library database to track the band (or chorus) music

## To do:
- Write documentation
- Improve user experience
- Provide installation instructions
- Promote

## Notes:
- The Grade level (1-7) slider does actually work. You just can't see exactly what number it's set at.


# Installation
Write some install commands here:

You must create a database. Here's how I did it with MariaDB:

```sql
create database musicLibraryDB;
grant all privileges on musicLibraryDB.* to 'musicLibraryDB'@'localhost' identified by 'superS3cretPa$$wo4d';
flush privileges;
```