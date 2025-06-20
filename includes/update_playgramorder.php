<?php
 //update_playgramorder.php
define('PAGE_TITLE', 'Update score order');
define('PAGE_NAME', 'Update score order');
require_once('config.php');
require_once('functions.php');
ferror_log(print_r($_POST, true));
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    $updated = 0;
    $timestamp = time();
    $newplaygramorder = $_POST['pg'];
    $collation = 1;
    $output = '<label class="text-success">';

    foreach ($newplaygramorder as $id_playgram_item) {
        $sql = "UPDATE playgram_items
                SET comp_order = " . $collation;
        $sql .= "
        WHERE id_playgram_item = " . $id_playgram_item . ";";
        $message = "Data updated.";
        ferror_log("Running SQL: ". $sql);
        if(mysqli_query($f_link, $sql) or die("Error: update query failed.")) {
            $updated++;
            $collation++;
        } else {
            $message = "Updating " . $id_playgram_item . " failed.";
            $output .= $message;
        }
    }
    $output .= $updated . ' record(s) updated.</label>';
    $referred = $_SERVER['HTTP_REFERER'];
    $query = parse_url($referred, PHP_URL_QUERY);
    $referred = str_replace(array('?', $query), '', $referred);
//    echo '<p><a href="'.$referred.'">Refresh</a></p>';
    echo '<p><a href="playgrams.php">Refresh</a></p>';
    echo $output;
 } else {
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Part types menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
