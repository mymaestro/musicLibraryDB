<?php  
 //delete_parts.php
 //
require_once('includes/config.php');
require_once('includes/functions.php');

ferror_log("Running delete_parts.php with id=". $_POST["catalog_number"] . ":" . $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
$id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);

if(isset($id_part_type) && (isset($catalog_number))) {
    $output = '';
    $message = '';
    $timestamp = time();
    $table_name = "parts";
    if($catalog_number != '') {
        $sql = "
        DELETE FROM " . $table_name . " 
        WHERE catalog_number = '" . $catalog_number . "' AND id_part_type = " . $id_part_type .";";
        $message = 'Data deleted';
        $referred = $_SERVER['HTTP_REFERER'];
        if(mysqli_query($f_link, $sql)) {
            $output .= '<label class="text-success">' . $message . '</label>';
            $query = parse_url($referred, PHP_URL_QUERY);
            $referred = str_replace(array('?', $query), '', $referred);
            echo '<p><a href="'.$referred.'">Return</a></p>';
            echo $output;
            ferror_log("output: ". $output);
        } else {
            $message = "Delete failed";
            $error_message = mysqli_error($f_link);
            $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
                   ';
            echo '<p><a href="'.$referred.'">Return</a></p>';
            echo $output;
            ferror_log("Error: " . $error_message);
            ferror_log("output: ". $output);
        }
    } else {
        $created = date('Y-m-d H:i:s.u');
        $sql = "";
        ferror_log("Delete SQL (N/A): " . $sql);
        $message = 'No data deleted';
        $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
          ';
        echo '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
        ferror_log("Error: " . $error_message);
    }
}
?>