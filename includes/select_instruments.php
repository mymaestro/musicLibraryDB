<?php
require_once('config.php');
require_once('functions.php');
error_log("Running select_instruments.php with id=". $_POST["id_instrument"]);
if (isset($_POST["id_instrument"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM instruments WHERE id_instrument = '".$_POST["id_instrument"]."'";
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><label>Collation</label></td>
                <td>'.$rowList["collation"].'</td>
            </tr>
            <tr>
                <td><label>Name</label></td>
                <td>'.$rowList["name"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
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
