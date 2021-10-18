<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select_ensembles.php with id=". $_POST["id_ensemble"]);
if (isset($_POST["id_ensemble"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM ensembles WHERE id_ensemble = '".$_POST["id_ensemble"]."'";
    ferror_log("Running SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><h4 class="text-primary">'.$rowList["id_ensemble"].'</h4></td>
                <td><h4 class="text-info">'.$rowList["name"].'</h4></td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>';
        $enslink = $rowList["link"];
        if ($enslink != '') {
            $output .= '            <tr>
                <td><label>Link</label></td>
                <td>'.$rowList["link"].'</td>
            </tr>';
        }
        $output .= '            <tr>
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