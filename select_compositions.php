<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select_compositions.php with id=". $_POST["catalog_number"]);
if (isset($_POST["catalog_number"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM compositions WHERE catalog_number = '".$_POST["catalog_number"]."'";
    error_log("Running SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><h4 class="text-primary">'.$rowList["catalog_number"].'</h4></td>
                <td><h4 class="text-info">'.$rowList["name"].'</h4></td>
            </tr>
            <tr>
                <td><label>Composer</label></td>
                <td>'.$rowList["composer"].'</td>
            </tr>
            <tr>
                <td><label>Arranger</label></td>
                <td>'.$rowList["arranger"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>
            <tr>
                <td><label>Publisher</label></td>
                <td>'.$rowList["publisher"].'</td>
            </tr>
            <tr>
                <td><label>Editor</label></td>
                <td>'.$rowList["editor"].'</td>
            </tr>
            <tr>
                <td><label>Grade</label></td>
                <td>'.$rowList["grade"].'</td>
            </tr>
            <tr>
                <td><label>Comments</label></td>
                <td>'.$rowList["comments"].'</td>
            </tr>
            <tr>
                <td><label>Listening link</label></td>
                <td>'.$rowList["listening_example_link"].'</td>
            <tr>
                <td><label>Genre</label></td>
                <td>'.$rowList["genre"].'</td>
            </tr>
            <tr>
                <td><label>Ensemble</label></td>
                <td>'.$rowList["ensemble"].'</td>
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