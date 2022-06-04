<?php
require_once('config.php');
require_once('functions.php');

ferror_log("Running select_partcollections.php with id=". $_POST["catalog_number_key"] . ":" . $_POST["id_part_type_key"] . ":". $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number_key = mysqli_real_escape_string($f_link, $_POST['catalog_number_key']);
$id_part_type_key = mysqli_real_escape_string($f_link, $_POST['id_part_type_key']);
$id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);

if (isset($id_part_type) && isset($id_part_type_key) && isset($catalog_number_key)) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM part_collections
            WHERE catalog_number_key = '" . $catalog_number_key . "' AND id_part_type_key = " . $id_part_type_key . " AND id_part_type = " . $id_part_type .";";
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><label>Name</label></td>
                <td>'.$rowList["name"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>
            <tr>
                <td><label>Collection for</label></td>
                <td>'.$rowList["catalog_number_key"].':'.$rowList["id_part_type_key"].'</td>
            <tr>
                <td><label>Part type key</label></td>
                <td>'.$rowList["id_part_type_key"].'</td>
            </tr>
            <tr>
                <td><label>Part type</label></td>
                <td>'.$rowList["id_part_type"].'</td>
            </tr>
            <tr>
                <td><label>Enabled</label></td>
                <td>'. (($rowList["enabled"] == 1) ? "Yes" : "No") .'</td>
            </tr>
            ';
    }
    $output .= '
        </table>
    </div>
    ';
    echo $output;
}
?>
