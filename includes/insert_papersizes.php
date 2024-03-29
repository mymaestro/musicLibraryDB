<?php
 //insert_papersizes.php
 define('PAGE_TITLE', 'Insert papersizes');
 define('PAGE_NAME', 'Insert papersizes');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_papersizes.php with id_paper_size=". $_POST["id_paper_size"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_paper_size=".$_POST["id_paper_size"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST description=".$_POST["description"]);
    ferror_log("POST horizontal=".$_POST["horizontal"]);
    ferror_log("POST vertical=".$_POST["vertical"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);
    $id_paper_size = mysqli_real_escape_string($f_link, $_POST['id_paper_size']);
    $id_paper_size_hold = mysqli_real_escape_string($f_link, $_POST['id_paper_size_hold']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $horizontal = mysqli_real_escape_string($f_link, $_POST['horizontal']);
    $vertical = mysqli_real_escape_string($f_link, $_POST['vertical']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    ferror_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE paper_sizes 
        SET id_paper_size = '$id_paper_size',
        name ='$name',
        description = '$description',
        horizontal = '$horizontal',
        vertical = '$vertical',
        enabled = '$enabled'
        WHERE id_paper_size='".$id_paper_size_hold."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO paper_sizes(id_paper_size, name, description, horizontal, vertical, enabled)
        VALUES('$id_paper_size', '$name', '$description', $horizontal, $vertical, $enabled);
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
    <div><p align="center" class="text-danger">You can get here only from the Paper sizes menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
