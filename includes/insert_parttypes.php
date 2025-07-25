<?php
 //insert_parttypes.php
define('PAGE_TITLE', 'Insert part types');
define('PAGE_NAME', 'Insert part types');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_parttypes.php with id_part_type=". $_POST["id_part_type"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_part_type=".$_POST["id_part_type"]);
    ferror_log("POST collation=".$_POST["collation"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST family=".$_POST["family"]);
    ferror_log("POST description=".$_POST["description"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    ferror_log("POST default_instrument=".$_POST["default_instrument"]);
    ferror_log("POST is_part_collection=".$_POST["is_part_collection"]);
    $is_part_collection =  mysqli_real_escape_string($f_link, $_POST["is_part_collection"]);
    if (empty($is_part_collection)) {
        $is_part_collection = "NULL";
    } else {
        $is_part_collection = "'" . $is_part_collection . "'";
    }
    $id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
    $collation = mysqli_real_escape_string($f_link, $_POST['collation']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $default_instrument = mysqli_real_escape_string($f_link, $_POST['default_instrument']);
    $family = mysqli_real_escape_string($f_link, $_POST['family']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    ferror_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE part_types 
        SET name ='$name',
        description = '$description',
        collation = $collation,
        family = '$family',
        default_instrument = '$default_instrument',
        is_part_collection = $is_part_collection,
        enabled = $enabled
        WHERE id_part_type='".$_POST["id_part_type"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO part_types(collation, name, description, family, default_instrument, is_part_collection, enabled)
        VALUES($collation, '$name', '$description', '$family', $default_instrument, $is_part_collection, $enabled);
        ";
        $message = 'Data Inserted';
    }
    ferror_log("Running SQL ". $sql);
    $referred = $_SERVER['HTTP_REFERER'];
    $referred .= "/#" . $id_part_type;
    if(mysqli_query($f_link, $sql)) {
        $output .= '<label class="text-success">' . $message . '</label>';
        $query = parse_url($referred, PHP_URL_QUERY);
        $referred = str_replace(array('?', $query), '', $referred);
    } else {
        $message = "Failed";
        $error_message = mysqli_error($f_link);
        $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
           ';
        ferror_log("Error: " . $error_message);
    }
 } else {
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Part types menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
