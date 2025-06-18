<?php
 //insert_parts.php
define('PAGE_TITLE', 'Insert parts');
define('PAGE_NAME', 'Insert parts');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("------------------------------------------------");
    ferror_log("RUNNING insert_parts.php with id_part=". $_POST["catalog_number"] . ":" . $_POST["id_part_type"]);
    $output = '';
    $message = '';
    $timestamp = time();

    ferror_log(print_r($_POST, true));

    if (!empty($_POST['id_instrument'])) {
        ferror_log('POST id_instrument=*not_empty*');
    } else {
        ferror_log('POST id_instrument=*empty*');
    }

    $catalog_number_hold = mysqli_real_escape_string($f_link, $_POST['catalog_number_hold']);
    $id_part_type_hold = mysqli_real_escape_string($f_link, $_POST['id_part_type_hold']);
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);

    // Handle columns that can be NULL
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    if (empty($name)) {
        $name = "NULL";
    } else {
        $name = "'" . $name . "'";
    }
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    if (empty($description)) {
        $description = "NULL";
    } else {
        $description = "'" . $description . "'";
    }
    // Expecting a number or nothing
    $is_part_collection = mysqli_real_escape_string($f_link, $_POST['is_part_collection']);
    if (!is_numeric($is_part_collection)) {
        $is_part_collection = "NULL";
    }
    $paper_size = mysqli_real_escape_string($f_link, $_POST['paper_size']);
    if (empty($paper_size)) {
        $paper_size = "NULL";
    } else {
        $paper_size = "'" . $paper_size . "'";
    }
    $page_count = mysqli_real_escape_string($f_link, $_POST['page_count']);
    if (!is_numeric($page_count)) {
        $page_count = "NULL";
    }
    $image_path = mysqli_real_escape_string($f_link, $_POST['image_path']);
    if (empty($image_path)) {
        $image_path = "NULL";
    } else {
        $image_path = "'" . $image_path . "'";
    }
    $originals_count = mysqli_real_escape_string($f_link, $_POST['originals_count']);
    // Will cause the SQL to return "originals_count cannot be NULL" if nothing, or non-number entered
    if (!is_numeric($originals_count)) {
        $originals_count = "NULL";
    }
    // Will cause the SQL to return "copies_count cannot be NULL"
    $copies_count = mysqli_real_escape_string($f_link, $_POST['copies_count']);
    if (!is_numeric($copies_count)) {
        $copies_count = "NULL";
    }
    // Instruments on the part should be an array
    if (isset($_POST['id_instrument'])){
        if(!is_array($_POST['id_instrument'])){
            $id_instrument = mysqli_real_escape_string($f_link, $_POST['id_instrument']);
        } else {
            $id_instrument = $_POST['id_instrument'];
        }
    }
    ferror_log("The REAL originals_count is ". $originals_count);
    ferror_log("The REAL copies_count is ". $copies_count);

    ferror_log("POST update=". $_POST["update"]);
    if($_POST["update"] == "update") {
        $sql = "
        UPDATE parts
        SET id_part_type = '$id_part_type',
        catalog_number = '$catalog_number',
        name = $name,
        description = $description,
        is_part_collection = $is_part_collection,
        paper_size = $paper_size,
        page_count = $page_count,
        image_path = $image_path,
        originals_count = $originals_count,
        copies_count = $copies_count,
        last_update = CURRENT_TIMESTAMP()
        WHERE catalog_number = '".$catalog_number_hold."' AND id_part_type = ".$id_part_type_hold.";";
        ferror_log("Running SQL ". $sql);
        if(mysqli_query($f_link, $sql)) {
            $output = "Parts updated successfully.";
            ferror_log($output);
            // Clean out instruments for this part type
            $sql = "DELETE FROM part_collections 
            WHERE catalog_number_key = '".$catalog_number."'
            AND id_part_type_key = '".$id_part_type."';";
            ferror_log("Running SQL: ". $sql);
            if(mysqli_query($f_link, $sql)) {
                ferror_log("Part collection removed for ".$catalog_number." and ".$id_part_type.".");
            } else {
                $error_message =  mysqli_error($f_link);
                ferror_log("Part collection delete failed with error: ". $error_message);
            }
            // Add to part_collections table for each instrument in the part
            foreach($_POST['id_instrument'] as $id_instrument_num) {
                ferror_log("Adding instrument: ". $id_instrument_num . " to part_collections.");
                $id_instrument_key = mysqli_real_escape_string($f_link, $id_instrument_num);
                $sql = "INSERT INTO part_collections(
                    catalog_number_key,
                    id_part_type_key,
                    id_instrument_key,
                    name,
                    description,
                    last_update)
                VALUES('$catalog_number', $id_part_type, $id_instrument_key, $name, $description, CURRENT_TIMESTAMP() );";
                ferror_log("=-=-=-=-= Running SQL: ". $sql);
                if(mysqli_query($f_link, $sql)) {
                    ferror_log("Part collection added for ".$catalog_number." and part type = ".$id_part_type." and instrument = ".$id_instrument_key.".");
                } else {
                    $error_message =  mysqli_error($f_link);
                    ferror_log("Part collection add failed with error: ". $error_message);
                }
            }
        } else {
            $error_message = mysqli_error($f_link);
            $output = "Parts update failed with error = " . $error_message;
            ferror_log($output);
        }
    } elseif($_POST["update"] == "add") {
        ferror_log("Running SQL ". $sql);
        $sql = "
        INSERT INTO parts(catalog_number, id_part_type, name, description, is_part_collection, paper_size, page_count, image_path, originals_count, copies_count, last_update)
        VALUES('$catalog_number', '$id_part_type', '$name', $description, $is_part_collection, $paper_size, $page_count, $image_path, $originals_count, $copies_count, CURRENT_TIMESTAMP() );
        ";
        if(mysqli_query($f_link, $sql)) {
            $output = "Parts inserted successfully.";
            ferror_log($output);
        } else {
            $error_message = mysqli_error($f_link);
            $output = "Parts insert failed with error = " . $error_message;
            ferror_log($output);
        }
    }

 } else {
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Parts menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>