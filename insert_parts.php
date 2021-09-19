<?php
 //insert_parts.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING insert_parts.php with id_part=". $_POST["id_part"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    error_log("POST id_part=".$_POST["id_part"]);
    error_log("POST catalog_number=".$_POST["catalog_number"]);
    error_log("POST name=".$_POST["name"]);
    error_log("POST description=".$_POST["description"]);
    $id_part = mysqli_real_escape_string($f_link, $_POST['id_part']);
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $originals_count = mysqli_real_escape_string($f_link, $_POST['originals_count']);
    $copies_count = mysqli_real_escape_string($f_link, $_POST['copies_count']);
    $id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE parts
        SET id_part = $id_part,
        catalog_number = '$catalog_number',
        id_part_type = '$id_part_type',
        name ='$name',
        description = '$description',
        originals_count = '$originals_count',
        copies_count = '$copies_count',
        WHERE id_part='".$_POST["id_part"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO parts(id_part, catalog_number, name, description, originals_count, copies_count)
        VALUES($id_part, '$catalog_number', '$name', '$description', '$originals_count', '$copies_count');
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