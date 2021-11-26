<?php  
 //fetch_parts.php
require_once('config.php');
require_once('functions.php');
error_log("Running fetch_parts.php with id=". $_POST["catalog_number"] . ":" . $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
$id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
if(isset($id_part_type) && (isset($catalog_number))) {
    $sql = "SELECT * FROM parts WHERE catalog_number = '" . $catalog_number . "' AND id_part_type = " . $id_part_type .";";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>
