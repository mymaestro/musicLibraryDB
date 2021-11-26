<?php
 //insert_parts.php
define('PAGE_TITLE', 'Insert parts');
define('PAGE_NAME', 'Insert parts');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    error_log("RUNNING insert_parts.php with id_part=". $_POST["catalog_number"] . ":" . $_POST["id_part_type"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("THIS IS A TEST +=================--+++");
    ferror_log("POST catalog_number=".$_POST["catalog_number"]);
    ferror_log("POST id_part_type=".$_POST["id_part_type"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    ferror_log("POST is_part_collection=".$_POST["is_part_collection"]);
    ferror_log("POST paper_size=".$_POST["paper_size"]);
    ferror_log("POST page_count=".$_POST["page_count"]);
    ferror_log("POST image_path=".$_POST["image_path"]);
    ferror_log("POST originals_count=".$_POST["originals_count"]);
    ferror_log("POST copies_count=".$_POST["copies_count"]);
    $catalog_number_hold = mysqli_real_escape_string($f_link, $_POST['catalog_number_hold']);
    $id_part_type_hold = mysqli_real_escape_string($f_link, $_POST['id_part_type_hold']);
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $id_part_type = mysqli_real_escape_string($f_link, $_POST['id_part_type']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    // Handle columns that can be NULL
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
    ferror_log("The REAL originals_count is ". $originals_count);
    ferror_log("The REAL copies_count is ". $copies_count);

    ferror_log("POST update=". $_POST["update"]);
    if($_POST["update"] == "update") {
        $sql = "
        UPDATE parts
        SET id_part_type = '$id_part_type',
        catalog_number = '$catalog_number',
        name ='$name',
        description = $description,
        is_part_collection = $is_part_collection,
        paper_size = $paper_size,
        page_count = $page_count,
        image_path = $image_path,
        originals_count = $originals_count,
        copies_count = $copies_count
        WHERE catalog_number = '".$catalog_number_hold."' AND id_part_type = ".$id_part_type_hold.";";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO parts(catalog_number, id_part_type, name, description, is_part_collection, paper_size, page_count, image_path, originals_count, copies_count)
        VALUES('$catalog_number', '$id_part_type', '$name', $description, $is_part_collection, $paper_size, $page_count, $image_path, $originals_count, $copies_count);
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
