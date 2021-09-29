<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select_parts.php with id=". $_POST["id_part"]);
if (isset($_POST["id_part_type"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM parts WHERE id_part = '".$_POST["id_part"]."'";
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><label>Catalog number</label></td>
                <td>'.$rowList["catalog_number"].'</td>
            </tr>
            <tr>
                <td><label>Name</label></td>
                <td>'.$rowList["name"].'</td>
            </tr>
            <tr>
                <td><label>Part type</label></td>
                <td>'.$rowList["id_part_type"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>
            <tr>
                <td><label>Paper size</label></td>
                <td>'.$rowList["paper_size"].'</td>
            </tr>
            <tr>
                <td><label>Pages</label></td>
                <td>'.$rowList["page_count"].'</td>
            </tr>
            <tr>
                <td><label>Originals</label></td>
                <td>'.$rowList["originals_count"].'</td>
            </tr>
            <tr>
                <td><label>Copies</label></td>
                <td>'.$rowList["copies_count"].'</td>
            </tr>
            <tr>
                <td><label>Image path</label></td>
                <td>'.$rowList["image_path"].'</td>
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