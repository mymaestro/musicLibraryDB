<?php
require_once 'includes/config.php';
// Get the faker
require_once 'faker/autoload.php';
require_once 'includes/functions.php';

$trial_Run = FALSE;

$faker = Faker\Factory::create();

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*
  Things that are the same each time
*/
// classid: One of the records in classes table
$classid = 5;
$port = 5900;
$platform = "Linux";
$expires = "2018-12-31";
/*
  Things that change every time
*/

// id: Unique ID, auto-increments
// timestamp: Row created, auto-generated
$timestamp = time();
    echo "Timestamp: $timestamp\n";
// ip: Address of the client browser that entered the form
$ip = 70113;
    echo "IP: $ip\n";
// host: Host name or IP address
$host = $faker -> localIpv4();
//$host = "10.10.11.11";
// token: Unique ID for hosts
$token = $faker -> regexify('[A-Z]+[0-9]{3,5}');
$created = "2018-03-01";

$sql = 'INSERT INTO vnc_targets (timestamp, ip, host, port, token, classid, platform, created, expires) VALUES ( ';
$sql_values = "$timestamp, $ip, " . '"' .
mysqli_real_escape_string($f_link, $host) . '", "' .
$port . '", "' .
mysqli_real_escape_string($f_link, $token) . '", "' .
$classid . '", "' .
mysqli_real_escape_string($f_link, $platform) . '", "' .
$created . '", "' .
$expires .'" );';
echo "-----------------\n";
echo "SQL string\n";
echo "-----------------\n";
echo "$sql $sql_values\n";
$sql = $sql . $sql_values;

if (!$trial_Run) {
	if (!mysqli_query($f_link, $sql)) {
	    die('Error: ' . mysqli_error());
	} else {
		echo "Inserted.\n";
	}
	mysqli_close($f_link);
}
?>