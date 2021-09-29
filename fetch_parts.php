<?php  
 //fetch_parts.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_parts.php with id=". $_POST["id_part"]);
if(isset($_POST["id_part_type"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM parts WHERE id_part = '".$_POST["id_part"]."'";
    error_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>