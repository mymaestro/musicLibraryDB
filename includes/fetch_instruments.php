<?php
require_once('config.php');
require_once('functions.php');

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

ferror_log("RUNNING fetch_instruments_table.php");

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_instrument"])) {
    $sql = "SELECT * FROM instruments WHERE id_instrument = '".$_POST["id_instrument"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
} else { 
    echo '            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available part types</caption>
                    <thead>
                    <tr>
                        <th>Collation</th>
                        <th>Name</th>
                        <th>Family</th>
                        <th>Description</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
    $sql = "SELECT * FROM instruments ORDER BY collation;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_instrument = $rowList['id_instrument'];
        $collation = $rowList['collation'];
        $name = $rowList['name'];
        $family = $rowList['family'];
        $description = $rowList['description'];
        $enabled = $rowList['enabled'];
        echo '<tr id="'.$id_instrument.'">
                    <td><a name="'.$id_instrument.'">'.$collation.'</a></td>
                    <td>'.$name.'</td>
                    <td>'.$family.'</td>
                    <td>'.$description.'</td>
                    <td><div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                    </div></td>';
        if ($u_librarian) { echo '
                    <td><input type="button" name="delete" value="Delete" id="'.$id_instrument.'" class="btn btn-danger btn-sm delete_data" /></td>
                    <td><input type="button" name="edit" value="Edit" id="'.$id_instrument.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
        echo '
                    <td><input type="button" name="view" value="View" id="'.$id_instrument.'" class="btn btn-secondary btn-sm view_data" /></td>
                </tr>
                ';
    }
    echo '
                </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- class panel -->
        ';
  }
  mysqli_close($f_link);
?>