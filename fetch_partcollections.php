<?php  
 //fetch_collections.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_partcollections.php with id=". $_POST["is_part_collection"]);
if(isset($_POST["is_part_collection"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM part_collections WHERE is_part_collection = '".$_POST["is_part_collection"]."'";
    error_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>