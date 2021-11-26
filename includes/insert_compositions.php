<?php
 //insert_compositions.php
define('PAGE_TITLE', 'Insert compositions');
define('PAGE_NAME', 'Insert compositions');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_compositions.php with catalog_number=". $_POST["catalog_number"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST catalog_number=".$_POST["catalog_number"]);
    ferror_log("POST catalog_number_hold=".$_POST["catalog_number_hold"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);

    ferror_log("POST composer=".$_POST["composer"]);
    ferror_log("POST arranger=".$_POST["arranger"]);
    ferror_log("POST editor=".$_POST["editor"]);
    ferror_log("POST publisher=".$_POST["publisher"]);
    ferror_log("POST genre=".$_POST["genre"]);
    ferror_log("POST ensemble=".$_POST["ensemble"]);
    ferror_log("POST grade=".$_POST["grade"]);
    ferror_log("POST last_performance_date=".$_POST["last_performance_date"]);
    ferror_log("POST duration_start=".$_POST["duration_start"]);
    ferror_log("POST duration_end=".$_POST["duration_end"]);
    ferror_log("POST comments=".$_POST["comments"]);
    ferror_log("POST performance_notes=".$_POST["performance_notes"]);
    ferror_log("POST storage_location=".$_POST["storage_location"]);
    ferror_log("POST date_acquired=".$_POST["date_acquired"]);
    ferror_log("POST cost=".$_POST["cost"]);
    ferror_log("POST listening_example_link=".$_POST["listening_example_link"]);
    ferror_log("POST windrep_link=".$_POST["windrep_link"]);
    ferror_log("POST image_path=".$_POST["image_path"]);
    ferror_log("POST checked_out=".$_POST["checked_out"]);
    ferror_log("POST paper_size=".$_POST["paper_size"]);
    ferror_log("POST last_inventory_date=".$_POST["last_inventory_date"]);

    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $composer = mysqli_real_escape_string($f_link, $_POST['composer']);
    $arranger = mysqli_real_escape_string($f_link, $_POST['arranger']);
    $editor = mysqli_real_escape_string($f_link, $_POST['editor']);
    $publisher = mysqli_real_escape_string($f_link, $_POST['publisher']);
    $genre = mysqli_real_escape_string($f_link, $_POST['genre']);
    $ensemble = mysqli_real_escape_string($f_link, $_POST['ensemble']);
    $comments = mysqli_real_escape_string($f_link, $_POST['comments']);
    $performance_notes = mysqli_real_escape_string($f_link, $_POST['performance_notes']);
    $storage_location = mysqli_real_escape_string($f_link, $_POST['storage_location']);
    $listening_example_link = mysqli_real_escape_string($f_link, $_POST['listening_example_link']);
    $image_path = mysqli_real_escape_string($f_link, $_POST['image_path']);
    $checked_out = mysqli_real_escape_string($f_link, $_POST['checked_out']);
    $paper_size = mysqli_real_escape_string($f_link, $_POST['paper_size']);

    // Special handling for numbers and dates and columns that can be NULL
    $grade = mysqli_real_escape_string($f_link, $_POST['grade']);
    if (empty($grade)) {
        $grade = "NULL";
    } else {
        $grade = "'" . $grade . "'";
    }

    $last_performance_date = mysqli_real_escape_string($f_link, $_POST['last_performance_date']);
    if (empty($last_performance_date)) {
        $last_performance_date = "NULL";
    } else {
        $last_performance_date = "'" . $last_performance_date . "'";
    }

    $duration_start = mysqli_real_escape_string($f_link, $_POST['duration_start']);
    if (empty($duration_start)) {
        $duration_start = "NULL";
    } else {
        $duration_start = "'" . $duration_start . "'";
    }
    
    $duration_end = mysqli_real_escape_string($f_link, $_POST['duration_end']);
    if (empty($duration_end)) {
        $duration_end = "NULL";
    } else {
        $duration_end = "'" . $duration_end . "'";
    }

    $date_acquired = mysqli_real_escape_string($f_link, $_POST['date_acquired']);
    if (empty($date_acquired)) {
        $date_acquired = "NULL";
    } else {
        $date_acquired = "'" . $date_acquired . "'";
    }

    $cost = mysqli_real_escape_string($f_link, $_POST['cost']);
    if (empty($cost)) {
        $cost = "NULL";
    }

    $last_inventory_date = mysqli_real_escape_string($f_link, $_POST['last_inventory_date']);
    if (empty($last_inventory_date)) {
        $last_inventory_date = "NULL";
    } else {
        $last_inventory_date = "'" . $last_inventory_date . "'";
    }

    $windrep_link = mysqli_real_escape_string($f_link, $_POST['windrep_link']);
    if (empty($windrep_link)) {
        $windrep_link = "NULL";
    } else {
        $windrep_link = "'" . $windrep_link . "'";
    }

    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE compositions 
        SET catalog_number='$catalog_number',
        name ='$name',
        description = '$description',
        composer = '$composer',
        arranger = '$arranger',
        editor = '$editor',
        publisher = '$publisher',
        genre = '$genre',
        ensemble = '$ensemble', 
        grade = $grade,
        last_performance_date = $last_performance_date,
        duration_start = $duration_start,
        duration_end = $duration_end,
        comments = '$comments',
        performance_notes = '$performance_notes',
        storage_location = '$storage_location',
        date_acquired = $date_acquired,
        cost = $cost,
        listening_example_link = '$listening_example_link',
        checked_out = '$checked_out',
        paper_size = '$paper_size',
        last_inventory_date = $last_inventory_date,
        image_path = '$image_path',
        windrep_link = $windrep_link,
        enabled = $enabled
        WHERE catalog_number='".$_POST["catalog_number_hold"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO compositions(catalog_number, name, description, composer, arranger, editor, publisher, genre, ensemble, grade, last_performance_date, duration_start, duration_end, comments, performance_notes, storage_location, date_acquired, cost, listening_example_link, checked_out, paper_size, image_path, windrep_link, last_inventory_date, enabled)
        VALUES('$catalog_number', '$name', '$description', '$composer', '$arranger', '$editor', '$publisher', '$genre', '$ensemble', $grade, $last_performance_date, $duration_start, $duration_end, '$comments', '$performance_notes', '$storage_location', $date_acquired, $cost, '$listening_example_link', '$checked_out', '$paper_size', '$image_path', '$winrep_link', $last_inventory_date, $enabled);
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
    require_once("includes/header.php");
    echo '<body>
';
    require_once("includes/navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You should not be here.</p></div>';
    require_once("includes/footer.php");
    echo '</body>';
 }
 ?>