<?php  
 //fetch_parts.php
require_once('config.php');
require_once('functions.php');
error_log("Running fetch_composition_parts.php with id=". $_POST["catalog_number"]);

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);

if(isset($catalog_number)) {
    $sql = "SELECT catalog_number, id_part_type FROM parts WHERE catalog_number = '" . $catalog_number ."';";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $counter = 0;
    $jsondata = "{";
    while($rowList = mysqli_fetch_array($res)) {
        $counter += 1;
        $part_type = $rowList['id_part_type'];
        $jsondata .= '"'.$counter.'": "'. $part_type . '",';
    }
    $jsondata = rtrim($jsondata, ',');
    $jsondata .= '}'.PHP_EOL;
    mysqli_close($f_link);
    ferror_log("JSON: ". $jsondata);
    echo $jsondata;
}
?>
