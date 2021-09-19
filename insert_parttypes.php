<?php
 //insert_parttypes.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING insert_parttypes.php with id_part_type=". $_POST["id_part_type"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    // error_log("POST id_part_type=".$_POST["id_part_type"]);
    error_log("POST collation=".$_POST["collation"]);
    error_log("POST name=".$_POST["name"]);
    error_log("POST family=".$_POST["family"]);
    error_log("POST description=".$_POST["description"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    error_log("POST enabled=".$enabled);
    error_log("POST id_part_collection=".$_POST["id_part_collection"]);
    $id_part_collection = ((isset($_POST["id_part_collection"])) ? 1 : 0);
    error_log("POST id_part_collection=".$id_part_collection);
    $id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
    $collation = mysqli_real_escape_string($f_link, $_POST['collation']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $family = mysqli_real_escape_string($f_link, $_POST['family']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    error_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE part_types 
        SET name ='$name',
        description = '$description',
        collation = $collation,
        family = '$family',
        id_part_collection = $id_part_collection,
        enabled = $enabled
        WHERE id_part_type='".$_POST["id_part_type"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO part_types(collation, name, description, family, id_part_collection, enabled)
        VALUES($collation, '$name', '$description', '$family', $id_part_collection, $enabled);
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