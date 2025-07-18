<?php
/* insert_recordings.php
#############################################################################
# Licensed Materials - Property of ACWE*
# (C) Copyright Austin Civic Wind Ensemble, 2022, 2025 All rights reserved.
#############################################################################
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('PAGE_TITLE', 'Insert recordings');
define('PAGE_NAME', 'Insert recordings');
require_once('config.php');
require_once('functions.php');

// Settings
$maxFileSize = 40 * 1024 * 1024; // 40 MB
// You might need to adjust these settings in your php.ini file as well
//ini_set('upload_max_filesize', '40M');
//ini_set('post_max_size', '40M');

$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');

// Check if the getID3 library is available
if (!file_exists('../getID3/getid3/getid3.php') || !file_exists('../getID3/getid3/write.php')) {
    ferror_log("getID3 library not found at: ".__DIR__ . "../getID3/getid3/getid3.php");
    die("getID3 library not found. Please ensure it is installed in the correct path.");
} else {
    ferror_log("getID3 library found at: ../getID3/getid3/getid3.php");
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    ferror_log("RUNNING insert_recordings.php with id_recording=". $_POST["id_recording"]);
    ferror_log("POST data: " . print_r($_POST, true));
    ferror_log("FILES data: " . print_r($_FILES, true));
    $output = '';
    $message = '';
    $timestamp = time();
    // Validate input, ensure required fields are set
    // Columns in the recordings table
    $id_recording = mysqli_real_escape_string($f_link, $_POST['id_recording']);
    $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
    $id_concert = mysqli_real_escape_string($f_link, $_POST['concert']);
    $id_ensemble = mysqli_real_escape_string($f_link, $_POST['id_ensemble']);
    $name = mysqli_real_escape_string($f_link, $_POST['name']);
    $ensemble = mysqli_real_escape_string($f_link, $_POST['ensemble']);
    $notes = mysqli_real_escape_string($f_link, $_POST['notes']);
    $composer = mysqli_real_escape_string($f_link, $_POST['composer']);
    $arranger = mysqli_real_escape_string($f_link, $_POST['arranger']);
    $venue = mysqli_real_escape_string($f_link, $_POST['venue']);
    $enabled = ((isset($_POST["enabled"])) ? 1 : 0);
    $enabled = mysqli_real_escape_string($f_link, $enabled);
    // Other important data
    $filedate = mysqli_real_escape_string($f_link, $_POST['filedate']);

    // Handle file upload
    $link = mysqli_real_escape_string($f_link, $_POST['linkDisplay']);

    if (isset($_FILES['link']) && $_FILES['link']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['link']['tmp_name'];
        $fileName = $_FILES['link']['name'];
        $fileSize = $_FILES['link']['size'];
        $fileType = $_FILES['link']['type'];

        require_once('../getID3/getid3/getid3.php');
        require_once('../getID3/getid3/write.php');
        
        $uploadDir = __DIR__ . "/" . ORGPUBLIC . $filedate . '/'; // Directory to save uploaded files
        // Example: www/public/recordings/2023-10-01/
        // Create the uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true) && ferror_log("Uploads directory created: " . $uploadDir);
        } else {
            ferror_log("Uploads directory already exists: " . $uploadDir);  
        }

        // Check file size
        if ($fileSize > $maxFileSize) {
            die("File is too large. Max allowed size is 20MB.");
        }

        // Check MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($fileTmpPath);
        $allowedMimes = [
            'audio/mpeg' => 'mp3',
            'audio/wav'  => 'wav',
            'audio/flac' => 'flac',
            'audio/x-flac' => 'flac', // Some systems use this
            'audio/ogg'  => 'ogg'
        ];
        if (!array_key_exists($mime, $allowedMimes)) {
            die("Only MP3, WAV, FLAC, and OGG audio files are allowed. Detected: $mime");
        }

        // Generate a safe file name with the correct extension
        $extension = $allowedMimes[$mime];
        $safeName = uniqid('audio_', true) . '.' . $extension;
        $destination = $uploadDir . $fileName; // Use original file name for simplicity

        // Move the uploaded file
        ferror_log("Attempting to move uploaded file from: " . $fileTmpPath . " to: " . $destination);
        if (!move_uploaded_file($fileTmpPath, $destination)) {
            die("Failed to save the uploaded file.");
        }

        // Analyze and save metadata as JSON
        $audio = new getID3();
        $tagwriter = new getid3_writetags();
        // Set up the tag writer
        $tagwriter->filename = $destination;
        $tagwriter->tagformats = ['id3v2.3', 'id3v2.4', 'id3v1'];
        $tagwriter->overwrite_tags = true;
        $tagwriter->remove_other_tags = false;
        $tagwriter->tag_encoding = 'UTF-8';
        // Set the tags to write from the form data

        $tagData = array(
            'title'   => array($name),
            'artist'  => array($composer),
            'album'   => array($ensemble),
            'year'    => array(substr($filedate, 0, 4)),
            'comment' => array($notes),
            'genre'   => array('Classical'),
        );
        $tagwriter->tag_data = $tagData;

        // Write the tags
        if ($tagwriter->WriteTags()) {
            ferror_log('Successfully wrote tags');
        } else {
            ferror_log('Failed to write tags: '.implode(', ', $tagwriter->errors));
        }

        $info = $audio->analyze($destination);
        if (isset($info['error'])) {
            die("Error analyzing audio file: " . implode(', ', $info['error']));
        }

        $metaFile = $uploadDir . 'meta_' . $safeName . '.json';
        file_put_contents($metaFile, json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo "Audio file uploaded and metadata saved.<br>";
        echo "File: " . htmlspecialchars(basename($safeName)) . "<br>";
        echo "Metadata: " . htmlspecialchars(basename($metaFile));

        ferror_log("Audio file uploaded and metadata saved.");
        ferror_log("File: " . htmlspecialchars(basename($safeName)));
        ferror_log("Metadata: " . htmlspecialchars(basename($metaFile)));

    } elseif ($_POST["update"] == "update") {
        // If updating, keep the existing link
        ferror_log("No new file uploaded, keeping existing link: " . $link);
    } else {
        die("No file uploaded or an error occurred.");
    }
    if($_POST["update"] == "update") {
        $sql = "
        UPDATE recordings 
        SET catalog_number = '$catalog_number',
        id_concert = '$id_concert',
        name ='$name',
        ensemble = '$ensemble',
        id_ensemble = '$id_ensemble',
        link = '$link',
        notes = '$notes',
        composer = '$composer',
        arranger = '$arranger',
        enabled = $enabled
        WHERE id_recording='".$_POST["id_recording"]."'";
        $message = 'Data Updated';
    } elseif($_POST["update"] == "add") {
        $sql = "
        INSERT INTO recordings(catalog_number, id_concert, name, ensemble, id_ensemble, link, notes, composer, arranger, enabled)
        VALUES('$catalog_number', $id_concert, '$name', '$ensemble', '$id_ensemble', '$link', '$notes', '$composer', '$arranger', $enabled);
        ";
        $message = 'Data Inserted';
    }
    ferror_log("Running SQL ". $sql);
    $referred = $_SERVER['HTTP_REFERER'];

    header('Content-Type: application/json');
    if(mysqli_query($f_link, $sql)) {
        ferror_log("SQL executed successfully: " . $sql);
        echo json_encode([
            'success' => true,
            'message' => $message,
        ]);
    } else {
        ferror_log("SQL execution failed: " . mysqli_error($f_link));
        echo json_encode([
            'success' => false,
            'message' => 'Failed with error: ' . mysqli_error($f_link),
        ]);
    }
    mysqli_close($f_link);
 } else {
    require_once("header.php");
    echo '<body>
';
    require_once("navbar.php");
    echo '
    <div class="container">
    <h2 align="center">'. ORGNAME . ' ' . PAGE_NAME . '</h2>
    <div><p align="center" class="text-danger">You can get here only from the Recordings menu.</p></div>';
    require_once("footer.php");
    echo '</body>';
 }
 ?>
