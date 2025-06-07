<?php
require_once('config.php');
require_once('functions.php');
ferror_log("Running select_recordings.php with id=". $_POST["id_recording"]);
if (isset($_POST["id_recording"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM recordings WHERE id_recording = '".$_POST["id_recording"]."'";
    ferror_log("Running SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $link = $rowList["link"];
        $date = $rowList["date"];
        $output .= '
            <tr>
                <td><h4 class="text-primary">'.$rowList["id_recording"].'</h4></td>
                <td><h4 class="text-info">(' . $rowList["catalog_number"] . ') '.$rowList["name"].'</h4></td>
            </tr>
            <tr>
                <td><label>Play</label></td>
                <td><audio controls>
			<source src="'. ORGFILES . $date. '/'.$link . '">
                    Your browser does not support the audio element.
                    </audio></td>
            </tr>
            <tr>
                <td><label>Ensemble</label></td>
                <td>'.$rowList["ensemble"] .'</td>
            </tr>
            <tr>
                <td><label>File name</label></td>
                <td>'.$link.'</td>
            </tr>
            <tr>
                <td><label>Information</label></td>
                <td>'.$rowList["concert"] .'</td>
            </tr>
            <tr>
                <td><label>Composer</label></td>
                <td>'.$rowList["composer"] .'</td>
            </tr>
            <tr>
                <td><label>Arranger</label></td>
                <td>'.$rowList["arranger"] .'</td>
            </tr>
            <tr>
                <td><label>Date</label></td>
                <td>'.$rowList["date"] .'</td>
            </tr>
            <tr>
                <td><label>Venue</label></td>
                <td>'.$rowList["venue"] .'</td>
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
