<?php  
 //fetch_recordings.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_recordings.php with id=". $_POST["id_recording"]);
if(isset($_POST["id_recording"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM recordings WHERE id_recording = '".$_POST["id_recording"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>