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
ferror_log(print_r($_POST, true));

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_recording"])) {
    ferror_log("with id=". $_POST["id_recording"]);
    $id_recording = mysqli_real_escape_string($f_link, $_POST['id_recording']);
//    $sql = "SELECT * FROM recordings WHERE id_recording = '".$id_recording."'";


    $sql = "SELECT
        r.id_recording       AS id_recording,
        r.id_concert         AS id_concert,
        c.catalog_number     AS catalog_number,
        c.name               AS composition_name,
        r.name               AS name,
        r.ensemble           AS ensemble,
        r.id_ensemble        AS id_ensemble,
        r.composer           AS composer,
        r.link               AS link,
        con.performance_date AS date,
        con.venue            AS venue,
        con.notes            AS concert_notes,
        r.enabled            AS enabled
    FROM recordings r
    LEFT JOIN compositions c ON r.catalog_number = c.catalog_number
    LEFT JOIN concerts con   ON r.id_concert = con.id_concert
    WHERE id_recording = $id_recording; ";

    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    ferror_log("JSON for $id_recording: " . json_encode($rowList));
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
        <div class="table-repsonsive" style="max-height: 750px; overflow-y: auto;">
                <table class="table table-hover tablesort tablesearch-table" id="cpdatatable">
                <caption class="title">Available recordings</caption>';
    echo '<thead class="thead-light" style="position: sticky; top: 0; z-index: 1;"><tr>
        <th style="width: 50px;"></th>
        <th data-tablesort-type="date">Date <i class="fa fa-sort" aria-hidden="true"></i></th>
        <th data-tablesort-type="string">Ensemble <i class="fa fa-sort" aria-hidden="true"></i></th>
        <th data-tablesort-type="string">Composition <i class="fa fa-sort" aria-hidden="true"></i></th>
        <th data-tablesort-type="string">Composer <i class="fa fa-sort" aria-hidden="true"></i></th>
        <th data-tablesort-type="string">Venue <i class="fa fa-sort" aria-hidden="true"></i></th>
        <th>Enabled</th>
      </tr></thead>
      <tbody>';

    $sql = "SELECT
        r.id_recording       AS id_recording,
        c.catalog_number     AS catalog_number,
        c.name               AS composition_name,
        r.name               AS name,
        r.ensemble           AS ensemble,
        r.id_ensemble        AS id_ensemble,
        r.composer           AS composer,
        r.link               AS link,
        con.performance_date AS date,
        con.venue            AS venue,
        con.notes            AS concert_notes,
        r.enabled            AS enabled
    FROM recordings r
    LEFT JOIN compositions c ON r.catalog_number = c.catalog_number
    LEFT JOIN concerts con   ON r.id_concert = con.id_concert
    ORDER BY con.performance_date DESC, r.id_recording; ";

    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));

    while ($rowList = mysqli_fetch_array($res)) {
        $id_recording     = $rowList["id_recording"];
        $catalog_number   = $rowList["catalog_number"];
        $composition_name = htmlspecialchars($rowList["composition_name"]);
        $name             = htmlspecialchars($rowList["name"]);
        $ensemble         = htmlspecialchars($rowList["ensemble"]);
        $id_ensemble      = $rowList["id_ensemble"];
        $composer         = htmlspecialchars($rowList["composer"]);
        $date             = $rowList["date"];
        $venue            = htmlspecialchars($rowList["venue"]);
        $notes            = nl2br(htmlspecialchars($rowList["concert_notes"]));
        $link             = htmlspecialchars($rowList["link"]);
        $enabled          = $rowList["enabled"] ? "Yes" : "No";

        $the_name = $name ; 
        if ( $composition_name == "" ) {
            $the_name = $the_name . "*";
        };

        echo '<tr data-id="'. $id_recording .'">
        <td><input type="radio" name="record_select" value="'.$id_recording.'" class="form-check-input select-radio"></td>
        <td><a href="#" class="view_data" name="view" id="view_'.$id_recording.'">'.$date.'</a></td>
        <td>'.$ensemble.'</td>
        <td><strong>'.$the_name.'</strong></td><!-- '.$composition_name.' -->
        <td>'.$composer.'</td>
        <td>'.$venue.'</td>
        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>
        </tr>';
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