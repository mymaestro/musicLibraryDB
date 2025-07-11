<?php  
 //enable_list.php
 //Multi-row set Enabled flag
require_once('includes/config.php');
require_once('includes/functions.php');
ferror_log("Running enable_list.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$output = '';
$message = '';
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    $table_name = $_POST["table_name"];
    $table_key_name = $_POST["table_key_name"];
    $table_key = $_POST["table_key"];

    ferror_log("table=". $table_name );
    ferror_log("table key=". $table_key);
    ferror_log("table key name=". $table_key_name);
    $referred = $_SERVER['HTTP_REFERER'];
    if($_POST["table_name"] != '') {
        $sql = "
        DELETE FROM " . $table_name . " 
        WHERE ".$table_key_name . " = '".$table_key."'";
        if(mysqli_query($f_link, $sql)){
            $message = "$table_key deleted from $table_name";
            $output .= '<label class="text-success">' . $message . '</label>';
            $query = parse_url($referred, PHP_URL_QUERY);
            $referred = str_replace(array('?', $query), '', $referred);
            $output .= '<p><a href="'.$referred.'">Return</a></p>';
            echo $output;
            ferror_log("Delete SQL: " . $sql);
        } else {
            $message = "Delete failed";
            $error_message = mysqli_error($f_link);
            $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
               ';
            $output .= '<p><a href="'.$referred.'">Return</a></p>';
            echo $output;
            ferror_log("Command:" . $sql);
            ferror_log("Error: " . $error_message);
        }
    } else {
        $message = "Wrong table name";
        $created = date('Y-m-d H:i:s.u');
        $sql = "";
        ferror_log("Delete SQL (N/A): " . $sql);
        $message = 'No data deleted';
    }
    if ($u_librarian) :
        if(!empty($_POST)) {
            echo '<h4>You added the following parts:</h4>';
            if($_POST["submit"] == "add"){
                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
                $paper_size = mysqli_real_escape_string($f_link, $_POST['paper_size']);
                $page_count = mysqli_real_escape_string($f_link, $_POST['page_count']);
    
                // loop over checked checkboxes

                if(!empty($_POST['parttypes'])){
                    $output = '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Catalog number</th>
                            <th>Part type ID</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $originals_count = 1;
                    $copies_count = 0;
                    $name = "$username " . date("Y-m-d");
                    foreach($_POST['parttypes'] as $id_part_type_num) {
                        $id_part_type = mysqli_real_escape_string($f_link, $id_part_type_num);
                        $sql = "
                        INSERT INTO parts(catalog_number, id_part_type, name, paper_size, page_count, originals_count, copies_count)
                        VALUES('$catalog_number', '$id_part_type', '$name', '$paper_size', $page_count, $originals_count, $copies_count);
                        ";
                        $output .= '<tr><td>' . $catalog_number . '</td><td>' . $id_part_type .  '</td><td>';
                        $message = 'Data Inserted';
                        ferror_log("Running SQL ". $sql);
                        $referred = $_SERVER['HTTP_REFERER'];
                        if(mysqli_query($f_link, $sql)) {
                            $output .= '<span class="text-success">' . $message . '</span></td></tr>';
                            $query = parse_url($referred, PHP_URL_QUERY);
                            $referred = str_replace(array('?', $query), '', $referred);
                        } else {
                            $message = "Failed";
                            $error_message = mysqli_error($f_link);
                            $output .= '<span class="text-danger">' . $message . '. Error: ' . $error_message . '</span></td></tr>';
                            ferror_log("Error: " . $error_message);
                        } // SQL complete
                    } // Loop parts
                    echo $output;
                    echo '</tbody></table>';
                    echo '<p><a href="'.$referred.'">Return</a></p>';
                } // Part types array is not empty
            } // Submit function was "add"
         }
        endif;

ferror_log($output);
//echo json_encode($message);
}
?>