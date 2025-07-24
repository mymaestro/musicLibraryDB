<?php
// includes/fetch_parttypes_list.php
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT id_part_type, name FROM part_types WHERE enabled = 1 ORDER BY collation";
$res = mysqli_query($f_link, $sql);
$parttypes = [];
while ($row = mysqli_fetch_assoc($res)) {
    $parttypes[] = $row;
}
mysqli_close($f_link);
header('Content-Type: application/json');
echo json_encode($parttypes);
?>