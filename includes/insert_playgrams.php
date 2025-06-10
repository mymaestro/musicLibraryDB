<?php
 //insert_playgrams.php
define('PAGE_TITLE', 'Insert playgrams');
define('PAGE_NAME', 'Insert playgrams');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_playgrams.php with id_playgram=". $_POST["id_playgram"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_playgram=".$_POST["id_playgram"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $id_playgram = mysqli_real_escape_string($f_link, $_POST['id_playgram']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    ferror_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE playgrams 
        SET name ='$name',
        description = '$description',
        enabled = $enabled
        WHERE id_playgram='".$_POST["id_playgram"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO playgrams(name, description, enabled)
        VALUES('$name', '$description', $enabled);
        ";
        $message = 'Data Inserted';
    }
    ferror_log("Running SQL ". $sql);
    $referred = $_SERVER['HTTP_REFERER'];
    $referred .= "/#" . $id_playgram;
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
    <div><p align="center" class="text-danger">You can get here only from the playgrams menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
