<?php  
 //fetch_playgrams.php
require_once('config.php');
require_once('functions.php');
ferror_log("Running fetch_playgrams.php");

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_playgram"])) {
    ferror_log("with id=". $_POST["id_playgram"]);
    $sql = "SELECT * FROM playgrams WHERE id_playgram = '".$_POST["id_playgram"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    $output = json_encode($rowList);
    ferror_log("JSON: " . $output);
    echo $output;
} else {
    echo '            <div class="panel panel-default">
        <form id="actionForm" method="post" action="handle_action.php">
           <div class="table-repsonsive">
                <table class="table table-hover">
                <caption class="title">Available program play lists (playgrams)</caption>
                <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
    $sql = "SELECT * FROM playgrams;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_playgram = $rowList['id_playgram'];
        $name = $rowList['name'];
        $description = $rowList['description'];
        $enabled = $rowList['enabled'];
        echo '<tr>
                    <td><input type="radio" name="selected_id" value="'.$id_playgram.'" class="form-check-input select-radio"></td>
                    <td id="'.$id_playgram.'" ><a href="#" class="view_data" name="view">'.$name.'</a></td>
                    <td>'.$description.'</td>
                    <td>'. (($enabled == 1) ? "Yes": "No" ). '</td>
                </tr>';
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
