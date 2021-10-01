# INSERT INTO `compositions` (`catalog_number`, `name`, `composer`, `arranger`, `publisher`, `genre`, `last_performance_date`, `comments`, `description`)  VALUES ('C155', 'Fiddler on the Roof', 'Bock, Jerry', 'Burden, James H.', 'Sunbeam Music', 'SH', '01-01-1970', '', '(Selections From)');
LOAD DATA INFILE 'ACWE_compositions.csv'
INTO TABLE compositions
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(catalog_number, name, composer, arranger, publisher, genre, @last_performance_date, comments, description)
SET last_performance_date = STR_TO_DATE(@last_performance_date, '%m-%d-%Y');
