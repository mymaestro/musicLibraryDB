<?php  
 //fetch_parttypes.php
require_once('config.php');
require_once('functions.php');

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

ferror_log("Running fetch_parttypes.php");

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_part_type"])) {
    ferror_log("with id=". $_POST["id_part_type"]);
    $sql = "SELECT * FROM part_types WHERE id_part_type = '".$_POST["id_part_type"]."'";
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
                    <th>Part Collection</th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
    $sql = "SELECT * FROM part_types ORDER BY collation;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_part_type = $rowList['id_part_type'];
        $collation = $rowList['collation'];
        $name = $rowList['name'];
        $family = $rowList['family'];
        $description = $rowList['description'];
        $is_part_collection = $rowList['is_part_collection'];
        $enabled = $rowList['enabled'];
        echo '<tr>
                    <td>'.$collation.'</td>
                    <td>'.$name.'</td>
                    <td>'.$family.'</td>
                    <td>'.$description.'</td>
                    <td>'.$is_part_collection.'</td>
                    <td><div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                    </div></td>';
        if ($u_librarian) { echo '
                    <td><input type="button" name="delete" value="Delete" id="'.$id_part_type.'" class="btn btn-danger btn-sm delete_data" /></td>
                    <td><input type="button" name="edit" value="Edit" id="'.$id_part_type.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
        echo '
                    <td><input type="button" name="view" value="View" id="'.$id_part_type.'" class="btn btn-secondary btn-sm view_data" /></td>
                </tr>
                ';
    }
    echo '
                </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- panel -->
       ';
}
mysqli_close($f_link);
?>
