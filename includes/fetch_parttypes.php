<?php  
 //fetch_parttypes.php
require_once('config.php');
require_once('functions.php');
error_log("Running fetch_parttypes.php with id=". $_POST["id_part_type"]);
if(isset($_POST["id_part_type"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM part_types WHERE id_part_type = '".$_POST["id_part_type"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>