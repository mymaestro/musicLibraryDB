<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select_users.php with id_users=". $_POST["id_users"]);
if (isset($_POST["id_users"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM users WHERE id_users = '".$_POST["id_users"]."'";
    ferror_log("Running SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td><h4 class="text-primary">'.$rowList["id_users"].'</h4></td>
                <td><h4 class="text-info">'.$rowList["username"].'</h4></td>
            </tr>
            <tr>
                <td><label>Name</label></td>
                <td>'.$rowList["name"].'</td>
            </tr>
            <tr>
                <td><label>Address</label></td>
                <td>'.$rowList["address"].'</td>
            </tr>
            <tr>
                <td><label>Roles</label></td>
                <td>'.$rowList["roles"].'</td>
            </tr>';
    }
    $output .= '
        </table>
    </div>
    ';
    echo $output;
}
?>