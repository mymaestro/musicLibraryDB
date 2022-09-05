<?php  
 //fetch_ensembles.php
require_once('config.php');
require_once('functions.php');
ferror_log("Running fetch_ensemble.php");

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (isset($_POST["id_ensemble"])) $id_ensemble = mysqli_escape_string($f_link, $_POST["id_ensemble"]);

if(isset($id_ensemble)) {
    $sql = "SELECT * FROM ensembles WHERE id_ensemble = '".$id_ensemble ."'";
    ferror_log("Running SQL: " . $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);  
    echo json_encode($rowList);
} else { // Show ensemble table
    echo '<div class="panel panel-default">
    <div class="table-repsonsive">
        <table class="table table-hover">
                <caption class="title">Available ensembles</caption>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
    $sql = "SELECT * FROM ensembles ORDER BY id_ensemble;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_ensemble = $rowList['id_ensemble'];
        $title = $rowList['name'];
        $description = $rowList['description'];
        $link = $rowList['link'];
        $enabled = $rowList['enabled'];
        echo '<tr>
                    <td>'.$id_ensemble.'<input type="hidden" name="id_ensemble[]" value="'. $id_ensemble .'"></td>
                    <td>'.$title.'</td>
                    <td>'.$description.'</td>
                    <td>'.$link.'</td>
                    <td><div class="form-check form-switch">
                    <input class="form-check-input" name="enabled[]" type="checkbox" role="switch" id="typeEnabled" '. (($u_librarian) ? "" : "disabled ") . (($enabled == 1) ? "checked" : "") .'>
                    </div></td>';
        if ($u_librarian) { echo '
                    <td><input type="button" name="delete" value="Delete" id="'.$id_ensemble.'" class="btn btn-danger btn-sm delete_data" /></td>
                    <td><input type="button" name="edit" value="Edit" id="'.$id_ensemble.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
        echo '
                    <td><input type="button" name="view" value="View" id="'.$id_ensemble.'" class="btn btn-secondary btn-sm view_data" /></td>
                </tr>
                ';
    }
    echo '
                </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- class panel -->
       ';
    mysqli_close($f_link);
    // ferror_log("returned: " . $sql);
}
?>
