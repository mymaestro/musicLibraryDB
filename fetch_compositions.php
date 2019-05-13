<?php  
 //fetch_compositions.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_compositions.php with id=". $_POST["catalog_number"]);
if(isset($_POST["catalog_number"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM compositions WHERE catalog_number = '".$_POST["catalog_number"]."'";
    error_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>