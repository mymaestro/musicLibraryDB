<?php  
 //fetch_papersizes.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_papersizes.php with id=". $_POST["id_paper_size"]);
if(isset($_POST["id_paper_size"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM paper_sizes WHERE id_paper_size = '".$_POST["id_paper_size"]."'";
    error_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>