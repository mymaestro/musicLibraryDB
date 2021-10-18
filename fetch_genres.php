<?php  
 //fetch_genres.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running fetch_genres.php with id=". $_POST["id_genre"]);
if(isset($_POST["id_genre"])) {
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM genres WHERE id_genre = '".$_POST["id_genre"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
}
?>