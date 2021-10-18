<?php
 //insert_recordings.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING insert_recordings.php with id_recording=". $_POST["id_recording"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    error_log("POST id_recording=".$_POST["id_recording"]);
    error_log("POST name=".$_POST["name"]);
    error_log("POST description=".$_POST["description"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    error_log("POST enabled=".$enabled);
    $enabled = mysqli_real_escape_string($f_link, $enabled);
    $id_recording = mysqli_real_escape_string($f_link, $_POST['id_recording']);
    $id_recording_hold = mysqli_real_escape_string($f_link, $_POST['id_recording_hold']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE recordings 
        SET id_recording = '$id_recording',
        name ='$name',
        description = '$description',
        enabled = $enabled
        WHERE id_recording='".$_POST["id_recording_hold"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO recordings(id_recording, name, description, enabled)
        VALUES('$id_recording', '$name', '$description', $enabled);
        ";
        $message = 'Data Inserted';
    }
    error_log("Running SQL ". $sql);
    $referred = $_SERVER['HTTP_REFERER'];
    if(mysqli_query($f_link, $sql)) {
        $output .= '<label class="text-success">' . $message . '</label>';
        $query = parse_url($referred, PHP_URL_QUERY);
        $referred = str_replace(array('?', $query), '', $referred);
        echo '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
    } else {
        $message = "Failed";
        $error_message = mysqli_error($f_link);
        $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
           ';
        echo '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
        error_log("Error: " . $error_message);
    }
 }
 ?>