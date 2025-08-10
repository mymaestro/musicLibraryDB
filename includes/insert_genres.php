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
    
    try {
        if(mysqli_query($f_link, $sql)) {
            $output .= '<div class="alert alert-success">' . $message . '</div>';
            $query = parse_url($referred, PHP_URL_QUERY);
            $referred = str_replace(array('?', $query), '', $referred);
            
            // Include proper HTML structure for success message
            require_once("header.php");
            echo '<body>';
            require_once("navbar.php");
            echo '<div class="container mt-4">';
            echo '<h2 class="text-center">' . ORGNAME . ' ' . PAGE_NAME . '</h2>';
            echo $output;
            echo '<div class="text-center mt-3"><a href="'.$referred.'" class="btn btn-primary">Return</a></div>';
            echo '</div>';
            require_once("footer.php");
            echo '</body>';
        }
    } catch (mysqli_sql_exception $e) {
        $message = "Failed";
        $error_message = $e->getMessage();
        $mysql_errno = $e->getCode();
        
        ferror_log("Error: " . $error_message . " (Error Code: " . $mysql_errno . ")");
        
        // Include proper HTML structure for error message
        require_once("header.php");
        echo '<body>';
        require_once("navbar.php");
        echo '<div class="container mt-4">';
        echo '<h2 class="text-center">' . ORGNAME . ' ' . PAGE_NAME . '</h2>';
        
        // Check for specific error types
        if ($mysql_errno == 1062) {
            echo '<div class="alert alert-danger"><strong>Duplicate Entry Error:</strong> A genre with this ID or name already exists. Please use a different ID or name.</div>';
        } else {
            echo '<div class="alert alert-danger"><strong>' . $message . '</strong><br>Error Code: ' . $mysql_errno . '<br>Details: ' . htmlspecialchars($error_message) . '</div>';
        }
        
        echo '<div class="text-center mt-3"><a href="'.$referred.'" class="btn btn-primary">Return</a></div>';
        echo '</div>';
        require_once("footer.php");
        echo '</body>';
    }
 } else {
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Genres menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
