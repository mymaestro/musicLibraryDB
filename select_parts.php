<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING select_parts.php with id_part=". $_POST["catalog_number"] . "-" . $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
$id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
if (isset($_POST["id_part_type"])) {
    $output = "";
    $sql = "SELECT p.catalog_number,
        c.name title,
        p.id_part_type,
        t.name type,
        p.name,
        p.description,
        p.is_part_collection,
        p.paper_size,
        z.name size,
        p.page_count,
        p.image_path,
        p.originals_count,
        p.copies_count
    FROM   parts p
    LEFT JOIN compositions c ON c.catalog_number = p.catalog_number
    LEFT JOIN part_types t ON t.id_part_type = p.id_part_type
    LEFT JOIN paper_sizes z ON z.id_paper_size = p.paper_size
    WHERE  p.catalog_number = '" . $catalog_number . "'
    AND    p.id_part_type = " . $id_part_type .";";
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><label>Composition</label></td>
                <td>'.$rowList["catalog_number"].' - <em>'. $rowList["title"] .'</em></td>
            </tr>
            <tr>
                <td><label>Part name</label></td>
                <td>'.$rowList["name"].'</td>
            </tr>
            <tr>
                <td><label>Part type</label></td>
                <td>'.$rowList["type"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>
            <tr>
                <td><label>Paper size</label></td>
                <td>'.$rowList["size"].'</td>
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