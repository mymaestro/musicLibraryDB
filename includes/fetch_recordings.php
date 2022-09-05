<?php  
 //fetch_recordings.php
require_once('config.php');
require_once('functions.php');

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

ferror_log("Running fetch_recordings.php");

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_recording"])) {
    ferror_log("with id=". $_POST["id_recording"]);
    $id_recording = mysqli_real_escape_string($f_link, $_POST['id_recording']);
    $sql = "SELECT * FROM recordings WHERE id_recording = '".$id_recording."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
} elseif(isset($_POST["catalog_number"])) {
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $sql = "SELECT catalog_number, composer, arranger FROM compositions WHERE catalog_number = '" . $catalog_number ."';";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
} else {
    echo '            <div class="panel panel-default">
        <div class="table-repsonsive-sm">
                <table class="table table-hover tablesort tablesearch-table" id="cpdatatable">
                <caption class="title">Available recordings</caption>
                <thead>
                <tr>
                    <th data-tablesort-type="string">Ensemble <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Catalog number <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Composer <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="date">Date <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">File name <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Concert <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Venue <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
    $sql = "SELECT * FROM recordings ORDER BY date DESC;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_recording = $rowList["id_recording"];
        $ensemble = $rowList["ensemble"];
        $catalog_number = $rowList["catalog_number"];
        $composer = $rowList["composer"];
        $date = $rowList["date"];
        $name = $rowList["name"];
        $link = $rowList["link"];
        $concert = $rowList["concert"];
        $venue = $rowList["venue"];
        $enabled = $rowList["enabled"];
        echo '<tr>
                <td>'. $ensemble . '</td>
                <td>'. $catalog_number . '</td>
                <td>'. $name . '</td>
                <td>'. $composer . '</td>
                <td>'. $date . '</td>
                <td><a href="'. ORGFILES . $date . '/' . $link . '">'.$link.'</a></td>
                <td>'. $concert . '</td>
                <td>'. $venue . '</td>
                <td><div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                </div></td>';
        if ($u_librarian) { echo '
                    <td><input type="button" name="delete" value="Delete" id="'.$id_recording.'" class="btn btn-danger btn-sm delete_data" /></td>
                    <td><input type="button" name="edit" value="Edit" id="'.$id_recording.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
        echo '
                    <td><input type="button" name="view" value="View" id="'.$id_recording.'" class="btn btn-secondary btn-sm view_data" /></td>
                </tr>
                ';
    }
    echo '
                </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- class panel -->
       ';
    ferror_log("returned: " . $sql);
}
mysqli_close($f_link);
?>
