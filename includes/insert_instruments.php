<?php
 //insert_instruments.php
define('PAGE_TITLE', 'Insert instruments');
define('PAGE_NAME', 'Insert instruments');
require_once('config.php');
require_once('functions.php');
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_instruments.php with id_instrument=". $_POST["id_instrument"]);
    $output = '';
    $message = '';
    $timestamp = time();

    ferror_log("POST id_instrument=".$_POST["id_instrument"]);
    ferror_log("POST collation=".$_POST["collation"]);
    ferror_log("POST name=".$_POST["name"]);
    ferror_log("POST family=".$_POST["family"]);
    ferror_log("POST description=".$_POST["description"]);
    
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    ferror_log("POST enabled=".$enabled);

    $id_instrument = mysqli_real_escape_string($f_link, $_POST['id_instrument']);
    $collation = mysqli_real_escape_string($f_link, $_POST['collation']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $description = mysqli_real_escape_string($f_link, $_POST['description']);
    $family = mysqli_real_escape_string($f_link, $_POST['family']);
    $enabled = mysqli_real_escape_string($f_link, $enabled);

    ferror_log("POST update=".$_POST["update"]);

    if($_POST["update"] == "update") {
        $sql = "
        UPDATE instruments 
        SET name ='$name',
        description = '$description',
        collation = $collation,
        family = '$family',
        enabled = $enabled
        WHERE id_instrument='".$_POST["id_instrument"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO instruments(collation, name, description, family, enabled)
        VALUES($collation, '$name', '$description', '$family', $enabled);
        ";
        $message = 'Data Inserted';
    }
    ferror_log("Running SQL ". $sql);
    $referred = $_SERVER['HTTP_REFERER']; // http://musicLibraryDB.org/instruments.php
    $referred .= '/#' . $id_instrument;
    ferror_log("Referred: " . $referred);
    
    try {
        if(mysqli_query($f_link, $sql)) {
            $output .= '<label class="text-success">' . $message . '</label>';
            $query = parse_url($referred, PHP_URL_QUERY);
            $referred = str_replace(array('?', $query), '', $referred);
            
            // Echo the output for success display
            echo $output;
        }
    } catch (mysqli_sql_exception $e) {
        $message = "Failed";
        $error_message = $e->getMessage();
        $mysql_errno = $e->getCode();
        
        ferror_log("Error: " . $error_message . " (Error Code: " . $mysql_errno . ")");
        
        // Check for specific error types
        if ($mysql_errno == 1062) {
            $output .= '<p class="text-danger">Duplicate Entry Error: An instrument with this ID or name already exists. Please use a different ID or name.</p>';
        } else {
            $output .= '<p class="text-danger">' . $message . '. Error Code: ' . $mysql_errno . ' - Details: ' . htmlspecialchars($error_message) . '</p>';
        }
        
        // Echo the output for error display
        echo $output;
    }
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
