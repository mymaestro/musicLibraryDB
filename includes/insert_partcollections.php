<?php
 //insert_partcollections.php
define('PAGE_TITLE', 'Insert part collections');
define('PAGE_NAME', 'Insert part collections');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("RUNNING insert_partcollections.php with catalog_number_key=". $_POST["catalog_number_key"]);
    ferror_log("POST id_part_type_key=".$_POST["id_part_type_key"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    $catalog_number_key = mysqli_real_escape_string($f_link, $_POST['catalog_number_key']);
    $id_part_type_key = mysqli_real_escape_string($f_link, $_POST['id_part_type_key']);

    // Special handling for numbers and dates and columns that can be NULL
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    ferror_log("Name set to =" . $name);
    if (empty($name)) {
        $name = "NULL";
    } else {
        $name = "'" . $name . "'";
    }
    ferror_log("Now name is ". $name);
    
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    if (empty($description)) {
        $description = "NULL";
    } else {
        $description = "'" . $description . "'";
    }

    if($_POST["update"] == "update") {
        $sql = "UPDATE part_collections
        SET   catalog_number_key = '$catalog_number_key',
              id_part_type_key = '$id_part_type_key',
              id_part_type = '$id_part_type',
              name =$name,
              description = $description
        WHERE catalog_number_key='".$catalog_number_key."'
        AND   id_part_type_key='".$id_part_type_key."'
        AND   id_part_type = '".$id_part_type."';";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        if(!empty($_POST["id_part_type"])) {
            foreach($_POST['id_part_type'] as $id_part_type_num) {
                $id_part_type = mysqli_real_escape_string($f_link, $id_part_type_num);
                ferror_log("Adding id_part_type=".$id_part_type);
                $sql = "
                INSERT INTO part_collections(catalog_number_key, id_part_type_key, id_part_type, name, description)
                VALUES('$catalog_number_key', '$id_part_type_key', '$id_part_type', $name, $description);
                ";
                $message = 'Data Inserted';
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
            } // end loop
        } // id_part_type empty
    } // update button = add

 } else { // $POST is empty
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Part collections menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
