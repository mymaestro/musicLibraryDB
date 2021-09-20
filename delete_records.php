<?php  
 //delete_records.php
 // remodel to fit music library database
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running delete_records.php");
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$output = '';
$message = '';
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    $table_name = $_POST["table_name"];
    $table_key_name = $_POST["table_key_name"];
    $table_key = $_POST["table_key"];

    error_log("table=". $table_name );
    error_log("table key=". $table_key);
    error_log("table key name=". $table_key_name);
    
    if($_POST["table_name"] != '') {
        $sql = "
        DELETE FROM " . $table_name . " 
        WHERE ".$table_key_name . " = '".$table_key."'";
        $res = mysqli_query($f_link, $sql);
        $message = 'Deleted';
        error_log("Delete SQL: " . $sql);
    } else {
        $created = date('Y-m-d H:i:s.u');
        $sql = "";
        error_log("Delete SQL (N/A): " . $sql);
        $message = 'No data deleted';
    }
echo json_encode($message);
}
?>