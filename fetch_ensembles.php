<?php  
 //fetch_ensembles.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_ensemble.php with id_ensemble=". $_POST["id_ensemble"]);
if(isset($_POST["id_ensemble"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM ensembles WHERE id_ensemble = '".$_POST["id_ensemble"]."'";
    error_log("Running SQL: " . $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);  
    echo json_encode($rowList);
}
?>