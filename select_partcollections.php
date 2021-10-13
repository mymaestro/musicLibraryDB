<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select_partcollections.php with id=". $_POST["is_part_collection"]);
if (isset($_POST["is_part_collection"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM part_collections WHERE is_part_collection = '".$_POST["is_part_collection"]."'";
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