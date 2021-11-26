<?php
 //insert_genres.php
define('PAGE_TITLE', 'Insert genres');
define('PAGE_NAME', 'Insert genres');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_genres.php with id_genre=". $_POST["id_genre"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_genre=".$_POST["id_genre"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $enabled = mysqli_real_escape_string($f_link, $enabled);
    $id_genre = mysqli_real_escape_string($f_link, $_POST['id_genre']);
    $id_genre_hold = mysqli_real_escape_string($f_link, $_POST['id_genre_hold']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE genres 
        SET id_genre = '$id_genre',
        name ='$name',
        description = '$description',
        enabled = $enabled
        WHERE id_genre='".$_POST["id_genre_hold"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO genres(id_genre, name, description, enabled)
        VALUES('$id_genre', '$name', '$description', $enabled);
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
    <div><p align="center" class="text-danger">You can get here only from the Genres menu.</p></div>';
    require_once("includes/footer.php");
    echo '</body>';
 }
 ?>
