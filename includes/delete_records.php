<?php  
 //delete_records.php
 // remodel to fit music library database
require_once('config.php');
require_once('functions.php');
error_log("Running delete_records.php");
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['table_name'])) $table_name = mysqli_real_escape_string($f_link, $_POST['table_name']);
if (isset($_POST["table_key_name"])) $table_key_name = mysqli_real_escape_string($f_link, $_POST['table_key_name']);
if (isset($_POST["table_key"])) $table_key = mysqli_real_escape_string($f_link, $_POST['table_key']);

if (isset($table_name) && isset($table_key_name) && isset($table_key)) {
    $timestamp = time();
    ferror_log("table=". $table_name );
    ferror_log("table key=". $table_key);
    ferror_log("table key name=". $table_key_name);

    $sql = "DELETE FROM " . $table_name . " WHERE ".$table_key_name . " = '".$table_key."'";
    if(mysqli_query($f_link, $sql)){
        echo '<p class="text-success">Record '.$table_key.' deleted from '.$table_name.'</p>';
        ferror_log("Delete SQL: " . $sql);
    } else {
        $error_message = mysqli_error($f_link);
        echo '<p class="text-danger">Error deleting <emp>'.$table_key.'</emp> from '.$table_name.'.</p><p>Error message:<br/>'. $error_message . '</p>';
        ferror_log("Command:" . $sql);
        ferror_log("Error: " . $error_message);
    }
}
?>