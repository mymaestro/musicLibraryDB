<?php
 //insert_compositions.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING insert_compositions.php with catalog_number=". $_POST["catalog_number"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    error_log("POST catalog_number=".$_POST["catalog_number"]);
    error_log("POST catalog_number_hold=".$_POST["catalog_number_hold"]);
    error_log("POST name=".$_POST["name"]);
    error_log("POST description=".$_POST["description"]);

    error_log("POST composer=".$_POST["composer"]);
    error_log("POST arranger=".$_POST["arranger"]);
    error_log("POST editor=".$_POST["editor"]);
    error_log("POST publisher=".$_POST["publisher"]);
    error_log("POST genre=".$_POST["genre"]);
    error_log("POST ensemble=".$_POST["ensemble"]);
    error_log("POST grade=".$_POST["grade"]);
    error_log("POST last_performance_date=".$_POST["last_performance_date"]);
    error_log("POST duration_start=".$_POST["duration_start"]);
    error_log("POST duration_end=".$_POST["duration_end"]);
    error_log("POST comments=".$_POST["comments"]);
    error_log("POST performance_notes=".$_POST["performance_notes"]);
    error_log("POST storage_location=".$_POST["storage_location"]);
    error_log("POST date_acquired=".$_POST["date_acquired"]);
    error_log("POST cost=".$_POST["cost"]);
    error_log("POST listening_example_link=".$_POST["listening_example_link"]);
    error_log("POST windrep_link=".$_POST["windrep_link"]);
    error_log("POST image_path=".$_POST["image_path"]);
    error_log("POST checked_out=".$_POST["checked_out"]);
    error_log("POST paper_size=".$_POST["paper_size"]);
    error_log("POST last_inventory_date=".$_POST["last_inventory_date"]);
    
    

    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $composer = mysqli_real_escape_string($f_link, $_POST['composer']);
    $arranger = mysqli_real_escape_string($f_link, $_POST['arranger']);
    $editor = mysqli_real_escape_string($f_link, $_POST['editor']);
    $publisher = mysqli_real_escape_string($f_link, $_POST['publisher']);
    $genre = mysqli_real_escape_string($f_link, $_POST['genre']);
    $ensemble = mysqli_real_escape_string($f_link, $_POST['ensemble']);
    $grade = mysqli_real_escape_string($f_link, $_POST['grade']);
    $last_performance_date = mysqli_real_escape_string($f_link, $_POST['last_performance_date']);
    $duration_start = mysqli_real_escape_string($f_link, $_POST['duration_start']);
    $duration_end = mysqli_real_escape_string($f_link, $_POST['duration_end']);
    $comments = mysqli_real_escape_string($f_link, $_POST['comments']);
    $performance_notes = mysqli_real_escape_string($f_link, $_POST['performance_notes']);
    $storage_location = mysqli_real_escape_string($f_link, $_POST['storage_location']);
    $date_acquired = mysqli_real_escape_string($f_link, $_POST['date_acquired']);
    $cost = mysqli_real_escape_string($f_link, $_POST['cost']);
    $listening_example_link = mysqli_real_escape_string($f_link, $_POST['listening_example_link']);
    $image_path = mysqli_real_escape_string($f_link, $_POST['image_path']);
    $windrep_link = mysqli_real_escape_string($f_link, $_POST['windrep_link']);
    $checked_out = mysqli_real_escape_string($f_link, $_POST['checked_out']);
    $paper_size = mysqli_real_escape_string($f_link, $_POST['paper_size']);
    $last_inventory_date = mysqli_real_escape_string($f_link, $_POST['last_inventory_date']);

    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    error_log("POST enabled=".$enabled);
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
        last_performance_date = '$last_performance_date',
        duration_start = '$duration_start',
        duration_end = '$duration_end',
        comments = '$comments',
        performance_notes = '$performance_notes',
        storage_location = '$storage_location',
        date_acquired = '$date_acquired',
        cost = '$cost',
        listening_example_link = '$listening_example_link',
        checked_out = '$checked_out',
        paper_size = '$paper_size',
        last_inventory_date = '$last_inventory_date',
        image_path = '$image_path',
        windrep_link = '$windrep_link',
        enabled = $enabled
        WHERE catalog_number='".$_POST["catalog_number_hold"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO compositions(catalog_number, name, description, composer, arranger, editor, publisher, genre, ensemble, grade, last_performance_date, duration_start, duration_end, comments, performance_notes, storage_location, date_acquired, cost, listening_example_link, checked_out, paper_size, image_path, windrep_link, last_inventory_date, enabled)
        VALUES('$catalog_number', '$name', '$description', '$composer', '$arranger', '$editor', '$publisher', '$genre', '$ensemble', $grade, '$last_performance_date', '$duration_start', '$duration_end', '$comments', '$performance_notes', '$storage_location', '$date_acquired', '$cost', '$listening_example_link', '$checked_out', '$paper_size', '$image_path', '$winrep_link', '$last_inventory_date', $enabled);
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