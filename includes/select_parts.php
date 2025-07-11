<?php
require_once('config.php');
require_once('functions.php');
/* called by parts.php when user selects "View" */
ferror_log("RUNNING select_parts.php with id_part=". $_POST["catalog_number"] . "-" . $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
$id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
if (isset($_POST["id_part_type"])) {
    $output = "";
    $sql = "SELECT p.catalog_number       'Catalog',
                   p.id_part_type         'Part type ID',
                   c.name                 'Composition',
                   c.composer             'Composer',
                   t.name                 'Type',
                   p.name                 'Part name',
                   p.description          'Description',
                   p.is_part_collection   'Instruments in collection',
                   z.name                 'Paper size',
                   p.page_count           'Pages',
                   p.originals_count      'Originals',
                   p.copies_count         'Copies',
                   p.image_path           'Digital image',
                   p.last_update          'Last updated'
    FROM   parts p
    LEFT JOIN compositions c ON c.catalog_number = p.catalog_number
    LEFT JOIN part_types t ON t.id_part_type = p.id_part_type
    LEFT JOIN paper_sizes z ON z.id_paper_size = p.paper_size
    WHERE  p.catalog_number = '" . $catalog_number . "'
    AND    p.id_part_type = " . $id_part_type .";";

    $output .= '
    <div class="table-responsive">
        <table class="table table-striped table-condensed">';

    if ($res = mysqli_query($f_link, $sql)) {
        $col = 0;
        while ($fieldinfo = mysqli_fetch_field($res)) {
            $fields[$col] =  $fieldinfo -> name;
            $col++;
        }
        while ($rowList = mysqli_fetch_array($res, MYSQLI_NUM)) {
            for ($row = 0; $row < $col; $row++) {
                $output .= '<tr><td><strong>'. $fields[$row] . '</strong></td>';
                $output .= '<td>'. $rowList[$row] . '</td></tr>';
            }
        }
    }
    $output .= '
        </table>
    </div>
    ';
    echo $output;
}
?>
