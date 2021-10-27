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
    ferror_log("POST id_recording=".$_POST["id_recording"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST date=".$_POST["date"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $enabled = mysqli_real_escape_string($f_link, $enabled);
    $id_recording = mysqli_real_escape_string($f_link, $_POST['id_recording']);
    $id_recording_hold = mysqli_real_escape_string($f_link, $_POST['id_recording_hold']);
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $date = mysqli_real_escape_string($f_link, $_POST['date']);
    $ensemble = mysqli_real_escape_string($f_link, $_POST['ensemble']);
    $link = mysqli_real_escape_string($f_link, $_POST['link']);
    $concert = mysqli_real_escape_string($f_link, $_POST['concert']);
    $venue = mysqli_real_escape_string($f_link, $_POST['venue']);
    $composer = mysqli_real_escape_string($f_link, $_POST['composer']);
    $arranger = mysqli_real_escape_string($f_link, $_POST['arranger']);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE recordings 
        SET catalog_number = '$catalog_number',
        name ='$name',
        date = '$date',
        ensemble = '$ensemble',
        link = '$link',
        concert = '$concert',
        venue = '$venue',
        composer = '$composer',
        arranger = '$arranger',
        enabled = $enabled
        WHERE id_recording='".$_POST["id_recording_hold"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO recordings(name, catalog_number, date, ensemble, link, concert, venue, composer, arranger, enabled)
        VALUES('$name', '$catalog_number', '$date', '$ensemble', '$link', '$concert', '$venue', '$composer', '$arranger', $enabled);
        ";
        $message = 'Data Inserted';
    }
    ferror_log("Running SQL ". $sql);
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
        ferror_log("Error: " . $error_message);
    }
 }
 ?>