<?php
 //insert_users.php
define('PAGE_TITLE', 'Insert users');
define('PAGE_NAME', 'Insert users');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    error_log("RUNNING insert_users.php with id_users=". $_POST["id_users"]);
    $output = '';
    $message = '';
    $timestamp = time();
    ferror_log("POST id_users=".$_POST["id_users"]);
    ferror_log("POST username=".$_POST["username"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST address=".$_POST["address"]);
    ferror_log("POST roles=".$_POST["roles"]);
        
    $id_users = mysqli_real_escape_string($f_link, $_POST['id_users']);
    $id_users_hold = mysqli_real_escape_string($f_link, $_POST['id_users_hold']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $username = mysqli_real_escape_string($f_link, $_POST['username']);
    $address = mysqli_real_escape_string($f_link, $_POST['address']);
    $roles = mysqli_real_escape_string($f_link, $_POST['roles']);
    
    if($_POST["update"] == "update") {
        $sql = "
        UPDATE users 
        SET id_users = '$id_users',
        name ='$name',
        username = '$username',
        address = '$address',
        roles = '$roles'
        WHERE id_users='".$_POST["id_users_hold"]."'";
        $message = "user $name updated";
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO users(id_users, name, username, address, roles)
        VALUES('$id_users','$name', '$username', '$address', '$roles');
        ";
        $message = "user $name inserted";
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
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You should not be here.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
