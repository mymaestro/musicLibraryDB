<?php  
 //fetch_collections.php
require_once('includes/config.php');
require_once('includes/functions.php');
if(isset($_POST["catalog_number_key"])) {
    ferror_log("Running fetch_partcollections.php with id=". $_POST["catalog_number_key"]);
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM part_collections WHERE catalog_number_key = '".$_POST["catalog_number_key"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>