<?php  
 //delete_records.php
 // remodel to fit music library database
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running delete_records.php");
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

    error_log("table=". $table_name );
    error_log("table key=". $table_key);
    error_log("table key name=". $table_key_name);
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
            error_log("Delete SQL: " . $sql);
        } else {
            $message = "Delete failed";
            $error_message = mysqli_error($f_link);
            $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
               ';
            $output .= '<p><a href="'.$referred.'">Return</a></p>';
            echo $output;
            error_log("Command:" . $sql);
            error_log("Error: " . $error_message);
        }
    } else {
        $message = "Wrong table name";
        $created = date('Y-m-d H:i:s.u');
        $sql = "";
        error_log("Delete SQL (N/A): " . $sql);
        $message = 'No data deleted';
    }
error_log($output);
//echo json_encode($message);
}
?>