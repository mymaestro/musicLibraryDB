<?php
 //insert_papersizes.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("RUNNING insert_papersizes.php with id_paper_size=". $_POST["id_paper_size"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $timestamp = time();
    error_log("POST id_paper_size=".$_POST["id_paper_size"]);
    error_log("POST name=".$_POST["name"]);
    error_log("POST description=".$_POST["description"]);
    error_log("POST horizontal=".$_POST["horizontal"]);
    error_log("POST vertical=".$_POST["vertical"]);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    error_log("POST enabled=".$enabled);
    $id_paper_size = mysqli_real_escape_string($f_link, $_POST['id_paper_size']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $horizontal = mysqli_real_escape_string($f_link, $_POST['horizontal']);
    $vertical = mysqli_real_escape_string($f_link, $_POST['vertical']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    error_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE paper_sizes 
        SET name ='$name',
        description = '$description',
        horizontal = '$horizontal',
        vertical = '$vertical',
        enabled = '$enabled'
        WHERE id_paper_size='".$_POST["id_paper_size"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO paper_sizes(id_paper_size, name, description, horizontal, vertical, enabled)
        VALUES('$id_paper_size', '$name', '$description', $horizontal, $vertical, $enabled);
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