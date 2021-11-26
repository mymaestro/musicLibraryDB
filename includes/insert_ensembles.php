<?php
 //insert_ensembles.php
define('PAGE_TITLE', 'Insert ensembles');
define('PAGE_NAME', 'Insert ensembles');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    error_log("RUNNING insert_ensembles.php with id_ensemble=". $_POST["id_ensemble"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_ensemble=".$_POST["id_ensemble"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    ferror_log("POST link=".$_POST["link"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $id_ensemble = mysqli_real_escape_string($f_link, $_POST['id_ensemble']);
    $id_ensemble_hold = mysqli_real_escape_string($f_link, $_POST['id_ensemble_hold']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $link = mysqli_real_escape_string($f_link, $_POST['link']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE ensembles 
        SET id_ensemble = '$id_ensemble',
        name ='$name',
        description = '$description',
        link = '$link',
        enabled = '$enabled'
        WHERE id_ensemble='".$_POST["id_ensemble_hold"]."'";
        $message = "Ensemble $name updated";
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO ensembles(id_ensemble, name, description, link, enabled)
        VALUES('$id_ensemble','$name', '$description', '$link', $enabled);
        ";
        $message = "Ensemble $name inserted";
    }
    $referred = $_SERVER['HTTP_REFERER'];
    if(mysqli_query($f_link, $sql)) {
        $output .= '<label class="text-success">' . $message . '</label>';
        $query = parse_url($referred, PHP_URL_QUERY);
        $referred = str_replace(array('?', $query), '', $referred);
        $output .= '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
        ferror_log($output);
    } else {
        $message = "Failed";
        $error_message = mysqli_error($f_link);
        $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
           ';
        $output .= '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
        ferror_log($output);
        ferror_log("Command:" . $sql);
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
