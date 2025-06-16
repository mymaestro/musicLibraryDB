<?php
require_once('config.php');
require_once('functions.php');
error_log("Running select_playgrams.php with id=". $_POST["id_playgram"]);
if (isset($_POST["id_playgram"])) {
    $output = '
    <div class="table-responsive">
    <table class="table table-striped table-condensed">';

    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $id_playgram = $_POST['id_playgram'];
/* $sql = "SELECT p.id_playgram            'Playgram ID',
                   p.name                   'Name',
                   if(p.enabled = 1, 'Yes', 'No') 'Enabled',
                   p.description            'Description'
            FROM   playgrams p
            WHERE  id_playgram = ".$_POST["id_playgram"] . ";"; */

    $sql = "SELECT
        p.id_playgram 'Playgram ID',
        p.name 'Name',
        p.description 'Description',
    GROUP_CONCAT(
        CONCAT(pi.comp_order, '. ', c.catalog_number, ' <em>', c.name, '</em> (', IFNULL(c.composer, 'Unknown'), ', ', SEC_TO_TIME(c.duration), ', Grade ', c.grade, ')')
        SEPARATOR '</br>'
    ) AS 'Compositions'
    FROM
        playgrams p
        JOIN playgram_items pi ON p.id_playgram = pi.id_playgram
        JOIN compositions c ON pi.catalog_number = c.catalog_number
    WHERE
        p.id_playgram = $id_playgram
    ORDER BY
        pi.comp_order;";

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

    $sql = "SELECT
    COUNT(*) AS Compositions,
    SEC_TO_TIME(SUM(c.duration)) 'Total duration'
    FROM
        playgram_items pi
    JOIN compositions c ON pi.catalog_number = c.catalog_number
    WHERE
    pi.id_playgram = $id_playgram ; ";
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
    };

    $output .= '
        </table>
    </div>
    ';
    echo $output;
}
?>
