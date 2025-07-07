<?php
define('PAGE_TITLE', 'Upload Recording');
define('PAGE_NAME','upload_recording');
require_once('config.php');
require_once('functions.php');

$uploadDir = __DIR__ . '/uploads/';
$maxFileSize = 20 * 1024 * 1024; // 20 MB

// Create the uploads directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// ORGFILES
require 'vendor/autoload.php';

// Settings
$uploadDir = __DIR__ . '/uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5 MB

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audioFile'])) {
    $file = $_FILES['audioFile'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload error code: " . $file['error']);
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    // Check MIME type, allow MP3, WAV, FlAC, and OGG
    $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/flac', 'audio/ogg'];
    if (!in_array($mime, $allowedMimes)) {
        die("Only MP3, WAV, FLAC, and OGG audio files are allowed.");
    }

    if ($file['size'] > $maxFileSize) {
        die("File is too large. Max allowed size is 20MB.");
    }

    $safeName = uniqid('doc_', true) . '.pdf';
    $destination = $uploadDir . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Failed to save the uploaded file.");
    }

    // Inject metadata
    $newFile = $uploadDir . 'meta_' . $safeName;
    $audio = new getID3();
    $audio->setOption(array('encoding' => 'UTF-8'));
    $audio->setOption(array('filename' => $destination));
    $info = $audio->analyze($destination);
    if (isset($info['error'])) {
        die("Error analyzing audio file: " . $info['error']);
    }

    // Save metadata to new file
    file_put_contents($newFile, json_encode($info));
    echo "Audio file uploaded and metadata added. Saved as: " . basename($newFile);
} else {
    echo "No file uploaded.";
}


// Add this .htaccess file to the uploads
//
// <FilesMatch "\.pdf$">
//   Order allow,deny
//   Deny from all
// </FilesMatch>
// 

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $file = $_FILES['pdfFile'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload error code: " . $file['error']);
    }

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if ($mime !== 'application/pdf') {
        die("Only PDF files are allowed.");
    }

    // Check file size
    if ($file['size'] > $maxFileSize) {
        die("File is too large. Max allowed size is 5MB.");
    }

    // Generate safe, unique file name
    $safeName = uniqid('doc_', true) . '.pdf';

    // Move file to upload directory
    $destination = $uploadDir . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Failed to save the uploaded file.");
    }

    echo "File uploaded successfully as: $safeName";
} else {
    echo "No file uploaded.";
}
?>
