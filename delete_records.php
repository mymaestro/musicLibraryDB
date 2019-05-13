<?php  
 //delete_records.php
 // remodel to fit music library database
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running delete_records.php with id=". $_POST["vnctarget_id"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$output = '';
$message = '';
if(!empty($_POST)) {
    if($_POST["vnctarget_id"] != '') {
        $sql = "
        DELETE FROM vnc_targets 
        WHERE id='".$_POST["vnctarget_id"]."'";
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
?>
