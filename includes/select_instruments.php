<?php
require_once('config.php');
require_once('functions.php');
error_log("Running select_instruments.php with id=". $_POST["id_instrument"]);
if (isset($_POST["id_instrument"])) {
    $output = '
    <div class="table-responsive">
    <table class="table table-striped table-condensed">';
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $sql = "SELECT i.id_instrument       'Instrument ID',
                   if(i.enabled = 1, 'Yes', 'No') 'Enabled',
                   i.collation           'Sort order',
                   i.name                'Name',
                   i.family              'Family',
                   i.description         'Description'
            FROM   instruments i
            WHERE  i.id_instrument = '".$_POST["id_instrument"]."'";

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
