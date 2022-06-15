<?php
 //insert_partcollections.php
define('PAGE_TITLE', 'Insert part collections');
define('PAGE_NAME', 'Insert part collections');
require_once('config.php');
require_once('functions.php');
ferror_log("Running insert_partcollections.php");
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("RUNNING insert_partcollections.php with catalog_number_key=". $_POST["catalog_number_key"]);
    ferror_log("POST id_part_type_key=".$_POST["id_part_type_key"]);
    ferror_log("POST id_part_type=".$_POST["id_part_type"]);
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
    // Update?
    if($_POST["update"] == "update") {
        $sql = "UPDATE part_collections
        SET   catalog_number_key = '$catalog_number_key',
              id_part_type_key = '$id_part_type_key',
              id_part_type = '$id_part_type',
              name =$name,
              description = $description,
              last_update = CURRENT_TIMESTAMP()
        WHERE catalog_number_key='".$catalog_number_key."'
        AND   id_part_type_key='".$id_part_type_key."'
        AND   id_part_type = '".$id_part_type."';";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        if(!empty($_POST["id_part_type"])) {
            ferror_log("Adding parts... ");
            foreach($_POST['id_part_type'] as $id_part_type_num) {
                $id_part_type = mysqli_real_escape_string($f_link, $id_part_type_num);
                ferror_log("Adding id_part_type = ".$id_part_type);
                $sql = "
                INSERT INTO part_collections(catalog_number_key, id_part_type_key, id_part_type, name, description, last_update)
                VALUES('$catalog_number_key', '$id_part_type_key', '$id_part_type', $name, $description, CURRENT_TIMESTAMP() );
                ";
                ferror_log("Running SQL ". $sql);
                if(mysqli_query($f_link, $sql)) {
                    echo '<p class="text-success">Inserted ' . $id_part_type . ' successfully.</p>';
                } else {
                    $error_message = mysqli_error($f_link);
                    echo '<p class="text-danger">Error inserting ' . $id_part_type . '. Error: ' . $error_message . '</p>
                       ';
                    ferror_log("Error: " . $error_message);
                }
            } 
            $referred = $_SERVER['HTTP_REFERER'];
            $query = parse_url($referred, PHP_URL_QUERY);
            $referred = str_replace(array('?', $query), '', $referred);
            echo '<p><a href="'.$referred.'">Return</a></p>';
            // end loop
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
