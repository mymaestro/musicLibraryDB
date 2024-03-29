<?php
require_once('config.php');
require_once('functions.php');

ferror_log("======= Running select_partcollections.php with id=". $_POST["catalog_number_key"] . ":" . $_POST["id_part_type_key"] . ":". $_POST["id_instrument_key"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['catalog_number_key'])) $catalog_number_key = mysqli_real_escape_string($f_link, $_POST['catalog_number_key']);
if (isset($_POST['id_part_type_key'])) $id_part_type_key = mysqli_real_escape_string($f_link, $_POST['id_part_type_key']);
if (isset($_POST['id_instrument_key'])) $id_instrument_key = mysqli_real_escape_string($f_link, $_POST['id_instrument_key']);

if (isset($catalog_number_key) && isset($id_part_type_key) && isset($id_instrument_key)) {
    $output = '
    <div class="table-responsive">
    <table class="table table-striped table-condensed">';
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT k.catalog_number_key   'Catalog number',
                   c.name                 'Composition',
                   k.id_part_type_key     'Part type key',
                   y.name                 'Part type',
                   k.id_instrument_key        'Instrument key',
                   i.name                 'Instrument',
                   k.name                 'Name',
                   k.description          'Description',
                   k.last_update          'Updated'
            FROM   part_collections k
            LEFT JOIN  compositions c ON c.catalog_number = k.catalog_number_key
            LEFT JOIN  part_types y ON y.id_part_type = k.id_part_type_key
            LEFT JOIN  instruments i ON i.id_instrument_key = k.id_instrument_key
            WHERE k.catalog_number_key = '" . $catalog_number_key . "' AND k.id_part_type_key = " . $id_part_type_key . " AND k.id_instrument_key = " . $id_instrument_key .";";
    ferror_log("Running SQL: ". $sql);
    if ($res = mysqli_query($f_link, $sql)) {
        $col = 0;
        while ($fieldinfo = mysqli_fetch_field($res)) {
            $fields[$col] =  $fieldinfo -> name;
            $col++;
        }
        while ($rowList = mysqli_fetch_array($res, MYSQLI_NUM)) {
            for ($row = 0; $row < $col; $row++) {
                $output .= '<tr><td><strong>'. $fields[$row] . '</strong></td>';
                $output .= '<td id="'.$fields[$row].'-data">'. $rowList[$row] . '</td></tr>';
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
